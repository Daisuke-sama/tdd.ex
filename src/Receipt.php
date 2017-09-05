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
    public function total(array $items = [])
    {
        return array_sum($items);
    }

    public function tax($amount, $tax)
    {
        return $amount * $tax;
    }
}