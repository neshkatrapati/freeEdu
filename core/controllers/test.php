<?php

	require_once '../../lib/model.php';
	require_once '../models/object.php';
	require_once '../models/student.php';

	require_once '../../lib/connection.php';

	require_once '../../lib/controller.php';
	require_once '../../modules/groups/models/group.php';
	require_once '../controllers/objects_controller.php';
	require_once '../controllers/students_controller.php';

	$g = new Group();
	$g -> COL_NAME = "My Group";
	

	$oc = new ObjectsController();
	$myobject = $oc -> findBy("oid","10");
	echo $myobject -> COL_OBNAME."\n";

	$sc = new StudentsController();
	$onestudent = $sc -> findBy("sid","0");
	echo $onestudent -> COL_SNAME."\n";

?>