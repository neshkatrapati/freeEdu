<?php

	    
            $arr=getBranches();
	    $len=count($arr);
	    echo "Branch:<select name='branch' onchange='newsub(this.value,reg.value)'>";
	       echo "<option value='-1'>--Select the Branch--</option>";
	    for($i=0;$i<$len;$i++)
	    {
		$br=mysql_query("select brid from MBRANCHT where brname='$arr[$i]'") or die(mysql_error());
		$branch=mysql_fetch_array($br);
		$brid=$branch['brid'];
		echo "<option value='$brid'>$arr[$i]</option>";
	    }
	    echo "</select>&nbspRegulation: ";
	    $reg=getRegulations();
	    $rlen=count($reg);
	    include_once("../lib/connection.php");
	    echo "<select name='reg'  onchange='newsub(this.value,reg.value)'>";
	       echo "<option value='-1'>--Select the Regulation--</option>";
	    for($i=0;$i<$rlen;$i++)
	    {
		$r=mysql_query("select * from MREGT where regname='$reg[$i]'") or die(mysql_error());
		$rg=mysql_fetch_array($r);
		$regid=$rg['regid'];
		echo "<option value='$regid'>$reg[$i]</option>";
	    }
	    echo "</select>";
?>