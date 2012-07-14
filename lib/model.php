<?php

    class Model {
        
                
        public function __construct($table,$columns){
            
            $this -> table = $table;
            $this -> columns = $columns;
            $this -> colvars = array();
            $this -> define_cols();
            
        }
        public function define_cols(){
            
            foreach($this -> columns as $column){
                
                $col = $column["colname"];
                $value = $column["value"];
                $var = "COL_".strtoupper("$col");
                $$var = $value;
                $this -> $var = $value;
                $this -> colvars[] = $var;
                
            }
            
        }
        public function set($column_name,$value){
            
            
            $this -> $column_name = $value;
            
        }
        
        
        
    }

?>