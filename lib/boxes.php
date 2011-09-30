<?php
class freeEdu_box
    {
	
	public $name = "FreeEdu-Box";
	public $module = "freeedu.mod_core";
	public $classinfo= "box";
	public $floatinfo ="right";
	private $object = "";
	
	public function __construct($oid)
	{
	   // xDebug("Hello World!");
	    $this->object = $oid;
	    
	}
	public function box_oncollapse()
	{
		
		
	}
	public function box_onexpand()
	{
		
		
	}
	
    }
    class rayon_Box extends freeEdu_box
    {
	
	public $name = "Marks Graph";
	public $module = "freeedu.mod_rayon";
	public $classinfo= "box";
	public $floatinfo ="right";
	private $object = "";
	public $defstate_e = "none";
	public $defstate_c = "block";
	
	public function __construct($oid)
	{
	    $this->object = $oid;
	    //$this->defstate = $defstate;

	}
	public function box_oncollapse()
	{
		return "Expand To See The Marks Graph";	
		
	}
	public function box_onexpand()
	{
		$ob = getObject($this->object);
		$array = getStudent($ob["obhandle"]);
	
		return "<div id='placeholderm' style='width:450px;height:250px'></div><p id='hoverdata'>
		<span id='clickdata'></span></p>".getMarksGraph($array["srno"]);
		
	}
	
    }
    class roster_Box extends freeEdu_box
    {
	
	public $name = "Attendance Graph";
	public $module = "freeedu.mod_roster";
	public $classinfo= "box";
	public $floatinfo ="right";
	private $object = "";
	public $defstate_e = "block";
	public $defstate_c = "none";
	
	public function __construct($oid)
	{
	    $this->object = $oid;
	    //$this->defstate = $defstate;

	}
	public function box_oncollapse()
	{
		return "Expand To See The Attendance Graph";	
		
	}
	public function box_onexpand()
	{
		$ob = getObject($this->object);
		$array = getStudent($ob["obhandle"]);
		//print_r($array);
		return "<div id='placeholder' style='width:450px;height:250px'></div>".getStuGraph($array["sid"],strtotime("-4 week"),strtotime("now"));
		
	}
	
    }
     class fac_plan_Box extends freeEdu_box
    {
	
	public $name = "Classes Taken By This Faculty";
	public $module = "freeedu.mod_roster";
	public $classinfo= "box";
	public $floatinfo ="right";
	private $object = "";
	public $defstate_e = "none";
	public $defstate_c = "block";
	
	public function __construct($oid)
	{
	    $this->object = $oid;
	    //$this->defstate = $defstate;

	}
	public function box_oncollapse()
	{
		return "Expand To See The Classes";	
		
	}
	public function box_onexpand()
	{
		$ob = getObject($this->object);
		$array = getFaculty($ob["obhandle"]);
		//print_r($array);
		return getFacPlan($array["fid"]);
		
	}
	
    }
    class assignments_Box extends freeEdu_box
    {
	
	public $name = "Assignments Created By This Faculty";
	public $module = "freeedu.mod_assignment";
	public $classinfo= "box";
	public $floatinfo ="right";
	private $object = "";
	public $defstate_e = "none";
	public $defstate_c = "block";
	
	public function __construct($oid)
	{
	    $this->object = $oid;
	    //$this->defstate = $defstate;

	}
	public function box_oncollapse()
	{
		//include("../modules/assignment/as_lib.php");
		$entries = getAssignmentEntries($this->object);
		
		return "Created ".count($entries)." Assignments <br>Expand To See The Assignments";	
		
	}
	public function box_onexpand()
	{
		include("../modules/assignment/as_lib.php");
		$ob = getObject($this->object);
		$entries = getAssignmentEntries($this->object);
		$ret = "";
		if(count($entries)!=0)
	        {
	            $ret .= "<table class='bttable' border='1'>";
		    $ret .= "<th class='blue'>Assignment Name</th>";
		    $ret .= "<th class='blue'>Subject</th>";
		    $ret .= "<th class='blue'>Created Date</th>";
		    $ret .= "<th class='blue'>Actions</th>";
	          
		    for($i=0;$i<count($entries);$i++)
		    {   
           
		       $ret .= "<tr>";
		       $ret .= "<td><a href='".$entries[$i]["Link"]."'>".$entries[$i]['Name']."</a></td>";
		       $asid = $entries[$i]["Id"];
		       $subject = getSubject($entries[$i]['subid']);
		       $subname =  $subject["subname"];
		       $object = getObjectByType('2',$entries[$i]["subid"]);
		       $oid = $object["oid"];
		       $ret .= "<td><a href='?m=p&id=".$oid."'>".$subname."</a></td>";
		       $ret .= "<td>".$entries[$i]["cdate"]."</td>";
		       $ret .= "<td><a href='?m=ass_see&asid=".$asid."'>See</a>&emsp;|&emsp;<a href='?m=ass_edit&asid=".$asid."'>Edit</a></td>";
		       $ret .= "</tr>";
           
           
		    }
	    $ret .= "</table>";
	    return $ret;
			
	    }
	
        }
    }
?>