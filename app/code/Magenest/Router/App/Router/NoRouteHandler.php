<?php

namespace Magenest\Router\App\Router;

class NoRouteHandler implements \Magento\Framework\App\Router\NoRouteHandlerInterface
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    protected $_categoryCollectionFactory;
    /**
     * @var
     */
    protected $_productCollectionFactory;

    /**
     * NoRouteHandler constructor.
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_productCollectionFactory  = $productCollectionFactory;
    }

    public function process(\Magento\Framework\App\RequestInterface $request)
    {
        $requestValue = ltrim($request->getPathInfo(), '/');

        $ProductCollection = $this->_productCollectionFactory->create();
        $ProductCollection->addAttributeToSelect('*');

        foreach ($ProductCollection as $product) {
            if ($product->getSku() == $requestValue) {
                $request->setParam('q', $requestValue);
            }
        }
        $collection = $this->_categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addIsActiveFilter();
        $categories = $collection;
        foreach ($categories as $category) {
            similar_text($requestValue, $category->getName(), $percent);
            if ($percent >= 70) {
                $request->setParam('q', $requestValue);
            }
        }

        if (!empty($request->getParam("q"))) {
            $request->setModuleName('catalogsearch')->setControllerName('result')->setActionName('index');
        } else {
            $request->setRouteName('noroutefound')->setControllerName('page')->setActionName('customnoroute');
        }

        return true;
    }
}
