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

use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

class CouponUsageReport extends \Magento\Sales\Model\ResourceModel\Report\AbstractReport
{
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $orderCollectionFactory;

    public const REPORT_COUPONCODE = 'yudiz_couponcode_report';

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resource;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $timezone;

    /**
     * @var \Yudiz\CouponUsageReport\Model\ResourceModel\Report\CollectionFactory
     */
    protected $reportCollectionFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Reports\Model\FlagFactory $reportsFlagFactory
     * @param \Magento\Framework\Stdlib\DateTime\Timezone\Validator $timezoneValidator
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     * @param CollectionFactory $orderCollectionFactory
     * @param \Yudiz\CouponUsageReport\Model\ResourceModel\Report\CollectionFactory $reportCollectionFactory
     * @param string|null $connectionName
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Reports\Model\FlagFactory $reportsFlagFactory,
        \Magento\Framework\Stdlib\DateTime\Timezone\Validator $timezoneValidator,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        CollectionFactory $orderCollectionFactory,
        \Yudiz\CouponUsageReport\Model\ResourceModel\Report\CollectionFactory $reportCollectionFactory,
        $connectionName = null
    ) {
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->reportCollectionFactory = $reportCollectionFactory;
        $this->resource = $resource;
        $this->timezone = $timezone;

        parent::__construct(
            $context,
            $logger,
            $localeDate,
            $reportsFlagFactory,
            $timezoneValidator,
            $dateTime,
            $connectionName
        );
    }

    /**
     * Model initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::REPORT_COUPONCODE, 'id');
    }

    /**
     * Aggregate Orders data by order created at
     *
     * @param string|int|\DateTime|array|null $from
     * @param string|int|\DateTime|array|null $to
     * @return $this
     * @throws \Exception
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function aggregate($from = null, $to = null)
    {
        $connection = $this->getConnection();

        try {
            $insertBatches = [];
            $collection = $this->reportCollectionFactory->create();
            $data = $collection->getData();
            $orderCollection = $this->orderCollectionFactory->create();

            if (empty($data)) {
                $orderCollection->addFieldToFilter('coupon_rule_name', ['neq' => 'NULL'])
                    ->getSelect("*");
            } else {
                $arraySize = count($data);
                $lastOrderId = $data[$arraySize - 1]['order_id'];
                $orderCollection->addFieldToFilter('coupon_rule_name', ['neq' => 'NULL'])
                    ->addFieldToFilter('entity_id', ['gt' => $lastOrderId])
                    ->getSelect("*");
            }

            /**
             * Replace below collection with your custom collection
             *
             * You have to insert data to your aggregate report table
             */
            $LastOrderId = empty($data) ? 0 : $data[$arraySize - 1]['order_id'];

            if ($orderCollection) {
                foreach ($orderCollection as $order) {
                    if ($order['entity_id'] > $LastOrderId) {
                        $name = $order['customer_firstname'] . ' ' . $order['customer_lastname'];
                        $insertBatches[] = [
                            'rule_name'   => $order['coupon_rule_name'],
                            'coupon_code'   => $order['coupon_code'],
                            'order_id'      => $order['entity_id'],
                            'user_id'       => $order['customer_id'],
                            'user_name'     => $name,
                            'user_email'    => $order['customer_email'],
                            'created_at'    => $order['created_at']
                        ];
                    }
                }
            }
            $tableName = $this->resource->getTableName(self::REPORT_COUPONCODE);
            foreach (array_chunk($insertBatches, 100) as $batch) {
                $connection->insertMultiple($tableName, $batch);
            }
            $this->_setFlagData(\Yudiz\CouponUsageReport\Model\Flag::REPORT_COUPONUSAGEREPORT_FLAG_CODE);
        } catch (\Exception $e) {
            throw $e;
        }
        return $this;
    }
}
