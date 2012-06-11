<script type="text/javascript">
window.onload = function(){
	new JsDatePick({
		useMode:2,
		target:"inputField",
		limitToToday:true,
		dateFormat:"%d-%M-%Y",
		imgPath:"../aux/calendar/img/"
			
	});
};
</script>
<?php
require_once '../lib/mod_lib.php';
$keys = getConfigKeys(getAuthToken("portcullis"));
if(!array_key_exists('dbname', $keys) || !array_key_exists('dbpass', $keys)
|| !array_key_exists('dbuser', $keys))
{
	notifyerr("<b >Module Not Configured Properly!</b>");
	redirect("?m=modules");
}
$dbname = $keys["dbname"][1];
$dbuser = $keys["dbuser"][1];
$dbpass = $keys["dbpass"][1];
$conx = mysql_connect("localhost",$dbuser,$dbpass);
mysql_select_db($dbname, $conx);

?>
<fieldset>
	<legend>Import From A Portcullis Database</legend>
	<body>
		<center>
			
			
		<?php
		if($_GET["tabid"]==NULL){

			echo "<div class='box' style='width:60%'>";
			echo  "<h3 class='label success'>Available Results</h3>";
			echo "<form action='#' class='uniForm' method='post'>";
			$q = mysql_query("select * from MRESULTT",$conx);
			echo "<table class='bttable'>";
			while($row = mysql_fetch_array($q))
			{
				echo "<tr><td>";
				$table = $row["rtabname"];
				$resname = $row["rname"];
				echo "<a href='?m=marks_portcullis&tabid=".$table."' style='display:block'>".$resname."</a><br>";
				echo "</td></tr>";
			}
		}
		else{
			$result = mysql_query("select * from ".$_GET['tabid']);
			echo "<form action='' method='post'>";
			echo "<h3 class='label success'>These Following Student Records Were Recognized Submit To Import</h3>";
			
			echo "Date Of Exam :<input type='text' id='inputField'></input>&emsp;<input type='submit' class='btn primary'></input><br>";
			echo "<br><br><br><table class='bttable'>";
			echo "<th class='zebra-striped' colspan='2'>Name</th>";
			echo "<th class='zebra-striped'>Subject</th>";
			echo "<th class='zebra-striped'>Internals</th>";
			echo "<th class='zebra-striped'>Externals</th>";
			echo "<th class='zebra-striped'>Credits</th>";
			while ($row = mysql_fetch_array($result)) {
				
			
			
				$x = lookupStudent($row['srno']);
				if($x != "false"){
					echo "<tr>";
					$name = $x['sname'];
					$sid =  $x['sid'];
					$subject = $row["subname"];
					$intm = $row["intm"];
					$extm = $row["extm"];
					$cre = $row["cre"];
					$imgurl = getImageURL($x['imgid']);
					echo "<td><img src='../$imgurl' width='50' height='50'></img></td>";
					echo "<td>$name</td>";
					echo "<td>$subject</td>";
					echo "<td>$intm</td>";
					echo "<td>$extm</td>";
					echo "<td>$cre</td>";
					echo "</tr>";
				}
				
			}
			echo "</table>";
			echo "</form>";
		}
		?>
			</div>
		</center>
		<?php 
			function lookupStudent($srno){
				//echo "select * from freeEdu.MSTUDENTT s where s.srno like '$srno' ";
				$res = mysql_query("select * from freeEdu.MSTUDENTT s where s.srno like '$srno' ");
				if(mysql_num_rows($res)<=0)
					return "false";
				return mysql_fetch_array($res);
			}
			function getImageURL($imgid){
				//echo "select * from freeEdu.MSTUDENTT s where s.srno like '$srno' ";
				$res = mysql_query("select * from freeEdu.MIMGT s where s.imgid like '$imgid' ");
				if(mysql_num_rows($res)<=0 )
				return "images/faces/student.png";
				$y =  mysql_fetch_array($res);
				if(!file_exists("../".$y['imguri'])){
					return "images/faces/student.png";
				}
				return $y['imguri'];
			}
		?>
	</body>
</fieldset>
