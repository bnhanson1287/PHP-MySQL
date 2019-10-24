<?php

include ("includes/header.php");

?>

  <div class="jumbotron clearfix">
    <h1>SNL Characters List</h1>
  </div>

<?php 
// use a select statement to select to retrieve whats in the DB
// use formatting.
	$result = mysqli_query($con, "SELECT first_name, last_name, description FROM characters") or die(mysqli_error($con));

		while($row = mysqli_fetch_array($result))
		{
			$fname = $row['first_name'];
			$lname = $row['last_name'];
			$description = $row['description'];
			echo "<div class=\"character\">";
			echo "\n\t<h3>" . $fname . " " . $lname ."</h3>";
			echo "\n\t<p>". $description ."</p>";
			echo "</div>";



		}

 ?>

      


<?php

include ("includes/footer.php");
?>