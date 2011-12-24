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
  $('.nyroModal').resize();
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
function show(value,element)
			{
				var ele = document.getElementById(value+"#expand");
				var ele_c = document.getElementById(value+"#collapse");
				if(ele.style.display == 'none'){
					
					ele.style.display = 'block';
					ele_c.style.display = 'none';
					element.src = "../images/others/collapse.png";	
				}
					
				else{
					ele.style.display = 'none';
					ele_c.style.display = 'block';
					element.src = "../images/others/expandico.gif";	
				}
			}
function showModuleDetails(value,element)
			{
				var ele = document.getElementById(value);
				
				if(ele.style.display == 'none'){
					
					ele.style.display = 'block';
					
					element.src = "../images/others/collapse.png";	
				}
					
				else{
					ele.style.display = 'none';
					
					element.src = "../images/others/expandico.gif";	
				}
			}

</script>
 </head>
<body>
<?php
require_once '../lib/connection.php';
include_once("../lib/menu2.php");
include_once("../lib/graphs.php");
include_once("../lib/lib.php");
include_once("../misc/constants.php");
include_once("../core/interfaces.php");
require_once("../lib/boxes.php");

//require("../lib/classes.php");


?>
<script type="text/javascript" src="../core/search.js"></script>

<br>
<?php
$optarray = $_GET;
$mode="";
$oid = $_COOKIE['object'];

