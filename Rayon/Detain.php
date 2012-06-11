<?php
function detainRegular($newbatid,$newakyr,$sid)
{
	$batyr=mysql_query("select * from MBATCHT where batid='$newbatid'");
	$byr=mysql_fetch_array($batyr);
	$batyr=$byr['batyr'];
	$regular=mysql_query("select * from MAVAILT where batid='$newbatid' and ros='R'");
	while($reglr=mysql_fetch_array($regular))
	{
		$mrid=$reglr[0];
		$akyer=$reglr[4];
		$batyr=$byr['batyr'];
		if($akyer>=$newakyr)
		{
			echo "<center>";
			if($akyer=='1')
			{
				echo "<br>Results For 1st Year Regular in Batch $batyr<br>";
			}
			else if($akyer=='2')
			{
				echo "<br>Results For 2nd Year 1st Semester Regular<br>";
			}
			else if($akyer=='3')
			{
				echo "<br>Results For 2nd Year 2st Semester Regular<br>";
			}
			else if($akyer=='4')
			{
				echo "<br>Results For 3rd Year 1st Semester Regular<br>";
			}	
			else if($akyer=='5')
			{
				echo "<br>Results For 3rd Year 2nd Semester Regular<br>";
			}
			else if($akyer=='6')
			{
				echo "<br>Results For 4th Year 1st Semester Regular<br>";
			}
			else if($akyer=='7')
			{
				echo "<br>Results For 4th Year 2nd Semester Regular<br>";
			}
			echo "</center>";
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
		}
		
	echo("</table>");
}
}
function detainSupply($newbatid,$newakyr,$sid)
{
$supply=mysql_query("select * from MAVAILT where batid='$newbatid' and ros='S'");
while($supp=mysql_fetch_array($supply))
{
	$mrid=$supp[0];
	$akyer=$supp[4];
	$regular=mysql_query("select * from MAVAILT where batid='$batid' and ros='R'");
	while($reg=mysql_fetch_array($regular))
	{
		$doex=$reg[2];
	}
	if($akyer>=$newakyr)
	{
		echo "<center>";
		if($akyer=='1')
		{
		echo "<br>Results For 1st Year Supplymentary<br>";
		}
		else if($akyer=='2')
		{
			echo "<br>Results For 2nd Year 1st Semester Supplymentary<br>";
		}
		else if($akyer=='3')
		{
			echo "<br>Results For 2nd Year 2st Semester Supplymentary<br>";
		}
		else if($akyer=='4')
		{
			echo "<br>Results For 3rd Year 1st Semester Supplymentary<br>";
		}	
	
		else if($akyer=='5')
		{
			echo "<br>Results For 3rd Year 2nd Semester Supplymentary<br>";
		}
		else if($akyer=='6')
		{
			echo "<br>Results For 4th Year 1st Semester Supplymentary<br>";
		}
		else if($akyer=='7')
		{
			echo "<br>Results For 4th Year 2nd Semester Supplymentary<br>";
		}
		echo "</center>";
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
		}
	echo("</table>");		
}
}
function detainRev($newbatid,$newakyr,$sid)
{
$rev=mysql_query("select * from MAVAILT where batid='$batid' and ros='RV'");
while($REV=mysql_fetch_array($rev))
{
	$mrid=$REV[0];
	$akyer=$REV[4];
	$regular=mysql_query("select * from MAVAILT where batid='$batid' and ros='R'");
	while($reg=mysql_fetch_array($regular))
	{
		$doex=$reg[2];
	}
	if($akyer>=$newakyr)
	{
		echo "<center>";
		if($akyer=='1')
		{
			echo "<br>Revaluation For 1st Year<br>";
		}
		else if($akyer=='2')
		{
			echo "<br>Revaluation For 2nd Year 1st Semester<br>";
		}
		else if($akyer=='3')
		{
			echo "<br>Revaluation For 2nd Year 2st Semester <br>";
		}
		else if($akyer=='4')
		{
			echo "<br>Revaluation For 3rd Year 1st Semester <br>";
		}
		else if($akyer=='5')
		{
			echo "<br>Revaluation For 3rd Year 2nd Semester<br>";
		}
		else if($akyer=='6')
		{
			echo "<br>Revaluation For 4th Year 1st Semester<br>";
		}
		else if($akyer=='7')
		{
			echo "<br>Revaluation For 4th Year 2nd Semester<br>";
		}
		echo "</center>";
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
	}
	echo("</table>");		
}	
}	
?>			
