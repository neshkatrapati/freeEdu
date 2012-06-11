		<html>
		<head>	
		<link rel="stylesheet" type="text/css" media="all" href="cal/jsDatePick_ltr.min.css" />
		<script type="text/javascript" src="cal/jsDatePick.min.1.3.js"></script>
		<script type="text/javascript">
		window.onload = function(){
        	new JsDatePick({
            	useMode:2,
            	target:"inputField",
            	isStripped:false,
            	dateFormat:"%d-%M-%Y",
            	cellColorScheme:"torqoise"                        
		});
        	new JsDatePick({
            	useMode:2,
            	target:"inputField2",
            	cellColorScheme:"beige",                        
            	dateFormat:"%d-%M-%Y",
            	imgPath:"calendar/img/"
		});
    		};
		</script>	
		<LINK href="style.css" rel="stylesheet" type="text/css">
		<title>Portcullis- Client </title>		
		</head>		
		
			<form action='#' method='post'>
			From Date:&nbsp; &nbsp;<input type='text' name='from' id='inputField' required=true>
    			&emsp;
			To Date:&nbsp; &nbsp;<input type='text' name='to' id='inputField2' required=true >
			</input>
    			</input>
			<br><br>
			<input type='submit' class='btn' name='submit2'></input></form></div></center>
			</form>
			
			</body>
			</html>
