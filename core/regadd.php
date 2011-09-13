<html>
<head>
</head>
<body>
<fieldset  style="text-align:center;width:300;">
	<legend>Add A Regulation</legend>
	<form action='#' method='post'>
	<input type='text' name='regname' required=true><br>
	<input type='submit' name='phase1' value="Add Regulation">
	</form>
	<?php
	if(isset($_POST['phase1']))
	{
		$regname=$_POST['regname'];
		$array = mysql_query("SELECT regname from MREGT where regname like '".$regname."'");
		$num = mysql_num_rows($array);
		if($num == 0)
		{
			$reg=mysql_query('select * from MREGT');
			$num=mysql_num_rows($reg);
			mysql_query("insert into MREGT values('$num','$regname')");
			notify("Regulation Updated Succesfully!");
		}
		else
			notifyerr("That Regulation Already Exists!");
		
	}
?>
</fieldset>
</body>
</html>
