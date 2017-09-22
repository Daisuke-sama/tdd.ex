<?php
/**
 * Created by PhpStorm.
 * User: Pavel_Burylichau
 * Date: 9/5/2017
 * Time: 5:15 PM
 */

namespace TDD;

use \BadMethodCallException;
use TDD\Formatter;

class Receipt
{
    /**
     * @var Formatter
     */
    private $formatter;

    public function __construct($formatter)
    {
        $this->formatter = $formatter;
    }

    public function total(array $items = [], ?float $coupon)
    {
        if ($coupon > 1.00) {
            throw new BadMethodCallException(
                'Coupon must less then or equal to 1.00'
            );
        }

        $sum = array_sum($items);

        if ($coupon !== null && is_float($coupon)) {
            $sum = $sum * (1 - $coupon);
        }

        return $sum;
    }

    public function tax(float $amount, float $tax)
    {
        return $amount * $this->formatter->currencyAmount($tax);
    }

    public function postTaxTotal(array $items, float $tax, ?float $coupon)
    {
        $subtotal = $this->total($items, $coupon);
        $result   = $subtotal + $this->tax($subtotal, $tax);

        return $result;
    }
}