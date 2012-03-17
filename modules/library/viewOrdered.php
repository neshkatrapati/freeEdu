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
    $rorder=$_GET['rorder'];
    $orderid=$_GET['orderid'];
      if($rorder!=NULL && $orderid!=NULL)
            {
                
                $c_num=mysql_query("select * from MORDERT where orderid='$orderid' and lid='$rorder' and (aop='-1' or aop='a')");
                $oc_num=mysql_num_rows($c_num);
                if($oc_num!=0)
                {
                    $o_check=mysql_query("select * from MORDERT where orderid='$orderid' and lid='$rorder'");
                    $or_check=mysql_fetch_array($o_check);
                    $aop=$or_check['aop'];
                    if($aop=='-1'){
                        mysql_query("update MORDERT set aop='-2' where oid='$objid' and lid='$rorder' and orderid='$orderid'") or die(mysql_error());?> 
                        <div class="alert alert-success fade in">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            Ordered Book Removed Successfully.</div> <?}
                    else if($aop=='a')
                    {?>
                        <div class="alert alert-block alert-error fade in">
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                            Book Already Clamed.Invalid Option.Try Again !</div> 
                    <?}
                }
                else {?>
                     <div class="alert alert-block alert-error fade in">
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                        Ordered Cannot be removed.Invalid Option.Try Again</div>
                <?}}
    
    
    
    function date_difference($old_date, $new_date) {
    $offset = strtotime($new_date) - strtotime($old_date);
    return $offset/60/60/24;
    }
$oid=getCurrentObject();
$order=mysql_query("select * from MORDERT where oid='$oid' and (aop='-1' or aop='a')");
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
        if($aop=='a')
        {
            $intime=$oa['intime'];
            $outtime=$oa['outtime'];
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
            echo "<img src='../$bookimage' class='orbook'>";

           echo "
            <div class='caption'>
              <h4>$bname-by-$bauthor</h4>
              <h4>Order Id: $orid</h4>
              <h5>Details of the book:</h5><b>Book ID:</b> $bookid<br><b>Edition:</b> $bedition<br><b>Publisher:</b> $bpub<br></p>";              
              
              if($aop=='-1')
              {
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
                    <a href='?m=lib_viewordered&rorder=$lid&orderid=$orid' class='btn btn-danger'>Remove Order</a>
                <a href='#' class='btn' data-dismiss='modal'>Close</a>
                  </div>
                </div>";
                echo "<br><b>Order Not Clamed</b><br>";
                echo "<p><center><br><br><a data-toggle='modal' href='#rmyModal$lid' class='btn btn-danger btn-medium'>Remove Order</a></center></p>";
              }
            else if($aop=='a')
            {
                echo "<b>Book Taken on: </b>".date('d M Y',$intime);
                echo "<br><b>Book Should be retured on or before: </b>".date('d M Y',$outtime);
                $tdate=date('m/d/y');
                $ldate=date('m/d/y',$outtime);
                $diff=date_difference($tdate,$ldate);
                echo "<br><br><b>Due Details:</b>";
                if($diff<0)
                {
                    $diff=$diff*-1;
                    echo "<br>Your Book is Due by $diff days.<br>You may be Fined INR $diff.";
                }
                else if($diff==0)
                {
                    echo "<br>Your Have to return the book Today";
                }
                else   if($diff>0)
                {
                    echo "<br>Your can return the in $diff day/days.<br>Please return the book on time.";
                }
            }
              echo "
            </div>
          </div>
        </li>
       ";
    }    
    echo "</ul>";
}
?>
    </center>
</body>
</html>
