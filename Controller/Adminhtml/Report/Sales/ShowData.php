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

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\View\LayoutFactory;

class ShowData extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * @var SessionManagerInterface
     */
    protected $sessionManager;

    /**
     * @var RawFactory
     */
    protected $resultRawFactory;

    /**
     * @var LayoutFactory
     */
    protected $layoutFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param \Magento\Framework\App\RequestInterface $request
     * @param SessionManagerInterface $sessionManager
     * @param \Magento\Framework\Registry $registry
     * @param RawFactory $resultRawFactory
     * @param LayoutFactory $layoutFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Framework\App\RequestInterface $request,
        SessionManagerInterface $sessionManager,
        \Magento\Framework\Registry $registry,
        RawFactory $resultRawFactory,
        LayoutFactory $layoutFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->sessionManager = $sessionManager;
        $this->_registry = $registry;
        $this->resultRawFactory = $resultRawFactory;
        $this->layoutFactory = $layoutFactory;
    }

    /**
     * Execute method
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $this->sessionManager->start();

        if ($this->sessionManager->getData('customreportfrom') != '') {
            $this->sessionManager->unsData('customreportfrom');
            $this->sessionManager->unsData('customreportto');
            $this->sessionManager->unsData('customreportcoupon');
        }
        $this->sessionManager->setData('customreportfrom', $data['from']);
        $this->sessionManager->setData('customreportto', $data['to']);
        $this->sessionManager->setData('customreportcoupon', $data['coupon']);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Yudiz_CouponUsageReport::index');
        $resultPage->getConfig()->getTitle()->prepend(__('Coupon used by'));
        return $resultPage;
    }
}
