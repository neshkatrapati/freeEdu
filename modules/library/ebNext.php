<?php
include('library_lib.php');
            include("../../lib/connection.php");
            $s=$_GET['s'];
                $bk=mysql_query("select * from MLIBRARYT where bname like '%$s%'  or bookid like '%$s%' or bauthor like '%$s%' or bpub like '%$s%' or bedition like '%$s%'");
                $b_num=mysql_num_rows($bk);
                if($b_num!=0)
                {
                 echo "<h2>Edit Books</h2>";
                echo "<br>";
                  echo "<table border=5 cellpadding=10>
               <tr>
                <th>&nbsp</th>
                <th>Cover Page<br>(if given previously)</th>
                <th>Book Id</th>
                <th>Book Name</th>
                <th>Author</th>
                <th>Publications</th>
                <th>Edition</th>
                <th>Linked Subject</th>
                <th>Number<br>of Copies</th>
               </tr>";
                 while($b=mysql_fetch_array($bk))
                {
                    $lid=$b['lid'];
                    $bid=$b['bookid'];
                    $bname=$b['bname'];
                    $bauthor=$b['bauthor'];
                    $pub=$b['bpub'];
                    $edition=$b['bedition'];
                    $subid=$b['subid'];
                    $suid=$b['suid'];
                    $ncps=$b['ncps'];
                    $imgid=$b['imgid'];
                    $lid=$b['lid'];
                    $subarr=explode(";",$subid);
                    $sublen=count($subarr);
                    $img=mysql_query("select * from MIMGT where imgid='$imgid'");
                    $image=mysql_fetch_array($img);
                    $imguri=$image['imguri'];
                    echo "<form action='#' method='post'>";
                    echo "<tr><td><input type='radio' name='lid' value='$lid' required='true'></td>";
                    if($imguri==NULL)
                        echo "<td>No cover Image</td>";
                    else
                        echo "<td><img src='../$imguri' width='100'></td>";
                    echo "<td>$bid</td>";
                    echo "<td>$bname</td>";
                    echo "<td>$bauthor</td>";
                   echo "<td>$pub</td>";
                   echo "<td>$edition</td>";
                   echo "<td>";
                    for($i=0;$i<$sublen;$i++)
                    {
                        $subjectname=mysql_query("select * from MSUBJECTT where subid='$subarr[$i]'");
                        $subjname=mysql_fetch_array($subjectname);
                        $subname=$subjname['subname'];
                        $suid=$subjname['suid'];
                        $subj=mysql_query("select * from SAVAILT where subid='$suid'");
                        $subjt=mysql_fetch_array($subj);
                        $brid=$subjt['brid'];
                        $reg=$subjt['regid'];
                        echo getBranch($brid)."--".getReg($reg)."--".$subname."<br>";
                        
                    }
                   echo "</td>";
                   echo "<td>$ncps</td>";
                   echo "</tr>";
                }   
            
                echo "</table><br>";
                echo "<input type='submit' name='phase1' value='Edit'>";
                }                
               elseif($b_num==0)
               {
                 echo "<center><h6>No Search with that Filter</h6></center>";
               }
             ?>