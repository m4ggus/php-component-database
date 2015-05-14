<?php

namespace Mib\Component\Database;
use Mib\Component\Database\Driver\Connection as ConnectionInterface;

class Connection
{
    private $conn;
    
    public function __construct(ConnectionInterface $conn)
    {
        $this->conn = $conn;
    }
    
    public function prepare($query)
    {
        return $this->conn->prepare($query);
    }
    
    public function query($query)
    {
        return $this->conn->query($query);
    }
    
    public function exec($query)
    {
        return $this->conn->exec($query);
    }
}