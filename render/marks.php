<?php
	$params = $_GET;
	if($params["view"] == "student"){
			echo json_encode(retrival(strtoupper($params["srno"])));
	}
	else if($params["getlist"] == "true"){
		$wheres = array("mrid","batid","doex","ros","akayr");
		$w = "";
		$i = 0;
		foreach($wheres as $v){
				if($_GET[$v]!=""){
					if($i!=0)
						$w .= " and ";
					$x = $_GET[$v];
					$w .= "$v like '$x'";
					$i++;
			}
		
		}
		if($w != "")
			$w = " where $w";
		$t = mysql_query("select * from MAVAILT $w");
		
		while($arr =  mysql_fetch_assoc($t)){
				$jsonarr[] = $arr;
		}
		$json = json_encode($jsonarr);
		echo $json;
	}
	else if($params["mrid"] != ""){
		$wheres = array("sid","subid","intm","extm","cre");
		$w = "";
		$i = 0;
		foreach($wheres as $v){
				if($_GET[$v]!=""){
					if($i!=0)
						$w .= " and ";
					$x = $_GET[$v];
					$w .= "$v like '$x'";
					$i++;
			}
		
		}
		if($params["sname"] != "")
			$w .= " m.sid in (select t.sid from MSTUDENTT t where sname like '".$params["sname"]."') ";
		
		if($params["subname"] != "")
			$w .= " and  m.subid in (select t.subid from MSUBJECTT t where subname like '".$params["subname"]."') ";
		
		if($w != "")
			$w = "and $w";
		$mrid = $params["mrid"];
		$filter = $params["filter"];
		if($filter != "")
			$filter = "and $filter";
		
		$q = "select *,(select subname from MSUBJECTT s where s.subid = m.subid) as subname,(select sname from MSTUDENTT p where p.sid=m.sid $stu ) as sname from MMARKST m where mrid='$mrid' $w $filter";
		$t = mysql_query($q);
		
		while($arr =  mysql_fetch_assoc($t)){
				$jsonarr[] = $arr;
		}
		$json = json_encode($jsonarr);
		echo $json;
		
	}
