<?php

namespace Magenest\CancelOrder\Controller\Index;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order\Status\HistoryFactory;
use Psr\Log\LoggerInterface;

class Config extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Data
     */
    protected $magenestHelperData;

    /**
     * @var \Magenest\CancelOrder\Model\CancelOrderFactory
     */
    protected $magenestOrderCancelFactory;
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;
    /**
     * @var HistoryFactory
     */
    protected $orderHistoryFactory;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var \Magento\Sales\Api\OrderManagementInterface
     */
    protected $orderManagement;
    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $_orderModel;
    /**
     * @param \Magento\Framework\App\Action\Context $ksContext
     * @param \Magenest\CancelOrder\Helper\Data $magenestHelperData
     * @param OrderRepositoryInterface $orderRepository
     * @param HistoryFactory $orderHistoryFactory
     * @param LoggerInterface $logger
     * @param \Magento\Sales\Api\OrderManagementInterface $orderManagement
     * @param \Magenest\CancelOrder\Model\CancelOrderFactory $magenestCancelOrderFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $ksContext,
        \Magenest\CancelOrder\Helper\Data $magenestHelperData,
        OrderRepositoryInterface $orderRepository,
        HistoryFactory $orderHistoryFactory,
        LoggerInterface $logger,
        \Magento\Sales\Api\OrderManagementInterface $orderManagement,
        \Magento\Sales\Model\Order $orderModel,
        \Magenest\CancelOrder\Model\CancelOrderFactory $magenestCancelOrderFactory
    ) {
        $this->magenestHelperData = $magenestHelperData;
        $this->magenestOrderCancelFactory = $magenestCancelOrderFactory;
        $this->orderRepository = $orderRepository;
        $this->orderHistoryFactory = $orderHistoryFactory;
        $this->logger = $logger;
        $this->orderManagement = $orderManagement;
        $this->_orderModel = $orderModel;
        return parent::__construct($ksContext);
    }

    /**
     * Method to save request and send mail to admin.
     */
    public function execute()
    {
        $ksOrderCancel = $this->magenestOrderCancelFactory->create();
        $ksData = $this->getRequest()->getPost();

        $status = $ksData['state'];

        $ksOrderCancel->setData('order_cancel_reason', $ksData['reason']);
        $ksOrderCancel->setData('comment', $ksData['comment']);
        $ksOrderCancel->setData('order_id', $ksData['entityId']);
        $ksOrderCancel->setData('customer_email', $this->magenestHelperData->getCustomerData()->getEmail());
        $ksOrderCancel->setData('cancel_date', date("Y-m-d H:i:s"));
        $ksOrderCancel->setData('cancel_by', "Customer");

        try {
            $orderCancel = $this->_orderModel->load($ksData['entityId']);
            $orderCancel->setState($ksData['state']);
            $orderCancel->setStatus($ksData['state']);
            $orderCancel->save();
            $order = $this->orderRepository->get($ksData['entityId']);
            if ($order->canComment()) {
                $history = $this->orderHistoryFactory->create()
                    ->setStatus(!empty($status) ? $status : $order->getStatus()) // Update status when passing $comment parameter
                    ->setEntityName(\Magento\Sales\Model\Order::ENTITY) // Set the entity name for order
                    ->setComment(
                        __('Comment: %1.', $ksData['comment'])
                    ); // Set your comment

                $history->setIsCustomerNotified(true)// Enable Notify your customers via email
                ->setIsVisibleOnFront(true);// Enable order comment visible on sales order details

                $order->addStatusHistory($history); // Add your comment to order
                $this->orderRepository->save($order);
            }
        } catch (NoSuchEntityException $exception) {
            $this->logger->error($exception->getMessage());
        }

        try {
            $ksOrderCancel->save();
            $this->messageManager->addSuccessMessage(__('Your order cancel request is sent.This may take some time.'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Sorry request has been sent before. Please wait, this may take some time.'));
        }
    }
}
