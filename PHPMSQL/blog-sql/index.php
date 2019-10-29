<?php

include ("includes/header.php");
include ("includes/_functions.php");
//////////// pagination
$getcount = mysqli_query ($con,"SELECT COUNT(*) FROM bha_blog");
$postnum = mysqli_result($getcount,0);// this needs a fix for MySQLi upgrade; see custom function below
$limit = 5;
if($postnum > $limit){
$tagend = round($postnum % $limit,0);
$splits = round(($postnum - $tagend)/$limit,0);

if($tagend == 0){
$num_pages = $splits;
}else{
$num_pages = $splits + 1;
}

if(isset($_GET['pg'])){
$pg = $_GET['pg'];
}else{
$pg = 1;
}
$startpos = ($pg*$limit)-$limit;
$limstring = "LIMIT $startpos,$limit";
}else{
$limstring = "LIMIT 0,$limit";
}

// MySQLi upgrade: we need this for mysql_result() equivalent
function mysqli_result($res, $row, $field=0) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
}
//////////////

?>

  	<div class="jumbotron clearfix">
    	<h1><?php echo APP_NAME ?></h1>    
  	</div>

<?php $result = mysqli_query($con, "SELECT * FROM bha_blog ORDER BY bid DESC $limstring") ?>

<?php while($row = mysqli_fetch_array($result)): ?>

	<div class="blog-entry">
		<h3><?php echo $row['bha_title']; ?></h3>

		<div class="blog-date clearfix">
			<p>
				<?php 
					$myDate = strtotime($row['bha_timedate']); echo date("F j, Y, g:i a", $myDate)
				?>
			</p>		
		</div>

		<p>
			<?php echo nl2br(addEmoticons(makeClickableLinks($row['bha_message']))); ?>	
		</p>
	</div>

<?php endwhile; ?>

<?php
	echo "<nav aria-label=\"Page navigation example\">"; 
	echo "<ul class=\"pagination\">";
	if($postnum > $limit)
	{
		$n = $pg + 1;
		$p = $pg - 1;
		$thisroot = $_SERVER['PHP_SELF'];
		if($pg > 1)
		{
			echo "<li class=\"page-item\"><a class=\"page-link\" href=\"$thisroot?pg=$p\">Previous</a></li>";
		}
		for($i=1; $i<=$num_pages; $i++)
		{
			if($i!= $pg)
			{
				echo "<li class=\"page-item\"><a class=\"page-link\" href=\"$thisroot?pg=$i\">$i</a></li>";
			}
			else
			{
				echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"$thisroot?pg=$i\">$i</a></li>";
			}
		}
		if($pg < $num_pages)
		{
			echo "<li class=\"page-item\"><a class=\"page-link\" href=\"$thisroot?pg=$n\">Next</a></li>";
		}
	}
	echo "</ul>";
	echo "</nav>";
 ?>


 <p>&nbsp;</p>
 <p>&nbsp;</p>
 <p>&nbsp;</p>
 <p>&nbsp;</p>
<?php

include ("includes/footer.php");
?>

