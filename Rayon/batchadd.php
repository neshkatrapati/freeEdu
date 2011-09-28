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
					Choose An Image Format:&emsp;<select name='imgfmt'>
					<option value='JPG'>.JPG</option>
					<option value='jpg'>.jpg</option>
					<option value='JPEG'>.JPEG</option>
					<option value='.jpeg'>.jpeg</option>
					<option value='PNG'>.PNG</option>
					<option value='png'>.png</option>
					</select><br><br>
					<input type=\"submit\" name=\"pre\" value=\"Preview\" />
					<input type=\"submit\" name=\"sub\" value=\"Submit\" />
					</fieldset>
				</form>";
		echo "</center>";
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		echo "<h2>Some Existing Batches</h2>";
		$abc = mysql_query("select * from MBATCHT order by rand() limit 0,3");
		echo "<table class='bttable'><center><tr>";
		while($row=mysql_fetch_array($abc))
		{
			$rnd = rand(0,1);
			if($rnd == 0)
				$sec = "A";
			else
				$sec = "B";
				
			$batid = $row["batid"];
			$year = $row["batyr"];
			echo "<td><h3>Batch ".$year."</h3>".getClassPreview($batid,$sec,4,16)."</td></center></div>&emsp;";
			
		}
		echo "</tr></center></table>";
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
		$imgfmt = $_POST["imgfmt"];
			$array = readExcel($newfile);
		
		//echo $imgfmt;	
			putBatch($array,$reg,$brn,$batyr,$A,$B,$imgfmt);
		
		}
		
		
		
?>
</html>