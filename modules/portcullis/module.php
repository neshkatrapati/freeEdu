<?php
    require_once "../lib/classes.php";
    require_once "../lib/mod_lib.php";
    class portcullis_ModuleInfo extends ModuleInfo
    {
        
        public function module_getInfo()
        {
            $array = array(
                           
                           "name" => "Portcullis-freeEdu Extension",
                           "mod_name" => "mod_portcullis",
                           "mod_tag" => "portcullis",
                           "authors" => array("Ganesh Katrapati"),
                           "dependencies" => array("mod_core","mod_rayon")
                            
                           );
            return $array;
            
        }
        public function module_dbaccess()
        {
            $array = array("read" => array("MOBJECTT","MMARKST","MSTUDENTT","MSUBJECTT"),
                           "update" => array("MMARKST")
                           );
            return $array;
            
        }
        public function module_getLinkInfo()
        {
            $array = array(
                             array(
                                    "mode" => "marks_portcullis",
                                    "title" => "Import From A Portcullis Database",
                                    "file" => "portcullis_import.php",
                                    "type" => "child",
                                    "parent" => "marks",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo"),
                                    "tag" => "portcullis.import_marks"
                                  ),
                            
                           );
            return $array;
        }
  		public function module_getConfigInfo(){
  			$mc = new Module_Config();
  			$mc->addKey("DB Username","dbuname",$mc->TYPE_TEXT);		
  			$mc->addKey("DB Password","dbpass",$mc->TYPE_TEXT);
  			$mc->addKey("DB Name","dbname",$mc->TYPE_TEXT);
  			return $mc;
  		}      
  		public function module_setConfigInfo($params){
  		  	return "Error At Database !";	
  		}
    }

?>