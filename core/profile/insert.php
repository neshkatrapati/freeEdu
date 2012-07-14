<html>
<body>
<?php
$con=mysql_connect("localhost","root","maturi");
mysql_select_db("freeEdu", $con);
$srno=$_GET['srno'];
$ros=$_GET['ros'];
$doex=$_GET['doex'];
$batyr=$_GET['batyr'];
$brid=$_GET['branch'];
$regid=$_GET['regid'];
$year=$_GET['year'];
$result2 = mysql_query(" SELECT * FROM MBATCHT WHERE brid=$brid AND batyr=$batyr ")  or die(mysql_error());
$row2 = mysql_fetch_array($result2);
$batid=$row2['batid'];
$query = mysql_query("SELECT COUNT(*) FROM MAVAILT") or die(mysql_error()); 
$row9 = mysql_fetch_array($query);
$mrid= $row9['COUNT(*)'];
mysql_query("INSERT INTO MAVAILT (mrid, batid, doex, ros, akayr) VALUES ($mrid, $batid, '$doex', '$ros', $year)");
for($i=0;$i<=11;$i++)
{
$subcode=$_GET['subcode'.$i];
$intm=$_GET['intm'.$i];
$extm=$_GET['extm'.$i];
$cre=$_GET['cre'.$i];
$result = mysql_query(" SELECT * FROM MSTUDENTT WHERE srno='$srno' ")  or die(mysql_error());
$row = mysql_fetch_array($result);
$sid=$row['sid'];
$result1 = mysql_query(" SELECT * FROM MSUBJECTT WHERE subcode='$subcode' ")  or die(mysql_error());
$row1 = mysql_fetch_array($result1);
$subid=$row1['subid'];
$query = mysql_query("SELECT COUNT(*) FROM MMARKST") or die(mysql_error()); 
$row8 = mysql_fetch_array($query);
$mid= $row8['COUNT(*)'];
mysql_query("INSERT INTO MMARKST (mid,sid, subid, intm, extm, cre, mrid) VALUES ($mid,$sid,$subid,$intm,$extm,$cre,$mrid)");
}
echo $srno.'   VALUES INSERTED';
?>
</body>
</html>
