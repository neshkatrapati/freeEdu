if(isset($_POST['phase1']))
        {
           $search=$_GET['search'];
            if($search=='date')
            {
                $i=$_GET['i'];
                $from=$_POST['from'];
                $to=$_POST['to'];
                $sfrom=strtotime($from);
                $sto=strtotime($to);
                $order=mysql_query("select * from MORDERT where intime>='$sfrom' and outtime<='$sto' and aop='a'") or die(mysql_error());
                   $o_num=mysql_num_rows($order);
                echo "       
        <div class='accordion' id='accordion2'>";
        
        echo "
            <div class='accordion-group'>
              <div class='accordion-heading'>
                <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#collapseOne'>
                  Books to be Issued
                </a>
              </div>
              <div id='collapseOne' class='accordion-body collapse' style='height: 0px; '>
                <div class='accordion-inner'>
                    <h6>No Orders with that serach</h6>
                </div>
              </div>";
              
              echo "
            </div>
            <div class='accordion-group'>
              <div class='accordion-heading'>
                <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#collapseTwo'>
                  Books Already Issued
                </a>
              </div>
              <div id='collapseTwo' class='accordion-body collapse' style='height: 0px; '>
                <div class='accordion-inner'>";
             
                  if($o_num==0)
                  {
                    echo "<h6>No Orders with that serach</h6>";
                  }
                  else
                  {
                    while($oa=mysql_fetch_array($order))
                    {
                        $lid=$oa['lid'];
                        $orid=$oa['orderid'];
                        $o_lib=mysql_query("select * from MLIBRARYT where lid='$lid'");
                        $olib=mysql_fetch_array($o_lib);
                        $bookid=$olib['bookid'];
                        $bname=$olib['bname'];
                        $bauthor=$olib['bauthor'];
                        $bpub=$olib['bpub'];
                        $bedition=$olib['bedition'];
                        $bimg=$olib['imgid'];
                        echo "<tr>";
                        $book_img=mysql_query("select * from MIMGT where imgid='$bimg'");
                        $b_img=mysql_fetch_array($book_img);
                        $bookimage=$b_img['imguri'];
                        echo "
                        <li class='span3'>
                      <div class='thumbnail'>";
                        if($bimg==NULL)
                        echo "<br><br><br><center><h6>No Cover Page</h6></center><br><br><br>";
                        else
                        echo "<img src='../$bookimage' width='75'>";
                       echo "
                            <div class='caption'>
                          <h4>$bname-by-$bauthor</h4>
                          <h4>Order Id: $orid</h4>
                              <h5>Details of the book:</h5><b>Book ID:</b> $bookid<br><b>Edition:</b> $bedition<br><b>Publisher:</b> $bpub<br></p>";              
                         
                          echo "
                        </div>
                      </div>
                    </li>
                    ";
                    }
                    }
                  echo "</div>
                
              </div>
            </div>";
            
            echo "
            <div class='accordion-group'>
              <div class='accordion-heading'>
                <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#collapseThree'>
                  Books Already Issued-Exceeding due date
                </a>
              </div>
              <div id='collapseThree' class='accordion-body collapse'>
                <div class='accordion-inner'>
                    <?php //content  ?>
                     <ul class='pager'>
                        <li class='previous'>
                          <a href='#'>&larr; Older</a>
                        </li>
                        <li class='next'>
                          <a href='#'>Newer &rarr;</a>
                        </li>
                    </ul>
                </div>
              </div>
            </div>
          </div>";
 
            }
            else if($search=='name')
            {
                $bookname=$_POST['bookname'];
                $barr=explode('/',$bookname);

                $bookid=$barr[0];
                $lib_c=mysql_query("select * from MLIBRARYT where bookid='$bookid' aop='-1'");
                $f_lid=mysql_fetch_array($lib_c);
                $lid=$f_lid['lid'];
                $order=mysql_query("select * from MORDERT where lid='$lid'");
            }
            else if($search==NULL)
            {
                $orderid=$_POST['orderid'];
                $order=mysql_query("select * from MORDERT where orderid='$orderid' aop='-1'");
                
            }
            
        }