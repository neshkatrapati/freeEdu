<?php 
class Object extends Model { 
	public $table = "MOBJECTT";
	public $columns = array(
		array("colname" => "oid","type" => "text","value" => ""),
		array("colname" => "obname","type" => "text","value" => ""),
		array("colname" => "obhandle","type" => "text","value" => ""),
		array("colname" => "otyid","type" => "text","value" => ""),
		array("colname" => "oimgid","type" => "text","value" => ""),
		array("colname" => "ologin","type" => "text","value" => ""),
		array("colname" => "opwd","type" => "text","value" => ""),
		array("colname" => "oref","type" => "text","value" => ""),
	);
	public function __construct(){
		parent::__construct($this -> table,$this -> columns);
	}
}
?>