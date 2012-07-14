<?php
	function postToStream($object,$message,$targets){
			
			$query = "SELECT * FROM MSTREAMT";
			$result = mysql_query($query);
			$rows = mysql_num_rows($result);
			$date = strtotime("now");
			$query = "INSERT INTO MSTREAMT VALUES($rows,\"".$message."\",$object,'".$targets."','".$date."')";
			echo $query;
			return mysql_query($query);
	}
	function getStream($object){
			$query = "SELECT * FROM MSTREAMT ORDER BY(sid) DESC";
			$result = mysql_query($query);
			$ret = "<table class='table'><th colspan='3'><h2>Your Stream!</h2></th>";
			while($row = mysql_fetch_array($result)){
				$o = getObject($row["oid"]);
				$id = $row["oid"];
				$im = getImgUri($o["oimgid"]);
				$ret .= "<tr><td><img width='50' height='50' src='../$im'></img></td><td><b style='color:black'><a href='?m=p&id=$id' target='_blank'>".$o["obname"]."</a></b><br>".$row["message"]."</td><td>".dateify($row["postedon"])."</td></tr>";
				
			}
			$ret .= "</table>";
			return $ret;
		
	}
	function getStreamByObject($object){
			$query = "SELECT * FROM MSTREAMT WHERE oid=$object ORDER BY(sid) DESC";
			$result = mysql_query($query);
			$ret = "<table class='table' style='width:300px;'>";
			while($row = mysql_fetch_array($result)){
				$o = getObject($row["oid"]);
				$id = $row["oid"];
				$im = getImgUri($o["oimgid"]);
				$ret .= "<tr><td>".$row["message"]."</td><td>".dateify($row["postedon"])."</td></tr>";
				
			}
			$ret .= "</table>";
			return $ret;
		
	}
	function dateify($date){
			$d = date("Y-m-d h:i",$date);
			return time_difference($d);
			
	}
	function time_difference($date){
		if(empty($date)) {
			return "No date provided";
		}
		$periods         = array("second","minute", "hour", "day", "week", "month", "year", "decade");
		$lengths         = array("60","60","24","7","4.35","12","10");
		$now             = time();
		$unix_date         = strtotime($date);
		 if($now > $unix_date) {
        $difference = $now - $unix_date;
        $tense = "ago";} 
        else {
        $difference = $unix_date - $now;
        $tense = "from now";}
        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];}
			$difference = round($difference);
			if($difference != 1) {
				$periods[$j].= "s";
			}
		if($j == 0)
			return "A few seconds Ago";
		return "$difference $periods[$j] {$tense}";
 
	}
	
?>
