<?php
/**
 * Created by PhpStorm.
 * User: Pavel_Burylichau
 * Date: 9/5/2017
 * Time: 5:15 PM
 */

namespace TDD;

class Receipt
{
    public function total(array $items = [], ?float $coupon)
    {
        $sum = array_sum($items);

        if ($coupon !== null && is_float($coupon)) {
            $sum = $sum * (1 - $coupon);
        }

        return $sum;
    }

    public function tax(float $amount, float $tax)
    {
        return $amount * $tax;
    }

    public function postTaxTotal(array $items, float $tax, ?float $coupon) {
        $subtotal = $this->total($items, $coupon);
        $result = $subtotal + $this->tax($subtotal, $tax);

        return $result;
    }
}