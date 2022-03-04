<?php
/**
 * Copyright © CancelOrder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\CancelOrder\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface CancelOrderRepositoryInterface
{

    /**
     * Save CancelOrder
     * @param \Magenest\CancelOrder\Api\Data\CancelOrderInterface $cancelOrder
     * @return \Magenest\CancelOrder\Api\Data\CancelOrderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Magenest\CancelOrder\Api\Data\CancelOrderInterface $cancelOrder
    );

    /**
     * Retrieve CancelOrder
     * @param string $cancelorderId
     * @return \Magenest\CancelOrder\Api\Data\CancelOrderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($cancelorderId);

    /**
     * Retrieve CancelOrder matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magenest\CancelOrder\Api\Data\CancelOrderSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete CancelOrder
     * @param \Magenest\CancelOrder\Api\Data\CancelOrderInterface $cancelOrder
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Magenest\CancelOrder\Api\Data\CancelOrderInterface $cancelOrder
    );

    /**
     * Delete CancelOrder by ID
     * @param string $cancelorderId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($cancelorderId);
}

