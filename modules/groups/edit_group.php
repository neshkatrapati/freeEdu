<html>
<head>
	<title>Edit Group</title>
	<style type=text/css>
.imgteaser {
	margin: 0;
	overflow: hidden;
	float: left;
	position: relative;
}
.imgteaser a {
	text-decoration: none;
	float: left;
}
.imgteaser a:hover {
	cursor: pointer;
}
.imgteaser a img {
	float: left;
	margin: 0;
	border: none;
	padding: 10px;
	background: #fff;
	border: 1px solid #ddd;
	position: relative;
	
}
.imgteaser a .desc {	display: none; }
.imgteaser a:hover .epimg { visibility: hidden;}
.imgteaser a .epimg {
	position: absolute;
	right: 10px;
	top: 10px;
	font-size: 12px;
	color: #fff;
	background: #000;
	padding: 4px 10px;
	filter:alpha(opacity=65);
	opacity:.65;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=65)";
	
}
.imgteaser a:hover .desc{
	display: block;
	font-size: 11px;
	padding: 10px 0;
	background: #111;
	filter:alpha(opacity=75);
	opacity:.75;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=75)";
	color: #fff;
	position: absolute;
	bottom: 11px;
	left: 11px;
	padding: 4px 10px;
	margin: 0;
	width: 125px;
	border-top: 1px solid #999;
	
}
.pos
{
	position:absolute;
	top:91px;
	left:350px;
	
}
.form
{
	position:absolute;
	left:410px;	
}


</style>

</head>
<body>
<?php

		function getAllObjectsAsSelect(){

			$query = "SELECT * FROM MOBJECTT WHERE otyid IN ('0','1','4','3')";
			//echo $query;
			$result = mysql_query($query);
			$objects = "<option value=''></option>";
			while($row = mysql_fetch_array($result)) {
				$objects .= "<option value='".$row["oid"]."'>".$row["obname"]."</option>";
			}

			return $objects;
		}


?>

	<form method='post' accept-charset='UTF-8' enctype='multipart/form-data' align='center'>
			<fieldset >
				<legend><h2>Create Group</h2></legend>
				<table align='center'>
					<tr>
						<td>New Group Name*:</td><td> <input type='text' name='name' id='name' maxlength="50" required='true'/></td>	
					</tr>
					<tr>
						<td>New Image:</td><td><input type='file' width='20' name='image'></td>
					</tr>	
					<tr>
						<td>New Members*</td><td><select data-placeholder="Choose a Person..." class="chzn-select" multiple style="height:100%;width:350px;" tabindex="4" name='mem[]'><?php echo getAllObjectsAsSelect();?></select>
        				</td>
					</tr>
					<tr align='center'><td colspan= '2' ><input type='submit' name='submit' value='Submit' /></td></tr>
				</table>
			</fieldset>
		</form>
</body>
</html>