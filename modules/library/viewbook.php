<html>
    <head>
        <link rel="stylesheet" href="../modules/library/libStyle.css" type="text/css" media="screen" />
        <script type="text/javascript">
	function showUser(branch,reg,search)
	{
	    if (branch=="" && reg=="" && search=="")
	    {
		document.getElementById("txtHint").innerHTML="Note : Books will be shown here";
		return;
	    }
            else if(branch=="-1" && reg=="-1" && search=="")
            {
		document.getElementById("txtHint").innerHTML="";
		return;
	    } 
	    if (window.XMLHttpRequest)
	    {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	    }
	    else
	    {// code for IE6, IE5
	      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	    }
	    xmlhttp.onreadystatechange=function()
	    {
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		}
	    }
	    xmlhttp.open("GET","../modules/library/viewNext.php?branch="+branch+"&reg="+reg+"&search="+search,true);
	    xmlhttp.send();
	}        
	</script>
    </head>
<body>
   
    <center>
        <?php
        
            include_once('library_lib.php');
        
            echo "<center>";
            echo "<fieldset>";
            echo "<legend>Available Books in the Library</legend>";
            echo "<form action='#' method='post' name='f1'>";
            echo "<h5>Select the following filters</h5>";
            
            echo "Search :<input type='text' name='search' AUTOCOMPLETE=OFF onkeyup='showUser(branch.value,reg.value,this.value)'><br><br><br>";
            $arr=getBranches();
	    $len=count($arr);
            echo "Branch :<select name='branch' onchange='showUser(this.value,reg.value,search.value)'>";
            echo "<option value='-1'>--Select the Branch--</option>";
            for($i=0;$i<$len;$i++)
	    {
		$br=mysql_query("select brid from MBRANCHT where brname='$arr[$i]'") or die(mysql_error());
		$branch=mysql_fetch_array($br);
		$brid=$branch['brid'];
		echo "<option value='$brid'>$arr[$i]</option>";
	    }
	    echo "</select>&nbsp&nbspRegulation:";
	    $reg=getRegulations();
	    $rlen=count($reg);
	    echo "<select name='reg' onchange='showUser(branch.value,this.value,search.value)'>";
            echo "<option value='-1'>--Select the Regulation--</option>";
	    for($i=0;$i<$rlen;$i++)
	    {
		$r=mysql_query("select * from MREGT where regname='$reg[$i]'") or die(mysql_error());
		$rg=mysql_fetch_array($r);
		$regid=$rg['regid'];
		echo "<option value='$regid'>$reg[$i]</option>";
	    }
	    echo "</select>&nbsp&nbsp";
            echo "</fieldset>";
            echo "<br><br><br><br><div id='txtHint'>Note : Books will be shown here.</div><br>";
            echo "</form>";
            ?>
  
    </center>
</body>
</html>
