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

    /**
     * @var Receipt
     */
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
        $coupon = null;    // dummy object

        $output = $this->receipt->total($input, null);

        $this->assertEquals(15, $output, 'When summing the total should equal 15');
    }

    /**
     * Within the function is a "dummy" object placed. It is a coupon that exist, but doesn't affect.
     */
    public function testTotalAndCoupon()
    {
        $input = [0,2,5,8];
        $coupon = 0.20;     // dummy object

        $output = $this->receipt->total($input, $coupon);

        $this->assertEquals(12, $output, 'When summing the total should equal 12');
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