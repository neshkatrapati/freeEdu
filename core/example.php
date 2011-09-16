<?php
require '../lib/fb/src/facebook.php';
//include("../misc/constants.php");
$clsname = "Constants";
// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => $clsname::$fbappid,
  'secret' => $clsname::$fbsecret,
));


$user = $facebook->getUser();
//echo $user;
if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
    
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}


?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <center>
    <link rel="stylesheet" href="../aux/pagestyles/style.css" type="text/css" media='screen'>

    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <h1>Facebook-Connect</h1>

    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        Login & Comeback Again!:
        <a href="<?php echo $loginUrl; ?>">Login</a>
      </div>
    <?php endif ?>

  

    <?php if ($user): ?>
      <h3>You</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture?type=large"><br><br>
      <?php
      if($_POST['sub']){
        //include('../lib/fb/src/curl.php');
        $img = 'images/others/'.uniqid().".jpg";
        $imguri = "https://graph.facebook.com/".$user."/picture";
        //echo $imguri;
         $headers = get_headers($imguri,1);
        if(isset($headers['Location'])) {
        $url = $headers['Location']; // string
       } else {
        $url = false; // nothing there? .. weird, but okay!
        return;
       }
       //echo $url;
      $imgnamea = explode(".",$url);
      $temp = count($imgnamea)-1;
      $imgname = $imgnamea[$temp];
      //$iname = $imgnamea[$temp-1];
      
      $img = 'images/faces/'.uniqid().".".$imgname;
      //echo $img;
      $url2 = str_replace("_q","_n",$url);
      //echo  $url2;
      $ch = curl_init($url2);
      $fp = fopen("../".$img, 'wb');
      curl_setopt($ch, CURLOPT_FILE, $fp);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_exec($ch);
      curl_close($ch);
      fclose($fp);
      
      $clsname = "Constants";
      $con = mysql_connect($clsname::$dbhost, $clsname::$dbuname,$clsname::$dbpass);
      mysql_select_db($clsname::$dbname, $con);
		
      $arr1 = mysql_query("select count(imgid) as cnt from MIMGT");
      $arry = mysql_fetch_array($arr1);
      $imgid = $arry["cnt"];
		
      $oid = $_COOKIE["object"];
      mysql_query("insert into MIMGT values('".$imgid."','".$img."')");
      //mysql_query("update MSUBJECTT set imgid='".$imgid."' where subid like '".$subid."'");
      mysql_query("update MOBJECTT set oimgid='".$imgid."' where oid='".$oid."'");
      $result = mysql_query("select * MOBJECTT where oid like '".$oid."'");
      $arrx = mysql_fetch_array($result);
      $obhandle = $arrx["obhandle"];
      $otyid = $arrx["otyid"];
      if($otyid == '0')
         mysql_query("update MSTUDENTT set imgid='".$imgid."' where sid like '".$obhandle."'");
      if($otyid == '1')
         mysql_query("update MFACULTYT set imgid='".$imgid."' where fid like '".$obhandle."'");
      if($otyid == '2')
         mysql_query("update MSUBJECTT set imgid='".$imgid."' where subid like '".$obhandle."'");
      echo "done!";
      redirect("?");
      }
      
      ?>
    
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>
    <?php
      echo $user_profile["name"];
    
    ?>
    <?php
    if(!$_POST["sub"]){?>
    <form action='#' method=post>
    <input type='submit' name='sub' />
    </form><?php } ?>
    </center>
  </body>
</html>
