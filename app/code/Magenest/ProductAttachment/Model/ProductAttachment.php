<?php

namespace Magenest\ProductAttachment\Model;

class ProductAttachment extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'sparsh_productattachment';

    /**
     * Cache Tag
     *
     * @var string
     */
    protected $cacheTag = 'sparsh_productattachment';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $eventPrefix = 'sparsh_productattachment';

    /**
     * ProductAttachment Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Magenest\ProductAttachment\Model\ResourceModel\ProductAttachment::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Prepare item's statuses
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * Return the Selected Products of Attachment
     *
     * @param int $attachmentid Current Attachment Id
     *
     * @return mixed
     */
    public function getSelectedProducts($attachmentid)
    {
        $productsids = $this->getResource()->getSelectedProducts($attachmentid);
        return $productsids;
    }
}
