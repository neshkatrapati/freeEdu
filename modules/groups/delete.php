<?php
    echo "delete";
 	f($_get["op"=="delete"]){
 		$g=new Group();
 	 $g->delete($id);
 	}	

?>
