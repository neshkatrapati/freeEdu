<?php
function showProfile($oid)
{
	include("../lib/connection.php");
	$imgid=mysql_query("select * from MOBJECTT where oid='$oid'");
	
	while($img=mysql_fetch_array($imgid))
	{
		$obname =$img['obname'];
		$opwd=$img['opwd'];
		$image=$img['oimgid'];
		$otyid=$img['otyid'];
		$obhandle=$img['obhandle'];
	}
	
	if($otyid!="4")
	{
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

echo "<a href='?m=ep'><img src='$imguri' width='$width' height='$height' border='1'/></a>";
echo "<a href='?m=ep'><h3>$obname</h3></a>";

}
function showProf($oid)
{
	include("../lib/connection.php");
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
	
echo "<img src='$imguri' width='$width' height='$height' border='1'/>";
echo "<h3>$obname</h3>";

}
?>


