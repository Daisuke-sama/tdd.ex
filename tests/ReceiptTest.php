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
        $input  = [0, 2, 5, 8];
        $coupon = null;    // dummy object

        $output = $this->receipt->total($input, null);

        $this->assertEquals(
            15, $output, 'When summing the total should equal 15'
        );
    }

    /**
     * Within the function is a "dummy" object placed. It is a coupon that
     * exist, but doesn't affect.
     */
    public function testTotalAndCoupon()
    {
        $input  = [0, 2, 5, 8];
        $coupon = 0.20;     // dummy object

        $output = $this->receipt->total($input, $coupon);

        $this->assertEquals(
            12, $output, 'When summing the total should equal 12'
        );
    }

    public function testTotalException()
    {
        $input  = [0, 2, 5, 8];
        $coupon = 1.20;

        $this->expectException('BadMethodCallException');
        $this->receipt->total($input, $coupon);
    }

    public function testTax()
    {
        $inputAmount  = 10.00;
        $inputTax     = 0.10;
        $outputAnswer = $this->receipt->tax($inputAmount, $inputTax);
        $this->assertEquals(
            1.00,
            $outputAnswer,
            'Tax should be equal 1.'
        );
    }

    /**
     * Here is a stub creation for replacing of methods in the class, thereby
     * excluding needed their real existing in the class, because we have
     * written returns that we want to receive for our testing method passed
     * its test.
     */
    public function testPostTaxTotal()
    {
        // creating a stub
        // In other words, the two methods can absence in the testing class,
        // and anyway test will pass.
        $receipt = $this->getMockBuilder('TDD\\Receipt')
            ->setMethods(['tax', 'total'])
            ->getMock();
        $receipt->method('total')
            ->will($this->returnValue(10.00));
        $receipt->method('tax')
            ->will($this->returnValue(1.00));

        // If the methods are used inside that tested function then its results
        // will be replaced on created by mock above, i.e. 10.00 and 1.00.
        $result = $receipt->postTaxTotal([1, 2, 5, 8], 0.20, null);

        $this->assertEquals(11.00, $result);
    }
}