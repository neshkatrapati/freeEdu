<?php
$q = $_GET['q'];
$q = strtoupper($q);
include("../misc/constants.php");
include("../lib/lib.php");
$clsname = "Constants";
$batname = $clsname::$batname;
$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
mysql_select_db($clsname::$dbname, $con);
$sql = mysql_query("SELECT *,(select imguri from MIMGT  where imgid = oimgid) as img,(select tyname from OTYPET where tyid=otyid) as type FROM MOBJECTT WHERE obname LIKE '".$q."%' LIMIT 0,5");
while($row = mysql_fetch_array($sql))
{
	echo "<li><a href='?m=p&id=".$row['oid']."'>";	
 	echo "<img src='../".$row['img']."' width='50' height='50' style='opacity:0.4;filter:alpha(opacity=40)'
  	onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
	onmouseout='this.style.opacity=0.4;this.filters.alpha.opacity=20'></img>
	".$row['obname']."".$row['type']."</a></li>";
}
echo "<li><a href='?m=os'>Search For More Results</a></li>"
?>