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
    echo "<center>";
    echo "<fieldset style='text-align:center;width:1100;'>";
    echo "<legend>Edit Attendence</legend>";
<<<<<<< HEAD

=======
>>>>>>> c0bd1722c15507956aa216ce9600cf691f9f860d
    echo "<center>";
    if(!isset($_POST['phaseminus1']) && !isset($_POST['phase4']) && !isset($_POST['phase0']) && !isset($_POST['phase1']) && !isset($_POST['phase2']) && !isset($_POST['phase3']))
    {
        
        echo "<form action='#' method='post'>";
        echo getClassesAsSelect("cls[]","");
        echo "&emsp;Date&emsp;<input type='text' id='inputField' name='date'/>&emsp;<input type='submit' name='phaseminus1' />";
        
        
    }
    if(isset($_POST['phaseminus1']))
    {

    $xyz = explode(":",$_POST['cls'][0]);
    $batid = $xyz[0];
    $sec = $xyz[1];
    $date = $_POST["date"];
    $f = getObject($_COOKIE["object"]);
    $fid = $f["obhandle"];
    echo "<form action='#' method='post'>";
    echo getSubPeriods($batid,$sec,$date,$fid);
    echo "<br><br>";
    echo "<input type='hidden' name='batid' value='$batid'>";
    echo "<input type='hidden' name='date' value='$date'>";
    echo "<input type='hidden' name='fid' value='$fid'>";
    echo "<input type='hidden' name='sec' value='$sec'>";
    echo "<input type='submit' name='phase1' value='Edit'>";
    }
    if(isset($_POST['phase1']) && !isset($_POST['phase2']))
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
        include("../lib/connection.php");
        $date = strtotime($date);
        $per=$_POST['per'];
        $batid=$_POST['batid'];
        $sec=$_POST['sec'];
        $fid=$_POST['fid'];
        $date=$_POST['date'];
        echo "<form action='#' method='post' align='center'>";
        echo "<input type='hidden' name='batid' value='$batid'>";
        echo "<input type='hidden' name='date' value='$date'>";
        echo "<input type='hidden' name='fid' value='$fid'>";
        echo "<input type='hidden' name='sec' value='$sec'>";
        echo "<input type='hidden' name='per' value='$per'>";
        $student=mysql_query("select * from MSTUDENTT where batid='$batid'");
        $rows=mysql_num_rows($student);
        echo "<div align='center'>";
        echo "<center>";
        notifywar("! The students Present are Checked.Please Make your changes !");
        while($s=mysql_fetch_array($student))
        {
            $srno=$s[1];
            $sid=$s[0];
            $sname=$s[2];
            $imgid=$s[5];
            $image=mysql_query("select * from MIMGT where imgid='$imgid'");
            while($img=mysql_fetch_array($image))
            {
            	$imguri="../".$img[1];
            }
            $oidsql = mysql_query("SELECT oid from MOBJECTT where obhandle='".$srno."' and otyid='0'");
            $rarray = mysql_fetch_array($oidsql);
            $oid = $rarray['oid'];
            
            $a=mysql_query("select * from MATDT where sec='$sec'and fid='$fid' and batid='$batid' and sessionid='$per'");
            $att=mysql_fetch_array($a);
            $aid=$att['aid'];
            $sa=mysql_query("select * from ADATAT where aid='$aid'");
            $as=mysql_fetch_array($sa);
            $adata=$as['adata'];
            $pa=$as['pa'];
            $satt=explode('.',$adata);
             
            echo "<div class='img'>";
            if($pa=='P')
            {
              
           
            if(in_array($sid,$satt))
            {
           echo"<img src='".$imguri."' width='50' height='50' style='opacity:0.7;filter:alpha(opacity=40)'
                  onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
        	onmouseout='this.style.opacity=0.7;this.filters.alpha.opacity=60'>
                <div class='desc'><b><font color=#000000>$srno</b><br /><b></font>
                <font color=#000000>".getFname($s['sname'])."</b></font><input type='checkbox' name='chk[]' value=$srno checked/></div></div></a>";
            }
            else
            {
                echo"<img src='".$imguri."' width='50' height='50' style='opacity:0.7;filter:alpha(opacity=40)'
                  onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
        	onmouseout='this.style.opacity=0.7;this.filters.alpha.opacity=60'>
                <div class='desc'><b><font color=#000000>$srno</b><br /><b></font>
                <font color=#000000>".getFname($s['sname'])."</b></font><input type='checkbox' name='chk[]' value=$srno unchecked/></div></div></a>";
                
            }
            }
            else if($pa=='A')
            {
                if(in_array($sid,$satt))
            {
           echo"<img src='".$imguri."' width='50' height='50' style='opacity:0.7;filter:alpha(opacity=40)'
                  onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
        	onmouseout='this.style.opacity=0.7;this.filters.alpha.opacity=60'>
                <div class='desc'><b><font color=#000000>$srno</b><br /><b></font>
                <font color=#000000>".getFname($s['sname'])."</b></font><input type='checkbox' name='chk[]' value=$srno unchecked/></div></div></a>";
            }
            else
            {
                echo"<img src='".$imguri."' width='50' height='50' style='opacity:0.7;filter:alpha(opacity=40)'
                  onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
        	onmouseout='this.style.opacity=0.7;this.filters.alpha.opacity=60'>
                <div class='desc'><b><font color=#000000>$srno</b><br /><b></font>
                <font color=#000000>".getFname($s['sname'])."</b></font><input type='checkbox' name='chk[]' value=$srno checked/></div></div></a>";
                
            }
            
            }
        }
        
         echo "<br><br><input type='submit' name='phase2'><br><br>";
           
    }
    if(isset($_POST['phase2']) && !isset($_POST['phase3']))
    {
        include("../lib/connection.php");
        $chk=$_POST[chk];
        $len=count($chk);
        $per=$_POST['per'];
        $sec=$_POST['sec'];
        $batid=$_POST['batid'];
        $fid=$_POST['fid'];
        $a=mysql_query("select * from MATDT where sec='$sec'and fid='$fid' and batid='$batid' and sessionid='$per'");
        $att=mysql_fetch_array($a);
        $aid=$att['aid'];
        echo "<center>";
       echo "<h4>Please confirm the Attendence</h4>";
        if($per='P')
            echo "<h4>The students present are</h4>";
        else if($per='A')
            echo "<h4>The students Absent are</h4>";
       
        for($i=0;$i<$len;$i++)
        {
            $student=mysql_query("select * from MSTUDENTT where srno='$chk[$i]'");
            $stu=mysql_fetch_array($student);
            $sname=$stu['sname'];
            if($i<($len-1))
               $sid=$sid.$stu['sid'].'.';
            else
                $sid=$sid.$stu['sid'];
            $stuimg=mysql_query("Select imgid from MSTUDENTT where srno='$chk[$i]' ");
            $simg=mysql_fetch_array($stuimg);
            $img=mysql_query("select * from MIMGT where imgid='$simg[imgid]'");
            $imguid=mysql_fetch_array($img);
            $imguri="../".$imguid['imguri'];
            echo "<div class='img'>";
             echo"<img src='".$imguri."' width='50' height='50' style='opacity:0.7;filter:alpha(opacity=40)'
                  onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
        	onmouseout='this.style.opacity=0.7;this.filters.alpha.opacity=60'>
                <div class='desc'><b><font color=#000000>$srno</b><br /><b></font>
                <font color=#000000>$chk[$i].<br>$sname</b></font></div></div>";
        }
         
         
            echo "<form action='#' method='post'>";
            echo "<input type='hidden' name='sid' value='$sid'>";
            echo "<input type='hidden' name='aid' value='$aid'>";
            echo "<br><br><br><input type='submit' value='Confirm' name='phase3'>";
           echo "<input type='submit' value='Back' name='back'>";
            
    }
    if(isset($_POST['back']))
            {
               redirect("?m=edit_att");
            }
        if(isset($_POST['phase3']))
       {
           $sid=$_POST['sid'];
           $aid=$_POST['aid'];
          
           mysql_query("update ADATAT set adata='$sid',pa='P' where aid='$aid'");
           notify("Editing Successfully Done");
           redirect("?");
        }    
   
    echo "</center>";
    echo "</fieldset>";
    echo "</center>";
?>