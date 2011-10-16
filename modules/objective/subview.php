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
echo "";
	
			include("ob_lib.php");
			$otid = $_GET["otid"];
			
			if(isAuth(getCurrentObject(),$otid))
			{
						echo "<fieldset><legend>Objective Submission</legend>";
						echo "<a href='?m=ot_edit&otid=".$otid."' style='float:left;'>Go Back</a><br>";
						$entry = getObjectiveEntry($otid);
						$subi = getSubmission($_GET["otid"],$stu["sid"]);
						
						$obj = getObject($_GET["oid"]);
						$stu = getStudent($obj["obhandle"]);
						$suba = getSubmissionAsArray($subi["submid"]);
						$image = getImgUri($obj["imguri"]);
						$questions = getQuestions($otid);
						$entarry  = getObjectiveEntryAsArray($otid);
						if(checkSubmitted($_GET["otid"],$obj["obhandle"]))
						{
							echo "<div class='box' style='width:30%;float:right;text-align:center;margin-right:50px;margin-bottom:20px;margin-top:20px'>Testname:".$entry["otname"]."
							<br>Submitted By <a href='?m=p&id=".$_GET["oid"]."'>".$stu["sname"]."</a>
							<br>Number Of Correct Answers:".$subi["result"]."
							<br>Submitted On:".date("d-M-y",$subi["date"])."</div>";
							echo "<table class='bttable' style='width:400px;float:left;margin-left:50px;margin-bottom:50px;margin-top:10px;text-align:center;border: 2px solid #550;'>";
							echo "<th colspan='2' class='zebra-striped'>
							<br><div style='float:left;margin-right:10px;text-align:center'></div>
							<h4>Questions</h4></th>";
							//print_r($suba);
							
							for($i=0;$i<count($questions);$i++)
							{
							    
							    echo "";
								 echo "<tr>";	       
							    $ques = $questions[$i]["Question"];
							    
							    echo "<tr><td>Question</td><td>".$ques."&emsp;";
								echo "<div style='float:right'>
									<input type='image' onclick='show(\"div".$i."\",this)' src='../images/others/expandico.gif' style='float:right;' ></input></div></div>";
								echo "</td></tr>
									<tr><td style='display:none;' colspan='2' id=\"div".$i."\"><table class='box' align='center' style='float:center;' >";
							    for($j=0;$j<count($questions[$i]["Options"]);$j++)
							    {
							        
							        $option = $questions[$i]["Options"][$j]["Option"];
							        $correct = $questions[$i]["Options"][$j]["Correct"];
							        if($suba["Details"][$i]["Status"]["Aid"] != $j)
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
			else
			{
									
						redirect("?m=ot_edit");									
			}	
?>		