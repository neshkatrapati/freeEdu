<?php

    class feedback_ModuleInfo extends ModuleInfo
    {
        
        public function module_getInfo()
        {
            $array = array(
                           
                           "name" => "Feedback Forms",
                           "mod_name" => "mod_feedback",
                           "mod_tag" => "feedback",
                           "authors" => array("Sandeep Billakanti"),
                           "dependencies" => array("mod_core"),
                           "css" => array("a.css","b.css")
                            
                           );
            return $array;
            
        }
        public function module_dbaccess()
        {
            $array = array("create" => array(
                                    array("name" => "MFEEDBACKT",
                                    "sql" => "create table MFEEDBACKT(fbid text,fbname text,fbdatec text,fbdatee text,fbmin text,fbmax text,fbcid text,batid text,sec text)"),
                                    array("name" => "FBAVAILT",
                                    "sql" => "create table MFEEDBACKT(feedid text,sid text,fid text,rating text,date text,fbid text)")
                                ),
                           "read" => array("MOBJECTT","MSTUDENTT","MBATCHT","MBRANCHT","MREGT","MFEEDBACKT","FBAVAILT","MFACULTYT"),
                           "update" => array("MFEEDBACKT","FBAVAILT")
                           );
            return $array;
            
        }
        public function module_getLinkInfo()
        {
            $array = array(
                            array(
                                    "title" => "Feedback Forms",
                                    "type" => "parent",
                                    "parent" => "/",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo","student"),
                                    "tag" => "feedback",
                                  ),
                            array(
                                    "mode" => "fb_create",
                                    "title" => "Create A Feedback",
                                    "file" => "fbcreate.php",
                                    "type" => "child",
                                    "parent" => "feedback",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo"),
                                    "tag" => "feedback.create"
                                  ),
                            array(
                                    "mode" => "fb_get",
                                    "title" => "Analyse Feedback",
                                    "file" => "fbget.php",
                                    "type" => "child",
                                    "parent" => "feedback",
                                    "createMenuItem" => "yes",
                                    "perms" => array("sudo"),
                                    "tag" => "feedback.create"
                                  ),
                            array(
                                    "mode" => "fbput",
                                    "title" => "Submit A Feedback Form",
                                    "file" => "fbput.php",
                                    "type" => "child",
                                    "parent" => "feedback",
                                    "createMenuItem" => "yes",
                                    "perms" => array("student"),
                                    "tag" => "feedback.create"
                                  )
			
                           
                           );
            return $array;
        }
        public function module_space_switchboard(){
				return array("space1" => array("weight" => 0,"spaces"=>array("rayon.add_marks","roster.upload_attendance"))
							);
		}
        public function module_getConfigInfo(){
        	$mc = new Module_Config();
        	$mc->addKey("Max Rating","maxrating",$mc->TYPE_TEXT);
        	$mc->addKey("Min Rating","minrating",$mc->TYPE_TEXT);
        	return $mc;
        }
        public function module_getRenderData(){
			
				return array("getlist"=>array("table"=>"FBAVAILT","searchby"=>array("fbid","fbname","fbdatec","fbdatee","fbcid","batid","sec")),
							 "fbid" => array("table"=>"MFEEDBACKT","searchby"=>array("fbid","sid","fid","rating","date"),"as"=>"f","include"=>array(array("name"=>"sname","query"=>"select sname from MSTUDENTT s where s.sid=f.sid"),array("name"=>"fname","query"=>"select fname from MFACULTYT ft where ft.fid=f.fid")))
							);
		}
        public function module_setConfigInfo($params){
        	return "config_success";
        }
        public function module_after_install(){
			
			freeedu_add_css("a.css");
		}
    }

?>
