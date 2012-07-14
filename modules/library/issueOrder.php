<html>
    <head>
        <script type="text/javascript" src="../modules/library/js/bootstrap-collapse.js"></script>
        <link rel="stylesheet" href="../modules/library/css/bootstrap1.css" type="text/css" media="screen" />
          <link rel="stylesheet" href="../modules/library/libStyle.css" type="text/css" media="screen" />
        <script type="text/javascript" src="../modules/library/js/bootstrap-modal.js"></script>
        <script type="text/javascript" src="../modules/library/js/bootstrap-alert.js"></script>   
        <script type="text/javascript">
        $(".collapse").collapse();
        </script>
        <script type="text/javascript">
        function alert1(a)
        {
            alert(a);
        }
        function showUser(orderid,bookname,ba,bp)
	{
	    if (orderid=="" & bookname=="")
	    {
		document.getElementById("txtHint").innerHTML="<center><h6>Note : Books will be shown here</h6></center>";
		return;
            }
	    if (window.XMLHttpRequest)
	    {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	    }
	    else
	    {// code for IE6, IE5
	      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	    }
	    xmlhttp.onreadystatechange=function()
	    {
		if (xmlhttp.readyState==4 & xmlhttp.status==200)
		{
		    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		}
	    }
	    xmlhttp.open("GET","../modules/library/issueNext.php?o="+orderid+"&b="+bookname+"&ba="+ba+"&bp="+bp,true);
	    xmlhttp.send();
	}
        </script>
    </head>
    <body>
        <?php
         require_once("../lib/connection.php");
        $return=$_GET['return'];
        $issue=$_GET['issue'];
        if($return!=NULL)
        {
            $c=mysql_query("select * from MORDERT where orderid='$return' and aop='a'");
            $cnum=mysql_num_rows($c);
            if($cnum!=0)
            {
                $aouttime=strtotime(date('m/d/y'));
                mysql_query("update MORDERT set aop='p',aouttime='$aouttime' where orderid='$return'");
                
                ?>
                <div class="alert fade in">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <center>Returned Order Updated Successfully</center></div>  
            
            <?}
            else
            {?>
             <div class="alert alert-block alert-error fade in">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                           <center>Invalid Option</center></div>
            <?}
        }
        elseif($issue!=NULL)
        {
           
            $c=mysql_query("select * from MORDERT where orderid='$issue' and aop='-1'") or die(mysql_error());
            $cnum=mysql_num_rows($c);
            if($cnum!=0)
            {
                 $intime=strtotime(date('m/d/y'));
                 $outtime=strtotime(date('m/d/y', strtotime(date('m/d/y'))) . "+1 month");
                mysql_query("update MORDERT set aop='a',intime='$intime', outtime='$outtime' where orderid='$issue'")or die(mysql_error());
                ?>
                <div class="alert fade in">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <center>Issue Order Successfully. Book Should be retuned on <? echo date('d/m/y',$outtime)?></center></div>  
                
            <?}
             else
            {?>
             <div class="alert alert-block alert-error fade in">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                          <center> Invalid Option</center></div>
            <?}
        }
        $ba=$_GET['ba'];
        $bp=$_GET['bp'];
        ?>
        <?if($bp==1)
        {?>
            <ul class="nav nav-tabs">
             <li >
                <a href='?m=lib_issueorder&ba=1&bp=0'>Orders Active</a>
             </li>
             <li class="active"> <a href='?m=lib_issueorder&bp=1&ba=0'>Orders Passive</a></li>
            </ul>
            <?}
              else{
            $ba=1;
            $bp=0;
            ?>
            <ul class="nav nav-tabs">
             <li class="active">
                <a href='?m=lib_issueorder&ba=1&bp=0'>Orders Active</a>
             </li>
             <li> <a href='?m=lib_issueorder&bp=1&ba=0'>Orders Passive</a></li>
            </ul>
        <? }?>
        </center><br><br>
        <fieldset>
            <center>
            <legend>Search The Orders</legend>
              <form action='#' method='post'>
                <table cellpadding=12 style="text-align:center;">
                <tr><th>Search By OrderId</th><th>Search By Book Names</th></tr>
                <tr><td><? echo "<input type='text' name='orderid' required='true' onkeyup='showUser(this.value,bookname.value,$ba,$bp)'>"; ?></td>
              <?
         $sub=mysql_query("select * from MLIBRARYT") or die(mysql_error());
            while($sub_list=mysql_fetch_array($sub))
            {
                   $bookid=$sub_list['bookid'];
                    $bname=$sub_list['bname'];
                    $bauthor=$sub_list['bauthor'];
                    $bpub=$sub_list['bpub'];
                    $bedition=$sub_list['bedition'];
                    $arr[]="$bookid/$bname-by-$bauthor-of-$bpub-of-$bedition";
            }
            $len=count($arr);?>
            <td><? echo "<input type='text' required='true' name='bookname' autocomplete='off' onkeyup='showUser(orderid.value,this.value,$ba,$bp)'>"; ?></td>
            </tr></table>
        </form>
            </center>
        </fieldset>
        <br><br>
        <div id='txtHint'><center><h6>Orders will be showed here</h6></center></div>
    </body>
</html>
