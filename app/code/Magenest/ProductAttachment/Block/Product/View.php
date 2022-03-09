<?php

namespace Magenest\ProductAttachment\Block\Product;

use Magento\Framework\View\Element\Template;


class View extends Template
{
    /**
     * Attachmentcollection
     *
     * @var \Magenest\ProductAttachment\Model\ResourceModel\ProductAttachment\CollectionFactory
     */
    protected $itemCollectionFactory;

    /**
     * Current Product
     *
     * @var array currentProduct
     */
    protected $coreRegistry;

    /**
     * Attachments for the product
     *
     * @var array attachments
     */
    protected $items;

    /**
     * View constructor
     *
     * @param Template\Context $context
     * @param \Magenest\ProductAttachment\Model\ResourceModel\ProductAttachment\CollectionFactory $itemCollectionFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Magenest\ProductAttachment\Model\ResourceModel\ProductAttachment\CollectionFactory $itemCollectionFactory,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->itemCollectionFactory = $itemCollectionFactory;
        $this->coreRegistry = $coreRegistry;
        $data['title'] = $context->getScopeConfig()->getValue('productattachment/general/title');
        $data['sort_order'] = $context->getScopeConfig()->getValue('productattachment/general/sort_order');
        parent::__construct($context, $data);
    }

    /**
     * Return attachments for the Product
     *
     * @return object Products
     */
    public function getAttachments()
    {
        if (!$this->items) {
            $product = $this->coreRegistry->registry('current_product');

            $this->items = $this->itemCollectionFactory->create()->addFieldToSelect(
                ['title','attach_file']
            )->addFieldToFilter(
                'is_active',
                ['eq' => \Magenest\ProductAttachment\Model\ProductAttachment::STATUS_ENABLED]
            );
            $this->items->getSelect()->joinLeft(
                ['attatch_products' => $this->items->getTable('sparsh_product_attachment')],
                'main_table.attachment_id = attatch_products.attachment_id',
                ['attatch_products.product_id']
            );
            $this->items->addFieldToFilter(
                'product_id',
                ['eq' => $product->getId()]
            )->addFieldToFilter(
                'title',
                ['notnull' => true]
            )->addFieldToFilter(
                'attach_file',
                ['notnull' => true]
            )
                ->setOrder(
                    'sort_order',
                    'asc'
                );
            ;
        }
        return $this->items;
    }

    /**
     * Return identifiers for produced content
     *
     * @return array identities
     */
    public function getIdentities()
    {
        $product = $this->coreRegistry->registry('current_product');
        return [\Magenest\ProductAttachment\Model\ProductAttachment::CACHE_TAG . '_' . $product->getId()];
    }

    /**
     * Return identifiers for produced content
     *
     * @return string mediapath
     */
    public function getAttachmentMediaPath()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
}
