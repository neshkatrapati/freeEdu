<?php

    include_once("ob_lib.php");
    $object = getObject($_COOKIE["object"]);
    if(isStudent($object["oid"]) )
    {

        if(isset($_GET["otid"]) && !isset($_POST["sub"]))
        {   
            $otid = $_GET["otid"];
            $entry = getObjectiveEntry($otid);
            
            $student = getStudent($object["obhandle"]);
            if(($student["batid"] == $entry["batid"]) &&  ($student["sec"] == $entry["sec"]))
            {
                    
                    $questions = getQuestions($otid);
		    echo "<fieldset><legend>Submit An Objective Test</legend><center><a href='?m=ot_submit' style='float:left;margin-left:20px;'>Go Back</a><br>";
                    echo "<form action='' method='post'>";
		    for($i=0;$i<count($questions);$i++)
		    {   
                              
                        $ques = $questions[$i]["Question"];
                        echo "<table class='bttable'  align='center' style='float:center;width:500px;border:2px solid;' ><tr><td>Q".($i+1)."</td>
                        <td colspan='2' style='' ><div style=''>".trim($ques,"\"")."</div>";
			echo "</td></tr>";
                        for($j=0;$j<count($questions[$i]["Options"]);$j++)
                        {
		      
                            $option = $questions[$i]["Options"][$j]["Option"];
                            $correct = $questions[$i]["Options"][$j]["Correct"];
                            if($j!=0)
                                $string = "<td ><input type='radio' name='check".$questions[$i]["Id"]."[]' value='".$j."'></input>".trim($option)."</td>";
                        
                            else if($j==0)
                            {
                                $string = "<td ><input type='radio' name='check".$questions[$i]["Id"]."[]' value='".$j."' checked></input>".trim($option)."</td>";
                                echo "<input type='hidden' name='motid[]' value='".$questions[$i]["Id"]."'></input>";    
                            }
                            
                            if($j%2==0)
                            {
                                if($j==(count($questions[$i]["Options"])-1))    
                                    echo "<tr><td></td>".$string."<td ></td></tr>";
                                else 
                                    echo "<tr><td></td>".$string;
			            
                            }
                            else
                            {
                                   echo $string."</tr>";
			    }
			        
			    }
			    
			    echo "</table>";    
			}
			echo "";
                        echo "<br><input type='submit' name='sub'></input></form></fieldset>";
		    }
            
            else
                redirect("?m=ot_edit");        
        }
        else if(!isset($_GET["otid"]) && !isset($_POST["sub"]))
	{
	    
	    if(isStudent(getCurrentObject()))
	    {
		echo "<fieldset><legend>Choose An Objective test</legend><center>";
		$student = getStudent($object["obhandle"]);
		
		//print_r($student);
		$entries = getObjectiveEntriesByBatIdSec($student["batid"],$student["sec"]);
		if(count($entries) <= 0){

			redirect("?m");
			notify("No Tests to Submit");
		}
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
		    $ret .= "<td colspan='2'>";
			if(checkSubmitted($entries[$i]["Id"],$student["sid"]) == FALSE)
				$ret .= "<a href='?m=ot_submit&otid=".$entries[$i]["Id"]."'>Submit</a>";
			else
			{
				$sub = getSubmission($entries[$i]["Id"],$student["sid"]);
				$ret .= "Submitted Result:".$sub["result"];
				
				if($sub["result"]<$entries[$i]["Thresh"])
					$ret .= "<div class='' style='width:50%;'>Fail</div>";
				else
					$ret .= "<div class='' height='5px;' >Pass</div>";
			}
			$ret .= "</td>";
		    
		    $ret .= "</tr>";
		    
		    
		}
		$ret .= "</table>";
		echo $ret;
		echo "</fieldset>";
	 }
	else
	{
		
		if(isStudent($_COOKIE["object"]))
			echo "<pre style='width:50%'>No Objective Tests To Display!</pre>";
		else
			echo "<pre style='width:50%'>No Objective Tests To Display! Consider Creating One <a href='?m=ot_create'>Here</a></pre>";
	}
		
				
	    
	    
	}
	else if(isset($_POST["sub"]))
        {
            $qids = $_POST["motid"];
            $detail = array();
            for($i=0;$i<count($qids);$i++)
            {
                $qid = $qids[$i];
                $ansc = $_POST["check".$qid.""][0];
                
                $detail[$i] = $qid.":".$ansc;
            }
            $sdet = implode(";",$detail);
            $result =  computeResult($sdet,$_GET["otid"]);
            $otid = $_GET["otid"];
            $submission = putSubmission($object["obhandle"],$sdet,date("d-M-y"),$result,$otid);
	    $et = getObjectiveEntry($otid);
            echo "<center><div class='box'>You Scored ".$result."!";
	    if($et["otthresh"]>$result)
		echo " You Failed!</div>";
	    else
		echo "Congos! You Passed</div></center>";
	    notify("Submitted Succesfully!");
	    redirect("?m=ot_submit");
        }         
            
    }
    else
    {
           redirect("?m=ot_edit");        
        
    }
   
   
?>
