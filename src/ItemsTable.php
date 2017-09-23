<?php
/**
 * Created by PhpStorm.
 * User: Royal_PC
 * Date: 23-Sep-17
 * Time: 5:02 PM
 */

namespace TDD;

use \PDO;

class ItemsTable
{

    protected $table = 'items';

    protected $pdo;


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function __destruct()
    {
        unset($this->pdo);
    }

    public function findById($id)
    {
        $query     = "SELECT * FROM {$this->table} WHERE {$this->table}.id = ?";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$id]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}