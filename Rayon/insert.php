        <?php
	$con=mysql_connect("localhost","root","1234");
        mysql_select_db("freeEdu", $con);
        function mavailt()
	{
	$ros=$_POST['ros'][0];
        $doex=$_POST['date'];
        $year=$_POST['yr'][0];
        $bat=$_POST['bat'][0];
	$array=explode(':',$bat);
	$result2 = mysql_query(" SELECT * FROM MBATCHT WHERE brid='$array[0]' AND batyr='$array[1]' ")  or die(mysql_error());
        $row2 = mysql_fetch_array($result2);
        $batid=$row2['batid'];
	
	$query = mysql_query("SELECT COUNT(*) FROM MAVAILT") or die(mysql_error()); 
        $row9 = mysql_fetch_array($query);
        $mrid= $row9['COUNT(*)'];
        mysql_query("INSERT INTO MAVAILT (mrid, batid, doex, ros, akayr) VALUES ($mrid, $batid, '$doex', '$ros', $year)");
        }

	function mmarkst()
	{
        $srno=$_POST['srno'];
	for($i=0;$i<=11;$i++)
	 {
            $subcode=$_POST['subcode'.$i];
            $intm=$_POST['intm'.$i];
            $extm=$_POST['extm'.$i];
            $cre=$_POST['cre'.$i];
	    if($srno!= "" && $subcode!="" && $intm!="" && $extm!="" && cre!= "")
            {
	    $result = mysql_query(" SELECT * FROM MSTUDENTT WHERE srno='$srno' ")  or die(mysql_error());
            $row = mysql_fetch_array($result);
            $sid=$row['sid'];
            $result1 = mysql_query(" SELECT * FROM MSUBJECTT WHERE subcode='$subcode' ")  or die(mysql_error());
            $row1 = mysql_fetch_array($result1);
            $subid=$row1['subid'];
            $query = mysql_query("SELECT COUNT(*) FROM MMARKST") or die(mysql_error()); 
            $row8 = mysql_fetch_array($query);
            $mid= $row8['COUNT(*)'];
            mysql_query("INSERT INTO MMARKST (mid,sid, subid, intm, extm, cre, mrid) VALUES ($mid,$sid,'$subid','$intm','$extm','$cre','$mrid')");
	    }       
	}
	echo 'inserted';        
	}
	?>
