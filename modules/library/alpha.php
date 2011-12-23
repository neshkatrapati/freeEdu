<html>
    <body>
        <?php
            echo "<abbr title='All EBooks'><u><a href='?m=edit_ebook&n=all'>ALL</a></u></abbr>&nbsp";
           foreach(range('A','Z') as $i) echo "<abbr title='EBooks Starting with $i'><u><a href='?m=edit_ebook&n=$i'>$i</a></u></abbr>&nbsp";
           echo "<br>";
        ?>
    </body>
</html>