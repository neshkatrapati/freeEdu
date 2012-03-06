<html>
<link rel="stylesheet" type="text/css" media="all" href="../aux/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../aux/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField1",
			limitToToday:true,
			dateFormat:"%d-%M-%Y",
			imgPath:"../aux/calendar/img/"
			
		});
                new JsDatePick({
			useMode:2,
			target:"inputField2",
			limitToToday:true,
			dateFormat:"%d-%M-%Y",
			imgPath:"../aux/calendar/img/"
			
		});
	};
</script>
<?php

echo "<fieldset><legend>Consolidated Report</legend><center><form action='#' method='post'>Select Class: ";
echo getClassesAsSelect("cls","");
echo "&emsp;From-Date: <input type='text' id='inputField1' name='datein' />To-Date: <input type='text' id='inputField2' name='dateout'></input><input type='submit' name='phase1'><br /></form>";
if(isset($_POST['phase1']))
{
	$bat = $_POST['cls'];
	
	$batdet = explode(":",$_POST['cls']);
	$batid = $batdet[0];
	$sec = $batdet[1];
	
	$datein = $_POST["datein"];
        $dateout = $_POST['dateout'];
	$in=strtotime($datein);
	$out=strtotime($dateout);
	if($in<$out)
	{
        	echo getConReport($batid,$sec,strtotime($datein),strtotime($dateout));
	}
	else
	{
		notifyerr("Not A Valid In And Out Time");
	}

	echo "</center></fieldset>";
	
}
?>
</html>
