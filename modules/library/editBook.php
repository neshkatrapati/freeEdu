<html>
    <head>
        <style type='text/css'>
.imgteaser {
	margin: 0;
	overflow: hidden;
	float: left;
	position: absolute;
}
.imgteaser a {
	text-decoration: none;
	float: left;
}
.imgteaser a:hover {
	cursor: pointer;
}
.imgteaser a img {
	float: left;
	margin: 0;
	border: none;
	padding: 10px;
	background: #fff;
	border: 1px solid #ddd;
}
.imgteaser a .desc {	display: none; }
.imgteaser a:hover .epimg { visibility: hidden;}
.imgteaser a .epimg {
	position: absolute;
	right: 10px;
	top: 10px;
	font-size: 12px;
	color: #fff;
	background: #000;
	padding: 4px 10px;
	filter:alpha(opacity=65);
	opacity:.65;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=65)";
	
}
.imgteaser a:hover .desc{
	display: block;
	font-size: 11px;
	padding: 10px 0;
	background: #111;
	filter:alpha(opacity=75);
	opacity:.75;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=75)";
	color: #fff;
	position: absolute;
	bottom: 11px;
	left: 11px;
	padding: 4px 10px;
	margin: 0;
	width: 125px;
	border-top: 1px solid #999;
	
}
table
{
    text-align:center;
}
div.mainpos
{
    right:200px;
}
        </style>
    </head>
<body>
   
    <center>
            <?php
            include('library_lib.php');
            echo "<fieldset>";
            echo "<legend>Edit Books</legend>";
            include("../lib/connection.php");
            if(!isset($_POST['phase1']) && !isset($_POST['phase2']))
            {
               echo "<table border=1 cellpadding=10>
               <tr>
                <th>&nbsp</th>
                <th>Cover Page<br>(if given previously)</th>
                <th>Book Id</th>
                <th>Book Name</th>
                <th>Author</th>
                <th>Publications</th>
                <th>Edition</th>
                <th>Branch</th>
                <th>Regulation</th>
                <th>Year</th>
                <th>Number<br>of Copies</th>
               </tr>
            <form action='#' method='post'>";
            $bk=mysql_query("select * from MLIBRARYT");
            while($b=mysql_fetch_array($bk))
            {
                $lid=$b['lid'];
                $bid=$b['bookid'];
                $bname=$b['bname'];
                $bauthor=$b['bauthor'];
                $pub=$b['bpub'];
                $reg=$b['breg'];
                $edition=$b['bedition'];
                $brid=$b['brid'];
                $year=$b['akyr'];
                $ncps=$b['ncps'];
                $imgid=$b['imgid'];
                $lid=$b['lid'];
                $img=mysql_query("select * from MIMGT where imgid='$imgid'");
                $image=mysql_fetch_array($img);
                $imguri=$image['imguri'];
                echo "<form action='#' method='post'>";
                echo "<tr><td><input type='radio' name='lid' value='$lid'></td>";
                echo "<td><img src='../$imguri' width='100'></td>";
                echo "<td>$bid</td>";
                echo "<td>$bname</td>";
                echo "<td>$bauthor</td>";
                echo "<td>$pub</td>";
                echo "<td>$edition</td>";
                echo "<td>".getBranch($brid)."</td>";
                echo "<td>".getReg($reg)."</td>";
                echo "<td>".getYear($year)."</td>";
                echo "<td>$ncps</td>";
                echo "</tr>";
            }
            
    echo "</table><br>
    <input type='submit' name='phase1' value='Edit'>
    </form>";
    }
    if(isset($_POST['phase1']) && !isset($_POST['phase2']))
    {
        include("../lib/connection.php");
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
        echo "<div class='imgteaser' style='border:1px'><a href='../modules/library/changeLibPic.php?lid=$lid&KeepThis=true&TB_iframe=true&#TB_inline?width=300&height=200' title='Change Picture' class='thickbox'><img src='../$imguri' width='130' /><span class='epimg'>&raquo; Change Picture</span><span class='desc' class='strong'>Click to change the picture
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
            echo "&nbspRegulation:";
	    $reg=getRegulations();
	    $rlen=count($reg);
	    include("../lib/connection.php");
	    echo "<select name='reg'>";
	    for($i=0;$i<$rlen;$i++)
	    {
		$r=mysql_query("select * from MREGT where regname='$reg[$i]'") or die(mysql_error());
		$rg=mysql_fetch_array($r);
		$regid=$rg['regid'];
		echo "<option value='$regid'>$reg[$i]</option>";
	    }
	    echo "</select>";
        echo "<br><br><br><input type='submit' name='phase2' value='Update'>";
        echo "</div>";
        
    }
    if(isset($_POST['phase2']))
    {
        include("../lib/connection.php");
        $lid=$_POST['lid'];
        $reg=$_POST['reg'];
        $year=$_POST['year'];
        $branch=$_POST['branch'];
        $bookid=$_POST['bookid'];
        $bname=$_POST['bname'];
        $bauthor=$_POST['author'];
        $pub=$_POST['pub'];
        $bedition=$_POST['edition'];
        $ncps=$_POST['cp'];
        if($ncps<0)
        {
            notifyerr("Number of copies cannot be negative. Please try again");
            redirect('?m=eb');
        }
        else
        {
            mysql_query("update MLIBRARYT set akyr='$year',brid='$branch',breg='$reg',bookid='$bookid',bname='$bname',bauthor='$bauthor',bpub='$pub',bedition='$bedition',ncps='$ncps' where lid='$lid'");
            notify("Updated Successfully");
            redirect('?');
        }
    }
    echo "</fieldset>";
    ?>
    </center> 
    
</body>
</html>