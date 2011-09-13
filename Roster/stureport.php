<html>
    <head>
        <link rel="stylesheet" type="text/css" media="all" href="../aux/calendar/jsDatePick_ltr.min.css" />
        <script type="text/javascript" src="../aux/calendar/jsDatePick.min.1.3.js"></script>
        <script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField1",
			limitToToday:true,
			dateFormat:"%d-%M-%Y",
			imgPath:"../aux/calendar/img/"
			
		});
                new JsDatePick({
			useMode:2,
			target:"inputField2",
			limitToToday:true,
			dateFormat:"%d-%M-%Y",
			imgPath:"../aux/calendar/img/"
			
		});
	};
        </script>
    </head>
    <body>
        <fieldset>
		 <legend>Student Report</legend>
            <center>
               
                <form action='#' method='post'>
                    Roll Number : <input type='text' name='rno' required=true/><br><br>
                    From-Date: <input type='text' id='inputField1' name='datein' required=true/>&emsp;
                    To-Date: <input type='text' id='inputField2' name='dateout' required=true></input><br><br><input type='submit' name='phase1'>
                </form>
            
            <div id='phase1'>
                <?php
                    if(isset($_POST['phase1']))
                    {
                        $rno = $_POST['rno'];
                        $datein = $_POST["datein"];
                        $dateout = $_POST['dateout'];
                        $Arr = queryMe("SELECT sid from MSTUDENTT where srno like '".strtoupper($rno)."'");
                        $sid = $Arr['sid'];
			$brid = getBranchFromSrno($rno);
			$obrid = getBranchFilter();
			$result=mysql_query("select * from MSTUDENTT where srno='$rno'");
		        $rownum=mysql_num_rows($result);

			if($rownum<=0)
			{
				notifyerr("Invalid Hallticket Number");
			}
			else
			{
			    if($obrid=='%' || $brid==$obrid)
			    {
				echo " <div id='placeholder' style='width:500px;height:300px'></div>
				 <p id='hoverdata'> <span id='clickdata'></span></p>";
				 echo  getStuGraph($sid,strtotime($datein),strtotime($dateout));
			        echo getStuReport($sid,strtotime($datein),strtotime($dateout),-1);
			    }
			    else
				notifyerr("The Student Does Not Correspond To The Branch Concerned With You!");
			}
			
                    }
                ?>
            </div>
            </center>
        </fieldset>
    </body>
</html>
