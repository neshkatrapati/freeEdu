<?php

    class blog_ModuleInfo extends ModuleInfo
    {
        
        public function module_getInfo()
        {
            $array = array(
                           
                           "name" => "Blog",
                           "mod_name" => "mod_blog",
                           "mod_tag" => "blog",
                           "authors" => array("Ganesh Katrapati"),
                           "dependencies" => array("mod_core")
                            
                           );
            return $array;
            
        }
        public function module_dbaccess()
        {
            $array = array("create" => array(
                                    array("name" => "MBLOGT",
                                    "sql" => "create table MBLOGT(blogid text,blogname text,blogobject text,blogdetail text,bctime text)")
                                    
                                ),
                           "read" => array("MOBJECTT","MBLOGT"),
                           "update" => array("MBLOGT")
                           );
            return $array;
            
        }
        public function module_getLinkInfo()
        {
            $array = array(
                            array(
                                    "title" => "Blogs",
                                    "type" => "parent",
                                    "parent" => "/",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo"),
                                    "tag" => "blog",
                                    "mode" => "blog_home",
                                    "file" => "blog_create.php"
                                  ),
                             array(
                                    "mode" => "blog_create",
                                    "title" => "Create A Blog Entry",
                                    "file" => "blog_create.php",
                                    "type" => "child",
                                    "parent" => "blog",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo"),
                                    "tag" => "blogy`rre.create"
                                  ),
                            
                           );
            return $array;
        }
    }

?>
