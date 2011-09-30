<?php

function getMarksGraph($srno)
{
    
    $array = tpercent($srno);
    //echo  $srno;
     echo "<script type='text/javascript'>
$(function () {
    var d1 = [";
    
    for($i=0;$i<(count($array)-1);$i++)
        echo  "[".$i.",".round($array[$i][1],2)."], ";    
    echo "];
    $.plot($('#placeholderm'), [
        {
        label: 'Classes',  data: d1},
           ], {
        series: {
            lines: { show: true },
            points: { show: true }
        },
        xaxis: {
           tickDecimals: 0,
           ticks: [";
           
           for($i=0;$i<(count($array)-1);$i++)
            echo "[".$i.",'".getFullClass($array[$i][0])."'],";
           
           echo "]
        },
        yaxis: {
            ticks: 10,
            tickDecimals: 0,
        },
        grid: {
            
            hoverable: true, clickable: true,
            }
        }
    );
});

    function showTooltip(x, y, contents) {
        $('<div id=\"tooltipm\">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo('body').fadeIn(200);
    }
    
     var previousPoint = null;
    $('#placeholderm').bind('plothover', function (event, pos, item) {
       

        
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;
                    
                    $('#tooltipm').remove();
                    var x = item.datapoint[0],
                    y = item.datapoint[1];
                    var date = item.series.xaxis.ticks[x].label
                    showTooltip(item.pageX, item.pageY,
                                'Scored '+y + ' % for '+date);
                }
            }
            else {
                $('#tooltipm').remove();
                previousPoint = null;            
            }
        
    });
</script>";
    
}

function getStuGraph($sid,$datein,$dateout)
{
    $clsname = "Constants";
    $con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
    mysql_select_db($clsname::$dbname, $con);
    $return = "";
    $bA = queryMe("SELECT batid,sec FROM MSTUDENTT WHERE sid like '".$sid."'");
    $batid = $bA["batid"];
    $sec = $bA["sec"];
    
    $i++;
    
    $query = "SELECT distinct sessionid from MATDT where batid like '".$batid."' and sec like '".$sec."' order by(sessionid)";
    $result = mysql_query($query);
    $prc = mysql_num_rows($result);
    $periods = array();
    while($row = mysql_fetch_array($result))
    {	
	$return .= "<th>Period-".$row['sessionid']."</th>";
	$periods[$i]=$row['sessionid'];
	$i++;
    }
    
    $dates = getDates($batid,$sec,$datein,$dateout);
    $classes = array();
    for($i=0;$i<count($dates);$i++)
    {
        $query = "SELECT aid FROM MATDT WHERE batid LIKE '".$batid."'
				AND sec LIKE '".$sec."'
				AND dayid like '".$dates[$i][0]."'";
        $result = mysql_query($query);
        $classes[$i]=0;
        while($row = mysql_fetch_array($result))
        {
           $parry = queryMe("SELECT adata,pa from ADATAT where aid like '".$row["aid"]."'");
	   $adata = $parry["adata"];
	   $pa = $parry["pa"];
	   $students = explode(".",$adata);
	   if($pa == "P" && in_array($sid,$students))
	   {
                $classes[$i]++;
	   }
           elseif($pa == "A" && !in_array($sid,$students))
           {
		$classes[$i]++;
					
	   }
	
            
        }
        
    }
   
    
    
    echo "<script type='text/javascript'>
$(function () {
    var d1 = [";
    
    for($i=0;$i<count($classes);$i++)
        echo  "[".$i.",".$classes[$i]."], ";    
    echo "];
    $.plot($('#placeholder'), [
        {
        label: 'Classes',  data: d1},
           ], {
        series: {
            lines: { show: true },
            points: { show: true }
        },
        xaxis: {
           tickDecimals: 0,
           ticks: [";
           
           for($i=0;$i<count($dates);$i++)
            echo "[".$i.",'".$dates[$i][1]."'],";
           
           echo "]
        },
        yaxis: {
            ticks: 10,
            tickDecimals: 0,
        },
        grid: {
            
            hoverable: true, clickable: true,
            }
        }
    );
});

    function showTooltip(x, y, contents) {
        $('<div id=\"tooltip\">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo('body').fadeIn(200);
    }
    
     var previousPoint = null;
    $('#placeholder').bind('plothover', function (event, pos, item) {
       

        
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;
                    
                    $('#tooltip').remove();
                    var x = item.datapoint[0],
                    y = item.datapoint[1];
                    var date = item.series.xaxis.ticks[x].label
                    showTooltip(item.pageX, item.pageY,
                                'Attended '+y + ' Classes on '+date);
                }
            }
            else {
                $('#tooltip').remove();
                previousPoint = null;            
            }
        
    });
</script>";
    
    
    
}
?>