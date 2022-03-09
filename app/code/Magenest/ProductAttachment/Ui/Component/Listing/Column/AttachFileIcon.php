<?php

namespace Magenest\ProductAttachment\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class AttachFileIcon extends Column
{
    /**
     * UrlBuilder
     *
     * @var UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Constructor
     *
     * @param ContextInterface $context Context
     * @param UiComponentFactory $uiComponentFactory UiComponentFactory
     * @param UrlInterface $urlBuilder UrlBuilder
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $components Components
     * @param array $data Data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource DataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['icon'])) {
                    $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                    if ($item[$this->getData('name')] === 'pdf') {
                        $item[$this->getData('name') . '_src'] = $mediaUrl . "/magenest/product_attachment/tmp/pdf_image.png";
                    } elseif ($item[$this->getData('name')] === 'doc' | $item[$this->getData('name')] === 'docx') {
                        $item[$this->getData('name') . '_src'] = $mediaUrl . "/magenest/product_attachment/tmp/doc_image.png";
                    } elseif ($item[$this->getData('name')] === 'xls' | $item[$this->getData('name')] === 'xlsx') {
                        $item[$this->getData('name') . '_src'] = $mediaUrl . "/magenest/product_attachment/tmp/excel.png";
                    }
                }
            }
        }

        return $dataSource;
    }
}
