<html>
    <head>
		<?php echo "<script src='../aux/bootstrap/js/bootstrap.js' type='text/javascript'></script>"; ?>
	<link rel="stylesheet" href="../modules/library/css/bootstrap1.css" type="text/css" media="screen" />
	<script type="text/javascript" src="../modules/library/js/bootstrap-alert.js"></script>
	<script type="text/javascript">
	$('.typeahead').typeahead();
	
	function subSelect(snum)
	{
	    if(snum==0)
	    {
		document.getElementById("sublist").innerHTML="";
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
		    document.getElementById("sublist").innerHTML=xmlhttp.responseText;
		}
	    }
	    xmlhttp.open("GET","../modules/library/numsub.php?snum="+snum,true);
	    xmlhttp.send();
	}
	function showUser(branch,reg,j)
	{
	    if(branch=="-1" && reg=="-1")
	    {
		document.getElementById("txtHint"+j).innerHTML="Note:Select branch and Regulation to add a subject";
		return;
	    }
		
	    
	    else if(branch!="-1" && reg=="-1")
	    {
		document.getElementById("txtHint"+j).innerHTML="Note:Select branch and Regulation to add a subject";
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
		    document.getElementById("txtHint"+j).innerHTML=xmlhttp.responseText;
		}
	    }
	    xmlhttp.open("GET","../modules/library/addNext.php?branch="+branch+"&reg="+reg+"&j="+j,true);
	    xmlhttp.send();
	}
	
    </script>
    </head>
    <body>
	<?php
	if(!(isset($_POST['phase1'])))
        {
	    include_once("../lib/connection.php");
	    include_once("../lib/lib.php");
	    include_once("../modules/library/library_lib.php");
	    echo "<center>";
            echo "<fieldset>";
            echo "<legend>Add-a-New-Book</legend>";
            echo "<form action='#' method='post' name='f1' enctype='multipart/form-data'>";
            echo "Cover Page:(jpg or png or gif):<input type='file' name='img'><br><br><br>";
	    echo "Book ID:<input type='text' name='bookid' required='true'>&nbsp&nbsp";
            echo "Book Name:<input type='text' name='book' required='true'>&nbsp&nbsp";
            echo "Author:<input type='text' name='author' required='true'>&nbsp&nbsp";
	    echo "Publication:<input type='text' name='pub' required='true'><br><br><br>";
	    echo "Edition:<input type='text' name='edition' required='true'>&nbsp&nbsp";
	    echo "&nbspNo. of copies:<input type='number' name='cp' value='1' style='width:50px;'><br><br><br>";
	    echo "Note: Ignore it if there is no link to the book or Branch and Regualtion both must be selected to link a book to a subject<br><br>";
	    echo "<br>Number of subject to be linked:<select name='snumber' onchange='subSelect(this.value)'>";
	    for($i=0;$i<11;$i++)
		echo "<option value='$i'>$i</option>";
	    echo "</select>";
	    echo "<div id='sublist'></div>";
	    echo "<div id='submit'><br><br><br><input type='submit' name='phase1'></div>";
            echo "</form>"; 
        }
	if(isset($_POST[phase1]))
        {
	    include_once("../lib/connection.php");
	    $MAX_SIZE=1000;
	    $snum=$_POST['snumber'];
	    $img=$_FILES['img']['name'];
	    $bookid=$_POST['bookid'];
	    $brid=$_POST['branch'];
	    $book=$_POST['book'];
	    $author=$_POST['author'];
	    $bpub=$_POST['pub'];
	    $ncps=$_POST['cp'];
	    $edition=$_POST['edition'];
	    
	    $bidcheck=mysql_query("select * from MLIBRARYT where bookid='$bookid'");
	    $bidchecknum=mysql_num_rows($bidcheck);
	    if($bidchecknum==0)
	    {
	    for($k=0;$k<$snum;$k++)
	    {
		$reg=$_POST['reg'.$k];
		$branch=$_POST['branch'.$k];
		if($reg!=-1 && $branch!=-1)
                {
		    $bookname=$_POST['bookname'.$k];
		    $subj=mysql_query("select * from SAVAILT where regid='$reg' and brid='$branch'");
		    $subject=mysql_fetch_array($subj);
		    $subid[$k]=$subject['subid'];
		    $subjectid=mysql_query("select * from MSUBJECTT where suid='$subid[$k]' and subname='$bookname'");
		    $subnameid=mysql_fetch_array($subjectid);
		    if(!in_array($subnameid['subid'],$suid))
		        $suid[]=$subnameid['subid'];
		}
	    }
	    $subjectids=implode(';',$suid);
	    $b=mysql_query("select * from MLIBRARYT")or die(mysql_error()) ;
	    $num=mysql_num_rows($b);
	    $extension = getExtension($ebook);
	    $extension = strtolower($extension);
	    $ext=strtolower(getExtension($img));
	    $obj=mysql_query("select * from MOBJECTT");
	    $onum=mysql_num_rows($obj);
	    if (($ext== "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "gif")) 
	    {
		$size=$_FILES["img"]["size"];
		if ($size > $MAX_SIZE*1024)
		{	
		    notifyerr('You have exceeded the Image size limit! Please try Again');
		    redirect('?m=lib');
		}
		else
		{
		    $image_name=time().'.'.$ext;
		    $newname="../images/others/".$image_name;
		    $imguri="images/others/".$image_name;
		    $copied = copy($_FILES['img']['tmp_name'], $newname);
		    if($copied)
		    {
		        $imgnum=mysql_query("select * from MIMGT");
		        $imgid=mysql_num_rows($imgnum);
		        mysql_query("insert into MIMGT values('$imgid','$imguri')"); 
		        mysql_query("insert into MLIBRARYT values('$num','$bookid','$book','$author','$bpub','$edition','$imgid','$ncps','$subjectids')");
			mysql_query("insert into MOBJECTT values('$onum','$book','$num','8','$imgid','','','')");
		        notify('Book Added Succesfully Successfull!');
		        redirect('?m=add_book');
		    }
		    else
		    {
		        notifyerr("Problem in copying the Image Try again");
		        redirect('?m=add_book');
		    }
		}
	    }
	    else if($img==NULL)
	    {
		mysql_query("insert into MLIBRARYT values('$num','$bookid','$book','$author','$bpub','$edition','','$ncps','$subjectids')");
		mysql_query("insert into MOBJECTT values('$onum','$book','$num','8','','','','')");
		notify('Book Added Succesfully Successfull!');
		redirect('?m=add_book');
	    }
	}
	
	else if($bidchecknum!=0){
	   notifywar("Book Id already exists. Please check once again and enter the Details.");
	redirect('?m=add_book');
		
	}
	}
	?>
	
    </body>
</html>
