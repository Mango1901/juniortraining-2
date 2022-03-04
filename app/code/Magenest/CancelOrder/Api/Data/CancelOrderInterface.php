<?php
/**
 * Copyright © CancelOrder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\CancelOrder\Api\Data;

interface CancelOrderInterface
{

    const COMMENT = 'comment';
    const ORDER_CANCEL_REASON = 'order_cancel_reason';
    const CANCELORDER_ID = 'cancelorder_id';
    const REQUEST_ID = 'request_id';
    const CANCEL_BY = 'cancel_by';

    /**
     * Get cancelorder_id
     * @return string|null
     */
    public function getCancelorderId();

    /**
     * Set cancelorder_id
     * @param string $cancelorderId
     * @return \Magenest\CancelOrder\CancelOrder\Api\Data\CancelOrderInterface
     */
    public function setCancelorderId($cancelorderId);

    /**
     * Get request_id
     * @return string|null
     */
    public function getRequestId();

    /**
     * Set request_id
     * @param string $requestId
     * @return \Magenest\CancelOrder\CancelOrder\Api\Data\CancelOrderInterface
     */
    public function setRequestId($requestId);

    /**
     * Get order_cancel_reason
     * @return string|null
     */
    public function getOrderCancelReason();

    /**
     * Set order_cancel_reason
     * @param string $orderCancelReason
     * @return \Magenest\CancelOrder\CancelOrder\Api\Data\CancelOrderInterface
     */
    public function setOrderCancelReason($orderCancelReason);

    /**
     * Get comment
     * @return string|null
     */
    public function getComment();

    /**
     * Set comment
     * @param string $comment
     * @return \Magenest\CancelOrder\CancelOrder\Api\Data\CancelOrderInterface
     */
    public function setComment($comment);

    /**
     * Get cancel_by
     * @return string|null
     */
    public function getCancelBy();

    /**
     * Set cancel_by
     * @param string $cancelBy
     * @return \Magenest\CancelOrder\CancelOrder\Api\Data\CancelOrderInterface
     */
    public function setCancelBy($cancelBy);
}

