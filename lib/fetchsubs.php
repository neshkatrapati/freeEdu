<?php
	$q = $_GET['q'];
	include("../misc/constants.php");
	$exparray = explode(':',$q);
	$brid = $exparray[0];
	$clsid = substr($exparray[1],0,1);
	$clsid = $clsid - 1;
	$clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
	$sql = "select subid,subname from MSUBJECTT 
	where suid like 
	(select subid from SAVAILT where brid like '".$brid."' 
	and regid like 
	(select regid from MBATCHT where akayr='".$clsid."' and brid like '".$brid."')) and year like '".($clsid+1)."'";

	$sqlresult = mysql_query($sql);

	echo "<select name='sub[][]'>";	
	while($row = mysql_fetch_array($sqlresult))
	{
		echo "<option value='".$row['subid']."'>".$row['subname']."</option>";
	
	}
	
	echo "</select>";	

?>
