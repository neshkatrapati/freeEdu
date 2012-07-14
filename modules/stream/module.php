<?php

    class stream_ModuleInfo extends ModuleInfo
    {
        
        public function module_getInfo()
        {
            $array = array(
                           
                           "name" => "Object Stream",
                           "mod_name" => "mod_stream",
                           "mod_tag" => "stream",
                           "authors" => array("Ganesh Katrapati"),
                           "dependencies" => array("mod_core"),
                           
                            
                           );
            return $array;
            
        }
        public function module_dbaccess()
        {
            $array = array("create" => array(
                                    array("name" => "MSTREAMT",
                                    "sql" => "create table MSTREAMT(sid int,message text,oid int,targets text)"),
                                    array("name" => "MCLIQUET",
                                    "sql" => "create table MCLIQUET(cid int,name text,oid int,targets text)")
                                    ),
                                    
                           "read" => array("MOBJECTT","MSTUDENTT","MBATCHT","MBRANCHT","MREGT","MFEEDBACKT","FBAVAILT","MFACULTYT"),
                           "update" => array("MOBJECTT")
                           );
            return $array;
            
        }
        public function module_getLinkInfo()
        {
            $array = array(
                            array(
                                    "title" => "Stream",
                                    "type" => "parent",
                                    "parent" => "/",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo","student","faculty"),
                                    "tag" => "stream",
                                    "file" => "home.php",
                                    "mode" => "stream",
                                    "show_side_menu" => "false"
                                  ),
                            array(
                                    "title" => "Create A Clique",
                                    "type" => "child",
                                    "parent" => "/",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo","student","faculty"),
                                    "tag" => "stream",
                                    "file" => "clique.php",
                                    "mode" => "clique",
                                    "show_side_menu" => "false",
                                    "parent" => "stream"
                                  )
                           
                           
                           );
            return $array;
        }
        public function module_space_switchboard(){
				return array("space1" => array("weight" => 0,"spaces"=>array("rayon.add_marks","roster.upload_attendance"))
							);
		}
        public function module_getRenderData(){
			
				return array("null" => array("table"=>"MSTREAMT","searchby"=>array("sid","oid")));
		}
    }

?>
