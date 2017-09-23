<?php
/**
 * Created by PhpStorm.
 * User: Royal_PC
 * Date: 23-Sep-17
 * Time: 5:20 PM
 */

namespace TDD\Test;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor'
    . DIRECTORY_SEPARATOR . 'autoload.php';

use PHPUnit\Framework\TestCase;
use \PDO;
use TDD\ItemsTable;

class ItemsTableTest extends TestCase
{

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var ItemsTable
     */
    private $itemsTable;

    public function setUp()
    {
        $this->pdo = $this->getConnection();
        $this->createTable();
        $this->populateTable();

        $this->itemsTable = new ItemsTable($this->pdo);
    }

    public function tearDown()
    {
        unset($this->pdo);
        unset($this->itemsTable);
    }

    public function testFindById()
    {
        $id = 1;

        $result = $this->itemsTable->findById($id);

        $this->assertInternalType('array', $result, 'The result should always be an array.');
        $this->assertEquals($id, $result['id'], 'The id key/value of the result for id should be equal to the id.');
        $this->assertEquals(
            'Candy', $result['name'], 'The id key/value of the result for name should be equal to `Candy`.'
        );
    }

    public function testFindByIdMock()
    {
        $id = 1;

        $pdoStatement = $this->getMockBuilder('\PDOStatement')
            ->setMethods(['execute', 'fetch'])
            ->getMock();
        $pdoStatement->expects($this->once())
            ->method('execute')
            ->with([$id])
            ->will($this->returnSelf());
        $pdoStatement->expects($this->once())
            ->method('fetch')
            ->with($this->anything())
            ->will($this->returnValue('canary'));

        $pdo = $this->getMockBuilder('\PDO')
            ->setMethods(['prepare'])
            ->disableOriginalConstructor()
            ->getMock();
        $pdo->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT * FROM'))
            ->will($this->returnValue($pdoStatement));

        $itemsTable = new ItemsTable($pdo);

        $output = $itemsTable->findById($id);

        $this->assertEquals(
            'canary', $output,
            'The output for the mocked instance of the PDO and PDOStatement should produce the string `canary`.'
        );
    }

    protected function getConnection()
    {
        return new PDO('sqlite::memory:');
    }

    protected function createTable()
    {
        $query
            = "CREATE TABLE `items` (
                `id` INTEGER ,
                `name` TEXT,
                `price` REAL,
                PRIMARY KEY (`id`)
                ); ";
        $this->pdo->query($query);
    }

    protected function populateTable()
    {
        $query
            = "
        INSERT INTO `items` VALUES (1, 'Candy', 1.00);
        INSERT INTO `items` VALUES (2, 'TShirt', 5.34);
        ";
        $this->pdo->query($query);
    }

}