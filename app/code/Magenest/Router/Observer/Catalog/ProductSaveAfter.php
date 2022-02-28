<?php
/**
 * Copyright © Router All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\Router\Observer\Catalog;

use Magento\UrlRewrite\Model\ResourceModel\UrlRewrite;

class ProductSaveAfter implements \Magento\Framework\Event\ObserverInterface
{
    const TARGET_PATH = 'target_path';
    /**
     * @var \Magento\UrlRewrite\Model\UrlRewriteFactory
     */
    protected $_urlRewriteFactory;
    /**
     * @var UrlRewrite
     */
    protected $_urlRewriteCollection;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * ProductSaveAfter constructor.
     * @param \Magento\UrlRewrite\Model\UrlRewriteFactory $urlRewriteFactory
     * @param \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollection $urlRewriteCollection
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\UrlRewrite\Model\UrlRewriteFactory $urlRewriteFactory,
        \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollection $urlRewriteCollection,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_urlRewriteFactory = $urlRewriteFactory;
        $this->_urlRewriteCollection = $urlRewriteCollection;
        $this->_storeManager = $storeManager;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        $_product = $observer->getProduct();
        $specialPrice = $_product->getPriceInfo()->getPrice('special_price')->getValue();
        $basePrice = $_product->getPrice();
        if ($specialPrice < $basePrice) {
            $categoryIds = $_product->getCategoryIds();
            $checkExist = $this->_urlRewriteCollection->addFieldToFilter(self::TARGET_PATH, "/sale/" . $_product->getSku())->getLastItem();
            if (empty($checkExist->getData())) {
                $urlRewriteModel = $this->_urlRewriteFactory->create();
                $urlRewriteModel->setStoreId(1);
                $urlRewriteModel->setIsSystem(0);
                $urlRewriteModel->setIdPath(rand(1, 100000));
                $urlRewriteModel->setTargetPath("/sale/" . $_product->getSku());
                $urlRewriteModel->setRequestPath("catalog/product/view/id/" . $_product->getId());
                $urlRewriteModel->save();
            }
        }
    }
}
