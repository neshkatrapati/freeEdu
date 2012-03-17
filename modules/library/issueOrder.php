<html>
    <head>
        <script type="text/javascript" src="../modules/library/js/bootstrap-collapse.js"></script>
        <link rel="stylesheet" href="../modules/library/css/bootstrap1.css" type="text/css" media="screen" />
        <script type="text/javascript">
        $(".collapse").collapse();
        </script>
        <link rel="stylesheet" type="text/css" media="all" href="../modules/library/cal/jsDatePick_ltr.min.css" />
		<script type="text/javascript" src="../modules/library/cal/jsDatePick.min.1.3.js"></script>
		<script type="text/javascript">
		window.onload = function(){
        	new JsDatePick({
            	useMode:2,
            	target:"inputField",
            	isStripped:false,
            	dateFormat:"%d-%M-%Y",
            	cellColorScheme:"torqoise"                        
		});
        	new JsDatePick({
            	useMode:2,
            	target:"inputField2",
            	cellColorScheme:"beige",                        
            	dateFormat:"%d-%M-%Y",
            	imgPath:"../aux/calendar/img/"
		});
    		};
		</script>	
        <script type="text/javascript">
        function alert1(a)
        {
            alert(a);
        }
        function showUser(branch,reg,search)
	{
	    if (branch=="" && reg=="" && search=="")
	    {
		document.getElementById("txtHint").innerHTML="Note : Books will be shown here";
		return;
	    }
            else if(branch=="-1" && reg=="-1" && search=="")
            {
		document.getElementById("txtHint").innerHTML="";
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
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		}
	    }
	    xmlhttp.open("GET","../modules/library/issueNext.php?branch="+branch+"&reg="+reg+"&search="+search,true);
	    xmlhttp.send();
	}
        </script>
    </head>
    <body>
        <? include_once("../lib/connection.php"); ?>
        <fieldset>
            <center>
            <legend>Search The Orders</legend>
              <form action='#' method='post'>
                <table cellpadding=12 style="text-align:center;">
                <tr><th>Search By OrderId</th><th>Search By Names</th><th colspan=2>Search By Dates</th></tr>
                <tr><td><input type='text' name='orderid' required=true></td>
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
            <td><input type='text' required='true' name='bookname' autocomplete='off'  data-provide='typeahead' data-items='6' data-source="[<?php for($i=0;$i<$len;$i++)
            if($i<($len-1))
                echo "&quot;$arr[$i]&quot;,";
            else if($i==($len-1))
                echo "&quot;$arr[$i]&quot;";
        ?>]"></td>

                         
            <td>From Date:
            <input type='text' name='from' id='inputField' autocomplete='off' required=true onkeyup='alert1(this.value)'></td>
            <td>To Date:
            <input type='text'  name='to' id='inputField2' autocomplete='off' required=true onkeyup='alert1(this.value)'><br></td></tr></table>
        </form>
            </center>
        </fieldset>
        <br><br>
        <div id='txtHint'><center><h6>Orders will be showed here</h6></center></div>
    </body>
</html>