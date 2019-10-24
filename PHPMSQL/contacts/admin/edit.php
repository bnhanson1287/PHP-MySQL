<?php 
session_start();
if(isset($_SESSION['labfivesessionforlogin']))
{
	$pageName = "edit";
}
else 
{
	header("Location:login.php"); 
}

include("../includes/header.php");

	$host = $_SERVER['REQUEST_URI'];
	echo $host;
	$con_id = $_GET['id'];

	if(!isset($con_id))
	{
		$result = mysqli_query($con, "SELECT id FROM bha_contacts LIMIT 1");
		while($row = mysqli_fetch_array($result))
		{
			$con_id = $row['id'];
		}
	}

	// Update proccess
	if(isset($_POST['my-submit']))
	{

		$companyName = trim($_POST['company-name']);
		$website = $_POST['website'];
		$contactName = trim($_POST['contact-name']);
		$email = trim($_POST['email']);
		$address1 = $_POST['address-1'];
		$address2 = $_POST['address-2'];
		$city = $_POST['city'];
		$province = $_POST['province'];
		$postalCode = $_POST['postal'];
		$phone = $_POST['phone'];
		$description = $_POST['description'];
		$resume = $_POST['resume'];



		// VALIDATION

		$valid = 1;
		$msgPre = "<div class=\"alert alert-success\">";
		$msgPost = "</div>\n";
		$msgPreError = "<div class=\"alert alert-info\">";

		//COMPANY NAME VALIDATION
		if((strlen($companyName) < 3) || (strlen($companyName) >50)) 
		{
			$valid = 0;
			$valNameMsg = "Company name must be between 3 and 50 characters";
		}

		//EMAIL VALIDATION
		if($email !="")
		{
			$email = filter_var($email, FILTER_SANITIZE_EMAIL);

			if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$valEmailMsg = "\nPlease fill in correct email";
				$valid = 0;
			}
		}
		else
		{
			$valEmailMsg = "\nPlease fill in an email address.";
			$valid = 0;
			
		}
		//URL validation
		if($website !="")
		{
			if(!filter_var($website, FILTER_VALIDATE_URL))
			{
				$valURLMsg = "\nPlease fill in correct URL";
				$valid = 0;
			}

		}
		else
		{
			$valURLMsg = "\n Website field cannot be left empty.";
			$valid = 0;
		}

		//PHONE VALIDATION
		
		if($phone != "")
		{
			$phone = str_replace(" ", "", $phone); 
			$phone = str_replace("-", "", $phone); 
			$phone = str_replace(".", "", $phone); 
			$phone = str_replace("(", "", $phone); 
			$phone = str_replace(")", "", $phone);

			if((!is_numeric($phone)) || (strlen($phone) != 10))
			{
				$valPhoneMsg = "\nPhone number is a 10 digit numeric field (ex: 1234567890).";
				$valid = 0;
			}
		}
		else
		{
			$valPhoneMsg = "\nPhone number is a required field";
			$valid = 0;
		}

		// SUCCESSFUL SUBMISSION
		if($valid == 1)
		{
			//success
			$msgSuccess = "You have successfully updated ".$companyName."!";


			mysqli_query($con, "UPDATE bha_contacts SET bha_company_name = '$companyName', bha_person_name = '$contactName', bha_email = '$email', bha_phone1 = '$phone', bha_url = '$website', bha_address1 = '$address1', bha_address2 = '$address2', bha_city = '$city', bha_province = '$province', bha_postal = '$postalCode', bha_resume = '$resume', bha_description = '$description' WHERE id = '$con_id' ") or die(mysqli_error($con));


		}
	}


	// creating list of contacts
	$result = mysqli_query($con, "SELECT id, bha_company_name FROM bha_contacts") or die(mysqli_error($con));

	while($row = mysqli_fetch_array($result))
	{
		$companyName = $row['bha_company_name'];
		$id = $row['id'];



		$editLinks .= "\n\t\t<a class=\"<?php if($host == '/dmit2025/contacts/admin/edit.php?id=$id') active else {""} ?>\" href=\"edit.php?id=$id\">" . $companyName ."</a> <br>";
	}

	//PREPOP FIELDS
	$result = mysqli_query($con, "SELECT * FROM bha_contacts WHERE id = $con_id") or die(mysqli_error($con));

	while($row = mysqli_fetch_array($result))
	{
		$companyName = $row['bha_company_name'];
		$website = $row['bha_url'];
		$contactName = $row['bha_person_name'];
		$email = $row['bha_email'];
		$address1 = $row['bha_address1'];
		$address2 = $row['bha_address2'];
		$city = $row['bha_city'];
		$province = $row['bha_province'];
		$postalCode = $row['bha_postal'];
		$phone = $row['bha_phone1'];
		$description = $row['bha_description'];
		$resume = $row['bha_resume'];
	}


 ?>
