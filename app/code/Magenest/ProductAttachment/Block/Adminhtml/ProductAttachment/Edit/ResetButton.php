<?php

namespace Magenest\ProductAttachment\Block\Adminhtml\ProductAttachment\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;


class ResetButton implements ButtonProviderInterface
{
    /**
     * ButtonData
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30
        ];
    }
}
