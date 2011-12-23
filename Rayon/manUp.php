<html>
<head>
</head>
<body>
<fieldset>
	<center>
<legend>Update Manually</legend>
<form action="#" method="post" >
     
	Roll Number:<input type='text' name='srno' />&nbsp;
	Year of Exam to be Updated:<select name='year'>
		<option name='1' value='1'>1st Year</option>
		<option name='2' value='2'>2nd Year- 1st Sem</option>
		<option name='3' value='3'>2nd Year- 2st Sem</option>
		<option name='4' value='4'>3nd Year- 1st Sem</option>
		<option name='5' value='5'>3nd Year- 2st Sem</option>
		<option name='6' value='6'>4nd Year- 1st Sem</option>
		<option name='7' value='7'>4nd Year- 2st Sem</option>
	</select>
	<input type="submit" name="submit" value="Submit"/>
	</form>
	<?php
	if(isset($_POST['submit']))
	{
		
		include("../lib/connection.php");
		$srno=$_POST['srno'];
		$student=mysql_query("select * from MSTUDENTT where srno='$srno'");
		$stu=mysql_fetch_array($student);
		$batid=$stu['batid'];
		$sid=$stu['sid'];
		$batch=mysql_query("select * from MBATCHT where batid='$batid'");
		$bat=mysql_fetch_array($batch);
		$brid=$bat['brid'];
		$regid=$bat['regid'];
		$batyr=$bat['batyr'];
		$year=$_POST['year'];
		if($sid==null)
		{
			notifyerr("Student Roll Number not Valied. Please Try again!");
			break;
		}
		echo "<form action='#' method='post' >";
		echo "<input type='hidden' name='sid' value='$sid'>";
		echo "<input type='hidden' name='year' value='$year'>";		
		echo "Date Of exam:<select name='doex'>";
		$exam=mysql_query("select * from MAVAILT where batid='$batid' and akayr='$year'");
		while($date=mysql_fetch_array($exam))
		{
			echo "Date Of Exam:<option value='$date[doex]'>$date[doex] &nbsp $date[ros]</option>";
		}
		echo "</select>&nbsp;";
		$sub=mysql_query("select subid from SAVAILT where brid='$brid' and regid='$regid'");
		$subid=mysql_fetch_array($sub);
		$subject=mysql_query("select * from MSUBJECTT where suid='$subid[0]' and year='$year'");
		echo "Subject:<select name='subid'>";		
		while($subname=mysql_fetch_array($subject))
		{
			echo "<option name='$subname[subid]' value='$subname[subid]'>$subname[subname]</option>";
		}
		echo "</select>&nbsp;";
		echo "<input type='submit' name='submit1' value='Submit'/></form>";
	}
	if(isset($_POST['submit1']))
	{	
		$subid=$_POST['subid'];
		$sid=$_POST['sid'];
		$year=$_POST['year'];
		$doex=$_POST['doex'];
		$exam=mysql_query("select mrid from MAVAILT where doex='$doex' and akayr='$year'");
		$mark=mysql_fetch_array($exam);
		$mrid=$mark['mrid'];
		$ros=$mark['ros'];
		$marks=mysql_query("select * from MMARKST where mrid='$mrid[0]' and sid='$sid' and subid='$subid'");
		$em=mysql_fetch_array($marks);
		$intm=$em['intm'];
		$extm=$em['extm'];
		$cre=$em['cre'];
		echo "<form action='#' method='post' >";
		echo "<table><tr><th>Internal</th><th>External</th><th>Credit</th></tr>";
		echo "<input type='hidden' name='sid' value='$sid'>";
		echo "<input type='hidden' name='mrid' value='$mrid[0]'>";	
		echo "<input type='hidden' name='subid' value='$subid'>";
		echo "<tr><td><input type=text name=intm value='$intm' size='2' Style='text-align: center;'></td>";
		echo "<td><input type=text name=extm value='$extm' size='2' Style='text-align: center;'></td>";
		echo "<td><input type=text name=cre value='$cre' size='2' Style='text-align: center;'></td>";
		echo "<td><input type='submit' value='Update' name='final'></td></tr>";
	}	
	
	if(isset($_POST['final']))
	{
		
		$intm=$_POST['intm'];
		$extm=$_POST['extm'];
		$cre=$_POST['cre'];
		$subid=$_POST['subid'];
		$sid=$_POST['sid'];
		$mrid=$_POST['mrid'];
		if($intm==null || $extm==null || $cre==null)
		{
			notifyerr("Null Values cannot be updated");
		}
		else
		{		
			mysql_query("update MMARKST set intm='$intm',extm='$extm',cre='$cre' where sid='$sid' and mrid='$mrid' and subid='$subid'");
			notify("Update Done");
		}	
	}	

	?>
	</center>
	
</fieldset>
</body>
</html>
