<html>
    <body>
    <fieldset>
    	<legend>Choose Batch For Analysis</legend>
        <form action="#" method="post" >
        <?php
	echo "<center>";
	$placeBranch = "";
	$placeBranch = getBatches('bat[]');
	echo "Select A Batch:".$placeBranch;
	?>
	<input type="submit" name="submit" value="submit"/>
	</form>
    </body>
    <?php
	if(isset($_POST['submit']))
	{
		
		$bat=$_POST['bat'][0];
		$array=explode(':',$bat);
		$brid=$array[0];
		$batyr=$array[1];
		$query=mysql_query("SELECT * FROM MBATCHT WHERE brid='$brid' AND batyr='$batyr' ") or die(mysql_error());
		$result=mysql_fetch_array($query);
		$batid= $result['batid'];
		$regid= $result['regid'];
		$query2=mysql_query("SELECT * FROM SAVAILT WHERE brid='$brid' AND regid='$regid' ") or die(mysql_error());
		$result2=mysql_fetch_array($query2);
		$query1=mysql_query("SELECT * FROM MAVAILT WHERE batid='$batid'") or die(mysql_error());
		
                while($result1 = mysql_fetch_array($query1))
                {
                	if($result1['ros']=="R")
                           	$reg="Regular";
                        if($result1['ros']=="S")
                        	$reg="Supplimentary";
	
	switch ($result1['akayr']):
	    case 1:
	        $yr="1st year";
	        break;
	    case 2:
	        $yr="2nd year-1st semester";
	        break;
	    case 3:
	        $yr="2nd year-2nd semester";
	        break;
	    case 4:
	        $yr="3rd year-1st semester";
	        break;
	    case 5:
	        $yr="3rd year-2nd semester";
	        break;
	    case 6:
	        $yr="4th year-1st semester";
	        break;	
	    case 7:
		$yr="4th year-2nd semester";
		break;
	    default:
	        $yr="0";
	endswitch;
	?>
	<form action="../lib/demo.php" method="get" target='_blank'>
	<?php
	echo '<input type="radio"'.'name="mixed"'.'value=' .$result1['mrid'].":".$result1['akayr'].":".$result1['doex'].'>';
	
	//echo $result1['akayr']." subid:".$result2['subid']." mrid:".$result1['mrid']." ".$result1['doex']." ".$batid."<br>";
	echo "Consolidated Report of ".$result1['doex']."  ".$reg." ". $yr.'</br>';
        }
	echo '<input type="hidden"'.'name="subid"'.'value=' .$result2['subid'].'>';
	echo '<input type="hidden"'.'name="batid"'.'value=' .$batid.'>';
	echo '<input type="hidden"'.'name="reg"'.'value=' .$reg.'>';
         echo "<input type='submit' name='ok' value='OK'></form>	";
	}
	?>
	
   </html>
