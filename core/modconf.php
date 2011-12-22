<link rel="stylesheet" href="../aux/bootstrap/bootstrap-1.0.0.css" type="text/css" media="screen" />
<?php
	require_once '../lib/connection.php';
	require_once '../lib/mod_lib.php';
	$modtag = $_GET["modtag"];
	$module = getModule($modtag);
	$modfile = "../".$module['mod_file'];
	require_once $modfile;
	$mod_name = $module['mod_tag'];
	$cls = $mod_name."_ModuleInfo";
    $class =  new $cls();
    
	if(method_exists($class, "module_getConfigInfo") && method_exists($class, "module_setConfigInfo")){
		
		$module_config = $class->module_getConfigInfo();
		$info = $class->module_getInfo();
		if(get_class($module_config) == "Module_Config"){
			
			$keys = $module_config->getKeys();
			if(count($keys)>0){
				
				echo "<form action='#' method='post'>";
				echo "<center><div style='width:80%'><h3 class='box'>Welcome To ".$info["name"]." Config Page!</h3>";
				echo "</div><div><table class='bttable' style='border:2px solid black'>";
				for($i=0;$i<count($keys);$i++){
					echo "<tr>";
					$label = $keys[$i]["label"];
					$type = $keys[$i]["type"];
					$name = $keys[$i]["name"];
					echo "<td>".$label."</td>";
					if($type == $module_config->TYPE_TEXT){
						echo "<td><input type='text' name='$name'></input></td>";
					}
					else if($type == $module_config->TYPE_SELECT){
						$selector = "<select name='$name'>";
						$choices = $keys[$i]["choices"];
						for($j=0;$j<count($choices);$j++){
							$opname = $choices[$j]["name"];
							$opvalue = $choices[$j]["value"];
							$selector .= "<option value='$opvalue'>$opname</option>";
						}
						$selector .= "</select>";
						echo "<td>$selector</td>";
					}
					echo "</tr>";
					
				}
				echo "<tr><td></td><td><input type='submit' class='btn primary' name='phase1'></input></td></tr></table></div>";
				echo "</center>";
				echo "</form>";
				
				if(isset($_POST['phase1'])){
					$class->module_setConfigInfo($_POST);
				}
			}
			else{
				
				echoError("This Module Doesnot Provide any Configuration Keys");
			}
		}
		else{
			echoError("Wrong Configuration! Please Check It!");
		}
	}
	else{
		echoError("No Configuration Function!!");
	}
	function echoSuccess($string){
		echo "<br><center><h3 class='btn success'>$string</h3></center><br>";
	}
	
	function echoError($string){
		echo "<br><center><h3 class='btn danger'>$string</h3></center><br>";
	}
	

?>