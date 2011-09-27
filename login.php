<html>
<head>
<script	 type="text/javascript" src="aux/thickbox/jquery.js"></script>
<script type="text/javascript" src="aux/thickbox/thickbox.js"></script>
<link rel="stylesheet" href="aux/thickbox/ThickBox.css" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="aux/demo.css"></link>
<link rel="stylesheet" type="text/css" href="aux/login.css"></link>
<title>FreeEdu-Login</title>
<link rel="icon" href="images/icon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="images/icon.png" type="image/x-icon" /> 
<?php
if(!isset($_POST['btnLogin']))
	{
		setcookie("object","",time()+60);
	}
?>
<script type="text/javascript">
function validator()
{
	var rotob = document.getElementById('rotate');
	
	var ologin = document.forms["login"]["ologin"].value
	var opass = document.forms["login"]["opass"].value
	if (ologin=="" || opass=="")
	{
		alert("Please Fill Required Fields.");
		document.getElementById("fail").innerHTML = "<div id='ufail'>One or More Fields Were Not Filled</div>";
		return false;
	}
}	
</script>

</head>
<body color=beige>
<center>
<div id="fail">
<?php
	

	if(isset($_POST['btnLogin']))
	{
		$ologin = $_POST['ologin'];
		$opass = $_POST['opass'];
		include("misc/constants.php");
		$clsname = "Constants";
		$batname = $clsname::$batname;
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass) or die(mysql_error());
		mysql_select_db($clsname::$dbname, $con);
		$result = mysql_query("SELECT oid FROM MOBJECTT where ologin='".$ologin."' and opwd='".$opass."'");
		$q = mysql_num_rows($result);
		if($q==0)
		{
			echo "<div id='ufail'>Username Password Conflict.</div>";
			
		}
		else
		{
			$row = mysql_fetch_array($result);
			setcookie('object',$row["oid"]);
			echo "<script type='text/javascript'>
			if(localStorage.prevurl!='')
			{
<<<<<<< HEAD
				window.location = localStorage.prevurl;
				localstorage.prevurl='index.php';
=======
				var setter = localStorage.prevurl;
				localStorage.prevurl='main/';
				window.location = setter;
				
>>>>>>> c4ede7fdb967fc8a1dcfbd8eaec0ae1bc6b8038e
			}
			else
				window.location = 'index.php';
			</script>";		
		
		}
	}	
?>	
<div id="additional">
</div>
<div id="formWrapper">
	<div id="formCasing">
		<center><img src='images/others/rotate.gif' id='rotate'></img></center>
		<h1><center>FreeEdu Login<center></h1>
		<div id="loginForm">	
			<form method="post" action="#" onsubmit="return validator()" name="login" id="login">
				<table>
				<tr><td><label for="ologin">Username</label></td>
				<td><input type="text" name="ologin" id="ologin" value="" style=''></input></td></tr><tr>
				<td><label for="opass">Password</label></td>
				<td><input type="password" name="opass" value=""></input></td>
				</table>
				<a href='doc/loginpage.php?var=1' class='thickbox'>Help</a><br><br>		
				<input type="submit" id="btnLogin" name="btnLogin" value="Submit">
				</form>		
				
		</div>
			
	</div>
	<div id="formFooter"></div>

</div>
</div>
</center>
</body>
</html> 
