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
    
	if(method_exists($class, "module_getConfigInfo")){
		
		$module_config = $class->module_getConfigInfo();
		if(get_class($module_config) == "Module_Config"){
			
			$keys = $module_config->getKeys();
			if(count($keys)>0){
				
				
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