<style type='text/css'>
.imgteaser {
	margin: 0;
	overflow: hidden;
	float: left;
	position: relative;
}
.imgteaser a {
	text-decoration: none;
	float: left;
}
.imgteaser a:hover {
	cursor: pointer;
}
.imgteaser a img {
	float: left;
	margin: 0;
	border: none;
	padding: 10px;
	background: #fff;
	border: 1px solid #ddd;
}
.imgteaser a .desc {	display: none; }
.imgteaser a:hover .epimg { visibility: hidden;}
.imgteaser a .epimg {
	position: absolute;
	right: 10px;
	top: 10px;
	font-size: 12px;
	color: #fff;
	background: #000;
	padding: 4px 10px;
	filter:alpha(opacity=65);
	opacity:.65;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=65)";
	
}
.imgteaser a:hover .desc{
	display: block;
	font-size: 11px;
	padding: 10px 0;
	background: #111;
	filter:alpha(opacity=75);
	opacity:.75;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=75)";
	color: #fff;
	position: absolute;
	bottom: 11px;
	left: 11px;
	padding: 4px 10px;
	margin: 0;
	width: 125px;
	border-top: 1px solid #999;
	
}
.pos
{
	position:absolute;
	top:91px;
	left:350px;
	
}

</style>
<script>
	function show(value,element)
			{
				var ele = document.getElementById(value);
				
				if(ele.style.display == 'none'){
					
					ele.style.display = 'block';
					element.src = "../images/others/collapse.png";	
				}
					
				else{
					ele.style.display = 'none';
					element.src = "../images/others/expandico.gif";	
				}
			}
	
