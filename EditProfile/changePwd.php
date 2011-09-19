<html>
<head>
	<link rel="stylesheet" href="../aux/pagestyles/style.css" type="text/css" media='screen'>
</head>
<body>
<?php 
echo "<form action='#' method='post'>";
echo "<center>";
echo "<table>";
echo "<tr><td>Old Password*</td><td>:<input type='password' name='opswd'></td></tr>";
echo "<tr><td>New Password*</td><td>:<input type='password' name='npwd'></td></tr>";
echo "<tr><td>Confirm Password*</td><td>:<input type='password' name='cpwd'></td></tr></table>";
echo "<h4>Note:Please type the password minimum of 6 Charecters!</h4>";
echo "<input type='submit' name='pwd'>";
echo "</form>";
if(isset($_POST['pwd']))
{
	include("../lib/connection.php");
	$oid = $_COOKIE['object'];
	$opswd=$_POST['opswd'];
	$npwd=$_POST['npwd'];
	$cpwd=$_POST['cpwd'];
	echo $npwd;
	echo $opswd;
	echo $cpwd;
	$len=strlen($npwd);
	$pawd=mysql_query("select * from MOBJECTT where oid='$oid'");
	while($pass=mysql_fetch_array($pawd))
	{	
		$oldpwd=$pass['opwd'];
	}
	echo "1.".$opswd;
	echo "2.".$oldpwd."kofda";
	if($opswd==$oldpwd)
	{
		if($npwd==$cpwd && $len==0)
		{
			echo "<h3>Some fields are empty. Please fill them!</h3>";
			
		}
		else if($npwd==$cpwd && $len<6)
		{
			echo "<h3>The new password is less than 6 letters!</h3>";
		}	
		else if($npwd==$cpwd && $npwd!=NULL && $len>5)
		{
			mysql_query("update MOBJECTT set opwd='$npwd' where oid='$oid'");
			echo "<script type='text/javascript'>parent.location.reload(1);</script>";
		}
		else
		{
			echo "<h3>The Password Does not match</h3>";
		}
	}
	else if($opwd==NULL)
		{
			echo "<h3>Some fields are empty. Please fill them!</h3>";
		}
	
	else
	{
		echo "<h3>Authentication Failure</h3>";
	}

}
?>
</body>
</html>
