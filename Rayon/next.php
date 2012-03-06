<?php
function nextUp()
{
include_once("../lib/connection.php");
include_once("check.php");
echo "<link rel='stylesheet' href='../aux/pagestyles/profiles.css' type='text/css' media='screen'>";
$bat = $_POST['bat'][0];
$barray = explode(':',$bat);
$brid = $barray[0];
$yoj = $barray[1];
echo "<h2 align=center>Select Student for Demotion</h2>";

$year=mysql_query("select * from MBATCHT where batyr='$yoj' and brid='$brid'");
while($batyr=mysql_fetch_array($year))
{
	$regid=$batyr[2];
	$batid=$batyr[0];
	$akyr=$batyr[4];
}
$reg=mysql_query("select * from MREGT where regid='$regid'");
while($REG=mysql_fetch_array($reg))
{
	$reg=$REG[1];
}
$student=mysql_query("select * from MSTUDENTT where batid='$batid'");
$rows=mysql_num_rows($student);
echo "<form action='check.php' method='post' align='center'>";

echo "<div align='center'>";
echo "<br><input type='submit' name='phase2'><br><br>";
while($s=mysql_fetch_array($student))
{
	$srno=$s[1];
	$sname=$s[2];
	$imgid=$s[5];
	$image=mysql_query("select * from MIMGT where imgid='$imgid'");
	while($img=mysql_fetch_array($image))
	{
		$imguri="../".$img[1];
	}
	$oidsql = mysql_query("SELECT oid from MOBJECTT where obhandle='".$srno."' and otyid='0'");
	$rarray = mysql_fetch_array($oidsql);
	$oid = $rarray['oid'];

	 echo "<a href='?m=p&id=".$oid."'>";	
	echo "<div class='img'>";
	  
    echo "<img src='".$imguri."' width='50' height='50' style='opacity:0.7;filter:alpha(opacity=40)'
	  onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
  	onmouseout='this.style.opacity=0.7;this.filters.alpha.opacity=60'>
	<div class='desc'><b><font color=#000000>$srno</b><br /><b></font><font color=#000000>".getFname($s['sname'])."</b></font><input type='checkbox' name='chk[]' value=$srno unchecked/></div></div></a>";
		
	
	
}
	

echo "<br></div>";
echo "<input type='hidden' name='batid' value='".$batid."' />";
echo "</form>";

}
?>

