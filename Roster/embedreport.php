<?php
    include("../lib/lib.php");
    include("../misc/constants.php");
    $sid = $_GET['sid'];
    $datein = $_GET["datein"];
    $dateout = $_GET['dateout'];
    $pid = $_GET['pid'];
    
    echo "<center>".getStuReport($sid,$datein,$dateout,$pid)."</center>";
?>