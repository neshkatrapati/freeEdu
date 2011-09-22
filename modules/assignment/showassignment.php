<?php
include("as_lib.php");

if(!isset($_GET["asid"]))
{
    echo "<center>";    
   $entries = getAssignmentEntries($_COOKIE["object"]);
   //print_r($entries);
    echo "<table class='bttable' border='1'>";
    echo "<th class='blue'>Assignment Name</th>";
    echo "<th class='blue'>Actions</th>";
   
    for($i=0;$i<count($entries);$i++)
    {
        
        echo "<tr>";
        echo "<td><a href='".$entries[$i]["Link"]."'>".$entries[$i]['Name']."</a></td>";
        $asid = $entries[$i]["Id"];
        echo "<td><a href='?m=ass_see&asid=".$asid."'>See</a>|<a href='?m=ass_edit&asid=".$asid."'>Edit</a></td>";
        echo "</tr>";
        
        
    }
    echo "</table>";
    echo "</center>";
}
else if(isset($_GET["asid"]))
{
        
	
	$asid = $_GET["asid"];
	echo "<a href='?m=ass_edit&asid=".$asid."' style='float:right;'>Edit This Assignment</a>";
        echo "<a href='?m=ass_see' style='float:left;'>Back</a>";
	echo  getAssignmentContent($asid);
}
?>