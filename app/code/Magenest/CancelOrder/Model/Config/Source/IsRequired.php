<?php
/**
 * Copyright © CancelOrder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\CancelOrder\Model\Config\Source;

class IsRequired implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [['value' => 'comment', 'label' => __('Comment')],['value' => 'reason', 'label' => __('Reason')]];
    }

    public function toArray()
    {
        return ['comment' => __('Comment'),'reason' => __('Reason')];
    }
}

