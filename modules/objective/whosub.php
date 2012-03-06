<link rel="stylesheet" href="../../aux/bootstrap/bootstrap-1.0.0.css" type="text/css" media="screen" />
<?php
    
    include_once("ob_lib.php");
    include_once("../../lib/lib.php");
    include_once("../../lib/connection.php");
    
    $otid = $_GET["otid"];
    $subs = getSubmissionsForOtid($otid);
    echo "<table class='bttable' >";
    echo "<th class='zebra-striped'></th>"; 
    echo "<th class='zebra-striped' colspan='2'>Student Name</th>";
    echo "<th class='zebra-striped'>Submission date</th>";
    echo "<th class='zebra-striped'>Result</th>";
    for($i=0;$i<count($subs);$i++)
    {
        echo "<tr>";
        $sid = $subs[$i]["Student"]["sid"];
        $oid = getObjectByType("0",$sid);   
        echo "<td><td><img src='../".$subs[$i]["Student"]["img"]."' width='50' height='50'></img></td>
        <td><a href='?m=ot_submit_see&otid=".$otid."&oid=".$oid["oid"]."'>".$subs[$i]["Student"]["sname"]."</td>";
        echo "<td>".$subs[$i]["date"]."</td>";
        echo "<td>".$subs[$i]["result"]."</td>";
        
        echo "</tr>";
    }
    echo "</table>";
?>
