<link rel="stylesheet" href="../aux/pagestyles/profiles.css" type="text/css" media='screen'>
<link rel="stylesheet" href="../aux/pagestyles/style.css" type="text/css" media='screen'>
<link rel="stylesheet" href="../aux/pagestyles/livesearch.css" type="text/css" media='screen'>
<link rel="stylesheet" href="../aux/bootstrap/bootstrap-1.0.0.css" type="text/css" media="screen" />
<script src="../aux/bootstrap/docs/assets/js/application.js"></script>
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
<?php
    echo "<center>";
    if(!isset($_POST["sub2"]))
    {
        $subid = $_GET["subid"];
        //echo "Select A Book";
        //require_once "../lib/lib.php";
       require_once '../lib/connection.php';
         echo "<form action='#' method='post'>";
        
        $subres = mysql_query("SELECT * from MSUBJECTT where subid like '".$subid."'");
	    $cnt = 0;
         while($row = mysql_fetch_array($subres))
        {
                
		if($row['books']=='')
		{
		
		    echo "<br><br><div id='notwar'>There Are No Books Associated With The Subject</div>";
		    return;
		}
        
                $books = $row["books"];
                $barray = explode(";",$books);
                $name = "bimg".$cnt;
                
                echo "<select name='books[]' onchange='getImages(\"".$row["subid"]."\",\"".$row['subname']."\",this.value,\"".$name."\",\"".$cnt."\")'>";
                
                echo "<option value=''>Select</option>";
                for($i=0;$i<count($barray);$i++)
                {
                    
                    echo "<option value='".$barray[$i]."'>".$barray[$i]."</option>";
                }
                echo "</select>&emsp;<input type='submit' name='sub2' /><br><br>";
                echo "<div id='bimg".$cnt."' style='width:500px;float:right'></div>";
                
                
                $cnt++;
                    
        }
        echo "<br />";
	
	echo "<input type='hidden' name='count' value='".$cnt."' />";
        //echo $cnt;
	echo "</center></form>";}
        if(isset($_POST["sub2"]))
        {
            
            $selected = $_POST["count"];
            //echo $selected;
	    for($i=0;$i<$selected;$i++)
            {
                if(array_key_exists("selected".$i,$_POST))
                {
                    $rar = $_POST["selected".$i];
                    $arr = explode("<",$rar);
		    //print_r($arr);
		    $imguri = $arr[1];
		    $imgid = $arr[2];
		    $subid = $arr[0];
                    $imgnamea = explode(".",$arr[1]);
		    $temp = count($imgnamea)-1;
		    $imgname = $imgnamea[$temp];
		    $img = 'images/others/'.$arr[2].".".$imgname;
		    //xDebug($img);
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
		    echo "Done!";
		    echo "<script type='text/javascript'>";
		    echo "$(function() {
		      $('.nyroModal').close();
	    	    });";
		    echo "</script>";
		    redirect("?");
                }
            }
    }


    echo "</center>";

    function queryMe($query)
	{
		require_once("../lib/connection.php");
		$clsname = "Constants";
		$con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
		mysql_select_db($clsname::$dbname, $con);
		
		$sqlresult = mysql_query($query);
		return mysql_fetch_array($sqlresult);

	}



?>
