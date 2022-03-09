<?php

namespace Magenest\ProductAttachment\Controller\Adminhtml\Attachgrid;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Result Page Factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Attachment Model
     *
     * @param array
     */
    protected $model;

    /**
     * Edit Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magenest\ProductAttachment\Model\ProductAttachment $model
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magenest\ProductAttachment\Model\ProductAttachment $model
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->model = $model;
        $this->_coreRegistry = $coreRegistry;

        parent::__construct($context);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $resultPage = $this->resultPageFactory->create();
        $id = $this->getRequest()->getParam('id');
        $this->model->load($id);
        $this->_coreRegistry->register('currentAttachment', $this->model);

        if ($this->getRequest()->getQuery('isAjax')) {
            return $this->ajaxRequestResponse($this->model, $resultPage);
        }

        $this->initPage($resultPage)->getConfig()->getTitle()->prepend(__($this->model->getTitle()));
        return $resultPage;
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
         $resultPage->setActiveMenu('Magenest_ProductAttachment::productattachment')
             ->addBreadcrumb(__('ProductAttachment'), __('Manage Product Attachment'))
             ->addBreadcrumb(__('ProductAttachment'), __('Manage Product Attachment'));

         return $resultPage;
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_ProductAttachment::productattachment');
    }
}
