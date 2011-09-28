<script>
var persist = null;
var number = 0;
function add()
{
    
    tabBody=document.getElementById("options");
    if(persist == null)
    {
        if(number == 0){
            row = document.getElementById("initop");
            persist = null;
        }
        else{
            row=document.createElement("tr");
            persist = row;}
    }
    else
    {
        
        row = persist;
        persist = null;
        
    }
    cell0 = document.createElement("td");
    cell1 = document.createElement("td");
    textnode1=document.createElement("input");
    textnode1.name="options[]";
    textnode1.type="text";
    textnode1.required=true;
    textnode2=document.createElement("input");  
    textnode2.name="check[]";
    textnode2.type="checkbox";
    textnode2.value=number+1;
    cell1.appendChild(textnode2);
    cell1.appendChild(textnode1);
    row.appendChild(cell0);
    row.appendChild(cell1);
    tabBody.appendChild(row);
    number++;
}
var even = 0; 
function addEdit()
{
    
    tabBody=document.getElementById("options");
    
    if(persist == null)
    {
        if(even == 0){
            row = document.getElementById("initop");
            persist = null;
        }
        else{
            row=document.createElement("tr");
            persist = row;}
    }
    else
    {
        
        row = persist;
        persist = null;
        
    }
    cell0 = document.createElement("td");
    cell1 = document.createElement("td");
    textnode1=document.createElement("input");
    textnode1.name="options[]";
    textnode1.type="text";
    textnode1.required=true;
    textnode2=document.createElement("input");  
    textnode2.name="check[]";
    textnode2.type="checkbox";
    textnode2.value=number+1;
    //textnode2.required=true;
    cell1.appendChild(textnode2);
    cell1.appendChild(textnode1);
    row.appendChild(cell0);
    row.appendChild(cell1);
    tabBody.appendChild(row);
    even = 1-even;
    number++;
}

