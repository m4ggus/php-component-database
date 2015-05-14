<?php
    
namespace Mib\Component\Database\Driver\MySQLi;
use Mib\Component\Database\Driver\Connection;
use Mib\Component\Database\Driver\Exception;
use Mib\Component\Database\Exception\ConnectionException;

class MySQLiConnection implements Connection
{
    private $resource;
    
    public function __construct($host, $database, $username, $password, $port = null) 
    {
        $this->resource = new \MySQLi($host, $username, $password, $database, $port);
        
        if ($this->resource->connect_errno) {
            throw new ConnectionException(
                sprintf(
                    "Failed to connect to Database: [%s] %s",
                     $this->resource->connect_errno,
                     $this->resource->connect_error
                 )
            );
        } 
    }
    
    public function prepare($query)
    {
        $stmt = $this->resource->prepare($query);
        
        if (!$stmt) {
            throw new Exception(
                sprintf("[%s] %s", $this->resource->errno, $this->resource->error)
            );
        }
        
        return new MySQLiStatement($stmt, $query);
    }
    
    public function query($query)
    {
        $stmt = $this->prepare($query);
        
        if (!$stmt) {
            throw new Exception($this->resource->error);
        }
                
        return $stmt->execute();
    }
    
    public function exec($query)
    {
        $res = $this->resource->query($query);

        if (!$res) {
            throw new Exception($this->resource->error);
        }

        return $res->num_rows;
    }
}