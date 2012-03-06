<?php
    require_once 'yaml/Yaml.php';
	$params = $_GET;
	$mode = $params["mode"];
	$render = $params["render"];
	$others = get_modules_render();
	$toggle = FALSE;
	if(array_key_exists($mode,$others)){
			jsonify($others[$mode]);
	}
	else{
	switch($mode){
			case "student":require_once 'student.php';break;
			case "marks":require_once 'marks.php'; break;
			case "attendance": jsonify(array(
										"getlist"=>array("table"=>"MATDT", "as" => "a",
														 "searchby"=>array("aid","fid","batid","sec","dayid","sessionid","subid"),
														 "include" => array(array("name"=>"fname","query"=>"select fname from MFACULTYT as f where f.fid=a.fid"))
													,$render),
										"aid"=>array("table"=>"ADATAT", "as" => "ad",
														 "searchby"=>array("aid","adata","pid"), "process"=>array("adata" => array("explode"=>"."),"pa"=> array("replace"=>array("search"=>array("P","A"),"replace"=>array("Present","Absent")
																												                                               )
																												)
																		  )
														 
													)
										
											)
										); break;
			case "subjects" : jsonify(array( "null" => array("table"=>"MSUBJECTT", "searchby" => array("subid","subname","subcode","year","cre","subshort","suid")),
											 "getlist" => array("table"=>"SAVAILT", "searchby" => array("subid","regid"))
										   )
									); break;
									
			case "faculty" : jsonify(array( "null" => array("table"=>"MFACULTYT", "searchby" => array("fid","fname","imgid","fbio","deptid","fcourse")),
			
										   )
								); break;
			case "images" : jsonify(array( "null" => array("table"=>"MIMGT", "searchby" => array("imgid")),
			
										   )
								); break;
			

		
	}
}
	
	function jsonify($args){
		
			$params = $_GET;
			foreach($args as $key=>$value){
					if(array_key_exists($key,$params) || $key == "null"){
							$table = $value["table"];
							$searchby = $value["searchby"];
							$process = $value["process"];
							$w = "";
							$i = 0;
							foreach($searchby as $v){
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
					$as = $value["as"];
					$inc = "";
					if($args[$key]["include"]!=NULL){
							
							for($k=0;$k<count($args[$key]["include"]);$k++){
									$in = $args[$key]["include"][$k]["query"];
									$inname = $args[$key]["include"][$k]["name"];
									$inc .= ",($in) as $inname";
							}
					}
					
					$t = mysql_query("select *$inc from $table $as $w ");
	               
				if($process == NULL){
					while($arr =  mysql_fetch_assoc($t)){
							$students["Records"][] = $arr;
	
					}
				}
				
				else{
					$cx = 0;
					while($arr =  mysql_fetch_assoc($t)){
							foreach($arr as $k=>$v){
									if(array_key_exists($k,$process)){
											$rules = $process[$k];
											if(array_key_exists("explode",$rules)){
												$arr[$k] = explode($rules["explode"],$arr[$k]);
											}
											if(array_key_exists("replace",$rules)){
												$arr[$k] = str_replace($rules["replace"]["search"],$rules["replace"]["replace"],$arr[$k]);
											}
									}
							}
							$students["Records"][$cx] = $arr;
							unset($arr);
							$cx++;
	
					}	
				}
				
				if($_GET["render"] == "xml"){
				header('Content-type: application/xml');
				//print_r($students);
				echo xml_encode($students);
				}
				elseif($_GET["render"] == "yaml"){
						print Yaml::dump($students);
				}
				else
					echo json_encode($students);
			
	
				}
			}
		
	}
function xml_encode($mixed,$domElement=null,$DOMDocument=null){
    if(is_null($DOMDocument)){
        $DOMDocument=new DOMDocument;
        $DOMDocument->formatOutput=true;
        xml_encode($mixed,$DOMDocument,$DOMDocument);
        echo $DOMDocument->saveXML();
    }
    else{
        if(is_array($mixed)){
            foreach($mixed as $index=>$mixedElement){
                if(is_int($index)){
                    if($index==0){
                        $node=$domElement;
                    }
                    else{
                        $node=$DOMDocument->createElement($domElement->tagName);
                        $domElement->parentNode->appendChild($node);
                    }
                }
                else{
                    $plural=$DOMDocument->createElement($index);
                    $domElement->appendChild($plural);
                    $node=$plural;
                    if(rtrim($index,'s')!==$index){
                        $singular=$DOMDocument->createElement(rtrim($index,'s'));
                        $plural->appendChild($singular);
                        $node=$singular;
                    }
                }
                xml_encode($mixedElement,$node,$DOMDocument);
            }
        }
        else{
            $domElement->appendChild($DOMDocument->createTextNode($mixed));
        }
    }
}
?>
