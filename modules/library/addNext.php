<html>
    <head>
     </head>
    <body>
        
        <?php
            include_once("../../lib/connection.php");
            $branch=$_GET['branch'];
            $reg=$_GET['reg'];
            $j=$_GET['j'];
            if($branch!=-1 && $reg!=-1)
            {
                $sub=mysql_query("select * from SAVAILT where regid='$reg' && brid='$branch'") or die(mysql_error());
            }
            else if($branch==-1 && $reg!=-1)
            {
                $sub=mysql_query("select * from SAVAILT where regid='$reg'") or die(mysql_error());
            }
            else if($branch!=-1 && $reg==-1)
            {
                $sub=mysql_query("select * from SAVAILT where brid='$branch'") or die(mysql_error());
            }
            
            
            while($sub_list=mysql_fetch_array($sub))
            {
                $subid=$sub_list['subid'];
                $subid_list=mysql_query("select * from MSUBJECTT where suid='$subid'") or die(mysql_error());
                while($s=mysql_fetch_array($subid_list))
                {
                    $subject=$s['subname'];
                    $arr[]=strtoupper($subject);
                }
            }
            $len=count($arr);?>
            <br>Select a Subject:<input type='text' required='true' name='bookname<?php echo $j ?>' autocomplete='off'  data-provide='typeahead' data-items='6' data-source="[<?php for($i=0;$i<$len;$i++)
            if($i<($len-1))
                echo "&quot;$arr[$i]&quot;,";
            else if($i==($len-1))
                echo "&quot;$arr[$i]&quot;";
        ?>]">
        <br>
    </body>
</html>




