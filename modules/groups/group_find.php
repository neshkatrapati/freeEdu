<?php
	
	require_once '../modules/groups/group.php';
	
	$gid=$_GET['id'];
	
	$g = new Group();
	$glist = $g->find($gid);
	$imguri = $glist["imguri"]; 
	
	echo "<img src = '../".$imguri."' width='200' height='200'>";
?>
