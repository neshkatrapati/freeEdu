<?php
$q = $_GET['q'];
echo "Hello";
include("../misc/constants.php");
$clsname = "Constants";
$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
mysql_select_db($clsname::$dbname, $con);

$sql = "SELECT * FROM MOBJECTT where obname LIKE '".$q."%'";
echo $sql;
$result = mysql_query($sql);
while ($row = mysql_fetch_rows($result))
{
	echo "<a href='?m=p&id=".$row['oid']."'>".$row['obname']."</a>";

}
?>
