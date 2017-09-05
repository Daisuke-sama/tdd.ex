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
    private $receipt;

    public function setUp()
    {
        $this->receipt = new Receipt();
    }

    public function tearDown()
    {
        unset($this->receipt);
    }

    public function testTotal()
    {
        $input = [0,2,5,8];

        $output = $this->receipt->total($input);

        $this->assertEquals(15, $output, 'When summing the total should equal 15');
    }

    public function testTax() {
        $inputAmount = 10.00;
        $inputTax = 0.10;
        $outputAnswer = $this->receipt->tax($inputAmount, $inputTax);
        $this->assertEquals(
            1.00,
            $outputAnswer,
            'Tax shoulf be equal 1'
        );
    }
}