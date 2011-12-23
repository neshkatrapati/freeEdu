<?php
    include("ob_lib.php");
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
		    echo "<fieldset><legend>Submit An Objective Test</legend><center><a href='?m=ot_edit' style='float:left;margin-left:20px;'>Go Back</a><br>";
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
	    redirect("?m=ot_edit");
        }         
            
    }
    else
    {
           redirect("?m=ot_edit");        
        
    }
   
   
?>