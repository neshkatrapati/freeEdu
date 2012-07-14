<?php
require_once 'yaper/reader.php';
class ExcelReader
{

     
    public function parse($filename) 
    {
        
			$data = new Spreadsheet_Excel_Reader();
		  // Set output Encoding.
		   $data->setOutputEncoding('CP1251');
		   $data->read($filename);
     	   $colname=array('id','name');
			
			for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
				for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
					$product[$i-1][$j-1]=$data->sheets[0]['cells'][$i][$j];
				}
		}
			return $product;
        
    }
}
?>
