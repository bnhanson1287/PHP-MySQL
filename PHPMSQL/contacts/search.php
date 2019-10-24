<?php

include ("includes/header.php");

?>

  
<h1>Search</h1>
       
    <!-- On your own
	Create a search form.
	Create a link to search in your header


     -->

<form id="myform" name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

		<div class="form-group">
			<label for="searchterm">Search Term:</label>
			<input type="text" name="searchterm" class="form-control">	
		</div>
			
		<div class="form-group">
			<label for="submit">&nbsp;</label>
			<input type="submit" name="submit" class="btn btn-info" value="Submit">
		</div>

</form>
      
<?php 

if(isset($_POST['submit'])){

	$searchterm = trim($_POST['searchterm']);
	if($searchterm != ""){
		echo "<p>searching for <b>\"$searchterm\"</b> ... </p>" ;


	// this time, we'll save our actual SQL query in a variable
	
		$sql = "SELECT * FROM characters WHERE 
		first_name LIKE '$searchterm'
		OR last_name LIKE '$searchterm'
		OR description LIKE '%$searchterm%'";	

		//$result = mysqli_query($con,"SELECT * FROM characters") or die(mysqli_error($con));
		$result = mysqli_query($con,$sql) or die(mysqli_error($con));

		// let's have a conditional in case there are no results from this query

		if(mysqli_num_rows($result) > 0){

			while($row = mysqli_fetch_array($result)){
	
				$fname = $row['first_name'];
				$lname = $row['last_name'];
				$description = $row['description'];
				echo "\n<div class=\"character\">";
				echo "\n\t<h3>" . $fname . " " . $lname . "</h3>";
				echo "\n\t<p>" . $description . "</p>";
				echo "\n</div>";

			}




		}else{
			echo "\n\t\t<div class=\"alert alert-warning\">No Results</div>\n";
		}



	}

}



 ?>



<?php

include ("includes/footer.php");
?>