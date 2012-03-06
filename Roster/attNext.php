<?php
include_once("../lib/connection.php");
$fac=$_GET['fac'];
$fac1=explode(":",$fac);
$batid1=$fac1[0];
$sec1=$fac1[1];
if($fac!='null')
{
    $arr=explode(":",$fac);
    echo "<input type='hidden' name='batid' value='$batid1'>";
    echo "<input type='hidden' name='sec' value='$sec1'>";
    echo "Select Faculty : <select name='fid'>";
    echo "<option value='null'>--Faculty--</option>";
    $f=mysql_query("select * from MFACULTYT where fcourse like '%$batid1$sec1%'");
    while($f1=mysql_fetch_array($f))
    {
        $fid=$f1['fid'];
        $fname=$f1['fname'];
        echo "<option value='$fid'>$fname</option>";
    }
}
?>