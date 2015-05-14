<?php
       
namespace Mib\Component\Database\Driver\MySQLi;
use Mib\Component\Database\Driver\Result;

class MySQLiResult implements Result
{
    public function __construct($statement)
    {
        $this->statement = $statement;     
    }
    
    public function fetch()
    {        
        $row    = array();        
        $data   = array();
        $result = array();
var_dump($this->statement);
        $meta = $this->statement->result_metadata();
        
        while ($column = $meta->fetch_field()) {
            $row[] = &$data[$column->name];
        }
        
        call_user_func_array(array($this->statement, 'bind_result'), $row);
        
        while ($this->statement->fetch()) {
            $result[] = $this->array_clone($data);
        }        
        
        return $result;         
    }
    
    public function count()
    {
        return $this->statement->num_rows;
    }
    
    private function array_clone(array $arr) {
        $clone = array();
        
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $clone[$key] = array_clone($val);
            } elseif (is_object($val)) {
                $clone[$key] = array_clone((array)$val);
            } else {
                $clone[$key] = $val;
            }
        }
        
        return $clone;
    }
}