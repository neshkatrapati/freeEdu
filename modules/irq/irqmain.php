<script type='text/javascript'>
		function addIt(num){
			a = confirm("Add This ??");
			if(a == true){
				valx = document.getElementById("valx"+num);
				valy = document.getElementById("valy"+num).value;
				valx.innerHTML = valy+ "&emsp;<button type='button' class='btn' id='btn"+num+"' onclick='editIt("+num+")'>Edit</button>";
				barx = document.getElementById("barx"+num);
				bary = document.getElementById("bary"+num).value;
				barx.innerHTML = bary 
				filx = document.getElementById("filx"+num);
				fily = document.getElementById("fils"+num).value;
				filx.innerHTML = getFullOption(fily);
				
			}
		}
		function editIt(num){
			a = confirm("Add This ??");
			if(a == true){
				valx = document.getElementById("valx"+num);
				valy = document.getElementById("valy"+num).value;
				valx.innerHTML = valy+ "&emsp;<button type='button' class='btn' id='btn"+num+"' onclick='editIt("+num+")'>Edit</button>";
				barx = document.getElementById("barx"+num);
				bary = document.getElementById("bary"+num).value;
				barx.innerHTML = bary 
				filx = document.getElementById("filx"+num);
				fily = document.getElementById("fils"+num).value;
				filx.innerHTML = getFullOption(fily);
				
			}
		}
		function displayQueryBar(element,valel,x){
				element = document.getElementById(element);
				valel = document.getElementById(valel);
				if(x == "none"){
					element.style.display = 'none';
					valel.style.display = 'none';
				}
				else{
					element.style.display = '';
					valel.style.display = '';
				}
				
		}
		function getFullOption(op){
				switch(op){
					case "gt":return "Greater Than";
					case "lt":return "Less Than";
					case "gte":return "Greater Than Or Equal To";
					case "lte":return "Less Than Or Equal To";
					case "in":return "In [List]";
					case "nin":return "Not In [List]";
					case "nlike":return "Not Like[RegExp]";
					case "like":return "Like [RegExp]";
					case "neq":return "Not Equal To";
					case "eq":return "Equal To";
					
				}
		}
		function addFilter(num){
				var detail = getStandardDetail();
				var element = document.getElementById('filtertable');
				if(num!=0){
					var c = prompt("Relation With Previous Filter (Give And / Or)");
					element.innerHTML += "<tr ><td colspan='2' class='zebra-striped' style='text-align:center'>"+c+"</td></tr>";
				}
				
				element.innerHTML = element.innerHTML +  detail;
				
		}
		function getStandardDetail(){
			var ele = document.getElementById("filcount");
			var dc = parseInt(ele.innerHTML);
			var x = "<table class='bttable' style='border:2px solid black'><tr><td>Select Filter:</td><td id='filx"+dc+"'><select onchange='displayQueryBar(\"barx"+dc+"\",\"valx"+dc+"\",this.value)' id='fils"+dc+"' style='width:200'><option value='none'>--SELECT-- </option><option value='gt'>Greater Than \"&gt;\"</option><option value='lt'>Less Than \"&lt;\"</option><option value='gte'>Greater Than or Equal To '&gt;='</option><option value='lte'>Less Than or Equal To '&lt;='</option><option value='eq'>Equal To \"=\"</option><option value='neq'>Not Equal To '!='</option><option value='in'>In [List]</option><option value='nin'>Not In [List]</option><option value='like'>Like [RegExp]</option><option value='nlike'>Not Like [RegExp]</option></select></td></tr><tr ><td>Query String</td><td id='barx"+dc+"'><input type='text' id='bary"+dc+"'></tr><tr id='val"+dc+"'><td>Query Value</td><td id='valx"+dc+"'><input type='text' id='valy"+dc+"'>&emsp;<button type='button' class='btn' onclick='addIt("+dc+")' id='btn"+dc+"'>Add</button></tr></table>";
			ele.innerHTML = dc+1;
			return x;
		}
</script>
<div id='filcount' style='display:none'>1</div>
<form><div style='float:left;display:inline;' class='sidebar'><table class='bttable' style='border:2px solid black;'><th class='zebra-striped' colspan='2'>Perspective Pane</th>
<tr><td>Select a Perspective</td><td><select name='pers' style='width:170'><option value='sub'>Subject Perspective</option><option value='stu'>Student Perspective</option></select></td></tr></table>
<table id='filtertable' class='bttable' style='border:2px solid black;' ><th class='zebra-striped' colspan='2' style=''>Filter Pane <div style='float:right'><img src='../images/others/add.png' width='30' height='30' style='display:inline;line-height:0px' onclick='addFilter()'></img></div></th><script>addFilter(0);</script></table></div>
<div style='border:2px solid black;height:80%' class='content'>
	<h4 style='padding-left:10px' class='zebra-striped'>Content Pane</h4>
	<div class='box' style='margin-left:20px;margin-right:20px;margin-top:20px;font-size:18px'>Welcome to IRQ [Interactive Result Queriying].</div>
</div>

</form>
<?php
	
	
	
?>
</table>
</div>
