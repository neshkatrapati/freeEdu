<?php

    /*
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
along with FreeEdu.  If not, see <http://www.gnu.org/licenses/>.*/
    include("fb_lib.php");
    $object = getObject($_COOKIE["object"]);
    $student = getStudent($object["obhandle"]);
    $batid = $student["batid"];
    $sec = $student["sec"];
    if(!isset($_GET['fbid']) && !isset($_POST["postbtn"]))
    {
       
    
        $entries = getFeedbackEntries($batid,$sec);
        echo "<table class='bttable' border='1'>";
        echo "<th class='blue'>Feedback Form Name</th>";
        echo "<th class='blue'>Creation Date</th>";
        echo "<th class='blue'>Subbmitable By:</th>";
         echo "<th class='blue'>Submitted?</th>";
        for($i=0;$i<count($entries);$i++)
        {
            
            echo "<tr>";
            if(!checkSubmitted($entries[$i]["Id"],$object["obhandle"]))
            {
                echo "<td><a href='".$entries[$i]["Link"]."'>".$entries[$i]['Name']."</a></td>";
                echo "<td>".$entries[$i]["Cdate"]."</td>";
                echo "<td>".$entries[$i]["Edate"]."</td>";
                echo "<td><center>No</center></td>";
            }
            else{
                echo "<td>".$entries[$i]['Name']."</td>";
                echo "<td>".$entries[$i]["Cdate"]."</td>";
                echo "<td>".$entries[$i]["Edate"]."</td>";
                echo "<td><center>Yes</center></td>";
            }
            echo "</tr>";
            
            
        }
        echo "</table>";
    }
    else if(isset($_GET["fbid"]) && !isset($_POST["postbtn"]))
    {
    
        $fbid = $_GET["fbid"];    
        $fbentry = getFeedbackEntry($fbid);
    
        if($batid!=$fbentry['batid'] || $sec!=$fbentry["sec"])
        {
            
            notifyerr("You Are Unauthorized To View This Page!");
            redirect("?m=fbput");
            
        }
        
    
        else
        {
            $get = getFacultyForClass($batid,$sec);
            echo "<form action='#' method='post'>";
            echo "<table class='bttable' border=1>";
            echo "<th class='blue'>Faculty</th>";
            echo "<th class='blue'>Rating</th>";
            echo "<th class='blue'>Faculty</th>";
            echo "<th class='blue'>Rating</th>";
            $fbmin = $fbentry["fbmin"];
            $fbmax = $fbentry["fbmax"];
            $l=0;
            for($i=0;$i<count($get);$i++)
            {
                $name = $get[$i]["Name"];
                $id = $get[$i]["Id"];
                $imguri = $get[$i]["imguri"];
                
                $object = getObjectByType(getFacultyType(),$id);
                $url = "m=p&id=".$object["oid"];
                
                $ret = "<select name='rating[][]'>";
                
                    for($j=$fbmin;$j<=$fbmax;$j++)
                    {
                    $ret .= "<option value='".$j.":".$id."'>".$j."</option>";
                    
                    }
                 $ret.="</select>";
            
                if($i%2==0)
                    echo "<tr>";
                echo "<td><div class='img'><img src='../".$imguri."' width='100' height='100' style='padding-right:5px;z-index:1'></img><div class='desc'>".$name."</div></div></td>";
                echo "<td>".$ret."</td>";
                if($i%2==1){
                    echo "</tr>";
                    $l=0;
                }
                $l++;
            }
            echo "</table><br><input type='submit' name='postbtn'></input>
            <input type='hidden' name='fbid' value='".$fbid."'></input>
            </form>";
            
            
        }
        
    }
    else if(isset($_POST["postbtn"]))
    {
        
        $rating = $_POST["rating"];
        //print_r($rating);
        $feedback = array();
        for($i=0;$i<count($rating);$i++)
        {
            $data = explode(":",$rating[$i][0]);
            $rate = $data[0];
            $fid = $data[1];
            
            $feedback[$i] = array();
            $feedback[$i]["rating"] = $rate;
            $feedback[$i]["fid"] = $fid;
            
        }
        //print_r($feedback);
        putFeedback($object["obhandle"],$feedback,$_POST["fbid"]);
        notify("Feedback Submitted!");
        redirect("?m=fbput");
        
    }
?>  