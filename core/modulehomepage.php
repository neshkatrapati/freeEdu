<?php
	$object = getObject(getCurrentObject());
	$modtag = $_GET["modtag"];
	$menus = getMenuItems(getObjectTypeTag($object["otyid"]),$modtag);

	for($i=0;$i<count($menus);$i++){
		echo "<div class='well'><a href='".$menus[$i]["link"]."'>".$menus[$i]["title"]."</a></div>";
	}

?>
