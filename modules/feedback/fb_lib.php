<?php
    function createFeedback($oid,$fbname,$cdate,$edate,$fbmin,$fbmax,$batid,$sec)
    {
        $clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
        $result = mysql_query("select * from FBAVAILT");
        $rows = mysql_num_rows($result);
        mysql_query("insert into FBAVAILT values('".$rows."','".$fbname."','".$cdate."','".strtotime($edate)."','".$fbmin."','".$fbmax."','".$oid."','".$batid."','".$sec."')");	
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
	    $returnLinks[$i]["Id"] = $fid;
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
	$result1 = mysql_query($query);
	$result2 = mysql_query($query2);
	
	$faculty = array();
	$i = 0;
	while($row = mysql_fetch_array($result2))
	{
	    
	    $faculty[$i] = $row["fid"];
	    
	}
	
	
	
	
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
    function curPageURL()
    {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
         $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
         $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
       return $pageURL;
    }
    function getFeedbackEntry($fbid)
    {
	
	return queryMe("select * from FBAVAILT where fbid like '".$fbid."'");
	
    }
?>