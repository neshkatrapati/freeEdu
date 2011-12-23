<script type='text/javascript'>
    
    $(document).ready(function() {
    $('#bbb').starRating({
                    basicImage : '../images/others/starplain.gif', 
                    ratedImage : '../images/others/starfull.gif',
                    hoverImage : '../images/others/starfull.gif',
                    paramValue : 'rate', 
                    
                });
});
</script>
<?php
echo "<form action='?m=feedback' method='get'>";
echo "<div id='bbb'></div>";
echo "<input type='hidden' name='rid'></input>";
echo "<input type='submit'></input>";
echo "</form>";
print_r($_GET);
?>