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

    /**
     * @dataProvider provideSubtotal
     */
    public function testSubtotal($items, $expected)
    {
        $coupon = null;    // dummy object

        $output = $this->receipt->subtotal($items, $coupon);

        $this->assertEquals(
            $expected,
            $output,
            "When summing the total should equal {$expected}"
        );
    }

    public function provideSubtotal()
    {
        return [
            'waited_ok' => [[1, 2, 5, 8], 16],
            // can be tested with command "vendor\bin\phpunit tests --filter=testTotal@waited_ok"
            [[-1, 2, 5, 8], 14],
            [[1, 2, 8], 11],
        ];
    }

    /**
     * Within the function is a "dummy" object placed. It is a coupon that
     * exist, but doesn't affect.
     */
    public function testSubtotalAndCoupon()
    {
        $input  = [0, 2, 5, 8];
        $coupon = 0.20;                         // dummy object

        $output = $this->receipt->subtotal($input, $coupon);

        $this->assertEquals(
            12, $output, 'When summing the total should equal 12'
        );
    }

    public function testSubtotalException()
    {
        $input  = [0, 2, 5, 8];
        $coupon = 1.20;

        $this->expectException('BadMethodCallException');
        $this->receipt->subtotal($input, $coupon);
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
    public function testPostTaxSubtotal()
    {
        // creating a stub
        // In other words, the two methods can absence in the testing class,
        // and anyway test will pass.
        $receipt = $this->getMockBuilder('TDD\\Receipt')
            ->setMethods(['tax', 'subtotal'])
            ->getMock();
        $receipt->method('subtotal')
            ->will($this->returnValue(10.00));
        $receipt->method('tax')
            ->will($this->returnValue(1.00));

        // If the methods are used inside that tested function then its results
        // will be replaced on created by mock above, i.e. 10.00 and 1.00.
        $result = $receipt->postTaxSubtotal([1, 2, 5, 8], 0.20, null);

        $this->assertEquals(11.00, $result);
    }

    /**
     * Here is a mock creation, which means controlling inputs for functions,
     * or a mock has expectations about the stub method are called in the
     * inputs to that stub.
     */
    public function testPostTaxSubtotalMock()
    {
        $items  = [1, 2, 5, 8];
        $tax    = 0.20;
        $coupon = null;
        // creating a stub
        // In other words, the two methods can absence in the testing class,
        // and anyway test will pass.
        $receipt = $this->getMockBuilder('TDD\\Receipt')
            ->setMethods(['tax', 'subtotal'])
            ->getMock();
        $receipt->expects($this->once())
            ->method('subtotal')
            ->with($items, $coupon)// here we have transformed a stub to a mock
            ->will($this->returnValue(10.00));
        $receipt->expects($this->once())
            ->method('tax')
            // since we have stubbed return value of the total() that used by tax(),
            // then mock signature for tax() should have that return value.
            // In other words, there is a new implicit assertion, which success
            // will be shown in the test result.
            ->with(10.00, $tax)
            ->will($this->returnValue(1.00));

        // If the methods are used inside that tested function then its results
        // will be replaced on created by mock above, i.e. 10.00 and 1.00.
        $result = $receipt->postTaxSubtotal([1, 2, 5, 8], 0.20, null);

        $this->assertEquals(11.00, $result);
    }

    /**
     * @dataProvider provideCurrencyAmount
     */
    public function testCurrencyAmount($input, $expected, $message)
    {
        $this->assertSame(
            $expected,
            $this->receipt->currencyAmount($input),
            $message
        );
    }

    public function provideCurrencyAmount()
    {
        return [
            [1, 1.00, '1 should be transformed to 1.00'],
            [1.1, 1.10, '1.1 should be transformed to 1.10'],
            [1.11, 1.11, '1.11 should be transformed to 1.11'],
            [1.111, 1.11, '1.111 should be transformed to 1.11'],
        ];
    }
}