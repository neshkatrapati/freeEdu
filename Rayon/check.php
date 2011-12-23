<?php
function cheker()
{
include("../lib/connection.php");
$rnum=array();
$detain=mysql_query("select count(did) as cnt from MDETAINT");
$didarray=mysql_fetch_array($detain);
$did=$didarray['cnt'];
$rnum=$_POST['chk'];
$batid = $_POST["batid"];

$year=mysql_query("select * from MBATCHT where batid='$batid'");
while($barray=mysql_fetch_array($year))
{
	$brid = $barray['brid'];
	$batyr = $barray['batyr'];
	$akyr=$barray['akayr'];
}
$len=count($rnum);
for($i=0;$i<$len;$i++)
	{
		$srno =$rnum[$i];
		$bat=mysql_query("select * from MBATCHT where batyr='$batyr'+1 and brid='$brid'");
		while($batch=mysql_fetch_array($bat))
		{
			$newbatid=$batch[0];
		}
		mysql_query("update MSTUDENTT set  batid='$newbatid' where srno='$srno'");
		mysql_query("update MSTUDENTT set  did='$did' where srno='$srno'");
		mysql_query("insert into MDETAINT values('$did','$srno','$batid','$newbatid','$akyr')");
		
			$did=$did+1;		
		
	}

mysql_query("update MBATCHT set akayr=akayr+1 where batid='$batid'");
mysql_query("update MSTUDENTT set tap='0' where batid='$batid'");
//mysql_query("update MBATCHT set akayr=akayr+1 where batid='$batid'");
mysql_query("delete from ADATAT where aid in (select aid from MATDT where batid like '".$batid."')");
mysql_query("delete from MATDT where batid like '".$batid."'");

notify("Updated Succesfully");
redirect("?");
} 
?>
