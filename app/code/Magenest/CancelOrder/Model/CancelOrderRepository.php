<?php
/**
 * Copyright © CancelOrder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\CancelOrder\Model;

use Magenest\CancelOrder\Api\CancelOrderRepositoryInterface;
use Magenest\CancelOrder\Api\Data\CancelOrderInterface;
use Magenest\CancelOrder\Api\Data\CancelOrderInterfaceFactory;
use Magenest\CancelOrder\Api\Data\CancelOrderSearchResultsInterfaceFactory;
use Magenest\CancelOrder\Model\ResourceModel\CancelOrder as ResourceCancelOrder;
use Magenest\CancelOrder\Model\ResourceModel\CancelOrder\CollectionFactory as CancelOrderCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class CancelOrderRepository implements CancelOrderRepositoryInterface
{

    /**
     * @var CancelOrderCollectionFactory
     */
    protected $cancelOrderCollectionFactory;

    /**
     * @var ResourceCancelOrder
     */
    protected $resource;

    /**
     * @var CancelOrderInterfaceFactory
     */
    protected $cancelOrderFactory;

    /**
     * @var CancelOrder
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;


    /**
     * @param ResourceCancelOrder $resource
     * @param CancelOrderInterfaceFactory $cancelOrderFactory
     * @param CancelOrderCollectionFactory $cancelOrderCollectionFactory
     * @param CancelOrderSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceCancelOrder $resource,
        CancelOrderInterfaceFactory $cancelOrderFactory,
        CancelOrderCollectionFactory $cancelOrderCollectionFactory,
        CancelOrderSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->cancelOrderFactory = $cancelOrderFactory;
        $this->cancelOrderCollectionFactory = $cancelOrderCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(CancelOrderInterface $cancelOrder)
    {
        try {
            $this->resource->save($cancelOrder);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the cancelOrder: %1',
                $exception->getMessage()
            ));
        }
        return $cancelOrder;
    }

    /**
     * @inheritDoc
     */
    public function get($cancelOrderId)
    {
        $cancelOrder = $this->cancelOrderFactory->create();
        $this->resource->load($cancelOrder, $cancelOrderId);
        if (!$cancelOrder->getId()) {
            throw new NoSuchEntityException(__('CancelOrder with id "%1" does not exist.', $cancelOrderId));
        }
        return $cancelOrder;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->cancelOrderCollectionFactory->create();
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(CancelOrderInterface $cancelOrder)
    {
        try {
            $cancelOrderModel = $this->cancelOrderFactory->create();
            $this->resource->load($cancelOrderModel, $cancelOrder->getCancelorderId());
            $this->resource->delete($cancelOrderModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the CancelOrder: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($cancelOrderId)
    {
        return $this->delete($this->get($cancelOrderId));
    }
}