<div class="container">
	<h2>Edit Contact</h2>
		<p>&nbsp;</p>
        <?php 
	  		if($msgSuccess)
	  		{
	  			echo $msgPre . $msgSuccess . $msgPost;
	  		}
		?>
	<div class="row">
		<div class="col-sm-8">
			<form id="myform" name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
				<div class="form-row">
					<div class="col">
						<label for="company-name" class="control-label">Company Name:</label>
			            <input type="text" class="form-control" name="company-name" placeholder="Company Name" value="<?php if($companyName) {echo "$companyName";}?>">
			            <?php 
			            	if($valNameMsg){echo $msgPreError . $valNameMsg . $msgPost;}
			             ?>
					</div>
					<div class="col">
						<label for="website" class="control-label">Website URL:</label>
						<input type="text" class="form-control" name="website" placeholder="http://website.com" value="<?php if($website) {echo "$website";}?>">
						<?php 
							if($valURLMsg){echo $msgPreError . $valURLMsg . $msgPost;}
						 ?>
					</div>
				</div>
				<div class="form-row">
					<div class="col">
						<label for="contact-name">Contact Name:</label>
		                <input type="text" class="form-control" name="contact-name" placeholder="Contact Name" value="<?php if($contactName) {echo "$contactName";}?>">
						
					</div>
					<div class="col">
						<label for="email" class="control-label">Email Address:</label>
						<input type="text" class="form-control" name="email" placeholder="Email Address" value="<?php if($email) {echo "$email";}?>">
						<?php 
							if($valEmailMsg){echo $msgPreError . $valEmailMsg . $msgPost;}
						?>
					</div>
				</div>
				<div class="form-row">
					<div class="col">
						<label for="address-1">Address 1:</label>
	                	<input type="text" class="form-control" name="address-1" placeholder="Address 1" value="<?php if($address1) {echo "$address1";}?>">
					</div>
					<div class="col">
						<label for="address-2">Address 2:</label>
			    		<input type="text" class="form-control" name="address-2" placeholder="Address 2" value="<?php if($address2) {echo "$address2";}?>">
						
					</div>
				</div>
				<div class="form-row">
					<div class="col">
						<label for="city">City:</label>
					    <input type="text" class="form-control" name="city" placeholder="City" value="<?php if($city) {echo "$city";}?>">
					</div>
					<div class="col">
						<label for="province">Province:</label>
					    <select class="form-control" name="province">
					    	<option value="">-Select a Province-</option>
					    	<option value="AB" <?php if(isset ($province) && $province == "AB") {echo "selected";} ?>>Alberta</option>
					    	<option value="BC" <?php if(isset ($province) && $province == "BC") {echo "selected";} ?>>British Columbia</option>
					    	<option value="MB" <?php if(isset ($province) && $province == "MB") {echo "selected";} ?>>Manitoba</option>
					    	<option value="NB" <?php if(isset ($province) && $province == "NB") {echo "selected";} ?>>New Brunswick</option>
					    	<option value="NL" <?php if(isset ($province) && $province == "NL") {echo "selected";} ?>>Newfoundland and Labrador</option>
					    	<option value="NS" <?php if(isset ($province) && $province == "NS") {echo "selected";} ?>>Nova Scotia</option>
					    	<option value="ON" <?php if(isset ($province) && $province == "ON") {echo "selected";} ?>>Ontario</option>
					    	<option value="PE" <?php if(isset ($province) && $province == "PE") {echo "selected";} ?>>Prince Edward Island</option>
					    	<option value="QC" <?php if(isset ($province) && $province == "QC") {echo "selected";} ?>>Quebec</option>
					    	<option value="SK" <?php if(isset ($province) && $province == "SK") {echo "selected";} ?>>Saskatchewan</option>
					    	<option value="NT" <?php if(isset ($province) && $province == "NT") {echo "selected";} ?>>Northwest Territories</option>
					    	<option value="NU" <?php if(isset ($province) && $province == "NU") {echo "selected";} ?>>Nunavut</option>
					    	<option value="YT" <?php if(isset ($province) && $province == "YT") {echo "selected";} ?>>Yukon</option>
					    </select>	 
					</div>
				</div>
				<div class="form-row">
					<div class="col">
						<label for="phone" class="control-label">Phone:</label>
			            <input type="text" class="form-control" name="phone" placeholder="1235554444" value="<?php if($phone) {echo "$phone";}?>">
			            <?php 
			            	if($valPhoneMsg){echo $msgPreError . $valPhoneMsg . $msgPost;}
			             ?> 
					</div>
					<div class="col">
						<label for="postal">Postal Code:</label>
		                <input type="text" class="form-control" name="postal" placeholder="H0H 0H0" value="<?php if($postalCode) {echo "$postalCode";}?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col">
						<label for="description">Description:</label>
		            	<textarea class="form-control" name="description" rows="3"><?php if($description) {echo "$description";}?></textarea>
					</div>
					<div class="col">
						<p>&nbsp;</p>
						<label>	
			    			<input type="checkbox" name="resume" value="1" <?php if(isset($resume) && $resume == "1"){echo "checked";} ?>> Sent a Resume?
			    		</label> <br>
			    		<label for="my-submit"></label>
			    		<input type="submit" name="my-submit" class="btn btn-info" value="Update">
			    		<a href="delete.php?id=<?php echo "$con_id";?> "class="btn btn-danger" onclick="return confirm('Are you sure you want to delete <?php echo "$companyName";?>?')">Delete</a>
					</div>
				</div>

			</form>
		</div>
		<div class="col-sm">
			<h3>Contacts</h3>
			<!----Right Column---->
			<?php
				echo "<div class=\"my-nav\">";
				echo $editLinks . "\n\t";
				echo "</div>\n";
			 ?>
		</div>
	</div>
	
</div>
 
<?php
	include("../includes/footer.php");
?>