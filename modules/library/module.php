<?php
    require_once "../lib/classes.php";
    class library_ModuleInfo extends ModuleInfo
    {
        
        public function module_getInfo()
        {
            $array = array(
                           
                           "name" => "Library",
                           "mod_name" => "mod_library",
                           "mod_tag" => "library",
                           "authors" => array("Aditya Maturi"),
                           "dependencies" => array("mod_core")
                            
                           );
            return $array;
            
        }
        public function module_dbaccess()
        {
            $array = array("create" => array(
                                    array("name" => "MLIBRARYT",
                                    "sql" => "create table MLIBRARYT(lib text,bookid text,bname text,bauthor text,bpub text,reg text,bedition text,brid text,akyr text,imgid text,ncps text)")
                                                                   ),
                           "read" => array("MOBJECTT","MSTUDENTT","MBATCHT","MBRANCHT","MREGT","MLIBRARYT","MIMGT","MDOCT"),
                           "update" => array("MLIBRARYT")
                           );
            return $array;
            
        }
        public function module_getLinkInfo()
        {
            $array = array(
                            
                            array(
                                    "mode" => "add_book",
                                    "title" => "Create A Book",
                                    "file" => "addBook.php",
                                    "type" => "child",
                                    "parent" => "library",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo"),
                                    "tag" => "library.book.create"
                                  ),
			    array(
                                    "mode" => "lib_ebookcreate",
                                    "title" => "Add E-Book",
                                    "file" => "addEbook.php",
                                    "type" => "child",
                                    "parent" => "library",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo"),
                                    "tag" => "library.ebook.create"
                                  ),
                            
                            array(
                                    "title" => "Library",
                                    "type" => "parent",
                                    "parent" => "/",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo"),
                                    "tag" => "library"
                                  )
                           
                           );
            return $array;
        }
        public function module_getConfigInfo(){
        	$mc = new Module_Config();
        	$mc->addKey("Max Rating","maxrating",$mc->TYPE_TEXT);
        	$mc->addKey("Min Rating","minrating",$mc->TYPE_TEXT);
        	return $mc;
        }
        public function module_setConfigInfo($params){
        	return "config_success";
        }
    }

?>