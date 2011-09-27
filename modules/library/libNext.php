<?php
include("../../lib/lib.php");
include("../../lib/connection.php");
$link=$_GET['link'];
if($link=='ln')
{
    echo "Books:<select name='bk'>";
    $bk=mysql_query("select * from MLIBRARYT");
    while($b=mysql_fetch_array($bk))
    {
        $lid=$b['lid'];
        $bid=$b['bookid'];
        $bname=$b['bname'];
        $bauthor=$b['bauthor'];
        echo "The Books are:";
        echo "<option value='$lid'>$bname-by-$bauthor</option>";
    }
    echo "</select>";
}
else if($link='dln')
{
    echo "Note : Books will be shown here.";
    
}
?>