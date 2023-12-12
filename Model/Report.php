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

namespace Yudiz\CouponUsageReport\Model;

use Magento\Framework\Model\AbstractModel;

class Report extends AbstractModel
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init(\Yudiz\CouponUsageReport\Model\ResourceModel\Report::class);
    }
}
