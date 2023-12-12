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

namespace Yudiz\CouponUsageReport\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Report extends AbstractDb
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('yudiz_couponcode_report', 'id');
    }
}
