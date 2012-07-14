<?php
class Group
{
 	public function create($name,$imgid,$date,$mem)
       {
        	$query="SELECT max(id) as max from groups";
        	$result=mysql_query($query);
		      $arr = mysql_fetch_array($result);
		
        	$id= $arr["max"]+1;
          $query="INSERT INTO groups VALUES($id,'$name','$imgid','$mem','$date');";
          return mysql_query($query);
       
    	 }
       public function groups_by_object($oid) {
       
           $query="SELECT *,(SELECT imguri from MIMGT i where i.imgid = g.imgid) imguri  FROM groups g WHERE mem LIKE '%,$oid,%' ";
           $result=mysql_query($query);
           $retarray=array();
           while($row=mysql_fetch_array($result)){
           	$retarray[]=$row;
           }


           return $retarray;
        }
 	public function find($id){

		$query = "SELECT *,(SELECT imguri from MIMGT i where i.imgid = g.imgid) imguri FROM groups g where id = $id ";
		$result = mysql_query($query);
		return mysql_fetch_array($result);
	}
       public function update($id,$mem,$name,$imgid) {
            
           $query="update groups set mem='$mem',imgid='$imgid',name='$name' where id=$id";
           $result=mysql_query($query);

        }

       public function delete($id) {
        
           $query="DELETE from groups where id=$id";
           $result=mysql_query($query);
            

        }
}
?>
