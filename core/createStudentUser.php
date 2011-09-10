<script type='text/javascript'>
    
    function check(value)
    {
        var list = document.getElementById("avail");
        var hob = document.getElementById("iavail");
	var string = "";
	string = "../core/usercheck.php?q="+value;
        if(value!="")
        {
            if (window.XMLHttpRequest)
            {
            	xmlhttp=new XMLHttpRequest();
            }
            xmlhttp.onreadystatechange=function()
            {
            	SELECT * FROM `MOBJECTT` WHERE 1
            	if(xmlhttp.readyState==4 && xmlhttp.status==200)
            	{
            		
            		var x = xmlhttp.responseText;
                        
                            if(x==2)
                            {
                                    hob.innerHTML = "";
                                    list.innerHTML = "Username Already Taken";
                                    list.setAttribute("style","color:red");
                            }
                            else
                            {
                                hob.innerHTML = "<input type='submit' name='phase2'>";
                                list.innerHTML = "Username Available";
                                list.setAttribute("style","color:green");
                            }
            	}
                    
            }
        }
	xmlhttp.open("GET",string,true);
	xmlhttp.send();
        
    }
    
</script>
<fieldset>
    <legend>Create Student User</legend>
    <center>
<?php
    if(!isset($_POST['phase1']) && !isset($_POST['phase2']))
    {
        
        echo "<form action='#' method='post'>";
        echo "Enter Rollnumber:<input type='text' name='rno' required=true></input>";
        echo "<input type='submit' name='phase1'>";
        echo "</form>";
        
    }
    if(isset($_POST['phase1']))
    {
        include("../lib/connection.php");
        $srno = $_POST["rno"];
        $srno= strtoupper($srno);
        $result=mysql_query("select * from MSTUDENTT where srno='$srno'");
        $rownum=mysql_num_rows($result);
    
        if($rownum<=0)
        {
        	notifyerr("Invalid Hallticket Number");
        }
        else
        {
           
            $new = mysql_fetch_array($result);
            $sid = $new["sid"];
            
            echo "<form action='#' method='post'>";
            echo "Roll Number:<font color='blue'>".$srno."</font><br><br>";
            $imgid = $new["imgid"];
            $image=mysql_query("select * from MIMGT where imgid='$imgid'");
            $img=mysql_fetch_array($image);
            $imguri=$img[1];
            echo "<img src='../".$imguri."' width='150' height='150' class='imgshadow'></img><br /><br />";
    	
        
            
            echo "<input type='hidden' value='".$sid."' name='sid' />";
            echo "<table cellspacing='30'>";
            echo "<td>Username:</td><td><input type='text' name='uname' onkeyup='check(this.value)' required=true></input></td><td><div id='avail'></div></td></tr>";
            echo "<td>Password</td><td><input type='password' name='pass' required=true></input></td></table>";
            echo "<div id='iavail'>";
            echo "</div>";
            echo "</form>";
        }
        
    }
    if(isset($_POST['phase2']))
    {
        $sid=$_POST["sid"];
        $uname = $_POST["uname"];
        $pass = $_POST["pass"];
        createStudentUser($sid,$uname,$pass);
        xDebug($sid.$uname.$pass);
        notify("User Created Succesfully!");
        
    }
?>
    </center>
</fieldset>