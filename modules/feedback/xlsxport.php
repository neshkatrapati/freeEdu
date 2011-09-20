<?php
    $fid = $_POST["fbid"];
    include("fb_lib.php");
    //include("../../misc/constants.php");
     require_once 'Spreadsheet/Excel/Writer.php';
        require '../../misc/constants.php';
         require '../../lib/lib.php';
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
	
        
         $docname = "Feedback-".$fbname.".xls";
        
        $workbook = new Spreadsheet_Excel_Writer();
        $format=& $workbook->addFormat();
        $format->setSize(10);
        $worksheet =& $workbook->addWorksheet();
        
               
      
      
        $format_center =&$workbook->addFormat();
        $format_center->setHAlign('center');
        $format_center->setBorder(2);
        
        
        
	$faculty = array();
	$i = 0;
	$xnum =0;
	 $worksheet->write(0,0,"RollNumber",$format_center);
         $pointer = 1;
	while($row = mysql_fetch_array($result2))
	{
	    $fac = getFaculty($row["fid"]);
	     $worksheet->write(0,$pointer,$fac["fname"],$format_center);
	    $pointer++;
	}
	$totalrating = array();
	while($row2 = mysql_fetch_array($result3))
	{
	    $sql = "SELECT * FROM MFEEDBACKT where sid like '".$row2['sid']."'";
	    $sqlres = mysql_query($sql);
	    $student = getStudent($row2["sid"]);
	     $worksheet->write($xnum+1,0,$student["srno"],$format_center);
            
	    $cnt = 0;
	    while($srow = mysql_fetch_array($sqlres))
	    {
		 $worksheet->write($xnum+1,$cnt+1,$srow["rating"],$format_center);
            
                
		$totalrating[$cnt] += $srow["rating"];
		$cnt++;
	    }
	    $ret .= "</tr>";
	    $xnum++;
	}
	$worksheet->write($xnum+1,0,"Cumulative Result",$format_center);
	
	for($i=0;$i<count($totalrating);$i++)
	{
	    
	    $worksheet->write($xnum+1,$i+1,$totalrating[$i],$format_center);
	  
	    
	}
        $worksheet->write($xnum+2,0,"Average Result",$format_center);
	for($i=0;$i<count($totalrating);$i++)
	{
	    
	    $worksheet->write($xnum+2,$i+1,round($totalrating[$i]/$xnum,2),$format_center);
	    
	    
	}
	 $workbook->send($docname);
        $workbook->close();
?>