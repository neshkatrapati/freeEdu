<html>
<head>
<script type='text/javascript'>
    
    function doPut()
    {
	
	var el1  = document.getElementById("srno");
	var el2  = document.getElementById("slogin");
	var el3  = document.getElementById("spass");
	//el1.value = el1.value.toUpperCase();
	el2.value = el1.value;
	el3.value = el1.value;
	
    }
    
</script>
</head>
<body>
    <?php
        echo "<form name='al' method='post' enctype='multipart/form-data' action='#'>";
        $placeBranch = "";
	$placeBranch = getBatches('bat[]');
        echo "<table cellpadding=10>";
        echo "<tr><td colspan=2 style='text-align:center;'style='text-align:center;'>Upload Image:&nbsp;<input type='file' name='image'></td></tr>";
        echo "<tr><td colspan=2 style='text-align:center;font-size:13; '>Note: Image size should not exceed 1MB.</td></tr>";
        echo "<tr><td colspan=2 style='text-align:center;'>Roll Number:&nbsp;<input type='text' name='srno' required=true id='srno' onkeyup='doPut()'</td></tr>";
        echo "<tr><td>First Name:&nbsp;<input type='text' name='fn' required=true></td>";
        echo "<td>Last(Family) Name:&nbsp;<input type='text' name='ln' required=true></td></tr>";
        echo "<tr><td>Slogin:&nbsp;<input type='text' name='slogin' required=true id='slogin'></td>";
        echo "<td>Spassword:&nbsp;<input type='password' name='spswd' required=true id='spass'></td>";
	echo "<tr><td>Select A Batch:&nbsp;".$placeBranch."</td>";
        echo  "<td>Section:&nbsp;<input type='text' size='1px' name='sec' required=true></td>";
        echo "<tr><td colspan=2 style='text-align:center;'>Student Info:<br><textarea name='sinfo' rows='5' cols='10'></textarea></td></tr>";
        echo "<tr><td colspan=2 style='text-align:center;'><input type='submit' name='submit' value='Submit'/></td></tr>";
        echo "</table>";
        echo "</form>";
        $MAX_SIZE=1000; 
        $errors=1;
    	if(isset($_POST['submit']))
	   {
                
                $bat=$_POST['bat'][0];
                $srno=$_POST['srno'];
                $fn=$_POST['fn'];
                $ln=$_POST['ln'];
                $sec=$_POST['sec'];
                $slogin=$_POST['slogin'];
                $spswd=$_POST['spswd'];
                $sinfo=$_POST['sinfo'];
		$array=explode(':',$bat);
		$brid=$array[0];
		$batyr=$array[1];
                $sno=strtoupper($srno);
                $stu=mysql_query("select * from MSTUDENTT where srno='$srno'");
                $nums=mysql_num_rows($stu);
                //echo "<script type='text/javascript'>alert('$nums');</script>";
                if($nums==0)
                {  
                    $bat=mysql_query("select * from MBATCHT where brid='$brid' and batyr='$batyr'");
                    $batch=mysql_fetch_array($bat);
                    $batid=$batch['batid'];
                   
                    $image=$_FILES['image']['name'];
                    if($image!=NULL) 
                    {
                            $filename = stripslashes($_FILES['image']['name']);
                            $extension = getExtension($filename);
                            $extension = strtolower($extension);
                            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
                            {
                            	notifyerr('Unknown extension!');
                            	$errors=1;
                            }
                            else
                            {
                            	$size=filesize($_FILES['image']['tmp_name']);
                            	if ($size > $MAX_SIZE*1024)
                        	{	
                                    notifyerr('You have exceeded the size limit!');
                                    $errors=1;
                                    break;
                                }
                                 $img=mysql_query("select * from MIMGT");
                                $num=mysql_num_rows($img);
                                $image_name= time().'.'.$extension;
                                $newname="../images/faces/".$image_name;
                                $imguri="images/faces/".$image_name;
                                $copied = copy($_FILES['image']['tmp_name'], $newname);
                                if (!$copied)
                                {
                                   	$errors=1;
                                        notifyerr('You have Not copied!');
                                        
                                }
                                else
                                {
                                	$errors=0;
                                        //echo "<script type='text/javascript'>alert(' copied $errors ');</script>";
                                }
                            }       
                    } 
                    if(isset($_POST['submit']) && !$errors) 
                    {
                        
                       echo "<script type='text/javascript'>alert('$num');</script>";
                       echo "<script type='text/javascript'>alert('helloBoy');</script>";
                        $img=mysql_query("select * from MIMGT");
                        $num=mysql_num_rows($img);
                        mysql_query("insert into MIMGT values('$num','$imguri')");
                       // echo "<script type='text/javascript'>alert('$num');</script>";
                        
                    }
                
                    $snum=mysql_query("select * from MSTUDENTT");
                    $stot=mysql_num_rows($snum);
                    mysql_query("insert into MSTUDENTT values('$stot','$srno','$fn $ln','','$sinfo','$num','$batid','$sec','','0')");
                    $onum=mysql_query("select * from MOBJECTT");
                    $otot=mysql_num_rows($onum);
                    mysql_query("insert into MOBJECTT values('$otot','$fn $ln','$stot','0','$num','$slogin','$spswd','')");
                    
                    
                }
                else
                {
                    notifyerr("Roll Number Already Exists.");
                    
                }
                
           }       
      
    ?>
</body>
</html>