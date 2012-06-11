<?php
require_once("../../lib/connection.php");
$orderid=$_GET['o'];
$bookname=$_GET['b'];
$ba=$_GET['ba'];
$bp=$_GET['bp'];
if($orderid!=NULL && $bookname==NULL)
{
    if($ba==1 && $bp==0)
    {
        $o=mysql_query("Select * from MORDERT where orderid like '%$orderid%' and (aop='a' or aop='-1')") or die(mysql_error());
    }
    else if($ba==0 && $bp==1)
    {
        $o=mysql_query("Select * from MORDERT where orderid like '%$orderid%' and aop='p'");
    }
}
elseif($orderid==NULL && $bookname!=NULL)
{
    if($ba==1 && $bp==0)
    {
        $o=mysql_query("select * from MORDERT where lid in ('select * from MLIBRARYT where bname like %$bookname%  or bookid like %$bookname% or bauthor like %$bookname% or bpub like %$bookname% or bedition like %$bookname%') and (aop='a' or aop='-1')");
    }
    else if($ba==0 && $bp==1)
         $o=mysql_query("select * from MORDERT where lid in ('select * from MLIBRARYT where  bname like %$bookname%  or bookid like %$bookname% or bauthor like %$bookname% or bpub like %$bookname% or bedition like %$bookname%') and aop='p'");
}
elseif($orderid!=NULL && $bookname!=NULL)
{
    if($ba==1 && $bp==0)   
       $o=mysql_query("select * from MORDERT where lid in ('select * from MLIBRARYT where  bname like %$bookname%  or bookid like %$bookname% or bauthor like %$bookname% or bpub like %$bookname% or bedition like %$bookname%') and orderid like '%$orderid%' and (aop='a' or aop='-1')");
    else if($ba==0 && $bp==1)
        $o=mysql_query("select * from MORDERT where lid in ('select * from MLIBRARYT where  bname like %$bookname%  or bookid like %$bookname% or bauthor like %$bookname% or bpub like %$bookname% or bedition like %$bookname%') and orderid like '%$orderid%' and aop='p'");
}
$o_num=mysql_num_rows($o);
if($o_num!=0)
{ 
    echo "<center><table border='5' cellpadding='7' style='text-align:center;'>";
    if($ba==1)
        echo "<tr><th>Order Id</th><th>Object Image</th><th>Roll Number</th><th>Object Name</th><th>Book ID</th><th>Ordered Book</th><th>Action</th></tr>";
    else if($bp==1)
        echo "<tr><th>Order Id</th><th>Object Image</th><th>Roll Number</th><th>Object Name</th><th>Book ID</th><th>Ordered Book</th><th>Issued Date</th><th>Return Date</th><th>Actual Return Date</th></tr>";
}
else
{
    echo "<center><h6>No Search Results</h6></center>";
}
  function date_difference($old_date, $new_date) {
    $offset = $new_date - $old_date;
    return $offset/60/60/24;
    }
