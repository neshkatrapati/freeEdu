<?php

    class library_ModuleInfo extends ModuleInfo
    {
        
        public function module_getInfo()
        {
            $array = array(
                           
                           "name" => "Library",
                           "mod_name" => "mod_library",
                           "mod_tag" => "library",
                           "authors" => array("Aditya Maturi"),
                           "dependencies" => array("mod_core"),
			   
                            
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
                           "update" => array("MLIBRARYT","MDOCTT")
                           );
            return $array;
            
        }
        public function module_getLinkInfo()
        {
            $array = array(
                            
                            array(
                                    "mode" => "add_book",
                                    "title" => "Add A Book",
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
                                    "mode" => "lib_viewbook",
                                    "title" => "View Books",
                                    "file" => "viewbook.php",
                                    "type" => "child",
                                    "parent" => "library",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo"),
                                    "tag" => "library.view.book"
                                  ),
			     array(
                                    "mode" => "lib_editbook",
                                    "title" => "Edit Books Details",
                                    "file" => "editBook.php",
                                    "type" => "child",
                                    "parent" => "library",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo"),
                                    "tag" => "library.view.book"
                                  ),
			      array(
                                    "mode" => "lib_editebook",
                                    "title" => "edit E-Books Details",
                                    "file" => "editEbook.php",
                                    "type" => "child",
                                    "parent" => "library",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo"),
                                    "tag" => "library.view.book"
                                  ),
			        array(
                                    "mode" => "lib_viewbook",
                                    "title" => "View Books",
                                    "file" => "viewbook.php",
                                    "type" => "child",
                                    "parent" => "library",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo"),
                                    "tag" => "library.view.book"
                                  ),
				 array(
                                    "mode" => "lib_viewebook",
                                    "title" => "View E-Books",
                                    "file" => "viewEbook.php",
                                    "type" => "child",
                                    "parent" => "library",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo"),
                                    "tag" => "library.view.book"
                                  ),
				      array(
                                    "mode" => "lib_viewordered",
                                    "title" => "View Order",
                                    "file" => "viewOrdered.php",
                                    "type" => "child",
                                    "parent" => "library",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo","student"),
                                    "tag" => "library.view.ordered",
				    "show_side_menu" => "false"
                                  ),
				  array(
                                    "mode" => "lib_issueorder",
                                    "title" => "Isuue an Order",
                                    "file" => "issueOrder.php",
                                    "type" => "child",
                                    "parent" => "library",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo"),
                                    "tag" => "library.issue.ordered"
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
