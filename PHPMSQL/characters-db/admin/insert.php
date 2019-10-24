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
	if(isset($_POST['my-submit']))
	{
		//echo "button clicked!";

		$fName = trim($_POST['first-name']);
		$lName = trim($_POST['last-name']);
		$description = trim($_POST['description']);

		//echo "$fname, $lname, $description";

		// VALIDATION SECTION

			$valid = 1;
			$msgPre = "<div class=\"alert alert-success\">";
			$msgPost = "</div>\n";
			$msgPreError = "<div class=\"alert alert-danger\">";

			//fname validation
			if((strlen($fName) < 3) || (strlen($fName) >20)) 
			{
				$valid = 0;
				$valFNameMsg = "First Name must be between 3 and 20 characters.";
			}
			//lname validation
			if((strlen($lName) < 3) || (strlen($lName) >20)) 
			{
				$valid = 0;
				$valLNameMsg = "Last Name must be between 3 and 20 characters.";
			}
			//description validation
			if((strlen($description) < 20) || (strlen($description) >400)) 
			{
				$valid = 0;
				$valDescription = "Description must be between 20 and 400 characters";
			}


			//SUCCESS validation has been successful, go ahead and put info into the db
			if($valid == 1)
			{
				//success
				$msgSuccess = "You have successfully added ". $fName ." ". $lName. "!";

				// Insert if valid. It is because it's put in this if statment
				mysqli_query($con, "INSERT INTO characters (first_name, last_name, description) VALUES('$fName', '$lName', '$description')") or die(mysqli_error($con));

				$fName = "";
				$lName = "";
				$description = "";

			}

	}// \ if submit
?>
<h2>Insert</h2>
<form id="myform" name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
		<div class="form-group">
			<label for="first-name">First Name:</label>
			<input type="text" name="first-name" class="form-control" value="<?php if($fName) {echo "$fName";}?>">
			<?php 
				if($valFNameMsg){echo $msgPreError . $valFNameMsg . $msgPost;}
			 ?>
		</div>
		<div class="form-group">
			<label for="last-name">Last Name:</label>
			<input type="text" name="last-name" class="form-control" value= "<?php if($lName){echo "$lName";}?>">
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
			<input type="submit" name="my-submit" class="btn btn-info" value="Submit">
		</div>
        <p>&nbsp;</p>
        <?php 
	  		if($msgSuccess)
	  		{
	  			echo $msgPre . $msgSuccess . $msgPost;
	  		}
		?>
</form>
<?php
	include("../includes/footer.php");
?>