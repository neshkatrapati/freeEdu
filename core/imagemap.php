<head>
    
    <script type='text/javascript'>
        
        function getImages(subid,subval,val,el,i)
        {
            
            var list = document.getElementById(el);
            if (window.XMLHttpRequest)
            {
 		
 		xmlhttp=new XMLHttpRequest();
            }
            xmlhttp.onreadystatechange=function()
            {
		
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
				
			list.innerHTML = xmlhttp.responseText;
		
			
		}	
            }
	
	xmlhttp.open("GET","../core/booksearch.php?subname="+subval+"&book="+val+"&subid="+subid+"&i="+i,true);
	xmlhttp.send();
        }
        
    </script>
    
</head>
<fieldset>
    <legend>Map Images To Subjects</legend>
<?php
    if(!isset($_POST["sub"]) && !isset($_POST["sub2"])){
      $placeBranch = "";
        $Brret = getBranches();
        $placeReg = "";
        $Regret = getRegulations();
            
        for($i=0;$i<count($Brret);$i++)
            $placeBranch=$placeBranch."<option value='".$Brret[$i]."'>".$Brret[$i]."</option>";
        for($i=0;$i<count($Regret);$i++)
            $placeReg=$placeReg."<option value='".$Regret[$i]."'>".$Regret[$i]."</option>";
            
     echo "<form method=\"post\" action='#' enctype=\"multipart/form-data\">
              
            		Choose Branch:
            		<select name='brn[]'>".$placeBranch.
            		"</select>&emsp;&emsp;Choose Regulation:<select name='reg[]'>".$placeReg."</select>&emsp;Select Academic Year:<select name='yr[]'>
					<option value='1'>1st Year</option>
					<option value='2'>2-1</option>
					<option value='3'>2-2</option>
					<option value='4'>3-1</option>
					<option value='5'>3-2</option>
					<option value='6'>4-1</option>
					<option value='7'>4-2</option>
					</select><br /><br />
            		<input type=\"submit\" name=\"sub\" value=\"Submit\" />
                </fieldset>
            </form>";
        echo "</center>";}
    if(isset($_POST["sub"]) && !isset($_POST["sub2"]))
    {
        echo "<form action='#' method='post'>";
        $clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
        $brn = $_POST['brn'][0];
	$reg = $_POST['reg'][0];
        $yr = $_POST['yr'][0];
        $brid = getBranchByName($brn);
        $regid = getRegByName($reg);
        $subres = mysql_query("SELECT * from MSUBJECTT where suid like 
		(select subid from SAVAILT where brid like '".$brid."' and regid like '".$regid."') and year like '".$yr."' ");
        echo "<table style='text-align:center;'>";
        $cnt = 0;
        while($row = mysql_fetch_array($subres))
        {
            echo "<tr>";
            echo "<td><div class='img'><img src='../".getImgUri($row['imgid'])."' width='75' height='75' style='opacity:0.8;filter:alpha(opacity=40)'
	  	onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
  		onmouseout='this.style.opacity=0.8;this.filters.alpha.opacity=20'>
		<div class='desc'><b><font color=#000000>".$row["subname"]."</font></b></font></div></div></td>";
            $books = $row["books"];
            $barray = explode(";",$books);
            $name = "bimg".$cnt;
            
	    echo "<td><select name='books[]' onchange='getImages(\"".$row["subid"]."\",\"".$row['subname']."\",this.value,\"".$name."\",\"".$cnt."\")'>";
            
            echo "<option value=''>Select</option>";
            for($i=0;$i<count($barray);$i++)
            {
                
                echo "<option value='".$barray[$i]."'>".$barray[$i]."</option>";
            }
            echo "</select></td>";
            echo "<td><div id='bimg".$cnt."'></div></td>";
            echo "</tr>";
            $cnt++;
            
        }
        echo "</table>";
	echo "<input type='submit' name='sub2' />";
	echo "<input type='hidden' name='count' value='".$cnt."' />";
	echo "</form>";
        
   }
    if(isset($_POST["sub2"]))
    {
	
	$selected = $_POST["count"];
	for($i=0;$i<$selected;$i++)
	{
	    if(array_key_exists("selected".$i,$_POST))
	    {
		$rar = $_POST["selected".$i];
	        $arr = explode("<",$rar);
		//print_r($rar);
	        replaceSubjectImage($arr[0],$arr[1],$arr[2]);
		redirect("?m=immap");
	    }
	}
    }

?>