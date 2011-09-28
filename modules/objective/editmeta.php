<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField1",
			limitToToday:true,
			dateFormat:"%d-%M-%Y",
			imgPath:"../aux/calendar/img/"
			
		});
                new JsDatePick({
			useMode:2,
			target:"inputField2",
			dateFormat:"%d-%M-%Y",
			imgPath:"../aux/calendar/img/"
			
		});
	};
	
</script>
<?php
include("ob_lib.php");
echo "<script>function check()
	{
		
		var element = document.getElementById('otsub');
		var myDiv = document.getElementById('myDiv');
		if(element.value=='')
		{
			myDiv.innerHTML =\"Select A Class:".getClassesAsSelect("cls[]","")."\"
			
			
			
		}
		else
			myDiv.innerHTML = '';
		
		
	}</script>";
	
?>
<?php

        if(isset($_GET["otid"]))
        {
            
            $otid = $_GET["otid"];
            $entry = getObjectiveEntry($otid);
	    
            $object = getObject($_COOKIE["object"]);
            if($_COOKIE["object"] == $entry["oid"])
            {
                echo "<fieldset><legend>Update Objective Test - ".$entry["otname"]."</legend>";
                echo "<a href='?m=ot_edit&otid=".$otid."' style='float:left;margin-left:50px;'>Go Back</a><br>";
		if(!isset($_POST["Submit"]))
                {
                	    echo "<form method=\"post\" action=\"\">";
                    echo "<table class=\"aaa\" align=\"center\" width=\"300\" cellpadding='10px;'>";
                    echo "<tr>";
                	echo "<td align=\"right\">Test Name:</td><td><input type=\"text\" name='otname' required=true value='".$entry["otname"]."'></td>";
                    echo "</tr>";
                
                    echo "<tr>";
                	echo "<td align=\"right\">Test Date:</td><td><input type=\"text\" name='otdate'
                    required=true id='inputField1' value='".date("d-M-Y",$entry["otdate"])."'> </td>";
                    echo "</tr>";
                
                    echo "<tr>";
                	$classes = getFacClasses("otsub[]",$object["obhandle"],"onchange=check() id='otsub'");
                	$classes2 = substr($classes,0,-8);
                	$classes2 .= "<option value=''>Other</option></select>";
                	echo "<td align=\"right\">Subject:</td><td>".$classes2."</td><td><div id='myDiv'></div></td>";
                    echo "</tr>";
                
                    
                    echo "<tr>";
                	echo "<td align=\"right\">Deadline for Test </td><td><input type=\"text\" name='otdline'
                    required=true id='inputField2' value='".date("d-M-Y",$entry["otdline"])."'> </td>";
                    echo "</tr>";
                
                    echo "<tr>";
                	echo "<td align=\"right\">Time Limit(min):</td><td><input type=\"number\" name='ottt' required=true value='".$entry["ottt"]."'></td>";
                    echo "</tr>";
                    echo "<tr>";
                	
                	echo "<td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"Submit\" value=\"Submit\">&nbsp;&nbsp;&nbsp;&nbsp; </td>";
                    echo "</tr>";
                    echo "</table>";
                    echo "</form>";
                
                	
                }
                if (isset($_POST['Submit'])) {
                	
                	$otname = $_POST["otname"];
                	$otdate = $_POST["otdate"];
                	$otsub = $_POST["otsub"][0];
                	$otdline = $_POST["otdline"];
                	$ottt = $_POST["ottt"];
                	if($otsub == "")
                	{
                		$otcls = $_POST["cls"][0];
                		$array1 = explode(":",$otcls);
                		$subid = '';
                		$batid = $array1[0];
                		$sec = $array1[1];
                		
                	}
                	else
                	{
                		$clsmain = explode(':',$otsub);
                		$cldet = $clsmain[0];
                		$subid = $clsmain[1];
                		$batid = substr($cldet,0,1);
                		$sec = substr($cldet,-1);
                		
                	}
                	$otid2 = updateObjectiveTest($otid,$otname,$otdate,$subid,$otdline,$ottt,$batid,$sec);
                	notify("Objective Test Edited Succesfully!");
                	redirect("?m=ot_edit&otid=".$otid);
                    	
                }
                    echo "</fieldset>";
            }
            else
            {
            $object = getObject($entry["oid"]);
		if(!isStudent($_COOKIE["object"]))
			echo "<pre style='width:50%'>This Objective Test Was Created By <a href='?m=p&id=".$object["oid"]."'>".$object["obname"]."</a> So You Cant Edit It!</pre>";
            redirect("?m=ot_edit");
            
            }
        
        }
        else
        {
        
            redirect("?m=ot_edit");
            
        }
        
?>