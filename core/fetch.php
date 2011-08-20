<?php

$q  = $_GET['q'];

if($q == 'all')
	$q = "";
	
$br = $_GET['br'];
$q = strtoupper($q);
$clsname = "Constants";
$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
mysql_select_db($clsname::$dbname, $con);

if($br == "%")
	$deptid = $br;
else
{
	$result = mysql_query("SELECT brid FROM MBRANCHT WHERE brname LIKE '".$br."'");
	$row = mysql_fetch_array($result);
	$deptid = $row["brid"];
}
		

$sql = "SELECT fname,fid,imgid from MFACULTYT where fname LIKE '".$q."%' AND deptid LIKE '".$deptid."%'";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result))
{
	$isql = "SELECT imguri from MIMGT WHERE imgid='".$row['imgid']."'";
	$iresult = 	mysql_query($isql);
	$irow = mysql_fetch_array($iresult);
	
	$osql = "SELECT oid FROM MOBJECTT where obhandle='".$row['fid']."' AND otyid='1'";
	$oresult = 	mysql_query($osql);
	$orow = mysql_fetch_array($oresult);
	$oid = $orow['oid'];
	
	echo "<div class='padd'><a href='../main/?m=p&id=".$oid."'><img src='../".$irow['imguri']."' width='50' height='50'></a>&emsp;".$row['fname']."</div><br />";

}

?>