<style>
.btn1 {
  display: inline-block;
  background-color: #e6e6e6;
  background-repeat: no-repeat;
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), color-stop(0.25, #ffffff), to(#e6e6e6));
  background-image: -webkit-linear-gradient(#ffffff, color-stop(0.25, #ffffff), #e6e6e6);
  background-image: -moz-linear-gradient(#ffffff, color-stop(#ffffff, 0.25), #e6e6e6);
  padding: 4px 14px;
  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
  color: #333333;
  font-size: 13px;
  line-height: 18px;
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-bottom-color: rgba(0, 0, 0, 0.25);
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  -webkit-transition: 0.1s linear all;
  -moz-transition: 0.1s linear all;
  transition: 0.1s linear all;
}
.btn1:hover {
  background-position: 0 -15px;
  color: #333333;
  text-decoration: none;
}</style>
<?php
    if(!isset($_POST["phase1"]))
    {
        echo "<fieldset><legend>Create A Blog Entry</legend><div style='margin-left:150px;'>";
        echo "<form action='#' method='post'>";
        echo "<div style='float:left'>Blog Title</div><br><br><input type='text' name='btitle' style='width:60%;'> </input><br><br>";
        echo "<div style='float:left'>Blog Title</div><br><br><textarea name='bdetail' rows='30' cols='106' style=''></textarea>";
        echo "<br><br><div style='margin-left:300px'><input type='submit' name='phase1' value='Post' class='btn1' style=''></input></div>";
        echo "</form>";
        echo "</div></fieldset>";
    }
    else
    {
        $bdetail = $_POST["bdetail"];
        $btitle = $_POST["btitle"];
        $object = getCurrentObject();
        $cdate  = strtotime(date("d-M-y"));
        $authtoken = getAuthToken("blog");
        $q = fq("select count(*) as cnt from MBLOGT",$authtoken);
        echo $q;
        $x = mysql_fetch_array($q);
        $rownum = $x["cnt"];
        fq("insert into MBLOGT values('".$rownum."','".$btitle."','".$object."','".$bdetail."','".$cdate."')",$authtoken);
        notify("Created Blog Entry Succesfully!");        
    }
?>