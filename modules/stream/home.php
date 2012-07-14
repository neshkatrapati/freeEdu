<?php 
	echo "<link href='../aux/bootstrap/css/bootstrap.css' rel='stylesheet' type='text/css'></link>";
	echo "<script src='../aux/bootstrap/js/bootstrap.js' type='text/javascript'></script>";
	echo "<script src='../aux/bootstrap/js/bootstrap-dropdown.js' type='text/javascript'></script>";
	echo "<script>$(\".accordion2\").collapse();$('.dropdown-toggle').dropdown()</script>";
	
	echo "<script>var mobject = ".getCurrentObject().";</script>"
	
	
?>
<style>
	
	li {
		
		list-style:none;
		
	}
	
</style>
<script src='../modules/stream/timers.js'></script>
<script>
	function post(object){
		var el = document.getElementById("msg");
		
		if (window.XMLHttpRequest)
		{
			xmlhttp=new XMLHttpRequest();
		}
		xmlhttp.onreadystatechange=function()
		{
		
			if(xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			
				el.value = "Whats On Your Mind?";
		
			
			}	
		}
		var string = "../modules/stream/handler.php?mode=post&msg="+el.value+"&object="+object+"&targets=*";
		
		xmlhttp.open("GET",string,true);
		xmlhttp.send();

	}
	 window.setInterval(function() {
		var el = document.getElementById("stream");
		if (window.XMLHttpRequest)
		{
			xmlhttp=new XMLHttpRequest();
		}
		xmlhttp.onreadystatechange=function()
		{
		
			if(xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			
				el.innerHTML = xmlhttp.responseText;
		
			
			}	
		}
		var string = "../modules/stream/handler.php?mode=get&object="+mobject;
		
		xmlhttp.open("GET",string,true);
		xmlhttp.send();
	},1000);
</script>
<center>
	  
<?php
		$object = getCurrentObject();
		echo "<a href='?m=clique' class='btn btn-info'>Create A Clique</a><br><br><br><div class = 'container'>";
		echo "<form>
					<textarea id='msg' name='msg' rows='5' cols='70'>Whats On Your Mind??</textarea><br><br>";
		 echo "<div class='accordion' id='accordion2' style='width:40%;'>";
		    echo "<div class='accordion-group'>
					<div class='accordion-heading'>
						<a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#collapse0'>CUSTOMIZE SHARING</a>
					</div>
						<div id='collapse0' class='accordion-body collapse' style='height: 0px; '>
							<div class='accordion-inner'>
								<ul><li>";
				echo "<table class='table'><th>Students</th><th>Faculty</th>".getChoices()."</table>";
				echo "</li></ul></div></div></div></div>";
					echo "&emsp;<div class='btn' style='width:30%' onclick='post($object)'>Post</div>
			  </form>";
			  
			  
		echo "<div id='stream'></div>";
		
		echo "</div>";
		
		function getChoices(){
			
			return "<tr><td>All&emsp;<input type='checkbox' name='stu' id='stub'></input></td><td>All&emsp;<input type='checkbox' name='stu' id='stub'></input></td></tr>
			<tr><td>Share to Batches&emsp;<input type='checkbox' name='stu' id='stub'></input></td>
						<td>
							<div>
								By Names
							</div>
						</td></tr>";
			
		}
?>
</center>
