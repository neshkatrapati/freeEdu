<?php
include_once("../lib/connection.php");
function fetchProfile($objectid)
{

	$query = "SELECT obname, (SELECT imguri FROM MIMGT i WHERE i.imgid = o.oimgid) img, obhandle FROM MOBJECTT o WHERE oid ='".$objectid."'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	echo "<h1>".$row['obname']."</h1>";
	echo "<img src='../".$row['img']."' width='200' height='200' />";
}
?>
