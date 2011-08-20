<html>
<body>
<center>
<h2>Update Manually</h2>
<form action="#" method="post">
<?php

if(!array_key_exists("batsub",$_POST) && !array_key_exists("phase2",$_POST))
{
	echo getBatches('bat[]')."<br /><br />";
	echo "<input type='submit' name='batsub' />";
} 
?>
</center>
<div id='php_next'>
<?php
include("next.php");
if(isset($_POST['batsub']))
{
	
	nextUp();
	
}
?>

<div id='php_check'>
<?php
include("check.php");
if(isset($_POST['phase2']))
{
	cheker();
	
}
?>
</div>
</div>
</form>

</body>
</html>
