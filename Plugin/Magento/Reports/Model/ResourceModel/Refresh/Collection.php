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

namespace Yudiz\CouponUsageReport\Plugin\Magento\Reports\Model\ResourceModel\Refresh;

class Collection extends \Magento\Framework\Data\Collection
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_localeDate;

    /**
     * @var \Magento\Reports\Model\FlagFactory
     */
    protected $_reportsFlagFactory;

    /**
     * @param \Magento\Framework\Data\Collection\EntityFactory $entityFactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Reports\Model\FlagFactory $reportsFlagFactory
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Reports\Model\FlagFactory $reportsFlagFactory
    ) {
        parent::__construct($entityFactory);
        $this->_localeDate = $localeDate;
        $this->_reportsFlagFactory = $reportsFlagFactory;
    }

    /**
     * Get if updated
     *
     * @param string $reportCode
     * @return string
     */
    protected function _getUpdatedAt($reportCode)
    {
        $flag = $this->_reportsFlagFactory->create()->setReportFlagCode($reportCode)->loadSelf();
        return $flag->hasData() ? $flag->getLastUpdate() : '';
    }

    /**
     * Handles the logic after data is loaded.
     *
     * @param \Magento\Framework\Data\Collection\AbstractDb $subject The subject of the plugin
     * @param array $result The result data
     * @param bool $printQuery Whether to print the query
     * @param bool $logQuery Whether to log the query
     *
     * @return array
     */
    public function afterLoadData($subject, $result, $printQuery = false, $logQuery = false)
    {
        if (!count($this->_items)) {
            $data = [
                [
                    'id' => 'CouponUsageReport',
                    'report' => __('Coupon Code Usage Report'),
                    'comment' => __('Coupon Code Usage Report'),
                    'updated_at' => $this->_getUpdatedAt(
                        \Yudiz\CouponUsageReport\Model\Flag::REPORT_COUPONUSAGEREPORT_FLAG_CODE
                    )                ],
            ];
            foreach ($data as $value) {
                $item = new \Magento\Framework\DataObject();
                $item->setData($value);
                $this->addItem($item);
                $subject->addItem($item);
            }
        }
        return $subject;
    }
}
