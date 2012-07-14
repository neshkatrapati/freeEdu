<html>
<head>
<style type='text/css'>
.posttitle{

	width:100%;
	float:left;
	font-size: 20px;
	font-style: bold;
	padding-bottom: 3px;
	-webkit-border-radius:15px;
	background-color: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,1)), color-stop(50%,rgba(243,243,243,1)), color-stop(51%,rgba(237,237,237,1)), color-stop(100%,rgba(255,255,255,1)));
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#e5e5e5));
}
</style>
</head>
<body>
<?php
  
        require_once '../modules/groups/group.php';
        
               
           
	$g=new Group();
	
	if($_GET["op"]=="delete")
	{
	   $id=$_GET["id"];
	   $g=new Group();
   	   $g->delete($id);
 	   notify("Successfully Deleted!!! :)");	
	}

	$arr=$g->groups_by_object(getCurrentObject());
	echo "<form> <fieldset ><legend><h2>Groups</h2></legend>";

	echo "<center><div><table class='bttable table-bordered'>";
	for($i=0;$i<count($arr);$i++)
	{   
		$id = $arr[$i]["id"];
		echo "<center><tr rowspan='2'>
			<td><div><a href='?m=view_group&id=".$id."'>
			<img src='../".$arr[$i]["imguri"]."' width='50' he
			ight='50'></a></div><br /><div><center><b>".$arr[$i]["name"]."</b></center></div></td>
			</td><div><th><a href='?m=edit_group&id=$id'>EDIT</a></div>
			<th><a href='?m=get_groups&op=delete&id=$id'>DELETE</a></center></th>
                        </tr></center>";
	}
        echo "Number of groups: $i";
	echo "</table></div></center></fieldset>";
	echo "</form>";
        





?>
</body>
</html>