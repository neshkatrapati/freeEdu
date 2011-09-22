<?php
include("as_lib.php");

if(!isset($_GET["asid"]))
{
    echo "<center><fieldset><legend>Assignment List</legend>";
    $object = getObject($_COOKIE["object"]);
    $student = getStudent($object["obhandle"]);
   $entries = getAssignmentEntriesForBatch($student["batid"],$student["sec"]);
   //print_r($entries);
    echo "<table class='bttable' border='1'>";
    echo "<th class='blue'>Assignment Name</th>";
    
   
    for($i=0;$i<count($entries);$i++)
    {
        
        echo "<tr>";
        echo "<td><a href='".$entries[$i]["Link"]."'>".$entries[$i]['Name']."</a></td>";
        $asid = $entries[$i]["Id"];
    
        echo "</tr>";
        
        
    }
    echo "</table>";
    echo "</center></fieldset>";
}
else if(isset($_GET["asid"]))
{
        
	
	$asid = $_GET["asid"];
	
        echo "<a href='?m=ass_see' style='float:left;'>Back</a>";
	echo  getAssignmentContent($asid);
}
?>