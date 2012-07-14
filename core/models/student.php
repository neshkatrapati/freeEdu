<?php
require_once '../../lib/model.php';

class Student extends Model {
    
    public $table = "MSTUDENTT";
    
    public $columns = array(
<<<<<<< HEAD
                                array("colname" => "sid","value" => "100"),
                                array("colname" => "srno","value" => ""),
                                array("colname" => "sname","value" => ""),
=======
                                array("colname" => "sid","value" => ""),
                                array("colname" => "srno","value" => ""),
                                array("colname" => "sname","value" => ""),
                                array("colname" => "scontact","value" => ""),
                                array("colname" => "sbio","value" => ""),
                                array("colname" => "imgid","value" => ""),
                                array("colname" => "batid","value" => ""),
                                array("colname" => "sec","value" => ""),
                                array("colname" => "did","value" => ""),
                                array("colname" => "tap","value" => ""),
>>>>>>> a470b63f9e103738c05dcc555176f0ba2f1802b6
                            
                            );    
    
    public function __construct(){
        
        parent::__construct($this -> table,$this -> columns);
<<<<<<< HEAD
       
        
    }
    
    
}

?>
=======
         
    }
    

    
}


?>
>>>>>>> a470b63f9e103738c05dcc555176f0ba2f1802b6
