<html>

<style>
.num
{
	width : 5%;
}
</style>
<?php

	
		echo "<center>";
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
					<fieldset>
					<legend>Add A Batch</legend>
					<input type=\"file\" name=\"file\" / required=true><br /><br />Branch:
					<select name='brn[]'>".$placeBranch.
					"</select>&emsp;&emsp;Regulation:<select name='reg[]'>".$placeReg."</select><br /><br />
					Batch Year:<input type='text' name='batyr' required=true></input><br />
					<br /><b>Strength In:</b>&emsp;Section A  <input type='number' name='A' value=60 class=num></input>
					&emsp;Section B  <input type='number' name='B' value=60 class=num></input><br /><br />
					<input type=\"submit\" name=\"pre\" value=\"Preview\" />
					<input type=\"submit\" name=\"sub\" value=\"Submit\" />
					</fieldset>
				</form>";
		echo "</center>";
	
		echo "<div align=center>";
		if(isset($_POST["pre"]))
			printPreview();
		
		else if(isset($_POST["sub"]))
		{
			
	   	$brn = $_POST['brn'][0];
	   	$reg = $_POST['reg'][0];
	   	$batyr = $_POST['batyr'];
	   	$A = $_POST['A'];
	   	$B = $_POST['B'];
			$array = readExcel($newfile);
			
			putBatch($array,$reg,$brn,$batyr,$A,$B);
		
		}
		
		
		
?>
</html>