</script>
<?php
    echo "<fieldset>";
    include_once("ob_lib.php");
    if(isset($_GET["otid"]))
    {
	
        $otid = $_GET["otid"];
        $entry = getObjectiveEntry($otid);
	echo "<legend>Objective Test ".$entry["otname"]."</legend><a href='?m=ot_edit' style='float:left;margin-left:50px;'>Go Back</a></br><center>";
        if(isAuth($_COOKIE["object"],$otid))
	{
		if(isNotSubmitted($otid)) //Replace By More Stringent Auth Check
		{
		    
		    echo "<pre style='width:50%;'>This Objective Test Has No Questions Yet Consider Submitting Some <a href='?m=ot_ques&mode=add&otid=".$otid."'>Here</a></pre>";
		    
		}
		else
		{
		    $questions = getQuestions($otid);
		    $entarry  = getObjectiveEntryAsArray($otid);
		    echo "<div style='float:left;margin-left:50px;margin-bottom:50px;margin-top:20px;border: 2px solid #550;'>";
		    echo "<table class='bttable' >";
		    echo "<th class='zebra-striped' colspan='2'>Test Details<a href='?m=ot_edit_meta&otid=".$otid."' style='float:right;'>
		    <img src='../images/others/edit.png' width='20' hieght='20'></img></a></th>";
		    echo "<tr><td>Name</td><td>".$entarry["Name"]."</td></tr>";
		    echo "<tr><td>Created On</td><td>".$entarry["Cdate"]."</td></tr>";
		    echo "<tr><td>Submittable By</td><td>".$entarry["Edate"]."</td></tr>";
		    echo "<tr><td>Number Of Questions</td><td>".$entarry["Count"]."</td></tr>";
		    echo "<tr><td>Number Of Questions Answerable To Pass</td><td>".$entarry["Thresh"]."</td></tr>";
		    echo "<tr><td>Time Limit</td><td>".$entarry["Timelt"]." Minutes</td></tr>";
		    $ct = getObject($entarry["Object"]);
		    $subcnt = getSubmissionCount($otid);
		    if($subcnt>0)
			echo "<tr><td>Submissions</td><td><a href='../modules/objective/whosub.php?otid=".$otid."' class='nyroModal'>".$subcnt." Submissions</a></td></tr>";
		    echo "<tr><td>Created By</td><td>".getImageBox(getObjectLink($ct["oid"]),"../".getImgUri($ct["oimgid"]),$ct["obname"],"","50","50","1","0.8")."</td></tr>";
		    echo "<tr><td>Created For</td><td style='margin-right:20px;'>".getClassPreview($entarry["Class"]["Id"],$entarry["Class"]["Sec"],3,9)."</td></tr>";
		    echo "</table>";
		    echo "</div>";
		    if($entry["oid"]==$_COOKIE["object"])
		    {
			echo "<center><table class='bttable' style='width:400px;float:right;margin-right:50px;margin-bottom:50px;margin-top:20px;float:right;text-align:center;border: 2px solid #550;'>";
			echo "<th colspan='2' class='zebra-striped'>
			<br><div style='float:right;margin-right:10px;text-align:center'>
			<a href='?m=ot_ques&mode=add&otid=".$otid."'>
			<img src='../images/others/add.png' style='margin-left:20px' width='25' hieght='25'></img></a></div>
			Questions</th>";
			
			for($i=0;$i<count($questions);$i++)
			{
			    
			    echo "";
				 echo "<tr>";	       
			    $ques = $questions[$i]["Question"];
			    
			    echo "<tr><td>Question</td><td>".$ques."&emsp;";
				echo "<div style='float:right'>
					<input type='image' onclick='show(\"div".$i."\",this)' src='../images/others/expandico.gif' style='float:right;' ></input></div><a href='?m=ot_ques&mode=edit&motid=".$questions[$i]["Id"]."'>
					&emsp;<img style='float:right' src='../images/others/edit.png' width='20' height='20'></img></a>
					&emsp;<div style='float:right;' >".getCorrectCount($questions[$i]["Id"])."<img style='' src='../images/others/tick.png' width='20' hieght='20'></img></div></div>";
				echo "</td></tr>
					<tr><td style='display:none;' colspan='2' id=\"div".$i."\"><table class='box' align='center' style='float:center;' >";
			    for($j=0;$j<count($questions[$i]["Options"]);$j++)
			    {
			        
			        $option = $questions[$i]["Options"][$j]["Option"];
			        $correct = $questions[$i]["Options"][$j]["Correct"];
			        if($correct!='true')
			            $string = "<td >".$option."</td>";
			        if($correct=='true')
			            $string = "<td >".$option."&emsp;<img src='../images/others/tick.png' width='20' hieght='20'></img></td>";
			        
			        if($j%2==0)
			        {
			            if($j==(count($questions[$i]["Options"])-1))
			                echo $string."<td ></td></tr>";
			            else
			                echo "<tr>".$string;
			            
			        }
			        else
			        {
			                echo $string."</tr>";
			        }
			        
			    }
			    
			    echo "</table></td></tr>";    
			}
			echo "</table></div>";
		    }
		    else if(isStudent(getCurrentObject()))
		    {
			$obj = getObject(getCurrentObject());
			//echo getCurrentObject();
			$stu = getStudent($obj["obhandle"]);
			$subi = getSubmission($_GET["otid"],$stu["sid"]);
			//print_r($subi);
			$suba = getSubmissionAsArray($subi["submid"]);
			$image = getImgUri($obj["imguri"]);
			if(checkSubmitted($_GET["otid"],$obj["obhandle"]))
			{
				echo "<div class='box' style='width:30%;float:right;margin-right:50px;margin-bottom:20px;margin-top:20px'>Number Of Correct Answers:".$subi["result"]."
				<br>Submitted On:".date("d-M-y",$subi["date"])."</div>";
				echo "<center><table class='bttable' style='width:400px;float:right;margin-right:50px;margin-bottom:50px;margin-top:20px;float:right;text-align:center;border: 2px solid #550;'>";
				echo "<th colspan='2' class='zebra-striped'>
				<br><div style='float:right;margin-right:10px;text-align:center'></div>
				<h4>Questions</h4></th>";
				//print_r($suba);
				
				for($i=0;$i<count($questions);$i++)
				{
				    
				    echo "";
					 echo "<tr>";	       
				    $ques = $questions[$i]["Question"];
				    
				    echo "<tr><td>Question</td><td>".$ques."&emsp;";
					echo "<div style='float:right'>
						<input type='image' onclick='show(\"div".$i."\",this)' src='../images/others/expandico.gif' style='float:right;' ></input></div><a href='?m=ot_ques&mode=edit&motid=".$questions[$i]["Id"]."'>
						</div>";
						
					echo "</td></tr>
						<tr><td style='display:none;' colspan='2' id=\"div".$i."\"><table class='box' align='center' style='float:center;' >";
				    for($j=0;$j<count($questions[$i]["Options"]);$j++)
				    {
				        
				        $option = $questions[$i]["Options"][$j]["Option"];
				        $correct = $questions[$i]["Options"][$j]["Correct"];
				        if($suba["Details"][$i]["Aid"] != $j)
				            $string = "<td >".$option."</td>";
				        else{
						//xDebug($suba["Detail"][0]["Status"]);
					    if($correct == 'true')
						$string = "<td >".$option."&emsp;<img src='../images/others/answer.gif' width='20' hieght='20'></img><img src='../images/others/tick.png' width='20' hieght='20'></img></td>";
					else
						$string = "<td >".$option."&emsp;<img src='../images/others/answer.gif' width='20' hieght='20'></img><img src='../images/others/wrong.jpg' width='20' hieght='20'></img></td>";
				        }
				        
				        if($j%2==0)
				        {
				            if($j==(count($questions[$i]["Options"])-1))
				                echo $string."<td ></td></tr>";
				            else
				                echo "<tr>".$string;
				            
				        }
				        else
				        {
				                echo $string."</tr>";
				        }
				        
				    }
				    
				    echo "</table></td></tr>";    
				}
				echo "</table></div>";
			}
			else
			{
				
				echo "<br><pre style='width:40%;float:right;'></br></br></br></br></br></br>You Haven't Yet Submitted this Test Yet ! Consider <a href='?m=ot_submit&otid=".$_GET["otid"]."'>Submitting It Now!</a></br></br></br></br></br></br></br></br></pre>";
				
			}
		    }
		}
	}
	else
	{
		$object = getObject($entry["oid"]);
		if(!isStudent($_COOKIE["object"]))
			echo "<pre style='width:50%'>This Objective Test Was Created By <a href='?m=p&id=".$object["oid"]."'>".$object["obname"]."</a> So You Cant Edit It!</pre>";
		else{
			$student = getStudent($object["obhandle"]);
			$batid = $student["batid"];
			$sec = $student["sec"];
			$array2 = queryMe("select (select brname from MBRANCHT br where br.brid=ba.brid) as brname,akayr from MBATCHT ba where batid like '".$batid."'");
			$batch = $array2['brname']." ".getFullClass($array2['akayr']+1)." Section: ".$sec;
			echo "<pre style='width:60%'>This Objective Test Was Created For <a href='?m=src&q=%&t=0&ip=n&op=c&c=".$batid.":".$sec."'>".$batch."</a> So You Cant See It</pre>";
			
		}
		//redirect("?m=ot_edit");
	}
    }
    if(!isset($_POST["phase1"]) && !isset($_GET["otid"]))
    {
	
	if(!isStudent($_COOKIE["object"]))
	{
		echo "<legend>Choose A Class</legend><center>";
		echo "<form action='#' method='post'>";
		echo "Select By ".getClassesAsSelect("bat[]")."&emsp;";
		echo "<br><br><input type='submit' name='phase1'/>";
		echo "</form>";
	}
	else
	{
		echo "<legend>Choose An Objective Test</legend><center>";
		$object = getObject($_COOKIE["object"]);
		$student = getStudent($object["obhandle"]);
		echo getEntries($student["batid"],$student["sec"],"S");
		
	}
    }
    else if(!isset($_GET["otid"]))
    {
	echo "<legend>Choose An Objective Test</legend><center>";
	$bat = $_POST['bat'][0];
	$barray = explode(':',$bat);
	$batid = $barray[0];
	$sec = $barray[1];
	$object = getObject($_COOKIE["object"]);
	if(isStudent($_COOKIE["object"]))
	{
		$student = getStudent($object["obhandle"]);
		echo getEntries($student["batid"],$student["sec"],"S");
	}
	else
	{
		echo  getEntries($batid,$sec,"F");
		
	}
    }
    function getEntries($batid,$sec,$mode)
    {
	if($mode == "F")
		$entries = getObjectiveEntries($batid,$sec,getCurrentObject());
	else
		$entries = getObjectiveEntries($batid,$sec);
	//print_r($entries);
	$obj = getObject(getCurrentObject());
	$stu = $obj["obhandle"];
	
	if(count($entries)>0)
	{
		$ret = "<table class='bttable' border='1'>";
		$ret .= "<th class='blue'>Objective Test Name</th>";
		$ret .= "<th class='blue'>Creation Date</th>";
		$ret .= "<th class='blue'>Deadline</th>";
		$ret .= "<th class='blue'>Subject</th>";
		$ret .= "<th class='blue'>Question Count</th>";
		$ret .= "<th class='blue'>Treshold</th>";
		$ret .= "<th class='blue'>Timelimit</th>";
		$ret .= "<th class='blue' >Created By</th>";
		$ret .= "<th class='blue'>Actions</th>";
		if($mode == "F")
			$ret .= "<th class='blue' >Submissions</th>";
		
		for($i=0;$i<count($entries);$i++)
		{
		    
		    $ret .= "<tr>";
		    $ret .= "<td><a href='".$entries[$i]["Link"]."'>".$entries[$i]['Name']."</a></td>";
		    $ret .= "<td>".$entries[$i]["Cdate"]."</td>";
		    $ret .= "<td>".$entries[$i]["Edate"]."</td>";
		    if($entries[$i]["Subject"]["Id"]!="")
			$ret .= "<td><a href='".$entries[$i]["Subject"]["Link"]."'>".$entries[$i]["Subject"]["Name"]."</a></td>";
		    else
			$ret .= "<td>UnAssigned</td>";
		    $ret .= "<td>".$entries[$i]["Count"]."</td>";
		   
		    $ret .= "<td>".$entries[$i]["Thresh"]."</td>";
		    $ret .= "<td>".$entries[$i]["Timelt"]."</td>";
		    $object = getObject($entries[$i]["Object"]);
		    $ret .= "<td><a href='?m=p&id=".$object["oid"]."'>".$object["obname"]."</a></td>";
		    if($mode == "S")
		    {
			$ret .= "<td colspan='2'>";
			if(checkSubmitted($entries[$i]["Id"],$stu) == false)
				$ret .= "<a href='?m=ot_submit&otid=".$entries[$i]["Id"]."'>Submit</a>";
			else
			{
				$sub = getSubmission($entries[$i]["Id"],$stu);
				$ret .= "Submitted Result:".$sub["result"];
				if($sub["result"]<$entries[$i]["Thresh"])
					$ret .= "<div class='' style='width:50%;'>Fail</div>";
				else
					$ret .= "<div class='' height='5px;' >Pass</div>";
			}
			$ret .= "</td>";
		    }
		    else{
			
			$ret .= "<td><a href='?m=ot_edit&otid=".$entries[$i]["Id"]."'>Edit</a></td>";
			$subcnt = getSubmissionCount($entries[$i]["Id"]);
			$ret .= "<td><a href='../modules/objective/whosub.php?otid=".$entries[$i]["Id"]."' class='nyroModal'>".$subcnt." Submissions</a></td>";
		    }
		    $ret .= "</tr>";
		    
		    
		}
		$ret .= "</table>";
		return $ret;
	}
	else
	{
		
		if(isStudent($_COOKIE["object"]))
			echo "<pre style='width:50%'>No Objective Tests To Display!</pre>";
		else
			echo "<pre style='width:50%'>No Objective Tests To Display! Consider Creating One <a href='?m=ot_create'>Here</a></pre>";
	}
    }
    function getEntriesByOid($oid)
    {
	
	$entries = getObjectiveEntriesByOid($oid);
	//print_r($entries);
	if(count($entries)>0)
	{
		$ret = "<table class='bttable' border='1'>";
		$ret .= "<th class='blue'>Objective Test Name</th>";
		$ret .= "<th class='blue'>Creation Date</th>";
		$ret .= "<th class='blue'>Deadline</th>";
		$ret .= "<th class='blue'>Subject</th>";
		$ret .= "<th class='blue'>Question Count</th>";
		$ret .= "<th class='blue'>Treshold</th>";
		$ret .= "<th class='blue'>Timelimit</th>";
		$ret .= "<th class='blue'>Created For</th>";
		for($i=0;$i<count($entries);$i++)
		{
		    
		    $ret .= "<tr>";
		    $ret .= "<td><a href='".$entries[$i]["Link"]."'>".$entries[$i]['Name']."</a></td>";
		    $ret .= "<td>".$entries[$i]["Cdate"]."</td>";
		    $ret .= "<td>".$entries[$i]["Edate"]."</td>";
		    if($entries[$i]["Subject"]["Id"]!="")
			$ret .= "<td><a href='".$entries[$i]["Subject"]["Link"]."'>".$entries[$i]["Subject"]["Name"]."</a></td>";
		    else
			$ret .= "<td>UnAssigned</td>";
		    $ret .= "<td>".$entries[$i]["Count"]."</td>";
		   
		    $ret .= "<td>".$entries[$i]["Thresh"]."</td>";
		    $ret .= "<td>".$entries[$i]["Timelt"]."</td>";
		    $object = $entries[$i]["Class"];
		    $ret .= "<td><a href='".$object["Link"]."'>".$object["Name"]."</a></td>";
		    
		    $ret .= "</tr>";
		    
		    
		}
		$ret .= "</table>";
		return $ret;
	}
	else
	{
		
		if(isStudent($_COOKIE["object"]))
			echo "<pre style='width:50%'>No Objective Tests To Display!</pre>";
		else
			echo "<pre style='width:50%'>No Objective Tests To Display! Consider Creating One <a href='?m=ot_create'>Here</a></pre>";
	}
    }
    echo "</center></fieldset>";
?>
