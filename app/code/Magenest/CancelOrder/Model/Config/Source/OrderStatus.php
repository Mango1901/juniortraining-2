<?php
/**
 * Copyright © CancelOrder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\CancelOrder\Model\Config\Source;

class OrderStatus implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [['value' => 'Pending', 'label' => __('Pending')],['value' => 'Processing', 'label' => __('Processing')]];
    }

    public function toArray()
    {
        return ['Pending' => __('Pending'),'Processing' => __('Processing')];
    }
}

