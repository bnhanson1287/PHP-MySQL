<?php

	session_start();
	if(isset($_SESSION['labsixsessionforlogin']))
	{
		 
	}
	else 
	{
		header("Location:login.php?redirect=insert.php"); 
	}
	include("../includes/header.php");
	/*
		Grab Form Values if Button is clicked validate.
	*/

	if(isset($_POST['submit']))
	{
		$title = strip_tags(trim($_POST['title']));
		$message = strip_tags(trim($_POST['message']));

		//echo $title, $message;

		//Valid Section

		$valid = 1;
		$msgPre = "<div class=\"alert alert-success\">";
		$msgPost = "</div>\n";
		$msgPreError = "<div class=\"alert alert-info\">";

		if(strlen($title) < 3 || strlen($title) > 30)
		{
			$valid = 0;
			$valTitleMsg = "Title must be between 3 and 30 characters.";
		}

		if(strlen($message) < 20 || strlen($message) > 800)
		{
			$valid = 0;
			$valMessageMsg = "Message must be between 20 & 800 characters.";
		} 

		if($valid == 1)
		{
			$msgSuccess = "You have successfully added a post.";

			mysqli_query($con,"INSERT INTO bha_blog (bha_title,bha_message) VALUES ('$title','$message')")or die(mysqli_error($con));

			$title = "";
			$message = "";
		}
	}// end of if isset submit
?>
<h2>Insert</h2>
<form id="myform" name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	<?php 
		if($msgSuccess)
		{
			echo $msgPre . $msgSuccess . $msgPost;
		}
	?>   
		<div class="form-group">
			<label for="title">Title:</label>
			<input type="text" name="title" class="form-control" value="<?php if($title){echo "$title";} ?>">
			<?php if($valTitleMsg){echo $msgPreError. $valTitleMsg. $msgPost;} ?>
		</div>
		<div class="form-group">
			<label for="message">Message:</label>
			<textarea name="message" class="form-control"><?php if($message){echo "$message";} ?></textarea>
			<?php if($valMessageMsg){echo $msgPreError. $valMessageMsg. $msgPost;} ?>
		</div>
		<div><!----Emoticon Editor------>
			<a href="javascript:emoticon(':D')"><img src="../emoticons/icon_biggrin.gif"></a>
			<a href="javascript:emoticon('B-)')"><img src="../emoticons/icon_cool.gif"></a>
			<a href="javascript:emoticon(':(')"><img src="../emoticons/icon_sad.gif"></a>
			<a href="javascript:emoticon(':O')"><img src="../emoticons/icon_surprised.gif"></a>
			<a href="javascript:emoticon(';)')"><img src="../emoticons/icon_wink.gif"></a>
			<a href="javascript:emoticon(':)')"><img src="../emoticons/icon_smile.gif"></a>
			<a href="javascript:emoticon(':S')"><img src="../emoticons/icon_confused.gif"></a>
		</div>
		<div class="form-group">
			<label for="submit">&nbsp;</label>
			<input type="submit" name="submit" class="btn btn-info" value="Submit">
		</div>
</form>
<?php
	include("../includes/footer.php");
?>