<?php
	$q = $_GET['q'];
	include("../misc/constants.php");
	$exparray = explode(':',$q);
	$batid = $exparray[0];
	$clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
	$sql2 = "select * from MBATCHT where batid like '".$batid."'";
	$result2 = mysql_query($sql2);
	$abc = mysql_fetch_array($result2);
	$brid = $abc["brid"];
	$regid = $abc["regid"];
	$clsid = $abc["akayr"];
	$sql = "select subid,subname from MSUBJECTT 
	where suid like 
	(select subid from SAVAILT where brid like '".$brid."' 
	and regid like '".$regid."') and year like '".($clsid+1)."'";
	//echo $sql;
	$sqlresult = mysql_query($sql);

	echo "<select name='sub[][]'>";	
	while($row = mysql_fetch_array($sqlresult))
	{
		echo "<option value='".$row['subid']."'>".$row['subname']."</option>";
	
	}
	
	echo "</select>";	

?>
