<?php
            if(!isset($_POST["phase1"]))
            {
                $dirlist = module_parser();
		echo "<h2>Install New Modules</h2><center><form action='#' method='post'>";
		echo "<table class='bttable' style='border:2px solid black;'>";
		echo "<th class='zebra-striped' colspan='3'>Modules</th><tr><td>
		<table class='bttable'><th class='zebra-striped'>Module Name</th><th class='zebra-striped'>Authors</th><th class='zebra-striped'>Status</th>";
		for($i=0;$i<count($dirlist);$i++)
		{
			echo "<tr>";
			
			require_once($dirlist[$i]["modfile"]);
			
			$class = $dirlist[$i]["name"]."_ModuleInfo";
			
			$instance = new $class();
			$info = $instance->module_getInfo();
			
			echo "<td>".$info["name"]."</td>";
			$dbaccess = $instance->module_dbaccess();
			$dbcreate = $dbaccess["create"];
			$dbread = $dbaccess["read"];
			$dbupdate = $dbaccess["update"];
                        $read = array();
                        $update = array();
			$links = $instance->module_getLinkInfo();
                        echo "<input type='hidden' name='modnames[]' value='".$dirlist[$i]["name"]."'></input>";
                        echo "<input type='hidden' name='modfiles[]' value='".$dirlist[$i]["modfile"]."'></input>";    
			echo "<td>".implode(', ',$info["authors"])."</td>";
			
			$clsname = "Constants";
			$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
			mysql_select_db($clsname::$dbname, $con);
			
			$res = mysql_query("select * from MMODULET where mod_tag like '".$dirlist[$i]["name"]."'");
			if(mysql_num_rows($res)==0)
				    $chval = '';
			else
				    $chval = "checked";
				    
                        echo "<td><input type='checkbox' name='modules[]' value='".$i."' ".$chval."></input>&emsp;<img src='../images/others/expandico.gif' style='float:right' onclick='showModuleDetails(\"mod".$i."\",this)'></td>
			<tr><td colspan='3' id='mod".$i."' style='display:none'><div class='box'>Db Access:";
			echo "</br>Creates Tables: ";
			for($j=0;$j<count($dbcreate);$j++)
				echo $dbcreate[$j]["name"]." ";
			echo "</br>Acesses Tables: ";
			for($j=0;$j<count($dbread);$j++){
				echo $dbread[$j]." ";
                                $read[$j] = $dbread[$j];
			}
			echo "</br>Updates Tables: ";
			for($j=0;$j<count($dbupdate);$j++){
				echo $dbupdate[$j]." ";
                                $update[$j] = $dbupdate[$j];
			}
			echo "</div><div class='box'>Creates Links: ";
			for($j=0;$j<count($links);$j++)
				echo $links[$j]["title"]."<br>";
                        $r = implode(";",$read);
                        $u = implode(";",$update);
			
			echo"</div></td></tr>";
			echo "</tr>";
                        echo "<input type='hidden' name='modreads[]' value='".$r."'></input>";
                        echo "<input type='hidden' name='modupdates[]' value='".$u."'></input>";    
			
		}
		echo "</center></table></td></tr><tr><td colspan='3'><center><input type='submit' name='phase1'></input></center></td></tr></table></form>";
            }
            else
            {
                
                $modnames = $_POST["modnames"];
                $modfiles = $_POST["modfiles"];
                  $modreads = $_POST["modreads"];
                    $modupdates = $_POST["modupdates"];
                $enables = $_POST["modules"];
                $list = array();
                    for($i=0;$i<count($enables);$i++)
                    {
                        $list[$i]["tag"] = $modnames[$enables[$i]];
                        $list[$i]["file"] = substr($modfiles[$enables[$i]],3);
                        require_once $modfiles[$enables[$i]];
			$class = $modnames[$enables[$i]]."_ModuleInfo";
			$instance = new $class();
			$dbaccess = $instance->module_dbaccess();
			$dbcreate = $dbaccess["create"];
			
                        for($j=0;$j<count($dbcreate);$j++)
				queryMe($dbcreate[$j]["sql"]);
			
                        
                        $list[$i]["reads"] = $modreads[$enables[$i]];
                        $list[$i]["updates"] = $modupdates[$enables[$i]];
                    }
                    enableModules($list);
                    notify("Modules Updated Successfully");
                    redirect("?m=modules");
                
            }

?>