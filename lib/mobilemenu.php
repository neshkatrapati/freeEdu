
<?php
	echo "<link href='../aux/bootstrap/css/bootstrap.css' rel='stylesheet' type='text/css'></link>";
	echo "<script>$(\".accordion2\").collapse();</script>";
	echo "<center>";
	echo "<div class='accordion' id='accordion2'>";
	
	function getTemplate($number,$heading,$items){
		 $r = "<div class='accordion-group'><div class='accordion-heading'><a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#collapse$number'>$heading</a></div><div id='collapse$number' class='accordion-body collapse' style='height: 0px; '><div class='accordion-inner'><ul>";
         for($i=0;$i<count($items);$i++){
				
				$link = $items[$i]["link"];
				$text = $items[$i]["text"];
				$r .= "<li><a href='$link'>$text</a></li>";
		 }         
         $r .="</ul></div></div></div>";
		 return $r;
	}
	
	$object = getObject(getCurrentObject());
	$otytag = getObjectTypeTag($object["otyid"]);
	
	
	if(in_array($otytag,array("sudo","admin")))
	{
	      $c = 0;
	      if($otytag == "sudo")
	      {
			  
			$items[$c]["text"] = "Add A Batch";
			$items[$c]["link"] = "?m=ba";
			$c++;
			$items[$c]["text"] = "Upgrade Batches";
			$items[$c]["link"] = "?m=up";
			$c++;
			$items[$c]["text"] = "Add A Subject List";
			$items[$c]["link"] = "?m=sa";
			$c++;
			$items[$c]["text"] = "Add A Lateral Entry";
			$items[$c]["link"] = "?m=al";
			$c++;
			
	      }
	      else if($otytag = "admin"){
			$items[$c]["text"] = "Upgrade Batches";
			$items[$c]["link"] = "?m=up";
			$c++;
			
		
	      }
	      $titles1 = getMenuItems($otytag,'batch');
	
	  for($i=0;$i<count($titles1);$i++){
		  
	    $items[$c]["text"] = $titles1[$i]["title"];
	    $items[$c]["link"] = $titles1[$i]["link"];
	    $c++;
	   }
	   echo getTemplate(0,"Batches",$items);
	   unset($items);
	   $c = 0;
	   
	    if($otytag == "sudo")
	    {
	         $items[$c]["text"] = "Create Faculty"; 
	         $items[$c]["link"] = "?m=cf";
	         $c++;
	         $items[$c]["text"] = "Map Faculty"; 
	         $items[$c]["link"] = "?m=mf&l=0&r=5";
	         $c++;
                 
                 
	    }
	    else if($otytag == "admin")
	    {
			$items[$c]["text"] = "See Faculty List"; 
	        $items[$c]["link"] = "?m=src&q=%&t=1";
	        $c++;
            
	    }
	       $titles1 = getMenuItems($otytag,'faculty');
	
	  for($i=0;$i<count($titles1);$i++){
		  
	    $items[$c]["text"] = $titles1[$i]["title"];
	    $items[$c]["link"] = $titles1[$i]["link"];
	    $c++;
	   }
	     echo getTemplate(1,"Faculty",$items);
	 
	}
	if(in_array($otytag,array("sudo","admin","faculty","student")))
	{
	   unset($items);
	   $c = 0;
	   
	      if($otytag == "sudo" || $otytag == "admin")
	      {
			$items[$c]["text"] = "Design Schedules";
			$items[$c]["link"] = "?m=sc";
			$c++;
			$items[$c]["text"] = "Day Report";
			$items[$c]["link"] = "?m=dr";
			$c++;
			$items[$c]["text"] = "Consolidated Report";
			$items[$c]["link"] = "?m=cr";
			$c++;
			$items[$c]["text"] = "Student Report";
			$items[$c]["link"] = "?m=str";
			$c++;
	      }
	      if($otytag == "faculty")
	      {
			  
			$items[$c]["text"] = "Upload Attendance";
			$items[$c]["link"] = "?m=ua";
			$c++;
			$items[$c]["text"] = "Edit Attendance";
			$items[$c]["link"] = "?m=edit_att";
			$c++;
			$items[$c]["text"] = "See Your Plan";
			$items[$c]["link"] = "?m=fp";
			$c++;
			
            
	      }
	      if($otytag == "student")
	      {
			 $items[$c]["text"] = "See Your Attendance";
			 $items[$c]["link"] = "?m=see_att";
			 $c++;
			
             
	      }
	         $titles1 = getMenuItems($otytag,'attendance');
	
		  for($i=0;$i<count($titles1);$i++){
		  
	    $items[$c]["text"] = $titles1[$i]["title"];
	    $items[$c]["link"] = $titles1[$i]["link"];
	    $c++;
	   }
	   echo getTemplate(2,"Attendance",$items);
  
	   unset($items);
	   $c = 0;
	    if($otytag == "sudo")
	    {
			$items[$c]["text"] = "Result Analysis";
			$items[$c]["link"] = "?m=ra";
			$c++;
			$items[$c]["text"] = "Add Marks List";
			$items[$c]["link"] = "?m=ma";
			$c++;
			$items[$c]["text"] = "Record Retrieval";
			$items[$c]["link"] = "?m=rr";
			$c++;
			
            
	    }
	    else if($otytag == "admin")
	    {
			$items[$c]["text"] = "Result Analysis";
			$items[$c]["link"] = "?m=ra";
			$c++;
			$items[$c]["text"] = "Record Retrieval";
			$items[$c]["link"] = "?m=rr";
			$c++;
		
            
	    }
	    else if($otytag == "faculty")
	    {
				$items[$c]["text"] = "Calculate Internals";
			$items[$c]["link"] = "?m=inc";
			$c++;
		
            
	    }
        else if($otytag == "student")
	    {
				$items[$c]["text"] = "See Marks";
			$items[$c]["link"] = "?m=see_marks";
			$c++;
		
	      
            
	    }
               $titles1 = getMenuItems($otytag,'marks');
	
	  for($i=0;$i<count($titles1);$i++){
		  
	    $items[$c]["text"] = $titles1[$i]["title"];
	    $items[$c]["link"] = $titles1[$i]["link"];
	    $c++;
	   }
	   echo getTemplate(3,"Marks",$items);
	   unset($items);
	   $c = 0;
	  
	}
	$x = getParentMenus($otytag);
	
	for($i=0;$i<count($x);$i++)
	{

	  $titles = getMenuItems($otytag,$x[$i]["tag"]);
	  for($j=0;$j<count($titles);$j++){
		  
	    $items[$c]["text"] = $titles[$j]["title"];
	    $items[$c]["link"] = $titles[$j]["link"];
	    $c++;
	   }
	   echo getTemplate(4+$i,$x[$i]["title"],$items);
	   unset($items);
	   $c = 0;
	  
	  
	}
	
?>
<body>

</div>
</body>
