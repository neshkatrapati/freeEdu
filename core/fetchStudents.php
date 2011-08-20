<style>
.padd
{
	padding:0 0px 0px;
	

}
.cont 
{
	
}
</style>
<?php
include("../misc/constants.php");
function fetchStudents($batch)
{

		if($batch != "") 
		{
			$clsname = "Constants";
			$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
			mysql_select_db($clsname::$dbname, $con);
			$wherestr = "where Tables_in_freeedu like 'Batch%'";
			if($batch != "all")
			{
				$res1 = mysql_query("select batname from batavail where batyr='".$batch."'");
				$rowx = mysql_fetch_array($res1);
				$batname = $rowx['batname'];
				//echo $batname;
				$wherestr = "where Tables_in_freeedu like '".$batname."'";
				//echo $wherestr;
			}
			$result = mysql_query("show tables ".$wherestr);
			$i=0;
			while($row = mysql_fetch_array($result))
  			{
  			
  				$batchname = $row["Tables_in_freeedu"];
  				$result2 = mysql_query("select sname,imgURI from ".$batchname);				/*Replace The Division Factor.. Choose A Factor Of Stud*/
  				while($row2 = mysql_fetch_array($result2))
  				{
					$i++;  					
  					$appendo = "&emsp;";
  					if($i==3)
  					{			
	  					$appendo = "<br />";
	  					$i=0;
	  				}
	  				$rstring .= "<img class='padd' src='../".$row2['imgURI']."'/>".$row2['sname'].$appendo.""; //Change The Ref! 
	  				
  				}
  				
  			}
			return $rstring;
		}
}

?>
