<script type='text/javascript'>
function getLists(str)
{

	var list = document.getElementById('list');
	var br = document.getElementById('brn').value	
	//if(str.length==0)
	//{
		//list.innerHTML="";
		//return;
	//}
	
	if (window.XMLHttpRequest)
 	{
 	
 		xmlhttp=new XMLHttpRequest();
 	}
  	xmlhttp.onreadystatechange=function()
	{
		
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
				
			list.innerHTML = xmlhttp.responseText;	
		}	
	}
	xmlhttp.open("GET","../core/fetch.php?q="+str+"&br="+br,true);
	xmlhttp.send();
}
</script>

<style>
.padd
{
	text-align:center;

}
</style>
<?php

include("../lib/lib.php");	
include("../misc/constants.php");
echo "<center>";
//Getting Branches And Regulations 
$placeBranch = "";
$Brret = getBranches();

for($i=0;$i<count($Brret);$i++)
			$placeBranch=$placeBranch."<option value='".$Brret[$i]."'>".$Brret[$i]."</option>";
			
			
echo "<input type='search' onkeyup='getLists(this.value)'></input><br />";
echo "Select By Department : <select name='brn[]' id='brn' onchange='getLists(\"all\")'><option value='%'>ALL</option>".$placeBranch."</select>";
echo "<div id='list'></div>";
?>