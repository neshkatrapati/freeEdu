<html>
<link rel="stylesheet" type="text/css" media="all" href="../aux/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../aux/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			limitToToday:true,
			dateFormat:"%d-%M-%Y",
			imgPath:"../aux/calendar/img/"
			
		});
	};
</script>
<?php

	
	echo "<center>";
	 
	$placeBranch = "";
	$placeBranch = getBatches('bat[]');
	$DateA = getdate();
			
		echo "<form method=\"post\" action='#' enctype=\"multipart/form-data\">
					<fieldset>	
					<legend>Add A Marks List</legend>				
					<input type=\"file\" name=\"file\" required=true/><br /><br />
					Select A Batch:".$placeBranch.
					"<br /><br />Date Of Exam:<input type=text id='inputField' name='date' value='' required=true>
					Select Exam Type:<select name='ros[]'>
					<option value='R'>Regular</option><option value='S'>Supplementary</option>
					</select><br /><br />Select Academic Year:<select name='yr[]'>
					<option value='1'>1st Year</option>
					<option value='2'>2-1</option>
					<option value='3'>2-2</option>
					<option value='4'>3-1</option>
					<option value='5'>3-2</option>
					<option value='6'>4-1</option>
					<option value='7'>4-2</option>
					</select><br /><br /><input type=\"submit\" name=\"pre\" value=\"Preview\" />
					<input type=\"submit\" name=\"sub\" value=\"Submit\" />
					</fieldset>
				</form>";
		echo "</center>";
	
		echo "<div align=center>";
		if(isset($_POST["pre"]))
			printPreview();
		
		else if(isset($_POST["sub"]))
		{
			
	   	$bat = $_POST['bat'][0];
	   	$date = $_POST['date'];
	   	$ros = $_POST['ros'][0];
	   	$akayr = $_POST['yr'][0];
	   	
	   	$barray = explode(':',$bat);
	   	$brid = $barray[0];
	   	$batyr = $barray[1];
			$array = readExcel($newfile);
			
			putMarks($array,$batyr,$brid,$date,$ros,$akayr);
		
		}
?>
</html>