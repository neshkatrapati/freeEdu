<script type='text/javascript'>

function printer()
{
  var html="<html>";
   html+= document.getElementById('printarea').innerHTML;
   html+="</html>";

   var printWin = window.open('','','left=0,top=0,width=1,height=1,toolbar=0,scrollbars=0,status  =0');
   printWin.document.write(html);
   printWin.document.close();
   printWin.focus();
   printWin.print();
   printWin.close();
}
</script>
<?php
include_once("as_lib.php");
   
if(!isset($_GET["asid"]))
{
    echo "<center><fieldset><legend>Assignment List</legend>"; 
   $entries = getAssignmentEntries($_COOKIE["object"]);
   //print_r($entries);
    if(count($entries)!=0)
    {
        echo "<table class='bttable' border='1'>";
       echo "<th class='blue'>Assignment Name</th>";
       echo "<th class='blue'>Subject</th>";
       echo "<th class='blue'>Created Date</th>";
       echo "<th class='blue'>Actions</th>";
    //  print_r($entries);
       
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
           echo "<td><a href='?m=ass_see&asid=".$asid."'>See</a>&emsp;|&emsp;<a href='?m=ass_edit&asid=".$asid."'>Edit</a></td>";
           echo "</tr>";
           
           
       }
       echo "</table>";
       
    }
    else
    {
        
        echo "<pre style='width:50%'>There Are No Assignments To Show</pre>";
        
    }
    
    echo "Create Assignment <a href='?m=ass'>Here</a>";
    echo "</center></fieldset>";
}
else if(isset($_GET["asid"]))
{
        
	
	$asid = $_GET["asid"];
        $ass = getAssignment($asid);
        if($_COOKIE["object"] == $ass["oid"])
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
		}
}
?>