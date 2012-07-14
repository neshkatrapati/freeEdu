<html>
    <head>
         <link rel="stylesheet" href="../modules/library/css/bootstrap1.css" type="text/css" media="screen" />
        <script type="text/javascript" src="../modules/library/js/bootstrap-modal.js"></script>
        <script type="text/javascript" src="../modules/library/js/bootstrap-alert.js"></script>  
         <script type="text/javascript">
        $('#myModal').modal('toggle');
	</script>
    </head>
<body>
    <center>
<?php
    function date_difference($old_date, $new_date) {
    $offset = $new_date - $old_date;
    return $offset/60/60/24;
    }
$oid=getCurrentObject();
$order=mysql_query("select * from MORDERT where oid='$oid' and (aop='-2' or aop='p')");
$o_num=mysql_num_rows($order);
if($o_num==0)
{
    echo "<h6>No Orders Placed. If you want to place an order plese <a href='?m=lib_viewbook'>click here</a></h6>";
}
else{
    echo " <ul class='thumbnails'>";
    while($oa=mysql_fetch_array($order))
    {
        $aop=$oa['aop'];
        if($aop=='p')
        {
            $intime=$oa['intime'];
            $outtime=$oa['outtime'];
	    $aouttime=$oa['aouttime'];
	}
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
            echo "<img src='../$bookimage' width='100'>";
           echo "
            <div class='caption'>
              <h4>$bname-by-$bauthor</h4>
              <h4>Order Id: $orid</h4>
              <h5>Details of the book:</h5><b>Book ID:</b>$bookid<br><b>Edition:</b>$bedition<br><b>Publisher:</b>$bpub<br></p>";
	      if($aop==-2)
	      {
		echo "Book Ordered but not claimed";
	      }
	      elseif($aop=='p')
	      {
		echo "Books claimed on <b>".date('d-M-y',$intime);
		echo "</b><br>Book Must be returned on <b>".date('d-M-y',$outtime);
		echo "</b><br>Book returnd on <b>".date('d-M-y',$aouttime);
		 $diff=date_difference($aouttime,$outtime);
                echo "<br><br>Due Details:</b>";
                if($diff<0)
                {
                    $diff=$diff*-1;
                    echo "<br>Your Book was Due by $diff days.<br>You may be Fined INR $diff.";
                }
                else if($diff==0)
                {
                    echo "<br>Your Have to return the book Today";
                }
                else   if($diff>0)
                {
                    echo "<br>Your have returned the book on time.Thank You!";
                }
	      }
            }
              echo "
            </div>
          </div>
        </li>
       ";
    }    
    echo "</ul>";

?>
    </center>
</body>
</html>