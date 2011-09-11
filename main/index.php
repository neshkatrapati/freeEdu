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
<link rel="stylesheet" href="../lib/nyromodal/styles/nyroModal.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="../lib/nyromodal/js/jquery.nyroModal.custom.js"></script>
<link href="../aux/bootstrap/docs/assets/js/google-code-prettify/prettify.css" rel="stylesheet" type="text/css">
<script src="../aux/bootstrap/docs/assets/js/google-code-prettify/prettify.js"></script>
<script src="../aux/bootstrap/docs/assets/js/application.js"></script>
<script type="text/javascript">
$(function() {
  $('.nyroModal').nyroModal();
});
</script>


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
include("../lib/graphs.php");
include("../lib/lib.php");
include("../misc/constants.php");

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
echo getMenu();
echo "<br><br>";
if(array_key_exists("m",$optarray) || !array_key_exists("m",$optarray))
{
        $mode = $_GET['m'];
	echo "<div id='messages'></div><div class='container-fluid'>";
	
	
if($mode==NULL)
{
	echo "<div id='sidebar' class='sidebar'></div>";
	include("../EditProfile/showProfile.php");
	showProfile($oid);
}
else if($mode == "p")
{
	if(array_key_exists("id",$optarray))
	{
      	 $id = $_GET['id'];
       	 include("../EditProfile/showProfile.php");
	 echo "<div id='sidebar' class='sidebar'>"; 
       	 showProf($id);
	 echo "</div>";
	 if(isStudent($id))
	 {
			echo "<div class='content' id='content' align='right'> <div id='placeholder' style='width:450px;height:250px'></div>
			<p id='hoverdata'><span id='clickdata'></span></p><br><div id='placeholderm' style='width:450px;height:250px'></div>
			<p id='hoverdata'><span id='clickdata'></span></p></div>";
			$obj = getObject($id);
			$array =  queryMe("select * from MSTUDENTT where srno like '".$obj['obhandle']."'");
			//echo "select sid from MSTUDENT where srno like '".$obj['obhandle']."'";
			getStuGraph($array["sid"],strtotime("-4 weeks"),strtotime("now"));
			getMarksGraph($array["srno"]);
	 }
	 
   	}
}

else if($mode == "cre")
{
	include("../credits.php");
}
else if($mode=="ba")
{
	echo "<div id='content'>";
	if(isSudo($oid))
		include("../Rayon/batchadd.php");
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="sa")
{
	echo "<div id='content'  class='content'>";
	if(isSudo($oid))
	{
		echo "<center>";
		echo "<a href='?m=sa&t=a' class='pills'>Create A Sublist</a>&emsp;";	
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
 
	echo "</div>";
	
}
else if($mode=="ma")
{
	echo "<div id='content'  class='content'>";
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
 
	echo "</div>";
	
}
else if($mode=="cf")
{
	echo "<div id='content'  class='content'>";
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
	echo "</div>";
}
else if($mode=="mf")
{
	echo "<div id='content'  class='content'>";
	if(isSudo($oid))
	{
		$low = $_GET['l'];
		include("../core/facmap.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="rga")
{
	echo "<div id='content'  class='content'>";
	if(isSudo($oid))
	{
		echo "<center>";
		include("../core/regadd.php");
		echo "</center>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="suba")
{
	echo "<div id='content'  class='content'>";
	if(isSudo($oid))
	{
		echo "<center>";
		include("../core/substituteui.php");
		echo "</center>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="immap")
{
	echo "<div id='content'  class='content'>";
	if(isSudo($oid))
	{
		echo "<center>";
		include("../core/imagemap.php");
		echo "</center>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="ra")
{
	echo "<div id='content'  class='content'>";
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
	echo "</div>";
}
else if($mode=="rr")
{
	echo "<div id='content'  class='content'>";
	if(isSudo($oid) || isAdmin($oid))
	{
		echo "<fieldset><legend>Record Retrieval</legend>";
		echo "<center>";
		include("../Rayon/MRetrival.php");
		echo "</center></fieldset>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="up")
{
	echo "<div id='content'  class='content'>";
	if(isSudo($oid) || isAdmin($oid))
	{
		include("../Rayon/upgrade.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="dr")
{
	echo "<div id='content'  class='content'>";
	if(isSudo($oid) || isAdmin($oid))
	{
		include("../Roster/dayreport.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="cr")
{
	echo "<div id='content'  class='content'>";
	if(isSudo($oid) || isAdmin($oid))
	{
		include("../Roster/conreport.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="sc")
{
	echo "<div id='content'  class='content'>";
	if(isSudo($oid) || isAdmin($oid))
	{
		include("../Roster/schedule.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="src")
{
	echo "<div id='content' class='content'>";
	if(array_key_exists("q",$_GET))
	{
		$q=$_GET['q'];
		if(array_key_exists("t",$_GET))
		{
			
			$t=$_GET['t'];
			
		}
		if(array_key_exists("ip",$_GET))
		{
			
			$ip=$_GET['ip'];
			
		}if(array_key_exists("op",$_GET))
		{
			
			$op=$_GET['op'];
			
		}if(array_key_exists("b",$_GET))
		{
			
			$b=$_GET['b'];
			
		}
		if(array_key_exists("c",$_GET))
		{
			
			$c=$_GET['c'];
			
		}
	}
	include("../core/livesearch2.php");
	getResult($q,$t,$ip,$op,$b,$c);

	echo "</div>";
}
else if($mode=="str")
{
	echo "<div id='content'  class='content'>";
	if(isSudo($oid) || isAdmin($oid))
	{
		include("../Roster/stureport.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="os")
{
	
	echo "<div id='content'  class='content'>";
	echo "<center><input type='text' onkeyup=\"getLists(this.value,'omni')\">
	</input><br>Select By Type :&emsp;".getTypes('type[]','onchange=\'getSelect(this.value)\'')."
	<div id='options'></div>	
	<div id='omni'></div></center>";
	
	if(array_key_exists("srch",$_POST))
	{
		$value = $_POST["srch"];
		
		echo "<script type='text/javascript'>getLists(\"".$value."\",'omni');</script>";
	}
	echo "</div>";	
}
else if($mode=="fp")
{
	echo "<div id='content'  class='content'>";
	if(isFaculty($oid))
	{
		$array = getObject($_COOKIE['object']); 
		echo "<center>".getFacPlan($array['obhandle'])."</center>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="edit_att")
{
	echo "<div id='content' class='content'>";
	if(isFaculty($oid))
	{
		include("../Roster/editAtt.php"); 
		echo "<center>".getFacPlan($array['obhandle'])."</center>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="xdebug")
{
	echo "<div id='content' class='content'>";
	if(isSudo($oid))
	{
		if(file_exists("../misc/.xdebug"))
		{
			$file = fopen("../misc/.xdebug","r");
			echo "<center>";
			echo "<a href='?m=xdebug_clear'>Clear Entries</a><br />";
			echo "<table class='xdebug' style='text-align:center;'>";
			
			echo "<th>Debug_Message</th><th>Filename</th><th>Line Number</th><th>Date</th><th>Time</th>";
			while(!feof($file))
				echo fgets($file);
			echo "</table></center>";
		}
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="xdebug_exp")
{
	echo "<div id='content' class='content'>";
	if(isSudo($oid))
	{
		xDebug("Message");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="create_student")
{
	echo "<div id='content' class='content'>";
	if(isSudo($oid))
	{
		include("../core/createStudentUser.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="feedback")
{
	echo "<div id='content' class='content'>";
	if(isSudo($oid))
	{
		include("../core/feedback.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="xdebug_clear")
{
	echo "<div id='content' class='content'>";
	if(isSudo($oid))
	{
		unlink("../misc/.xdebug");
		echo "<script type='text/javascript'>window.location='?m=xdebug';</script>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="inc")
{
	echo "<div id='content'  class='content'>";
	if(isFaculty($oid))
	{
		include("../Rayon/internals.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="ep")
{
	echo "<div id='content'  class='content'>";
	include("../EditProfile/editProfile.php");
	echo "</div>";
}
else if($mode=="ua")
{
	echo "<div id='content' class='content'>";
	if(isFaculty($oid))
	{
		include("../Roster/atupload.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";

}

else
{
	echo "<div id='content'>";
	notifyerr("There Is No Such Page!");
	redirect("?");
	echo "</div>";
}
}
echo "</div>";
?>
</body>

</html>
