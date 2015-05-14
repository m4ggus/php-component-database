<?php
    
namespace Mib\Component\Database\Driver;

interface Connection
{
    /**
     * @param string $query The sql query to prepare
     * @return Statement
     * @throws Exception
     */
    public function prepare($query);
    
    /**
     * @param string $query The sql query to query
     * @return array
     * @throws Exception
     */
    public function query($query);
    
    /**
     * @param string $query The sql query to execute
     * @return integer
     * @throws Exception
     */
    public function exec($query);
}