</script>
<?php
    include("ob_lib.php");
    echo "<fieldset>";
    $mode = $_GET["mode"];
    if($mode == "add")
    {
        if(isset($_GET["otid"]) && !isset($_POST["fin"]))
        {
            echo "<legend>Add A Question</legend><center>";
            echo "<a href='?m=ot_edit&otid=".$_GET["otid"]."' style='float:left;margin-left:50px;'>Go Back</a><br>";
            echo "<form action='' method='post'>";
           
            echo "<table cellpadding='10px;' id='inputtable'><tr><td>Question</td><td colspan='30'><textarea name='ques' rows='3' cols='50'></textarea></td>
            <td><a onclick='add()' >Add Options</a></td></tr></table>";
            echo "<table id='options' cellpadding='10px;'>
                    <tr id='initop'>
                        <td>Options</td>
                        <td><input type='checkbox' name='check[]' value='0' checked>
                        <input type='text' name='options[]' ></td>
                    </tr>
                </table>";
             echo "<input type='submit' name='fin' value='Finish Adding'></input>&emsp;<input type='submit' name='add' value='Add Another Question'>";
        }
        if(isset($_POST["add"]))
        {
            
            $otid = $_GET["otid"];
            $ques = $_POST["ques"];
            $opttext = $_POST["options"];
            $optcorrect = $_POST["check"];
            
            $row = putQuestion($otid,$ques,$opttext,$optcorrect);
            $entry = getObjectiveEntry($otid);
            updateQuestionCount($otid,($entry["otcnt"]+1));
            notify("Added Question Succesfully!");
         
            //print_r($_POST);
        }
        if(isset($_POST["fin"]))
        {
            
            $otid = $_GET["otid"];
            $ques = $_POST["ques"];
            $opttext = $_POST["options"];
            $optcorrect = $_POST["check"];
            $entry = getObjectiveEntry($otid);
            $row = putQuestion($otid,$ques,$opttext,$optcorrect);
            updateQuestionCount($otid,($entry["otcnt"]+1));
            echo "<form action='' method='post'><center>";
            echo "<input type='number' name='thres' value='".$entry["otthresh"]."'></input>&emsp;<input type='submit' name='over'></input>
            <input type='hidden' name='otid' value='".$otid."'></center></form>";
            notify("Added Question Succesfully!");
            //print_r($_POST);
        }
    }
    else if($mode == "edit")
    {
        if(isset($_GET["motid"]) && !isset($_POST["fin"]))
        {
            echo "<legend>Edit A Question</legend><center>";
            
            $motid = $_GET["motid"];
            $quest = getQuestion($motid);
            $questions = getQuestionAsArray($motid);
            $xcnt = count($questions[0]["Options"]);
            echo "<a href='?m=ot_edit&otid=".$quest["otid"]."' style='float:left;margin-left:50px;'>Go Back</a><br>";
            echo "<form action='?m=ot_ques&mode=edit&motid=".($motid+1)."' method='post'>";
           
            
            
            if(count($questions)>0)
            {
                echo "<table cellpadding='10px;' id='inputtable'><tr><td>Question</td><td colspan='30'>
                <textarea name='ques' rows='3' cols='50'>".$quest["motques"]."</textarea></td>
                <td><a onclick='addEdit()' >Add Options</a></td></tr></table>";
                echo "<table id='options' cellpadding='10px;'><tr><td>Options</td>";
                
                if($xcnt%2==0)
                    echo "<script>even=1;number=".($xcnt-1).";</script>";
                if($xcnt%2==1)
                    echo "<script>even=0;number=".($xcnt-1).";</script>";
                    
                   
                for($j=0;$j<count($questions[0]["Options"]);$j++)
                    {
                        
                        $option = $questions[0]["Options"][$j]["Option"];
                        $correct = $questions[0]["Options"][$j]["Correct"];
                        if($correct=='true'){
                            if($j!=0)
                            {
                                $string = "<td></td><td>
                                <input type='checkbox' name='check[]' checked value='".$j."'></input>
                                <input type='text' name='options[]' value='".$option."' required=true></input></td>";
                            }
                            else
                                $string = "<td>
                                <input type='checkbox' name='check[]' checked value='".$j."'></input>
                                <input type='text' name='options[]' value='".$option."' required=true></input></td>";
                        }
                        if($correct!='true'){
                            if($j!=0)
                            {
                                $string = "<td></td><td >
                                <input type='checkbox' name='check[]' value='".$j."'></input>
                                <input type='text' name='options[]' value='".$option."' required=true></input></td>";
                            }
                            else
                                $string = "<td >
                                <input type='checkbox' name='check[]' value='".$j."'></input>
                                <input type='text' name='options[]' value='".$option."' required=true></input></td>";
                        }
                        
                        if($j%2==0 && $j!=0)
                        {
                            
                            if($j == $xcnt-1)
                                echo "<tr id='initop'>".$string;
                            else
                                echo "<tr >".$string;
                            
                        }
                        else if($j!=0 && $j%2!=0)
                        {
                                echo $string."</tr>";
                        }
                        else
                        {
                            echo $string;
                        }
                        
                    }
                    
                echo "</table>";
                echo "<input type='hidden' name='postmotid' value='".$motid."'></input>";
                 echo "<input type='submit' name='fin' value='Finish Editing'></input>&emsp;<input type='submit' name='edit' value='Edit Another Question'>";
            }
            else
            {
                echo "<pre style='width:50%'>No Such Question Exists</pre>";
            }
        }
        if(isset($_POST["edit"]))
        {
            
            $postmotid = $_POST["postmotid"];
            $ques = $_POST["ques"];
            $opttext = $_POST["options"];
            $optcorrect = $_POST["check"];
            
            $row = editQuestion($postmotid,$ques,$opttext,$optcorrect);
            notify("Modified Question Succesfully!");
            //print_r($_POST);
        }
        if(isset($_POST["fin"]))
        {
            
            $postmotid = $_POST["postmotid"];
            $ques = $_POST["ques"];
            $opttext = $_POST["options"];
            $optcorrect = $_POST["check"];
            $question = getQuestion($postmotid);
            $entry2 = getObjectiveEntry($question["otid"]);
            $row = editQuestion($postmotid,$ques,$opttext,$optcorrect);
            echo "<form action='' method='post'><center>";
            echo "<input type='number' name='thres' value='".$entry2["otthresh"]."'></input>&emsp;<input type='submit' name='over'></input>
            <input type='hidden' name='otid' value='".$question["otid"]."'></center></form>";
            
            notify("Modified Question Succesfully!");
            
            //print_r($_POST);
        }
    }
    if(isset($_POST["over"]))
    {
        
        $thresh = $_POST["thres"];
        $otid = $_POST["otid"];
        updateQuestionTreshold($otid,$thresh);
        notify("Objective Treshold Updated Succesfully!");
        redirect("?m=ot_edit&otid=".$otid);
    }
    echo "</center></fieldset>";
?>