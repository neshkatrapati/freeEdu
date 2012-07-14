<html>
    <body>
        <fieldset>
            <legend>Calculate Internals</legend>
            <center>
        <?php
        if(!isset($_POST['phase1']) && !isset($_POST['phase2']))
        {
             echo "<form action='#' method='post'>";
        
            $array = getObject($_COOKIE['object']); 
            $classes = getFacClasses("cls[]",$array['obhandle'],"");
            echo " Select Class : ".$classes."<br />";
            echo "<br />Number Of Internals :<input type='text' name='intc' required=true style='width:50px;'></input>&emsp;";
            echo "Best Of :<input type='text' name='best' required=true style='width:50px;'></input><br />";
            echo "<input type='hidden' name='fid' value='".$array['obhandle']."' />";
            echo "<br /><input type='submit' name='phase1' /  ></form>";
        }
        else if(isset($_POST['phase1']))
        {n
            $cls = $_POST['cls'][0];
            $clsa = explode(":",$cls);
            $batid = substr($clsa[0],0,1);
            $sec = substr($clsa[0],-1);
            $subid = $clsa[1];
            $intc = $_POST['intc'];
            $best = $_POST['best'];
	  
            if($intc < $best)
            {
                
                notifyerr("Number of Internals Lessthan Best Of Please Retry!"); //Put JavaScript.Sleep Here
                redirect("?m=inc");
                
            }
            $clsname = "Constants";
            $con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
            mysql_select_db($clsname::$dbname, $con);
            
	    $sarr = queryMe("select * from MSUBJECTT where subid like '".$subid."'");
	    $inmax = $sarr['inmax'];
	  
            $result = mysql_query("SELECT * from MSTUDENTT where batid like '".$batid."' and sec like '".$sec."'");
            echo "<form action='#' method='post'><table>
            <th>Students</th><th colspan='".($intc)."'>Internals</th>";
            while($row = mysql_fetch_array($result))
            {
                echo "<tr><td><table><tr><td><img src='../".getImgUri($row['imgid'])."' width='40' hieght='40' style='opacity:0.75;filter:alpha(opacity=75)'
			onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
			onmouseout='this.style.opacity=0.75;this.filters.alpha.opacity=75'></img>
                        <input type='hidden' name='img[]' value='../".getImgUri($row['imgid'])."' /></td><td>".$row['srno']."
                        <input type='hidden' name='srno[]' value='".$row['srno']."' /></td><td>".$row['sname']."<input type='hidden' name='sname[]' value='".$row['sname']."' />
                        </td></tr></table></td>";
                for($i=0;$i<$intc;$i++)
                    echo "<td><input type='number' name='ints[]' value='0'  max='".$inmax."'/></td>";
                echo "</tr>";
                
            }
            echo "</table><input type='hidden' name='best' value='".$best."' /><input type='hidden' name='intc' value='".$intc."' /><input type='hidden' name='subid' value='".$subid."' /><input type='submit' name='phase2' /></form>";
        }
        
        if(isset($_POST['phase2']))
        {
            
            $img = $_POST['img'];
            $sname = $_POST['sname'];
            $srno = $_POST['srno'];
            $ints = $_POST['ints'];
            $best = $_POST['best'];
            $intc = $_POST['intc'];
            
            echo "<form action='../lib/export.php' method='post' target='_blank'><table>
            <th>Students</th><th>Calculation</th>";
	    
	    $calc = array();
	    $n=0;
	    //print_r($ints)."<br>";
	    for($i=0;$i<count($ints);$i++)
	    {
		
		$arr[]=$ints[$i];
		if(count($arr)==$intc && $i!=0)
		{
		    $agg = getAgg(getBestOf($arr,$best));
		    //print_r(getBestOf($arr,$best));
		    $calc[$n] = round($agg,2);
		    $n++;
		    unset($arr);
		}
		
		
		
	    }
	    $calc[$n] = getAgg(getBestOf($arr,$best));
	    $n++;
	    unset($arr);
	   
            for($i=0;$i<count($sname);$i++)
            {
                echo "<tr><td><table><tr><td><img src='".$img[$i]."' width='40' hieght='40' style='opacity:0.75;filter:alpha(opacity=75)'
			onmouseover='this.style.opacity=1;this.filters.alpha.opacity=100'
			onmouseout='this.style.opacity=0.75;this.filters.alpha.opacity=75'></img>
                       <td>".$srno[$i]."
                        <input type='hidden' name='srno[]' value='".$srno[$i]."' /></td><td>".$sname[$i]."<input type='hidden' name='sname[]' value='".$sname[$i]."' />
                        </td></tr></table></td>";
                        echo "<td><input type='text' name='ints[]' value='".$calc[$i]."'/></td>";
                
		
                echo "</tr>";
		
                
            }
            echo "</table><input type='submit' name='phase2' /></form>";
            
       
        }
	
	function getBestOf($array,$best)
	{
	    
	    $b = sort($array,SORT_NUMERIC);
	    $array = array_reverse($array);
	    $c = array();
	    for($i=0;$i<$best;$i++)
	    {
		$c[$i] = $array[$i];
		
	    }
	    return $c;
	    
	}
	function getAgg($arr)
	{
	    return array_sum($arr)/count($arr);
	    
	}
        ?>
        </fieldset>
    </body>
</html>
