<?php

/**
 * Yudiz
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Yudiz
 * @package     Yudiz_CouponUsageReport
 * @copyright   Copyright (c) 2023 Yudiz (https://www.Yudiz.com/)
 */

namespace Yudiz\CouponUsageReport\Model\ResourceModel\Report;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        $model = \Yudiz\CouponUsageReport\Model\Report::class;
        $resourceModel = \Yudiz\CouponUsageReport\Model\ResourceModel\Report::class;

        $this->_init($model, $resourceModel);
    }
}
