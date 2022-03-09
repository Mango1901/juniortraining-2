<?php

namespace Magenest\ProductAttachment\Controller\Adminhtml\Attachgrid;

use Magenest\ProductAttachment\Model\ProductAttachment;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magenest\ProductAttachment\Controller\Adminhtml\ProductAttachment
{
    /**
     * Admin Resource
     *
     * @param string
     */
    const ADMIN_RESOURCE = 'Magenest_ProductAttachment::productattachment';

    /**
     * Data Processor
     *
     * @var \Magenest\ProductAttachment\Controller\Adminhtml\Attachgrid\PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * Data Persostor
     *
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * ProductAttachment Model
     *
     * @var \Magenest\ProductAttachment\Model\ProductAttachment
     */
    protected $model;

    /**
     * Save constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param PostDataProcessor                   $dataProcessor
     * @param ProductAttachment                   $model
     * @param DataPersistorInterface              $dataPersistor
     * @param \Magento\Framework\Registry         $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        PostDataProcessor $dataProcessor,
        ProductAttachment $model,
        DataPersistorInterface $dataPersistor,
        \Magento\Framework\Registry $coreRegistry,
        \Magenest\ProductAttachment\Model\ProductAttachment $attachmentLoader,
        \Magento\Framework\Controller\Result\Json $resultJson
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->model = $model;

        parent::__construct($context, $coreRegistry, $attachmentLoader, $resultJson);
    }

    /**
     * Save action execute
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $attachmentmodel = $this->initAttachment();

            if (!$this->dataProcessor->validate($data)) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $attachmentmodel->getId(), '_current' => true]);
            }

            try {
                $data = $this->filterFoodData($data);

                //Remove "on" key value from attachment_products
                $data['attachment_products'] = json_decode($data['attachment_products'], true);
                if (array_key_exists("on",$data['attachment_products'])){
                    unset($data['attachment_products']['on']);
                }
                $data['attachment_products'] = json_encode($data['attachment_products']);

                $attachmentmodel->setData($data);
                $attachmentmodel->save();
                $this->messageManager->addSuccess(__('Details are saved successfully.'));
                $this->dataPersistor->clear('productattachment');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        ['id' => $attachmentmodel->getId(),
                         '_current' => true]
                    );
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Attachment.'));
            }

            $this->dataPersistor->set('productattachment', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $attachmentmodel->getId()]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * FilterPoolData
     *
     * @param array $rawData Postdata
     *
     * @return array
     */
    public function filterFoodData(array $rawData)
    {

        $data = $rawData;

        if (isset($data['attach_file'][0]['name']) && isset($data['attach_file'][0]['tmp_name'])) {
            $data['attach_file'] =$data['attach_file'][0]['name'];
            $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magenest\ProductAttachment\ProductAttachImageUpload::class);
            $this->imageUploader->moveFileFromTmp($data['attach_file']);
        } elseif (isset($data['attach_file'][0]['name'])) {
            $data['attach_file'] =$data['attach_file'][0]['name'];
        } else {
            $data['attach_file'] = null;
        }

        return $data;
    }
}
