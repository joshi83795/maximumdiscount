<?php

namespace Joshi\MaximumDiscount\Model;

class RulesApplier extends  \Magento\SalesRule\Model\RulesApplier
{

    protected function applyRule($item, $rule, $address, $couponCode)
    { 
        $itemOriginalPrice  = $item->getOriginalPrice();
        $itemQty        = $item->getQty();
        $address        = $item->getAddress();
        $objectManager  = \Magento\Framework\App\ObjectManager::getInstance();
        $dataHelper     = $objectManager->create(\Joshi\MaximumDiscount\Helper\Data::class);
        $isEnabled      = $dataHelper->isEnabled();
        $discountData   = $this->getDiscountData($item, $rule, $address);
        $maxDiscount    = $rule->getMaxDiscount();
        $simpleAction   = $rule->getSimpleAction();
        $discountAmount = $rule->getDiscountAmount();
        $baseSubtotal   = $address->getBaseSubtotal();
        $discountTotalAmount = $baseSubtotal * $discountAmount/100;

        if ($isEnabled  && $maxDiscount > 0 && $simpleAction == 'by_percent') { 
            $finalItemPrice = $itemOriginalPrice  * $itemQty;
            $itemDiscount   = $finalItemPrice * $discountAmount / 100;
            
           if($itemDiscount > $maxDiscount) {
                $discountData->setAmount($maxDiscount) ;
                $discountData->setBaseAmount($maxDiscount) ;
            }
        }
        $this->setDiscountData($discountData, $item);
        $this->maintainAddressCouponCode($address, $rule, $couponCode);
        $this->addDiscountDescription($address, $rule);
        return $this;
    }
}