if($oid==NULL)
{
	$url = htmlify(curPageUrl());
	
	echo "<script type='text/javascript'>window.location='../login.php?url=".$url."' </script>";
}
if($_GET["menu"]!="no")
{
	$object = getObject($oid);
	$object = getObject(getCurrentObject());
	//$links = getLinkItems();
	
	echo getMenu(getObjectTypeTag($object["otyid"]));
}
echo "<br><br>";
if(array_key_exists("m",$optarray) || !array_key_exists("m",$optarray))
{
        $mode = $_GET['m'];
	echo "<div id='messages'></div><div class='container-fluid'>";
	
	
if($mode==NULL)
{
	echo "<div id='sidebar' class='sidebar'>";
	
	include("../EditProfile/showProfile.php");
	
	showProfile($oid);
	echo "<br><br>";
        $obj = getObject(getCurrentObject());
	$abcd = freeedu_boxes($obj["otyid"]);

	$boxes = $abcd["left"];
	echo "<div style='float:left'>";
	for($i=0;$i<count($boxes);$i++)
	{
		$boxname = $boxes[$i];
		
	
		$box = new $boxname(getCurrentObject(),"context.home");
		
		echo "<div id='box#".$boxname."#main' class='".$box->classinfo."' style=''>";
		if($box->defstate_e == "none")
			$img = "../images/others/expandico.gif";
		else
			$img = "../images/others/collapse.png";
		echo "".$box->name."<br><input type='image' onclick='show(\"box#".$boxname."\",this)' src='".$img."' style='float:right;' ></input>";
		echo "<div id='box#".$boxname."#expand'  style='display:".$box->defstate_e.";'>".$box->box_onexpand()."</div>";
		echo "<div id='box#".$boxname."#collapse' class='' style='display:".$box->defstate_c."'>".$box->box_oncollapse()."</div>";
		echo $ret."</div>";
	 }
	 echo "</div>";
	 echo "</div>";
	 $obj = getObject(getCurrentObject());
	 $abcd = freeedu_boxes($obj["otyid"]);
	 $boxes = $abcd["right"];
	 echo "<div style='float:right'>";
	 for($i=0;$i<count($boxes);$i++)
	 {
		$boxname = $boxes[$i];
		
	
		$box = new $boxname(getCurrentObject(),"context.home");
		
		echo "<div id='box#".$boxname."#main' class='".$box->classinfo."' style=''>";
		if($box->defstate_e == "none")
			$img = "../images/others/expandico.gif";
		else
			$img = "../images/others/collapse.png";
		echo "".$box->name."&emsp;<input type='image' onclick='show(\"box#".$boxname."\",this)' src='".$img."' style='float:right;' ></input>";
		echo "<div id='box#".$boxname."#expand'  style='display:".$box->defstate_e.";'>".$box->box_onexpand()."</div>";
		echo "<div id='box#".$boxname."#collapse' class='' style='display:".$box->defstate_c."'>".$box->box_oncollapse()."</div>";
		echo $ret."</div>";
	 }
	 echo "</div>";
	
}
else if($mode == "p")
{
	if(array_key_exists("id",$optarray))
	{
      	 $id = $_GET['id'];
       	 require_once("../EditProfile/showProfile.php");
	 echo "<div id='sidebar' style='float:left'>"; 

	 showProf($id);
	 echo "<br><br>";
	 $obj = getObject($_GET["id"]);
	 $abcd = freeedu_boxes($obj["otyid"]);
	 $boxes = $abcd["left"];
	 echo "<div style='float:right'>";
	 for($i=0;$i<count($boxes);$i++)
	 {
		$boxname = $boxes[$i];
		
	
		$box = new $boxname($_GET["id"],"context.profile");
		
		echo "<div id='box#".$boxname."#main' class='".$box->classinfo."' style=''>";
		if($box->defstate_e == "none")
			$img = "../images/others/expandico.gif";
		else
			$img = "../images/others/collapse.png";
		echo "".$box->name."<br><input type='image' onclick='show(\"box#".$boxname."\",this)' src='".$img."' style='float:right;' ></input>";
		echo "<div id='box#".$boxname."#expand'  style='display:".$box->defstate_e.";'>".$box->box_onexpand()."</div>";
		echo "<div id='box#".$boxname."#collapse' class='' style='display:".$box->defstate_c."'>".$box->box_oncollapse()."</div>";
		echo $ret."</div>";
	 }
	 echo "</div>";
	 echo "</div>";
	 $obj = getObject($_GET["id"]);
	 $abcd = freeedu_boxes($obj["otyid"]);
	 $boxes = $abcd["right"];
	 echo "<div style='float:right'>";
	 for($i=0;$i<count($boxes);$i++)
	 {
		$boxname = $boxes[$i];
		
	
		$box = new $boxname($_GET["id"],"context.profile");
		
		echo "<div id='box#".$boxname."#main' class='".$box->classinfo."' style=''>";
		if($box->defstate_e == "none")
			$img = "../images/others/expandico.gif";
		else
			$img = "../images/others/collapse.png";
		echo "".$box->name."&emsp;<input type='image' onclick='show(\"box#".$boxname."\",this)' src='".$img."' style='float:right;' ></input>";
		echo "<div id='box#".$boxname."#expand'  style='display:".$box->defstate_e.";'>".$box->box_onexpand()."</div>";
		echo "<div id='box#".$boxname."#collapse' class='' style='display:".$box->defstate_c."'>".$box->box_oncollapse()."</div>";
		echo $ret."</div>";
	 }
	 echo "</div>";
	
   	}
}

else if($mode == "cre")
{
	echo "<iframe src='../credits/credits.html' frameborder='0' scrolling='yes' width='100%' height='200%' style='-webkit-border-radius:15px;-moz-border-radius:15px;border-radius:15px;'>";
}
else if($mode == "fbimage")
{
	//echo "Hello";
	include("../core/example.php");
}

else if($mode=="ba")
{
	echo "<div id='content' >";
	if(isSudo($oid))
		include("../Rayon/batchadd.php");
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="modules")
{
	echo "<div id='content' >";
	if(isSudo($oid)){
		include_once("../core/modmain.php");
	}
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
		echo "<a href='?m=sa&t=a' >Create A Sublist</a>&emsp;";	
		echo "<a href='?m=sa&t=e'>Edit A Sublist</a><br /><br />";
		echo "</center>";	
		if(array_key_exists("t",$optarray))
			$type = $_GET['t'];
		if($type=='a')
			include_once("../Rayon/sublistadd.php");
		else if($type == 'e')
			include_once("../Rayon/sublistedit.php");
		else
			include_once("../Rayon/sublistadd.php");
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
			include_once("../Rayon/marksadd.php");
		else if($type == 'm')
			include_once("../Rayon/dataentry.php");
		else if($type == 'ed')
			include_once("../Rayon/manUp.php");
		else
			include_once("../Rayon/marksadd.php");
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
			include_once("../core/factsheetup.php");
		else if($type == 'm')
			include_once("../core/faccreate.php");
		else
			include_once("../core/faccreate.php");	
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
		include_once("../core/facmap.php");
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
		include_once("../core/regadd.php");
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
		include_once("../core/substituteui.php");
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
		include_once("../core/imagemap.php");
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
		
		  include_once("../Rayon/excelex.php");
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
		include_once("../Rayon/MRetrival.php");
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
		include_once("../Rayon/upgrade.php");
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
		include_once("../Roster/dayreport.php");
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
		include_once("../Roster/conreport.php");
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
		include_once("../Roster/schedule.php");
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
	include_once("../core/livesearch2.php");
	getResult($q,$t,$ip,$op,$b,$c);

	echo "</div>";
}
else if($mode=="str")
{
	echo "<div id='content'  class='content'>";
	if(isSudo($oid) || isAdmin($oid))
	{
		include_once("../Roster/stureport.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="add_ebook")
{
	echo "<div id='content'  class='content'>";
	if(isAlib($oid))
	{
		include_once("../modules/library/addEbook.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="edit_ebook")
{
	echo "<div id='content'  class='content'>";
	if(isAlib($oid))
	{
		include_once("../modules/library/editEbook.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="eb")
{
	echo "<div id='content'  class='content'>";
	if(isAlib($oid))
	{
		include_once("../modules/library/editBook.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}

else if($mode=="ab")
{
	echo "<div id='content'  class='content'>";
	if(isAlib($oid))
	{
		include_once("../modules/library/addBook.php");
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

else if($mode=="ot_create")
{
	echo "<div id='content'  class='content'>";
	if(!isStudent($oid))
	{
		include_once("../modules/objective/input.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="ot_edit")
{
	echo "<div id='content' style='margin-left:20px;margin-right:20px'>";
	if(true)
	{
		include_once("../modules/objective/editobjective.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="ot_submit_see")
{
	echo "<div id='content' style='margin-left:20px;margin-right:20px'>";
	if(true)
	{
		include_once("../modules/objective/subview.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}

else if($mode=="ot_ques")
{
	echo "<div id='content'  class='content'>";
	if(!isStudent($oid))
	{
		include_once("../modules/objective/otques.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="ot_submit")
{
	echo "<div id='content'  class='content'>";
	if(isStudent($oid))
	{
		include_once("../modules/objective/otsubmit.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}

else if($mode=="ot_edit_meta")
{
	echo "<div id='content'  class='content'>";
	if(!isStudent($oid))
	{
		include_once("../modules/objective/editmeta.php");
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
		include_once("../Roster/editAtt.php"); 
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
		include_once("../Roster/maineditAtt.php"); 
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
		include_once("../core/createStudentUser.php");
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
		include_once("../core/feedback.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="cflow")
{
	echo "<div id='content' class='content'>";
	if(isSudo($oid))
	{
		
		echo "<div id='coverflowHolder'>

<div id='__cvfl-coverflow-holder' style='display:none'><div id='__cvfl-coverflow'>
<div id='__cvfl-coverflow-wrapper'></div>
<div id='smallerPreview'></div>
<div id='__cvfl-coverflow-label'></div>";
		echo "<SCRIPT type='text/javascript'>
	if (true) {
	
window.onload = function(){	Coverflow.init([

		{src: 'CoverFlows_files/covers/cover1med.jpg',
		  label: {album: 'Abbey Road', artist: 'The Beatles', url:'http://www.beatles.com/', high:'CoverFlows_files/covers/cover1large.jpg'}},

		{src: 'CoverFlows_files/covers/cover2med.jpg',
		   label: {album: 'Graduation', artist: 'Kanye West', url:'http://www.kanyewest.com', high:'CoverFlows_files/covers/cover2large.jpg'}},

		{src: 'CoverFlows_files/covers/cover3med.jpg',
		   label: {album: 'Circus', artist: 'Britney Spears', url:'http://www.britneyspears.com', high:'CoverFlows_files/covers/cover3large.jpg'}},
		   
		{src: 'CoverFlows_files/covers/cover13med.jpg',
		   label: {album: 'The Fame', artist: 'Lady Gaga', url:'http://www.ladygaga.com', high:'CoverFlows_files/covers/cover13large.jpg'}},
		   
		{src: 'CoverFlows_files/covers/cover14med.jpg',
		   label: {album: 'The Fray', artist: 'The Fray', url:'http://www.thefray.com', high:'CoverFlows_files/covers/cover14large.jpg'}},
		   
		{src: 'CoverFlows_files/covers/cover12med.jpg',
		   label: {album: 'Funhouse', artist: 'Pink', url:'http://www.pinkspage.com', high:'CoverFlows_files/covers/cover12large.jpg'}},
		   

		{src: 'CoverFlows_files/covers/cover4med.jpg',
		   label: {album: '21st Century Breakdown', artist: 'Greenday', url:'http://www.greenday.com', high:'CoverFlows_files/covers/cover4large.jpg'}},

		{src: 'CoverFlows_files/covers/cover5med.jpg',
		   label: {album: 'Carter III', artist: 'Lil Wayne', url:'http://www.lilwayne.com', high:'CoverFlows_files/covers/cover5large.jpg'}},

		{src: 'CoverFlows_files/covers/cover6med.jpg',
		   label: {album: 'Clumsy', artist: 'Fergie', url:'http://www.fergie.com', high:'CoverFlows_files/covers/cover6large.jpg'}},

		{src: 'CoverFlows_files/covers/cover7med.jpg',
		   label: {album: 'The Best Of', artist: 'Blur', url:'http://ww.blur.com', high:'CoverFlows_files/covers/cover7large.jpg'}},

		{src: 'CoverFlows_files/covers/cover8med.jpg',
		   label: {album: 'Rockferry', artist: 'Duffy', url:'http://www.duffy.com', high:'CoverFlows_files/covers/cover8large.jpg'}},

		{src: 'CoverFlows_files/covers/cover9med.jpg',
		   label: {album: 'Dig out your soul', artist: 'Oasis', url:'http://www.oasis.com', high:'CoverFlows_files/covers/cover9large.jpg'}},

		{src: 'CoverFlows_files/covers/cover10med.jpg',
		   label: {album: 'Loose', artist: 'Nelly Furtado', url:'http://www.nellyfurtado.com', high:'CoverFlows_files/covers/cover10large.jpg'}}
		   
],
{	createLabel: function(item)
       {
			
			return item.label.album +'<br><span id=\"artist\">'+ item.label.artist + '</span><br><a href=\"\" + item.label.url + \"\">'+item.label.url+'</a>';
	         
	  },
		onSelectCenter: function(item,id){
		
		var img = new Image();
		img.onload = function(){ 
		
		
		Lightbox.show(this.src,id);	
		
		}; 
		
		img.src = item.label.high;
		
		},
		
		refill: function(start){

			new HTTPQuery('/ajax/cflow/0/?from='+start+'&l=1&cache=3998668924011356071',0,'updateCflow');
		}		
		});
		}
	}
	
	function updateCflow(oHttp) {
		cResponse = oHttp.responseText;
		if (cResponse.substr(0,1)=='!'){
			cResponse=cResponse.substr(1);
			eval(cResponse);
		}
	}

</SCRIPT></div></div>";

	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="xdebug_clear")
{
	echo "<div id='content' class='content'>";
	if(True)
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
		include_once("../Rayon/internals.php");
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}
else if($mode=="ep")
{
	echo "<div id='content'  class='content'>";
	include_once("../EditProfile/editProfile.php");
	echo "</div>";
}
else if($mode=="ass")
{
	echo "<div id='content'  class='content'>";
	if(!isStudent($oid))
		include_once("../modules/assignment/createassignment.php");
	else
		notifywar("You Are Un Authorised To View This Page");
		
	echo "</div>";
}
else if($mode=="ass_see")
{
	
	echo "<div id='content'  class='content'>";
	if(!isStudent($oid))
		include_once("../modules/assignment/showassignment.php");
	else if(isStudent($_COOKIE["object"]))
		include_once("../modules/assignment/showassignment_stu.php");
	else
		notifywar("You Are Un Authorised To View This Page");

		
	echo "</div>";
}
else if($mode=="ass_edit")
{
	echo "<div id='content'  class='content'>";
	echo "<fieldset><legend>Edit Assignment</legend>";
	$asid = $_GET["asid"];
	include_once("../modules/assignment/editassignment.php");
	echo "</div></fieldset>";
}
else if($mode=="license")
{
	echo "<div id='content'  class='content'>";
	echo "<center><pre>";
	include_once("../COPYING");
	echo "</pre></center></div>";
}
else if($mode=="ua")
{
	echo "<div id='content' class='content'>";
	if(isFaculty($oid))
	{
		include_once("../Roster/atupload.php");
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
		include_once("../Rayon/Retrival.php");
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
		include_once("../Roster/stugetatt.php");
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
		include_once("../core/addLateral.php");
		echo "</center></fieldset>";
	}
	else
		notifywar("You Are Un Authorised To View This Page");
	echo "</div>";
}


else
{
	$object = getObject(getCurrentObject());
	$links = getLinkItems(getObjectTypeTag($object["otyid"]));
	echo "<div id='content'>";
	for($i=0;$i<count($links);$i++)
	{
		if($mode == $links[$i]["mode"]){
			$modpath = "../modules/".$links[$i]["tag"]."/";
			//echo $modpath.$links[$i]["file"];
			include_once($modpath.$links[$i]["file"]);
		}
	}
	echo "</div>";
	if($i==0)
	{
		echo "<div id='content'>";
		notifyerr("There Is No Such Page!");
		redirect("?");
		echo "</div>";
	}
}
}
echo "</div>";

?>

</body>

</html>
