<?php

	require_once '../../lib/connection.php';
	require_once 'group.php';
	
	$p=new post();
	$p->create("1","5","first post","testing","6,7,2012");
	$p->create("0","13","second post","coding","7,10,2002");
	$array=$p->posts_by_group("0");
	print_r($array);
	echo $array[5];
		

	


?>
