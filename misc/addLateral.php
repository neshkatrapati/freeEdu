<html>
<head>

</head>
<body>
    <fieldset>
    	<legend>Choose Batch For Analysis</legend>
   
        <?php
        include("../lib/lib.php");
	include("constants.php");
        include("../lib/connection.php");
        echo "<center>";
	echo "<form action='#' method='post' >";
        $placeBranch = "";
	$placeBranch = getBatches('bat[]');
	echo "Select A Batch:".$placeBranch;
	echo "<input type='submit' name='submit' value='submit'/>";
        ?>
    </form>
    </fieldset>
    </center>
</body>
</html>