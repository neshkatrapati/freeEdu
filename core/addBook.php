<html>
    <head>
    </head>
    <body>
        <?php
	if(!(isset($_POST['phase1'])))
        {
	    
            echo "<center>";
            echo "<fieldset>";
            echo "<legend>Add-an-EBook</legend>";
            echo "<form action='#' method='post' enctype='multipart/form-data'>";
            echo "Cover Page:(jpg or png or gif):<input type='file' name='img'><br><br><br>";
	    echo "Book ID:<input type='text' name='bookid' required='true'>&nbsp&nbsp";
            echo "Book Name:<input type='text' name='book' required='true'>&nbsp&nbsp";
            echo "Author:<input type='text' name='author' required='true'><br><br>";
	    echo "<br>Select Branch:";
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
	    $img=$_FILES['img']['name'];
	    $bookid=$_POST['bookid'];
	    $brid=$_POST['branch'];
	    $book=$_POST['book'];
	    $author=$_POST['author'];
	    $year=$_POST['year'];
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
		    $imgnum=mysql_query("select * from MIMGT");
		    $imgid=mysql_num_rows($imgnum);
		    mysql_query("insert into MIMGT values('$imgid','$imguri')"); 
		    $b=mysql_query("select * from MLIBRARYT")or die(mysql_error()) ;
		    $num=mysql_num_rows($b);
		    xDebug($num);
		    mysql_query("insert into MLIBRARYT values('$num','$bookid','$book','$author','$brid','$year','$imgid')");
		    notify('Copy Successfull!');
		    redirect('?');
		}
		else
		{
		    notifyerr("Problem in copying the Image Try again");
		    redirect('?m=ab');
		}
	    }
	}
	?>
    </body>
</html>