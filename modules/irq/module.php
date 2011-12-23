<?php
    require_once "../lib/classes.php";
    class irq_ModuleInfo extends ModuleInfo
    {
        
        public function module_getInfo()
        {
            $array = array(
                           
                           "name" => "Interactive Result Queriying Module",
                           "mod_name" => "mod_irq",
                           "mod_tag" => "irq",
                           "authors" => array("Ganesh Katrapati"),
                           "dependencies" => array("mod_core","mod_rayon")
                            
                           );
            return $array;
            
        }
        public function module_dbaccess()
        {
            $array = array("create" => array(),
                           "read" => array("MOBJECTT","MSTUDENTT","MMARKST","MFACULTYT","MAVAILT","MSUBJECTT","SAVAILT"),
                           "update" => array("MOBJECTT","MSTUDENTT","MMARKST","MFACULTYT","MAVAILT","MSUBJECTT","SAVAILT")
                           );
            return $array;
            
        }
        public function module_getLinkInfo()
        {
            $array = array(
                             array(
                                    "mode" => "irq_main",
                                    "title" => "Interactive Result Queriying",
                                    "file" => "irqmain.php",
                                    "type" => "child",
                                    "parent" => "marks",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo"),
                                    "tag" => "irq.main"
                                  ),
                            
                           );
            return $array;
        }
    }

?>
