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
    <?php if(!isset($_POST["phase1"])){?>
<form method="post" action="#">
    	<textarea id="elm1" name="elm1" rows='200' style="width: 100%">
            <?php
                include("as_lib.php");    
               $asid = $_GET["asid"];
            
               echo getAssignmentContent($asid);
            ?>
	</textarea><br><br>
	<input type="submit" name="phase1" value="Submit" />
	<?php
        echo "<input type='hidden' name='asid' value='".$asid."'>";
        ?>
</form>

<?php
}
else if(isset($_POST["phase1"]))
{
          include("as_lib.php");    
        updateAssignment($_POST["asid"],$_POST["elm1"]);
        notify("Assignment Edited");
        redirect("?m=ass_see&asid=".$_POST["asid"]);
}
?>
</center>
