<?php
include_once("../../lib/lib.php");
include_once("../../lib/connection.php");
$link=$_GET['link'];
if($link=='dln')
{
    echo "Note : Select Branch and Regulation to Submit a book<br><br><br>";
    echo "<div id='remove'>";
    include_once("branchreg.php");
    echo "</div>";   
}
else if($link=='ln')
{?>
    Books : <input type='text' name='bookname' required='true' autocomplete='off'  data-provide='typeahead' data-items='6' data-source="[<?php
    $bk=mysql_query("select * from MLIBRARYT");
    $bnum=mysql_num_rows($bk);
    $p=0;
    while($b=mysql_fetch_array($bk))
    {
        $p++;
        $lid=$b['lid'];
        $bid=$b['bookid'];
        $bname=$b['bname'];
        $bauthor=$b['bauthor'];
        $edition=$b['bedition'];
        $bpub=$b['bpub'];
        if($p<($bnum-1))
        {
            echo "&quot;$bid / $bname-by-$bauthor-of-$edition-of-$bpub / $lid &quot;";
            echo ",";
        }
        else if($p==($bnum-1))
            echo "&quot;$bname-by-$bauthor-of-$edition-of-$bpub&quot;";
    }

    ?>]">
<?}?>