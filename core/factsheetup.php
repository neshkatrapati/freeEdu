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
		document.getElementById("fail").innerHTML = "<div id='ufail'>One or More Fields Were Not Filled</div>";
		return false;
}
</script>
<body>
<div id='fail'></div>
<div class='php_content'>
<?php
echo "<center>";		
echo "<form action=\"#\" method=\"post\" enctype=\"multipart/form-data\" name='fcreate' id='fcreate' onsubmit='return validator()'>
<fieldset>
<legend>Create Faculty</legend>
<input type=\"file\" name=\"file\" />
<input type='submit' name='sub'/>
</fieldset>
</form>";
if(isset($_POST['sub']))
{
	$array = readExcel($newfile);
	for($i=0;$i<count($array);$i++)
	{
		$fname = $array[$i][0];
		$depname = $array[$i][1];
		$imgname = $array[$i][2];
		$bio = $array[$i][3];
		$login = $array[$i][4];
		$pass = $array[$i][5];

		if($fname!="" && $login!="" && $pass!="")
			addFaculty($fname,$depname,$imgname,$bio,$login,$pass);
		
	}
}
?>
</div>
</body>
<html>