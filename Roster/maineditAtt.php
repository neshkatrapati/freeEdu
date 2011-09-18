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
            
function showUser(str)
{
if (str=="")
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
xmlhttp.open("GET","../Roster/attNext.php?fac="+str,true);
xmlhttp.send();
}        
</script>
<?php
    echo "<center>";
     echo "<fieldset style='text-align:center;width:700;'>";
        echo "<legend>Edit Attendence</legend>";
        echo "<center>";
    if(!isset($_POST['phase0']) && !isset($_POST['phase1']))
    {
        include("../lib/connection.php");
        echo "<form action='#' method='post'>";
        echo getClassesAsSelect("cls[]","");
        echo "&emsp;Date&emsp;<input type='text' id='inputField' name='date' required=true/>&emsp;<input type='submit' name='phase0' />";
        echo "<br><br><div id='txtHint'>Note : Faculty will be given here</div>";
        
    }
    if(isset($_POST['phase0']))
    {
        $batid=$_POST['batid'];
        $sec=$_POST['sec'];
        $fid=$_POST['fid'];
        $date=$_POST['date'];
        echo "<form action='#' method='post'>";
        echo getMPeriods($batid,$sec,$date,$fid);
        echo "<br><br>";
        echo "<input type='submit' name='phase1' value='Replace'>";
    }
        if(isset($_POST['phase1']))
        {
            include("../lib/connection.php");
            $per=$_POST['per'];
            $per1=$_POST['per1'];
            $aid=$_POST['aid'];
            $aid1=$_POST['aid1'];
            $faculty=mysql_query("select * from MATDT where aid='$aid'");
            $f=mysql_fetch_array($faculty);
            $fac=$f['fid'];
            $faculty1=mysql_query("select * from MATDT where aid='$aid1[$per1]'");
            $f1=mysql_fetch_array($faculty1);
            $fac1=$f1['fid'];
            if($per==null || $per1==null)
            {
                notifyerr("One or more Periods not selected. Try Again");
                redirect("?m=edit_Matt");
            }
            else
            {
                //mysql_query("update MATDT set fid='$fac' where aid='$aid1[$per1]'");
                //mysql_query("update MATDT set fid='$fac1' where aid='$aid'");
                mysql_query("update MATDT set sessionid='$per' where aid='$aid1[$per1]'");
                mysql_query("update MATDT set sessionid='$per1' where aid='$aid'");
                notify("Updated Successfully");
                redirect("?");
            }
        }
    
    echo "</center>";
    echo "</fieldset>";
    echo "</center>";
?>