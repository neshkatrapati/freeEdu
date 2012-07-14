<?php
include_once("../lib/lib.php");
include_once("../lib/connection.php");
$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
$mode = $_GET["mode"];

if($mode == "types")
{
    $result = mysql_query("select distinct * from MPAGET");
    $ret = "<select name='ptypes[]' id='ptypes'>";
    $ret .= "<option value=''>--Select--</option>";
    while($row = mysql_fetch_array($result))
    {
        $ret .= "<option value='".$row["pid"]."'>".$row["pname"]."</option>";
        
    }
    $ret .= "</select>";
  
    echo $ret;
}
else if($mode == "search")
{
    $pid = $_GET["pid"];
    $query = mysql_query("select *,(select imguri from MIMGT i where i.imgid=o.imgid) as img,
			 (select ptag from MPAGET p where p.pid = o.obhandle)
			 as ptag from MOBJECTT o where obhandle='".$pid."' and otyid='7'");
    
    while($row = mysql_fetch_array($query))
    {
	echo "<a href='?m=p&id=".$row['oid']."'>";	
		echo "<div class='img'>";
	
	$tag = $row["ptag"];
	
	echo "<img src='../".$row['img']."' width='50' height='50' style='opacity:0.8;filter:alpha(opacity=40)'
	  	onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
  		onmouseout='this.style.opacity=0.8;this.filters.alpha.opacity=20'>
		<div class='desc'><b><font color=#000000>".getFname($row['obname'])."</font></b><br><b><font color=#000000>".page_descriptor($tag)."</b></font></div></div></a>";
    }
    
}

?>
