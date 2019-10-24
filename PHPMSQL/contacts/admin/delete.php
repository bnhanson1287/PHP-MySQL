<?php 
	include("../includes/mysql_connect.php");

	$con_id = $_GET['id'];
	//echo $char_id;
	if(!is_numeric($con_id))
	{
		exit();
	}
	else
	{
		mysqli_query($con,"DELETE FROM bha_contacts WHERE id = '$con_id'") or die(mysqli_error($con));

		header("Location:edit.php");
	}
	


?>