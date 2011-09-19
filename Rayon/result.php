		<html>
		<body>
	<?php
	include("../lib/connection.php");
		$brid=$_GET['brid'];
		$batyr=$_GET['batyr'];
		$query=mysql_query("SELECT * FROM MBATCHT WHERE brid='$brid' AND batyr='$batyr' ") or die(mysql_error());
		$result=mysql_fetch_array($query);
		$batid= $result['batid'];
		$regid= $result['regid'];
		$query2=mysql_query("SELECT * FROM SAVAILT WHERE brid='$brid' AND regid='$regid' ") or die(mysql_error());
		$result2=mysql_fetch_array($query2);
		$query1=mysql_query("SELECT * FROM MAVAILT WHERE batid='$batid' ") or die(mysql_error());

	while($result1 = mysql_fetch_array($query1))
	{
		if($result1['ros']="R")
		$reg="Regular";
		else
		$reg="Supplymentary";
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

	echo '<a href="marks.php?mrid=' . $result1['mrid'].'&subid=' . $result2['subid'].'&year=' . $result1['akayr'].'">'."Result Analysis of ".$result1['doex']."  ".$reg." ". $yr.'</br>'.'</br>';   
	}
	?>
		</body>
		</html>
