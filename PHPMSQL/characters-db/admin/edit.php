<?php 
session_start();
if(isset($_SESSION['labfoursessionforlogin']))
{
	
}
else 
{
	header("Location:login.php"); 
}
include("../includes/header.php");

	


	// retrieve our critical page setter variable

	$char_id = $_GET['id'];// get will retrieve anything from the URL can get query string.

	// set this as a default value in case it has none.
	if(!isset($char_id))
	{
		$result = mysqli_query($con, "SELECT id FROM characters LIMIT 1");
		while($row = mysqli_fetch_array($result))
		{
			$char_id = $row['id'];
		}
	}

	// TEST echo "<h1>$char_id</h1>"; 


	// Step 3: UPDATE the db with the new info from the form. Validate first.

	if(isset($_POST['my-submit']))
	{
		//echo "button clicked!";

		$fname = trim($_POST['first-name']);
		$lname = trim($_POST['last-name']);
		$description = trim($_POST['description']);

		//echo "$fname, $lname, $description";

		// VALIDATION SECTION

			$valid = 1;
			$msgPre = "<div class=\"alert alert-success\">";
			$msgPost = "</div>\n";
			$msgPreError = "<div class=\"alert alert-danger\">";

			//fname validation
			if((strlen($fname) < 3) || (strlen($fname) > 20)) 
			{
				$valid = 0;
				$valFNameMsg = "First Name must be between 3 and 20 characters.";
			}
			//lname validation
			if((strlen($lname) < 3) || (strlen($lname) > 20)) 
			{
				$valid = 0;
				$valLNameMsg = "Last Name must be between 3 and 20 characters.";
			}
			//description validation
			if((strlen($description) < 20) || (strlen($description) > 400)) 
			{
				$valid = 0;
				$valDescription = "Description must be between 20 and 400 characters";
			}


			//SUCCESS validation has been successful, go ahead and put info into the db
			if($valid == 1)
			{
				//success
				$msgSuccess = "You have successfully updated " . $fname ." ". $lname. "!";

				// Update if valid. It is because it's put in this if statment
				mysqli_query($con,"UPDATE characters SET first_name = '$fname', last_name = '$lname', description = '$description' WHERE id = '$char_id'") or die(mysqli_error($con));

			}

	}// \ if submit

	//Step 1: Create list of items that the user can select from.
	$result = mysqli_query($con, "SELECT id, first_name, last_name FROM characters") or die(mysqli_error($con));

	while($row = mysqli_fetch_array($result))
	{
		$fname = $row['first_name'];
		$lname = $row['last_name'];
		$id = $row['id'];


		//instead of echoing this here, we will create a variable that we can echo later on in my markup
		$editLinks .= "\n\t\t<a href=\"edit.php?id=$id\">" . $fname . " " . $lname ."</a> <br>";
	}

	// Step 2: Grab data for selected character and prepop form fields.

	$result = mysqli_query($con, "SELECT * FROM characters WHERE id = $char_id") or die(mysqli_error($con));

	while($row = mysqli_fetch_array($result))
	{
		$fname = $row['first_name'];
		$lname = $row['last_name'];
		$description = $row['description'];

		//TEST echo "$fname $lname";
	}



 ?>


<h2>Edit</h2>
<div class="row">
	<div class="col">
		<!----Left Column---->
		<!-----
			The name of the current file does not include any appended URLS. We can use $_SERVER['REQUEST_URI'] instead. It includes the appended URI info.
		------->
		<form id="myform" name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
				<div class="form-group">
					<label for="first-name">First Name:</label>
					<input type="text" name="first-name" class="form-control" value="<?php if($fname){echo"$fname";}?>">
					<?php 
						if($valFNameMsg){echo $msgPreError . $valFNameMsg . $msgPost;}
					 ?>
				</div>
				<div class="form-group">
					<label for="last-name">Last Name:</label>
					<input type="text" name="last-name" class="form-control" value= "<?php if($lname){echo"$lname";}?>">
					<?php 
						if($valLNameMsg){echo $msgPreError . $valLNameMsg . $msgPost;}
					 ?>
				</div>
				<div class="form-group">
					<label for="description">Description:</label>
					<textarea name="description" class="form-control"><?php if($description){echo "$description";}?></textarea>
					<?php 
						if($valDescription){echo $msgPreError . $valDescription . $msgPost;}
					 ?>
				</div>
				<div class="form-group">
					<label for="my-submit">&nbsp;</label>
					<input type="submit" name="my-submit" class="btn btn-info" value="Update">
					<a href="delete.php?id=<?php echo "$char_id";?> "class="btn btn-danger" onclick="return confirm('Are you sure you want to delete <?php echo "$fname $lname";?>?')">Delete</a>
				</div>
		        <p>&nbsp;</p>
		        <?php 
			  		if($msgSuccess)
			  		{
			  			echo $msgPre . $msgSuccess . $msgPost;
			  		}
				?>
		</form>
	</div>
	<div class="col">
		<h3>Characters</h3>
		<!----Right Column---->
		<?php
			echo "<div class=\"my-nav\">";
			echo $editLinks . "\n\t";
			echo "</div>\n";
		 ?>
	</div>
</div>





 <?php 
	include("../includes/footer.php");
 ?>