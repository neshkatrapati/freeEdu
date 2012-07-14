<html>
<head>
	<script type=text/css>


	</script>
</head>
<body>
<?php



?>

<body>

	<form method='post' accept-charset='UTF-8' enctype='multipart/form-data' align='center'>
		<fieldset>
		<legend><h2>Edit Group</h2></legend>
		<ul>
			<li>New Group Name : <input type='text' name='name' id='name' maxlength="50" required='true'/></li>
			<li>New Image : <input type='file' name='img'></li>
			<li>New Members : <select data-placeholder="Choose a Person..." class="chzn-select" multiple style="height:100%;width:350px;" tabindex="4" name='mem[]'><?php echo getAllObjectsAsSelect();?></select></li>
			<li> <input type='submit' name='submit' value='Submit' /></li>	
		</ul>
		</fieldset>
	</form>
</body>
</html>