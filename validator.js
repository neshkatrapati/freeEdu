<script type="text/javascript">
function validator()
{
	var ologin = document.forms["login"]["ologin"].value
	var opass = document.forms["login"]["opass"].value
	if (ologin=="" || opass=="")
	{
		alert("Please Fill Required Fields.");
		document.getElementById("fail").innerHTML = "<div id='ufail'>One or More Fields Were Not Filled</div>";
		return false;
	}
}	
</script>