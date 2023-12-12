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

namespace Yudiz\CouponUsageReport\Block\Adminhtml\Grid;

use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magento\Framework\Registry;
use Yudiz\CouponUsageReport\Model\ResourceModel\Report\CollectionFactory as DemoCollection;
use Magento\Framework\Session\SessionManagerInterface;

// also you can use Magento Default CollectionFactory
class Grid extends Extended
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Yudiz\CouponUsageReport\Model\ResourceModel\Report\CollectionFactory
     */
    protected $demoFactory;

    /**
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $sessionManager;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Framework\Registry $registry
     * @param \Yudiz\CouponUsageReport\Model\ResourceModel\Report\CollectionFactory $demoFactory
     * @param \Magento\Framework\Session\SessionManagerInterface $sessionManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        Registry $registry,
        DemoCollection $demoFactory,
        SessionManagerInterface $sessionManager,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->demoFactory = $demoFactory;
        $this->sessionManager = $sessionManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Constructor
     *
     * Set grid ID, default sort column, sort direction, save parameters in session,
     * disable filter visibility, set default limit, and disable pager visibility.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('index');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setFilterVisibility(false); //Filter Visibility is disabled
        $this->setDefaultLimit(100); //Default Pagination is set 100
        $this->setPagerVisibility(false); //Pagination Visibility is disabled
    }

    /**
     * Prepare mass action
     *
     * @return $this
     */
    protected function _prepareMassaction()
    {
        return $this;
    }

    /**
     * Prepare collection
     *
     * @return parent::_prepareCollection()
     */
    protected function _prepareCollection()
    {
        // $data = $this->getRequest()->getPostValue();
        $this->sessionManager->start();

        $coupon = $this->sessionManager->getData('customreportcoupon');

        $time_from = strtotime($this->sessionManager->getData('customreportfrom'));
        $newformatFrom = date('Y-m-d', $time_from);

        $time_to = strtotime($this->sessionManager->getData('customreportto'));
        $newformatTo = date('Y-m-d', $time_to);
        $demo = $this->demoFactory->create()
            ->addFieldToSelect('*');

        if ($coupon == 'none') {
            $demo->addFieldToFilter('id', ['neq' => ''])
                ->addFieldToFilter('created_at', ['gteq' => $newformatFrom])
                ->addFieldToFilter('created_at', ['lteq' => $newformatTo]);
        } else {
            $demo->addFieldToFilter('id', ['neq' => ''])
                ->addFieldToFilter('created_at', ['gteq' => $newformatFrom])
                ->addFieldToFilter('created_at', ['lteq' => $newformatTo])
                ->addFieldToFilter('rule_name', ['eq' => $coupon]);
        }

        $this->setCollection($demo);
        return parent::_prepareCollection();
    }

    /**
     * Prepare columns
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'rule_name',
            [
                'header' => __('Rule Name'),
                'index' => 'rule_name',
                'type' => 'string',
                'sortable' => false,
                'header_css_class' => 'col-product',
                'column_css_class' => 'col-product'
            ]
        );

        $this->addColumn(
            'coupon_code',
            [
                'header' => __('Coupon Code'),
                'index' => 'coupon_code',
                'type' => 'string',
                'sortable' => false,
                'header_css_class' => 'col-product',
                'column_css_class' => 'col-product'
            ]
        );

        $this->addColumn(
            'order_id',
            [
                'header' => __('Order Id'),
                'index' => 'order_id',
                'type' => 'string',
                'sortable' => false,
                'header_css_class' => 'col-product',
                'column_css_class' => 'col-product'
            ]
        );

        $this->addColumn(
            'user_id',
            [
                'header' => __('Customer Id'),
                'index' => 'user_id',
                'type' => 'string',
                'sortable' => false,
                'header_css_class' => 'col-product',
                'column_css_class' => 'col-product'
            ]
        );

        $this->addColumn(
            'user_name',
            [
                'header' => __('Customer Name'),
                'index' => 'user_name',
                'type' => 'string',
                'sortable' => false,
                'header_css_class' => 'col-product',
                'column_css_class' => 'col-product'
            ]
        );

        $this->addColumn(
            'user_email',
            [
                'header' => __('Customer Email'),
                'index' => 'user_email',
                'type' => 'string',
                'sortable' => false,
                'header_css_class' => 'col-product',
                'column_css_class' => 'col-product'
            ]
        );

        $this->addColumn(
            'created_at',
            [
                'header' => __('Order Date'),
                'index' => 'created_at',
                'type' => 'string',
                'sortable' => false,
                'header_css_class' => 'col-product',
                'column_css_class' => 'col-product'
            ]
        );

        $this->addExportType('*/*/exportCouponUsageReportCsv', __('CSV'));

        return parent::_prepareColumns();
    }

    /**
     * Get grid URL
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/showdata', ['_current' => true]);
    }
}
