<?php
namespace Joshi\MaximumDiscount\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\Context;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_MAXIMUM_COUPON_DISCOUNT_ENABLE = 'maximumdiscount/general/active';

    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    public function isEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_MAXIMUM_COUPON_DISCOUNT_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }
}
