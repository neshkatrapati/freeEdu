<html>
<?php

	
		echo "<center>";
		echo "<fieldset><legend>Add A Subject List</legend>";
			//Getting Branches And Regulations 
		$placeBranch = "";
		$Brret = getBranches();
		$placeReg = "";
		$Regret = getRegulations();
	
		for($i=0;$i<count($Brret);$i++)
			$placeBranch=$placeBranch."<option value='".$Brret[$i]."'>".$Brret[$i]."</option>";
		for($i=0;$i<count($Regret);$i++)
			$placeReg=$placeReg."<option value='".$Regret[$i]."'>".$Regret[$i]."</option>";
			
		echo "<form method=\"post\" action='#' enctype=\"multipart/form-data\">
					<input type=\"file\" name=\"file\" required=true/><br />
					<select name='brn[]'>".$placeBranch.
					"</select><select name='reg[]'>".$placeReg."</select><br />
					<input type=\"submit\" name=\"pre\" value=\"Preview\" />
					<input type=\"submit\" name=\"sub\" value=\"Submit\" />
				</form>";
		echo "</center>";
	
		echo "<div align=center>";
		if(isset($_POST["pre"]))
			printPreview();
		
		else if(isset($_POST["sub"]))
		{
			
	   	$brn = $_POST['brn'][0];
	   	$reg = $_POST['reg'][0];
	   	$array = readExcel($newfile);
			putSubList($array,$reg,$brn);
		
		}
			echo "</fieldset>";

?>
</html>