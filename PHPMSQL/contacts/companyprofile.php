<?php

include ("includes/header.php");

	$id = $_GET['id'];

?>

  <div class="jumbotron clearfix">
        <h1>Company Profile</h1>

  </div>

<?php $result = mysqli_query($con, "SELECT * FROM bha_contacts WHERE id = '$id'") ?>

<?php while($row = mysqli_fetch_array($result)): ?>

	<!------Company Name--->
	<h1><?php echo $row['bha_company_name']; ?></h1>

	<!------Person Name--->
	<?php if($row['bha_person_name'] != ""): ?>
		<div>
			<b>Contact Name: </b> <?php echo $row['bha_person_name']; ?>
		</div>
	<?php endif; ?>

	<!------Address 1--->
	<div>
		<b>Address: </b> <?php echo $row['bha_address1']; ?>
	</div>

	<!------Address 2--->
	<?php if($row['bha_address2'] != ""): ?>
		<div>
			<b>Address: </b> <?php echo $row['bha_address2']; ?>
		</div>
	<?php endif; ?>

	<!------Phone 1--->
	<div>
		<b>Phone 1: </b> <?php echo $row['bha_phone1']; ?>
	</div>

	<!------Address 2--->
	<?php if($row['bha_phone2'] != ""): ?>
		<div>
			<b>Phone 2: </b> <?php echo $row['bha_phone2']; ?>
		</div>
	<?php endif; ?>

	<!----Email--->
	<div>
		<b>Email: </b> <a href="mailto:<?php echo $row['bha_email']; ?>"><?php echo $row['bha_email']; ?></a>
	</div>

	<!------URL--->
	<div>
		<b>Website: </b> <a href="<?php echo $row['bha_url']; ?>" target="_blank"><?php echo $row['bha_url']; ?></a>
	</div>

	<!------City--->
	<div>
		<b>City: </b> <?php echo $row['bha_city']; ?>
	</div>

	<!------Province--->
	<div>
		<b>Province: </b> <?php echo $row['bha_province']; ?>
	</div>

	<!------Postal Code--->
	<div>
		<b>Postal Code: </b> <?php echo $row['bha_postal']; ?>
	</div>

	<!------Description--->
	<div>
		<b>Description: </b> <br>
		<textarea rows="5" readonly="true" class="description-textarea"><?php echo $row['bha_description']; ?></textarea>
	</div>


	<!--------Sent Resume ------>
	<?php if($row['bha_resume'] == 1): ?>
		<div>
			<b>Sent Resume: </b> <input type="checkbox" name="resume" checked="true" disabled="true">
		</div>
		<?php else:?>
			<div>
				<b>Sent Resume: </b> <input type="checkbox" name="resume" disabled="true">
			</div>	
	<?php endif; ?>
	

<?php endwhile; ?>

<?php

include ("includes/footer.php");
?>