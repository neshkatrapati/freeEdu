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

<?php
    $sec='A';
    $batid='1';
    $date='01-SEP-2011';
    $sujid='61';
    echo "<center>";
    echo "<fieldset style='text-align:center;width:600;'>";
    echo "<legend>Edit Attendence</legend>";
    if(!isset($_POST['phase0']) && !isset($_POST['phase1']))
    {
        
        echo "<center>";
        echo "<form action='#' method='post'>";
        $object = getObject($_COOKIE["object"]);
        echo "Select Class:&emsp;".getFacClasses("cls[]",$object["obhandle"],"")."&emsp;Date:&emsp;";
        echo "<input type='text' id='inputField'></input>";
        echo "<br><br>";
        echo "<input type='submit' name='phase0' value='Replace'>";
        echo "</center>";
        
    }
    if(isset($_POST['phase0']))
    {
      
        //echo "<center>";
        $main = $_POST['cls'][0];
        $clsmain = explode(':',$main);
        $cldet = $clsmain[0];
        $subid = $clsmain[1];
        $batid = substr($cldet,0,1);
        $sec = substr($cldet,-1);
        $fid = $_POST['fid'];
        $date = $_POST['date'];
    
        echo "<form action='#' method='post'>";
        echo getMPeriods($batid,$sec,$date,$subid);
        echo "<br><br>";
        echo "<input type='submit' name='phase1' value='Replace'>";
        echo "</center>";
    }
    if(isset($_POST['phase1']))
    {
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
            echo("One or more Periods not selected");
            notifyerr("One or more Periods not selected. Try Again");
        }
        else
        {
            //mysql_query("update MATDT set fid='$fac' where aid='$aid1[$per1]'");
            //mysql_query("update MATDT set fid='$fac1' where aid='$aid'");
           mysql_query("update MATDT set sessionid='$per' where aid='$aid1[$per1]'");
            mysql_query("update MATDT set sessionid='$per1' where aid='$aid'");
            
            
        }
    }
    echo "</center>";
    echo "</fieldset>";
    echo "</center>";
?>