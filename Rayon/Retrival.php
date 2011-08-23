<?php
function retrival()
{
include("connection.php");
$newakyr=-1;
$srno=$_POST['srno'];
$srno= strtoupper($srno);
$result=mysql_query("select * from MSTUDENTT where srno='$srno'");
$rownum=mysql_num_rows($result);

if($rownum<=0)
{
	notifyerr("Invalid Hallticket Number");
}
else
{
echo "Roll Number:<font color='blue'>".$srno."</font><br><br>";
while($s = mysql_fetch_array($result))
{
	$sid=$s[0];
	$batid=$s[6];
	$did=$s[8];
	$imgid=$s[5];
	$image=mysql_query("select * from MIMGT where imgid='$imgid'");
	$img=mysql_fetch_array($image);
	$imguri=$img[1];
	echo "<img src='../".$imguri."' width='150' height='150' class='imgshadow'></img><br /><br />";
	
}
if($did>=0)
{
	$detain=mysql_query("select * from MDETAINT where did='$did'");
	while($d=mysql_fetch_array($detain))
	{	
		$batid=$d[2];
		$newbatid=$d[3];
		$newakyr=$d[4];
	}
	if($newakyr=='0')
	{
		echo "<br><font color='red'>NOTE:The Student is Detained in 1st Year</font><br>";
	}
	else if($newakyr=='1')
	{
		echo "<br><font color='red'>NOTE:The Student is Detained in 2-1</font><br>";
	}
	else if($newakyr=='2')
	{
		echo "<br><font color='red'>NOTE:The Student is Detained in 2-2</font><br>";
	}
	else if($newakyr=='3')
	{
		echo "<br><font color='red'>NOTE:The Student is Detained in 3-1</font><br>";
	}
	else if($newakyr=='4')
	{
		echo "<br><font color='red'>NOTE:The Student is Detained in 3-2</font><br>";
	}
	else if($newakyr=='5')
	{
		echo "<br><font color='red'>NOTE:The Student is Detained in 4-1</font><br>";
	}
	else if($newakyr=='6')
	{
		echo "<br><font color='red'>NOTE:The Student is Detained in 4-2</font><br>";
	}

}
include("Detain.php");
$branch=mysql_query("select * from MBATCHT where batid='$batid'");
while($br = mysql_fetch_array($branch))
{
	$brid=$br[1];
	$regid=$br[2];
	$batyr=$br['batyr'];
}

$brname=mysql_query("select * from MBRANCHT where brid='$brid'");
while($BR=mysql_fetch_array($brname))
{
	$brname=$BR[1];
	echo "<br>Branch:".$brname;
}
$reg=mysql_query("select * from MREGT where regid='$regid'");
while($REG=mysql_fetch_array($reg))
{
	$reg=$REG[1];
	echo "<br>Regulation:".$reg;
}
$regular=mysql_query("select * from MAVAILT where batid='$batid' and ros='R'");
$i=0;
while($reglr=mysql_fetch_array($regular))
{
	$mrid=$reglr[0];
	$akyr=$reglr[4];
	echo "<br><div1><h2>Regular Results</h2></div1><br />";
	if($i==0){
	echo "<div id='placeholderm' style='width:450px;height:250px'></div>
			<p id='hoverdata'><span id='clickdata'></span></p></div>" ;
	echo getMarksGraph($srno);}
	if($akyr=='1')
	{
		echo "<br>Results For 1st Year Regular<br>";
	}
	else if($akyr=='2')
	{
		echo "<br>Results For 2nd Year 1st Semester Regular<br>";
	}
	else if($akyr=='3')
	{
		echo "<br>Results For 2nd Year 2st Semester Regular<br>";
	}
	else if($akyr=='4')
	{
		echo "<br>Results For 3rd Year 1st Semester Regular<br>";
	}
	else if($akyr=='5')
	{
		echo "<br>Results For 3rd Year 2nd Semester Regular<br>";
	}
	else if($akyr=='6')
	{
		echo "<br>Results For 4th Year 1st Semester Regular<br>";
	}
	else if($akyr=='7')
	{

		echo "<br>Results For 4th Year 2nd Semester Regular<br>";
	}
		echo "<br>";
		echo("<table border=2 align=center bordercolor=black>");
		echo "<div4>";		
		echo "<tr bgcolor=pink>";
			echo("<td>");
				echo("Subject Code");
			echo("</td>");
			echo("<td>");
				echo("Subject Name");
			echo("</td>");
			echo("<td>");
				echo("Internal");
			echo("</td>");
			echo("<td>");
				echo("External");
			echo("</td>");
			echo("<td>");
				echo("Credits");
			echo("</td>");
		echo("</tr>");
		echo "</div4>";
		$marks=mysql_query("select * from MMARKST where sid='$sid' and mrid='$mrid'");
		$class="even";
		$var=1;
		while($sub=mysql_fetch_array($marks))
		{
			
			
			$subid=$sub[2];
			$subject=mysql_query("select * from MSUBJECTT where subid='$subid'");
			while($subj=mysql_fetch_array($subject))
			{
				$subname=$subj[2];
				$subcode=$subj[1];
				echo("<tr class='$class'>");
				echo("<td>");
					echo($subcode);
				echo("</td>");
				echo("<td>");
					echo($subname);
				echo("</td>");
								
			}
			$intr=$sub[3];
			$extr=$sub[4];
			$cre=$sub[5];
			echo("<td>");
				echo($intr);
			echo("</td>");
			echo("<td>");
				echo($extr);
			echo("</td>");
			echo("<td>");
				echo($cre);
			echo("</td>");
			echo("</tr>");
			
			
			if($var%2==0)
			{
				$class="even";
				$var=$var+1;			
			}
			else if($var%2!=0)
			{
				$class="odd";
				$var=$var+1;
			}
			
		
		}
	echo("</table>");
	if($newakyr==$akyr)
	{
		detainRegular($newbatid,$newakyr,$sid);
		break;
	}
	$i++;
}

$supply=mysql_query("select * from MAVAILT where batid='$batid' and ros='S'");
$class="even";
$var=1;
while($supp=mysql_fetch_array($supply))
{	
	$mrid=$supp[0];
	$akyr=$supp[4];
	$regular=mysql_query("select * from MAVAILT where batid='$batid' and ros='R'");
	while($reg=mysql_fetch_array($regular))
	{
		$doex=$reg[2];
	}

	echo "<br><div2><h2>Black Log History</h2></div2>";
	
	if($akyr=='1')
	{
		echo "<br>Results For 1st Year Supplymentary<br>";
	}
	else if($akyr=='2')
	{
		echo "<br>Results For 2nd Year 1st Semester Supplymentary<br>";
	}
	else if($akyr=='3')
	{
		echo "<br>Results For 2nd Year 2st Semester Supplymentary<br>";
	}
	else if($akyr=='4')
	{
		echo "<br>Results For 3rd Year 1st Semester Supplymentary<br>";
	}
	else if($akyr=='5')
	{
		echo "<br>Results For 3rd Year 2nd Semester Supplymentary<br>";
	}
	else if($akyr=='6')
	{
		echo "<br>Results For 4th Year 1st Semester Supplymentary<br>";
	}
	else if($akyr=='7')
	{
		echo "<br>Results For 4th Year 2nd Semester Supplymentary<br>";
	}
	$marks=mysql_query("select * from MBACKLOCKT where sid='$sid' and doex='$doex'");
	$rows=mysql_num_rows($marks);	
	if($rows<=0)
	{
		echo "<br>No Backlock History Found<br>";
		break;
	}		
		echo "<br>";
		echo("<table border=2 align=center bordercolor=black>");
		echo "<div4>";
		echo "<tr bgcolor=pink>";
			echo("<td >");
				echo("Subject Code");
			echo("</td>");
			echo("<td>");
				echo("Subject Name");
			echo("</td>");
			echo("<td>");
				echo("Internal");
			echo("</td>");
			echo("<td>");
				echo("External");
			echo("</td>");
			echo("<td>");
				echo("Credits");
			echo("</td>");
		echo("</tr>");
		echo "</div4>";	
		while($sub=mysql_fetch_array($marks))
		{
			$subid=$sub[2];
			$subject=mysql_query("select * from MSUBJECTT where subid='$subid'");
			while($subj=mysql_fetch_array($subject))
			{
				$subname=$subj[2];
				$subcode=$subj[1];
				echo("<tr bgcolor=cyan>");
				echo("<td>");
					echo($subcode);
				echo("</td>");
				echo("<td>");
					echo($subname);
				echo("</td>");
								
			}
			$intr=$sub[3];
			$cre='0';
			$extr=$sub[4];
			
			echo("<td>");
				echo($intr);
			echo("</td>");
			echo("<td>");
				echo($extr);
			echo("</td>");
			echo("<td>");
				echo($cre);
			echo("</td>");
			echo("</tr>");
			if($var%2==0)
			{
				$class="even";
				$var=$var+1;			
			}
			else if($var%2!=0)
			{
				$class="odd";
				$var=$var+1;
			}
			
		}
	echo("</table>");		
	if($newakyr>=$akyr)
			{
			detainSupply($newbatid,$newakyr,$sid);
			break;
			}
}
$rev=mysql_query("select * from MAVAILT where batid='$batid' and ros='RV'");
$var=1;
$class="even";
while($REV=mysql_fetch_array($rev))
{
	$mrid=$REV[0];
	$akyr=$REV[4];
	$regular=mysql_query("select * from MAVAILT where batid='$batid' and ros='R'");
	while($reg=mysql_fetch_array($regular))
	{
		$doex=$reg[2];
	}

	echo "<br><div3><h2>Revaluation History</h2></div3>";
	if($akyr>$newakyr)
	{
		detainRev();
		break;
	}
	if($akyr=='1')
	{
		echo "<br>Revaluation For 1st Year<br>";
	}
	else if($akyr=='2')
	{
		echo "<br>Revaluation For 2nd Year 1st Semester<br>";
	}
	else if($akyr=='3')
	{
		echo "<br>Revaluation For 2nd Year 2st Semester <br>";
	}
	else if($akyr=='4')
	{
		echo "<br>Revaluation For 3rd Year 1st Semester <br>";
	}
	else if($akyr=='5')
	{
		echo "<br>Revaluation For 3rd Year 2nd Semester<br>";
	}
	else if($akyr=='6')
	{
		echo "<br>Revaluation For 4th Year 1st Semester<br>";
	}
	else if($akyr=='7')
	{
		echo "<br>Revaluation For 4th Year 2nd Semester<br>";
	}
	echo "<br>";
		
		$marks=mysql_query("select * from MREVT where sid='$sid' and doex='$doex'");
		$rows=mysql_num_rows($marks);	
		if($rows<=0)
		{
			echo "<br>No Revaluation History Found<br><br>";
			break;
		}
		echo("<table border=2 align=center bordercolor=black>");
		echo "<div4>";
		echo "<tr bgcolor=pink>";
			echo("<td>");
				echo("Subject Code");
			echo("</td>");
			echo("<td>");
				echo("Subject Name");
			echo("</td>");
			echo("<td>");
				echo("Internal");
			echo("</td>");
			echo("<td>");
				echo("External");
			echo("</td>");
			echo("<td>");
				echo("Credits");
			echo("</td>");
		echo("</tr>");
		echo "</div4>";	
		while($sub=mysql_fetch_array($marks))
		{
			$subid=$sub[2];
			$subject=mysql_query("select * from MSUBJECTT where subid='$subid'");
			while($subj=mysql_fetch_array($subject))
			{
				$subname=$subj[2];
				$subcode=$subj[1];
				echo("<tr bgcolor=cyan>");
				echo("<td>");
					echo($subcode);
				echo("</td>");
				echo("<td>");
					echo($subname);
				echo("</td>");
								
			}
			$intr=$sub[3];
			$cre='0';
			$extr=$sub[4];
			
			echo("<td>");
				echo($intr);
			echo("</td>");
			echo("<td>");
				echo($extr);
			echo("</td>");
			echo("<td>");
				echo($cre);
			echo("</td>");
			echo("</tr>");
			if($var%2==0)
			{
				$class="even";
				$var=$var+1;			
			}
			else if($var%2!=0)
			{
				$class="odd";
				$var=$var+1;
			}
			
			
		}
		echo("</table>");
		if($newakyr>=$akyr)
			{
				detainSupply($newbatid,$newakyr,$sid);
				break;
			}
			

}
}
}
?>
