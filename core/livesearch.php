<?php
$q = $_GET['q'];

$q = strtoupper($q);
$t='';
if(array_key_exists('t',$_GET))
	$t = $_GET['t'];

include("../misc/constants.php");
include("../lib/lib.php");
$clsname = "Constants";
$batname = $clsname::$batname;
$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
mysql_select_db($clsname::$dbname, $con);
if($t=="")
{
	$sql = mysql_query("SELECT *,(select imguri from MIMGT  where imgid = oimgid) as img,(select tyname from OTYPET where tyid=otyid) as type FROM MOBJECTT WHERE obname LIKE '%".$q."%'");
	while($row = mysql_fetch_array($sql))
	{
		echo "<a href='?m=p&id=".$row['oid']."'>";	
		echo "<div class='img'>";
	 	echo "<img src='../".$row['img']."' width='50' height='50' style='opacity:0.8;filter:alpha(opacity=40)'
	  	onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
  		onmouseout='this.style.opacity=0.8;this.filters.alpha.opacity=20'>
		<div class='desc'><b><font color=#000000>".getFname($row['obname'])."</font></b><br><b><font color=#000000>".$row['type']."</b></font></div></div></a>";
	}
}
else if($t=='0')
{

	$matcher = "sname";
	$extra = "";
	if(array_key_exists('ip',$_GET))
	{
		$ip = $_GET['ip'];
		if($ip=='r')
			$matcher = "srno";	
	}
	if(array_key_exists('op',$_GET))
	{
		$op = $_GET['op'];
		if($op=='b')
		{
			$bat = $_GET['b'];
			$barray = explode(':',$bat);			
			$brid = 	$barray[0];
			$batyr = $barray[1];
			$batsql = mysql_query("SELECT batid FROM MBATCHT WHERE brid LIKE '".$brid."' AND batyr LIKE '".$batyr."'");
			$batarray = mysql_fetch_array($batsql);
			$batid = $batarray['batid'];	
			$extra = "  AND batid LIKE '".$batid."'";
		
		}
		else if($op == 'c')
		{
			//echo "Op exists";
			$bat = $_GET['c'];
			$barray = explode(':',$bat);			
			$batid = 	$barray[0];
			$secname = $barray[1];
			$extra = "  AND batid LIKE '".$batid."' AND sec LIKE '".$secname."'";
		
		}
	}
	$sql = mysql_query("SELECT *,(select imguri from MIMGT i where i.imgid = s.imgid) 
	as img,(select oid from MOBJECTT o where obhandle=s.sid and otyid='0') as oid ,(select batyr from MBATCHT d where d.batid=s.batid ) as batyr,(select akayr from MBATCHT d2 where d2.batid=s.batid) 
	as akayr FROM MSTUDENTT s WHERE ".$matcher." LIKE '".$q."%'".$extra);
	//echo $sql;
	while($row = mysql_fetch_array($sql))
	{
		echo "<a href='?m=p&id=".$row['oid']."'>";	
		echo "<div class='img'>";
		$akayr = $row['akayr']+1;
		$class = getFullClass($akayr)." ".$row['sec'];
		
	 	echo "<img src='../".$row['img']."' width='50' height='50' style='opacity:0.8;filter:alpha(opacity=40)'
	  	onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
  		onmouseout='this.style.opacity=0.8;this.filters.alpha.opacity=20'>
		<div class='desc'><b><font color=#000000>".getFname($row[$matcher])."</font></b><br><b><font color=#000000>".$class."</b></font></div></div></a>";
	}


}
else if($t=='2')
{

	$sql = mysql_query("SELECT *,(select imguri from MIMGT i where i.imgid = s.imgid) as img,(select oid from MOBJECTT o where obhandle=subcode and otyid='2') as oid  FROM MSUBJECTT s WHERE subname LIKE '".$q."%';
");
	
	while($row = mysql_fetch_array($sql))
	{
		echo "<a href='?m=p&id=".$row['oid']."'>";	
		echo "<div class='img'>";
	
		$akayr = $row['year'];
		$sql2 = mysql_query("SELECT (select brname from MBRANCHT br where br.brid=s.brid) as brid,(select regname from MREGT r where r.regid=s.regid) as regid from SAVAILT s where subid='".$row['suid']."'");
		$sarray = mysql_fetch_array($sql2);
		$brname = $sarray['brid'];
		$regname = $sarray['regid'];				
		$class = getFullClass($akayr);
		
	 	echo "<img src='../".$row['img']."' width='50' height='50' style='opacity:0.8;filter:alpha(opacity=40)'
	  	onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
  		onmouseout='this.style.opacity=0.8;this.filters.alpha.opacity=20'>
		<div class='desc'><b><font color=#000000>".getFname($row['subname'])."</font></b><br><b><font color=#000000>".$brname." ".$regname." ".$class."</b></font></div></div></a>";
	}


}
else if($t=='1')
{

	$query = "SELECT *,(select oid from MOBJECTT o where obhandle=fid and otyid='0') as oid,(select imguri from MIMGT i where i.imgid = s.imgid) as img  FROM MFACULTYT s WHERE fname LIKE '".$q."%'"; 
	$sql = mysql_query($query);
	
	while($row = mysql_fetch_array($sql))
	{
		echo "<a href='?m=p&id=".$row['oid']."'>";	
		echo "<div class='img'>";
	 	echo "<img src='../".$row['img']."' width='50' height='50' style='opacity:0.8;filter:alpha(opacity=40)'
	  	onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
  		onmouseout='this.style.opacity=0.8;this.filters.alpha.opacity=20'>
		<div class='desc'><b><font color=#000000>".getFname($row['fname'])."</font></b><br><b><font color=#000000>".$row['type']."</b></font></div></div></a>";
	}
}

?>