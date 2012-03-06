<?php
	$rollnum = strtoupper($_GET["srno"]);
	
	$wheres = array("sid","srno","sname","batid","sec");
	$w = "";
	$i = 0;
	foreach($wheres as $v){
			if($_GET[$v]!=""){
				if($i!=0)
					$w .= " and ";
			    $x = $_GET[$v];
				$w .= "$v like '$x'";
				$i++;
			}
		
	}
	if($w != "")
			$w = " where $w";
	$t = mysql_query("select *,(select imguri from MIMGT i where i.imgid=s.imgid) as img from MSTUDENTT s $w");
	//echo "select *,(select imguri from MIMGT i where i.imgid=s.imgid) as img from MSTUDENTT s $w";
	while($arr =  mysql_fetch_assoc($t)){
			$students["Records"][] = $arr;
	
	}
	if($_GET["render"] == "xml"){
			header('Content-type: application/xml');
			
			echo xml_encode($students);
			}
			elseif($_GET["render"] == "yaml"){
					print Yaml::dump($students);
			}
			else
				echo json_encode($students);
			
			
	
	
?>
