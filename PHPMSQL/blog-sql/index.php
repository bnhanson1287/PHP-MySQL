<?php

include ("includes/header.php");
include ("includes/_functions.php");

?>

  	<div class="jumbotron clearfix">
    	<h1><?php echo APP_NAME ?></h1>    
  	</div>

<?php $result = mysqli_query($con, "SELECT * FROM bha_blog") ?>

<?php while($row = mysqli_fetch_array($result)): ?>

	<h3><?php echo $row['bha_title']; ?></h3>

	<i><?php echo $row['bha_timedate']; ?></i>

	<p><?php echo nl2br(addEmoticons($row['bha_message'])); ?></p>

<?php endwhile; ?>


<?php

include ("includes/footer.php");
?>

