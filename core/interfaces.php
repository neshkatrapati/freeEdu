<?php
    function freeedu_boxes($otyid)
    {
        if($otyid == "0")
            $array = array("right" => array("rayon_Box","roster_Box"));
        if($otyid == "1")
            $array = array("right" => array("fac_plan_Box","assignments_Box"));
        if($otyid == "2")
            $array = array("right" => array("subjects_fac_Box"));
        
        return $array;    
    }

?>