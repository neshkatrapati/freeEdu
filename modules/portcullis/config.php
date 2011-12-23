<link rel="stylesheet" href="../../aux/bootstrap/bootstrap-1.0.0.css" type="text/css" media="screen" />
<?php
	require_once "../../lib/mod_lib.php";
	require_once "../../lib/lib.php";
	require_once "../../misc/constants.php";
	$auth = getAuthToken("portcullis");
	if(!isset($_POST['phase1'])){
	echo "<form action='#' method='post'>";
	echo "<center><div style='width:80%'><h3 class='box'>Welcome To Portcullis Config Page!</h3>";
	$auth = getAuthToken("portcullis");
	$stat = getConfigValue($auth,'dbname');
	if($stat != false){
		echo "<center><div style='width:80%'><h3 class='btn primary'>This Module Is Already Configured Properly!!</h3></div><br>";
	}
	echo "</div><div><table class='bttable' style='border:2px solid black'><tr><td>Database Name:</td><td><input type='text' name='dbname'></input></td></tr>
	<tr><td>Database User:</td><td><input type='text' name='dbuser'></input></td></tr>
	<tr><td>Database Pass:</td><td><input type='password' name='dbpass'></input></td></tr>
	<tr><td></td><td><input type='submit' class='btn primary' name='phase1'></input></td></tr></table></div>";
	echo "</center>";
	echo "</form>";
	}
	if(isset($_POST['phase1'])){
		$dbname = $_POST['dbname'];
		$dbuser = $_POST['dbuser'];
		$dbpass = $_POST['dbpass'];
		
			$auth = getAuthToken("portcullis");
			$conTest = mysql_connect("localhost",$dbuser,$dbpass);
			$conTest *= mysql_select_db($dbname);
			if($conTest){
				$st = addConfigKey($auth,"dbname",$dbname);
				$st *= addConfigKey($auth,"dbuser",$dbuser);
				$st *= addConfigKey($auth,"dbpass",$dbpass);
	            if($st)	{
					echo "<center><div style='width:80%'><h3 class='box'>Registration Successful!</h3></div></center>";
					redirect('?');
				}
				else{
			echo "<center><div style='width:80%'><h3 class='box'>Registration Unsuccessful!</h3></div></center>";
			redirect('?');
		}
			}
			else{
				echo "<center><div style='width:80%'><h3 class='box'>Unable to connect to database try again</h3></div></center>";
				redirect('?');
			
						
		}
		
	
	}
?>
