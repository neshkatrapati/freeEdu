
<?php
    
    if(!isset($_POST['sub']) && !isset($_POST['sub2']))
    {
        echo "<center>";
        $placeBranch = "";
        $Brret = getBranches();
        $placeReg = "";
        $Regret = getRegulations();
            
        for($i=0;$i<count($Brret);$i++)
            $placeBranch=$placeBranch."<option value='".$Brret[$i]."'>".$Brret[$i]."</option>";
        for($i=0;$i<count($Regret);$i++)
            $placeReg=$placeReg."<option value='".$Regret[$i]."'>".$Regret[$i]."</option>";
        echo "<form method=\"post\" action='#' enctype=\"multipart/form-data\">
                <fieldset>
            	<legend>Add Substitute Subject</legend>
            		Choose Branch:
            		<select name='brn[]'>".$placeBranch.
            		"</select>&emsp;&emsp;Choose Regulation:<select name='reg[]'>".$placeReg."</select>Select Academic Year:<select name='yr[]'>
					<option value='1'>1st Year</option>
					<option value='2'>2-1</option>
					<option value='3'>2-2</option>
					<option value='4'>3-1</option>
					<option value='5'>3-2</option>
					<option value='6'>4-1</option>
					<option value='7'>4-2</option>
					</select><br /><br />
            		<input type=\"submit\" name=\"sub\" value=\"Submit\" />
                </fieldset>
            </form>";
        echo "</center>";
    }
    
    if(isset($_POST['sub']) && !isset($_POST['sub2']))
    {
        
        $brn = $_POST['brn'][0];
	$reg = $_POST['reg'][0];
        $yr = $_POST['yr'][0];
        $brid = getBranchByName($brn);
        $regid = getRegByName($reg);
        $select =  getSubjectsAsSelect($brid,$regid,$yr,"sub[]");
        if($select == "ERR_INV_REG_BRNC")
            notifyerr("Invalid Branch-Regulation-Year Combination!");
        else
        {
            
             $placeBranch = "";
        $Brret = getBranches();
        $placeReg = "";
        $Regret = getRegulations();
            
        for($i=0;$i<count($Brret);$i++)
            $placeBranch=$placeBranch."<option value='".$Brret[$i]."'>".$Brret[$i]."</option>";
        for($i=0;$i<count($Regret);$i++)
            $placeReg=$placeReg."<option value='".$Regret[$i]."'>".$Regret[$i]."</option>";
            
            echo "<form action='#' method='post' enctype=\"multipart/form-data\">";
            echo "<table border='1' style='text-align:center;'>";
            echo "<th>Subject</th>";
            echo "<th>Replacement Subject Name</th>";
            echo "<th>Replacement Subject Code</th>";
            echo "<th>Subject Regulation</th>";
            echo "<th>Subject Branch</th>";
            echo "<th>Subject Image</th>";
             echo "<tr><td>".$select."</td>";
            echo "<td><input type='text' name='subname' style='width:auto;' required=true/></td>";
            echo "<td><input type='text' name='subcode' style='width:auto;' required=true/></td>";
            echo "<td><select name='reg[]'>".$placeReg."</select></td>";
            echo "<td><select name='brn[]'>".$placeBranch."</select></td>";
            echo "<td><input type='file' name='file' /></td></tr></table><br><hr><table border='1' style='text-align:center;'>";
            echo "<th>Internal Max</th>";
            echo "<th>External Max</th>";
            echo "<th>External Min</th>";
            echo "<th>Credits</th>";
            echo "<th>Books</th><tr>";
            
           
            echo "<td><input type='text' name='inmax' required=true/></td>";
            echo "<td><input type='text' name='exmax' required=true/></td>";
            echo "<td><input type='text' name='exmin' required=true/></td>";
            echo "<td><input type='text' name='cre' required=true/></td>";
            echo "<td><input type='text' name='books' /></td>";
            
            
            echo "</tr></table><input type='submit' name='sub2' /></form>";
        }   
       
        
    }
    if(isset($_POST['sub2']))
    {
        
        $msubid = $_POST['sub'][0];
        $reg = getRegByName($_POST['reg'][0]);
        $brn = getBranchByName($_POST['brn'][0]);
        $subname = $_POST['subname'];
        $subcode = $_POST['subcode'];
        $inmax = $_POST['inmax'];
        $exmax = $_POST['exmax'];
        $exmin = $_POST['exmin'];
        $cre = $_POST['cre'];
        $books = $_POST['books'];
       
        //echo $msubid." ".$reg." ".$brn." ".$subname." ".$subcode." ".$inmax." ".$exmax." ".$exmin." ".$cre." ".$books;
        putSubstituteSubject($msubid,$subname,$subcode,uploadImage(),$brn,$reg,$inmax,$exmax,$exmin,$cre,$books);
        
        
    }
?>