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
            echo "<h1>Edit Ebooks</h1>";
        echo "<form action='#' method='post'>";
        echo "<table border='1' cellpadding=6>
            <tr>
                <th>&nbsp</th>
                <th>Cover Page<br>(if given previously)</th>
                <th>EBook Name</th>
                <th>Author</th>
                <th>Publications</th>
                <th>Edition</th>
                <th>Branch</th>
                <th>Regulation</th>
                <th>Year</th>
                <th>Linked Book</th>
            </tr>";
        $doc=mysql_query("select * from MDOCT");
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
            $docedition=$b['docedition'];
            $docimg=$d['docimg'];
            $lid=$d['lid'];
            $img=mysql_query("select * from MIMGT where imgid='$docimg'");
            $image=mysql_fetch_array($img);
            $imguri=$image['imguri'];
            echo "<td><input type='radio' name='did' value='$did'></td>";
            echo "<td><img src='../$imguri' width='100'></td>";
            echo "<td>$docname</td>";
            echo "<td>$docauthor</td>";
            echo "<td>$docpub</td>";
            echo "<td>$docedition</td>";
            echo "<td>".getBranch($brid)."</td>";
            echo "<td>".getReg($reg)."</td>";
            echo "<td>".getYear($year)."</td>";
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
        echo "<input type='submit' name='phase1' value='Submit'>";
        echo "</form>";
        }
        if(isset($_POST['phase1'])&& !isset($_POST['phase2']))
        {
            echo "<fieldset>";
            echo "<legend>Edit Ebooks</legend>";
            notifywar("Please check the branch year and linking before you Submit");
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
            echo "<table cellpadding=5>";
            echo "<form action='#' method='post'>";
            echo "<input type='hidden' name='did' value='$did'>";
            echo "<tr><td>Book Name:<input type='text' name='ebname' value='$docname' required='true'></td>";
            echo "<td>Author:<input type='text' name='ebauthor' value='$docauthor' required='true'></td></tr>";
            echo "<tr><td>Publication:<input type='text' name='ebpub' value='$pub' required='true'></td>";
            echo "<td>Edition:<input type='text' name='ebedition' value ='$ebedition' required='true'></td></tr>";
            echo "<tr><td>Linking: <select name='link'>";
            echo "<option value='dnl'>Dont Link</option>";
            include('../lib/connection.php');
            $d1=mysql_query("select * from MLIBRARYT");
            while($d2=mysql_fetch_array($d1))
            {
                $lid=$d2['lid'];
                $bname=$d2['bname'];
                $bauthor=$d2['bauthor'];
                if($dlid==$lid)
                    echo "<option value='$lid' default>$bname-by-$bauthor</option>";
                else
                    echo "<option value='$lid'>$bname-by-$bauthor</option>";
                
            }
            echo "</select></td>";
            $arr=getBranches();
	    $len=count($arr);
	    include("../lib/connection.php");
	    echo "<td>Branch:<select name='branch'>";
	    for($i=0;$i<$len;$i++)
	    {
		$br=mysql_query("select brid from MBRANCHT where brname='$arr[$i]'") or die(mysql_error());
		$branch=mysql_fetch_array($br);
		$brid=$branch['brid'];
                echo "<option value='$brid'>$arr[$i]</option>";
                
            }
	    echo "</select></td></tr>";
            echo "<tr><td>Year:<select name='year'>";
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
	    echo "<td>Regulation: <select name='reg'>";
	    for($i=0;$i<$rlen;$i++)
	    {
		$r=mysql_query("select * from MREGT where regname='$reg[$i]'") or die(mysql_error());
		$rg=mysql_fetch_array($r);
		$regid=$rg['regid'];
		echo "<option value='$regid'>$reg[$i]</option>";
	    }
	    echo "</select></td></tr>";
            echo "</table>";
            echo "<br><br><input type='submit' name='phase2'>";
            echo "</form>";
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