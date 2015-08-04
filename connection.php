<?php
//connect to the Database
	$dbhost = 'localhost';
	$dbuser = 'INB201';
	$dbpass = 'disaster';	
	$db = 'inb201_draft';
	
	$conn = mysql_connect($dbhost,$dbuser,$dbpass);
	mysql_select_db($db);
?>
