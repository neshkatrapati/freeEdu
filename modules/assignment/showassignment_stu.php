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
     echo "<th class='blue'>Subject</th>";
    echo "<th class='blue'>Created Date</th>";
   
    for($i=0;$i<count($entries);$i++)
    {
        
        echo "<tr>";
        echo "<td><a href='".$entries[$i]["Link"]."'>".$entries[$i]['Name']."</a></td>";
	 $asid = $entries[$i]["Id"];
        $subject = getSubject($entries[$i]['subid']);
        $subname =  $subject["subname"];
        $object = getObjectByType('2',$entries[$i]["subid"]);
        $oid = $object["oid"];
        echo "<td><a href='?m=p&id=".$oid."'>".$subname."</a></td>";
        echo "<td>".$entries[$i]["cdate"]."</td>";
        $asid = $entries[$i]["Id"];
    
        echo "</tr>";
        
        
    }
    echo "</table>";
    echo "</center></fieldset>";
}
else if(isset($_GET["asid"]))
{
        
	$asid = $_GET["asid"];
        $ass = getAssignment($asid);
	$object = getObject($_COOKIE["object"]);
	$student = getStudent($object["obhandle"]);
   	
        if(($student["batid"] == $ass["batid"]) && ($student["sec"] == $ass["sec"]))
	{
            echo "<a href='?m=ass_edit&asid=".$asid."' style='float:right;'>Edit This Assignment</a><br>";
            echo "<a href='".$ass["docpath"]."' style='float:right;' target='_blank'>Permalink</a><br>";
            echo "<a href='' onclick='printer()' value='Print' style='float:right;'>Print</a>";
            echo "<a href='?m=ass_see' style='float:left;'>Back</a>";
            
            echo "<div id='printarea'>";
            echo  getAssignmentContent($asid);
            echo "</div>";
        }
        else{
			notifyerr("You Are Unauthorised To View This Assignment");
			redirect("?m=ass_see");
		};
       
}
?>