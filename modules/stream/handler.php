<?php
	require_once '../../lib/connection.php';
	require_once '../../lib/lib.php';
	require_once 'stlib.php';
	
	if($_GET["mode"] == "post"){
			
			$message = $_GET["msg"];
			$object = $_GET["object"];
			$targets = $_GET["targets"];
			
			postToStream($object,$message,$targets);
	}
	else if($_GET["mode"] == "get"){
		
		echo getStream($_GET["object"]);
	}
	else if($_GET["mode"] == "gets"){
		
		echo getStreamByObject($_GET["object"]);
	}
?>
