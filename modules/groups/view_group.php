<html>
<head>
	<title>ViewGroup</title>
	<script type="text/javascript" src="../lib/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
	tinyMCE.init({
    // General options
    mode : "textareas",
    theme : "advanced",
    plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
    
    // Theme options
    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",

    theme_advanced_resizing : true,
    width: "100%",
    
	});
	</script>
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
.imgteaser {
	margin: 0;
	overflow: hidden;
	float: left;
	position: relative;
}
.imgteaser a {
	text-decoration: none;
	float: left;
}
.imgteaser a:hover {
	cursor: pointer;
}

.imgteaser a img {
	float: left;
	margin: 0;
	border: none;
	padding: 10px;
	background: #fff;
	border: 1px solid #ddd;
	position: relative;
	
}
.imgteaser a .desc {	display: none; }
.imgteaser a:hover .epimg { visibility: hidden;}
.imgteaser a .epimg {
	position: absolute;
	right: 10px;
	top: 10px;
	font-size: 12px;
	color: #fff;
	background: #000;
	padding: 4px 10px;
	filter:alpha(opacity=65);
	opacity:.65;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=65)";
	
}
.imgteaser a:hover .desc{
	display: block;
	font-size: 11px;
	padding: 10px 0;
	background: #111;
	filter:alpha(opacity=75);
	opacity:.75;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=75)";
	color: #fff;
	position: absolute;
	bottom: 11px;
	left: 11px;
	padding: 4px 10px;
	margin: 0;
	width: 125px;
	border-top: 1px solid #999;
	
}
.pos
{
	position:absolute;
	top:91px;
	left:350px;
	
}
.form
{
	position:absolute;
	left:410px;	
}

.comment .comment-text {
  border-bottom-color:#D3D7D9;
  border-bottom-style:solid;
  border-bottom-width:1px;
  border-image:initial;
  border-left-color:#D3D7D9;
  border-left-style:solid;
  border-left-width:1px;
  border-right-color:#D3D7D9;
  border-right-style:solid;
  border-right-width:1px;
  border-top-color:#D3D7D9;dude
  border-top-style:solid;
  border-top-width:1px;
  display:table-cell;
  padding-bottom:10px;
  padding-left:25px;
  padding-right:25px;
  padding-top:10px;
  position:relative;
  vertical-align:top;
  width:100%;
}


</style>

</head>
<body>

<?php
require_once '../modules/groups/group.php';
require_once '../modules/groups/post.php';
$id=$_GET['id'];
viewGroup($id);
function viewGroup($oid)
{
     
	$id=$_GET['id'];
	$g=new Group();
	$row = $g -> find($oid);
	echo "<form method='post' accept-charset='UTF-8' enctype='multipart/form-data' align='center'>";
	echo "<fieldset width=500 align=center><legend><h2>".$row['name']."</h2></legend>";
	echo "<table cellpadding='10'>";
   	echo "<tr><td><a href ='?m=view_group&id=".$id."'><img src='../".$row['imguri']."' align=left width='200' height='200'/></a></td>";
    echo "<td><div class=''>Subject :&nbsp;<input type=text name=subject ></div><br />";
    echo "<div class=''>Body :&nbsp;<textarea class='mceSimple' name=post width=300px rows='10' cols='50' ></textarea></div></td>";
    echo "<tr><td><input type=submit name= submit></td></tr>";
    echo "</table></fieldset></form>";
   
	
	if(isset($_POST["submit"]))
    {
		
    	$oid=getCurrentObject();
       	$subject=$_POST["subject"];
    	$post=$_POST["post"];
       	$date = strtotime(date("m.d.y"));

		$p = new Post();
		$p->pcreate($id,$oid,$post,$subject,$date);
	
		notify("Successfully Posted!!!");

		
     }  
    $p=new Post();
  	$arr=$p -> posts_by_group($id); 
  	echo "<div style='margin-left:18%'>";  
    for($i=0;$i<count($arr);$i++)
	{   
		$pid = $arr[$i]["id"];
		$oid = $arr[$i]["object"];
		$date = $arr[$i]["date"];
		$real_date = date("d-M-y h:i:s",$date);
		$object = getObject($oid);

		echo "<center><div class='well'>
			<img style ='float:left' src='../".$object["imguri"]."' width='25' height='25'>".$arr[$i]["subject"]." -- By ".$object["obname"]."
	 		-- On ".$real_date."<hr /><table class='table bordered-table'>
			<tr><td size='30'>
			".$arr[$i]["post"]."

			</td>
            </tr></table></div></center>";
               

	}
      echo "</div>";     	    

  
     echo "Number of Posts: $i"; 

        
    }

?>
</body>
</html>
