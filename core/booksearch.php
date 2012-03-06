<?php
require_once("../lib/menus.php");
require_once("../lib/graphs.php");
require_once("../lib/lib.php");
require_once("../lib/connection.php");
$subname = $_GET["subname"];
$book = $_GET["book"];
$total = $book;

$tot2 = explode(" ",$total);

$search = getBookImages($tot2,$_GET["subid"],$_GET["i"]);
echo $search;
?>
