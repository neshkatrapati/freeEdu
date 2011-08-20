<?php
echo "<center>";

	$low = $_GET['l'];
	$range = $_GET['r'];
//Getting Branches And Regulations 
echo "<form method='post' action='#'>";

$clsname = "Constants";
$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
mysql_select_db($clsname::$dbname, $con);	

$query = 'SELECT count(fid) as cnt from MFACULTYT';
$result = mysql_query($query);
$mrow = mysql_fetch_array($result);
$cntfid = $mrow['cnt'];


echo getFacMap($low,$range);
echo "<input type='submit' name='upload'></form>";
$cnt = 0;

$rindstring = "";
$ic = 0;
$fcount = 0;
if(array_key_exists("cls",$_POST))
{
	if(array_key_exists('sub',$_POST))
	{
	
		$cls = $_POST['cls'];
		$sub = $_POST['sub'];
		$c=0;
		for($i=0;$i<count($cls);$i++)
		{
			 
			if($cls[$i][0]!="")
			{				
					
					$exparray = explode(':',$cls[$i][0]); 
					$brid = $exparray[0];
					$akayr = substr($exparray[1],0,1)-1;
					$sql = "SELECT batid from MBATCHT where brid like '".$brid."' and akayr like '".$akayr."'";
					$sqlresult = mysql_query($sql);
					$brow = mysql_fetch_array($sqlresult);
					$batid = $brow['batid'];
					$sec = substr($exparray[1],1);
					//echo $brid.":".$sql.":".$batid.":".$sec;	
					$rindstring .= $batid.$sec.":".$sub[$cnt][0].";"; 					
					$cnt++;
					$c++;
			}
			if(($i+1)%4 == 0)
			{
				
				if($c!=0)
				{
					$fid = $_POST['fid'][$fcount];
					$mode = $_POST[$fid];
					$fcourses = $rindstring;
					$erind = queryMe("SELECT fcourse FROM MFACULTYT WHERE fid LIKE '".$fid."'");
					$erinds = $erind['fcourse'];
					if($mode == 'c')
						$sql = "UPDATE MFACULTYT SET fcourse='".$rindstring."' WHERE fid='".$fid."'";
					elseif($mode == 'a')
						$sql = "UPDATE MFACULTYT SET fcourse='".$erinds.$rindstring."' WHERE fid='".$fid."'";
					mysql_query($sql);
					$rindstring = "";
					$c = 0;
				}
				
					$fcount++; 			
				
				
					
			}
			
		
		}
		
	}

}
$nhi = $low+5;

	echo "<a href='?m=mf&l=".$nhi."&r=".$range."'>Next</a>";
?>