<?php
require_once 'reader.php';

$filename="itemtypes.xls";
$prod=parseExcel($filename);
echo"<pre>";
print_r($prod);

function parseExcel($excel_file_name_with_path)
{
	$data = new Spreadsheet_Excel_Reader();
	// Set output Encoding.
	$data->setOutputEncoding('CP1251');
	$data->read($excel_file_name_with_path);

	$colname=array('id','name');

	for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
		for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
		
			$product[$i-1][$j-1]=$data->sheets[0]['cells'][$i][$j];
			$product[$i-1][$colname[$j-1]]=$data->sheets[0]['cells'][$i][$j];
		}
	}
	return $product;
}