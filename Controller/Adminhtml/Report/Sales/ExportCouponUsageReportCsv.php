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

use Magento\Framework\App\Filesystem\DirectoryList;

class ExportCouponUsageReportCsv extends \Magento\Reports\Controller\Adminhtml\Report\Sales
{
    /**
     * Execute method
     */
    public function execute()
    {
        $fileName = 'Yudiz_CouponCodeUsage_Report.csv';
        $grid = $this->_view->getLayout()->createBlock(\Yudiz\CouponUsageReport\Block\Adminhtml\Grid\Grid::class);
        $this->_initReportAction($grid);
        return $this->_fileFactory->create($fileName, $grid->getCsvFile(), DirectoryList::VAR_DIR);
    }
}
