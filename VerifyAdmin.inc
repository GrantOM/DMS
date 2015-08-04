<!--this include file must be added to the top every page that requires admin or service permissions to view, needs testing-->
<?php
// create session
session_start(); 
//if the user does not have an active admin session, they are redirected to the index
if (!isset($_SESSION['isAdmin'])){
		header("Location: http://{$_SERVER['HTTP_HOST']}/Index.php");	
		echo "You do not have permission to view this page";
		exit();
	}
?>