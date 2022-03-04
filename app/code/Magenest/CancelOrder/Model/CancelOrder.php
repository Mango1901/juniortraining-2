<?php
/**
 * Copyright © CancelOrder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\CancelOrder\Model;

use Magenest\CancelOrder\Api\Data\CancelOrderInterface;
use Magento\Framework\Model\AbstractModel;

class CancelOrder extends AbstractModel implements CancelOrderInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Magenest\CancelOrder\Model\ResourceModel\CancelOrder::class);
    }

    /**
     * @inheritDoc
     */
    public function getCancelorderId()
    {
        return $this->getData(self::CANCELORDER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCancelorderId($cancelorderId)
    {
        return $this->setData(self::CANCELORDER_ID, $cancelorderId);
    }

    /**
     * @inheritDoc
     */
    public function getRequestId()
    {
        return $this->getData(self::REQUEST_ID);
    }

    /**
     * @inheritDoc
     */
    public function setRequestId($requestId)
    {
        return $this->setData(self::REQUEST_ID, $requestId);
    }

    /**
     * @inheritDoc
     */
    public function getOrderCancelReason()
    {
        return $this->getData(self::ORDER_CANCEL_REASON);
    }

    /**
     * @inheritDoc
     */
    public function setOrderCancelReason($orderCancelReason)
    {
        return $this->setData(self::ORDER_CANCEL_REASON, $orderCancelReason);
    }

    /**
     * @inheritDoc
     */
    public function getComment()
    {
        return $this->getData(self::COMMENT);
    }

    /**
     * @inheritDoc
     */
    public function setComment($comment)
    {
        return $this->setData(self::COMMENT, $comment);
    }

    /**
     * @inheritDoc
     */
    public function getCancelBy()
    {
        return $this->getData(self::CANCEL_BY);
    }

    /**
     * @inheritDoc
     */
    public function setCancelBy($cancelBy)
    {
        return $this->setData(self::CANCEL_BY, $cancelBy);
    }
}

