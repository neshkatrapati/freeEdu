<html>
  <head

</head>
<body><?php
          $snum=$_GET['snum'];
          include_once("../../lib/connection.php");
	  include_once("../../lib/lib.php");
	  include_once("library_lib.php");
          for($j=0;$j<$snum;$j++)
          {
            echo "<br><br>Select Branch:";
            $arr=getBranches();
            $len=count($arr);
	        echo "<select name='branch$j' onchange='showUser(this.value,reg$j.value,$j)'>";
	        echo "<option value='-1'>--Remove Option-</option>";
	        include_once("../lib/connection.php");
	        for($i=0;$i<$len;$i++)
	        {
	    	$br=mysql_query("select brid from MBRANCHT where brname='$arr[$i]'") or die(mysql_error());
	    	$branch=mysql_fetch_array($br);
	    	$brid=$branch['brid'];
	    	echo "<option value='$brid'>$arr[$i]</option>";
	        }
	        echo "</select>&nbsp";
	        echo "</select>";
	        echo "&nbspRegulation:";
	        $reg=getRegulations();
	        $rlen=count($reg);
		    echo "<select name='reg$j' onchange='showUser(branch$j.value,this.value,$j)'>";
	        echo "<option value='-1'>--Remove Option--</option>";
	        for($i=0;$i<$rlen;$i++)
	        {
	    	$r=mysql_query("select * from MREGT where regname='$reg[$i]'") or die(mysql_error());
	    	$rg=mysql_fetch_array($r);
	    	$regid=$rg['regid'];
	    	echo "<option value='$regid'>$reg[$i]</option>";
	        }
		echo "</select><br><br>";
        	echo "<div id='txtHint$j'>Note:Select branch and Regulation to Select a subject</div>";
          }
	
?>
</body>
</html>
