<?php
function getChildMenu($otytag,$modname){
		
		$menus = getMenuItems($otytag,$modname);
		$stages = "<div class='well' style='float:left;margin-right:5%'>";
		$stages .= "<ul class='nav nav-list' >";
		$stages .= "<li class='nav-header'>Menu</li>";
		
		for($i=0;$i<count($menus);$i++){
		$stages .= "<li ><a class='active' href='".$menus[$i]["link"]."'>".$menus[$i]['title']."</a></li>";
		}
	$stages .=  "</ul></div>";
	return $stages;
}
function getMenu($otytag)
{  
  $retstr =  " <div class='page-header'>
   </div>
  <div class='topbar-wrapper' style='z-index: 5;'>
    <div class='topbar'>
      <div class='container fixed'>
        <a class='logo' href='?'>freeEdu<img src='../images/others/home.png' width='20'></a>";
        if(in_array($otytag,array("sudo","admin")))
	{
	  $retstr .= "<ul class='nav'>
	    <li class='menu'>
	      <a href='#' class='menu'>Batches</a>
	      <ul class='menu-dropdown'>";
	      
	      if($otytag == "sudo")
	      {
	        $retstr .= "<li><a href='?m=ba'>Add A Batch</a></li>
	        <li><a href='?m=up'>Upgrade Batches</a></li>
	        <li><a href='?m=sa'>Add A Subject List</a></li>
	        <li><a href='?m=al'>Add A Lateral Entry</a></li>";
	      }
	      else if($otytag = "admin")
	      {
		$retstr .= "<li><a href='?m=up'>Upgrade Batches</a></li>";
		
	      }
	      $titles1 = getMenuItems($otytag,'batch');
	
	  for($i=0;$i<count($titles1);$i++)
	    $retstr .= "<li><a href='".$titles1[$i]["link"]."'>".$titles1[$i]["title"]."</a></li>";
	
	$retstr .= "</ul>
             </li>
        </ul>
        <ul class='nav'>
          <li class='menu'>
            <a href='#' class='menu'>Faculty</a>
            <ul class='menu-dropdown'>";
	    if($otytag == "sudo")
	    {
	         $retstr .="<li><a href='?m=cf'>Create Faculty</a></li>
                 <li><a href='?m=mf&l=0&r=5'>Map Faculty</a></li>";
           
	    }
	    else if($otytag == "admin")
	    {
	      
		$retstr .= "<li><a href='?m=src&q=%&t=1'>See Faculty List</a></li>";
	    }
	       $titles1 = getMenuItems($otytag,'faculty');
	
	  for($i=0;$i<count($titles1);$i++)
	    $retstr .= "<li><a href='".$titles1[$i]["link"]."'>".$titles1[$i]["title"]."</a></li>";
            $retstr .= "</ul>
            
          </li>
        </ul>";
	  
	}
	if(in_array($otytag,array("sudo","admin","faculty","student")))
	{
	  $retstr .= "
	  <ul class='nav'>
            <li class='menu'>
              <a href='#' class='menu'>Attendance</a>
              <ul class='menu-dropdown'>";
	      if($otytag == "sudo" || $otytag == "admin")
	      {
                $retstr .= "<li><a href='?m=sc'>Design Schedules</a></li>
                         <li><a href='?m=dr'>Day Report</a></li>
                         <li><a href='?m=cr'>Consolidated Report</a></li>
	                    <li><a href='?m=str'>Student Report</a></li>";
	      }
	      if($otytag == "faculty")
	      {
                $retstr .= "<li><a href='?m=ua'>Upload Attendance</a></li>
	                    <li><a href='?m=edit_att'>Edit Attendance</a></li>
		            <li><a href='?m=fp'>See Your Plan</a></li>";
	      }
	      if($otytag == "student")
	      {
                $retstr .= "<li><a href='?m=see_att'>See Your Attendance</a></li>";
	      }
	         $titles1 = getMenuItems($otytag,'attendance');
	
	  for($i=0;$i<count($titles1);$i++)
	    $retstr .= "<li><a href='".$titles1[$i]["link"]."'>".$titles1[$i]["title"]."</a></li>";
		 $retstr .= "</ul>
	      
            </li>
          </ul>";
	  $retstr .= "<ul class='nav'>
          <li class='menu'>
            <a href='#' class='menu'>Marks</a>
            <ul class='menu-dropdown'>
            ";
	    if($otytag == "sudo")
	    {
	         $retstr .=" <li><a href='?m=ra'>Result Analysis</a></li>
			<li><a href='?m=ma'>Add Marks List</a></li>
		        <li><a href='?m=rr'>Record Retrieval</a></li>";
            
	    }
	    else if($otytag == "admin")
	    {
	      $retstr .=" <li><a href='?m=ra'>Result Analysis</a></li>
			
		        <li><a href='?m=rr'>Record Retrieval</a></li>";
            
	    }
	    else if($otytag == "faculty")
	    {
	      $retstr .=" <li><a href='?m=inc'>Calculate Internals</a></li>";
            
	    }
            else if($otytag == "student")
	    {
	      $retstr .="<li><a href='?m=see_marks'>See Marks</a></li>";
            
	    }
               $titles1 = getMenuItems($otytag,'marks');
	
	  for($i=0;$i<count($titles1);$i++)
	    $retstr .= "<li><a href='".$titles1[$i]["link"]."'>".$titles1[$i]["title"]."</a></li>";
              $retstr .= "</ul>
            
          </li>
        </ul>";
	
	}
	$x = getParentMenus($otytag);
	$retstr .= "<ul class='nav'>
          <li class='menu'>
            <a href='#'  class='menu' >Modules</a>
            
            <ul class='menu-dropdown'>";
	  
	for($i=0;$i<count($x);$i++){
		
			$retstr .= "<li><a href='".$x[$i]["link"]."'>".$x[$i]["title"]."</a></li>";
	}
	
            $retstr .= "</ul>
            
          </li></ul>
        ";
	if(in_array($otytag,array("sudo","admin","faculty","student","aadmin","ladmin")))
	{
	  $retstr .= "<ul class='nav'>
          <li class='menu'>
            <a href='#' class='menu'>Tools</a>
            <ul class='menu-dropdown'>";
	    if($otytag == "sudo")
	    {
                $retstr.=" <li><a href='?m=modules'>Manage Modules</a></li> <li><a href='?m=rga'>Add Regulation</a></li>
                 <li><a href='?m=suba'>Substitute Subjects</a></li>
                 <li><a href='?m=immap'>Assign Images To Subjects[**Experimental**]</a></li>
                 <li><a href='?m=create_student'>Create Username For Student</a></li>";
	    }
             $retstr.=   " <li><a href='?m=license' >License</a></li>
                 <li><a href='https://github.com/freeEdu/freeEdu' target='_blank'>Download Source</a></li>";
		  $titles = getMenuItems($otytag,'tools');
	  for($i=0;$i<count($titles);$i++)
	    $retstr .= "<li><a href='".$titles[$i]["link"]."'>".$titles[$i]["title"]."</a></li>";
                          
            $retstr .= "</ul>
            
          </li>
        </ul>";
        
        }
	$oid = $_COOKIE['object'];
  $retstr .=  "<form action='?m=os' method='post'>
          <input type='text' placeholder='Search' name='srch' />
        </form>";
      
$oarray = getObject($oid);
$retstr .= "<ul class='nav secondary-nav'>
          <li class='menu'>
            
            <a href='#' class='menu'><span class='profname'>
            ".$oarray["obname"]."
            </span></a>
            <ul class='menu-dropdown'>
               <li><a href='?m=cre' style='font-size:13px;'><b><i>@</i>Team-Alacrity</b></a></li> 
               <li><a href='?m=ep'>Edit Profile</a></li>
                <li><a href='../login.php'>Logout</a></li>";
	  $titles = getMenuItems($otytag,'user');
	  for($i=0;$i<count($titles);$i++)
	    $retstr .= "<li><a href='".$titles[$i]["link"]."'>".$titles[$i]["title"]."</a></li>";
$retstr .= "</ul>
          </li>
        </ul>
	
</div>
    </div>
    
  </div> <!-- topbar-wrapper -->";
return $retstr;
        
}

?>
