<html>
	<head>
	
	</head>
    <body>
    	<fieldset>
    	<legend>Add A Marks List</legend>
        <form action="#" method="get" >
        <fieldset>
        <legend>DETAILS</legend>
           	<?php
	include("../misc/constants.php");
	include("../lib/lib.php");	
	echo "<center>";
	 
	$placeBranch = "";
	$placeBranch = getBatches('bat[]');
	$DateA = getdate();
	$Date = $DateA['month']."-".$DateA['year'];			
	echo "Select A Batch:".$placeBranch.
			"<br /><br />Date Of Exam:<input type=text name='date' value='".$Date."'>
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
				</select><br /><br /><input type=\"submit\" name=\"sub\" value=\"Submit\" /";
		echo "</center>";
	
		echo "<div align=center>";
		?>	
				</fieldset>
				<br ><br >
		<?php 
  		if (isset($_POST[sub]))
      		{     
            	echo "value is set";
                }
             ?>
            </br>
            </br>
        </form>
        </fieldset>
        </fieldset>
    </body>
</html>
