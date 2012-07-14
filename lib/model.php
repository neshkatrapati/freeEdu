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
<<<<<<< HEAD
                $this -> colvars[] = $var;
=======
                $this -> colvars[$col] = $var;
>>>>>>> a470b63f9e103738c05dcc555176f0ba2f1802b6
                
            }
            
        }
<<<<<<< HEAD
        public function set($column_name,$value){
            
            
            $this -> $column_name = $value;
            
        }
        
=======

        public function set($parameters){

            foreach($parameters as $key => $value){

                $var = "COL_".strtoupper("$key");
                $this -> $var = $value;

            }


        }
        
        public function pack(){
			
				$pack = array();
				foreach($this->colvars as $key => $value){
						
						$pack[$key] = $this -> $value;
					
				}
				return $pack;
		
		}
        
>>>>>>> a470b63f9e103738c05dcc555176f0ba2f1802b6
        
        
    }

<<<<<<< HEAD
=======
	
>>>>>>> a470b63f9e103738c05dcc555176f0ba2f1802b6
?>