<html>
<body>
<form action="insert.php" method="get" >
Enter Student Roll No.</br>
<input type="text" name="srno"/>
</br>
</br>
Enter Date of Exam(dd-mm-yy)</br>
<input type="text" name="doex"/>
</br>
</br>
Enter Exam Type</br>
<input type="radio" name="ros" value="R"/>   Regular
<input type="radio" name="ros" value="S"/>   Supplementary
</br>
</br> 
Enter Batch</br>
<input type="radio" name="batyr" value="2008"/>   2008
<input type="radio" name="batyr" value="2009"/>   2009
</br>
</br> 
Enter Branch</br>
<input type="radio" name="branch" value="0"/>  CSE
<input type="radio" name="branch" value="1"/>  ECE 
<input type="radio" name="branch" value="2"/>  EEE
<input type="radio" name="branch" value="3"/>  MECH
<input type="radio" name="branch" value="4"/>  IT
</br>
</br>
Enter Regulation</br>
<input type="radio" name="regid" value="0"/>  R09
<input type="radio" name="regid" value="1"/>  R07
<input type="radio" name="regid" value="2"/>  R05
<input type="radio" name="regid" value="3"/>  RR
<input type="radio" name="regid" value="4"/>  NR
</br>
</br>
Enter Year</br>
<input type="radio" name="year" value="1"/>  1st yr
<input type="radio" name="year" value="2"/>  2-1 sem
<input type="radio" name="year" value="3"/>  2-2 sem
<input type="radio" name="year" value="4"/>  3-1 sem
<input type="radio" name="year" value="5"/>  3-2 sem
<input type="radio" name="year" value="6"/>  4-1 sem
<input type="radio" name="year" value="7"/>  4-2 sem
</br>
</br>
<table width="100%" border="2">
<tr>
<td>Subject Code</td>  
<td>Internal Marks</td> 
<td>External Marks</td>
<td>Credits Earned</td>
</tr>
<?php

for($i=0;$i<12;$i++)
{
?>
<tr>
<td> <?php echo '<input type="text" name="' . 'subcode'. $i . '" />'; ?></td>  
<td> <?php echo '<input type="text" name="' . 'intm'. $i . '" />'; ?></td>  
<td> <?php echo '<input type="text" name="' . 'extm'. $i . '" />'; ?></td>  
<td> <?php echo '<input type="text" name="' . 'cre'. $i . '" />'; ?></td>  
</tr>
<?php
}
?>
</table>
<input type="submit"/>
</br>
</br>
</form>
</body>
</html>
