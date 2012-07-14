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

	$branchtab = "MBRANCHT";
	$result = mysql_query("SELECT * FROM MBRANCHT");
	$i =0;
	while($row = mysql_fetch_array($result))
	{
		$ret[$i] = $row["brname"];
		$i++;
	}

	 
	return $ret;

}
function getRegulations()
{	
	$result = mysql_query("SELECT * FROM MREGT");	
	$i =0;
	while($row = mysql_fetch_array($result))
	{
		$ret[$i] = $row["regname"];
		$i++;
	}

	 
	return $ret;

}
function getBatches($name,$extra)
{
	
	$brfilter = getBranchFilter();

	$result = mysql_query("select (select brname from MBRANCHT b where b.brid=c.brid) as brname,brid,batyr from MBATCHT c where brid like '".$brfilter."'");
	$i =0;
	$ret = "<select name='".$name."' ".$extra.">";
	while($row = mysql_fetch_array($result))
	{
		$ret  .= "<option value='".$row['brid'].":".$row['batyr']."'>".$row['brname']." ".$row['batyr']."</option>";
			
	}
	$ret .= "</select>";
	 
	return $ret;

}
function getBranchFilter()
{
	if(!array_key_exists("object",$_COOKIE))
	return '%';

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
	
	$result = mysql_query("SELECT akayr FROM MBATCHT");
	$i =0;
	while($row = mysql_fetch_array($result))
	{
		$ret[$i] = getFullClass($row['akayr'])."A";
		$ret[$i+1]=  getFullClass($row['akayr'])."B";
		$i = $i+2;
	}

	 
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
	$brfilter = getBranchFilter();
	$result = mysql_query("select (select brname from MBRANCHT b where b.brid=c.brid) as brname,brid,batyr,akayr,batid from MBATCHT c where brid like '".$brfilter."'");
	$i =0;
	$ret = "<select name='".$name."' ".$extra."  onchange='showUser(this.value)'>";

	while($row = mysql_fetch_array($result))
	{
		$ret  .= "<option value='".$row['batid'].":A'>".$row['brname']." ".getFullClass($row['akayr']+1)." A</option>";
		$ret  .= "<option value='".$row['batid'].":B'>".$row['brname']." ".getFullClass($row['akayr']+1)." B</option>";
			
	}
	$ret .= "</select>";
	
	return $ret;

}
function getEClassesAsSelect($name,$extra)
{
	$brfilter = getBranchFilter();
	$result = mysql_query("select (select brname from MBRANCHT b where b.brid=c.brid) as brname,brid,batyr,akayr,batid from MBATCHT c where brid like '".$brfilter."'");
	$i =0;
	$ret = "<select name='".$name."' ".$extra."  onchange='showUser(this.value)'>";
	$ret .="<option value='null'>--Classes--</option>";
	while($row = mysql_fetch_array($result))
	{
		$ret  .= "<option value='".$row['batid'].":A'>".$row['brname']." ".getFullClass($row['akayr']+1)." A</option>";
		$ret  .= "<option value='".$row['batid'].":B'>".$row['brname']." ".getFullClass($row['akayr']+1)." B</option>";
			
	}
	$ret .= "</select>";
	
	return $ret;

}
function getSubjectsAsSelect($brid,$regid,$year,$name)
{

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
function putBatch($data,$regname,$brnname,$batyr,$A,$B,$imgfmt)
{

	
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
		//echo $incount;
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
				$img = "images/faces/".$data[$i][$j].".".$imgfmt;
				$sql = "SELECT imgid from MIMGT where imguri like '".$img."'";
				//echo $img;
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
		//echo $insstr;
		mysql_query($insstr);
		$index = $objectCount+$i;
		$makeObject = "insert into MOBJECTT values('".$index."','".$data[$i][1]."','".$stuIncrement."','0','".$imgid."','','','')";
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
	

}
function putSubList($data,$regname,$brnname)
{

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

		xDebug($insstr);
		mysql_query($insstr);
		$index = $objectCount+$i;
		$makeObject = "insert into MOBJECTT values('".$index."','".$data[$i][1]."','".$stuIncrement."','2','".$imgid."','','','')";
		mysql_query($makeObject);
		xDebug($makeObject);
		$insstr = "";
	}

	$brnidt = mysql_fetch_array(mysql_query("select brid from MBRANCHT where brname='".$brnname."'"));
	$brnid = $brnidt["brid"];

	$regidt = mysql_fetch_array(mysql_query("select regid from MREGT where regname='".$regname."'"));
	$regid = $regidt["regid"];

	$battabupd = "insert into SAVAILT values('".$subcount."','".$regid."','".$brnid."')";
	mysql_query($battabupd);
	notify("Update Done!");
	 


}
function putMarks($data,$batyr,$brid,$doex,$ros,$akayr)
{

	
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
	notify("Updated Succesfully! Consider Upgrading The Batches Go To <a href=\"?m=up\">");
	notify("You Have Upgraded The Batches! Consider Mapping Faculty A Fresh! Go To <a href=\"?m=mf&l=0&r=5\">");

	updateMarks($mrcount);
}
function updateMarks($mrid)
{
	//include_once("connection.php");
	$ros=mysql_query('select * from MAVAILT where mrid='.$mrid);
	while($ROS = mysql_fetch_array($ros))
	{
		$batid=$ROS["batid"];
		$doex=$ROS["doex"];
		$ros=$ROS["ros"];
		$akayr = $ROS["akayr"];
	}
	 
	if($ros=='R')
	{

		 
		 
	}
	else if($ros=='S')
	{
		$regular=mysql_query("select * from MAVAILT where batid='$batid' and ros='R' and akayr like '$akayr'");
		xDebug("select * from MAVAILT where batid='$batid' and ros='R' and akayr like '$akayr'");
		while($Reg = mysql_fetch_array($regular))
		{
			$mrid2=$Reg["mrid"];
			$doex=$Reg["doex"];
		}
		$supply=mysql_query('select * from MMARKST where mrid='.$mrid);
		while($sup = mysql_fetch_array($supply))
		{
			$sid=$sup["sid"];
			$subid=$sup["subid"];
			$intr=$sup["intm"];
			$extr=$sup["extm"];
			$cre=$sup["cre"];
			if($cre>0)
			{
				$supply1=mysql_query('select * from MMARKST where mrid='.$mrid2.' and sid='.$sid.' and subid='.$subid);
				$bl=mysql_query('select * from MBACKLOGT');
				$rows=mysql_num_rows($bl);
				while($sup1 = mysql_fetch_array($supply1))
				{
					$sid1=$sup1["sid"];
					$subid1=$sup1["subid"];
					$intr1=$sup1["intm"];
					$extr1=$sup1["extm"];
					$cre1=$sup1["cre"];
					mysql_query("insert into MBACKLOGT values('$rows','$sid1','$subid1','$intr1','$extr1','$doex')");
					xDebug("insert into MBACKLOGT values('$rows','$sid1','$subid1','$intr1','$extr1','$doex')");
				}
				mysql_query("update MMARKST set extm='$extr' where sid='$sid' and subid='$subid' and mrid='$mrid2'");
				mysql_query("update MMARKST set cre='$cre' where sid='$sid' and subid='$subid' and mrid='$mrid2'");
			}
			else
			{
				mysql_query("insert into MBACKLOGT values('$rows','$sid','$subid','$intr','$extr,'$doex1')");
			}
		}


	}


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
	
	$result = mysql_query("SELECT brid FROM MBRANCHT WHERE brname='".$brname."'");
	$row = mysql_fetch_array($result);
	$brid = $row["brid"];

	return $brid;

}
function getRegByName($brname)
{
	
	$result = mysql_query("SELECT regid FROM MREGT WHERE regname='".$brname."'");
	$row = mysql_fetch_array($result);
	$brid = $row["regid"];

	return $brid;

}
function getFname($name)
{
	//$array = explode(" ",$name);
	if(strlen($name)>10)
	$name = substr($name,0,8);
	$name .= "..";
	return $name;
}
function makeObject($oname,$ohandle,$otyid,$oimgid,$ologin,$opass)
{

		
	

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
	

	$result = mysql_query("select (select brname from MBRANCHT b where b.brid=c.brid) as brname,brid,batyr,akayr,batid from MBATCHT c ");
	$i =0;
	$ret = "";

	while($row = mysql_fetch_array($result))
	{
		$ret  .= "<option value='".$row['batid'].":A'>".$row['brname']." ".getFullClass($row['akayr']+1)." A</option>";
		$ret  .= "<option value='".$row['batid'].":B'>".$row['brname']." ".getFullClass($row['akayr']+1)." B</option>";
			
	}
		
	$placeClass = 	$ret;
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
function getModifTypes($name,$spstr)
{

	
	$result = mysql_query("select * from OTYPET where loggable='yes'");
	$i =0;
	$ret = "<select name='".$name."' ".$spstr." id=type><option value=''>-Select-</option>";
	while($row = mysql_fetch_array($result))
	{
		$ret  .= "<option value='".$row['tyid']."'>".$row['tyname']."</option>";
			
	}
	$ret .= "</select>";
	 
	return $ret;


}
function getTypes($name,$spstr)
{
	$result = mysql_query("select * from OTYPET");
	$i =0;
	$ret = "<select name='".$name."' ".$spstr." id=type><option value=''>-Select-</option>";
	while($row = mysql_fetch_array($result))
	{
		$ret  .= "<option value='".$row['tyid']."'>".$row['tyname']."</option>";
			
	}
	$ret .= "</select>";
	 
	return $ret;


}
function getSchedule($batid,$sec,$clsnum)
{

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

	
	$sqlresult = mysql_query($query);
	
	return mysql_fetch_array($sqlresult);

}
function isLab($subid)
{
	
	$array = queryMe("SELECT islab from MSUBJECTT where subid like '".$subid."'");
	if($array['islab']==1)
	return True;
	else
	return False;
}
function getObject($oid)
{
	

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

		$array = queryMe("SELECT oid from MOBJECTT where obhandle like '".$subid."' and otyid like '2'");
		xDebug("SELECT oid from MOBJECTT where obhandle like '".$subid."' and otyid like '2'");
		$oid = $array['oid'];
		$retstr .= "<div class='box'><center><h3>Teaches</h3>";
		$retstr .= "<div style='width:100%'>".getSubjectBox($subid)."</div>";
		$retstr .= "<h3>To</h3><table><tr><td>".getClassPreview($batid,$sec,4,16)."</td></tr></table></center></div>";


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

function totAtt($ppl,$pora,$batid)
{
	//include_once("connection.php");
	$p=explode(".",$ppl);
	$num=count($p);
	$set = "";
	for($i=0;$i<$num;$i++)
	{
		$set .= $p[$i].",";
			
	}
	$set = substr($set,0,-1);

	if($pora=='A'){
		mysql_query("update MSTUDENTT set tap=tap+1 where sid NOT IN (".$set.") and batid like '".$batid."'");
	}
	else if($pora=='P')
	mysql_query("update MSTUDENTT set tap=tap+1 where sid  IN (".$set.") and batid like '".$batid."'");
		
	//print_r($p);
}


function getMPeriods($batid,$sec,$date,$fid)
{
	$date = strtotime($date);
	$fac=mysql_query("select * from MFACULTYT where fid='$fid'");
	$faculty=mysql_fetch_array($fac);
	$return.="<br>";
	$return="<table cellpadding='10'>";
	$return.="<tr>";
	$return.="<th>Classes Taken By<br> ".$faculty['fname']."</th>";
	$return.="<th>All Clases</th></tr>";
	$return.="<tr><td>";
	$return.="<table border='1' cellpadding='10'><tr><th>Period</th><th></th><th>Start</th><th>End</th></tr>";
	$att=mysql_query("select * from MATDT where sec='$sec' and batid='$batid' and dayid='$date' and fid='$fid' order by(sessionid)");
	while($a=mysql_fetch_array($att))
	{
		$subid=$a['subid'];
		$p=$a['sessionid'];
		$aid=$a['aid'];
		$res=mysql_query("select * from SMETAT where batid='$batid' and sec='$sec' and pid='$p'");
		$t=mysql_fetch_array($res);
		$timeinfo=$t['timeinfo'];
		$x=explode(';',$timeinfo);
		$return.="<tr><td>Period".$p."</td>";
		$return.="<td><input type='radio' name='per' value='$p'></td>";
		$return.="<td>$x[0]</td>";
		$return.="<td>$x[1]</td>";
		$return.="<input type='hidden' name='aid[$p]' value='$aid'>";
		$return.="</tr>";

	}
	$return.="</table></td><td>";
	$return.="<table border='1' cellpadding='10'><tr><th>Period</th><th></th><th>Start</th><th>End</th><th></th><th>Taken By</th></tr>";
	$get=mysql_query("select sessionid from MATDT where batid='$batid' and sec='$sec' and dayid='$date'");
	while($pr=mysql_fetch_array($get))
	{
		$arr[]=$pr['sessionid'];
	}
	$result=mysql_query("select * from SMETAT where batid='$batid' and sec='$sec' order by(pid)");
	while($res=mysql_fetch_array($result))
	{
		//include_once("connection.php");
		$pid=$res['pid'];
		$s1=mysql_query("select * from MATDT where sec='$sec' and batid='$batid' and dayid='$date' and sessionid='$pid'");
		$s2=mysql_fetch_array($s1);
		$fid1=$s2['fid'];
		$aid1=$s2['aid'];
		$fname=getFacName($fid1);
		if($fid1==$fid)
		{
			continue;
		}
		if(in_array($pid,$arr))
		{
			$subject=mysql_query("select * from MSUBJECTT where subid='$s2[subid]'");
			$subname=mysql_fetch_array($subject);
			$return.="<tr>";
			$timeinfo=$res['timeinfo'];
			$x=explode(';',$timeinfo);
			$return.="<td>Period $pid:</td>";
			$return.="<td><input type='radio' name='per1' value='".$pid."'></td>";
			$return.="<input type='hidden' name='aid1[$pid]' value='$aid1'>";
			$return.="<td>$x[0]</td>";
			$return.="<td>$x[1]</td>";
			$return.="<td><img src='../images/others/done.jpg' width='18'></td>";
			$return.="<td>$fname</td>";
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
		$return.="<td>Not Taken</td>";
		$return.= "</tr>";
			
	}
	$return.="</table>";
	$return.="</td></tr></table>";
	return $return;
}


function getPeriods($batid,$sec,$date)
{
	//include_once("connection.php");
	$date = strtotime($date);
	$result=mysql_query("select * from SMETAT where batid='$batid' and sec='$sec' order by(pid)");
	$get=mysql_query("select sessionid from MATDT where batid='$batid' and sec='$sec' and dayid='$date'");
	while($pr=mysql_fetch_array($get))
	{
		$arr[]=$pr[0];
	}

	$return="<table border='1' cellpadding='10'><tr><th>Period</th><th></th><th>Start</th><th>End</th></tr>";
	if(mysql_num_rows($result)<=0)
	{
		$classGet = queryMe("SELECT (select brname from MBRANCHT b where b.brid=t.brid)
			as brname,akayr from MBATCHT t where batid like '".$batid."'");
		$brname = $classGet['brname'];
		$year = getFullClass($classGet['akayr']);
		$batch = $brname." ".getFullClass($year+1)." ".$sec;
		notifyerr("No Schedule Uploaded For The Class ".$batch);
		redirect("?m=ua");
		return;
			
	}
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
	//include_once("connection.php");
	$date = strtotime($date);

	$get=mysql_query("select sessionid from MATDT where batid='$batid' and sec='$sec' and dayid='$date'");
	while($pr=mysql_fetch_array($get))
	{
		$arr[]=$pr[0];
	}

	$return="<table border='1' cellpadding='5'><tr><th>Period</th><th></th><th>Start</th><th>End</th></tr>";

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
	$return="<table border='1' cellpadding='5'><tr><th>Period</th><th></th><th>Start</th><th>End</th></tr>";
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

function getSubPeriods($batid,$sec,$date,$fid)
{
	//include_once("connection.php");
	$date = strtotime($date);
	$result=mysql_query("select * from SMETAT where batid='$batid' and sec='$sec' order by(pid)");
	$get=mysql_query("select sessionid from MATDT where batid='$batid' and sec='$sec' and dayid='$date' and fid='$fid'");
	while($pr=mysql_fetch_array($get))
	{
		$arr[]=$pr[0];
	}

	$return="<table border='1' cellpadding=3><tr><th>Period</th><th></th><th>Start</th><th>End</th></tr>";
	if(mysql_num_rows($result)<=0)
	{
		$classGet = queryMe("SELECT (select brname from MBRANCHT b where b.brid=t.brid)
			as brname,akayr from MBATCHT t where batid like '".$batid."'");
		$brname = $classGet['brname'];
		$year = getFullClass($classGet['akayr']);
		$batch = $brname." ".getFullClass($year+1)." ".$sec;
		notifyerr("No Schedule Uploaded For The Class ".$batch);
		redirect("?m=ua");
		return;
			
	}
	while($res=mysql_fetch_array($result))
	{
			
		$pid=$res['pid'];
		if(in_array($pid,$arr))
		{
			$return.="<tr>";
			$timeinfo=$res['timeinfo'];
			$x=explode(';',$timeinfo);
			$return.="<td>Period $pid:</td>";
			$return.="<td><input type='radio' name='per' value='".$pid."'></td>";
			$return.="<td>$x[0]</td>";
			$return.="<td>$x[1]</td>";
			$return.= "</tr>";
			continue;
		}
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
			document.getElementById('messages').innerHTML += '<div id=\"notif\">".$text."</div><br />';
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
			document.getElementById('messages').innerHTML+='<div id=\"notwar\">".$text."</div><br />';
		</script>
		";
}
function redirect($location)
{
	echo "
		<script type='text/javascript'>
			setTimeout('delayer()',1000);
			function delayer(){
			
			window.location = '".$location."';
			}
		</script>
		";

}
function check($checker)
{
	echo "
		<script type='text/javascript'>
			alert($checker)
		</script>
		";

}
function uploadAtt($batid,$sec,$ppl,$pora,$subid,$fid,$per,$date)
{

	//include_once("connection.php");
	$att=mysql_query("select * from MATDT");
	$aid=mysql_num_rows($att);
	mysql_query("insert into MATDT values('$aid','$fid','$batid','$sec','$date','$per','$subid')");
	mysql_query("insert into ADATAT values('$aid','$ppl','$pora')");
	totAtt($ppl,$pora,$batid);
}
function getFacName($fid)
{

	$fac=mysql_query("select * from MFACULTYT where fid ='$fid'");
	$faculty=mysql_fetch_array($fac);
	$facname=$faculty['fname'];
	return($facname);
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
	$sql = "SELECT *,(select imguri from MIMGT i where i.imgid=s.imgid) as imguri ,(select oid from MOBJECTT o where obhandle=sid and otyid='0') as oid FROM MSTUDENTT s WHERE batid LIKE '".$batid."' AND sec LIKE '".$sec."' order by('batid') DESC";
		
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
	$return = "";
	
	$query = "SELECT distinct sessionid from MATDT where batid like '".$batid."' and sec like '".$sec."' order by(sessionid)";
	//echo $query;
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
		(select oid from MOBJECTT o where obhandle=sid and otyid='0')
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
	
	$return = "";

	$bA = queryMe("SELECT batid,sec FROM MSTUDENTT WHERE sid like '".$sid."'");
	$batid = $bA["batid"];
	$sec = $bA["sec"];
	$i=0;
	$return = "<table border='1' style='text-align:center;'><th>Dates</th>";
	$ex = mysql_query("select * from MATDT where batid like '".$batid."' and sec like '".$sec."'");
	$exnum = mysql_num_rows($ex);
	if($exnum<=0)
	{
		notifyerr("No Attendance Uploaded Till Now!");
		redirect("?");
		return;
	}
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
function isPage($oid)
{


	$array = queryMe("SELECT otyid FROM MOBJECTT WHERE oid like '".$oid."'");
	$arrayd = array("0","1","2","3","4","5","6");
	if(in_array($array["otyid"],$arrayd))
	return false;
	else
	return true;


}
function isSudo($oid)
{

	$array = queryMe("SELECT otyid FROM MOBJECTT WHERE oid like '".$oid."'");
	if($array['otyid']=='4')
	return true;
	else
	return false;


}
function isAAdmin($oid)
{

	$array = queryMe("SELECT otyid FROM MOBJECTT WHERE oid like '".$oid."'");
	if($array['otyid']=='5')
	return true;
	else
	return false;


}
function isALib($oid)
{

	$array = queryMe("SELECT otyid FROM MOBJECTT WHERE oid like '".$oid."'");
	if($array['otyid']=='6')
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
	//include_once("connection.php");
	$student=mysql_query("select * from MSTUDENTT where srno='$rno'");
	$s=mysql_fetch_array($student);
	$sid=$s['sid'];
	$batid=$s['batid'];
	$marks=mysql_query("select * from MAVAILT where batid='$batid' and ros='R' order by(mrid)");
	$num=mysql_num_rows($marks);
	 
	$mpercent=0;
	$per = array();
	$i=0;
	while($m=mysql_fetch_array($marks))
	{
		$date=$m['doex'];
		$akyr=$m['akayr'];
		$mrid=$m['mrid'];
		$marks1=mysql_query("select * from MMARKST where sid='$sid' and mrid='$mrid' order by(mrid)");
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
function getBookImages($search,$subid,$ind)
{
	$srcurl = implode("%20",$search);
	$url = "https://ajax.googleapis.com/ajax/services/search/images?" .
		       "v=1.0&q=".$srcurl;

	// sendRequest
	// note how referer is set manually
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_REFERER, "www.google.com");
	$body = curl_exec($ch);
	curl_close($ch);
	$ret = "";
	// now, process the JSON string
	$json = json_decode($body);
	// now have some fun with the results...
	$demo = $json;
	$results = $demo->responseData->results;
	
	$arry = queryMe("select imgid from MSUBJECTT where subid like '".$subid."'");
	$imgcurl = getImgUri($arry["imgid"]);
	for($i=0;$i<count($results);$i++)
	{
		$item = $results[$i];
		$url = $item->url;
		$width = 150;
		$height = 200;
		$ret .= "<td><div class='img'><img src='".$url."' width='".$width."' height='".$height."' style='padding-right:5px;z-index:1'></img><div class='desc'>
			<input type='radio' name='selected".$ind."' value='".$subid."<".$url."<".$item->imageId."' style='z-index:4'></input></div></div></td>"; //Replace <
			
	}
	//$ret .= "<td><div class='img'><img src='../".$imgcurl."' width='".$width."' height='".$height."' style='padding-right:5px;z-index:1'></img><div class='desc'>Donot replace<br />
	//<input type='radio' name='selected".$ind."' value='NULL' style='z-index:4'></input></div></div></td>";
	return $ret;
}
function replaceSubjectImage($subid,$imguri,$imgid)
{

	$imgnamea = explode(".",$imguri);
	$temp = count($imgnamea)-1;
	$imgname = $imgnamea[$temp];
	$img = 'images/others/'.$imgid.".".$imgname;
	xDebug($img);
	$ch = curl_init($imguri);
	$fp = fopen("../".$img, 'wb');
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);



	$arr1 = queryMe("select count(imgid) as cnt from MIMGT");
	$imgid = $arr1["cnt"];


	mysql_query("insert into MIMGT values('".$imgid."','".$img."')");
	mysql_query("update MSUBJECTT set imgid='".$imgid."' where subid like '".$subid."'");
	mysql_query("update MOBJECTT set oimgid='".$imgid."' where obhandle='".$subid."' and otyid='2'");

}
function replaceObjectImage($oid,$imguri,$imgid)
{

	$imgnamea = explode(".",$imguri);
	$temp = count($imgnamea)-1;
	$imgname = $imgnamea[$temp];
	$img = 'images/others/'.$imgid.".".$imgname;
	xDebug($img);
	$ch = curl_init($imguri);
	$fp = fopen("../".$img, 'wb');
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);


	$arr1 = queryMe("select count(imgid) as cnt from MIMGT");
	$imgid = $arr1["cnt"];


	mysql_query("insert into MIMGT values('".$imgid."','".$img."')");
	mysql_query("update MSUBJECTT set imgid='".$imgid."' where subid like '".$subid."'");
	mysql_query("update MOBJECTT set oimgid='".$imgid."' where obhandle='".$subid."' and otyid='2'");

}
function xDebug($debug)
{

	if(!file_exists("../misc/.xdebug"))
	{
		$file = fopen("../misc/.xdebug","w");
			
	}
	else
	{
		$file = fopen("../misc/.xdebug",'a');
	}
	$debugarr = debug_backtrace();
	$debugstring = "<tr><td>".$debug."</td><td>".$debugarr[0]["file"]."</td><td>".$debugarr[0]["line"]."</td><td>".date("m.d.y")."</td><td>".date("h-i-s")."</td></tr>";
	//echo $debugstring;
	fputs($file,$debugstring);
	fclose($file);

}
function createStudentUser($sid,$uname,$pass)
{
	//include_once("connection.php");
	mysql_query("Update MOBJECTT set ologin='".$uname."' where obhandle='".$sid."' and otyid='0'");
	mysql_query("Update MOBJECTT set opwd='".$pass."' where obhandle='".$sid."' and otyid='0'");
	xDebug("Update MOBJECTT set ologin='".$uname."' where obhandle='".$sid."' and otyid='0'");
	xDebug("Update MOBJECTT set opwd='".$pass."' where obhandle='".$sid."' and otyid='0'");
}
function taughtBy($sid)
{
	
	$query = "select * from MFACULTYT where fcourse!=''";
	$result = mysql_query($query);
	$retarray = array();
	$cnt =0;
	//echo mysql_num_rows($result)."<br>";
	while($row = mysql_fetch_array($result))
	{
		$fcourse = $row["fcourse"];
		//print_r($row);
		$res = containsSubject($fcourse,$sid);
		if($res!=false)
		{

			$retarray[$cnt] = array();
			$retarray[$cnt]["fid"] = $row["fid"];
			$retarray[$cnt]["fname"]=$row["fname"];
			$sql = queryMe("select * from MOBJECTT where obhandle='".$row["fid"]."' and otyid='1'");
			$oid = $sql["oid"];
			$oimguri = getImgUri($sql["oimgid"]);
			$retarray[$cnt]["fprof"] = "?m=p&id=".$oid;
			//$retarray[$cnt]["fimguri"] = $oimguri;
			$retarray[$cnt]["classes"] = array();
			//print_r($res);
			for($i=0;$i<count($res);$i++)
			{
				$class = $res[$i];
				$batid = substr($class,0,1);
				$sec = substr($class,-1);
				$retarray[$cnt]["classes"][$i] = array();
				$classGet = queryMe("SELECT (select brname from MBRANCHT b where b.brid=t.brid)
					as brname,akayr from MBATCHT t where batid like '".$batid."'");
				$brname = $classGet['brname'];
				$year = getFullClass($classGet['akayr']);
				$batch = $brname." ".getFullClass($year+1)." ".$sec;
				$retarray[$cnt]["classes"][$i]["name"] = $batch;
				$retarray[$cnt]["classes"][$i]["url"] = "?m=src&q=%&t=0&ip=n&op=c&c=".$batid.":".$sec;
			}
			$cnt++;
		}
			
			
	}

	return $retarray;

}
function containsSubject($string,$key)
{
	//echo $key;
	$string = substr($string,0,-1);
	$x = explode(";",$string);
	$check = 0;
	$arr = array();
	$count = 0;
	for($i=0;$i<count($x);$i++)
	{
			
		$p = explode(":",$x[$i]);
		//print_r($p);
		if($p[1]==$key)
		{
			$check = -1;
			$arr[$count]=$p[0];
			$count++;
		}

			
			
	}
	return $arr;
}
function getStudent($sid)
{

	return queryMe("select *,(select imguri from MIMGT i where i.imgid=s.imgid) as img from MSTUDENTT s where sid like '".$sid."'");
}
function getStudentByRNO($sid)
{

	$t = mysql_query("select *,(select imguri from MIMGT i where i.imgid=s.imgid) as img from MSTUDENTT s where s.srno like '".$sid."'");
	return mysql_fetch_assoc($t);
	
}
function getBatchFromId($batid)
{

	return queryMe("select *,(select brname from MBRANCHT b where b.brid = t.brid) as brname from MBATCHT t where batid like '".$batid."'");
}
function getSubject($subid)
{

	return queryMe("select * from MSUBJECTT where subid like '".$subid."'");
}
function getFaculty($fid)
{

	return queryMe("select * from MFACULTYT where fid like '".$fid."'");
}
function getExtension($str)
{
	$i = strrpos($str,".");
	if (!$i)
	{
		return "";
	}
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}
function getFacultyForClassAsSelect($batid1,$sec1)
{

	//include_once("connection.php");

	 
	$ret = "Select Faculty : <select name='fid'>";
	$ret .= "<option value='null'>--Faculty--</option>";
	$f=mysql_query("select * from MFACULTYT where fcourse like '%$batid1$sec1%'");
	while($f1=mysql_fetch_array($f))
	{
		$fid=$f1['fid'];
		$fname=$f1['fname'];
		$ret .="<option value='$fid'>$fname</option>";
	}
	return $ret;


}
function getFacultyForClass($batid1,$sec1)
{

	//include_once("connection.php");
	//$ret .= "<option value='null'>--Faculty--</option>";
	$f=mysql_query("select * from MFACULTYT where fcourse like '%$batid1$sec1%'");
	$ret = array();
	$i=0;
	while($f1=mysql_fetch_array($f))
	{
		$fid=$f1['fid'];
		$fname=$f1['fname'];
		$ret[$i] = array();
		$ret[$i]["Name"] = $fname;
		$ret[$i]["Id"] = $fid;
		$ret[$i]["imguri"] = getImgUri($f1["imgid"]);
		$i++;
			
			
	}
	return $ret;


}
function getObjectByType($tyid,$handle)
{
    
	return queryMe("select * from MOBJECTT where obhandle like '".$handle."' and otyid like '".$tyid."'");
}
function getStudentType()
{

	return 0;

}
function getFacultyType()
{

	return 2;
}
function curPageURL()
{
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {
		$pageURL .= "s";
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}
function htmlify($url)
{

	$str = str_replace("&","%26",$url);
	$str2 = str_replace("/","%2F",$str);
	$str3 = str_replace(":","%3A",$str2);
	$str4 = str_replace("?","%3F",$str3);

	return $str4;

}
function getClassLink($batid,$sec)
{
	$array2 = queryMe("select (select brname from MBRANCHT br where br.brid=ba.brid) as brname,akayr from MBATCHT ba where batid like '".$batid."'");
	$batch = $array2['brname']." ".getFullClass($array2['akayr']+1)." Section: ".$sec;
	echo "<a href='?m=src&q=%&t=0&ip=n&op=c&c=".$batid.":".$sec."'>".$batch."</a>";

}
function getClassName($batid,$sec)
{
	$array2 = queryMe("select (select brname from MBRANCHT br where br.brid=ba.brid) as brname,akayr from MBATCHT ba where batid like '".$batid."'");
	$batch = $array2['brname']." ".getFullClass($array2['akayr']+1)." Section: ".$sec;
	echo $batch;

}


function page_descriptor($oid,$context)
{
	switch($page)
	{

		case "fb":return fb_descriptor($oid,$context);
		case '':return false;
	}
}
function page_profile($oid)
{

	$object = getObject($oid);
	$otype = $object["otyid"];
	echo  $type;
	if($otype == "7"){

		return fb_profile($oid);
	}
}
function fb_descriptor($oid)
{

	return "Feedback Form";


}

function fb_profile($oid)
{

	$object = getObject($oid);
	$fbid = $object["obhandle"];
	include_once("../modules/feedback/fb_lib.php");
	$entry = getFeedbackEntry($fbid);
	$batid =  $entry["batid"];
	$sec = $entry["sec"];
	$array2 = queryMe("select (select brname from MBRANCHT br where br.brid=ba.brid) as brname,akayr from MBATCHT ba where batid like '".$batid."'");
	$batch = $array2['brname']." ".getFullClass($array2['akayr']+1)." Section: ".$sec;
	$ret .= "<a href='?m=src&q=%&t=0&ip=n&op=c&c=".$batid.":".$sec."'>Feedback for :".$batch."</a>";

	$ret .= "<center></div><div id='content' style='float:right;'>";
	$ret .= "<h4 style='float:left;'>Feedback Entries&emsp;&emsp;<a href='?m=fbget&fbid=".$fbid."' style='float:right;margin-left:300px;'>Analyze</a></h4><br><br><br>";
	$ret .= getFeedback($fbid);
	$ret .= "</div></center>";
	return $ret;
}
function getObjectLink($oid)
{
	return  "?m=p&id=".$oid;

}
function getImageBox($link,$image,$name,$desc,$width,$hieght,$activeopacity,$uncativeopacity)
{

	return "<a href='".$link."'>
		<div class='img'><img src='".$image."' width='".$width."' height='".$hieght."' style='opacity:".$uncativeopacity."'
	  	onmouseover='this.style.opacity=".$activeopacity."'
  		onmouseout='this.style.opacity=".$uncativeopacity.";'>
		<div class='desc'><b><font color=#000000>".$name."</font></b><br><b><font color=#000000>".$desc."</b></font></div></div></a>";
}
function getSubjectBox($subid)
{

	$query = queryMe("select * from MSUBJECTT where subid like '".$subid."'");

	$img = "../".getImgUri($query["imgid"]);
	$name = $query["subname"];
	$books = explode(";",$query["books"]);
	$year = getFullClass($query["year"]);

	$object = getObjectByType("2",$subid);
	$link = "?m=p&id=".$object["oid"];

	$query2 = queryMe("select (select regname from MREGT r where r.regid like s.regid) as regname from SAVAILT s where subid like '".$query["suid"]."' ");
	//xDebug("select (select regname from MREGT r where r.regid like s.regid) as regname from SAVAILT where subid like '".$query["suid"]."' ");
	$regname = $query2["regname"];
	$ret = "<div class='box' style=''><table><tr><td><a href='".$link."'><img src='".$img."' width='75' height='75'></img></a></td>
		<td style='margin-left:10px;'>
			<table class='bttable' style='margin-left:10px;'>
			<tr><td>Name</td><td>".$name."</td></tr>
			<tr><td>Year</td><td>".$year."</td></tr>
			<tr><td>Regulation</td><td>".$regname."</td></tr>
			</table>
		</td>
	</table></div>";
	return $ret;
}

function getClassPreview($batid,$sec,$size,$number)
{

	
	$result = mysql_query("select * from MSTUDENTT where batid like '".$batid."' and sec like '".$sec."' order by rand() LIMIT 0,".$number);
	$ret = "<div class='box' style='width:auto;'>";
	$array2 = queryMe("select (select brname from MBRANCHT br where br.brid=ba.brid) as brname,akayr from MBATCHT ba where batid like '".$batid."'");
	$batch = $array2['brname']." ".getFullClass($array2['akayr']+1)." Section: ".$sec;
	$ret .= "<b>".$batch."</b>   <a href='?m=src&q=%&t=0&ip=n&op=c&c=".$batid.":".$sec."' target='_blank' title='".$batch."'><img src='../images/others/expand.png' width='20' hieght='20'></img></a>";
	$ret .= "<table>";
	$i=0;
	
	while($row = mysql_fetch_array($result))
	{
		if($i%$size == 0)
		$ret.= "<tr>";

		$name = getFname($row["sname"]);
		$img = "../".getImgUri($row["imgid"]);
		$roll = $row["srno"];
		$object = getObjectByType("0",$row["sid"]);
		$link = "?m=p&id=".$object["oid"];
		$ret .= "<td><a href='".$link."'>
		<div style=''><img src='".$img."' width='50' height='50' style='opacity:0.8';onmouseover='this.style.opacity=1'
  		onmouseout='this.style.opacity=0.8'><div style='font-size:10px;text-align:center'>".$name."</div>
		</div></a></td>";

		if(($i+1)%$size == 0)
		$ret .= "</tr>";
		$i++;
	}
	$ret .= "</table></div>";
	return $ret;
}
function getCurrentObject()
{

	return $_COOKIE["object"];
}
function module_parser()
{
	$filepath = "../modules/";
	$dirArray = array();
	$i=0;
	$myDirectory = opendir($filepath);
	while($entryName = readdir($myDirectory)) {
		if(!in_array($entryName,array(".","..")))
		{
			$modfile = $filepath.$entryName."/module.php";
	
			if(file_exists($modfile))
			{
							
				$dirArray[$i]["name"] = $entryName;
				$dirArray[$i]["modfile"] = $modfile;
				$i++;

			}
		}
	}
	//print_r($dirArray);
	closedir($myDirectory);

	return $dirArray;
}
function get_modules_render(){
	
	
	$filepath = "modules/";
	$dirArray = array();
	$i=0;
	$myDirectory = opendir($filepath);
	
	while($entryName = readdir($myDirectory)) {
			
		if(!in_array($entryName,array(".","..")))
		{
			
			$modfile = $filepath.$entryName."/module.php";
			
			if(file_exists($modfile))
			{
			
				require_once $modfile;
					
				$class = $entryName."_ModuleInfo";
				//echo $class;
				$object = new $class();
				
				$method = "module_getRenderData";
				if(method_exists($object,$method)){
					$x = $object->$method();
						
					$dirArray[$entryName] = $x;
					
				}	
				
				
			}
		}
	}
	closedir($myDirectory);

	return $dirArray;
	
}
function enableModules($list)
{
	queryMe("delete from MMODULET");
	for($i=0;$i<count($list);$i++)
	{

		$tag = $list[$i]["tag"];
		$file = $list[$i]["file"];
		$read = $list[$i]["reads"];
		$updates = $list[$i]["updates"];
		$modname = "mod_".$tag;

		queryMe("Insert into MMODULET values('".$i."','".$modname."','".$tag."','".$file."','".uniqid()."','".$read."','".$updates."')");

	}

}

function fq($query,$authtoken)
{
	$query = trim($query);
	$pquery = preg_split("/[\s]+/", $query);
	//print_r($pquery);
	$stat = $pquery[0];
	
	if(strtoupper($stat) == "SELECT")
	{

		$mod = getModFromToken($authtoken);
		$modreads = explode(";",$mod["mod_read"]);
		$table = $pquery[3];
		echo $table;
		if(in_array($table,$modreads))
		return mysql_query($query);
		else
		return -1;
	}
	if(strtoupper($stat) == "UPDATE")
	{
		$mod = getModFromToken($authtoken);
		$modreads = explode(";",$mod["mod_update"]);
		$table = $pquery[1];
		if(in_array($table,$modreads))
		return mysql_query($query);
		else
		return -1;
	}
	if(strtoupper($stat) == "INSERT")
	{
		$mod = getModFromToken($authtoken);
		$modreads = explode(";",$mod["mod_update"]);
		$table = $pquery[2];
		if(in_array($table,$modreads))
		return mysql_query($query);
		else
		return -1;
	}

}
function getModFromToken($token)
{

	$x = queryMe("select * from MMODULET where mod_authtoken='".$token."'");
	return $x;

}
function getAuthToken($modname)
{

	
	$x = queryMe("select * from MMODULET where mod_tag='".$modname."'");
	
	//xDebug($x["mod_authtoken"]);
	return $x["mod_authtoken"];

}

function getMenuItems($context,$parent)
{

	
	$array = array();
	$top = 0;
	$query = mysql_query("select * from MMODULET");
	while($row = mysql_fetch_array($query))
	{
		//print_r($row);
		require_once("../".$row["mod_file"]);
		$classname = $row["mod_tag"]."_ModuleInfo";
		$instance = new $classname();
		$links = $instance->module_getLinkInfo();

		for($i=0;$i<count($links);$i++)
		{
			if($links[$i]["createMenuItem"]=="yes")
			{

				if(in_array($context,$links[$i]["perms"]) && $links[$i]["parent"]==$parent)
				{
					$array[$top]["title"] = $links[$i]["title"];
					$array[$top]["link"] = "?m=".$links[$i]["mode"];
					$top++;
				}
			}
				
		}

	}
	return $array;

}
function getParentMenus($context)
{

	
	$array = array();
	$top = 0;
	$query = mysql_query("select * from MMODULET");
	while($row = mysql_fetch_array($query))
	{
		//print_r($row);
		require_once("../".$row["mod_file"]);
		$classname = $row["mod_tag"]."_ModuleInfo";
		$instance = new $classname();
		$links = $instance->module_getLinkInfo();

		for($i=0;$i<count($links);$i++)
		{
			if($links[$i]["type"]=="parent")
			{

				if(in_array($context,$links[$i]["perms"]))
				{
					$array[$top]["title"] = $links[$i]["title"];
					$array[$top]["tag"] = $links[$i]["tag"];
					if($links[$i]["mode"] != "")
						$array[$top]["link"] = "?m=".$links[$i]["mode"];
					else
						$array[$top]["link"] = "?m=mhpage&modtag=".$links[$i]["tag"];
					$top++;
				}
			}
				
		}

	}
	
	return $array;

}

function getLinkItems($context)
{

	
	$array = array();
	$top = 0;
	$query = mysql_query("select * from MMODULET");
	while($row = mysql_fetch_array($query))
	{

		require_once("../".$row["mod_file"]);
		$classname = $row["mod_tag"]."_ModuleInfo";
		$instance = new $classname();
		$links = $instance->module_getLinkInfo();
		$info = $instance->module_getInfo();
		for($i=0;$i<count($links);$i++)
		{

			if(in_array($context,$links[$i]["perms"]))
			{
				$array[$top]["tag"] = $info["mod_tag"];
				$array[$top]["mode"] = $links[$i]["mode"];
				$array[$top]["file"] = $links[$i]["file"];
				$array[$top]["modtag"] = $links[$i]["tag"];
				$array[$top]["show_side_menu"] = $links[$i]["show_side_menu"];
				$top++;
			}
				
				
		}

	}
	return $array;

}
function getObjectTypeTag($otyid)
{

	$x = queryMe("select tag from OTYPET where tyid like '".$otyid."'");
	return $x["tag"];

}
function freeedu_add_css($link){
	
		if(!file_exists("css.json")){
			
				$file = fopen("css.json","w");
				$css = json_encode(array($link));
				fputs($file,$css);
		}
		else{
				$file = fopen("css.json","r");
				$css = json_decode(fgets($file));
				fclose($file);
				if(!in_array($link,$css)){
						$file = fopen("css.json","w");
						$css = array_merge($css,array($link));
						fputs($file,json_encode($css));
				}
			
		}
}
function freeedu_add_js($link){
	
		if(!file_exists("js.json")){
				$file = fopen("js.json","w");
				$css = json_encode(array($link));
				fputs($file,$css);
		}
		else{
				$file = fopen("js.json","r");
				$css = json_decode(fgets($file));
				fclose($file);
				if(!in_array($link,$css)){
						$file = fopen("js.json","w");
						$css = array_merge($css,array($link));
						fputs($file,json_encode($css));
				}
			
		}
}
function getModuleInfo($tag){
	
	
		require_once("../modules/".$tag."/module.php");
		$classname = $tag."_ModuleInfo";
		$instance = new $classname();
		$info = $instance->module_getInfo();
		return $info;
}
function path_exists($path){

	echo $path;
	return file_exists($path);

}
function include_all_models_and_controllers(){

	$it = new RecursiveDirectoryIterator("../");
	foreach(new RecursiveIteratorIterator($it) as $file) {
		if(is_dir($file)){
			echo "$file\n";
			$t = preg_match("/models/", $file,$matches);
			if(count($matches) > 0)
				print_r($matches);
		}
	}

}
//include_all_models_and_controllers();
//include_once("../misc/constants.php");
//print_r(getLinkItems('sudo'));
//var_dump(fq("update MOBJECTT values(1,2)","4e884dfa84160"));

?>
