function getLists(str,elementname)
{

	var list = document.getElementById(elementname);
	var type = document.getElementById('type').value;
	var string = "";
	if(type!='')
		string = "../core/livesearch.php?q="+str+"&t="+type;
	else
		string = "../core/livesearch.php?q="+str;
	var extra = "";
	var inex ="";	
	if(type == '0')
	{
		var options = 	document.getElementById('soptions').value;
		var imode = 	document.getElementById('imode').value;
		if(options != '-1')
		{
			if(options == '0')
			{
				var bat = 	document.getElementById('bat').value;			
				extra += "op=b&b="+bat;
			}		
			else if(options == '1')
			{
				var cls = 	document.getElementById('cls').value;			
				extra += "op=c&c="+cls;
			}		
			
		}
		if(imode==1)
			inex += "ip=n";
		else if(imode==2)
			inex+= "ip=r";
	
	}
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
	if(extra!="")
		extra = "&"+extra;
	if(inex!="")
		inex = "&"+inex;
	
	xmlhttp.open("GET",string+extra+inex,true);
	xmlhttp.send();
}
function getModifLists(str,elementname)
{

	var list = document.getElementById(elementname);
	var type = document.getElementById('type').value;
	var string = "";
	if(type!='')
		string = "../core/livesearch.php?q="+str+"&t="+type;
	else
		string = "../core/livesearch.php?q="+str;
	var extra = "";
	var inex ="";	
	if(type == '0')
	{
		var options = 	document.getElementById('soptions').value;
		var imode = 	document.getElementById('imode').value;
		if(options != '-1')
		{
			if(options == '0')
			{
				var bat = 	document.getElementById('bat').value;			
				extra += "op=b&b="+bat;
			}		
			else if(options == '1')
			{
				var cls = 	document.getElementById('cls').value;			
				extra += "op=c&c="+cls;
			}		
			
		}
		if(imode==1)
			inex += "ip=n";
		else if(imode==2)
			inex+= "ip=r";
	
	}
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
	if(extra!="")
		extra = "&"+extra;
	if(inex!="")
		inex = "&"+inex;
	
	xmlhttp.open("GET",string+extra+inex,true);
	xmlhttp.send();
}
function getMSelect(value)
{

	var options = document.getElementById('options');
	
		
	if(value == "0")
	{
		
		options.innerHTML = "<select name='soptions[]' id='soptions' onchange='getOptions(this.value)'><option value='-1'>All</option><option value='0'>Select By Batch</option><option value='1'>Select By Class</option></select>";
		options.innerHTML += "<span id='more'></span>";		
		options.innerHTML += "&emsp;<select name='imode[]' id='imode'><option value='0'>All</option><option value='1'>Use Name For Selection</option><option value='2'>Use Roll Number For Selection</option></select>";	
		
	}
	else
	{
		
		options.innerHTML = "";
	}
	var tbox = document.getElementById("tbox").value;
	getLists(tbox,'omni');
}
function getSelect(value)
{

	var options = document.getElementById('options');
	
		
	if(value == "0")
	{
		
		options.innerHTML = "Options: <select name='soptions[]' id='soptions' onchange='getOptions(this.value)'><option value='-1'>--Select--</option><option value='0'>Select By Batch</option><option value='1'>Select By Class</option></select>";
		options.innerHTML += "<span id='more'></span>";		
		options.innerHTML += "<select name='imode[]' id='imode'><option value='1'>Use Name For Selection</option><option value='2'>Use Roll Number For Selection</option></select>";	
		
	}
	else
	{
		
		options.innerHTML = "";
	}
	var tbox = document.getElementById("tbox").value;
	getLists(tbox,'omni');
}
function getOptions(value)
{
	var list = document.getElementById('more');
	
	var string = "";
	if(value==0)
		string = "../core/batchesnothers.php?q=b";
	else if(value==1)
		string = "../core/batchesnothers.php?q=c";
	else
	{
		list.innerHTML = "";
		return;
	}
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
	xmlhttp.open("GET",string,true);
	xmlhttp.send();

}
