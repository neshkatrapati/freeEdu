 <?php
            include('library_lib.php');
            include("../../lib/connection.php");
            $lib=mysql_query("select * from MLIBRARYT");
            $num=mysql_num_rows($lib);
            if($num==0)
            {
                notifywar("No Books available with That Filter . Try Again");
            }
            else
            {
		echo "<div class='b-load'>";
                while($l=mysql_fetch_array($lib))
                {
                    $bookid=$l['bookid'];
                    $bname=$l['bname'];
                    $bauthor=$l['bauthor'];
                    $bpub=$l['bpub'];
		    $bedition=$l['bedition'];
		    $ncps=$l['ncps'];
		    $imgid=$l['imgid'];
                    $lid=$l['lid'];
                    $img=mysql_query("select * from MIMGT where imgid='$imgid'");
                    $image=mysql_fetch_array($img);
                    $imguri=$image['imguri'];
		    
		    echo "<div>";
		    
		     if($imguri==NULL)
                        echo "<center><h1>No cover Image</h1></center>";
                    else
                        echo "<center><img src='../../$imguri'  height=100 width=50></center>";
		        
		    echo "
			<h1>$bname-by-$bauthor</h1>
			<p>Publisher : $bpub<br>Edition : $bedition<br>Number of Books : $ncps<br></p>
			<br><a  target='_blank' class='article'>OrderBook</a>
				<a target='_blank' class='demo'>E-Book</a>
		</div>";
                    
                }
		echo "</div>";
            }
        ?>



