<!--this include file must be added to the top every page that requires admin or service permissions to view, needs testing-->
<?php
// start the session
session_start();
// redirects to index if the user does not have the correct active session 
if (!isset($_SESSION['isAdmin']) && (!isset($_SESSION['isEmergency']))) {
		header("Location: http://{$_SERVER['HTTP_HOST']}/Index.php");	
		echo "You do not have permission to view this page";
		exit();
	}
?>