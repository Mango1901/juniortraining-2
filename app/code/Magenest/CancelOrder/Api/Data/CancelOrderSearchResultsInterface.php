<?php
/**
 * Copyright © CancelOrder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\CancelOrder\Api\Data;

interface CancelOrderSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get CancelOrder list.
     * @return \Magenest\CancelOrder\Api\Data\CancelOrderInterface[]
     */
    public function getItems();

    /**
     * Set request_id list.
     * @param \Magenest\CancelOrder\Api\Data\CancelOrderInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

