<html>
<body>
<?php
$con=mysql_connect("localhost","root","maturi");
mysql_select_db("freeEdu", $con);
$sid=$_GET["sid"];
$res=mysql_query("SELECT * FROM MSTUDENTT WHERE sid=$sid") or die(mysql_error());
$ro = mysql_fetch_array( $res );
echo $ro['srno']. '  '.$ro['sname'].' '.$ro['scontact'].' '.$ro['sbio'] ;
?>
</body>
</html>





