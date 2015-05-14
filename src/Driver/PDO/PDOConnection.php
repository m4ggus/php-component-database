<?php
    
namespace Mib\Component\Database\Driver\PDO;
use Mib\Component\Database\Driver\Connection;

class PDOConnection implements Connection
{
    private $connection;
    
    public function __construct($hostname, $database, $username, $password)
    {        
        try {
            
            $dsn = sprintf('mysql:host=%s;dbname=%s', $hostname, $database);
            
            $pdo = new \PDO($dsn, $username, $password);
            
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            $this->connection = $pdo;
            
        } catch (\PDOException $exception) {
            
            throw new ConnectionException(
                sprintf("[%s] %s", $exception->getCode(), $exception->getMessage())
            );
            
        }
    }
    
    public function exec($query)
    {       
        try {
            
            return $this->connection->exec($query);
            
        } catch (\PDOException $exception) {
            
            throw new Exception(
                sprintf('[%s] %s', $exception->getCode(), $exception->getMessage())
            );
            
        }
    }
    
    public function prepare($query)
    {        
        try {
            
            $statement = $this->connection->prepare($query);
            
            return new PDOStatement($this->connection, $statement, $query);
            
        } catch (\PDOException $exception) {
            
            throw new Exception(
                sprintf('[%s] %s', $exception->getCode(), $exception->getMessage())
            );
            
        }               
    }
    
    public function query($query)
    {
        try {
            
            $res = $this->connection->query($query);
            
            return new PDOResult($res);
            
        } catch (\PDOException $exception) {
            
            throw new Exception(
                sprintf('[%s] %s', $exception->getCode(), $exception->getMessage())
            );
            
        }
    }
}