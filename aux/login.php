<html>
<head>
<link rel="stylesheet" type="text/css" href="aux/demo.css"></link>
<link rel="stylesheet" type="text/css" href="aux/login.css"></link>
<?php
setcookie("object","",time()-3600);
?>
<script type="text/javascript">
function validator()
{
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
	$q = $_GET['err'];
	$n = $_GET['new'];
	if($q==1)
		echo "<div id='ufail'>Username Password Conflict.</div>";
	else if($n==1)
	{

		require_once '../lib/connection.php';
		$result = mysql_query("SELECT oid FROM MOBJECTT");
		$result2 = mysql_query("SELECT fid FROM MFACTT");
		$num1 = mysql_num_rows($result);
		$num2 = mysql_num_rows($result2);

	}
		
?>	
<div id="additional">
</div>
<div id="formWrapper">
	<div id="formCasing">
		<h1><center>FreeEdu Login<center></h1>
		<div id="loginForm">	
			<form method="post" action="val.php" onsubmit="return validator()" name="login" id="login">
				<dt><label for="ologin">Username</label></dt>
				<dd><input type="text" name="ologin" id="ologin" value="Username"></input></dd>
				<dt><label for="opass">Password</label></dt>
				<dd><input type="password" name="opass" value="Password"></input></dd>
				<input type="image" src="login.gif" width="93" tabindex="4" height="40" id="btnLogin" name="btnLogin"></dd>
				</form>			
		</div>
		
			
		
		
	
		
	</div>
	<div id="formFooter"></div>

</div>
</div>

</center>
</body>
</html> 
