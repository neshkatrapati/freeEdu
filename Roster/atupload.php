<style>
.num
{
	width : 5%;
}
</style>
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
<fieldset>
    <legend>Upload Attendance</legend>
    <center>
<?php
//The UI Part
if(array_key_exists("err",$_GET))
{
    notifywar("You Have Rejected Your Selection. Please Start The Process Again!");
    
}
if(!isset($_POST['phase1']) && !isset($_POST['phase2']) && !isset($_POST['phase3']) && !isset($_POST['confirm']) && !isset($_POST['reject']))
{
    echo "<form action='#' method='post'>";
    $array = getObject($_COOKIE['object']); 
    $classes = getFacClasses("cls[]",$array['obhandle'],"");
    echo " Select Class : ".$classes."<br />";
    echo "<br />Select Date: <input type='text' name='date' id='inputField' required=true></input><br />";
   
    echo "<input type='hidden' name='fid' value='".$array['obhandle']."' />";
    echo "<br /><input type='submit' name='phase1' /  ></form>";
}
elseif(isset($_POST['phase1']))
{
    $main = $_POST['cls'][0];
    $clsmain = explode(':',$main);
    $cldet = $clsmain[0];
    $subid = $clsmain[1];
    $batid = substr($cldet,0,1);
    $sec = substr($cldet,-1);
    $fid = $_POST['fid'];
    $date = $_POST['date'];
    echo "<form action='#' method='post'>";
    echo "<input type='hidden' name='fid' value='".$fid."' />";
    echo "<input type='hidden' name='date' value='".$date."' />";
    echo "<input type='hidden' name='batid' value='".$batid."' />";
    echo "<input type='hidden' name='sec' value='".$sec."' />";
    echo "<input type='hidden' name='subid' value='".$subid."' />";
    
    echo "<fieldset style='width: 200px'><legend>Select Periods:</legend>".getPeriods($batid,$sec,$date)."</fieldset><br />";
    echo "<input type='submit' name='phase2' /></form>";
   //echo "batid: ".$batid." sec:".$sec." subid:".$subid." fid:".$fid." ".$date;
    
}
elseif(isset($_POST['phase2']))
{
    
    
    $batid = $_POST['batid'];
    $batsec = $_POST['sec'];
    $subid = $_POST['subid'];
    $date = $_POST['date'];
    $fid = $_POST['fid'];
    $query = "SELECT *,(SELECT imguri from MIMGT i WHERE i.imgid=s.imgid) as imguri FROM MSTUDENTT s WHERE batid LIKE '".$batid."' AND sec LIKE '".$batsec."'";
    $result = mysql_query($query);
    echo "<form action='#' method='post'>";
    $imp = implode(":",$_POST['per']);
    echo "<input type='hidden' value='".$imp."' name='perstr'>";
    echo "<input type='hidden' name='batid' value='".$batid."'></input>";
    echo "<input type='hidden' name='sec' value='".$batsec."'></input>";
    echo "<input type='hidden' name='subid' value='".$subid."'></input>";
    echo "<input type='hidden' name='date' value='".$date."'></input>";
     echo "<input type='hidden' name='fid' value='".$fid."' />";
    echo "<input type='radio' value='P' name='pora' checked='true'>Present</input><input type='radio' value='A' name='pora'>Absent</input>&emsp;<input type='submit' name='phase3'></input>";
    echo "<div id='people' style='margin:40px;'>";
    
    while($row = mysql_fetch_array($result))
    {
        
        $sql = "SELECT oid from MOBJECTT WHERE obhandle like '".$row['srno']."' AND otyid='0'";
        $getSql = queryMe($sql);
        $oid = $getSql['oid'];
        echo "<a href='?m=p&id=".$oid."'>";	
        echo "<div class='img'>";
        echo "<img src='../".$row['imguri']."' width='75' height='75' style='opacity:0.4;filter:alpha(opacity=40)'
	  	onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
  		onmouseout='this.style.opacity=0.4;this.filters.alpha.opacity=20'></a>
		<div class='desc'><b><font color=#000000>".getFname($row['sname'])."</font></b><br><b><font color=#000000>".$row['srno']."</b></font>
                <input type='checkbox' name='ppl[]' value='".$row['sid']."'></div></div>";
    }
    echo "</div></form>";
    
}
elseif(isset($_POST['phase3']))
{
    
    $ppl = $_POST['ppl'];
    $pora = $_POST['pora'];
    $batid = $_POST['batid'];
    $sec = $_POST['sec'];
    $subid = $_POST['subid'];
    $date = $_POST['date'];
    $fid = $_POST['fid'];
    $perstr = $_POST['perstr'];
    echo "<fieldset><legend>Confirm Attendance</legend><center><form action='#' method='post'><div align='center'>";
    if($pora == "P")
        echo "<h3>Students Present</h3>";
    else
        echo "<h3>Students Absent</h3>";
    for($i=0;$i<count($ppl);$i++)
    {
        $query = "SELECT *,(SELECT imguri from MIMGT i WHERE i.imgid=s.imgid) as imguri FROM MSTUDENTT s WHERE sid LIKE '".$ppl[$i]."'";
        $row = queryMe($query);	
        echo "<div class='img'>";
        echo "<img src='../".$row['imguri']."' width='75' height='75' style='opacity:0.4;filter:alpha(opacity=40)'
	  	onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
  		onmouseout='this.style.opacity=0.4;this.filters.alpha.opacity=20'>
		<div class='desc'><b><font color=#000000>".$row['sname']."</font></b><br><b><font color=#000000>".$row['srno']."</b></font>
                </div></div>";
    }
    foreach($ppl as $roll)
    {
        $string .= $roll.".";
    }
    $putstr  = substr($string,0,-1);
    echo "<input type='hidden' value='".$perstr."' name='perstr' />";
    echo "<input type='hidden' value='".$putstr."' name='str' />";
    echo "<input type='hidden' name='batid' value='".$batid."'></input>";
    echo "<input type='hidden' name='sec' value='".$sec."'></input>";
    echo "<input type='hidden' name='subid' value='".$subid."'></input>";
    echo "<input type='hidden' name='date' value='".$date."'></input>";
    echo "<input type='hidden' name='fid' value='".$fid."' />";
     echo "<input type='hidden' name='pora' value='".$pora."' />";
    echo "<input type='submit' name='confirm' value='Confirm'/>";
    echo "<input type='submit' name='reject' value='Reject'/>";
    
    echo "</div></center></form></fieldset>";
}
elseif(isset($_POST['confirm']))
{
    $str = $_POST['str'];
    $pora = $_POST['pora'];
    $batid = $_POST['batid'];
    $sec = $_POST['sec'];
    $subid = $_POST['subid'];
    $date = $_POST['date'];
    $fid = $_POST['fid'];
    $perstr = $_POST['perstr'];
   // echo  $batid." SEC:".$sec." SUB:".$subid." FAC:".$fid." P/A:".$pora." String:".$str." Perstr:".$perstr;
    recAtt($batid,$sec,$str,$pora,$subid,$fid,$perstr,strtotime($date));
    notify("Attendance Uploaded Succesfully!!");
	 redirect("?m=ua");
}
elseif(isset($_POST['reject']))
{
    
    
    redirect("?m=ua&err=t");
}

?>
</center>
</fieldset>
