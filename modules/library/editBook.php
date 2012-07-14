<html>
    <head>
        <link rel="stylesheet" href="../modules/library/libStyle.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../modules/library/css/bootstrap1.css" type="text/css" media="screen" />
        <script type="text/javascript">
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
	    if (branch=="-1" && reg=="-1")
	    {
		document.getElementById("txtHint"+j).innerHTML="Note: Please select Branch and regulation to select a subject.";
		return;
	    }
            else if (branch!="-1" && reg=="-1")
	    {
		document.getElementById("txtHint"+j).innerHTML="Note: Please select Branch and regulation to select a subject.";
		return;
	    }
            else if (branch=="-1" && reg!="-1")
	    {
		document.getElementById("txtHint"+j).innerHTML="Note: Please select Branch and regulation to select a subject.";
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
    function search(s)
    {
	    if (s=="")
	    {
		document.getElementById("txtHint1").innerHTML="<center><br><br><h6>Note : Books will be shown here</h6></center>";
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
		if (xmlhttp.readyState==4 & xmlhttp.status==200)
		{
		    document.getElementById("txtHint1").innerHTML=xmlhttp.responseText;
		}
	    }
	    xmlhttp.open("GET","../modules/library/ebNext.php?s="+s,true);
	    xmlhttp.send();
	}


</script>
    </head>
<body>
   
    <center>
            <?php
            if(!isset($_POST['phase1']) && !isset($_POST['phase2']))
            {
            echo "<fieldset>";
            echo "<legend>Search Books to Edit</legend>";
            echo "<form action='#' method='post'>";
            echo "<b>Search Books</b><br><br><input type='text' name='s' autocomplete='off' onkeyup='search(this.value)'>";
            echo "</form>";
            echo "</fieldset>";
            echo "<form action='#' method='post'>";
            echo "<br><br><div id='txtHint1'><h6>Note : Books Will be shown here</h6></div>";
               echo "</form>";
            }
            
    if(isset($_POST['phase1']) && !isset($_POST['phase2']))
    {
        include("../lib/connection.php");
        echo "<fieldset>";
            echo "<legend>Edit Books</legend>";
        $lid=$_POST['lid'];
        $doc=mysql_query("select * from MLIBRARYT where lid='$lid'");
        $book=mysql_fetch_array($doc);
        $bookid=$book['bookid'];
        $bname=$book['bname'];
        $bauthor=$book['bauthor'];
        $pub=$book['bpub'];
        $bedition=$book['bedition'];
        $ncps=$book['ncps'];
        $imgid=$book['imgid'];
        $img=mysql_query("select * from MIMGT where imgid='$imgid'");
        $image=mysql_fetch_array($img);
        $imguri=$image['imguri'];
        if($imguri!=NULL)
        echo "<div class='imgteaser' style='border:1px'><a href='../modules/library/changeLibPic.php?lid=$lid&KeepThis=true&TB_iframe=true&#TB_inline?width=300&height=200' title='Change Picture' class='thickbox'><img src='../$imguri' width='130' /><span class='epimg'>&raquo; Change Picture</span><span class='desc' class='strong'>Click to change the picture
	</span></a></div>";
        else
         echo "<div class='imgteaser' style='border:1px'><a href='../modules/library/changeLibPic.php?lid=$lid&KeepThis=true&TB_iframe=true&#TB_inline?width=300&height=200' title='Change Picture' class='thickbox'>Add a cover page<span class='epimg'>&raquo; Change Picture</span><span class='desc' class='strong'>Click to change the picture
	</span></a></div>";
        echo "<div class='mainpos'>";
        echo "<form action='#' method='post'>";
        echo "<input type='hidden' name='lid' value='$lid'>";
        echo "Book ID:<input type='text' name='bookid' value='$bookid' required='true'>&nbsp&nbsp";
        echo "Book Name:<input type='text' name='bname' value='$bname' required='true'>&nbsp&nbsp";
        echo "Author:<input type='text' name='author' value='$bauthor' required='true'><br><br><br>";
	echo "Publication:<input type='text' name='pub' value='$pub' required='true'>&nbsp&nbsp";
	echo "Edition:<input type='text' name='edition' value ='$bedition' required='true'>&nbsp&nbsp";
	echo "&nbspNo. of copies:<input type='number' name='cp' value='$ncps' required='true' style='width:50px;'><br><br><br>";
         echo "<br>Number of subject to be linked:<select name='snumber' onchange='subSelect(this.value)'>";
          for($i=0;$i<11;$i++)
		echo "<option value='$i'>$i</option>";
	    echo "</select>";
        echo "<div id='sublist'></div>";
        echo "<br><br><br><input type='submit' name='phase2' value='Update'>";
        echo "</div>";
        
    }
    if(isset($_POST['phase2']))
    {
        include("../lib/connection.php");
        $snum=$_POST['snumber'];
        $lid=$_POST['lid'];
        $reg=$_POST['reg'];
        $branch=$_POST['branch'];
        $bookid=$_POST['bookid'];
        $bname=$_POST['bname'];
        $bauthor=$_POST['author'];
        $pub=$_POST['pub'];
        $bedition=$_POST['edition'];
        $bookname=$_POST['bookname'];
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
        $subject_id=mysql_query("select * from SAVAILT where brid='$branch' and regid='$reg'");
        $su_id=mysql_fetch_array($subject_id);
        $suid=$su_id['subid'];
        $book_id=mysql_query("select * from MSUBJECTT where suid='$suid' and subname='$bookname'");
        $book_name=mysql_fetch_array($book_id);
        $subid=$book_name['subid'];
        $ncps=$_POST['cp'];
        if($ncps<0)
        {
            notifyerr("Number of copies cannot be negative. Please try again");
            redirect('?m=lib_editbook');
        }
        else
        {
            mysql_query("update MLIBRARYT set subid='$subjectids',bookid='$bookid',bname='$bname',bauthor='$bauthor',bpub='$pub',bedition='$bedition',ncps='$ncps' where lid='$lid'");
            notify("Updated Successfully");
            redirect('?m=lib_editbook');
        }
    }
    echo "</fieldset>";
    ?>
    </center> 
</body>
</html>