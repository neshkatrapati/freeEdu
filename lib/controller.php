<?php
	
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
				//echo $query;

				$result = mysql_query($query);

				$results = array();
				while ($row = mysql_fetch_array($result)) {
					$m = new Model($this->model->table,$this->model->columns);
					$m -> set($row);
					$results[] = $m;
				}
				if(count($results) == 1)
						return $results[0];
				return $results;

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

