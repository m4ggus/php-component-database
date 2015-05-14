<?php
    
namespace Mib\Component\Database\Driver\PDO;
use Mib\Component\Database\Driver\Statement;

class PDOStatement implements Statement
{
    private $connection;
    
    private $statement;
    
    private $query;
    
    public function __construct($connection, $statement, $query)
    {
        $this->connection = $connection;
        $this->statement  = $statement;
        $this->query      = $query;
    }
    
    public function prepare($query)
    {
        $this->statement = $this->connection->prepare($query);
        $this->query     = $query;
    }
    
    public function execute(array $params = array())
    {
        foreach ($params as $name => $value) {
            $this->statement->bindParam($name, $params[$name]);
        }
        
        if (!$this->statement->execute()) {
            $errorInfo = $this->statement->errorInfo();
            throw new Exception(
                sprintf("[%s] %s", $errorInfo[0], $errorInfo[2])
            );
        }
        
        return new PDOResult($this->statement);
    }
}