<?php

    
    include("fb_lib.php");
    $object = getObject($_COOKIE["object"]);
    $student = getStudent($object["obhandle"]);
    $batid = $student["batid"];
    $sec = $student["sec"];
    if(!isset($_GET['fbid']))
    {
       
    
        $entries = getFeedbackEntries($batid,$sec);
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
    
        $fbid = $_GET["fbid"];    
        $fbentry = getFeedbackEntry($fbid);
    
        if($batid!=$fbentry['batid'] || $sec!=$fbentry["sec"])
        {
            
            notifyerr("You Are Unauthorized To View This Page!");
            redirect("?m=fbput");
            
        }
        else
        {
            
            
            
            
        }
        
    }
?>  