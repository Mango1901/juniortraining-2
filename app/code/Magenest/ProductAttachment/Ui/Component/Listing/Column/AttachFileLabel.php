<?php

namespace Magenest\ProductAttachment\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;


class AttachFileLabel extends Column
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
                if (isset($item['attach_file'])) {
                    $fileLabel = explode(".", $item["attach_file"])[0];
                    $fileIcon  = explode(".", $item["attach_file"])[1];
                    $item[$this->getData('name')] = $fileLabel;
                    $item['icon'] = $fileIcon;
                }
            }
        }

        return $dataSource;
    }
}
