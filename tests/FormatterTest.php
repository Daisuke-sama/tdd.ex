<?php
/**
 * Created by PhpStorm.
 * User: Royal_PC
 * Date: 22-Sep-17
 * Time: 10:30 PM
 */

namespace TDD\Test;
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor'
    . DIRECTORY_SEPARATOR . 'autoload.php';


use PHPUnit\Framework\TestCase;
use TDD\Formatter;


class FormatterTest extends TestCase
{
    /**
     * @var Formatter
     */
    private $formatter;

    public function setUp()
    {
        $this->formatter = new Formatter();
    }

    public function tearDown()
    {
        unset($this->formatter);
    }
    
    /**
     * @dataProvider provideCurrencyAmount
     */
    public function testCurrencyAmount($input, $expected, $message)
    {
        $this->assertSame(
            $expected,
            $this->formatter->currencyAmount($input),
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