<?php
	
	require_once '../../lib/controller.php';
	require_once '../models/student.php';
	class StudentsController extends Controller{

		public function __construct(){

			parent::__construct(new Student());

		}

	}


?>
