<?php
include("../lib/menus.php");
include("../lib/graphs.php");
include("../lib/lib.php");
include("../misc/constants.php");
$subname = $_GET["subname"];
$book = $_GET["book"];
$total = $book;

$tot2 = explode(" ",$total);

$search = getBookImages($tot2,$_GET["subid"],$_GET["i"]);
echo $search;
?>
