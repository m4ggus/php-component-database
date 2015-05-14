<?php
    
namespace Mib\Component\Database;
use Mib\Component\Database\Exception\ConfigException;

class ConnectionManager
{
    private static $availableDrivers = array(
        'mysqli' => 'Mib\Component\Database\Driver\MySQLi\MySQLiConnection',
        'pdo'    => 'Mib\Component\Database\Driver\PDO\PDOConnection'
    );
    
    private $connections;
    
    public function __construct()
    {
        $this->connections = array();
    }
    
    public function connect(array $config)
    {
        
        $requiredOptions = array('driver', 'hostname', 'database', 'username', 'password');
        
        foreach ($requiredOptions as $option) {
            if (!isset($config[$option])) {
                throw new ConfigException(
                    sprintf('missing option "%s"', $option)
                );
            }
        }
        
        $driver   = $config['driver'];
        $hostname = $config['hostname'];
        $database = $config['database'];
        $username = $config['username'];
        $password = $config['password'];
        
        if (!isset(self::$availableDrivers[$driver])) {
            throw new ConfigException(
                sprintf('unsupported driver "%s" for option "%s"', $driver, 'driver')
            );
        }
        
        $connection = new self::$availableDrivers[$driver]($hostname, $database, $username, $password);
        
        $this->connections[] = $connection;
        
        return $connection;
    }
    
    public function getConnection()
    {
        if (!count($this->connections)) {
            return null;
        }
        
        return $this->connections[0];
    }
}