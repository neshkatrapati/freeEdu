<?php
include_once("../lib/lib.php");
	require_once("../lib/connection.php");
$q=$_GET['q'];
if($q=='b')
{
	echo getBatches('bat[]',"id='bat'");

}
if($q=='c')
{
	echo getClassesAsSelect('cls[]',"id='cls'");

}
?>
