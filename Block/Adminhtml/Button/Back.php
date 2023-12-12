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

namespace Yudiz\CouponUsageReport\Block\Adminhtml\Button;

class Back extends \Magento\Backend\Block\Widget\Container
{
    /**
     * Prepare layout
     *
     * @return parent::_prepareLayout()
     */
    protected function _prepareLayout()
    {
        $data = [
            'label' =>  'Back',
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/couponusagereport') . '\')',
            'class'     =>  'back'
        ];
        $this->buttonList->add('back', $data);
        return parent::_prepareLayout();
    }
}
