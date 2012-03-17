<?php
    function freeedu_boxes($otyid)
    {
        if($otyid == "0")
            $array = array("right" => array("roster_Box","rayon_Box"));
        if($otyid == "1")
            $array = array("right" => array("fac_plan_Box","assignments_Box"));
        if($otyid == "2")
            $array = array("right" => array("subjects_fac_Box"));
        if($otyid == "3")
            $array = array("right" => array("assignments_Box"));
        if($otyid == "4")
            $array = array("right" => array("assignments_Box"));
            
        $array["right"][] = "stream_Box";
        return $array;    
    }

?>
