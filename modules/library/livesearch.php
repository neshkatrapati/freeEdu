<?php
$q=$_GET["q"];
$branch=$_GET['branch'];
$reg=$_GET['reg'];
echo "$branch $reg $q";
/*
$stu=mysql_query("select * from MSTUDENTT where srno like'$q%'");
if (strlen($q)>0)
{
    $hint="";
    while($s=mysql_fetch_array($stu))
    {
        $hint=$s['srno'];
        echo $s['srno'];
    }
    
    if ($hint=="")
  {
  $response="no suggestion";
  }
else
  {
    $hint=$hint ."<br>";
 // $response=$hint;
  }

//output the response
echo $hint; 

} */
?>