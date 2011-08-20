<html>
<center>
<form action='#' method='post'>
<fieldset>
	<legend>Design Schedules</legend>
<?php
if(!isset($_POST['mainsub']) && !isset($_POST['phase2']))
{
	
	echo "Select A Class: ";	
	echo getClassesAsSelect('cls','');
	echo "<br /><br />Select Maximum Number Of Classes: <input type='number' name='clsnum' value='6'></input><br><br /><br />
<input type='submit' name='mainsub'></input><br />";
}
?>

</form>

<div id='php_sc_phase2'>
<?php

if(isset($_POST['mainsub']))
{
	
	echo "<form action='#' method='post'>";
	$bat = $_POST['cls'];
	
	$batdet = explode(":",$bat);
	$batid = $batdet[0];
	$sec = $batdet[1];
	$npo = $_POST["clsnum"];
	echo mapPeriods($batid,$sec,$npo);
	echo "<input type='hidden' name='batid' value='".$batid."'>";
	echo "<input type='hidden' name='sec' value='".$sec."'>";
	echo "<input type='hidden' name='clsnum' value='".$npo."'>";
	echo "<br /><input type='submit' name='phase2'></form>";
	
	
}
?>
</div>
<div id='php_sc_phase3'>
<?php
if(isset($_POST['phase2']))
{
	
	echo "<form action='#' method='post'>";	
	$batid = $_POST["batid"];
	$sec = $_POST['sec'];
	$clsnum = $_POST['clsnum'];
	putPeriods($batid,$sec,$clsnum,$_POST['inputs'],$_POST['outputs']);
	echo getSchedule($batid,$sec,$clsnum);
	echo "<input type='hidden' name='batid' value='".$batid."'></input>";
	echo "<input type='hidden' name='sec' value='".$sec."'></input>";
	echo "<input type='hidden' name='clsnum' value='".$clsnum."'></input>";
	echo "<input type='submit' name='phase3'></input></form>";
	
}
?>
</div>
<div id='phase4'>
<?php
	if(isset($_POST['phase3']))
	{
		
	$clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
	$sub = $_POST['sub'];
	$clsnum = $_POST['clsnum'];
	$sec = $_POST['sec'];
	$batid = $_POST['batid'];
	for($i=0;$i<6;$i++)
	{
		$str = "";
		for($j=0;$j<$clsnum;$j++)
		{
			$subid = $sub[($i*$clsnum)+$j][0];
			$str .=  $subid.";";
			
		}
		$sql = "INSERT INTO MSCHEDULET(weekid,batid,sec,sessionstring) VALUES('".$i."','".$batid."','".$sec."','".$str."')";
		mysql_query($sql);
		
	}
	notify("Schedule Designed Succesfully.");	
	
}
?>
</div>
</center>
</fieldset>
</html>
