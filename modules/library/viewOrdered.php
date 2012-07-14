<?php
$oa=$_GET['oa'];
$op=$_GET['op'];
if($op==1 && $oa==0)
{?>
    <ul class="nav nav-tabs">
    <li >
        <a href='?m=lib_viewordered&oa=1&op=0'>Orders Active</a>
    </li>
    <li class="active"> <a href='?m=lib_viewordered&op=1&oa=0'>Orders Passive</a></li>
    </ul>
<?
require_once("../modules/library/pviewOrdered.php");
}
else{
?>
    <ul class="nav nav-tabs">
        <li class="active">
        <a href='?m=lib_viewordered&oa=1&op=0'>Orders Active</a>
    </li>
    <li> <a href='?m=lib_viewordered&op=1&oa=0'>Orders Passive</a></li>
    </ul>
<?
require_once("../modules/library/aviewOrdered.php");
}?>
