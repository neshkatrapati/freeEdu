<html>
    <head>
        <link rel="stylesheet" href="../modules/library/libStyle.css" type="text/css" media="screen" />
    </head>
    <body>
        <?php
        
        include("../modules/library/library_lib.php");
        include("../lib/connection.php");
        
        echo "<center>";
        
        if(!isset($_POST['phase1']) && !isset($_POST['phase2']))
        {
            echo "<h2>Edit Ebooks</h2><br>";
            include("alpha.php");
            echo "<br>";
            $n=$_GET['n'];
             if($n=='all')
            {
                $doc=mysql_query("select * from MDOCT");
            }
            else
                $doc=mysql_query("select * from MDOCT where docname like '$n%'");
        $num=mysql_num_rows($doc);
        if($num==0)
        {
            notifywar("No Ebook Starting with $n. Try Another Letter");   
        }
        else
        {
            echo "<form action='#' method='post'>";
            echo "<table border='5' cellpadding='6' cellspacing='15'>
            <tr>
                <th>&nbsp</th>
                <th>Cover Page<br>(if given uploaded)</th>
                <th>EBook Name</th>
                <th>Author</th>
                <th>Publications</th>
                <th>Edition</th>
                <th>Branch</th>
                <th>Regulation</th>
                <th>Year</th>
                <th>Linked Book</th>
            </tr>";
           
        while($d=mysql_fetch_array($doc))
        {
            echo "<tr>";
            $did=$d['did'];
            $docname=$d['docname'];
            $docauthor=$d['docauthor'];
            $brid=$d['brid'];
            $akyr=$d['akyr'];
            $reg=$d['reg'];
            $docpub=$d['docpub'];
            $docedition=$d['docedition'];
            $docimg=$d['docimg'];
            $lid=$d['lid'];
            $img=mysql_query("select * from MIMGT where imgid='$docimg'");
            $image=mysql_fetch_array($img);
            $imguri=$image['imguri'];
            echo "<td><input type='radio' name='did' value='$did' required='true'></td>";
            echo "<td><img src='../$imguri' width='75'></td>";
            echo "<td>$docname</td>";
            echo "<td>$docauthor</td>";
            echo "<td>$docpub</td>";
            echo "<td>$docedition</td>";
            echo "<td>".getBranch($brid)."</td>";
            echo "<td>".getReg($reg)."</td>";
            echo "<td>".getYear($akyr)."</td>";
            if($lid!=NULL)
            {
                $d1=mysql_query("select * from MLIBRARYT where lid='$lid'");
                $d2=mysql_fetch_array($d1);
                $bname=$d2['bname'];
                $bauthor=$d2['bauthor'];
                echo "<td>$bname-by-$bauthor</td>";
            }
            else{
                echo "<td>No Link</td>";
            }
            echo "</tr>";
        }
        echo "<table><br><br>";
        echo "<input type='submit' name='phase1' value='Edit'>";
        echo "</form>";
        }
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
            $ebedition=$d['docedition'];
            $dbrid=$d['brid'];
            $dlid=$d['lid'];
            $imgid=$d['docimg'];
            $img=mysql_query("select * from MIMGT where imgid='$imgid'");
            $image=mysql_fetch_array($img);
            $imguri=$image['imguri'];
            echo "<div class='imgteaser' style='border:1px'><a href='../modules/library/changeEbookPic.php?did=$did&KeepThis=true&TB_iframe=true&#TB_inline?width=300&height=200' title='Change Picture' class='thickbox'><img src='../$imguri' width='130' /><span class='epimg'>&raquo; Change Picture</span><span class='desc' class='strong'>Click to change the picture
            </span></a></div>";
            echo "<table cellpadding=5 align=center>";
            echo "<form action='#' method='post'>";
            echo "<input type='hidden' name='did' value='$did'>";
            echo "<tr><td>Book Name:</td><td><input type='text' name='ebname' value='$docname' required='true'></td>";
            echo "<td>Author:</td><td><input type='text' name='ebauthor' value='$docauthor' required='true'></td></tr>";
            echo "<tr><td>Publication:</td><td><br><input type='text' name='ebpub' value='$pub' required='true'></td>";
            echo "<td>Edition:</td><td><input type='text' name='ebedition' value ='$ebedition' required='true'></td></tr>";
            echo "<tr><td>Linking:</td><td> <select name='link'>";
            echo "<option value='dnl'>Dont Link</option>";
            include('../lib/connection.php');
            $d1=mysql_query("select * from MLIBRARYT");
            while($d2=mysql_fetch_array($d1))
            {
                $lid=$d2['lid'];
                $bname=$d2['bname'];
                $bauthor=$d2['bauthor'];
                echo "Hello".$lid;
                if($dlid==$lid)
                    echo "<option value='$lid' default>$bname-by-$bauthor</option>";
                else
                    echo "<option value='$lid'>$bname-by-$bauthor</option>";
                
            }
            echo "</select></td>";
            $arr=getBranches();
	    $len=count($arr);
	    include("../lib/connection.php");
	    echo "<td>Branch:</td><td><br><select name='branch'>";
	    for($i=0;$i<$len;$i++)
	    {
		$br=mysql_query("select brid from MBRANCHT where brname='$arr[$i]'") or die(mysql_error());
		$branch=mysql_fetch_array($br);
		$brid=$branch['brid'];
                echo "<option value='$brid'>$arr[$i]</option>";
                
            }
	    echo "</select></td></tr>";
            echo "<tr><td>Year:</td><td><br><select name='year'>";
	    echo "<option value='0'>1st-Year</option>";
	    echo "<option value='1'>2nd-Year 1st-Sem</option>";
	    echo "<option value='2'>2nd-Year 2nd-Sem</option>";
	    echo "<option value='3'>3rd-Year 1st-Sem</option>";
	    echo "<option value='4'>3rd-Year 2nd-Sem</option>";
	    echo "<option value='5'>4th-Year 1st-Sem</option>";
	    echo "<option value='6'>4th-Year 2nd-Sem</option>";
	    echo "</select></td>";
            
            $reg=getRegulations();
	    $rlen=count($reg);
	    include("../lib/connection.php");
	    echo "<td>Regulation:</td><td><br><select name='reg'>";
	    for($i=0;$i<$rlen;$i++)
	    {
		$r=mysql_query("select * from MREGT where regname='$reg[$i]'") or die(mysql_error());
		$rg=mysql_fetch_array($r);
		$regid=$rg['regid'];
		echo "<option value='$regid'>$reg[$i]</option>";
	    }
	    echo "</select></td></tr>";
            echo "</table>";
            echo "<br><br><input type='submit' name='phase2' value='Update'>";
            echo "</form>";
        }
        else if(isset($_POST['phase1']))
        {
            notifyerr("!No Filed Selected Try Again!");
            redirect("?m=edit_ebook");
        }
        if(isset($_POST['phase2']))
        {
            $did=$_POST['did'];
            $reg=$_POST['reg'];
            $year=$_POST['year'];
            $branch=$_POST['branch'];
            $bname=$_POST['ebname'];
            $bauthor=$_POST['ebauthor'];
            $pub=$_POST['ebpub'];
            $reg=$_POST['reg'];
            $lid=$_POST['link'];
            $ebedition=$_POST['ebedition'];
            
            include("../lib/connection.php");
            if($lid=='dnl')
                mysql_query("update MDOCT set lid='',akyr='$year',brid='$branch',reg='$reg',docname='$bname',docauthor='$bauthor',docpub='$pub',docedition='$ebedition' where did='$did'");
            else
                mysql_query("update MDOCT set lid='$lid',akyr='$year',brid='$branch',reg='$reg',docname='$bname',docauthor='$bauthor',docpub='$pub',docedition='$ebedition' where did='$did'");
            notify("Editing Succedfully Done");
            redirect('?');
        }
        ?>
    </body>
</html>