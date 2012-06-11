<html>
<head>
</head>
<body>
<?php

function getBranch($brid)
{
    include('../lib/connection.php');
    $br=mysql_query("select brname from MBRANCHT where brid='$brid'");
    $branch=mysql_fetch_array($br);
    $brname=$branch['brname'];
    return $brname;
}
function getReg($id)
{
    include('../lib/connection.php');
    $rg=mysql_query("select * from MREGT where regid='$id'");
    $reg=mysql_fetch_array($rg);
    $regname=$reg['regname'];
    return $regname;
}
function getYear($id)
{
    if($id==0)
        return "1st Year";
    else if($id==1)
        return "2nd-Year 1st-Sem";
    else if($id==2)
        return "2nd-Year 2nd-Sem";
    else if($id==3)
        return "3rd-Year 1st-Sem";
    else if($id==4)
        return "3rd-Year 2nd-Sem";
    else if($id==5)
        return "4th-Year 1st-Sem";
    else if($id==6)
        return "4th-Year 2nd-Sem";
}
?>
</body>
</html>