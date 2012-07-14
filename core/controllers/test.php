<?php

	require_once '../../lib/model.php';
	require_once '../models/object.php';

	$o = new Object();
	$o -> COL_OBNAME = "Ganesh Katrapati";
	$o -> COL_OTYID = 10;
	print_r($o -> pack());


?>