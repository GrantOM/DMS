<?php
	require 'VerifyAdmin.inc';
	
	include dirname(__FILE__) . '\connection.php';	
	mysql_query ("DELETE FROM incident WHERE incidentID= $_GET[id]") or die(mysql_error());
	mysql_query ("DELETE FROM location WHERE locationID= $_GET[id2]") or die(mysql_error());
	mysql_query ("DELETE FROM cost WHERE costID= $_GET[id3]") or die (mysql_error());
	echo "User has been deleted!";					
	header ('Location: http://in201collab.no-ip.org/EditReport.php');	
?>