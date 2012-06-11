<?php

    class assignment_ModuleInfo extends ModuleInfo
    {
        
        public function module_getInfo()
        {
            $array = array(
                           
                           "name" => "Subjective Assignment",
                           "mod_name" => "mod_assignment",
                           "mod_tag" => "assignment",
                           "authors" => array("Ganesh Katrapati"),
                           "dependencies" => array("mod_core")
                            
                           );
            return $array;
            
        }
        public function module_dbaccess()
        {
            $array = array("create" => array(
                                    array("name" => "MASSIGNMENTT",
                                    "sql" => "create table MASSIGNMENTT(asid text,asname text,oid text,batid text,sec` text,subid text,cdate text,docpath text")),
                           "read" => array("MOBJECTT","MSTUDENTT","MBATCHT","MBRANCHT","MREGT","MFEEDBACKT","FBAVAILT","MFACULTYT"),
                           "update" => array("MASSIGNMENTT")
                           );
            return $array;
            
        }
        public function module_getLinkInfo()
        {
            $array = array(
                           array(
                                    "title" => "Subjective Assignments",
                                    "type" => "parent",
                                    "parent" => "/",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo","student","admin","faculty"),
                                    "tag" => "assignment",
                                  
                                  ),
                            array(
                                    "mode" => "as_create",
                                    "title" => "Create A Assignment",
                                    "file" => "createassignment.php",
                                    "type" => "child",
                                    "parent" => "assignment",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo","faculty"),
                                    "tag" => "assignment.create"
                                  ),
                            array(
                                    "mode" => "as_see_stu",
                                    "title" => "See Assignment",
                                    "file" => "showassignment_stu.php",
                                    "type" => "child",
                                    "parent" => "assignment",
                                    "createMenuItem" => "yes",
                                    "perms" => array("student"),
                                    "tag" => "assignmet.see_stu"
                                  ),

                            array(
                                    "mode" => "as_edit",
                                    "title" => "Edit A Assignment",
                                    "file" => "editassignment.php",
                                    "type" => "child",
                                    "parent" => "assignment",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo","faculty"),
                                    "tag" => "feedback.create"
                                  )
			
                           
                           );
            return $array;
        }
        
        public function module_setConfigInfo($params){
        	return "config_success";
        }
    }

?>
