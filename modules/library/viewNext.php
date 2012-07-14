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
                    echo "<th>E-Book</th>";
                    echo "<th>Order Book</th></tr></div>";
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
                        $ooid=getCurrentObject();
                        $cklid=mysql_query("select * from MORDERT where oid='$ooid' and lid='$lid' and aop='-1'");
                        $cklid1=mysql_query("select * from MORDERT where oid='$ooid' and lid='$lid' and aop='a'");
                        $ck_num=mysql_fetch_array($cklid);
                        $ck_num1=mysql_fetch_array($cklid1);
                        if($ck_num1==0)
                        {
                            if($ck_num==0)
                                echo "<td><a data-toggle='modal' href='#myModal$lid' class='btn btn-primary btn-small'>Order Book</a></td>";
                            else if($ck_num!=0)
                                echo "<td><a data-toggle='modal' href='#rmyModal$lid' class='btn btn-danger btn-small'>Remove Order</a></td>";
                        }
                        else
                            echo "<td>Book already Issued</td>";
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
        $a=mysql_query("select * from MLIBRARYT");
        while($e=mysql_fetch_array($a))
        {
        $bookid=$e['bookid'];
        $bname=$e['bname'];
        $bauthor=$e['bauthor'];
        $bpub=$e['bpub'];
        $bedition=$e['bedition'];  
        $lid=$e['lid'];
        $bimg=$e['imgid'];
        $bauthor=$e['bauthor'];
        $book_img=mysql_query("select * from MIMGT where imgid='$bimg'");
        $b_img=mysql_fetch_array($book_img);
        $bookimage=$b_img['imguri'];
        echo "<div id='myModal$lid' class='modal hide fade' style='display:none; overflow:hidden;'>
            <div class='modal-header'>";
            echo "
              <a class='close' data-dismiss='modal'>×</a>
              <h3>Order A Book</h3>
            </div>
            <div class='modal-body'>";
                if($bookimage==NULL)
            echo "</h2>No Cover Page</h2><br>";
            else
            echo "<img src='../$bookimage' width='100'><br>";
             echo "
             <form action='#' method='post'>
             <h4>$bookid / $bname- by - $bauthor - of - $bedition - by - $bpub </h4>
              <p>Do You Want to Order this Book?</p>
            </div>
            <div class='modal-footer'>
              <a href='?m=lib_viewbook&order=$lid' class='btn btn-primary'>Place Order</a>
              <a href='#' class='btn' data-dismiss='modal'>Close</a>
            </div>
          </div>";
          
           echo "<div id='rmyModal$lid' class='modal hide fade' style='display:none; overflow:hidden;'>
            <div class='modal-header'>";
            echo "
              <a class='close' data-dismiss='modal'>×</a>
              <h3>Order A Book</h3>
            </div>
            <div class='modal-body'>";
                if($bookimage==NULL)
            echo "</h2>No Cover Page</h2><br>";
            else
            echo "<img src='../$bookimage' width='100'><br>";
             echo "
             <form action='#' method='post'>
             <h4>$bookid / $bname- by - $bauthor - of - $bedition - by - $bpub </h4>
              <p>Do You Want to Remove the Order?</p>
            </div>
            <div class='modal-footer'>
              <a href='?m=lib_viewbook&rorder=$lid' class='btn btn-danger'>Remove Order</a>
              <a href='#' class='btn' data-dismiss='modal'>Close</a>
            </div>
          </div>";
        }?>
    </body>
</html>