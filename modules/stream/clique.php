<?php 
	echo "<link href='../aux/bootstrap/css/bootstrap.css' rel='stylesheet' type='text/css'></link>";
	echo "<script src='../aux/bootstrap/js/bootstrap.js' type='text/javascript'></script>";
	echo "<script src='../aux/bootstrap/js/bootstrap-dropdown.js' type='text/javascript'></script>";
	echo "<script>$(\".accordion2\").collapse();$('.dropdown-toggle').dropdown()</script>";
	
	echo "<script>var mobject = ".getCurrentObject().";</script>"
	
	
?>
<?php
	echo "<div class=''>";
	echo "<h1>Create A Clique</h1><br>";
	echo "<center>";
	echo "<table class='table table-bordered'>";
		echo "<tr><td>Name</td><td><input style='width:90%' type='text' name='cname'></input></td></tr>";
		echo "<tr><td>Selector</td><td>"; 
		echo "<input type='text' onkeyup=\"getLists(this.value,'omni')\" id='tbox'>
				</input><br><br>Select By Type :&emsp;".getModifTypes('type[]','onchange=\'getMSelect(this.value)\'')."
					<div id='options'></div>	
						<div id='omni'></div>";
		
	echo "</td></tr>";
	echo "</table>";
	echo "</center>";
	echo "</div>";

?>
