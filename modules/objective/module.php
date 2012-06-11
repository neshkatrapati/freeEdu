<?php

    class objective_ModuleInfo extends ModuleInfo
    {
        
        public function module_getInfo()
        {
            $array = array(
                           
                           "name" => "Create an Objective tests",
                           "mod_name" => "mod_objective",
                           "mod_tag" => "objective",
                           "authors" => array("Ganesh Katrapati"),
                                                   
                           );
            return $array;
            
        }
        public function module_dbaccess()
        {
            $array = array("create" => array("OTAVAILT","MOTESTT"),
                           "read" => array("MOBJECTT","MSTUDENTT","MMARKST","MFACULTYT","MAVAILT","MSUBJECTT","SAVAILT"),
                           "update" => array("OTAVAILT","MOTESTT")
                           );
            return $array;
            
        }
        public function module_getLinkInfo()
        {
            $array = array(
							array(
                                    "title" => "Objective Tests",
                                    "type" => "parent",
                                    "parent" => "/",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo","student","faculty","admin"),
                                    "tag" => "objective",
                                  
                                  ),
                             array(
                                    "mode" => "ot_create",
                                    "title" => "Create Objective test",
                                    "file" => "input.php",
                                    "type" => "child",
                                    "parent" => "objective",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo","faculty","admin"),
                                    "tag" => "objective.main"
                                  ),
				array(
                                    "mode" => "ot_edit_meta",
                                    "title" => "Edit Objective tests",
                                    "file" => "editmeta.php",
                                    "type" => "child",
                                    "parent" => "objective",
                                    "createMenuItem" => "no",
                                    "perms" => array("sudo","faculty","admin"),
                                    "tag" => "objective.main"
                                  ),
				
				array(
                                    "mode" => "ot_edit",
                                    "title" => "Edit Objective",
                                    "file" => "editobjective.php",
                                    "type" => "child",
                                    "parent" => "objective",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo","faculty","admin"),
                                    "tag" => "objective.main"
                                  ),
				array(
                                    "mode" => "ot_ques",
                                    "title" => "Edit Objective",
                                    "file" => "otques.php",
                                    "type" => "child",
                                    "parent" => "objective",
                                    "createMenuItem" => "no",
                                    "perms" => array("sudo","faculty","admin"),
                                    "tag" => "objective.main"
                                  ),
				array(
                                    "mode" => "ot_submit",
                                    "title" => "Submit Objective Test",
                                    "file" => "otsubmit.php",
                                    "type" => "child",
                                    "parent" => "objective",
                                    "createMenuItem" => "yes",
                                    "perms" => array("student"),
                                    "tag" => "objective.main"
                                  ),
				array(
                                    "mode" => "ot_submit_see",
                                    "title" => "Submit See",
                                    "file" => "subview.php",
                                    "type" => "child",
                                    "parent" => "objective",
                                    "createMenuItem" => "no",
                                    "perms" => array("sudo","faculty","admin"),
                                    "tag" => "objective.main"
                                  )
                            
                           );
            return $array;
        }
    }

?>
