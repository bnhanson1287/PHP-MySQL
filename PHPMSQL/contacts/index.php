<?php

include ("includes/header.php");

?>

  <div class="jumbotron clearfix">
        <h1><?php echo APP_NAME ?></h1>

  </div>

<?php $result = mysqli_query($con, "SELECT * FROM bha_contacts ORDER BY bha_company_name") ?>

<?php while($row = mysqli_fetch_array($result)): ?>

	<a href="companyprofile.php?id=<?php echo $row['id']; ?>"><?php echo $row['bha_company_name']; ?></a><br>
<?php endwhile; ?>

<?php

include ("includes/footer.php");
?>