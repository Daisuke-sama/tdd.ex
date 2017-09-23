<?php
/**
 * Created by PhpStorm.
 * User: Royal_PC
 * Date: 22-Sep-17
 * Time: 10:40 PM
 */

namespace TDD;


class Formatter
{
    public function currencyAmount($input)
    {
        return round($input, 2);
    }
}