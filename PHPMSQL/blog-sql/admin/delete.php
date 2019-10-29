<?php 
	include("../includes/mysql_connect.php");

	$blog_id = $_GET['id'];
	//echo $char_id;
	if(!is_numeric($blog_id))
	{
		exit();
	}
	else
	{
		mysqli_query($con,"DELETE FROM bha_blog WHERE bid = '$blog_id'") or die(mysqli_error($con));

		header("Location:edit.php");
	}
	


?>