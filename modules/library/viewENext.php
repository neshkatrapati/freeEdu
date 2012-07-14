<html>
    <head>
    </head>
    <body>
        <?php
        include_once("../../lib/lib.php");
        include_once("../../lib/connection.php");
            $branch=$_GET['branch'];
            $reg=$_GET['reg'];
            $search=$_GET['search'];
            if($branch==-1 && $reg==-1) 
                $lib=mysql_query("select * from MDOCT where docname like '%$search%' or docauthor like '%$search%' or docpub like '%$search%' or edition like '%$search%'");
            else if($branch==-1  && $reg!=-1)
                 $lib=mysql_query("select * from MDOCT where reg='$reg' and (docname like '%$search%' or docauthor like '%$search%' or docpub like '%$search%' or edition like '%$search%')");
            else if( $branch!=-1 && $reg!=-1)
                 $lib=mysql_query("select * from MDOCT where brid='$branch' && reg='$reg' and (docname like '%$search%' or docauthor like '%$search%' or docpub like '%$search%' or edition like '%$search%')");
            else if( $reg==-1 && $branch!=-1)
            {
                $lib=mysql_query("select * from MDOCT where brid='$branch' and (docname like '%$search%' or docauthor like '%$search%' or docpub like '%$search%' or edition like '%$search%')") or die(mysql_error());
            }
            $num=mysql_num_rows($lib);
            if($num==0)
            {
                echo "<h6>No Books With this Filter";
            }
            else
            {
                echo "<table border=4 cellpadding=10>";
                echo "<th>Cover Page</th>";
                echo "<th>EBook name</th>";
                echo "<th>EBook author</th>";
                echo "<th>Ebook pubublisher</th>";
                echo "<th>Ebook edition</th>";
                echo "<th>Open/Download Link</th>";
                echo "<th>Linked to</th></tr>";
            }        
            while($l=mysql_fetch_array($lib))
            {
                $did=$l['did'];
                $docname=$l['docname'];
                $docauthor=$l['docauthor'];
                $docpub=$l['docpub'];
                $docedition=$l['edition'];
                $docimg=$l['docimg'];
                $link=$l['eburi'];
                $lid=$l['lid'];
                
                echo "<tr>";
                $doc_img=mysql_query("select * from MIMGT where imgid='$docimg'");
                $d_img=mysql_fetch_array($doc_img);
                $docimage=$d_img['imguri'];
                if($docimg==NULL)
                    echo "<td>No Cover Page</td>";
                else
                    echo "<td><img src='../$docimage' width='100'></td>";
                echo "<td>$docname</td>";
                echo "<td>$docauthor</td>";
                echo "<td>$docpub</td>";
                echo "<td>$docedition</td>";
                echo "<td><a href='../$link' target='_blank'>Open/Download Link $i</a><br>";
                echo "</td>";
                echo "<td>";
                if($lid!=NULL)
                {
                    $libry=mysql_query("select * from MLIBRARYT where lid='$lid'");
                    $lry=mysql_fetch_array($libry);
                    $lbookid=$lry['bookid'];
                    $lbname=$lry['bname'];
                    $lbauthor=$lry['bauthor'];
                    echo "$lbookid--$lbname--by--$lbauthor";
                }
                else
                {
                    echo "No Link";
                }
                
                echo "</tr>";
            }
        ?>
    </body>
</html>