<?php 
    	$con = mysql_connect("localhost","root","1234");
	mysql_select_db("freeEdu", $con);
?>
<?php
        require_once 'Spreadsheet/Excel/Writer.php';
             
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
