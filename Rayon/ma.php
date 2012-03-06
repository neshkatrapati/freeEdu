	<html>
	<head>
		<style type="text/css">

		table.imagetable {
		font-family: verdana,arial,sans-serif;
		font-size:14px;
		color:#333333;
		border-width: 4px;
		border-color: #8a879c;
		border-collapse: collapse;
		}
		
		td.red
		{
			color:red;
		}
		
		table.imagetable th {
		background:#87CEFA url('cell-blue.jpg');
		font-size:14px;
		border-width: 3px;
		padding: 8px;
		border-style: solid;
		border-color: #999999;
		}

		table.imagetable td {
		background:#F5F5F5 url('cell-grey.jpg');
		border-width: 3px;
		padding: 8px;
		border-style: solid;
		border-color: #999999;
		}

		
    		div.box
		{
		width:300px;
		padding:10px;
		border:5px solid gray;
		margin:0px;
		}
    
		div.heading
		{
		text-transform:uppercase;	
		width:500px;
		padding:10px;
		border:3px solid gray;
		margin:0px;
		}

		</style>
		</head>
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
	<?php
	if(isset($_POST['submit']))
	{
	?>
	
	<?php
	include_once("../lib/connection.php");
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
	?>
	<form action="#" method="post">
	<?php
	echo '<input type="radio"'.'name="year"'.'value=' .$result1['akayr'].'>';
	echo '<input type="hidden"'.'name="subid"'.'value=' .$result2['subid'].'>';
	echo '<input type="hidden"'.'name="mrid"'.'value=' .$result1['mrid'].'>';
	echo '<input type="hidden"'.'name="doex"'.'value=' .$result1['doex'].'>';
	echo '<input type="hidden"'.'name="batid"'.'value=' .$batid.'>';
	echo "Consolidated Report of ".$result1['doex']."  ".$reg." ". $yr.'</br>';
	}	
	?>
	<input type="submit" name="ok" value="OK">
	</form>	

	<?php 
	}
	?>
	
	<?php
	if(isset($_POST['ok']))
	{
	include_once("../lib/connection.php");
	$year=$_POST['year'];
	$suid=$_POST['subid'];
	$batid=$_POST['batid'];
	
	
	
	$qry1=mysql_query("SELECT mrid FROM MAVAILT WHERE batid='$batid' and akayr='$year'") or die(mysql_error());
	$mrid=mysql_fetch_array($qry1);
	echo '<center>'.'<div class="heading"'.'>'.'<center>'."Consolidated Marks Report".'</center>'.'</div>'.'</center>';
	?>
	<table class="imagetable" id='imagetable'>
	<tr>	
	<th rowspan=2>Student Roll No</th>
	<th rowspan=2>Student Name</th>
		
	<?php
	$maxtot=0;
	$subcount=0;
	$query=mysql_query("SELECT * FROM MSUBJECTT WHERE suid='$suid' AND year='$year'") or die(mysql_error());
	while($result=mysql_fetch_array($query))
	{
		$subcount++;		
		echo '<th colspan=4>'.$result['subname'].'</th>';
		$mxtot=$mxtot+$result['exmax']+$result['inmax'];
	}
	$st = 2; 
        for($i=0;$i<5;$i++){
                 $worksheet->mergeCells(0,$st,0,$st+3);
                 $st = $st+4;
        }
	echo '<th rowspan=2>'."Total".'</th>';
	echo '<th rowspan=2>'."%".'</th>';
	echo '<th rowspan=2>'."Backlogs".'</th>';
	echo '</tr>';
	echo "<tr>";	
	
	for($i=0;$i<$subcount;$i++)
	{
		
	
		echo '<th>IN</th>';
		echo '<th>EX</th>';
		echo '<th>TOT</th>';
		echo '<th>CRE</th>';
		
	}
	echo '</tr>';
	$stu=mysql_query("select * from MSTUDENTT where batid='$batid'");
	$stucount=0;
	$failcount=0;
	$fcount=0;
	while($stuf=mysql_fetch_array($stu))
	{	
			
		$sid=$stuf['sid'];
		echo "<tr>";
		echo "<td>$stuf[srno]</td>";
		echo "<td>$stuf[sname]</td>";
		$sub=mysql_query("select * from MMARKST where mrid='$mrid[0]' and sid='$sid'");
		$total=0;
		$backlog=0;
		$stucount++;
		while($subf=mysql_fetch_array($sub))
		{	
		
			$class='def';
			
			$subid=$subf['subid']; 		
			
			$i=$subf['intm']+$subf['extm'];			
			$total=$total+$i;			
			
			if($subf['cre']<=0)
			{
				$arr[]=$subid;
				$backlog=$backlog+1;	
				$class='red';
				$failcount++;
			}
			echo "<td class='$class'>$subf[intm]</td>";
			echo "<td class='$class'>$subf[extm]</td>";
			echo "<td class='$class'>$i</td>";
			echo "<td class='$class'>$subf[cre]</td>";
			
		}
		if($failcount>0)
		{
			$fcount++;
			$failcount=0;	
		}
		
		echo "<td>$total</td>";
		$percent=number_format(($total/$mxtot)*100,2,'.','');
		echo "<td>$percent</td>";
		echo "<td>$backlog";
		for($i=0;$i<count($arr);$i++)
		{
			$sub=mysql_query("select subname from MSUBJECTT where subid='$arr[$i]'");
			$subname=mysql_fetch_array($sub);	
			echo "/$subname[0]";		
		}	
		echo "</td>";
		echo "</tr>";		
		unset($arr);		
		
	}	
	echo $fcount."<br>";
	echo $stucount;	
	$pass=$stucount-$fcount;
	$pp=($pass/$stucount)*100;
	echo "</table>";
	?>
	<center>
	<div class='box' align=center>
	TOTAL PASS PERCENTAGE :<?php echo number_format($pp,2,'.','')."%";?>
	</div></center>
	<?php
	}
	?>
	</fieldset>
	</body>
	</html>	
