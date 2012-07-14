<?php
<<<<<<< HEAD


?>
=======
	
	class Controller {
		
			// CRUD
			public function __construct($model){
					
					$this -> model = $model;
				
			}
			public function create($params){
				
				// Create Query
				$query = "INSERT INTO ".$this -> model -> table." VALUES(";
				foreach ($params as $key => $value) {
					$type = gettype($value);
					if($type == "string")
						$pair = $key." '".$value."'";
					else
						$pair = $key.' '.$value;

					$query .= $pair.',';
				}
				$query = substr($query,0,-1);
				$query .= ")";
				echo $query;
				
			}
			public function createFromObject($object){
				
				return $this->create($object -> pack());
					
			}
			public function retrieve($columns = array("*"),$conditions = array()){
				

					$selectors = join($columns,",");
					$query = "SELECT $selectors FROM ".$this -> model -> table."";
					echo $query;


				
			}
			public function findBy($column,$value){

				$type = gettype($value);
				if($type == "string")
					$value = "'".$value."'";

				$query = "SELECT * FROM ".$this -> model -> table." WHERE $column = $value";
				echo $query;


			}
			public function raw_query($query){
				
				// Do Something
				
			}
			public function update($id,$object){
				
				// Update Query
			}
			public function delete(){
				
				
			}
			
		
	}

	

?>
>>>>>>> a470b63f9e103738c05dcc555176f0ba2f1802b6
