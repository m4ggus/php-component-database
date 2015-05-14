<?php
    
namespace Mib\Component\Database\Driver\PDO;
use Mib\Component\Database\Driver\Result;

class PDOResult implements Result
{
    private $statement;
    
    public function __construct($statement)
    {
        $this->statement = $statement;
    }
    
    public function count()
    {
        return $this->statement->rowCount();
    }
    
    public function fetch()
    {
        return $this->statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}