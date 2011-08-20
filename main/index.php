<html>
<head> 
<link rel="stylesheet" href="../aux/demo/menu.css" type="text/css" media='screen'>
<link rel="stylesheet" href="../aux/pagestyles/style.css" type="text/css" media='screen'>
<link rel="stylesheet" href="../aux/pagestyles/profiles.css" type="text/css" media='screen'>
<link rel="stylesheet" href="../aux/pagestyles/livesearch.css" type="text/css" media='screen'>
<script type="text/javascript" src="../lib/jquery.js"></script>
<script type="text/javascript" src="../aux/thickbox/thickbox.js"></script>
<script language="javascript" type="text/javascript" src="../lib/flot/jquery.flot.js"></script>
<link rel="stylesheet" href="../aux/thickbox/ThickBox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="../aux/bootstrap/bootstrap-1.0.0.css" type="text/css" media="screen" />
<script src="http://autobahn.tablesorter.com/jquery.tablesorter.min.js"></script>
<link href="../aux/bootstrap/docs/assets/js/google-code-prettify/prettify.css" rel="stylesheet" type="text/css">
<script src="../aux/bootstrap/docs/assets/js/google-code-prettify/prettify.js"></script>
<script src="../aux/bootstrap/docs/assets/js/application.js"></script>



<title>FreeEdu-CMS</title>
<link rel="icon" href="../images/icon.png" type="image/x-icon" /> 
<link rel="shortcut icon" href="../images/icon.png" type="image/x-icon" /> 
<script type='text/javascript'>
function omniMeth(str,elementname)
{

	var list = document.getElementById(elementname);
	var string = "";
	string = "../core/omnisearch.php?q="+str;
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
</script>
 </head>
<body>
<?php

include("../lib/menus.php");
include("../lib/lib.php");
include("../misc/constants.php");
echo getMenu();
echo "<br><br>";
?>
<script type="text/javascript" src="../core/search.js"></script>

<br>
<?php
$optarray = $_GET;
$mode="";
$oid = $_COOKIE['object'];
if($oid==NULL)
{
	echo "<script type='text/javascript'>alert('Please Login Again!'); window.location='../login.php'; </script>";
}
if(array_key_exists("m",$optarray) || !array_key_exists("m",$optarray))
{
        $mode = $_GET['m'];
	echo "<div id='messages'></div>";
	echo "<div id='content'>";
	
if($mode==NULL)
{	
	include("../EditProfile/showProfile.php");
	showProfile($oid);
}
else if($mode == "p")
{
	if(array_key_exists("id",$optarray))
	{
      	 $id = $_GET['id'];
       	 include("../EditProfile/showProfile.php");
       	 showProf($id);
   	}
}
else if($mode == "cre")
{
	include("../credits.php");
}
else if($mode=="ba")
{
	if(isSudo($oid))
		include("../Rayon/batchadd.php");
	else
		notifywar("You Are Un Authorised To View This Page");
}
else if($mode=="sa")
{
	
	if(isSudo($oid))
	{
		echo "<center>";
		echo "<a href='?m=sa&t=a'>Create A Sublist</a>&emsp;";	
		echo "<a href='?m=sa&t=e'>Edit A Sublist</a><br /><br />";
		echo "</center>";	
		if(array_key_exists("t",$optarray))
			$type = $_GET['t'];
		if($type=='a')
			include("../Rayon/sublistadd.php");
		else if($type == 'e')
			include("../Rayon/sublistedit.php");
		else
			include("../Rayon/sublistadd.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
 
	
}
else if($mode=="ma")
{
	if(isSudo($oid))
	{
		echo "<center>";
		echo "<a href='?m=ma&t=e'>Upload By A Spreadsheet</a>&emsp;";	
		echo "<a href='?m=ma&t=m'>Upload Manually</a>&emsp;";
		echo "<a href='?m=ma&t=ed'>Edit Marks</a><br /><br />";
		echo "</center>";	
		if(array_key_exists("t",$optarray))
			$type = $_GET['t'];
		if($type=='e')
			include("../Rayon/marksadd.php");
		else if($type == 'm')
			include("../Rayon/dataentry.php");
		else if($type == 'ed')
			include("../Rayon/manUp.php");
		else
			include("../Rayon/marksadd.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
 
	
}
else if($mode=="cf")
{
	if(isSudo($oid))
	{
		echo "<center>";
		echo "<a href='?m=cf&t=e'>Upload By A Spreadsheet</a>&emsp;";	
		echo "<a href='?m=cf&t=m'>Upload Manually</a><br /><br />";
		echo "</center>";	
		if(array_key_exists("t",$optarray))
			$type = $_GET['t'];
		if($type=='e')
			include("../core/factsheetup.php");
		else if($type == 'm')
			include("../core/faccreate.php");
		else
			include("../core/faccreate.php");	
	}
	else
		notifywar("You Are Un Authorised To View This Page");
}
else if($mode=="mf")
{
	if(isSudo($oid))
	{
		$low = $_GET['l'];
		include("../core/facmap.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
}
else if($mode=="rga")
{
	if(isSudo($oid))
	{
		echo "<center>";
		include("../core/regadd.php");
		echo "</center>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
}

else if($mode=="ra")
{
	
	if(isSudo($oid) || isAdmin($oid))
	{
		
		echo "<center>";
		echo "<a href='?m=ra&t=e'>Export To Spreadsheet</a>&emsp;";	
		echo "<a href='?m=ra&t=h'>Show As HTML</a><br /><br />";
		echo "</center>";	
		if(array_key_exists("t",$optarray))
			$type = $_GET['t'];
		if($type == "e")
		  include("../Rayon/excelex.php");
		else
		 include("../Rayon/ma.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
}
else if($mode=="rr")
{
	if(isSudo($oid) || isAdmin($oid))
	{
		echo "<fieldset><legend>Record Retrieval</legend>";
		echo "<center>";
		include("../Rayon/MRetrival.php");
		echo "</center></fieldset>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
}
else if($mode=="up")
{
	if(isSudo($oid) || isAdmin($oid))
	{
		include("../Rayon/upgrade.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
}
else if($mode=="dr")
{
	if(isSudo($oid) || isAdmin($oid))
	{
		include("../Roster/dayreport.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
}
else if($mode=="cr")
{
	if(isSudo($oid) || isAdmin($oid))
	{
		include("../Roster/conreport.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
}
else if($mode=="sc")
{
	if(isSudo($oid) || isAdmin($oid))
	{
		include("../Roster/schedule.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
}
else if($mode=="gf")
	include("../Roster/graph.php");
else if($mode=="str")
{
	if(isSudo($oid) || isAdmin($oid))
	{
		include("../Roster/stureport.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
}
else if($mode=="os")
{
	
	echo "<center><input type='text' onkeyup=\"getLists(this.value,'omni')\">
	</input><br>Select By Type :&emsp;".getTypes('type[]','onchange=\'getSelect(this.value)\'')."
	<div id='options'></div>	
	<div id='omni'></div></center>";
	
	if(array_key_exists("srch",$_POST))
	{
		$value = $_POST["srch"];
		echo "<script type='text/javascript'>getLists(\"".$value."\",'omni');</script>";
	}
		
}
else if($mode=="fp")
{
	if(isFaculty($oid))
	{
		$array = getObject($_COOKIE['object']); 
		echo "<center>".getFacPlan($array['obhandle'])."</center>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	
}
else if($mode=="ep")
{
	include("../EditProfile/editProfile.php");
}
else if($mode=="ua")
{
	if(isFaculty($oid))
	{
		include("../Roster/atupload.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
			

}

else
{
	notifyerr("There Is No Such Page!");
	redirect("?");
}
}
echo "</div>";
?>
</body>
</html>
