<?php
    function createObjectiveTest($otname,$otdate,$otsub,$otcnt,$otthresh,$otdline,$ottt,$oid,$batid,$sec)
    {
        $clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
        $result = mysql_query("select * from OTAVAILT");
        $rows = mysql_num_rows($result);
        mysql_query("insert into OTAVAILT values('".$rows."','".
                    $otname."','".strtotime($otdate)."','".$otsub."','".$otcnt."','".$otthresh.
                    "','".strtotime($otdline)	."','".$ottt."','".$oid."','".$batid."','".$sec."')");	
	
        return $rows;    
        
    }
    function updateObjectiveTest($otid,$otname,$otdate,$otsub,$otdline,$ottt,$batid,$sec)
    {
        $clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
        mysql_query("update OTAVAILT set otname = '".$otname."' where otid like '".$otid."'");
	mysql_query("update OTAVAILT set otdate = '".strtotime($otdate)."' where otid like '".$otid."'");
	mysql_query("update OTAVAILT set otsub = '".$otsub."' where otid like '".$otid."'");
	mysql_query("update OTAVAILT set otdline = '".strtotime($otdline)."' where otid like '".$otid."'");
	mysql_query("update OTAVAILT set ottt = '".$ottt."' where otid like '".$otid."'");
	mysql_query("update OTAVAILT set batid = '".$batid."' where otid like '".$otid."'");
	mysql_query("update OTAVAILT set sec = '".$sec."' where otid like '".$otid."'");
	
        return '';    
        
    }
    function getObjectiveEntry($otid)
    {
	
	return queryMe("select * from OTAVAILT where otid like '".$otid."'");
	
    }
    function getQuestion($motid)
    {
	
	return queryMe("select * from MOTESTT where motid like '".$motid."'");
	
    }
    function isAuth($oid,$otid)
    {
	$entry = getObjectiveEntry($otid);
	//print_r($entry);
	if(isStudent($oid))
	{
	    
	    $object = getObject($oid);
	    $student = getStudent($object["obhandle"]);
	    if(($entry["batid"] == $student["batid"]) && ($entry["sec"]==$student["sec"]))
	    {
		return true;
	    }
	    else
		return false;
	}
	
	else if($entry["oid"]==$oid)
	{
	    return true;
	}
	else
	    return false;
    }
    function isNotSubmitted($otid) // Include A Check In OTAVAILT
    {
        
        $cnt = queryMe("select count(otid) as cnt from MOTESTT where otid like '".$otid."'");
        if($cnt["cnt"]>0)
            return false;
        else
            return true;
        
    }
    function putQuestion($otid,$ques,$optext,$opcorrect)
    {
        
        $clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
        $result = mysql_query("select * from MOTESTT");
        $rows = mysql_num_rows($result);
        
        $motoptions = implode(";",$optext);
        $motcorrect = implode(";",$opcorrect);
        
        mysql_query("insert into MOTESTT values('".$rows."',\"".$ques."\",\"".$motoptions."\",'".$motcorrect."','".$otid."')");
	xDebug("insert into MOTESTT values('".$rows."',\"".$ques."\",\"".$motoptions."\",'".$motcorrect."','".$otid."')");
        return $rows;
    }
    function editQuestion($motid,$ques,$optext,$opcorrect)
    {
        
        $clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
        $result = mysql_query("select * from MOTESTT");
        $rows = mysql_num_rows($result);
        
        $motoptions = implode(";",$optext);
        $motcorrect = implode(";",$opcorrect);
        
        mysql_query("update MOTESTT set ques='".$ques."' where motid like '".$motid."'");
        mysql_query("update MOTESTT set motoptions='".$motoptions."' where motid like '".$motid."'");
        mysql_query("update MOTESTT set motcorrect='".$motcorrect."' where motid like '".$motid."'");
        return $rows;
    }
    function updateQuestionCount($otid,$otcnt)
    {
	 $clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	      
        mysql_query("update OTAVAILT set otcnt='".$otcnt."' where otid like '".$otid."'");
       
	
    }
    function updateQuestionTreshold($otid,$ottresh)
    {
	 $clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	      
        mysql_query("update OTAVAILT set otthresh='".$ottresh."' where otid like '".$otid."'");
       
	
    }
    function getQuestions($otid)
    {
        
        $clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
        $result = mysql_query("select * from MOTESTT where otid like '".$otid."' order by(motid) ASC");
        $returnLinks = array();
	$i=0;
	while($row=mysql_fetch_array($result))
	{
	    $motid = $row["motid"];
	    $motques = $row["motques"];
	    $motoptions = $row["motoptions"];
            $motcorrect = $row["motcorrect"];
	    $returnLinks[$i] = array();
            $returnLinks[$i]["Id"] = $motid;
	    $returnLinks[$i]["Question"] = $motques;
	    $returnLinks[$i]["Options"] = array();
            $options = explode(";",$motoptions);
            $correct = explode(";",$motcorrect);
            for($j=0;$j<count($options);$j++)
            {
                $returnLinks[$i]["Options"][$j] = array();
                $returnLinks[$i]["Options"][$j]["Option"] = $options[$j];
                if(in_array($j,$correct))
                {
                    $returnLinks[$i]["Options"][$j]["Correct"] = "true"; 
                    
                }
                else
                     $returnLinks[$i]["Options"][$j]["Correct"] = "false"; 
            }
            $i++;
	}
    
       return $returnLinks;

        
        
    }
    function getQuestionAsArray($motid)
    {
        
        $clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
        $result = mysql_query("select * from MOTESTT where motid like '".$motid."' order by(motid) ASC");
        $returnLinks = array();
	$i=0;
	while($row=mysql_fetch_array($result))
	{
	    $motid = $row["motid"];
	    $motques = $row["motques"];
	    $motoptions = $row["motoptions"];
            $motcorrect = $row["motcorrect"];
	    $returnLinks[$i] = array();
            $returnLinks[$i]["Id"] = $motid;
	    $returnLinks[$i]["Question"] = $motques;
	    $returnLinks[$i]["Options"] = array();
            $options = explode(";",$motoptions);
            $correct = explode(";",$motcorrect);
            for($j=0;$j<count($options);$j++)
            {
                $returnLinks[$i]["Options"][$j] = array();
                $returnLinks[$i]["Options"][$j]["Option"] = $options[$j];
                if(in_array($j,$correct))
                {
                    $returnLinks[$i]["Options"][$j]["Correct"] = "true"; 
                    
                }
                else
                     $returnLinks[$i]["Options"][$j]["Correct"] = "false"; 
            }
            $i++;
	}
    
       return $returnLinks;
    }
    function getObjectiveEntries($batid,$sec)
    {
	$clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
	$query = "SELECT * From OTAVAILT where batid like '".$batid."' and sec like '".$sec."'";
	$result = mysql_query($query);
	$returnLinks = array();
	$i=0;
	while($row=mysql_fetch_array($result))
	{
	    $otid = $row["otid"];
	    $otname = $row["otname"];
	    $otdate = $row["otdate"];
	    $otsub = $row["otsub"];
	    $otcnt = $row["otcnt"];
	    $otthresh = $row["otthresh"];
	    $otdline = $row["otdline"];
	    $ottt = $row["ottt"];
	    $oid = $row["oid"];
	    
	    
	    $returnLinks[$i] = array();
	    $returnLinks[$i]["Name"] = $otname;
	    $returnLinks[$i]["Cdate"] = date("d-M-Y",$otdate);
	    $returnLinks[$i]["Edate"]= date("d-M-Y",$otdline);
	    $returnLinks[$i]["Id"] = $otid;
	    $returnLinks[$i]["Thresh"] = $otthresh;
	    $returnLinks[$i]["Timelt"] = $ottt;
	    $returnLinks[$i]["Count"] = $otcnt;
	    $subject = getSubject($otsub);
	    $subob = getObjectByType("2",$otsub);
	    $returnLinks[$i]["Subject"] = array();
	    $returnLinks[$i]["Subject"]["Id"] = $otsub;
	    $returnLinks[$i]["Subject"]["Name"] = $subject["subname"];
	    $returnLinks[$i]["Subject"]["Link"] = "?m=p&id=".$subob["oid"] ;
	    $returnLinks[$i]["Object"] = $oid;
	    $returnLinks[$i]["Link"] = curPageURL()."&otid=".$otid;
	    $i++;
	}
       return $returnLinks;
    }
    function getObjectiveEntryAsArray($otid)
    {
	$clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
	$query = "SELECT * From OTAVAILT where otid like '".$otid."'";
	$result = mysql_query($query);
	$returnLinks = array();
	$row=mysql_fetch_array($result);
	$otid = $row["otid"];
	$otname = $row["otname"];
	$otdate = $row["otdate"];
	$otsub = $row["otsub"];
	$otcnt = $row["otcnt"];
	$otthresh = $row["otthresh"];
	$otdline = $row["otdline"];
	$ottt = $row["ottt"];
	$oid = $row["oid"];
	$obatid = $row["batid"];
	$osec = $row["sec"];
	    
	$returnLinks["Name"] = $otname;
	$returnLinks["Cdate"] = date("d-M-Y",$otdate);
	$returnLinks["Edate"]= date("d-M-Y",$otdline);
	$returnLinks["Id"] = $otid;
	$returnLinks["Thresh"] = $otthresh;
	$returnLinks["Timelt"] = $ottt;
	$returnLinks["Count"] = $otcnt;
	$subject = getSubject($otsub);
	$subob = getObjectByType("2",$otsub);
	$returnLinks["Subject"] = array();
	$returnLinks["Subject"]["Id"] = $otsub;
	$returnLinks["Subject"]["Name"] = $subject["subname"];
	$returnLinks["Subject"]["Link"] = "?m=p&id=".$subob["oid"] ;
	$returnLinks["Object"] = $oid;
	$array2 = queryMe("select (select brname from MBRANCHT br where br.brid=ba.brid) as brname,akayr from MBATCHT ba where batid like '".$obatid."'");
	$batch = $array2['brname']." ".getFullClass($array2['akayr']+1)." Section: ".$osec;
	$link =  "?m=src&q=%&t=0&ip=n&op=c&c=".$obatid.":".$osec;
        $returnLinks["Class"]["Id"] = $obatid;
	$returnLinks["Class"]["Sec"] = $osec;
	    
	$returnLinks["Class"]["Name"] = $batch;
        $returnLinks["Class"]["Link"] = $link;
        $returnLinks["Link"] = curPageURL()."&otid=".$otid;
	    
       return $returnLinks;
    }
    
    function getObjectiveEntriesByOid($oid)
    {
	$clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
	$query = "SELECT * From OTAVAILT where oid like '".$oid."'";
	$result = mysql_query($query);
	$returnLinks = array();
	$i=0;
	while($row=mysql_fetch_array($result))
	{
	    $otid = $row["otid"];
	    $otname = $row["otname"];
	    $otdate = $row["otdate"];
	    $otsub = $row["otsub"];
	    $otcnt = $row["otcnt"];
	    $otthresh = $row["otthresh"];
	    $otdline = $row["otdline"];
	    $ottt = $row["ottt"];
	    $obatid = $row["batid"];
	    $osec = $row["sec"];
	    
	    
	    $returnLinks[$i] = array();
	    $returnLinks[$i]["Name"] = $otname;
	    $returnLinks[$i]["Cdate"] = date("d-M-Y",$otdate);
	    $returnLinks[$i]["Edate"]= date("d-M-Y",$otdline);
	    $returnLinks[$i]["Id"] = $otid;
	    $returnLinks[$i]["Thresh"] = $otthresh;
	    $returnLinks[$i]["Timelt"] = $ottt;
	    $returnLinks[$i]["Count"] = $otcnt;
	    $subject = getSubject($otsub);
	    $subob = getObjectByType("2",$otsub);
	    $returnLinks[$i]["Subject"] = array();
	    $returnLinks[$i]["Subject"]["Id"] = $otsub;
	    $returnLinks[$i]["Subject"]["Name"] = $subject["subname"];
	    $returnLinks[$i]["Subject"]["Link"] = "?m=p&id=".$subob["oid"] ;
	    $returnLinks[$i]["Class"] = array();
	    $returnLinks[$i]["Class"]["Id"] = $obatid;
	    $returnLinks[$i]["Class"]["Sec"] = $osec;
	    
	    $array2 = queryMe("select (select brname from MBRANCHT br where br.brid=ba.brid) as brname,akayr from MBATCHT ba where batid like '".$obatid."'");
	    $batch = $array2['brname']." ".getFullClass($array2['akayr']+1)." Section: ".$osec;
	    $link =  "?m=src&q=%&t=0&ip=n&op=c&c=".$obatid.":".$osec;
	    
	    $returnLinks[$i]["Class"]["Name"] = $batch;
	    $returnLinks[$i]["Class"]["Link"] = $link;
	    $returnLinks[$i]["Link"] = curPageURL()."&otid=".$otid;
	    $i++;
	}
       return $returnLinks;
    }
?>