<?php/*
Copyright 2011
Ganesh Katrapati <ganesh.katrapati@gmail.com>
Aditya Maturi <maturiaditya@gmail.com>
This file is part of FreeEdu.

FreeEdu is free software: you can redistribute it and/or modify
it under the terms of the Affero GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

FreeEdu is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the Affero GNU General Public License
along with FreeEdu.  If not, see <http://www.gnu.org/licenses/>.*/?>
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
 <script type="text/javascript" src="../lib/nyromodal/js/jquery.nyroModal.custom.js"></script>
<link href="../aux/bootstrap/docs/assets/js/google-code-prettify/prettify.css" rel="stylesheet" type="text/css">
<script src="../aux/bootstrap/docs/assets/js/google-code-prettify/prettify.js"></script>
<script src="../aux/bootstrap/docs/assets/js/application.js"></script>
<script type="text/javascript" src="../aux/stars/jquery.starRating.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../aux/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../aux/calendar/jsDatePick.min.1.3.js"></script>
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
			$array =  queryMe("select * from MSTUDENTT where sid like '".$obj['obhandle']."'");
			//echo "select sid from MSTUDENT where srno like '".$obj['obhandle']."'";
			getStuGraph($array["sid"],strtotime("-4 week"),strtotime("now"));
			getMarksGraph($array["srno"]);
	 }
	 
   	}
}

else if($mode == "cre")
{
	
	echo "<iframe src='../credits/credits.html' frameborder='0' scrolling='yes' width='100%' height='200%'>";
}
else if($mode == "fbimage")
{
	//echo "Hello";
	include("../core/example.php");
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
		
		  include("../Rayon/excelex.php");
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
else if($mode=="fbcreate")
{
	echo "<div id='content'  class='content'>";
	if(isSudo($oid) || isAdmin($oid))
	{
		echo "<fieldset><legend>Create A Feedback Form</legend>";
		echo "<center>";
		include("../modules/feedback/fbcreate.php");
		echo "</center></fieldset>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="fbput")
{
	echo "<div id='content'  class='content'>";
	if(isStudent($oid))
	{
		echo "<fieldset><legend>Submit A Feedback Form</legend>";
		echo "<center>";
		include("../modules/feedback/fbput.php");
		echo "</center></fieldset>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="fbget")
{
	echo "<div id='content'  class='content'>";
	if(isSudo($oid) || isAdmin($oid))
	{
		echo "<fieldset><legend>Analyse Feedback Forms</legend>";
		echo "<center>";
		include("../modules/feedback/fbget.php");
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
	echo "<form>"; 
	echo "<center><input type='text' onkeyup=\"getLists(this.value,'omni')\" id='tbox'>
	</input><br><br>Select By Type :&emsp;".getTypes('type[]','onchange=\'getSelect(this.value)\'')."
	<div id='options'></div>	
	<div id='omni'></form></div></center>";
	
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
		//echo "<center>".getFacPlan($array['obhandle'])."</center>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="edit_Matt")
{
	echo "<div id='content' class='content'>";
	if(isAAdmin($oid))
	{
		include("../Roster/maineditAtt.php"); 
		//echo "<center>".getFacPlan($array['obhandle'])."</center>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="xdebug")
{
	echo "<div id='content' class='content'>";
	if(True)
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
else if($mode=="license")
{
	echo "<div id='content'  class='content'>";
	echo "<center><pre>";
	include("../COPYING");
	echo "</pre></center></div>";
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
else if($mode=="see_marks")
{
	echo "<div id='content' class='content' align='center'>";
	echo "<center>";
	if(isStudent($oid))
	{
		include("../Rayon/Retrival.php");
		$arr = getObject($oid);
		//print_r($arr);
		$sidarr = getStudent($arr["obhandle"]); 	
		//echo $sidarr["srno"];		
		retrival($sidarr["srno"]);
		echo "</center>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";

}
else if($mode=="see_att")
{
	echo "<div id='content' class='content' align='center'>";
	if(isStudent($oid))
	{
		include("../Roster/stugetatt.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";

}
else if($mode=="see_att_today")
{
	echo "<div id='content' class='content' align='center'>";
	if(isStudent($oid))
	{
		$arr = getObject($oid);
		$sidarr = getStudent($arr["obhandle"]); 	
		
		
				echo " <div id='placeholder' style='width:500px;height:300px'></div>
				 <p id='hoverdata'> <span id='clickdata'></span></p>";
				 echo  getStuGraph($sid,strtotime(date("d-M-Y")),strtotime(date("d-M-Y")));
			        echo getStuReport($sid,strtotime(date("d-M-Y")),strtotime(date("d-M-Y")),-1);
			    
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";

}
else if($mode=="al")
{
	echo "<div id='content'  class='content'>";
	if(isSudo($oid) || isAdmin($oid))
	{
		echo "<fieldset><legend>Lateral Entry-Add a student into the Batch</legend>";
		echo "<center>";
		include("../core/addLateral.php");
		echo "</center></fieldset>";
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
