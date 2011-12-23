<link rel="stylesheet" href="../../aux/bootstrap/bootstrap-1.0.0.css" type="text/css" media="screen" />
<?php
	require_once "../../lib/mod_lib.php";
	require_once "../../lib/lib.php";
	require_once "../../misc/constants.php";
	$auth = getAuthToken("feedback");
	if(!isset($_POST['phase1'])){
		
	echo "<form action='#' method='post'>";
	echo "<center><div style='width:80%'><h3 class='box'>Welcome To Feedback-Module Config Page!</h3>";
	$auth = getAuthToken("feedback");
	$stat = getConfigValue($auth,'maxrating');
	if($stat != false){
		echo "<center><div style='width:80%'><h3 class='btn primary'>This Module Is Already Configured Properly!!</h3></div><br>";
	}
	echo "</div><div><table class='bttable' style='border:2px solid black'><tr><td>Max Rating:</td><td><input type='text' name='maxrating'></input></td></tr>
	<tr><td></td><td><input type='submit' class='btn primary' name='phase1'></input></td></tr></table></div>";
	echo "</center>";
	echo "</form>";
	}
	if(isset($_POST['phase1'])){
		$maxrating = $_POST['maxrating'];
		$auth = getAuthToken("feedback");
			$st = addConfigKey($auth,"maxrating",$maxrating);
		    if($st){
				echo "<center><div style='width:80%'><h3 class='box'>Configuration Successful!</h3></div></center>";
				redirect('?');
			}
			else{
			echo "<center><div style='width:80%'><h3 class='box'>Configuration Unsuccessful!</h3></div></center>";
			redirect('?');
			}
		
	
	}
?>

