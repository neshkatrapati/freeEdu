<html align="center">
<head>
<script type='text/javascript'>

function printer()
{
  var html="<html>";
   html+= document.getElementById('printarea').innerHTML;
   html+="</html>";

   var printWin = window.open('','','left=0,top=0,width=1,height=1,toolbar=0,scrollbars=0,status  =0');
   printWin.document.write(html);
   printWin.document.close();
   printWin.focus();
   printWin.print();
   printWin.close();
}
</script>

<style type='text/css'>
div1
{
	color:green;
}
div2
{
	color:red;
}
div3
{
	color:blue;
}
div4
{
	background:pink;
}
tr.odd
{
	background-color:#4CC417;
}
tr.even
{
	background-color:cyan;
}

</style>
</head>
<body>
<form action='#' method='post'>
Roll Number: <input type="text" name="srno" /><br><br><br>
<input type="submit" name='retrival'/>&emsp;<a href='' onclick='printer()'>Print</a>
</form>
<div id='php_retival'>
<?php
	echo "<div id='printarea'>";
	if(isset($_POST['retrival']))
	{
		if($_POST['srno']!="")
		{
		  $brid = getBranchFromSrno($_POST['srno']);
		  $obrid = getBranchFilter();
		  if($obrid=='%' || $brid==$obrid)
		  {
		    include("Retrival.php");
		    retrival($srno);
		  }
		  else
		    notifyerr("The Student Does Not Correspond To The Branch Concerned With You!");
		}
		 else
		    notifyerr("Invalid Hall Ticket Number");
	}	
	echo "</div>";
?>
</div>

</body>
</html>
