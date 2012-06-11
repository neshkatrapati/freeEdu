<?php
    function createObjectiveTest($otname,$otdate,$otsub,$otcnt,$otthresh,$otdline,$ottt,$oid,$batid,$sec)
    {
    
	
        $result = mysql_query("select * from OTAVAILT");
        $rows = mysql_num_rows($result);
        mysql_query("insert into OTAVAILT values('".$rows."','".
                    $otname."','".strtotime($otdate)."','".$otsub."','".$otcnt."','".$otthresh.
                    "','".strtotime($otdline)	."','".$ottt."','".$oid."','".$batid."','".$sec."')");	
	
        return $rows;    
        
    }
    function putSubmission($sid,$detail,$date,$res,$otid)
    {
        $result = mysql_query("select * from MSUBMISSIONT");
        $rows = mysql_num_rows($result);
	
        mysql_query("insert into MSUBMISSIONT values('".$rows."','".$sid."','".$detail."','".strtotime($date)."','".$res."','".$otid."')");	
        return $rows;    
        
    }
    function computeResult($detail,$otid)
    {
	
	$array = explode(';',$detail);
	//print_r($array);
	$result = 0;
	for($i=0;$i<count($array);$i++)
	{
	    $arr2 = explode(":",$array[$i]);
	    $motid = $arr2[0];
	    $answer = $arr2[1];
	    //echo $motid;
	    $res = queryMe("select * from MOTESTT where motid like '".$motid."'");
	    $correct = explode(';',$res["motcorrect"]);
	    //print_r($correct);
	    if(in_array($answer,$correct))
		$result++;
	    
	}
	return $result;
	
    }
    function updateObjectiveTest($otid,$otname,$otdate,$otsub,$otdline,$ottt,$batid,$sec)
    {
        
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
    function getSubmission($otid,$sid)
    {
	
	return queryMe("select * from MSUBMISSIONT where sid like '".$sid."' and otid like '".$otid."'");
	
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
        
        $result = mysql_query("select * from MOTESTT");
        $rows = mysql_num_rows($result);
        
        $motoptions = implode(";",$optext);
        $motcorrect = implode(";",$opcorrect);
        
        mysql_query("update MOTESTT set motques=\"".$ques."\" where motid like '".$motid."'");
	//echo "update MOTESTT set ques=\"".$ques."\" where motid like '".$motid."'";
        mysql_query("update MOTESTT set motoptions=\"".$motoptions."\" where motid like '".$motid."'");
        mysql_query("update MOTESTT set motcorrect='".$motcorrect."' where motid like '".$motid."'");
        return $rows;
    }
    function updateQuestionCount($otid,$otcnt)
    {
	      
        mysql_query("update OTAVAILT set otcnt='".$otcnt."' where otid like '".$otid."'");
       
	
    }
    function updateQuestionTreshold($otid,$ottresh)
    {
	      
        mysql_query("update OTAVAILT set otthresh='".$ottresh."' where otid like '".$otid."'");
       
	
    }
    function getQuestions($otid)
    {
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
    function getObjectiveEntries($batid,$sec,$obid='%')
    {
	
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
	    
	    if(($oid == $obid) || ($obid == "%"))
	    {
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
	}
       return $returnLinks;
    }
    function getSubmissionAsArray($submid)
    {
        
        
        $result = mysql_query("select * from MSUBMISSIONT where submid like '".$submid."' order by(submid) ASC");
        $returnLinks = array();
	$row=mysql_fetch_array($result);
	
	$submid = $row["submid"];
	$sid = $row["sid"];
	$stu = getStudent($sid);
	$detail = $row["detail"];
	$otid = $row["otid"];
	$result = $row["result"];
	
        $returnLinks["Id"] = $submid;
	$returnLinks["Student"] = $stu;
	$returnLinks["Detail"] = array();
        $array = explode(';',$detail);
	
	
	for($i=0;$i<count($array);$i++)
	{
	    $arr2 = explode(":",$array[$i]);
	    $motid = $arr2[0];
	    $answer = $arr2[1];
	    //echo $motid;
	    $res = queryMe("select * from MOTESTT where motid like '".$motid."'");
	    $correct = explode(';',$res["motcorrect"]);
	    $returnLinks["Details"][$i] = array();
	    $returnLinks["Details"][$i]["Qid"] = $motid;
	    $returnLinks["Details"][$i]["Aid"] = $answer;
	    if(in_array($answer,$correct))
		$returnLinks["Details"][$i]["Status"] = "True";
	    else
		$returnLinks["Details"][$i]["Status"] = "False";
	    
	}
	
       return $returnLinks;
    }
    
    function getObjectiveEntryAsArray($otid)
    {
	
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
 function getObjectiveEntriesByBatIdSec($batid,$sec)
    {
	
	$query = "SELECT * From OTAVAILT where batid like '".$batid."' and sec like '$sec'";
	$result = mysql_query($query);
	$returnLinks = array();
	$i=0;
	while($row=mysql_fetch_array($result))
	{
	    $otid = $row["otid"];
		$oid = $row["oid"];
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
	    $returnLinks[$i]["Object"] = $oid;
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
    function checkSubmitted($otid,$sid)
    {
	//xDebug("select * from MSUBMISSIONT where sid like '".$sid."' and otid like '".$otid."'");
	$res = mysql_query("select * from MSUBMISSIONT where sid like '".$sid."' and otid like '".$otid."'");
	xDebug(mysql_num_rows($res));
	if(mysql_num_rows($res)==0)
	    return FALSE;
	else
	    return TRUE;
    }
    function getSubmissionsForOtid($otid)
    {
	$res = mysql_query("select * from MSUBMISSIONT where otid='".$otid."' order by(date)");
	$returnX = array();
	
	$i =0;
	while($row = mysql_fetch_array($res))
	{
	    $id = $row["submid"];
	    $detail = $row["detail"];
	    $student = getStudent($row["sid"]);
	    $date = date("d-M-y",$row["date"]);
	    $result = $row["result"];
	    
	    $returnX[$i] = array();
	    $returnX[$i]["Id"] = $id;
	    $returnX[$i]["Student"] = $student;
	    $returnX[$i]["date"] = $date;
	    $returnX[$i]["detail"] = $detail;
	    $returnX[$i]["result"] = $result;
	    $i++;
	}
	return $returnX;
    }
    function getSubmissionCount($otid)
    {
	
	$res = mysql_query("select * from MSUBMISSIONT where otid='".$otid."' order by(date)");
	return mysql_num_rows($res);
    }
    function getCorrectCount($motid2)
    {
	$question = getQuestion($motid2);
	$submissions = getSubmissionsForOtid($question["otid"]);
	//print_r($submissions);
	$result = 0;
	for($j=0;$j<count($submissions);$j++)
	{
	    $detail = $submissions[$j]["detail"];
	    $array = explode(';',$detail);
	    
	    for($i=0;$i<count($array);$i++)
	    {
	        $arr2 = explode(":",$array[$i]);
	        $motid = $arr2[0];
	        $answer = $arr2[1];
		
	        if($motid == $motid2)
		{
		    $res = queryMe("select * from MOTESTT where motid like '".$motid."'");
		    $correct = explode(';',$res["motcorrect"]);
		    //echo $answer;    
		    if(in_array($answer,$correct))
		    {
			$result++;
			
		    }
		}	        
	    }
	     
	    
	}
	return $result;
	
    }
?>
