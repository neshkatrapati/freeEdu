<html>
<script type="text/javascript">
function validator()
{
	var fcreate = document.forms["fcreate"]
	if (fcreate['facname'].value=="" || fcreate['login'].value=="" || fcreate['pass'].value=="")
	{
		return alerter();
	}
}	
function alerter()
{
	alert("Please Fill Required Fields.");
		document.getElementById("messages").innerHTML = "<div id='noterr'>One or More Fields Were Not Filled</div>";
		return false;
}
</script>
<body>
<div id='fail'></div>
<div class='php_content'>
<?php

echo "<center>";
//Getting Branches And Regulations 
$placeBranch = "";
$Brret = getBranches();

for($i=0;$i<count($Brret);$i++)
			$placeBranch=$placeBranch."<option value='".$Brret[$i]."'>".$Brret[$i]."</option>";
			
echo "<form action=\"#\" method=\"post\" enctype=\"multipart/form-data\" name='fcreate' id='fcreate' onsubmit='return validator()'>
<fieldset>
<legend>Create Faculty</legend>
Name:&emsp;<input type='text' name=\"facname\" id='facname' /><br /><br />
Upload An Image:&emsp;<input type='file' name='file' id='file'/><br /><br />
Select A Department : <select name='brn[]' id='brn'>".$placeBranch."</select>"."<br /><br />
Loginname :&emsp;<input type='text' name='login'></input>&emsp;
Password :&emsp;<input type='password' name='pass'></input><br /><br />
About :<br /><textarea name='bio'></textarea><br /><br /> 
<input type='submit' />
</fieldset>
</form>";

$fname = $_POST['facname'];
$depname = $_POST['brn'][0];
$bio = $_POST['bio'];
$login = $_POST['login'];
$pass = $_POST['pass'];

if($fname!="" && $login!="" && $pass!="")
	addFaculty($fname,$depname,'null',$bio,$login,$pass);
	

?>
</div>
</body>
<html>