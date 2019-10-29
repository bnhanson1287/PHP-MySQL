<?php 
session_start();
if(isset($_SESSION['labsixsessionforlogin']))
{
	 
}
else 
{
	header("Location:login.php?redirect=edit.php"); 
}

include("../includes/header.php");

	$host = $_SERVER['REQUEST_URI'];
	//echo $host;
	$blog_id = $_GET['id'];

	if(!isset($blog_id))
	{
		$result = mysqli_query($con, "SELECT bid FROM bha_blog LIMIT 1");
		while($row = mysqli_fetch_array($result))
		{
			$blog_id = $row['bid'];
		}
	}
	//UPDATE PROCESS
	if(isset($_POST['submit']))
	{
		$title = strip_tags(trim($_POST['title']));
		$message = strip_tags(trim($_POST['message']));


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
			$msgSuccess = "You have successfully updated ".$title.".";

			mysqli_query($con,"UPDATE bha_blog SET bha_title = '$title', bha_message = '$message' WHERE bid = $blog_id ")or die(mysqli_error($con));

			$title = "";
			$message = "";
		}
	}// end of if isset submit

	// Create List of Titles
	$result = mysqli_query($con, "SELECT bid, bha_title FROM bha_blog ORDER BY bid DESC") or die(mysqli_error($con));

	while($row = mysqli_fetch_array($result))
	{
		$title = $row['bha_title'];
		$id = $row['bid'];

		if($id == $blog_id)
		{
			$editLinks .= "\t\t\t<option \"value=\"edit.php?id=$id\" selected=\"true\">" . $title ."</option>\n";
		}
		else
		{
			$editLinks .= "\t\t\t<option value=\"edit.php?id=$id\">" . $title ."</option>\n";	
		}
		
	}

	//Prepopulate blog fields

	$result = mysqli_query($con, "SELECT * FROM bha_blog WHERE bid = $blog_id")or die(mysqli_error($con));
	while($row = mysqli_fetch_array($result))
	{
		$title = $row['bha_title'];
		$message = $row['bha_message'];
	}

 ?>
<div class="container">
	<h2>Edit Blog Post</h2>
		<p>&nbsp;</p>
		<form>
			<div class="form-group">
				<select name="entryselect" class="form-control" onchange="go()">
					<?php  echo $editLinks ?>
				</select>
			</div>
		</form>
		<form id="myform" name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>">
			<?php 
				if($msgSuccess)
				{
					echo $msgPre . $msgSuccess . $msgPost;
				}
			?>   
			<div>
				<label for="title">Title: </label>
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
				<input type="submit" name="submit" class="btn btn-info" value="Update">
				<a href="delete.php?id=<?php echo "$blog_id";?> "class="btn btn-danger" onclick="return confirm('Are you sure you want to delete <?php echo "$title";?>?')">Delete</a>
			</div>
		</form>
	</div>
</div>
 
<?php
	include("../includes/footer.php");
?>