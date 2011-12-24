<?php
	require_once '../lib/connection.php';
	$CONFIG_SUCCESS = "config_success";
	function addConfigKey($mod_auth_token,$key,$value){
		
		$x = mysql_query("select * from MMODULET where mod_authtoken='".$mod_auth_token."'");
		if(!$x){
				return false;
			}
		
		$module = mysql_fetch_array($x);
		$modid = $module['mod_tag'];
		if(mysql_query("INSERT INTO MODCONFT values('$modid','$key','$value')")){
				return true;
		}
		else{
			return false;
		}
	}
	function getConfigValue($mod_auth_token,$key){
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
	
		$x = mysql_query("select * from MMODULET where mod_authtoken='".$mod_auth_token."'");
		if(!$x){
				return false;
			}
		
		$module = mysql_fetch_array($x);
		$modid = $module['mod_tag'];
		$x2 = mysql_query("SELECT * FROM MODCONFT where `key` like '$key' and modtag like '$modid'");
		
		if(!$x2){
				return false;
			}
		else
		{
				$t = mysql_fetch_array($x2);
				return $t['value'];
		}
	
	}
function getConfigKeys($mod_auth_token){
	$x = mysql_query("select * from MMODULET where mod_authtoken='".$mod_auth_token."'");
	if(!$x){
		return false;
	}
	
	$module = mysql_fetch_array($x);
	$modid = $module['mod_tag'];
	$x2 = mysql_query("SELECT * FROM MODCONFT where modtag like '$modid'");
	
	if(!$x2){
		return false;
	}
	else
	{
		while($t = mysql_fetch_array($x2)){
			$arr[$t['key']] = array($t['key'],$t['value']);
		}
		return $arr;
	
	}
}
class Module_Config{
	
	public function __construct(){
		$this->keys = array();
	    $this->TYPE_TEXT = 'text';
	    $this->TYPE_SELECT = 'select';
	    $this->TYPE_SELECT_MULTIPLE = 'select_m';
	
	}	
	public function addKey($keylabel,$keyname,$keytype,$choices=NULL){
		$keyarray = array("name"=>$keyname,"label" => $keylabel,"type" =>$keytype,"attrs"=>array(),"choices"=>$choices);
		$this->keys[] = $keyarray;	
	
	}
	public function setAttribute($key,$attribute,$value){
		$keyarray = $this->keys[$key];
		$keyarray->attrs[$attribute] = $value;
	}
	public function getKeys(){
		return $this->keys;
	}
}
function getModule($modtag){
	$result = mysql_query("select * from MMODULET where mod_tag like '$modtag'");
	$array = mysql_fetch_array($result);
	return $array;
	
}
function isModConfigured($modtag){

	
	$res = mysql_query("SELECT * FROM MODCONFT where modtag like '$modtag'");
	//echo "SELECT * FROM MODCONFT where modtag like '$modtag'";
	if(mysql_num_rows($res)<=0){
		return False;
	}
	else{
		return True;
	}
}
function module_error($errstr){
	$debugarr = debug_backtrace();
	return array($errstr,$debugarr[0]["line"]);
}

	
?>
