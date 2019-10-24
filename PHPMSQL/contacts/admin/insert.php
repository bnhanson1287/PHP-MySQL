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

	if(isset($_POST['mysubmit']))
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


		//echo "$companyName, $website, $contactName, $email, $address1, $address2, $city, $province, $postalCode, $phone, $description, $resume";


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
			$msgSuccess = "You have successfully added ".$companyName." to your contact list!";
			mysqli_query($con, "INSERT INTO bha_contacts (bha_company_name, bha_person_name,bha_email,bha_phone1,bha_url,bha_address1,bha_address2,bha_city,bha_province,bha_postal,bha_resume,bha_description) VALUES('$companyName', '$contactName', '$email', '$phone', '$website' ,'$address1', '$address2', '$city', '$province', '$postalCode', '$resume' ,'$description')") or die(mysqli_error($con));

			$companyName = "";
			$website = "";
			$contactName = "";
			$email = "";
			$address1 = "";
			$address2 = "";
			$city = "";
			$province = "";
			$postalCode = "";
			$phone = "";
			$description = "";
			$resume = 0;
		}

	}
?>
<div class="container py-5">
	    <div class="row">
	    	<div class="col-md-10 mx-auto">
	    		<h2>Insert Contact</h2>	  
	    		<?php 
		      		if($msgSuccess)
		      		{
		      			echo $msgPre . $msgSuccess . $msgPost;
		      		}
      			 ?>          
	    		<form form name="myform"  method="post" class="formstyle" action="<?php 	echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	                <div class="form-group required row">
	                    <div class="col-sm-6 ">
	                        <label for="company-name" class="control-label">Company Name:</label>
	                        <input type="text" class="form-control" name="company-name" placeholder="Company Name" value="<?php if($companyName) {echo "$companyName";}?>">
	                        <?php 
	                        	if($valNameMsg){echo $msgPreError . $valNameMsg . $msgPost;}
	                         ?>
	                    </div>
	                    <div class="col-sm-6">
	                       	<label for="website" class="control-label">Website URL:</label>
	                       	<input type="text" class="form-control" name="website" placeholder="http://website.com" value="<?php if($website) {echo "$website";}?>">
	                       	<?php 
	                       		if($valURLMsg){echo $msgPreError . $valURLMsg . $msgPost;}
	                       	 ?>
		                </div>
		            </div>
		            <div class="form-group required row">
	                    <div class="col-sm-6">
	                        <label for="contact-name">Contact Name:</label>
	                        <input type="text" class="form-control" name="contact-name" placeholder="Contact Name" value="<?php if($contactName) {echo "$contactName";}?>">
	                    </div>
	                    <div class="col-sm-6">
	                        <label for="email" class="control-label">Email Address:</label>
	                        <input type="text" class="form-control" name="email" placeholder="Email Address" value="<?php if($email) {echo "$email";}?>">
	                        <?php 
	                        	if($valEmailMsg){echo $msgPreError . $valEmailMsg . $msgPost;}
	                        ?>
	                    </div>
	                </div>
	                <div class="form-group required row">
	                    <div class="col-sm-6">
	                        <label for="address-1">Address 1:</label>
	                        <input type="text" class="form-control" name="address-1" placeholder="Address 1" value="<?php if($address1) {echo "$address1";}?>">
	                    </div>
	                    <div class="col-sm-6">
	                       <label for="address-2">Address 2:</label>
	                        <input type="text" class="form-control" name="address-2" placeholder="Address 2" value="<?php if($address2) {echo "$address2";}?>"> 
	                    </div>
	                </div>
	                <div class="form-group required row">
	                    <div class="col-sm-6">
	                    	<label for="city">City:</label>
	                        <input type="text" class="form-control" name="city" placeholder="City" value="<?php if($city) {echo "$city";}?>">
	                    </div>
	                    <div class="col-sm-6">
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
	                <div class="form-group required row">
	                    <div class="col-sm-6">
	                         <label for="postal">Postal Code:</label>
	                        <input type="text" class="form-control" name="postal" placeholder="H0H 0H0" value="<?php if($postalCode) {echo "$postalCode";}?>">
	                    </div>
	                    <div class="col-sm-6">
                        	 <label for="phone" class="control-label">Phone:</label>
	                        <input type="text" class="form-control" name="phone" placeholder="1235554444" value="<?php if($phone) {echo "$phone";}?>">
	                        <?php 
	                        	if($valPhoneMsg){echo $msgPreError . $valPhoneMsg . $msgPost;}
	                         ?>
	                    </div>
	                </div>
	                <div class="form-group row">
	                    <div class="col-sm-6">
	                       <label for="description">Description:</label>
                        	<textarea class="form-control" name="description" rows="3"><?php if($description) {echo "$description";}?></textarea>
	                    </div>
	                    <div class="col-sm-6">
	                    	<div class="form-check">
                          		<label>	
                          			<input type="checkbox" name="resume" value="1" <?php if(isset($resume) && $resume == "1"){echo "checked";} ?>> Sent a Resume?
                          		</label> <br>
                          		<input type="submit" class="btn btn-primary" name="mysubmit">
                      		</div> 
	                    </div>
	                </div>
	            </form>
            </div>
      	</div>
	</div><!-- / .container -->
<?php
	include("../includes/footer.php");
?>