	<html>
	<head>
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
	</head>

    	<body>

    	<fieldset>
    	<legend>Add A Marks List</legend>
	<form action="#" method="post" >
        <?php
	if(!array_key_exists("sub",$_POST))
	{
	?>
	
        <fieldset>
	<legend>DETAILS</legend>
        <?php
	
	echo "<center>";
	$placeBranch = "";
	$placeBranch = getBatches('bat[]');
	$DateA = getdate();
	$Date = $DateA['month']."-".$DateA['year'];			
	echo "Select A Batch:".$placeBranch.
			"<br /><br />Date Of Exam:<input type=text name='date' value='' required=true id='inputField'>
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
				</select><br /><br />
				<input type=\"submit\" name=\"sub\" value=\"Submit\" /";
		echo "</center>";
		}
		?>
	       </fieldset>
		
               <br ><br >
            	<?php
		if (isset($_POST['sub']))
      		{
		include_once("insert.php");	     
		mavailt();         	
		?>
		

		<center>Enter Student Roll No.<input type="text" name="srno"/></center>
		<table width="100%" border="2">
                <tr>
                    <td>Subject Code</td>  
                    <td>Internal Marks</td> 
                    <td>External Marks</td>
                    <td>Credits Earned</td>
                </tr>
                <?php
                
                for($i=0;$i<12;$i++)
		 {
                ?>
                <tr>
                    <td> <?php echo '<input type="text" name="' . 'subcode'. $i . '" />'; ?></td>  
                    <td> <?php echo '<input type="text" name="' . 'intm'. $i . '" />'; ?></td>  
                    <td> <?php echo '<input type="text" name="' . 'extm'. $i . '" />'; ?></td>  
                    <td> <?php echo '<input type="text" name="' . 'cre'. $i . '" />'; ?></td>  
                </tr>
		<?php
                }
                ?>
            </table><br >
            <center>
            <input type="submit" name="update" value="update"/>
            </center>
		
		<?php
		}
		if(isset($_POST['update']))
		{
		include_once("insert.php");		
		mmarkst();
		}
		echo "<div align=center>";
		?>	
				
            </br>
            </br>
        </form>
        </fieldset>

</body>
</html>
