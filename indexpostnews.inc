<div id="stylized" class="myform">
	<form id="newspost" name="newspost" method="POST" action="newspost.php">
	<h1>Create News Post</h1>
	<p>Use this form to create a new news article on the front page.</p>
	
	<!-- input here creates the headline -->
	<label>Headline
	<span class="small">News Headline</span>
	</label>
	<textarea rows="2" cols="10" id="newstitle" name="newstitle"
	placeholder="Headline" required="required"></textarea>

	<!-- input here creates the content -->
	<label>News Content
	<span class="small">Content for the article</span>
	</label>
	<textarea rows="4" cols="20" id="newscontent" name="newscontent"
	placeholder="Content" required="required"></textarea>

	<!-- submit button -->
	<input type="submit" name="submit" value="Submit"/>
	<div class="spacer"></div>	
	</form>
</div>

<!-- sets timezone to Brisbane and creates a date object with the current time-->
<?php date_default_timezone_set('Australia/Brisbane');
$date = date('m/d/Y h:iA', time());?>

<?php 					
// when submit is clicked the input is submitted in the string (concatenated with other strings) below
if (isset($_POST['submit'])) {
	$newspost = '<div class="post"><h1 class="title">' . $_POST['newstitle'] . 
	'</h1><div class="entry"><p>'. $_POST['newscontent'] . '</p><div class="byline"><small>' . $date . 
	' by <a href="#"> ' . $_SESSION['USERNAME'] . '</a></small></div></div></div>';
	
	// add the string to the text file that stores the news posts
	file_put_contents("textonly.txt", $newspost, FILE_APPEND);
	
	// redirect to the index to display the new post
	echo '<meta http-equiv="refresh" content="0; url= http://', $_SERVER['HTTP_HOST'], '/index.php">';
}
?>

			