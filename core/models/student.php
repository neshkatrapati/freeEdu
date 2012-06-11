<?php
require_once '../../lib/model.php';

class Student extends Model {
    
    public $table = "MSTUDENTT";
    
    public $columns = array(
                                array("colname" => "sid","value" => "100"),
                                array("colname" => "srno","value" => ""),
                                array("colname" => "sname","value" => ""),
                            
                            );    
    
    public function __construct(){
        
        parent::__construct($this -> table,$this -> columns);
       
        
    }
    
    
}

?>