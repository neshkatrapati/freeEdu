<html>
    <head>
    </head>
    <body>
        <?php
        $check=-1;
        include_once("../../lib/lib.php");
        include_once("../../lib/connection.php");
            $branch=$_GET['branch'];
            $reg=$_GET['reg'];
            $search=$_GET['search'];
            if($branch==-1 && $reg==-1)
                $lib=mysql_query("select * from SAVAILT") or die(mysql_error());
            else if($branch==-1 && $reg!=-1)
                 $lib=mysql_query("select * from SAVAILT where regid='$reg'") or die(mysql_error());
            else if($branch!=-1 && $reg!=-1)
                 $lib=mysql_query("select * from SAVAILT where brid='$branch' and regid='$reg'") or die(mysql_error());
            else if($reg==-1 && $branch!=-1)
            {
                $lib=mysql_query("select * from SAVAILT where brid='$branch'") or die(mysql_error());
            }
            echo "<div id='table'><table border=5 cellpadding=10>";
                    echo "<th>Cover Page</th>";
                    echo "<th>Bookid</th>";
                    echo "<th>bname</th>";
                    echo "<th>bauthor</th>";
                    echo "<th>bpub</th>";
                    echo "<th>bedition</th>";
                    echo "<th>Number of Copies</th>";
                    echo "<th>E-Book</th></tr></div>";
            while($subj=mysql_fetch_array($lib))
            {
                $suid=$subj['subid'];
                if($search==NULL)
                    $library=mysql_query("select * from MLIBRARYT");
                else
                    $library=mysql_query("select * from MLIBRARYT where bname like '%$search%' or bookid like '%$search%' or bauthor like '%$search%' or bpub like '%$search%' or bedition like '%$search%'");
                    while($l=mysql_fetch_array($library))
                    {
                        unset($subidarr);
                        unset($subarr);
                        $subid=$l['subid'];
                        $subarr=explode(";",$subid);
                        $subcount=count($subarr);
                        for($h=0;$h<$subcount;$h++)
                        {
                            $ssub=mysql_query("select * from MSUBJECTT where subid='$subarr[$h]'");
                            $s1sub=mysql_fetch_array($ssub);
                            $subidarr[]=$s1sub['suid'];
                        }
                        $lid=$l['lid'];
                        if(in_array($suid,$subidarr) && !in_array($lid,$c))
                        {
                            $c[]=$lid;
                            $bookid=$l['bookid'];
                            $bname=$l['bname'];
                            $bauthor=$l['bauthor'];
                            $bpub=$l['bpub'];
                            $bedition=$l['bedition'];
                            $bimg=$l['imgid'];
                            $ncps=$l['ncps'];
                            echo "<tr>";
                            $book_img=mysql_query("select * from MIMGT where imgid='$bimg'");
                            $b_img=mysql_fetch_array($book_img);
                            $bookimage=$b_img['imguri'];
                            if($bimg==NULL)
                                echo "<td>No Cover Page</td>";
                            else
                                echo "<td><img src='../$bookimage' width='100'></td>";
                            echo "<td>$bookid</td>";
                            echo "<td>$bname</td>";
                            echo "<td>$bauthor</td>";
                            echo "<td>$bpub</td>";
                            echo "<td>$bedition</td>";
                            echo "<td>$ncps</td>";
                            $doc=mysql_query("select * from MDOCT where lid='$lid'");
                            $numdoc=mysql_num_rows($doc); 
                            echo "<td>";
                            if($numdoc==0)
                            {   
                                echo "No Link";
                            }
                            else
                            {
                                $i=0;
                                while($d=mysql_fetch_array($doc))
                                {
                                    $link=$d['eburi'];
                                    echo "<a href='../$link' target='_blank'>Open/Download Link $i</a><br>";
                                    $i++;
                                }
                            }
                        echo "</td>";
                        echo "</tr>";
                        $check=0;
                    }   
                    else    
                    {
                        $check=-1;
                       
                    }
                }
               
            }
            echo "</table>";
            if($check==-1)
            {
                echo "<h6>Books with the selected filters</h6>";
                echo "<script type='text/javascript'>document.getElementById('table').innerHTML=''</script>";
            }
        ?>
    </body>
</html>