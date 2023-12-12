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

namespace Yudiz\CouponUsageReport\Controller\Adminhtml\Report\Sales;

use Yudiz\CouponUsageReport\Model\Flag;

class CouponUsageReport extends \Magento\Reports\Controller\Adminhtml\Report\Sales
{
    /**
     * Execute method
     */
    public function execute()
    {
        $this->_showLastExecutionTime(Flag::REPORT_COUPONUSAGEREPORT_FLAG_CODE, 'CouponUsageReport');

        $this->_initAction()->_setActiveMenu(
            'Yudiz_CouponUsageReport::Report_CouponUsageReport'
        )->_addBreadcrumb(
            __('Coupon Code Usage Report'),
            __('Coupon Code Usage Report')
        );
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Coupon Code Usage Report'));

        $gridBlock = $this->_view->getLayout()->getBlock('adminhtml_sales_CouponUsageReport.grid');
        $filterFormBlock = $this->_view->getLayout()->getBlock('grid.filter.form');

        $this->_initReportAction([$gridBlock, $filterFormBlock]);

        $this->_view->renderLayout();
    }
}
