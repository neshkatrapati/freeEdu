<?php
function showProfile($oid)
{
	
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
	if($otyid == "2")
	{
		//echo "select (select imguri from MIMGT i where i.imgid=s.imgid) as imguri from MSUBJECTT s where subcode='".$obhandle."'";
		$array1 = queryMe("select (select imguri from MIMGT i where i.imgid=s.imgid) as imguri from MSUBJECTT s where subid='".$obhandle."'");
		$imguri = "../".$array1["imguri"];
		//echo $obhandle;
		$wr = queryMe("select subname from MSUBJECTT where subid like '".$obhandle."'");
		$subname = $wr["subname"];
		if(getImgUri($image)=="images/others/book.jpg")
		{
			echo "<a href='../core/immapind.php?subid=".$obhandle."' target='_blank' class='nyroModal' title='Select A Book For ".$subname."'>Find Book Cover</a>";
		//echo "<a href='../core/immapind.php?subid=".$obhandle."'&KeepThis=true&TB_iframe=true&#TB_inline class='thickbox'> Find Book Cover</a><br/>";
		}
		
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


