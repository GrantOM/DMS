<!--Link the contents of this page to a menu or header button-->
<?php
	session_start();
	//unsets all the session variables, effectively logging the user out
	unset($_SESSION['isVolunteer']);
	unset($_SESSION['isEmergency']);
	unset($_SESSION['isAdmin']);
	//redirects to the index
	header("Location: http://{$_SERVER['HTTP_HOST']}/Index.php");
	//terminates the script
	exit();
	echo 'You have successfully logged out';
?>