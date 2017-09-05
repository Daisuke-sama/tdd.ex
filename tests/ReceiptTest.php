<?php
/**
 * Created by PhpStorm.
 * User: Pavel_Burylichau
 * Date: 9/5/2017
 * Time: 5:24 PM
 */

namespace TDD\Test;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor'
    . DIRECTORY_SEPARATOR . 'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;


class ReceiptTest extends TestCase
{
    public function testTotal()
    {
        $receipt = new Receipt();
        $this->assertEquals(
            15,
            $receipt->total([0,2,5,8]),
            'When summing the total should equal 15');
    }
}