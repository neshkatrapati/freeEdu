<html>
    <head>
        <link rel="stylesheet" href="../modules/library/libStyle.css" type="text/css" media="screen" />
        
    </head>
<body>
   
    <center>
        <?php
            include('library_lib.php');
            include("../lib/connection.php");
            $lib=mysql_query("select * from MLIBRARYT");
            $num=mysql_num_rows($lib);
            if($num==0)
            {
                notifywar("No Books available with That Filter . Try Again");
            }
            else
            {
                while($l=mysql_fetch_array($lib))
                {
                    $bookid=$lib['bookid'];
                    $bname=$lib['bname'];
                    $bauthor=$lib['bauthor'];
                    $bpub=$lib['bpub'];
                    
                }
            }
        ?>
    </center>
</body>
</html>