function retrival($srno)
{

$newakyr=-1;
$srno= strtoupper("$srno");
$result=mysql_query("select * from MSTUDENTT where srno='$srno'");
$rownum=mysql_num_rows($result);
if($rownum<=0)
{
	return -1;
}
else
{
	

while($s = mysql_fetch_array($result))
{
	$sid=$s[0];
	$batid=$s[6];
	$did=$s[8];
	$imgid=$s[5];
	$image=mysql_query("select * from MIMGT where imgid='$imgid'");
	$img=mysql_fetch_array($image);
	$imguri=$img[1];
	$arr=array("img" => $imguri);
}
$arr["detain"]="";
if($did>=0)
{
	$detain=mysql_query("select * from MDETAINT where did='$did'");
	while($d=mysql_fetch_array($detain))
	{	
		$batid=$d[2];
		$newbatid=$d[3];
		$newakyr=$d[4];
	}
	if($newakyr=='0')
	{
		$arr["detain"]="<font color='red'>NOTE:The Student is Detained in 1st Year</font>";
	}
	else if($newakyr=='1')
	{
		$arr["detain"]="<font color='red'>NOTE:The Student is Detained in 2-1</font>";
	}
	else if($newakyr=='2')
	{
		$arr["detain"]="<font color='red'>NOTE:The Student is Detained in 2-2</font>";
	}
	else if($newakyr=='3')
	{
		$arr["detain"]="<font color='red'>NOTE:The Student is Detained in 3-1</font>";
	}
	else if($newakyr=='4')
	{
		$arr["detain"]="<font color='red'>NOTE:The Student is Detained in 3-2</font>";
	}
	else if($newakyr=='5')
	
		$arr["detain"]="<font color='red'>NOTE:The Student is Detained in 4-1</font>";
	}
	else if($newakyr=='6')
	{
		$arr["detain"]="<font color='red'>NOTE:The Student is Detained in 4-2</font>";
	}
	

}


$branch=mysql_query("select * from MBATCHT where batid='$batid'");
while($br = mysql_fetch_array($branch))
{
	$brid=$br[1];
	$regid=$br[2];
	$batyr=$br['batyr'];
}

$brname=mysql_query("select * from MBRANCHT where brid='$brid'");
while($BR=mysql_fetch_array($brname))
{
	$brname=$BR[1];
	$arr["brname"]=$brname;
}
$reg=mysql_query("select * from MREGT where regid='$regid'");
while($REG=mysql_fetch_array($reg))
{
	$reg=$REG[1];
	$arr["reg"]=$reg;
}
$regular=mysql_query("select * from MAVAILT where batid='$batid' and ros='R'");
$i=0;
while($reglr=mysql_fetch_array($regular))
{
	
	$mrid=$reglr[0];
	$akyr=$reglr[4];
	
	
	if($akyr=='1')
	{
		$arr_reg_r['mrid']=$mrid;
		$arr_reg_r['rname']="Results For 1st Year Regular";
	}
	else if($akyr=='2')
	{
		$arr_reg_r['mrid']=$mrid;
		$arr_reg_r['rname']="Results For 2nd Year 1st Semester Regular";
	}
	else if($akyr=='3')
	{
		$arr_reg_r['mrid']=$mrid;
		$arr_reg_r['rname']="Results For 2nd Year 2st Semester Regular";
	}
	else if($akyr=='4')
	{
		$arr_reg_r['mrid']=$mrid;
		$arr_reg_r['rname']="Results For 3rd Year 1st Semester Regular";
	}
	else if($akyr=='5')
	{
		$arr_reg_r['mrid']=$mrid;
		$arr_reg_r['rname']="Results For 3rd Year 2nd Semester Regular";
	}
	else if($akyr=='6')
	{
		$arr_reg_r['mrid']=$mrid;
		$arr_reg_r['rname']="Results For 4th Year 1st Semester Regular";
	}
	else if($akyr=='7')
	{
		$arr_reg_r['mrid']=$mrid;
		$arr_reg_r['rname']="Results For 4th Year 2nd Semester Regular";
	}
	$arr_reg[]=$arr_reg_r;
		
		$marks=mysql_query("select * from MMARKST where sid='$sid' and mrid='$mrid'");
		while($sub=mysql_fetch_array($marks))
		{
			$subid=$sub[2];
			$subject=mysql_query("select * from MSUBJECTT where subid='$subid'");
			while($subj=mysql_fetch_array($subject))
			{
				$subname=$subj[2];
				$subcode=$subj[1];
				$arr_marks_sub['subcode']=$subcode;
				$arr_marks_sub['subname']=$subname;
			}
			$intr=$sub[3];
			$extr=$sub[4];
			$cre=$sub[5];
			$arr_marks_sub['intr']=$intr;
			$arr_marks_sub['extr']=$extr;
			$arr_marks_sub['cre']=$cre;
			$arr_marks[]=$arr_marks_sub;
		}
		$arr_marks_main['type']='Regular';
		$arr_marks_main['marks']=$arr_marks;
		unset($arr_marks);
		$array_marks[]=$arr_marks_main;
		
		
	
	if($newakyr==$akyr)
	{
		detainRegular($newbatid,$newakyr,$sid);
		break;
	}
	


}




$supply=mysql_query("select * from MAVAILT where batid='$batid' and ros='S'");
while($supp=mysql_fetch_array($supply))
{	
	$mrid=$supp[0];
	$akyr=$supp[4];
	$regular=mysql_query("select * from MAVAILT where batid='$batid' and ros='R'");
	while($reg=mysql_fetch_array($regular))
	{
		$doex=$reg[2];
	}
	if($akyr=='1')
	{
		$arr_reg_b['mrid']="-1";
		$arr_reg_b['rname']="Black Log History-Results For 1st Year Supplymentary";
	}
	else if($akyr=='2')
	{
		$arr_reg_b['mrid']="-1";
		$arr_reg_b['rname']="Black Log History-Results For 2nd Year 1st Semester Supplymentary";
	}
	else if($akyr=='3')
	{
		$arr_reg_b['mrid']="-1";
		$arr_reg_b['rname']="Black Log History-Results For 2nd Year 2st Semester Supplymentary";
	}
	else if($akyr=='4')
	{
		$arr_reg_b['mrid']="-1";
		$arr_reg_b['rname']="Black Log History-Results For 3rd Year 1st Semester Supplymentary";
	}
	else if($akyr=='5')
	{
		$arr_reg_b['mrid']="-1";
		$arr_reg_b['rname']="Black Log History-Results For 3rd Year 2nd Semester Supplymentary";
	}
	else if($akyr=='6')
	{
		$arr_reg_b['mrid']="-1";
		$arr_reg_b['rname']="Black Log History-Results For 4th Year 1st Semester Supplymentary";
	}
	else if($akyr=='7')
	{
		$arr_reg_b['mrid']="-1";
		$arr_reg_b['rname']="Black Log History-Results For 4th Year 2nd Semester Supplymentary";
	}
	$arr_reg[]=$arr_reg_b;
	$marks=mysql_query("select * from MBACKLOGT where sid='$sid' and doex='$doex'");
	$rows=mysql_num_rows($marks);	
	if($rows<=0)
	{
		$arr["backlog"]="No Backlog History";
		break;
	}
	else
	{
		$arr["backlog"]="Backlog History";
	}
		while($sub=mysql_fetch_array($marks))
		{
			$subid=$sub[2];
			$subject=mysql_query("select * from MSUBJECTT where subid='$subid'");
			
			while($subj=mysql_fetch_array($subject))
			{
				$subname=$subj[2];
				$subcode=$subj[1];
				$arr_marks_sub['subcode']=$subcode;
				$arr_marks_sub['subname']=$subname;
								
			}
			$intr=$sub[3];
			$cre='0';
			$extr=$sub[4];
			$arr_marks_sub['intr']=$intr;
			$arr_marks_sub['extr']=$extr;
			$arr_marks_sub['cre']=$cre;
			$arr_marks[]=$arr_marks_sub;
		}
		$arr_marks_main['type']='Supply';
		$arr_marks_main['marks']=$arr_marks;
		unset($arr_marks);
		$array_marks[]=$arr_marks_main;
		
	if($newakyr>=$akyr)
	{
		detainSupply($newbatid,$newakyr,$sid);
		break;
	}
}

$main_arr[]=$arr;
$main_arr[]=$arr_reg;
$main_arr[]=$array_marks;
return $main_arr;
}


?>
