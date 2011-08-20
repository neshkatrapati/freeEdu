<html>
    <body>
        <fieldset>
            <legend>Edit Subject Lists</legend>
            <center>
                <form action='#' method='post'>
                <?php
				include("../lib/connection.php");
                    if(!isset($_POST['phase1']))
                    {
                        $placeBranch = "";
                        $Brret = getBranches();
                        $placeReg = "";
                        $Regret = getRegulations();
            
                        for($i=0;$i<count($Brret);$i++)
                            $placeBranch=$placeBranch."<option value='".$Brret[$i]."'>".$Brret[$i]."</option>";
                        for($i=0;$i<count($Regret);$i++)
                            $placeReg=$placeReg."<option value='".$Regret[$i]."'>".$Regret[$i]."</option>";
                        echo "Branch:&nbsp;<select name='brn[]'>".$placeBranch.
                        "</select>&emsp;Regulation:&nbsp;<select name='reg[]'>".$placeReg."</select><br /><br/>Select Year-Sem:&nbsp".getAllSemsAsSelect("yr[]")."<br /><br />";
                        echo "&emsp;<input type='submit' name='phase1'></input>";
                    }
                
                echo "</form>";	
		if(isset($_POST['phase1']))
		{
		
			$brn = $_POST['brn'][0];
	   		$reg = $_POST['reg'][0];
	   		$year = $_POST['yr'][0]+1;
			$brn=mysql_query("select brid from MBRANCHT where brname='$brn'");
			$brid=mysql_fetch_array($brn);
			$reg=mysql_query("select regid from MREGT where regname='$reg'");
			$regid=mysql_fetch_array($reg);
			$sub=mysql_query("select subid from SAVAILT where brid='$brid[0]' and regid='$regid[0]'");
			$subid=mysql_fetch_array($sub);
			$subject=mysql_query("select * from MSUBJECTT where suid='$subid[0]' and year='$year'");
			$num=mysql_num_rows($subject);	
						
			echo "<form action='#' method='post'>";
			echo "<table border=1 style='text-align:center;'>";	
			echo "<tr>";
				echo "<th>Subcode</th>";
				echo "<th>SubName</th>";
				echo "<th>InMax</th>";
				echo "<th>ExMax</th>";
				echo "<th>ExMin</th>";			
			echo "</tr>";	
			while($subd=mysql_fetch_array($subject))
			{
				echo "<tr>";
				echo "<td><input type='text' name='subcode[]' value='$subd[subcode]' required='true' size='10'></td>";
				echo "<td><input type='text' name='subname[]' value='$subd[subname]' required='true' size='60'></td>";
				echo "<td><input type='text' name='inmax[]' value='$subd[inmax]' required='true' size='5'></td>";
				echo "<td><input type='text' name='exmax[]' value='$subd[exmax]' required='true' size='5'></td>";
				echo "<td><input type='text' name='exmin[]' value='$subd[exmin]' required='true'  size='5'></td>";
				echo "<input type='hidden' name='subid[]' value='$subd[subid]'>";
				echo "<input type='hidden' name='num' value='$num'>";
				echo "</tr>";
			}
			echo "</table>";
			echo "<input type='submit' value='Update' name='phase2'>";
			echo "</form>";
		}
		if(isset($_POST['phase2']))
		{
				include("../lib/connection.php");
			$num=$_POST['num'];
			for($i=0;$i<$num;$i++)
			{
				
				$subcode=$_POST['subcode'][$i];
				$subname=$_POST['subname'][$i];
				$inmax=$_POST['inmax'][$i];
				$exmax=$_POST['exmax'][$i];
				$exmin=$_POST['exmin'][$i];
				$subid=$_POST['subid'][$i];
				mysql_query("update MSUBJECTT set subname='$subname',subcode='$subcode',inmax='$inmax',exmax='$exmax',exmin='$exmin' where 								subid='$subid'") or die(mysql_error());
						
				
	
			}
			notify("Updated Successfully");	
		}
	


?>
                    
            </center>
        </fieldset>
    </body>
</html>
