<?php
function getSudoMenu()
{  
  $retstr =  " <div class='page-header'>
   
  </div>
  
  <div class='topbar-wrapper' style='z-index: 5;'>
    <div class='topbar'>
      <div class='container fixed'>
        <h3><a class='logo' href='?'>freeEdu</a></h3>
         
        <ul class='nav'>
          <li class='menu'>
            <a href='#' class='menu'>Batches</a>
            <ul class='menu-dropdown'>
              <li><a href='?m=ba'>Add A Batch</a></li>
                        <li><a href='?m=up'>Upgrade Batches</a></li>
                        <li><a href='?m=sl'>See Students List</a></li>
                        <li><a href='?m=sa'>Add A Subject List</a></li>
              
            </ul>
            
          </li>
        </ul>
        <ul class='nav'>
          <li class='menu'>
            <a href='#' class='menu'>Faculty</a>
            <ul class='menu-dropdown'>
               <li><a href='?m=cf'>Create Faculty</a></li>
                        <li><a href='?m=mf&l=0&r=5'>Map Faculty</a></li>
            </ul>
            
          </li>
        </ul>
        
        <ul class='nav'>
          <li class='menu'>
            <a href='#' class='menu'>Marks</a>
            <ul class='menu-dropdown'>
              
                       <li><a href='?m=ra'>Result Analysis</a></li>
			<li><a href='?m=ma'>Add Marks List</a></li>
							  <li><a href='?m=rr'>Record Retrieval</a></li>
              
            </ul>
            
          </li>
        </ul>
        
       
        <ul class='nav'>
          <li class='menu'>
            <a href='#' class='menu'>Attendance</a>
            <ul class='menu-dropdown'>
              <li><a href='?m=sc'>Design Schedules</a></li>
                       <li><a href='?m=dr'>Day Report</a></li>
                       <li><a href='?m=cr'>Consolidated Report</a></li>
                        <li><a href='?m=str'>Student Report</a></li> 
            </ul>
            
          </li>
        </ul>
        
        <ul class='nav'>
          <li class='menu'>
            <a href='#' class='menu'>Tools</a>
            <ul class='menu-dropdown'>
                 <li><a href='?m=rga'>Add Regulation</a></li>
            </ul>
            
          </li>
        </ul>
        
        <form action='?m=os' method='post'>
          <input type='text' placeholder='Search' name='srch' />
        </form>";
          $oid = $_COOKIE['object'];

$oarray = getObject($oid);
$retstr .= " <ul class='nav secondary-nav'>
          <li class='menu'>
            
            <a href='#' class='menu'><span class='profname'>
            ".$oarray["obname"]."
            </span></a>
            <ul class='menu-dropdown'>
                
               <li><a href='?m=ep'>Edit Profile</a></li>
                <li><a href='../login.php'>Logout</a></li>
            </ul>
            
          </li>
        </ul>
</div>
    </div>
  </div> <!-- topbar-wrapper -->";
return $retstr;
        
}
function getAdminMenu()
{
  $retstr =  " <div class='page-header'>
    
  </div>
  
  <div class='topbar-wrapper' style='z-index: 5;'>
    <div class='topbar'>
      <div class='container fixed'>
        <h3><a class='logo' href='?'>freeEdu</a></h3>
         
        <ul class='nav'>
          <li class='menu'>
            <a href='#' class='menu'>Batches</a>
            <ul class='menu-dropdown'>
                         <li><a href='?m=up'>Upgrade Batches</a></li>
          </ul>
            
          </li>
        </ul>
        <ul class='nav'>
          <li class='menu'>
            <a href='#' class='menu'>Faculty</a>
            <ul class='menu-dropdown'>
               <li><a href='?m=fl'>See Faculty List</a></li>
            </ul>
            
          </li>
        </ul>
        
        <ul class='nav'>
          <li class='menu'>
            <a href='#' class='menu'>Marks</a>
            <ul class='menu-dropdown'>
                <li><a href='?m=ra'>Result Analysis</a></li>
		      
		       <li><a href='?m=rr'>Record Retrieval</a></li>
              
            </ul>
            
          </li>
        </ul>
        
       
        <ul class='nav'>
          <li class='menu'>
            <a href='#' class='menu'>Attendance</a>
            <ul class='menu-dropdown'>
              <li><a href='?m=sc'>Design Schedules</a></li>
                       <li><a href='?m=dr'>Day Report</a></li>
                       <li><a href='?m=cr'>Consolidated Report</a></li>
                        <li><a href='?m=str'>Student Report</a></li> 
            </ul>
            
          </li>
        </ul>
        
     
         <form action='?m=os' method='post'>
          <input type='text' placeholder='Search' name='srch'/>
        </form>";
        
        $oid = $_COOKIE['object'];

$oarray = getObject($oid);
$retstr .= " <ul class='nav secondary-nav'>
          <li class='menu'>
            
            <a href='#' class='menu'><span class='profname'>
            ".$oarray["obname"]."
            </span></a>
            <ul class='menu-dropdown'>
                
               <li><a href='?m=ep'>Edit Profile</a></li>
                <li><a href='../login.php'>Logout</a></li>
            </ul>
            
          </li>
        </ul>
</div>
    </div>
  </div> <!-- topbar-wrapper -->";
return $retstr;
}

function getFacMenu()
{
 $retstr =  " <div class='page-header'>
    
  </div>
  
  <div class='topbar-wrapper' style='z-index: 5;'>
    <div class='topbar'>
      <div class='container fixed'>
        <h3><a class='logo' href='?'>freeEdu</a></h3>
       <ul class='nav'>
          <li class='menu'>
            <a href='#' class='menu'>Attendance</a>
            <ul class='menu-dropdown'>
              <li><a href='?m=ua'>Upload Attendance</a></li>
<li><a href='?m=fp'>See Your Plan</a></li>
            </ul>
            
          </li>
        </ul>
        
     
         <form action='?m=os' method='post'>
          <input type='text' placeholder='Search' name='srch' />
        </form>";
        
        $oid = $_COOKIE['object'];

$oarray = getObject($oid);
$retstr .= " <ul class='nav secondary-nav'>
          <li class='menu'>
            
            <a href='#' class='menu'><span class='profname'>
            ".$oarray["obname"]."
            </span></a>
            <ul class='menu-dropdown'>
                
               <li><a href='?m=ep'>Edit Profile</a></li>
                <li><a href='../login.php'>Logout</a></li>
            </ul>
            
          </li>
        </ul>
</div>
    </div>
  </div> <!-- topbar-wrapper -->";
return $retstr;
}
function getMenu()
{
	
	$oid = $_COOKIE['object'];
	$oarray = getObject($oid);
	if($oarray['otyid']==4)
		return getSudoMenu();
	else if($oarray['otyid']==1)
		return getFacMenu();
        else if($oarray['otyid']==3)
		return getAdminMenu();


}
?>
