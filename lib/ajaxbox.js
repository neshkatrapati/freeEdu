function getSubList(value,str)
{

	var slist = document.getElementById(str);
	
	if (window.XMLHttpRequest)
 	{
 	
 		xmlhttp=new XMLHttpRequest();
 	}
  	xmlhttp.onreadystatechange=function()
	{
		
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
				
			slist.innerHTML = xmlhttp.responseText;	
		}	
	}
	xmlhttp.open("GET","../lib/fetchsubs.php?q="+value,true);
	xmlhttp.send();
}