<?php if($_GET["render"] == ""){?>
<script type='text/javascript'>
window.location = "main/";
</script>
<?php }?>
<?php
require_once 'lib/connection.php';
require_once 'lib/lib.php';
require_once 'lib/classes.php';
	
	require_once 'render/json.php';
?>
