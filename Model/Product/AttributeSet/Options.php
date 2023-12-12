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

namespace Yudiz\CouponUsageReport\Model\Product\AttributeSet;

use Magento\Framework\Option\ArrayInterface;

class Options implements ArrayInterface
{
    /**
     * @var \Magento\SalesRule\Model\Rule
     */
    protected $rule;

    /**
     * Constructor
     *
     * @param \Magento\SalesRule\Model\Rule $rule
     */
    public function __construct(
        \Magento\SalesRule\Model\Rule $rule
    ) {
        $this->rule = $rule;
    }

    /**
     * Convert rules to option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $rules = $this->rule->getCollection()->getData();

        $optionArrays = [];
        $optionArrays[] = ['value' => 'none', 'label' => '--- Select Applied Rule ---'];

        foreach ($rules as $rule) {
            $optionArray = [
                'value' => $rule['name'],
                'label' => $rule['name']
            ];
            $optionArrays[] = $optionArray;
        }
        return $optionArrays;
    }
}
