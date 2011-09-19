<?php
include("fb_lib.php");
if(!isset($_POST["phase1"]) && !isset($_GET["fbid"]))
{
    echo "<form action='#' method='post'>";
    echo "Select By ".getClassesAsSelect("bat[]")."&emsp;";
    echo "<br><br><input type='submit' name='phase1'/>";
    echo "</form>";
    
}
else if(!isset($_GET["fbid"]))
{
    $bat = $_POST['bat'][0];
    $barray = explode(':',$bat);
    $batid = $barray[0];
    $sec = $barray[1];
    $object = getObject($_COOKIE["object"]);
    $student = getStudent($object["obhandle"]);
    
   $entries = getFeedbackEntries($batid,$sec);
   //print_r($entries);
    echo "<table class='bttable' border='1'>";
    echo "<th class='blue'>Feedback Form Name</th>";
    echo "<th class='blue'>Creation Date</th>";
    echo "<th class='blue'>Subbmitable By:</th>";
   
    for($i=0;$i<count($entries);$i++)
    {
        
        echo "<tr>";
        echo "<td><a href='".$entries[$i]["Link"]."'>".$entries[$i]['Name']."</a></td>";
        echo "<td>".$entries[$i]["Cdate"]."</td>";
        echo "<td>".$entries[$i]["Edate"]."</td>";
      
        echo "</tr>";
        
        
    }
    echo "</table>";
    
}
else if(isset($_GET["fbid"]))
{
   
   echo getFeedback($_GET["fbid"]);
    
}
?>