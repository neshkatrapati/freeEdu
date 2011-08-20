<html>
<link rel="stylesheet" type="text/css" media="all" href="../aux/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../aux/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			limitToToday:true,
			dateFormat:"%d-%M-%Y",
			imgPath:"../aux/calendar/img/"
			
		});
	};

</script>
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
<?php

echo "<fieldset><center><legend>Day Report</legend><form action='#' method='post'>";
echo getClassesAsSelect("cls[]","");
echo "<input type='text' id='inputField' name='date' /><br><br /><select name='bunk[]'><option value='0'>Standard</option><option value='1'>Partially Present</option><option value='2'>Any Absentees</option></select><input type='submit' name='phase1'><br /><a href='' onclick='printer()'>Print</a></form>";
echo "<div id='printarea'>";
if(isset($_POST['phase1']))
{
	
	$batdet = explode(":",$_POST['cls'][0]);
	$batid = $batdet[0];
	$sec = $batdet[1];
	$date = $_POST["date"];
	$bunk = $_POST['bunk'][0];
	 echo " <div id='placeholder' style='width:500px;height:300px'></div>
    <p id='hoverdata'> <span id='clickdata'></span></p>";
	echo getDayReport($batid,$sec,strtotime($date),$bunk);
		
}
echo "</print></center></fieldset>";
?>
</html>
