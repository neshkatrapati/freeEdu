<html>
    <head>
       <link rel="stylesheet" href="../modules/library/libStyle.css" type="text/css" media="screen" />
       <script type="text/javascript">
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
		document.getElementById("submit").innerHTML="<br><input type='submit' value='Update' name='phase2'>";
		
	    }
	    else if(str=='ln')
	    {
		document.getElementById("submit").innerHTML="<br><input type='submit' value='Update' name='phase2'>";
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
		document.getElementById("submit").innerHTML="<br><input type='submit' value='Update' name='phase2'>";
	    }
	    if(branch==-1 || reg==-1)
	    {
		document.getElementById("submit").innerHTML="";
	    }
	}
        function search(s)
          {
	    if (s=="")
	    {
		document.getElementById("txtHint1").innerHTML="<center><br><br><h6>Note: E-Books will be shown here</h6></center>";
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
	    xmlhttp.open("GET","../modules/library/eebNext.php?s="+s,true);
	    xmlhttp.send();
	}
	</script>
    </head>
    <body>
        <?php
        include_once("../modules/library/library_lib.php");
        include_once("../lib/connection.php");
        echo "<center>";
        if(!isset($_POST['phase1']) && !isset($_POST['phase2']))
        {
            echo "<fieldset>";
            echo "<legend>Search E-Books to Edit</legend>";
            echo "<form action='#' method='post'>";
            echo "<b>Search Books</b><br><br><input type='text' name='s' autocomplete='off' onkeyup='search(this.value)'>";
            echo "</form>";
            echo "</fieldset>";
            echo "<form action='#' method='post'>";
            echo "<br><br><div id='txtHint1'><h6>Note : E-Books Will be shown here</h6></div>";
            echo "</form>";
        }
        if(isset($_POST['phase1'])&& !isset($_POST['phase2']) && $_POST['did']!=NULL)
        {
            echo "<fieldset>";
            echo "<legend>Edit Ebooks</legend>";
            notifywar("Please check the branch year and linking before you Update");
            $did=$_POST['did'];
            $doc=mysql_query("select * from MDOCT where did='$did'");
            $d=mysql_fetch_array($doc);
            $docname=$d['docname'];
            $docauthor=$d['docauthor'];
            $pub=$d['docpub'];
            $ebedition=$d['edition'];
            $dbrid=$d['brid'];
            $dlid=$d['lid'];
            $imgid=$d['docimg'];
            $img=mysql_query("select * from MIMGT where imgid='$imgid'");
            $image=mysql_fetch_array($img);
            $imguri=$image['imguri'];
            echo "<div class='imgteaser' style='border:1px'><a href='../modules/library/changeEbookPic.php?did=$did&KeepThis=true&TB_iframe=true&#TB_inline?width=300&height=200' title='Change Picture' class='thickbox'><img src='../$imguri' width='130' /><span class='epimg'>&raquo; Change Picture</span><span class='desc' class='strong'>Click to change the picture
            </span></a></div>";
            echo "<form action='#' method='post'>";
            echo "<input type='hidden' name='did' value='$did'>";
            echo "Book Name:&nbsp<input type='text' name='ebname' value='$docname' required='true'>";
            echo "&nbsp&nbspAuthor:&nbsp<input type='text' name='ebauthor' value='$docauthor' required='true'><br><br><br>";
            echo "Publication:&nbsp<input type='text' name='ebpub' value='$pub' required='true'>";
            echo "&nbsp&nbspEdition:&nbsp<input type='text' name='ebedition' value ='$ebedition' required='true'><br>";
            echo "<br><br>Linking:<select name='link' onchange='showUser(this.value)'>";
            echo "<option value='-1'>Generic E-Book</option>";
            echo "<option value='dln'>Dont Link to Existing Books</option>";
            echo "<option value='ln'>Link to Existing Books</option>";
            echo "</select>&nbsp<br>";
	    echo "<br><br><div id='txtHint'>Note : Books will be shown here.</div><br>";
            echo "<div id='remove'>";
            echo "</div>";
            echo "</table>";
            echo "<br><br><div id='submit'><input type='submit' name='phase2' value='Update'></div>";
            echo "</form>";
        }
        else if(isset($_POST['phase1']))
        {
            notifyerr("!No Field Selected Try Again!");
            redirect("?m=edit_ebook");
        }
        if(isset($_POST['phase2']))
        {
            $did=$_POST['did'];
            $link=$_POST['link'];
            $bname=$_POST['ebname'];
            $bauthor=$_POST['ebauthor'];
            $pub=$_POST['ebpub'];
            $ebedition=$_POST['ebedition'];
            include_once("../lib/connection.php");
            if($link=='dln')
            {
                $branch=$_POST['branch'];
                $reg=$_POST['reg'];
                mysql_query("update MDOCT set lid='',brid='$branch',reg='$reg',docname='$bname',docauthor='$bauthor',docpub='$pub',edition='$ebedition' where did='$did'");
            }
            else if($link=='-1')
            {
                mysql_query("update MDOCT set lid='-1',brid='-1',reg='-1',docname='$bname',docauthor='$bauthor',docpub='$pub',edition='$ebedition' where did='$did'");
            }
            else if($link=='ln')
            {
                $bk=$_POST['bookname'];
		$barr=explode('/ ',$bk);
		$lid=$barr[2];
                mysql_query("update MDOCT set lid='$lid',brid='',reg='',docname='$bname',docauthor='$bauthor',docpub='$pub',edition='$ebedition' where did='$did'");
            }
            notify("Editing Succedfully Done");
            redirect('?m=lib_editebook');
        }
        ?>
    </body>
</html>