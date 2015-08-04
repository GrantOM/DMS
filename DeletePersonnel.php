<?php
	//controls user access, which is admin only for this page
	require 'VerifyAdmin.inc';
	//connect to database
	include dirname(__FILE__) . '\connection.php';
	//delete the row from the personnel table with the ID that matches the person's ID
	mysql_query ("DELETE FROM `personnel` WHERE personnelID = $_GET[id]") or die(mysql_error());
	//delete the row from the login table with the ID that matches the person's ID
	mysql_query ("DELETE FROM `login` WHERE loginID = $_GET[id]") or die(mysql_error());
	//display appropriate message and redisplay the management page
	echo "User has been deleted!";					
	require "ManagePersonnel.php";
?>