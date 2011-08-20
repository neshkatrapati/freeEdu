<html>
<head>
<link rel="stylesheet" type="text/css" href="demo.css"></link>
<link rel="stylesheet" type="text/css" href="login.css"></link>
<center>
<?php
echo "<div class='herebox' style='position:relative;top:0'>
<a href='home.php'>Home</a>
</div>";
$oid = $_COOKIE["object"];
$con = mysql_connect("localhost","root","1234");
mysql_select_db("freeedu", $con);
$result = mysql_query("SELECT otype FROM MOBJECTT where oid='".$oid."'");
$row = mysql_fetch_array($result);
$tid = $row["otype"];
$result = mysql_query("SELECT tymas FROM OTYPET where tid='".$tid."'");
$row = mysql_fetch_array($result);
$tymas = $row["tymas"];
$query = "SELECT * FROM ".$tymas." where fid='".$tid."'";
$result = mysql_query($query);
$u = $_GET['upd'];
if($u==1)
{	
	$row = mysql_fetch_array($result);
	for($i=0;$i<count($row)/2;$i++)
	{
		$fname = mysql_field_name($result,$i);
		$query = "update ".$tymas." set ".$fname."='".$_POST[$fname]."' where fid='".$tid."'";
		mysql_query($query);


	}
	echo "<script type='text/javascript'>window.location='edit.php'</script>";

}
echo "<div id='additional'>
</div><div id='formWrapper'>
	<div id='formCasing'>";
echo "<form id='edit' action='edit.php?upd=1' method='post'>";

echo "<table>";
while($row = mysql_fetch_array($result))
{
	
	for($i=0;$i<count($row)/2;$i++)
	{
		$fname = mysql_field_name($result,$i);
		if($fname == "fbday")
			$type="date";
		else if($fname == "fexp" || $fname == "fbio")
			$type="textarea";		
		else
			$type="text";
		
		if($fname!="fid")
		echo "<tr><td><font color='red'><b>".$fname."</b></font></td><td><input type='".$type."' value='".$row[$i]."' name='".$fname."'></input></td></tr>";
	}


}
echo "</table><br /><input type='image' src='done.gif' width='93' tabindex='4' height='40'></div></form><div id='formFooter'></div></div></div>";
?>
</center>
</head>
</html>