while($obj=mysql_fetch_array($o))
{
    $objid=$obj['oid'];
    $orderid=$obj['orderid'];
    $lid=$obj['lid'];
    $aop=$obj['aop'];
    $intime=$obj['intime'];
    $outtime=$obj['outtime'];
    $aouttime=$obj['aouttime'];
    $object=mysql_query("select * from MOBJECTT where oid='$objid'");
    $obd=mysql_fetch_array($object);
    $obname=$obd['obname'];
    $otyid=$obd['otyid'];
    $objid1=$obd['obhandle'];
    $type=mysql_query("select * from OTYPET where tyid='$otyid'");
    $ftype=mysql_fetch_array($type);
    $matcher=$ftype['matcher'];
    $tytab=$ftype['tytab'];
    $issue=mysql_query("select * from $tytab where $matcher='$objid1'");
    $fissue=mysql_fetch_array($issue);
    if($matcher='sid')
    {
        $rno=$fissue['srno'];
        $name=$fissue['sname'];
        $imgid=$fissue['imgid'];
    }
    elseif($matcher='fid')
    {
        $rno='---N/A---';
        $name=$fissue['fname']; 
        $imgid=$fissue['imgid'];
    }
    $a=mysql_query("select * from MLIBRARYT where lid='$lid'");
    $e=mysql_fetch_array($a);
    $bookid=$e['bookid'];
    $bname=$e['bname'];
    $bauthor=$e['bauthor'];
    $bpub=$e['bpub'];
    $bedition=$e['bedition'];  
    $lid=$e['lid'];
    $bauthor=$e['bauthor'];
    $bookimage=$b_img['imguri'];
    echo "<tr><td>$orderid</td>";
    if($imgid!=NULL)
    {
        $i=mysql_query("select * from MIMGT where imgid='$imgid'") or die(mysql_error());
        $img=mysql_fetch_array($i);
        $imguri=$img['imguri'];
        echo "<td><img src='../$imguri' width='60'></td>";
    }
    else{
        echo "<td><h4>No Cover Page</h4></td>";
    }
    echo "<td>$rno</td>";   
    echo "<td>$name</td>";
    echo "<td>$bookid</td> <td> $bname- by - $bauthor - of - $bedition - by - $bpub</td>";
    if($ba==1)
    {
        if($aop=='a')
        {
            echo "<td><a data-toggle='modal' href='#myModal$orderid' class='btn btn-danger btn-small'>Returned Book</a></td>";
        }
        elseif($aop='-1')
        {
             echo "<td><a data-toggle='modal' href='#myModal$orderid' class='btn btn-primary btn-small'>Issue Book</a></td>";
        }
    }
    else if($bp==1)
    {
        echo "<td>".date('d-M-y',$intime)."</td><td>".date('d-M-y',$outtime)."</td><td>".date('d-M-y',$aouttime)."</td>";
    }
    echo "</tr>";
}
$amodal=mysql_query("select * from MORDERT where aop='a'");
while($ai=mysql_fetch_array($amodal))
{
    $intime=$ai['intime'];
    $outtime=$ai['outtime'];
    $aouttime=strtotime(date('d-M-y'));
    $lid=$ai['lid'];
    $orderid=$ai['orderid'];
    $oid=$ai['oid'];
    $a=mysql_query("select * from MLIBRARYT where lid='$lid'");
    $e=mysql_fetch_array($a);
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
        echo "<div id='myModal$orderid' class='modal hide fade' style='display:none; overflow:hidden;'>
            <div class='modal-header'>";
            echo "
              <a class='close' data-dismiss='modal'>×</a>
              <h3>Returned Book</h3>
            </div>
            <div class='modal-body'>";
                if($bookimage==NULL)
            echo "<h6>No Cover Page</h6><br>";
            else
            echo "<img src='../$bookimage' width='100'><br>";
             echo "
             <form action='#' method='post'>
             <h4>$bookid / $bname- by - $bauthor - of - $bedition - by - $bpub </h4>";
                echo "<b>Due Details:</b>";
                    $diff=date_difference($aouttime,$outtime);
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
                    echo "<br>Your can return the book in $diff day/days.<br>Please return the book on time.";
                }
             echo "       <p>Book Returned ?</p>
            </div>
            <div class='modal-footer'>
              <a href='?m=lib_issueorder&return=$orderid' class='btn btn-primary'>Confirm</a>
              <a href='#' class='btn' data-dismiss='modal'>Close</a>
            </div>
          </div>";
}
$amodal=mysql_query("select * from MORDERT where aop='-1'");
while($ai=mysql_fetch_array($amodal))
{
    $intime=$ai['intime'];
    $outtime=$ai['outtime'];
    $lid=$ai['lid'];
    $orderid=$ai['orderid'];
    $oid=$ai['oid'];
    $a=mysql_query("select * from MLIBRARYT where lid='$lid'");
    $e=mysql_fetch_array($a);
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
        echo "<div id='myModal$orderid' class='modal hide fade' style='display:none; overflow:hidden;'>
            <div class='modal-header'>";
            echo "
              <a class='close' data-dismiss='modal'>×</a>
              <h3>Issue Ordered Book</h3>
            </div>
            <div class='modal-body'>";
                if($bookimage==NULL)
            echo "</h2>No Cover Page</h2><br>";
            else
            echo "<img src='../$bookimage' width='100'><br>";
             echo "
             <form action='#' method='post'>
             <h4>$bookid / $bname- by - $bauthor - of - $bedition - by - $bpub </h4>
              <p>Issue Book ?</p>
            </div>
            <div class='modal-footer'>
              <a href='?m=lib_issueorder&issue=$orderid' class='btn btn-primary'>Confirm</a>
              <a href='#' class='btn' data-dismiss='modal'>Close</a>
            </div>
          </div>";
}
?>