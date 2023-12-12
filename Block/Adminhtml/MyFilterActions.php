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

namespace Yudiz\CouponUsageReport\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Massaction\Extended as ExtendedMassaction;

class MyFilterActions extends ExtendedMassaction
{
    /**
     * Prepare mass action
     *
     * @return $this
     */
    protected function _prepareMassaction()
    {
        return $this;
    }
}
