<?php
    
namespace Mib\Component\Database\Driver;

interface Result
{
    public function fetch();
    
    public function count();
}