<?php
    
namespace Mib\Component\Database\Driver\MySQLi;
use Mib\Component\Database\Driver\Statement;
use Mib\Component\Database\Exception;

class MySQLiStatement implements Statement
{
    private $statement;
    
    private $query;
    
    public function __construct($statement, $query)
    {
        $this->statement = $statement;
        $this->query     = $query;
    }
    
    public function prepare($query)
    {
        $statement = $this->statement->prepare($query);
        
        if (!$statement) {
            throw new Exception(
                sprintf("[%s] %s", $this->statement->errno, $this->statement->error)
            );
        }
        
        $this->statement = $statement;
        $this->query     = $query;
    }
    
    public function execute(array $params = array())
    {
        if (!$this->statement->execute()) {
            throw new Exception($this->statement->error);
        }
        
        return new MySQLiResult($this->statement);
    }
}