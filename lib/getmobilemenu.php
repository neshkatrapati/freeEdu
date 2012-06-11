<?php
function getMenu($otytag)
{  
  $retstr =  " <div class='page-header'>
   </div>
  <div class='topbar-wrapper' style='z-index: 5;'>
    <div class='topbar' style='width:100%'>
      <div class='container fixed'>
        <a class='logo' href='?'>freeEdu<img src='../images/others/home.png' width='20'></a>";
    
$retstr .= "<ul class='nav secondary-nav'>
          
            
            <li><a href='?m=mobilemenu' class='menu'><img src='../images/others/cog.svg'></img></a></li>
           
	
</div>
    </div>
    
  </div> <!-- topbar-wrapper -->";
return $retstr;
        
}

?>

