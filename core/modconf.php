<link rel="stylesheet" href="../aux/bootstrap/bootstrap.css"
	type="text/css" media="screen" />

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
			echo "<center><div style='width:80%'><h1 style='font-size:12px' class='box'>Welcome To ".$info["name"]." Config Page!</h1>";
			if(count($keys)>0){
				if(!isset($_POST["phase1"]) && $_GET["check"]!="true"){
					
					echo "<form action='#' method='post'>";
					
					if(isModConfigured($modtag)){
						echoError("This Module Might Have Been Configured Already! <a href='?modtag=$modtag&check=true'>Check</a>");
					}
					
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
				}
				if(isset($_POST['phase1']) && $_GET["check"]!='true'){
					$return = $class->module_setConfigInfo($_POST);
					
					if($return == $CONFIG_SUCCESS){
						echoSuccess("<a href='?modtag=$modtag'>Go Back</a>");
						echoSuccess("Module Configured Properly");
						
					}
					else{
						echoSuccess("<a href='?modtag=$modtag'>Go Back</a>");
						echoError("Configuration Failure");
						echo "<center><div class='box' style='width:50%'>Error Message:<br>".$return."</div></center>";
						
					}
					
				}
				if($_GET["check"] == "true"){
					$mod = getModule($modtag);
					$modauth = $mod["mod_authtoken"];
					$keys = getConfigKeys($modauth);
					echo "<center><table><th class='red'>Key</th><th class='red'>Value</th>";
					for($i=0;$i<count($keys);$i++){
						echo "<tr>";
						$key = $keys[$i][0];
						$value = $keys[$i][1];
						echo "<td>$key</td>";
						echo "<td>$value</td>";
						echo "</tr>";
					}
					echo "</table></center>";
					echoSuccess("<a href='?modtag=$modtag'>Go Back</a>");
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
		echo "<br><center><h3 class='label success'>$string</h3></center><br>";
	}

	function echoError($string){
		echo "<br><center><h3 class='label warning'>$string</h3></center><br>";
	}


	?>