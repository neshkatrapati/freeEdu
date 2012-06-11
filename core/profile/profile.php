<html>
<head>
<style type="text/css">
div {background-color:#F5F5F5;}
body
{
background-image:url(http://www.harloff.com/healthcareCarts/ColorOptions/HAMMER-BLUE.jpg);
}
div.img
  {
  margin:2px;
  border:2px solid #555500;
  height:auto;
  width:auto;
  float:left;
  text-align:center;
 }
div.img img
  {
  display:inline;
  margin:3px;
  border:1px solid #ffffff;
  }
div.img a:hover img
  {
  border:1px solid #0000ff;
  }
div.desc
  {
  text-align:center;
  font-weight:normal;
  font-family:'Times New Roman';
  width:120px;
  margin:2px;
  }
</style>
</head>
<body>
<?php
$con=mysql_connect("localhost","root","1234");
mysql_select_db("freeEdu", $con);
$batyr=$_POST["batyr"];
$brid=$_POST["branch"];
$result = mysql_query("SELECT * FROM MBATCHT WHERE batyr=$batyr AND brid=$brid")  or die(mysql_error());
$row = mysql_fetch_array($result);
$val=$row['batid'];
$query = mysql_query("SELECT COUNT(*) FROM MSTUDENTT WHERE batid=$val") or die(mysql_error()); 
$row1 = mysql_fetch_array($query);
$count= $row1['COUNT(*)'];
/*
for($i=0;$i<$count;i++)
{
$con=mysql_connect("localhost","root","scooty.123");
mysql_select_db("freeEdu_db",$con);
*/
$result=mysql_query("SELECT * FROM MSTUDENTT WHERE batid=$val") or die(mysql_error());
while($row = mysql_fetch_array( $result ))
{
$result1 = mysql_query("SELECT * FROM MIMGT WHERE imgid IN (SELECT imgid FROM MSTUDENTT WHERE batid=$val) ") or die(mysql_error());
$row1 = mysql_fetch_array( $result1 );
?>
<div class="img">
<?php echo '<a href="iprofile.php?sid=' . $row['sid'] . '">'; ?> 
<?php echo '<img src="' . $row1['imguri'] . '" width="110" height="90" style="opacity:0.4;filter:alpha(opacity=40)"
onmouseover="this.style.opacity=1;this.filters.alpha.opacity=100"
onmouseout="this.style.opacity=0.4;this.filters.alpha.opacity=20" >'?></a>
<div class="desc"><b><font color=#000000><?php echo $row['srno']; ?></b></font></div></div>
<?php
}
mysql_close($con);
?>
</body>
</html>
