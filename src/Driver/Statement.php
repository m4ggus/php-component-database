<?php
    
namespace Mib\Component\Database\Driver;

interface Statement
{
    public function prepare($query);
    
    public function execute(array $params = array());
}