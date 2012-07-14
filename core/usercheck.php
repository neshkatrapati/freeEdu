<?php
$q=$_GET['q'];
include_once("../lib/lib.php");
include_once("../lib/connection.php");

$val = queryMe("select count(oid) as cnt from MOBJECTT where ologin='".$q."'");
if($val["cnt"]=="0")
    echo 1;
else
    echo 2;
?>
