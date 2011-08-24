<?php
        /*
                $Id: report_all.php,v 1.1 2004/08/30 16:03:40 chris Exp $
                generate a spreadsheed from and addressbook in mysql database.
        */

       
        
        require_once 'Spreadsheet/Excel/Writer.php';
        require '../misc/constants.php';
       
        $clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
	
        
        $docname = 'Internals.xls';
        
        $workbook = new Spreadsheet_Excel_Writer();
        $format=& $workbook->addFormat();
        $format->setSize(10);
        $worksheet =& $workbook->addWorksheet();
        
               
      
      
        $format_center =&$workbook->addFormat();
        $format_center->setHAlign('center');
        $format_center->setBorder(2);
        
       
	
        $worksheet->write(0,0,"RollNumber",$format_center);
        $worksheet->write(0,1,"Name",$format_center);
        $worksheet->write(0,2,"Internal",$format_center);
        
        $sname = $_POST['sname'];
        $srno = $_POST['srno'];
        $ints = $_POST['ints'];
        
        
        for($i=0;$i<count($sname);$i++)
        {
            
            
             $worksheet->write($i+1,0,$srno[$i],$format_center);
            $worksheet->write($i+1,1,$sname[$i],$format_center);
            $worksheet->write($i+1,2,$ints[$i],$format_center);
        
            
            
        }
        
        
        $workbook->send($docname);
        $workbook->close();
?>