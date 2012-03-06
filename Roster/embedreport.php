<?php
    include_once("../lib/lib.php");
    include_once("../lib/connection.php");
    $sid = $_GET['sid'];
    $datein = $_GET["datein"];
    $dateout = $_GET['dateout'];
    $pid = $_GET['pid'];
    
    echo "<center>".getStuReport($sid,$datein,$dateout,$pid)."</center>";
?>
