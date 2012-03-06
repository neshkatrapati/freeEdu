<html>
    <head>
		<link rel="stylesheet" href="../modules/library/css/bootstrap1.css" type="text/css" media="screen" />
	 <link rel="stylesheet" href="../modules/library/libStyle.css" type="text/css" media="screen" />
	<script type="text/javascript">
	$('.typeahead').typeahead();
	function showUser(str)
	{
	    if(str=="")
	    {
		document.getElementById("txtHint").innerHTML="";
		document.getElementById("remove").innerHTML="";
		return;
	    }
	    else if(str=="-1")
	    {
		document.getElementById("txtHint").innerHTML="Note: Select an option to link a Book.";
		document.getElementById("submit").innerHTML="<br><input type='submit' name='phase1'>";
		
	    }
	    else if(str=='ln')
	    {
		document.getElementById("submit").innerHTML="<br><input type='submit' name='phase1'>";
	    }
	    else if(str=='dln')
	    {
		document.getElementById("submit").innerHTML="";
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
	function newsub(branch,reg)
	{
	    if(branch!=-1 && reg!=-1)
	    {
		document.getElementById("submit").innerHTML="<br><input type='submit' name='phase1'>";
	    }
	    if(branch==-1 || reg==-1)
	    {
		document.getElementById("submit").innerHTML="";
	    }
	}
	</script>
    </head>
    <body>
        <?php
	if(!(isset($_POST['phase1'])))
        {
	    require_once("../lib/connection.php");
	    echo "<center>";
            echo "<fieldset>";
            echo "<legend>Add-an-EBook</legend>";
            echo "<form action='#' method='post' enctype='multipart/form-data'>";
            echo "Upload E-Book:(pdf or doc):<input type='file' name='file' required='true'><br><br>";
	    echo "Upload Cover Page:(jpg or png or gif):<input type='file' name='img'><br><br>";
	    echo "Book Name:<input type='text' name='book' required='true'>&nbsp&nbsp";
	    echo "Author:<input type='text' name='author' required='true'>&nbsp";
	    echo "Publication:<input type='text' name='pub' required='true'>&nbsp";
	    echo "Edition:<input type='text' name='edition' required='true'>&nbsp<br><br><br>";
            echo "Linking to Existing Book:<select name='link' onchange='showUser(this.value)'>";
	    echo "<option value='-1'>Generic Book</option>";
	    echo "<option value='dln'>Dont Link</option>";
	    echo "<option value='ln'>Link to Existing Book</option>";
	    echo "</select>&nbsp<br>";
	    echo "<br><br><div id='txtHint'>Note : Books will be shown here.</div><br><br>";
            echo "<div id='submit'><input type='submit' name='phase1'></div>";
            echo "</form>";
        }
	if(isset($_POST['phase1']))
        {
	    require_once("../lib/connection.php");
	    $check=0;
	    $MAX_SIZE=1000;
	    $ebook=$_FILES['file']['name'];
	    $img=$_FILES['img']['name'];
	    $book=$_POST['book'];
	    $author=$_POST['author'];
	    $bpub=$_POST['pub'];
	    $edition=$_POST['edition'];
	    $link=$_POST['link'];
	    if($link==-1)
	    {
		$brid=-1;
		$reg=-1;
		$bkl='';
	    }
	    else if($link=='dln')
	    {
		$brid=$_POST['branch'];
		$reg=$_POST['reg'];
		$bkl=-1;
	    }
	    else if($link=='ln')
	    {
		$bk=$_POST['bookname'];
		$barr=explode('/ ',$bk);
		$bkl=$barr[2];
	    }
	    $obj=mysql_query("select * from MOBJECTT");
	    $onum=mysql_num_rows($obj);
	    $extension = getExtension($ebook);
	    $extension = strtolower($extension);
	    if($img==NULL)
	    {
		$check=1;
	    }
	    else
	    {
		$ext=strtolower(getExtension($img));
		if (($ext== "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "gif")) 
		{
		    $size=$_FILES["img"]["size"];
		    if ($size > $MAX_SIZE*1024)
		    {	
		        notifyerr('You have exceeded the Image size limit! Please try Again');
			redirect('?m=lib_ebookcreate');
			break;
		        
		    }
		    $image_name=time().'.'.$ext;
		    $newname="../images/others/".$image_name;
		    $imguri="images/others/".$image_name;
		    $copied = copy($_FILES['img']['tmp_name'], $newname);
		    if($copied)
		    {
		       notify("Image Copied Successfully");
		        }
		
		}
	        else if(($ext != "jpg") && ($ext != "jpeg") && ($ext != "png") && ($ext != "gif")) 
		{
		    notifyerr("Inavlid Image Extension. Try Again");
		    redirect('?');
		    
		}
	    }
	    if($extension=='pdf' || $extension=='doc')
	    {
		require_once("../lib/connection.php");
		//uploading into database
		$fname=time().'.'.$extension;
		$newname="../doc/ebooks/".$fname;
		$eburi="doc/ebooks/".$fname;
		$copied = copy($_FILES['file']['tmp_name'], $newname);
		if (!$copied)
		{ 
		    notifyerr('DOC Copy unsuccessfull!');
		}
		else
		{
		    $imgnum=mysql_query("select * from MIMGT");
		    $imgid=mysql_num_rows($imgnum);
		    mysql_query("insert into MIMGT values('$imgid','$imguri')");
		    $eb=mysql_query("select * from MDOCT")or die(mysql_error()) ;
		    $num=mysql_num_rows($eb);
		    if($check==0)
		    {
			mysql_query("insert into MDOCT values('$num','$book','$author','$bpub','$edition','$brid','$reg','$eburi','$imgid','$bkl')");
			mysql_query("insert into MOBJECTT values('$onum','$book','$num','9','$imgid','','','')");
		    }
		    else
		    {
			mysql_query("insert into MDOCT values('$num','$book','$author','$bpub','$edition','$brid','$reg','$eburi','','$bkl')");
			mysql_query("insert into MOBJECTT values('$onum','$book','$num','9','','','','')");
		    }
		    notify('Ebook Added Successfull!');
		    redirect('?m=lib_ebookcreate');
		}
	    }
		    else
		    {
		        notifyerr("Invalid Extension Try Again");
		        redirect('?m=lib_ebookcreate');
		    }
	    
        }
	
	echo "</fieldset>";
        echo "</center>";
        ?>
    </body>
</html>
