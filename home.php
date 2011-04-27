<html>
<head>
<link rel="stylesheet" type="text/css" href="demo.css"></link>
<div class="herebox" style="text-align:left;position:relative;right:-1090;top:0">
<a href="login.php" >Logout</a>
</div>
<div id='formWrapper'>
	<div id='formCasing'>
		<div>
			<a href="edit.php">Edit Profile</a>
		</div>
	</div>
</div>
<div id='formFooter'>
</div>
<?php
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

echo "<div id='additional'>
</div><div id='formWrapper'>
	<div id='formCasing'><div id='meta'>";
while($row = mysql_fetch_array($result))
{
	
	for($i=0;$i<count($row);$i++)
	{
		if($row[$i]!="")
			echo "<b>".mysql_field_name($result,$i)."</b>:".$row[$i]."<br />";
	}


}
echo "</div></div><div id='formFooter'></div></div>";
?>
</center>
<body>

</body>
</head>
</html>
