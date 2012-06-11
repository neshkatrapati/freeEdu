<?php
         require_once("library_lib.php");
       require_once("../../lib/connection.php");
       $s=$_GET['s'];
       $doc=mysql_query("select * from MDOCT where docname like '%$s%' or docauthor like '%$s%' or docpub like '%$s%' or edition like '%$s%'");
       $doc_num=mysql_num_rows($doc);
       if($doc_num!=0)
           {
        echo "<h2>Edit Ebooks</h2><br>";
            echo "<br>";
               
           echo "<table border='5' cellpadding='9'>
            <tr>
                <th>&nbsp</th>
                <th>Cover Page<br>(if given uploaded)</th>
                <th>EBook Name</th>
                <th>Author</th>
                <th>Publications</th>
                <th>Edition</th>
                <th>Branch</th>
                <th>Regulation</th>
                <th>Linked Book</th>
            </tr>";
        while($d=mysql_fetch_array($doc))
        {
            echo "<tr>";
            $did=$d['did'];
            $docname=$d['docname'];
            $docauthor=$d['docauthor'];
            $brid=$d['brid'];
            $reg=$d['reg'];
            $docpub=$d['docpub'];
            $docedition=$d['edition'];
            $docimg=$d['docimg'];
            $lid=$d['lid'];
            echo "<td><input type='radio' name='did' value='$did' required='true'></td>";
            if($docimg!=NULL)
            {
                $img=mysql_query("select * from MIMGT where imgid='$docimg'");
                $image=mysql_fetch_array($img);
                $imguri=$image['imguri'];
                echo "<td><img src='../$imguri' width='75'></td>";
            }
            else
            {
                echo "<td>NO COVER PAGE</td>";     
            }
            echo "<td>$docname</td>";
            echo "<td>$docauthor</td>";
            echo "<td>$docpub</td>";
            echo "<td>$docedition</td>";
                echo "<td>".getBranch($brid)."</td>";
                echo "<td>".getReg($reg)."</td>";
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
           }
           elseif($doc_num==0)
           {
                      echo "<center><h6>No Search with that Filter</h6></center>";
           }

?>