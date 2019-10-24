<?php 
	include("../includes/mysql_connect.php");

	$char_id = $_GET['id'];
	//echo $char_id;
	if(!is_numeric($char_id))
	{
		exit();
	}
	else
	{
		mysqli_query($con,"DELETE FROM characters WHERE id = '$char_id'") or die(mysqli_error($con));

		header("Location:edit.php");
	}
	


?>