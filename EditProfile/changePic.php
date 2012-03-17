<html>
<head>
</head>
<body>
<?php
require_once '../lib/connection.php';
$oid = $_COOKIE['object'];
echo "Select an image file on your computer (1MB max):<br>";
echo "<form name='newad' method='post' enctype='multipart/form-data' action='#'>";
echo "<input type='file' name='image'><br><br>";
echo "<input name='Submit' type='submit' value='Upload image'>";
echo "</form>";
$MAX_SIZE=1000; 
$errors=1;


if(isset($_POST['Submit'])) 
 { 	$image=$_FILES['image']['name'];
 	if($image!="") 
 	{
 		$filename = stripslashes($_FILES['image']['name']);
 		$extension = getExtension($filename);
		$extension = strtolower($extension);
		if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
 		{
			echo '<h2>Unknown extension!</h2>';
			$errors=1;
 		}
 		else
 		{
			$size=filesize($_FILES['image']['tmp_name']);
			if ($size > $MAX_SIZE*1024)
			{	
				echo '<h2>You have exceeded the size limit!</h2>';
				$errors=1;
			}
			$image_name=time().'.'.$extension;
			$newname="../images/faces/".$image_name;
			echo $newname;
			$imguri="images/faces/".$image_name;
			$copied = copy($_FILES['image']['tmp_name'], $newname);
			if (!$copied)
			{
				echo '<h2>Copy unsuccessfull!</h2>';
				$errors=1;
			}
			else
			{
				$errors=0;
			}

		}
	}
	else
	{
		echo "<h2>No Image Selected</h2>";
	}
}
if(isset($_POST['Submit']) && !$errors) 
{	

	$s=mysql_query("select obhandle from MOBJECTT where oid='$oid'");
	$student=mysql_fetch_array($s);
	$sid=$student['obhandle'];
	$img=mysql_query("select * from MIMGT");
	$num=mysql_num_rows($img);
	mysql_query("insert into MIMGT values('$num','$imguri')");
	mysql_query("update MOBJECTT set oimgid='$num' where oid='$oid'");
	mysql_query("update MSTUDENTT set imgid='$num' where sid='$sid'");
	echo "<script type='text/javascript'>parent.location.reload(1);</script>";

}
?>
</body>
</html>
