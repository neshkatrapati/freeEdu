<?php
function printPreview()
	{
		$filename = $_FILES["file"]["tmp_name"];
		if($filename!="")
		{

			$newfile = "/tmp/tmp.xls";
			move_uploaded_file($filename, $newfile);	
	      require_once 'spreader.php';
			$reader = new ExcelReader();
			$product = $reader->parse($newfile);
			$outcount = count($product);
			for ($i=0;$i<$outcount;$i++)
			{
				$incount = count($product[$i]);
				for ($j=0;$j<$incount;$j++)
					echo $product[$i][$j]."&emsp;";
				echo "<br />";			
			}
		}	
	}
function readExcel()
	{
		
		$filename = $_FILES["file"]["tmp_name"];
		if($filename!="")
		{
			
			$newfile = "/tmp/tmp.xls";
			move_uploaded_file($filename, $newfile);	
			require_once 'spreader.php';
			$reader = new ExcelReader();
			$product = $reader->parse($newfile);
			return $product;
		}	
	}
	
	function getBranches()
	{
		$clsname = "Constants";
		$dbuname = $clsname::$dbuname;
		$dbpass = $clsname::$dbpass;
		$dbname = $clsname::$dbname;
		$branchtab = $clsname::$branchtab;
		$brnname = $clsname::$brnname;
		$con = mysql_connect("localhost",$dbuname,$dbpass);
		mysql_select_db($dbname, $con);
		$result = mysql_query("SELECT * FROM ".$branchtab);
		$i =0;
		while($row = mysql_fetch_array($result))
  		{
  			$ret[$i] = $row[$brnname]; 
  			$i++;
  		}

		mysql_close($con);
		return $ret;
	
	}	
 	function getRegulations()
	{
		$clsname = "Constants";
		$dbuname = $clsname::$dbuname;
		$dbpass = $clsname::$dbpass;
		$dbname = $clsname::$dbname;
		$regtab = $clsname::$regtab;
		$regname = $clsname::$regname;
		$con = mysql_connect("localhost",$dbuname,$dbpass);
		mysql_select_db($dbname, $con);
		$result = mysql_query("SELECT * FROM ".$regtab);
		$i =0;
		while($row = mysql_fetch_array($result))
  		{
  			$ret[$i] = $row[$regname]; 
  			$i++;
  		}

		mysql_close($con);
		return $ret;
	
	}	
	function getBatches($name,$extra)
	{
		$clsname = "Constants";
		$dbuname = $clsname::$dbuname;
		$dbpass = $clsname::$dbpass;
		$dbname = $clsname::$dbname;
		$regtab = $clsname::$regtab;
		$regname = $clsname::$regname;
		$con = mysql_connect("localhost",$dbuname,$dbpass);
		mysql_select_db($dbname, $con);
		$brfilter = getBranchFilter();
		
		$result = mysql_query("select (select brname from MBRANCHT b where b.brid=c.brid) as brname,brid,batyr from MBATCHT c where brid like '".$brfilter."'");
		$i =0;
		$ret = "<select name='".$name."' ".$extra.">";
		while($row = mysql_fetch_array($result))
  		{
  			$ret  .= "<option value='".$row['brid'].":".$row['batyr']."'>".$row['brname']." ".$row['batyr']."</option>"; 
  			
  		}
		$ret .= "</select>";
		mysql_close($con);
		return $ret;
	
	}
	function getBranchFilter()
	{
		$oid = $_COOKIE['object'];
		$array = queryMe("SELECT otyid,obhandle FROM MOBJECTT WHERE oid like '".$oid."'");
		$oytpe = $array['otyid'];
		if($oytpe!='3')
		{
			return "%";
		}
		else
		{
			
			$nar = queryMe("SELECT brfilter from MADMINT WHERE adid like '".$array['obhandle']."'");
			return $nar['brfilter'];
		}
	}
	function getClasses()
	{
		$clsname = "Constants";
		$dbuname = $clsname::$dbuname;
		$dbpass = $clsname::$dbpass;
		$dbname = $clsname::$dbname;
		$regtab = $clsname::$regtab;
		$regname = $clsname::$regname;
		$con = mysql_connect("localhost",$dbuname,$dbpass);
		mysql_select_db($dbname, $con);
		$result = mysql_query("SELECT akayr FROM MBATCHT");
		$i =0;
		while($row = mysql_fetch_array($result))
  		{
  			$ret[$i] = getFullClass($row['akayr'])."A";
  			$ret[$i+1]=  getFullClass($row['akayr'])."B";
  			$i = $i+2;
  		}

		mysql_close($con);
		return $ret;
	
	}
	function getAllSemsAsSelect($name)
	{
		
		$ret = "<select name='".$name."'>";
		for($i=0;$i<7;$i++)
			$ret .= "<option value='".$i."'>".getFullClass($i+1)."</option>";
		return "</select>".$ret;
		
	}
	function getClassesAsSelect($name,$extra)
	{
		$clsname = "Constants";
		$dbuname = $clsname::$dbuname;
		$dbpass = $clsname::$dbpass;
		$dbname = $clsname::$dbname;
		$regtab = $clsname::$regtab;
		$regname = $clsname::$regname;
		$con = mysql_connect("localhost",$dbuname,$dbpass);
		mysql_select_db($dbname, $con);
		$brfilter = getBranchFilter();
		$result = mysql_query("select (select brname from MBRANCHT b where b.brid=c.brid) as brname,brid,batyr,akayr,batid from MBATCHT c where brid like '".$brfilter."'");
		$i =0;
		$ret = "<select name='".$name."' ".$extra.">";
		
		while($row = mysql_fetch_array($result))
  		{
  			$ret  .= "<option value='".$row['batid'].":A'>".$row['brname']." ".getFullClass($row['akayr']+1)." A</option>"; 
  			$ret  .= "<option value='".$row['batid'].":B'>".$row['brname']." ".getFullClass($row['akayr']+1)." B</option>"; 			
  			
  		}
		$ret .= "</select>";
		mysql_close($con);
		return $ret;
	
	}
	function getSubjectsAsSelect($brid,$regid,$year,$name)
	{
		
		$clsname = "Constants";
		$batname = $clsname::$batname;
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		$array = queryMe("select subid from SAVAILT where brid like '".$brid."' and regid like '".$regid."'");
		$suid = $array['subid'];
		if($suid == "")
			return "ERR_INV_REG_BRNC";
		$sql = "select * from MSUBJECTT where year like '".$year."' and suid like '".$suid."'";
		
		$result = mysql_query($sql);
		$ret = "<select name='".$name."'>";
		while($row = mysql_fetch_array($result))
		{
			$ret .= "<option value='".$row['subid']."'>".$row['subname']."</option>";
			
		}
		$ret .= "</select>";
		return $ret;
		
		
	}
	function getFullClass($akayr)
	{
		switch($akayr)
		{
			case 1:return '1st Year';
			case 2:return '2-1';
			case 3:return '2-2';
			case 4:return '3-1';		
			case 5:return '3-2';
			case 6:return '4-1';
			case 7:return '4-2';
		} 		
	
	}
	function getIdFromClass($cls)
	{
		switch($cls)
		{
			case '1st Year':return 1;
			case '2-1':return 2;
			case '2-2':return 3;
			case '3-1':return 4;	
			case '3-2':return 5;
			case '4-1':return 6;
			case '4-2':return 7;
		} 		
	
	}
	function putBatch($data,$regname,$brnname,$batyr,$A,$B)
	{
	
		//Connection Start		
		$clsname = "Constants";
		$batname = $clsname::$batname;
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		//Connection End
		
		//Fetching Count Start		
		$result = mysql_query("SELECT count(batid) as cnt FROM ".$clsname::$battab);
		$row = mysql_fetch_array($result);
		$count = $row["cnt"];
		//Fetching Count End 
		
		$result2 = mysql_query("SELECT count(oid) cnt FROM MOBJECTT"); 
		$row2 = mysql_fetch_array($result2);
		$objectCount = $row2['cnt'];$insstr .= ",'".$data[$i][$j]."'";
		
		$cntresult = mysql_query("SELECT count(sid) as cnt from MSTUDENTT");
		$rowresult = mysql_fetch_array($cntresult);
		$stuCount = $rowresult['cnt'];		
		
		$outcount = count($data);
	
		
		for ($i=0;$i<$outcount;$i++)
		{
			$incount = count($data[$i]);
			$stuIncrement = $stuCount+$i;
			$insstr = "insert into MSTUDENTT values('".$stuIncrement."'";
			$imgid = "";
		
			for ($j=0;$j<=$incount+1;$j++)
			{
				
				
				if ($j==$incount+1)
				{
					if($i<$A)
						$insstr .= ",'A'";
					else	
						$insstr .= ",'B'";			
				
				}
									
				else if($j==$incount)
					 $insstr .= ",'".$count."'";
					 
				else if ($j==$incount-1)
				{
					$img = "images/faces/".$data[$i][$j].".jpg";
					$sql = "SELECT imgid from MIMGT where imguri like '".$img."'";
					echo $img;
					$sqlresult = mysql_query($sql);
					$imcount = mysql_num_rows($sqlresult);
					if($imcount>0)
					{
						$sqlrows = mysql_fetch_array($sqlresult);					
						$insstr .= ",'".$sqlrows['imgid']."'";
						$imgid = $sqlrows['imgid'];
					}				
					else
					{
							$sql = "SELECT count(imgid) cnt from MIMGT";
							$sqlresult = mysql_query($sql);
							$sqlrows = mysql_fetch_array($sqlresult);
							$imcount = $sqlrows['cnt'];
							$sql = "INSERT INTO MIMGT VALUES('".$imcount."','".$img."')";
							mysql_query($sql);
							$insstr .= ",'".$imcount."'";	
							$imgid = $imcount;			
					
					}
					
					
				}
				else		
					$insstr .= ",'".$data[$i][$j]."'";
				
			}
			$insstr .= ",'','0')";
			mysql_query($insstr);
			$index = $objectCount+$i;
			$makeObject = "insert into MOBJECTT values('".$index."','".$data[$i][1]."','".$data[$i][0]."','0','".$imgid."','','','')";		
			mysql_query($makeObject);
			$insstr = "";			
		}
		
		$brnidt = mysql_fetch_array(mysql_query("select brid from MBRANCHT where brname='".$brnname."'"));
		$brnid = $brnidt["brid"];
	
		$regidt = mysql_fetch_array(mysql_query("select regid from MREGT where regname='".$regname."'"));
		$regid = $regidt["regid"]; 
		
		$battabupd = "insert into MBATCHT values('".$count."','".$brnid."','".$regid."','".$batyr."','0"."')";
		mysql_query($battabupd);		
		notify("Update Done!");
		mysql_close($con);

	}
	function putSubList($data,$regname,$brnname)
	{
		//Connection Start		
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		//Connection End
		
		//Fetching Count Start		
		$result = mysql_query("SELECT count(subid) as cnt FROM SAVAILT");
		$row = mysql_fetch_array($result);
		$subcount = $row["cnt"];
		//Fetching Count End 
		
		//Fetching Object Count 
		$result2 = mysql_query("SELECT count(oid) cnt FROM MOBJECTT"); 
		$row2 = mysql_fetch_array($result2);
		$objectCount = $row2['cnt'];
		
		//Fetching MSUBJECTT count
		$cntresult = mysql_query("SELECT count(subid) as cnt from MSUBJECTT");
		$rowresult = mysql_fetch_array($cntresult);
		$stuCount = $rowresult['cnt'];		
		
		$outcount = count($data);
	
		
		for ($i=0;$i<$outcount;$i++)
		{
			$incount = count($data[$i]);
			$stuIncrement = $stuCount+$i;
			$insstr = "insert into MSUBJECTT values('".$stuIncrement."'";
			$imgid = "";
		
			for ($j=0;$j<=$incount;$j++)
			{
				
				if($j==$incount)
					 $insstr .= ",'".$subcount."'";
					 
				else if ($j==2)
				{
					if($data[$i][$j]=="")
						$data[$i][$j]="images/others/book.jpg";

					$sql = "SELECT imgid from MIMGT where imguri like '".$data[$i][$j]."'";
					
					$sqlresult = mysql_query($sql);
					$imcount = mysql_num_rows($sqlresult);
					if($imcount>0)
					{
						$sqlrows = mysql_fetch_array($sqlresult);					
						$insstr .= ",'".$sqlrows['imgid']."'";
						$imgid = $sqlrows['imgid'];
					}				
					else
					{
							$sql = "SELECT count(imgid) cnt from MIMGT";
							$sqlresult = mysql_query($sql);
							$sqlrows = mysql_fetch_array($sqlresult);
							$imcount = $sqlrows['cnt'];
							$sql = "INSERT INTO MIMGT VALUES('".$imcount."','".$data[$i][$j]."')";
							mysql_query($sql);
							$insstr .= ",'".$imcount."'";	
							$imgid = $imcount;			
					
					}
					
					
				}
				else		
					$insstr .= ",'".$data[$i][$j]."'";
				
			}
			$insstr .= ")";

			echo $insstr."<br/>";
			mysql_query($insstr);
			$index = $objectCount+$i;
			$makeObject = "insert into MOBJECTT values('".$index."','".$data[$i][1]."','".$data[$i][0]."','2','".$imgid."','','','')";		
			mysql_query($makeObject);
			$insstr = "";			
		}
		
		$brnidt = mysql_fetch_array(mysql_query("select brid from MBRANCHT where brname='".$brnname."'"));
		$brnid = $brnidt["brid"];
	
		$regidt = mysql_fetch_array(mysql_query("select regid from MREGT where regname='".$regname."'"));
		$regid = $regidt["regid"]; 
		
		$battabupd = "insert into SAVAILT values('".$subcount."','".$regid."','".$brnid."')";
		mysql_query($battabupd);		
		notify("Update Done!");	
		mysql_close($con);


	}	
	function putMarks($data,$batyr,$brid,$doex,$ros,$akayr)
	{
		
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		//Fetching MAVAILT Count
		$result = mysql_query("SELECT count(mrid) as cnt FROM MAVAILT");
		$row = mysql_fetch_array($result);
		$mrcount = $row["cnt"];
		
		//Getting Batid
		$sql = "SELECT batid from MBATCHT where batyr='".$batyr."' and brid='".$brid."'";
		$result = mysql_query($sql);		
		$row = mysql_fetch_array($result); 
		$batid = $row['batid'];
			
		
		
		$sql = "INSERT INTO MAVAILT values('".$mrcount."','".$batid."','".$doex."','".$ros."','".$akayr."')";
		mysql_query($sql);
		
		$result = mysql_query("SELECT count(mid) as cnt FROM MMARKST");
		$row = mysql_fetch_array($result);
		$markcount = $row["cnt"];		
				
		$sql = "SELECT subid FROM SAVAILT 
				  where brid LIKE (select brid from MBATCHT where batid='".$batid."')
				  AND
				  regid LIKE (select regid from MBATCHT where batid='".$batid."')";
				  
		$sqlresult = mysql_query($sql);
		$sqlrow = mysql_fetch_array($sqlresult);
		$suid = $sqlrow['subid'];
		
		$outcount = count($data);
			
		
		for ($i=0;$i<$outcount;$i++)
		{
			$incount = count($data[$i]);
			$mrkIncrement = $markcount+$i;
			$insstr = "insert into MMARKST values('".$mrkIncrement."'";
			
			//Getting Sid From Srno 			
			$srno = $data[$i][0];
			$isql = "SELECT sid from MSTUDENTT where srno='".$srno."'";
			$isqlresult = mysql_query($isql);
			$irow = mysql_fetch_array($isqlresult);
			$sid = $irow['sid'];
			
			//Getting Subid From Subcode
			$subcode = 	$data[$i][1];
			$isql = "SELECT subid from MSUBJECTT where suid='".$suid."' AND subcode='".$subcode."'";
			$isqlresult = mysql_query($isql);
			$irow = mysql_fetch_array($isqlresult);
			$subid = $irow['subid'];
			
			
			$insstr .= ",'".$sid."','".$subid."','".$data[$i][2]."','".$data[$i][3]."','".$data[$i][4]."','".$mrcount."'";
			$insstr .= ")";
			mysql_query($insstr);
			$insstr = "";			
		}
		
		notify("Update Done!");
	}
	function addFaculty($fname,$depname,$imguri,$bio,$login,$pass)
	{
	
		if($imguri=='null')
		{
			$imgfile = uploadImage();
		}
		else
			$imgfile = $imguri;
			
		if($imgfile == "")
		{
			$imgfile = "images/faces/faculty.png";	
		
		}
		
		$imgid = "t";
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		$sql = "SELECT imgid from MIMGT where imguri like '".$imgfile."'";
		$sqlresult = mysql_query($sql);
		$imcount = mysql_num_rows($sqlresult);
	;
		if($imcount>0)
		{ 
				$sqlrows = mysql_fetch_array($sqlresult);					
				$imgid = $sqlrows['imgid'];
					
		}				
		else
		{
				
				$sql = "SELECT count(imgid) as cnt from MIMGT";
				$sqlresult = mysql_query($sql);
				$sqlrows = mysql_fetch_array($sqlresult);
				$imcount = $sqlrows['cnt'];
				$sql = "INSERT INTO MIMGT VALUES('".$imcount."','".$imgfile."')";
				mysql_query($sql);
				
				$imgid = $imcount;	
				
			
		}
					
	
		$fcount = getFcount();
	
		$depid = getBranchByName($depname);
		
		$sql = "INSERT INTO MFACULTYT values('".$fcount."','".$fname."','".$imgid."','".$bio."','".$depid."','')";
		mysql_query($sql);
		makeObject($fname,$fcount,'1',$imgid,$login,$pass);
		notify("Added the Faculty ".$fname."<br />");		
	}
	function getFcount()
	{
	
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		$result = mysql_query("SELECT count(fid) as cnt FROM MFACULTYT");
		$row = mysql_fetch_array($result);
		$fcount = $row["cnt"];
		return $fcount;	
	
	}
	
	function uploadImage()
	{
	
		$filename = $_FILES["file"]["name"];
		$imgfile = "";
				
		if($filename!="")
		{
			
			$ftmpname = $_FILES["file"]["tmp_name"];
			$namearray  = explode('.',$filename);
			$jusname = $namearray[0];
			$extension = $namearray[1]; // To Check if it is .jpg not Done Yet
			
			$newfile = "../images/faces/".$filename; // Check If File Already Exists --Not Done Yet! ..
			move_uploaded_file($ftmpname, $newfile);	
			$imgfile='images/faces/'.$filename;			
		}
		return $imgfile;
	
	}
	function putSubstituteSubject($msubid,$subname,$subcode,$img,$brid,$regid,$inmax,$exmax,$exmin,$cre,$books)
	{
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		$array = queryMe("select count(subid) cnt from MSUBST");
		$subid = $array['cnt'];
		if($img == "")
			$imgid = getImgId("images/others/book.jpg"); 
		else
			$imgid = getImgId($img);
		$sql = "insert into MSUBST values('".$subid."','".$regid."','".$brid."','".$msubid."','".$subcode."','".$subname."','".$imgid.
		"','".$inmax."','".$exmax."','".$exmin."','".$cre."','".$books."')";
		mysql_query($sql);
		makeObject($subname,$subid,'2',$imgid,"","");
		notify("Subject Substituted Succesfully!");
		
	}
	function getImgId($imgfile)
	{
		
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		$sql = "SELECT imgid from MIMGT where imguri like '".$imgfile."'";
		$sqlresult = mysql_query($sql);
		$imcount = mysql_num_rows($sqlresult);
	;
		if($imcount>0)
		{ 
				$sqlrows = mysql_fetch_array($sqlresult);					
				return $sqlrows['imgid'];
					
		}				
		else
		{
				
				$sql = "SELECT count(imgid) as cnt from MIMGT";
				$sqlresult = mysql_query($sql);
				$sqlrows = mysql_fetch_array($sqlresult);
				$imcount = $sqlrows['cnt'];
				$sql = "INSERT INTO MIMGT VALUES('".$imcount."','".$imgfile."')";
				mysql_query($sql);
				
				return $imcount;	
				
			
		}
					
	}
	function getBranchByName($brname)
	{
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		$result = mysql_query("SELECT brid FROM MBRANCHT WHERE brname='".$brname."'");
		$row = mysql_fetch_array($result);
		$brid = $row["brid"];
		
		return $brid;	
	
	}
	function getRegByName($brname)
	{
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		$result = mysql_query("SELECT regid FROM MREGT WHERE regname='".$brname."'");
		$row = mysql_fetch_array($result);
		$brid = $row["regid"];
		
		return $brid;	
	
	}
	function getFname($name)
	{
		$array = explode(" ",$name);
		return $array[0];
	}
	function makeObject($oname,$ohandle,$otyid,$oimgid,$ologin,$opass)
	{
	
			
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		$result2 = mysql_query("SELECT count(oid) cnt FROM MOBJECTT"); 
		$row2 = mysql_fetch_array($result2);
		$objectCount = $row2['cnt'];
		
		$makeObject = "insert into MOBJECTT values('".$objectCount."','".$oname."','".$ohandle."','".$otyid."','".$oimgid."','".$ologin."','".$opass."','')";
		mysql_query($makeObject);
		
			
	}

	function getFacMap($lowlimit,$hilimit)
	{
		$placeBranch = "";
		echo "<script type='text/javascript' src='../lib/ajaxbox.js'></script>";
		$retstr= "";
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);	

		
		$query = "select brid,(select brname from MBRANCHT b  where b.brid=c.brid) as brname,akayr from MBATCHT c";
		$exec	= mysql_query($query);
		while ($row = mysql_fetch_array($exec))
		{
	
			$ayr = $row['akayr']+1;
			$placeBranch=$placeBranch."<option value='".$row['brid'].":".$ayr."A'>".$row['brname']." ".getFullClass($ayr)."A</option>";
			$placeBranch=$placeBranch."<option value='".$row['brid'].":".$ayr."B'>".$row['brname']." ".getFullClass($ayr)."B</option>";
				
		}
		
		$placeClass = 	$placeBranch;
		echo '<br /><br />';
		$retstr .= "<table>";
		$i=0; 
		$sql = "SELECT * FROM MFACULTYT LIMIT ".$lowlimit." , ".$hilimit;
		
		$sqlresult = mysql_query($sql);
		
		while($sqlrow = mysql_fetch_array($sqlresult))
		{
			$i++;
			$isql = "SELECT imguri from MIMGT WHERE imgid='".$sqlrow['imgid']."'";
			$iresult = 	mysql_query($isql);
			$irow = mysql_fetch_array($iresult);
		
		
			$osql = "SELECT oid FROM MOBJECTT where obhandle='".$sqlrow['fid']."' AND otyid='1'";
			$oresult = 	mysql_query($osql);
			$orow = mysql_fetch_array($oresult);
			$oid = $orow['oid'];
			$retstr .= "<tr><td>";
			$retstr .= 	 "<div class='padd'><a href='../main/?m=p&id=".$oid."'><img src='../".$irow['imguri']."' width='50' height='50'></a><br />".$sqlrow['fname']."<input type='hidden' value='".$sqlrow['fid']."' name='fid[]'></input></div><br />";
			$retstr .= "</td>";
			for($j=0;$j<4;$j++)
			{		
				$retstr .= "<td><select name='cls[][]' onchange='getSubList(this.value,\"S".$i.$j."\")'><option value=''>--Select--</option>".$placeClass."</select>";
				$retstr .= "<br /><div id='S".$i.$j."'></div></td>";
			}
			$retstr .= "<td><input type='radio' name='".$sqlrow['fid']."' value='c' CHECKED>Clear-Mode</input></td>";
			$retstr .= "<td><input type='radio' name='".$sqlrow['fid']."' value='a'>Add-Mode</input></td>";
		}
		$retstr .= "</table>";
		return $retstr;
	
	}

	function getTypes($name,$spstr)
	{

	$clsname = "Constants";
		$dbuname = $clsname::$dbuname;
		$dbpass = $clsname::$dbpass;
		$dbname = $clsname::$dbname;
		$regtab = $clsname::$regtab;
		$regname = $clsname::$regname;
		$con = mysql_connect("localhost",$dbuname,$dbpass);
		mysql_select_db($dbname, $con);
		$result = mysql_query("select * from OTYPET");
		$i =0;
		$ret = "<select name='".$name."' ".$spstr." id=type><option value=''>-Select-</option>";
		while($row = mysql_fetch_array($result))
  		{
  			$ret  .= "<option value='".$row['tyid']."'>".$row['tyname']."</option>"; 
  			
  		}
		$ret .= "</select>";
		mysql_close($con);
		return $ret;


}
	function getSchedule($batid,$sec,$clsnum)
	{
		
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		$array = queryMe("SELECT brid,regid,akayr from MBATCHT where batid like '".$batid."'");
		$brid = $array['brid'];
		$regid = $array['regid'];
		$akayr = $array['akayr'];
		
		 $ayr = $akayr+1;
		 
		$subres = mysql_query("SELECT * from MSUBJECTT where suid like 
		(select subid from SAVAILT where brid like '".$brid."' and regid like '".$regid."') and year like '".$ayr."' ");
		
		$subSelect = "<select name='sub[][]'><option value='empty'>Un-Assigned</option>";
		while($subarray = mysql_fetch_array($subres))
		{
			$subSelect .= "<option value='".$subarray['subid']."'>".$subarray['subname']."</option>";		
		
		}
		$subSelect .= "</select>";
	
		$warray = array("MONDAY","TUESDAY","WEDNESDAY","THURSDAY","FRIDAY","SATURDAY");
		$retstr = "<table border='2'><th>Week</th>";
		for($j=0;$j<$clsnum;$j++)
		{
				$retstr .= "<th>P".$j."</th>";
		}
		for($i=0;$i<count($warray);$i++)
		{
			$retstr .= "<tr>";
			$retstr .= "<td>".$warray[$i]."</td>";
			for($j=0;$j<$clsnum;$j++)
			{
						$retstr .= "<td>".$subSelect."</td>";
			}		
			$retstr .= "</tr>";
		
		}		
		$retstr .= "</table>";
		
		return $retstr;
		



}
	function queryMe($query)
	{
		
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		$sqlresult = mysql_query($query);
		return mysql_fetch_array($sqlresult);

	}
	function isLab($subid)
	{
	$clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
		
	$array = queryMe("SELECT islab from MSUBJECTT where subid like '".$subid."'");
	if($array['islab']==1)
		return True;
	else
		return False;
}
	function getObject($oid)
	{
	$clsname = "Constants";
	$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
	mysql_select_db($clsname::$dbname, $con);
		
	$array = queryMe("SELECT *,(select imguri from MIMGT where imgid=oimgid) as imguri from MOBJECTT where oid like '".$oid."'");
	return $array;


	}
	
	function getFacPlan($fid)
	{
		
	$facarray = queryMe("SELECT * FROM MFACULTYT WHERE fid LIKE '".$fid."'");
	$fcourse = $facarray['fcourse'];
	$fcourse = substr($fcourse,0,-1);
	$courseArray = explode(';',$fcourse);
	$retstr = "";
	for($i=0;$i<count($courseArray);$i++)
	{
		$pair = explode(':',$courseArray[$i]);
		$class = $pair[0];
		$subid = $pair[1];
		
		$batid = substr($class,0,1);
		$sec = substr($class,-1);
		
		$classGet = queryMe("SELECT (select brname from MBRANCHT b where b.brid=t.brid) 
		as brname,akayr from MBATCHT t where batid like '".$batid."'");
		$brname = $classGet['brname'];	
		$year = getFullClass($classGet['akayr']);
		$subGet = queryMe("SELECT * FROM MSUBJECTT where subid like '".$subid."'");
		$subname = $subGet['subname'];
		$batch = $brname." ".getFullClass($year+1)." ".$sec;
		$retstr .= "<a href='?m=src&q=%&t=0&ip=n&op=c&c=".$batid.":".$sec."'>".$batch."</a>";
		$array = queryMe("SELECT oid from MOBJECTT where obhandle like '".$subid."' and otyid like '2'");
		//echo	 "SELECT oid from MOBJECTT where obhandle like '".$subid."' and otyid like '2'";
		$oid = $array['oid'];
		$retstr .= "--<a href='?m=p&id='".$oid.">".$subname."</a><br />"; 	
		
		
	
	} 
	return $retstr;
}
	function getFacClasses($name,$fid,$extra)
	{
		$farray = queryMe("SELECT * FROM MFACULTYT WHERE fid='".$fid."'");
		$fcourse = $farray["fcourse"];
		$clsarray = explode(";",$fcourse);
		$mprinter = "";
		
		for($i=0;$i<count($clsarray);$i++)
		{
			$class = $clsarray[$i];
			
			if($class!="")
			{
				$clsdetail = explode(":",$class);
				$batdetail = $clsdetail[0];
				$subid = $clsdetail[1];
				$batid = substr($batdetail,0,1);
				$batsec = substr($batdetail,1,1);
				$query = "SELECT (SELECT brname FROM MBRANCHT b where b.brid=t.brid) as brname,akayr FROM MBATCHT t where batid='".$batid."'";
				$result = queryMe($query);
				$query = "SELECT subname from MSUBJECTT where subid='".$subid."'";
				$subresult = queryMe($query);
				$subname = $subresult["subname"];
				$fullclass = getFullClass($result["akayr"]+1); 
				$branch = $result["brname"];
				$printer = $branch." ".$batsec." ".$fullclass." ".$subname;
				$mprinter .= "<option value='".$class."'>".$printer."</option>";
				
			} 
			
			
		}
		return "<select name='".$name."' ".$extra.">".$mprinter."</select>";
	}
	
	function totAtt($ppl)
	{
		include("connection.php");	
		$p=explode(".",$ppl);
		$num=count($p);	
		for($i=0;$i<$num;$i++)
		{
			mysql_query("update MSTUDENTT set tap=tap+1 where sid='$p[$i]'");	
			print_r($p);	
		}
	}
	
	
	function getMPeriods($batid,$sec,$date,$sujid)
	{
		$date = strtotime($date);
		$sub=mysql_query("select * from MSUBJECTT where subid='$sujid'");
		$subname=mysql_fetch_array($sub);
		$return.="<br>";
		$return="<table cellpadding='5'>";
		$return.="<tr>";
		$return.="<th>Classes Taken By<br> ".$subname['subname']."</th>";
		$return.="<th>All Clases</th></tr>";
		$return.="<tr><td>";
		$return.="<table border='1'><tr><th>Period</th><th></th><th>Start</th><th>End</th></tr>";
		$att=mysql_query("select * from MATDT where sec='$sec' and batid='$batid' and dayid='$date' order by(sessionid)");
		while($a=mysql_fetch_array($att))
		{
		    $subid=$a['subid'];
		    $fid=$a['fid'];
		    $p=$a['sessionid'];
		    $aid=$a['aid'];
		    if($subid==$sujid)
		    {
		       $res=mysql_query("select * from SMETAT where batid='$batid' and sec='$sec' and pid='$p'");
		       $t=mysql_fetch_array($res);
		       $timeinfo=$t['timeinfo'];
		       $x=explode(';',$timeinfo);
		       $return.="<tr><td>Period".$p."</td>";
		       $return.="<td><input type='radio' name='per' value='$p'></td>";
		       $return.="<td>$x[0]</td>";
		       $return.="<td>$x[1]</td>";
		       $return.="<input type='hidden' name='aid' value='$aid'>";
		       $return.="</tr>";
		    }
		}
		$return.="</table></td><td>";
		$result=mysql_query("select * from SMETAT where batid='$batid' and sec='$sec' order by(pid)");
		$return.="<table border='1'><tr><th>Period</th><th></th><th>Start</th><th>End</th><th></th><th>Taken By</th></tr>";
		$get=mysql_query("select sessionid from MATDT where batid='$batid' and sec='$sec' and dayid='$date'");
		while($pr=mysql_fetch_array($get))
		{
			$arr[]=$pr[0];
		}
		while($res=mysql_fetch_array($result))
		{
			$aid1=$aid1['aid'];
			$pid=$res['pid'];
			$s1=mysql_query("select * from MATDT where sec='$sec' and batid='$batid' and dayid='$date' and sessionid='$pid'");
			$s2=mysql_fetch_array($s1);
			$aid1=$s2['aid'];
			if(in_array($pid,$arr))
			{
				$subject=mysql_query("select * from MSUBJECTT where subid='$s2[subid]'");
				$subname=mysql_fetch_array($subject);
				$return.="<tr>";
				$timeinfo=$res['timeinfo'];
				$x=explode(';',$timeinfo);
				$return.="<td>Period $pid:</td>";
				$return.="<td><input type='radio' name='per1' value='".$pid."'></td>";
				$return.="<td>$x[0]</td>";
				$return.="<td>$x[1]</td>";
				$return.="<td><img src='../images/others/done.jpg' width='18'></td>";
				$return.="<input type='hidden' name='aid1[$pid]' value='$aid1'>";
				$return.="<td>$subname[subname]</td>";
				$return.= "</tr>";
				continue;
			}
				$return.="<tr>";
				$timeinfo=$res['timeinfo'];
				$x=explode(';',$timeinfo);
				$return.="<td>Period $pid:</td>";
				$return.="<td><input type='radio' name='per1' value='".$pid."'></td>";
				$return.="<td>$x[0]</td>";
				$return.="<td>$x[1]</td>";
				$return.="<td><img src='../images/others/wrong.jpg' width='18'></td>";
				$return.="<input type='hidden' name='aid1[$pid]' value='$aid1'>";
				$return.="<td>Not Taken</td>";
				$return.= "</tr>";
			
		}
		$return.="</table>";
		$return.="</td></tr></table>";
		return $return;
	}
	
	
	function getPeriods($batid,$sec,$date)
	{
		include("connection.php");
		$date = strtotime($date);
		$result=mysql_query("select * from SMETAT where batid='$batid' and sec='$sec' order by(pid)");
		$get=mysql_query("select sessionid from MATDT where batid='$batid' and sec='$sec' and dayid='$date'");
		while($pr=mysql_fetch_array($get))
		{
			$arr[]=$pr[0];
		}
		
		$return="<table border='1'><tr><th>Period</th><th></th><th>Start</th><th>End</th></tr>";
		while($res=mysql_fetch_array($result))
		{
			
			$pid=$res['pid'];
			if(in_array($pid,$arr))
			{
				$return.="<tr>";
				$timeinfo=$res['timeinfo'];
				$x=explode(';',$timeinfo);
				$return.="<td>Period $pid:</td>";
				$return.="<td><img src='../images/others/done.jpg' width='18'></td>";
				$return.="<td>$x[0]</td>";
				$return.="<td>$x[1]</td>";
				$return.= "</tr>";
				continue;
			}
				$return.="<tr>";
				$timeinfo=$res['timeinfo'];
				$x=explode(';',$timeinfo);
				$return.="<td>Period $pid:</td>";
				$return.="<td><input type='checkbox' name='per[]' value='".$pid."'></td>";
				$return.="<td>$x[0]</td>";
				$return.="<td>$x[1]</td>";
				$return.= "</tr>";
			
		}
		$return.="</table>";
		return $return;
	}
	
	function geteditPeriods($batid,$sec,$date)
	{
		include("connection.php");
		$date = strtotime($date);
		
		$get=mysql_query("select sessionid from MATDT where batid='$batid' and sec='$sec' and dayid='$date'");
		while($pr=mysql_fetch_array($get))
		{
			$arr[]=$pr[0];
		}
		
		$return="<table border='1'><tr><th>Period</th><th></th><th>Start</th><th>End</th></tr>";
		
		while($res=mysql_fetch_array($result))
		{
			
			$pid=$res['pid'];
			if(in_array($pid,$arr))
			{
				$s1=mysql_query("select * from MATDT where sec='$sec' and batid='$batid' and dayid='$date' sessionid='$pid'");
				$s2=mysql_fetch_array($s1);
				$subject=mysql_query("select * from MSUBJECTT where subid='$s2[subid]'");
				$subname=mysql_fetch_array($subject);
				$return.="<tr>";
				$timeinfo=$res['timeinfo'];
				$x=explode(';',$timeinfo);
				$return.="<td>Period $pid:</td>";
				$return.="<td><img src='../images/others/done.jpg' width='18'></td>";
				$return.="<td>$x[0]</td>";
				$return.="<td>$x[1]</td>";
				$return.="<td>$subname[$subname]</td>";
				$return.= "</tr>";
				continue;
			}
				$return.="<tr>";
				$timeinfo=$res['timeinfo'];
				$x=explode(';',$timeinfo);
				$return.="<td>Period $pid:</td>";
				$return.="<td><input type='checkbox' name='per[]' value='".$pid."'></td>";
				$return.="<td>$x[0]</td>";
				$return.="<td>$x[1]</td>";
				$return.="<td>Not Taken</td>";
				$return.= "</tr>";
			
		}
		$return.="</table>";
		return $return;
	}
	
	function getdelPeriods($batid,$sec,$date)
	{
		$date = strtotime($date);
		$result=mysql_query("select * from SMETAT where batid='$batid' and sec='$sec' order by(pid)");
		$get=mysql_query("select * from MATDT where batid='$batid' and sec='$sec' and dayid='$date'");
		while($pr=mysql_fetch_array($get))
		{
			$arr[]=$pr['sessionid'];
		}
		$return="<table border='1'><tr><th>Period</th><th></th><th>Start</th><th>End</th></tr>";
		while($res=mysql_fetch_array($result))
		{
			$pid=$res['pid'];
			if(in_array($pid,$arr))
			{
				$id1=mysql_query("select * from MATDT where batid='$batid' and sec='$sec' and dayid='$date' and sessionid='$pid'");
				$id2=mysql_fetch_array($id1);
				$aid=$id2['aid'];
				$return.="<tr>";
				$timeinfo=$res['timeinfo'];
				$x=explode(';',$timeinfo);
				$return.="<td>Period $pid:</td>";
				$return.="<td><input type='radio' name='per' value='".$pid."'>";
				$return.="<input type='hidden' name='aid[$pid]' value='$aid'>";
				$return.="<td>$x[0]</td>";
				$return.="<td>$x[1]</td>";
				$return.="<td><img src='../images/others/done.jpg' width='18'></td>";
				$return.= "</tr>";
				continue;
			}
				$return.="<tr>";
				$timeinfo=$res['timeinfo'];
				$x=explode(';',$timeinfo);
				$return.="<td>Period $pid:</td>";
				$return.="<td></td>";
				$return.="<td>$x[0]</td>";
				$return.="<td>$x[1]</td>";
				$return.="<td><img src='../images/others/wrong.jpg' width='18'></td>";
				$return.="</tr>";
				
		}
		$return.="</table>";
		return $return;
	}
	
	
	
	function mapPeriods($batid,$sec,$pno)
	{
		$ret = "";
		$ret .= "<table>";
		$ret .= "<th>Periods</th>";
		$ret .= "<th>Start Time</th>";
		$ret .= "<th>End Time</th>";
		$c=1;
		
		echo "
			<script type='text/javascript'>
				function timecopy(value)
				{
					var source = document.getElementById(value);
					var dest = document.getElementById(parseInt(value)+1);
					
					dest.value = source.value;
					
				}
			</script>
		";
		for($i=0;$i<$pno;$i++)
		{
			
			$ret .= "<tr><td>P".$i."</td><td><input type='text' name='inputs[]' id='".$c."' required=true>"."</td><td><input type='text' name='outputs[]' id='".($c+1)."' onkeyup=\"timecopy('".($c+1)."')\" required=true></td>";
			$c = $c+2;
			
		}
		$ret .= "</table>";
		return $ret;
	}
	function putPeriods($batid,$sec,$npo,$inputs,$outputs)
	{
		$smidarray = queryMe("SELECT count(smid) as smid FROM SMETAT");
		$smid = $smidarray['smid'];
		
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		for($i=0;$i<$npo;$i++)
		{
			$timeinfo = $inputs[$i].";".$outputs[$i];
			$sql = "INSERT INTO SMETAT VALUES('".($smid+$i)."','".$batid."','".$sec."','".$i."','".$timeinfo."')";
			mysql_query($sql);
			
		}
		
		notify("Time-Schedule Updated");
	}
	function notify($text)
	{
		
		echo "
		<script type='text/javascript'>
			document.getElementById('messages').innerHTML='<div id=\"notif\">".$text."</div><br />';
		</script>
		";
	}
	function notifyerr($text)
	{
		
		echo "
		<script type='text/javascript'>
			document.getElementById('messages').innerHTML += '<div id=\"noterr\">".$text."</div><br />';
		</script>
		";
	}
	function notifywar($text)
	{
		
		echo "
		<script type='text/javascript'>
			document.getElementById('messages').innerHTML='<div id=\"notwar\">".$text."</div><br />';
		</script>
		";
	}
	function redirect($location)
	{
		echo "
		<script type='text/javascript'>
			window.location = '".$location."';
		</script>
		";
		
	}
	function uploadAtt($batid,$sec,$ppl,$pora,$subid,$fid,$per,$date)
	{
	
		include("connection.php");
		$att=mysql_query("select * from MATDT");
		$aid=mysql_num_rows($att);
		mysql_query("insert into MATDT values('$aid','$fid','$batid','$sec','$date','$per','$subid')");
		mysql_query("insert into ADATAT values('$aid','$ppl','$pora')");
	}
	function recAtt($batid,$sec,$ppl,$pora,$subid,$fid,$per,$date)
	{
		$perry=explode(":",$per);
		$num=count($perry);
		for($i=0;$i<$num;$i++)
		{
			$perr=$perry[$i];
			uploadAtt($batid,$sec,$ppl,$pora,$subid,$fid,$perr,$date);
		}
	}
	function getDayReport($batid,$sec,$date,$bunk)
	{
		echoDayReportCSS();
		echoDayReportJS();
		
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		//echo $bunk;
		$query = "SELECT * FROM MATDT WHERE batid LIKE '".$batid."' AND sec LIKE '".$sec."' AND dayid LIKE '".$date."' order by(sessionid)";
		
		$result = mysql_query($query);
		$return = "<table border='1'><th>Students</th>";
		$counter = 0;
		$periods = array();
		$i=0;
		while($row = mysql_fetch_array($result))
		{
			$subarray = queryMe("SELECT * FROM MSUBJECTT WHERE subid LIKE '".$row['subid']."'");
			$subname = $subarray['subname'];
			$suburi = getImgUri($subarray['imgid']);
			$facarray = queryMe("SELECT * FROM MFACULTYT WHERE fid like '".$row['fid']."'");
			$facname = $facarray['fname'];
			$facuri = getImgUri($facarray['imgid']);
			$periods[$i] = array();
			$periods[$i][0]=$row['sessionid'];
			$periods[$i][1]= getPersCount($batid,$sec,$date,$row['sessionid']);
			$return .= "<th> <a id='hider' onclick='hideShow(\"D".$counter."\")' href='#'> Period".$row['sessionid']."[".$periods[$i][1]."]</a>
				<div id='D".$counter."' style=\"display:none;\">
				<img src='../".$suburi."' width='70' height='70' style='opacity:0.9;filter:alpha(opacity=40)'
	  	onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
  		onmouseout='this.style.opacity=0.9;this.filters.alpha.opacity=20'></img>&nbsp;
		<img src='../".$facuri."' width='70' height='70' style='opacity:0.9;filter:alpha(opacity=40)'
	  	onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
  		onmouseout='this.style.opacity=0.9;this.filters.alpha.opacity=20'></img><br>".$subname."-".$facname."
				</div>
			</th>";
			$counter++;
			$i++;
		}
		showDayReportGraph($periods);
		$bunkers = 0;
		$total = 0;
		$sql = "SELECT *,(select imguri from MIMGT i where i.imgid=s.imgid) as imguri ,(select oid from MOBJECTT o where obhandle=srno and otyid='0') as oid FROM MSTUDENTT s WHERE batid LIKE '".$batid."' AND sec LIKE '".$sec."' order by('batid') DESC";
			
		$sresult = mysql_query($sql);
		while($row1 = mysql_fetch_array($sresult))
		{
			$treturn = ""; 
			$treturn .=  "<td><table><tr><td><a href='?m=p&id=".$row1['oid']."'><img src='../".$row1['imguri']."' width='40' height='40' style='opacity:0.4;filter:alpha(opacity=40)'
	  	onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
  		onmouseout='this.style.opacity=0.4;this.filters.alpha.opacity=20'></img></a></td><td><div style='text-align:center'>".$row1['srno']."</td><td>".$row1['sname']."</div>
			</div></td></tr></table></td>";
			$query = "SELECT * FROM MATDT WHERE batid LIKE '".$batid."' AND sec LIKE '".$sec."' AND dayid LIKE '".$date."' order by(sessionid)";
			$result = mysql_query($query);
			$fcnt = 0;
			$ucnt = 0;
			while($row = mysql_fetch_array($result))
			{
				
				$sarray = queryMe("SELECT * FROM ADATAT WHERE aid LIKE '".$row['aid']."'");
				$spres  = $sarray['adata'];
				$pa = $sarray['pa'];
				$students = explode('.',$spres);
				if($pa == "P" && in_array($row1['sid'],$students))
				{
					$treturn .= "<td><center><img src='../images/others/tick.png' width='25' hieght='25'/></center></td>";
					$ucnt++;
				}
				elseif($pa == "A" && !in_array($row1['sid'],$students))
				{
					$treturn .= "<td><center><img src='../images/others/tick.png' width='25' hieght='25'/></center></td>";
					$ucnt++;
				}
				else
				{
					$treturn .= "<td><center><img src='../images/others/wrong.jpg' width='25' hieght='25'/></center></td>";;
					
				}
				$fcnt++;
			}
			if($ucnt != $fcnt && $ucnt!=0)
			{
				$bunkers++;
				$treturn = "<tr class='bunk'>".$treturn;
			}
		
			else
				$treturn = "<tr>".$treturn;
				
			$treturn .= "</tr>";
			if($bunk == 0)
				$return .= $treturn;
			else
			{
				if($ucnt != $fcnt && $bunk == 2)
					$return .= $treturn;
					
				elseif($ucnt != $fcnt && $ucnt!=0 && $bunk==1)
				{
					
					$return .= $treturn;
				}
				

			}
			$total++;
		}
		$return .= "</table>";
		
		$summary = "<table border='1'><tr><td>Total:</td><td>".$total."</td></tr><tr><td>Bunkers:</td><td>".$bunkers."</td></tr></table><br />";
		return $summary.$return;
	}
	function getPersCount($batid,$sec,$dayid,$pid)
	{
		
		$array = queryMe("SELECT adata,pa from ADATAT where aid like (select aid from MATDT where batid like '".$batid."'
				 and sec like '".$sec."'
				 and dayid like '".$dayid."' and sessionid like '".$pid."')");
		$pa = $array["pa"];
		$array2 = explode('.',$array["adata"]);
		$count = count($array2);
		
		$array = queryMe("SELECT count(sid) as cnt from MSTUDENTT where batid like '".$batid."' and sec like '".$sec."'");
		$totcnt = $array["cnt"];
		
		if($pa == "P")
			return $count;
		else
			return $totcnt-$count;
	}
	function getConReport($batid,$sec,$datein,$dateout)
	{
		
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		$return = ""; 
		
		$query = "SELECT distinct sessionid from MATDT where batid like '".$batid."' and sec like '".$sec."' order by(sessionid)";
		$result = mysql_query($query);
		$return = "<table border='1' style='text-align:center;'><th>Students</th>";
		$counter = 0;
		$periods = array();
		$i=0;
		while($row = mysql_fetch_array($result))
		{
			
			$periods[$i] = $row['sessionid'];
			$i++;
		}
		$inloop = mysql_num_rows($result);
		$prefetch = array();
		$totcnt = array();
		for($i=0;$i<count($periods);$i++)
		{
			$query = "SELECT * FROM MATDT WHERE batid LIKE '".$batid."'
			AND sec LIKE '".$sec."'
			AND dayid BETWEEN '".$datein."' AND '".$dateout."'
			AND sessionid LIKE '".$periods[$i]."'";
			//echo $query;
			$qr = mysql_query($query);
			$totcnt[$i] = mysql_num_rows($qr);
			$prefetch[$i] = array();
			$j=0;
			while($r = mysql_fetch_array($qr))
			{
				$prefetch[$i][$j] = array();
				$s = queryMe("SELECT adata,pa from ADATAT where aid like '".$r['aid']."'");
				$prefetch[$i][$j][0] = $s['pa'];
				$prefetch[$i][$j][1] = $s['adata'];
				$j++;
				
			}
			
		}
		
		for($i=0;$i<count($periods);$i++)
		{
			$return .= "<th>Period-".$periods[$i]."(".$totcnt[$i].")</th>";
		}
		$sql = "SELECT *,(select imguri from MIMGT i where i.imgid=s.imgid) as imguri ,
		(select oid from MOBJECTT o where obhandle=srno and otyid='0')
		as oid FROM MSTUDENTT s WHERE batid LIKE '".$batid."' AND sec LIKE '".$sec."' order by('batid') DESC";
		$sresult = mysql_query($sql);
		
		while($row1 = mysql_fetch_array($sresult))
		{
			 
			$return .=  "<tr><td><table><tr><td><a href='?m=p&id=".$row1['oid']."'>
			<img src='../".$row1['imguri']."' width='40' height='40' style='opacity:0.75;filter:alpha(opacity=75)'
			onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
			onmouseout='this.style.opacity=0.75;this.filters.alpha.opacity=75'>
			</img></a></td><td><div style='text-align:center'>".$row1['srno']."</td><td>".$row1['sname']."</div>
			</div></td></tr></table></td>";
			
			for($i=0;$i<count($prefetch);$i++)
			{
				$atcnt = attDecide($prefetch[$i],$row1['sid']);
				if($atcnt>=$totcnt[$i])
					$return .= "<td><div style='display:block;background-color:green;'><a href='../Roster/embedreport.php?sid=".$row1['sid']."&pid=".$periods[$i]."&datein=".$datein."&dateout=".$dateout."&width=200&hieght=200' class='thickbox'>".$atcnt."</a></div></td>";
				else
					$return .= "<td><div style='display:block;background-color:red;'><a href='../Roster/embedreport.php?sid=".$row1['sid']."&pid=".$periods[$i]."&datein=".$datein."&dateout=".$dateout."&width=200&hieght=200' class='thickbox'>".$atcnt."</a></div></td>";
			}
			
			
			
			$return .= "</tr>";
		}
		return "</table>".$return;
		
		
	}
	function attDecide($array,$sid)
	{
		$count=0;
		for($i=0;$i<count($array);$i++)
		{
				$spres  = $array[$i][1];
				$pa = $array[$i][0];
				$students = explode('.',$spres);
				if($pa == "P" && in_array($sid,$students))
				{
					$count++;
				}
				elseif($pa == "A" && !in_array($sid,$students))
				{
					$count++;
				}
				
		}
		return $count;
		
		
	}
	function getStuReport($sid,$datein,$dateout,$pid)
	{
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		$return = "";
		
		$bA = queryMe("SELECT batid,sec FROM MSTUDENTT WHERE sid like '".$sid."'");
		$batid = $bA["batid"];
		$sec = $bA["sec"];
		$i=0;
		$return = "<table border='1' style='text-align:center;'><th>Dates</th>";
				
		if($pid==-1)
		{
			
			$query = "SELECT distinct sessionid from MATDT where batid like '".$batid."' and sec like '".$sec."' order by(sessionid)";
			$result = mysql_query($query);
			$prc = mysql_num_rows($result);
			$periods = array();
			while($row = mysql_fetch_array($result))
			{	
				$return .= "<th>Period-".$row['sessionid']."</th>";
				$periods[$i]=$row['sessionid'];
				$i++;
			}
		}
		else
		{
			$periods = array($pid);
			$return .= "<th>Period-".$pid."</th>";
		}
		
		
		
		$dates = getDates($batid,$sec,$datein,$dateout);
		
		for($i=0;$i<count($dates);$i++)
		{
			$return .= "<tr><td>".$dates[$i][1]."</td>";
			for($j=0;$j<count($periods);$j++)
			{
				
				$query = "SELECT count(aid) as caid,aid FROM MATDT WHERE batid LIKE '".$batid."'
				AND sec LIKE '".$sec."'
				AND dayid like '".$dates[$i][0]."' and sessionid like '".$periods[$j]."'";
				$aidarray = queryMe($query);
				
				if($aidarray["caid"]==0)
				{
					$return .= "<td>--</td>";
					continue;
				}
				
				$parry = queryMe("SELECT adata,pa from ADATAT where aid like '".$aidarray["aid"]."'");
				$adata = $parry["adata"];
				$pa = $parry["pa"];
				$students = explode(".",$adata);
				
				if($pa == "P" && in_array($sid,$students))
				{
					$return .= "<td><center><img src='../images/others/tick.png' width='25' hieght='25'/></center></td>";
					
				}
				elseif($pa == "A" && !in_array($sid,$students))
				{
					$return .= "<td><center><img src='../images/others/tick.png' width='25' hieght='25'/></center></td>";
					
				}
				else
				{
					$return .= "<td><center><img src='../images/others/wrong.jpg' width='25' hieght='25'/></center></td>";;
					
				}
				
				
			}
			
			$return .= "</tr>";
		}
		return "</table>".$return;
	}
	function getDates($batid,$sec,$datein,$dateout)
	{
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		$dates = array();
		$i=0;
		
		$query = "SELECT distinct dayid FROM MATDT WHERE batid LIKE '".$batid."'
			AND sec LIKE '".$sec."'
			AND dayid BETWEEN '".$datein."' AND '".$dateout."' order by(dayid) ASC";
		
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
		{
			
			$dates[$i] = array();
			$dates[$i][0] = $row['dayid'];
			$dates[$i][1] = date("d-M-Y",$row['dayid']);
			$i++;
		}
		return $dates;
		
	}
	function echoDayReportCSS()
	{
		
		echo "
			<style type='text/css'>
			.bunker
			{
				
				background-color:red;
			}
			</style>
		";
	}
	function echoDayReportJS()
	{
		
		echo "
			<script type='text/javascript'>
			function hideShow(value)
			{
				var ele = document.getElementById(value);
				
				if(ele.style.display == 'none')
					ele.style.display = 'block';
				else
					ele.style.display = 'none';
			}
			</script>
		";
	}
	function getImgUri($imgid)
	{
		
		$array = queryMe("SELECT imguri FROM MIMGT WHERE imgid LIKE '".$imgid."'");
		return $array['imguri'];
	}
	function isFaculty($oid)
	{
		
		
		$array = queryMe("SELECT otyid FROM MOBJECTT WHERE oid like '".$oid."'");
		
		if($array['otyid']=="1")
			return true;
		else
			return false;
		
		
	}
	function isStudent($oid)
	{
		
		
		$array = queryMe("SELECT otyid FROM MOBJECTT WHERE oid like '".$oid."'");
		
		if($array['otyid']=="0")
			return true;
		else
			return false;
		
		
	}
	function isSudo($oid)
	{
		
		$array = queryMe("SELECT otyid FROM MOBJECTT WHERE oid like '".$oid."'");
		if($array['otyid']=='4')
			return true;
		else
			return false;
		
		
	}
	function isAdmin($oid)
	{
		
		
		$array = queryMe("SELECT otyid FROM MOBJECTT WHERE oid like '".$oid."'");
		
		if($array['otyid']=="3")
			return true;
		else
			return false;
		
		
	}
	function getBranchFromSrno($srno)
	{
		
		$array = queryMe("SELECT * from MSTUDENTT WHERE srno like '".$srno."'");
		$batid = $array['batid'];
		$nar = queryMe("SELECT brid from MBATCHT WHERE batid like '".$batid."'");
		$brid = $nar['brid'];
		return $brid;
		
	}
	function tpercent($rno)
        {
            include("connection.php");
            $student=mysql_query("select * from MSTUDENTT where srno='$rno'");
            $s=mysql_fetch_array($student);
            $sid=$s['sid'];
            $batid=$s['batid'];
            $marks=mysql_query("select * from MAVAILT where batid='$batid' and ros='R'");
            $num=mysql_num_rows($marks);
            $mpercent=0;
	    $per = array();
	    $i=0;
            while($m=mysql_fetch_array($marks))
            {
                $date=$m['doex'];
                $akyr=$m['akayr'];
                $mrid=$m['mrid'];
                $marks1=mysql_query("select * from MMARKST where sid='$sid' and mrid='$mrid'");
                $total=0;
                $mtotal=0;
                while($m1=mysql_fetch_array($marks1))
                {
                    $subj=$m1['subid'];
                    $subject=mysql_query("select * from MSUBJECTT where subid='$subj'");
                    $sub=mysql_fetch_array($subject);
                    $mtotal=$mtotal+$sub['inmax']+$sub['exmax'];
                    $total=$total+$m1['intm']+ $m1['extm'];
                }
                $percent=($total*100)/$mtotal;
                $mpercent=+$mpercent+$percent;
		$per[$i] = array();
		$per[$i][0] = $akyr;
		$per[$i][1] = $percent; 
		$i++;
            }
	    
            $ret=$mpercent/$num;
	    $per[$i][0] = -1;
	    $per[$i][1] = $ret;
	    
            return($per);    
        }
	function showDayReportGraph($periods)
	{
	$append='';
	
	for($i=0;$i<count($periods);$i++)
	{
        
        $append .= "sin.push([".$periods[$i][0].", ".$periods[$i][1]."]);\n";
        
	}
echo "<script type='text/javascript'>
$(function () {
    var sin = [], cos = [];
    ".$append."var plot = $.plot($('#placeholder'),
           [ { data: sin, label: 'Period'} ], {
               series: {
                   lines: { show: true },
                   points: { show: true }
               },
               grid: { hoverable: true, clickable: true },
	       xaxis: {ticks: ".count($periods)."},
	       yaxis: {tickDecimals: 0},
               
             });

    function showTooltip(x, y, contents) {
        $('<div id=\'tooltip\'>' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo('body').fadeIn(200);
    }

    var previousPoint = null;
    $('#placeholder').bind('plothover', function (event, pos, item) {
        $('#x').text(pos.x);
        $('#y').text(pos.y);

        if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;
                    
                    $('#tooltip').remove();
                    var x = item.datapoint[0],
                        y = item.datapoint[1];
                    
                    showTooltip(item.pageX, item.pageY,
                                'Attendance of '+item.series.label + ' ' + x + ' Is ' + y);
                }
            }
           
        
    });

    $('#placeholder').bind('plotclick', function (event, pos, item) {
        if (item) {
            
            plot.highlight(item.series, item.datapoint);
        }
    });
});
</script>";
}
?>
