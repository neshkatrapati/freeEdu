<?php
    function freeedu_boxes($otyid)
    {
        if($otyid == "0")
            $array = array("rayon_Box","roster_Box");
         if($otyid == "1")
            $array = array("fac_plan_Box","assignments_Box");
        return $array;    
    }

?>