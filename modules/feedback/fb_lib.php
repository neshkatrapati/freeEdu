<?php
    $authtoken = getAuthToken("feedback");
    function createFeedback($oid,$fbname,$cdate,$edate,$fbmin,$fbmax,$batid,$sec)
    {
        $clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
        $result = mysql_query("select * from FBAVAILT");
        $rows = mysql_num_rows($result);
	$authtoken = getAuthToken("feedback");
    
        fq("insert into FBAVAILT values('".$rows."','".$fbname."','".$cdate."','".strtotime($edate)."','".$fbmin."','".$fbmax."','".$oid."','".$batid."','".$sec."')",$authtoken);	
	makeObject($fbname,$rows,'7','476','','');
        return $rows;
    }
    function getFeedbackEntries($batid,$sec)
    {
	$clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
	$query = "SELECT * From FBAVAILT where batid like '".$batid."' and sec like '".$sec."'";
	$result = mysql_query($query);
	$returnLinks = array();
	$i=0;
	while($row=mysql_fetch_array($result))
	{
	    $fbid = $row["fbid"];
	    $fbname = $row["fbname"];
	    $fbcdate = $row["fbdatec"];
	    $fbedate = $row["fbdatee"];
	    $returnLinks[$i] = array();
	    $returnLinks[$i]["Name"] = $fbname;
	    $returnLinks[$i]["Cdate"] = date("d-M-Y",$fbcdate);
	    $returnLinks[$i]["Edate"]= date("d-M-Y",$fbedate);
	    $returnLinks[$i]["Id"] = $fbid;
	    $returnLinks[$i]["Link"] = curPageURL()."&fbid=".$fbid;
	    $i++;
	}
       return $returnLinks;
    }
    function getFeedback($fid)
    {
	$clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
	$query = "SELECT * From MFEEDBACKT where fbid like '".$fid."'";
	$query2 = "SELECT distinct fid from MFEEDBACKT where fbid like '".$fid."'";
	$query3 = "SELECT distinct sid from MFEEDBACKT where fbid like '".$fid."'";
	$result1 = mysql_query($query);
	$result2 = mysql_query($query2);
	$result3 = mysql_query($query3);
	
	$fbentry = getFeedbackEntry($fid);
	$fbname = $fbentry["fbname"];
	
	
	$faculty = array();
	$i = 0;
	$xnum =0;
	$ret .= "<table class='bttable' border='1' style=\"margin-left:50px;margin-right:50px;\">";
	$ret .= "<th class='blue'>Student</th>";
	while($row = mysql_fetch_array($result2))
	{
	    $fac = getFaculty($row["fid"]);
	    $ret .= "<th class='blue'>".$fac["fname"]."</th>";
	    
	}
	$totalrating = array();
	while($row2 = mysql_fetch_array($result3))
	{
	    $sql = "SELECT * FROM MFEEDBACKT where sid like '".$row2['sid']."'";
	    $sqlres = mysql_query($sql);
	    $student = getStudent($row2["sid"]);
	    $ret .= "<tr><td>".$student["srno"]."</td>"; 
	    $cnt = 0;
	    while($srow = mysql_fetch_array($sqlres))
	    {
		$ret .= "<td>".$srow["rating"]."</td>";
		$totalrating[$cnt] += $srow["rating"];
		$cnt++;
	    }
	    $ret .= "</tr>";
	    $xnum++;
	}
	$ret .= "<tr><td>Cumulative Result</td>";
	
	for($i=0;$i<count($totalrating);$i++)
	{
	    
	    $ret .= "<td>".$totalrating[$i]."</td>";
	  
	    
	}
	$ret .= "</tr><tr>";
	$ret .= "<td>Average Result</td>";
	for($i=0;$i<count($totalrating);$i++)
	{
	    
	    
	    $ret .= "<td>".round($totalrating[$i]/$xnum,2)."</td>";
	    
	}
	$ret .= "</tr></table>";
	return $ret;
	
	
    }
    function putFeedback($sid,$feedback,$fbid)
    {
	$clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
	$result = mysql_query("select * from MFEEDBACKT");
	$id = mysql_num_rows($result);
	for($i=0;$i<count($feedback);$i++)
	{
	    $query = "insert into MFEEDBACKT values('".$id."','".$sid."','".$feedback[$i]["fid"]."','".$feedback[$i]["rating"]."','".strtotime(date("d-M-Y"))."','".$fbid."')";
	    mysql_query($query);
	    $id++;
	}
	
    }
    function getFeedbackEntry($fbid)
    {
	
	return queryMe("select * from FBAVAILT where fbid like '".$fbid."'");
	
    }
    function getRatingBox($name,$fbid)
    {
	
	$fbentry = getFeedbackEntry($fbid);
	$fbmin = $fbentry["fbmin"];
	$fbmax = $fbentry["fbmax"];
	
	$ret = "<select name='".$name."'>";
	for($i=$fbmin;$i<=$fbmax;$i++)
	{
	    $ret .= "<option value='".$i."'>".$i."</option>";
	    
	}
	return $ret."</select>";
	
	
    }
    function checkSubmitted($fbid,$sid)
    {
	
	$clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
	//echo  $fbid." ".$sid;
	$result = mysql_query("select * from MFEEDBACKT where fbid like '".$fbid."' and sid like '".$sid."'");
	xDebug("select * from MFEEDBACKT where fbid like '".$fbid."' and sid like '".$sid."'");
	$rows = mysql_num_rows($result);
	if($rows>0)
	    return true;
	else
	    return false;
	
	
    }
?>