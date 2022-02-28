<?php

namespace Magenest\Router\Block;

use Magento\Framework\View\Element\Template;
use Magento\UrlRewrite\Model\ResourceModel\UrlRewrite;

class SalesProduct extends Template
{
    /**
     * @var UrlRewrite
     */
    protected $_urlRewriteCollection;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productCollectionFactory;
    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    /**
     * SalesProduct constructor.
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollectionFactory
     * @param \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollection $urlRewriteCollection
     * @param \Magento\Catalog\Helper\Image $image
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollectionFactory,
        \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollection $urlRewriteCollection,
        \Magento\Catalog\Helper\Image $image,
        Template\Context $context,
        array $data = []
    ) {
        $this->_urlRewriteCollection = $urlRewriteCollection;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->imageHelper = $image;
        parent::__construct($context, $data);
    }

    public function getSalesProductData()
    {
        $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $data = [];
        $products = $this->_productCollectionFactory->addAttributeToSelect("*");
        foreach ($products as $product) {
            $specialPrice = $product->getPriceInfo()->getPrice('special_price')->getValue();
            if (isset($specialPrice)) {
                $urlRewrite = $this->_urlRewriteCollection->addFieldToFilter("target_path", "/sale/" . $product->getSku())->getLastItem()->getData();
                if (isset($urlRewrite)) {
                    $data[] = [
                        'request_path' => $product->getSku(),
                        "image" => $mediaUrl . "catalog/product/" . $product->getData('image')
                    ];
                }
            }
        }
        
        return $data;
    }
}
