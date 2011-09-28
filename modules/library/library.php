<html>
    <head>
	<script type="text/javascript">
	function showUser(str)
	{
	    if (str=="")
	    {
		document.getElementById("txtHint").innerHTML="";
		return;
	    } 
	    if (window.XMLHttpRequest)
	    {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	    }
	    else
	    {// code for IE6, IE5
	      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	    }
	    xmlhttp.onreadystatechange=function()
	    {
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		}
	    }
	    xmlhttp.open("GET","../modules/library/libNext.php?link="+str,true);
	    xmlhttp.send();
	}        
	</script>
    </head>
    <body>
        <?php
	if(!(isset($_POST['phase1'])))
        {
	    echo "<center>";
            echo "<fieldset>";
            echo "<legend>Add-an-EBook</legend>";
            echo "<form action='#' method='post' enctype='multipart/form-data'>";
            echo "Upload E-Book:(pdf or doc):<input type='file' name='file' required='true'><br><br>";
	    echo "Upload Cover Page:(jpg or png or gif):<input type='file' name='img'><br><br>";
	    echo "Book Name:<input type='text' name='book' required='true'>&nbsp&nbsp";
	    echo "Author:<input type='text' name='author' required='true'><br><br>";
            echo "Linking to Existing Book:<select name='link' onchange='showUser(this.value)'>";
	    echo "<option value='dln'>Dont Link</option>";
	    echo "<option value='ln'>Link to Existing Book</option>";
	    echo "</select>&nbsp<br>";
	    echo "<br><div id='txtHint'>Note : Books will be shown here.</div><br><br>";
	    echo "Select Branch:";
            $arr=getBranches();
	    $len=count($arr);
	    include("../lib/connection.php");
	    echo "<select name='branch'>";
	    for($i=0;$i<$len;$i++)
	    {
		$br=mysql_query("select brid from MBRANCHT where brname='$arr[$i]'") or die(mysql_error());
		$branch=mysql_fetch_array($br);
		$brid=$branch['brid'];
		echo "<option value='$brid'>$arr[$i]</option>";
	    }
	    echo "</select>&nbsp";
	    echo "Year:";
	    echo "</select>";
	    echo "<select name='year'>";
	    echo "<option value='0'>1st-Year</option>";
	    echo "<option value='1'>2nd-Year 1st-Sem</option>";
	    echo "<option value='2'>2nd-Year 2nd-Sem</option>";
	    echo "<option value='3'>3rd-Year 1st-Sem</option>";
	    echo "<option value='4'>3rd-Year 2nd-Sem</option>";
	    echo "<option value='5'>4th-Year 1st-Sem</option>";
	    echo "<option value='6'>4th-Year 2nd-Sem</option>";
	    echo "</select>";	
            echo "<br><br><br><input type='submit' name='phase1'>";
            echo "</form>";
            
        }
        if(isset($_POST[phase1]))
        {
	    include("../lib/connection.php");
	    $MAX_SIZE=1000;
	    $ebook=$_FILES['file']['name'];
	    $img=$_FILES['img']['name'];
	    $brid=$_POST['branch'];
	    $book=$_POST['book'];
	    $author=$_POST['author'];
	    $year=$_POST['year'];
	    $bk=$_POST['bk'];
	    $extension = getExtension($ebook);
	    $extension = strtolower($extension);
	    $ext=strtolower(getExtension($img));
	    if (($ext== "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "gif")) 
	    {
		$size=$_FILES["img"]["size"];
		if ($size > $MAX_SIZE*1024)
		{	
		    notifyerr('You have exceeded the Image size limit! Please try Again');
		    redirect('?m=lib');
		}
		$image_name=time().'.'.$ext;
		$newname="../images/others/".$image_name;
		$imguri="images/others/".$image_name;
		$copied = copy($_FILES['img']['tmp_name'], $newname);
		if($copied)
		{
		   
		
		    if($extension=='pdf' || $extension=='doc')
		    {
			include("../lib/connection.php");
		        //uploading into database
		        $fname=time().'.'.$extension;
		        $newname="../ebooks/".$fname;
		        $eburi="ebooks/".$fname;
		        $copied = copy($_FILES['file']['tmp_name'], $newname);
		        if (!$copied)
		        {
		            echo '<h2>Copy unsuccessfull!</h2>';
		        }
		        else
		        {
		    	$imgnum=mysql_query("select * from MIMGT");
		    	$imgid=mysql_num_rows($imgnum);
		    	mysql_query("insert into MIMGT values('$imgid','$imguri')");
		        $eb=mysql_query("select * from MDOCT")or die(mysql_error()) ;
		       	$num=mysql_num_rows($eb);
			mysql_query("insert into MDOCT values('$num','$book','$author','$brid','$year','$eburi','$imgid','$bk')");
			notify('Copy Successfull!');
			redirect('?');
		        }
		    }
		    else
		    {
		        notifyerr("Invalid Extension Try Again");
		        redirect('?m=lib');
		    }
		}
	    }
	    else if(($ext != "jpg") && ($ext != "jpeg") && ($ext != "png") && ($ext != "gif")) 
	    {
		notifyerr("Inavlid Image Extension. Try Again");
		redirect('?');
		
	    }
	    
        }
	echo "</fieldset>";
        echo "</center>";
        ?>
    </body>
</html>