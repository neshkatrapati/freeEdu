<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<fieldset>
    <legend>Create An Assignment</legend>
    <center>
<?php
    include_once("as_lib.php");
    if(!isset($_POST['phase1']) && !isset($_POST['phase2']))
    {
        echo "<form action='#' method='post'>";
        $object = getObject($_COOKIE["object"]);
	if($object["otyid"] == "1"){
	    echo "Select A Class :".getFacClasses("cls[]",$object["obhandle"],"")."<br><br>";
	    echo "<input type='hidden' name='type' value='1'>";
	}
	if($object["otyid"] == "3")
	{
	    echo "Select A Class :".getClassesAsSelect("cls[]")."<br><br>";
	    echo "<input type='hidden' name='type' value='3'>";
	}
	    
        echo "Name Of Assignment: <input type='text' name='docname'></input>";
        echo "&emsp;<input type='submit' name='phase1'></input>";
        echo "</form>";
    }

?>
</center>
<?php if(isset($_POST['phase1'])) { ?>
<script type="text/javascript" src="../lib/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "css/word.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "../lib/tinymce/examples/lists/template_list.js",
		external_link_list_url : "../lib/tinymce/examples/lists/link_list.js",
		external_image_list_url : "../lib/tinymce/examples/lists/image_list.js",
		media_external_list_url : "../lib/tinymce/examples/lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->

</head>
<body>
<center>
<form method="post" action="#">
    	<textarea id="elm1" name="elm1" rows='30' style="width: 100%">
            <?php
		if($_POST["type"]==1)
		{
		    $main = $_POST['cls'][0];
		    $clsmain = explode(':',$main);
		    $cldet = $clsmain[0];
		    $subid = $clsmain[1];
		    $batid = substr($cldet,0,1);
		    $sec = substr($cldet,-1);
		    $suba = getSubject($subid);
		    $batch = getBatchFromId($batid);
		    $class = $batch["brname"]." ".getFullClass($batch["akayr"]+1)." ".$sec;
		    $object = getObject($_COOKIE["object"]);
		    $facname = $object["obname"];
    
		    echo "<center><h2>".$_POST["docname"]."-".$suba["subname"]."</h2>
				    <h3>Class:&emsp;".$class."</h3><div style='text-align:right;'>
				    <h3>Created By<br>".$facname."</h3></div></center>";
		}
		else
		{
		    $main = $_POST['cls'][0];
		    $clsmain = explode(':',$main);
		    $batid = $clsmain[0];
		    $sec = $clsmain[1];
		    $batch = getBatchFromId($batid);
		    $class = $batch["brname"]." ".getFullClass($batch["akayr"]+1)." ".$sec;
		    $object = getObject($_COOKIE["object"]);
		    $facname = $object["obname"];
		    
		     echo "<center><h2>".$_POST["docname"]."</h2>
				    <h3>Class:&emsp;".$class."</h3><div style='text-align:right;'>
				    <h3>Created By<br>".$facname."</h3></div></center>";
		    
		}
		    
            ?>
	</textarea><br><br>
	
        <?php
		 
		 echo "<input type='hidden' name='docname' value ='".$_POST["docname"]."' />";
		 echo "<input type='hidden' name='batid' value ='".$batid."' />";
		 echo "<input type='hidden' name='sec' value ='".$sec."' />";
		 if($_POST["type"] == 1)
		    echo "<input type='hidden' name='subid' value ='".$subid."' />";
		if($_POST["type"] == 3)
		    echo "<input type='hidden' name='subid' value ='' />";
	?>
	<input type="submit" name="phase2" value="Submit" />
	
</form>
</center>
<?php }
if(isset($_POST["phase2"])){
    $docname = $_POST["docname"];
    $batid = $_POST["batid"];
    $sec = $_POST["sec"];
    $subid = $_POST["subid"];
    $asid = putAssignment($docname,$_COOKIE["object"],$batid,$sec,$subid,$_POST["elm1"]);

    notify("Assignment Created! See it <a href=?m=ass_see&asid=".$asid.">Here</a> ");
   // redirect("?m=ass");
    }?>
</body>
</fieldset>
</html>
