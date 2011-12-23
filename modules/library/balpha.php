<html>
    <body>
        <?php
            echo "<abbr title='All Books'><u><a href='?m=eb&n=all'>ALL</a></u></abbr>&nbsp";
           foreach(range('A','Z') as $i) echo "<abbr title='Books Starting with $i'><u><a href='?m=eb&n=$i'>$i</a></u></abbr>&nbsp";
           echo "<br>";
        ?>
    </body>
</html>