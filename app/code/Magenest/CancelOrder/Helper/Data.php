<?php
namespace Magenest\CancelOrder\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

/**
* class Data
*/
class Data extends AbstractHelper
{
    const ORDER_STATUS = "cancelorder/general/order_status";
    const CANCEL_ORDER_ENABLED = "cancelorder/general/enabled";
    const ORDER_CANCELLATION_REASON = "cancelorder/frontend/order_cancellation_reason";
    const CANCEL_FRONTEND_BUTTON = "cancelorder/frontend/button_label";
    const CANCEL_POPUP_NOTICE = "cancelorder/frontend/popup_notice";
    const CANCEL_POPUP_REQUIRED_FIELD = "cancelorder/frontend/is_required";

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;
    /**
     * @var \Magento\Customer\Model\SessionFactory
     */
    protected $_customerSession;

    /**
     * Data constructor.
     * @param \Magento\Customer\Model\SessionFactory $sessionFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param Context $context
     */
    public function __construct(
        \Magento\Customer\Model\SessionFactory $sessionFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        Context $context
    ) {
        $this->_customerSession = $sessionFactory->create();
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    public function getEnabled()
    {
        return $this->_scopeConfig->getValue(self::CANCEL_ORDER_ENABLED);
    }

    public function getCancelOrderStatus()
    {
        $orderStatus = $this->_scopeConfig->getValue(self::ORDER_STATUS);
        return explode(",", $orderStatus);
    }

    public function getCancelFrontendButtonLabel()
    {
        return $this->_scopeConfig->getValue(self::CANCEL_FRONTEND_BUTTON);
    }

    public function getOrderCancelReason()
    {
        $orderCancelReason = $this->_scopeConfig->getValue(self::ORDER_CANCELLATION_REASON);
        return json_decode($orderCancelReason, true);
    }

    public function getCancelPopupNotice()
    {
        return $this->_scopeConfig->getValue(self::CANCEL_POPUP_NOTICE);
    }

    public function getCustomerData()
    {
        if ($this->_customerSession->isLoggedIn()) {
            return $this->_customerSession->getCustomer();
        }
    }
}
