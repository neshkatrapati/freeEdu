<html>
<head>
<style type='text/css'>
.imgteaser {
	margin: 0;
	overflow: hidden;
	float: left;
	position: relative;
}
.imgteaser a {
	text-decoration: none;
	float: left;
}
.imgteaser a:hover {
	cursor: pointer;
}
.imgteaser a img {
	float: left;
	margin: 0;
	border: none;
	padding: 10px;
	background: #fff;
	border: 1px solid #ddd;
}
.imgteaser a .desc {	display: none; }
.imgteaser a:hover .epimg { visibility: hidden;}
.imgteaser a .epimg {
	position: absolute;
	right: 10px;
	top: 10px;
	font-size: 12px;
	color: #fff;
	background: #000;
	padding: 4px 10px;
	filter:alpha(opacity=65);
	opacity:.65;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=65)";
	
}
.imgteaser a:hover .desc{
	display: block;
	font-size: 11px;
	padding: 10px 0;
	background: #111;
	filter:alpha(opacity=75);
	opacity:.75;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=75)";
	color: #fff;
	position: absolute;
	bottom: 11px;
	left: 11px;
	padding: 4px 10px;
	margin: 0;
	width: 125px;
	border-top: 1px solid #999;
	
}
.pos
{
	position:absolute;
	top:91px;
	left:350px;
	
}
.form
{
	position:absolute;
	left:410px;	
}

</style>
<body align=center>
<?php
include("../lib/connection.php");
$oid = $_COOKIE['object'];
$imgid=mysql_query("select * from MOBJECTT where oid='$oid'");
while($img=mysql_fetch_array($imgid))
{
	$obname =$img['obname'];
	$opwd=$img['opwd'];
	$image=$img['oimgid'];
	$otyid=$img['otyid'];
	$obhandle=$img['obhandle'];
}
$obj=mysql_query("select * from OTYPET where tyid='$otyid'");
while($object=mysql_fetch_array($obj))
{	
	$table=$object['tytab'];
	$matcher=$object['matcher'];
}
$ob=mysql_query("select * from ".$table." where ".$matcher."=".$obhandle);
while($mat=mysql_fetch_array($ob))
{
	$bio=$mat[3];
}

$imgurl=mysql_query("select imguri from MIMGT where imgid='$image'");
while($imgur=mysql_fetch_array($imgurl))
{
	$imguri="../".$imgur[0];
}
list($width, $height, $type, $attr) = getimagesize($imguri);
if($width>$height)
{
	$width=200;
	$height=150;
}
else if($width<$height)
{
	$width=150;
	$height=200;
}
else
{
	$width=200;
	$height=200;
}

echo "<a href='?m=fbimage' title='Image For ".$obname."'>Merge With Your Facebook Image!</a><br><br/>";
echo "<div class='imgteaser' style='border:1px'><a href='../EditProfile/changePic.php?KeepThis=true&TB_iframe=true&#TB_inline?width=300&height=200' title='Change Picture' class='thickbox'><img src='$imguri' width='$width' height='$height' /><span class='epimg'>&raquo; Change Picture</span><span class='desc' class='strong'>Click to change the picture
	</span></a></div>";
echo "<div class='pos'><a href='../EditProfile/changePwd.php?KeepThis=true&TB_iframe=true&#TB_inline?width=100&height=220' title='Change Password' class='thickbox'>Change Password</a></div>
<form action='#' method='post' class='form'> 
<fieldset style='width:350' align='center'>
	<legend align='left'>Edit Profile</legend>
	Name:<input type='text' name='name' size='30' value='$obname' ><br>
	About Me:<br><textarea name='aboutme' cols='30' rows='10' >$bio</textarea><br><br>	
	<input type='submit' value='Update' name='update'/>
</fieldset>
</form>";

if(isset($_POST['update']))
{	
	$name=$_POST['name'];
	$bio=$_POST['aboutme'];
	mysql_query("update ".$table." set fname='".$name."' where ".$matcher."='".$obhandle."'");
	mysql_query("update ".$table." set fbio='".$bio."' where ".$matcher."='".$obhandle."'");
	mysql_query("update MOBJECTT set obname='$name' where oid='$oid'");
	echo "<script type='text/javascript'>alert('Updated Successfully!'); window.location='index.php?m=ep'; </script>";
}	
?>
</body>
</html>
