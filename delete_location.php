<?php
	include dirname(__FILE__) . '\connection.php';
		
	mysql_query ("DELETE FROM location WHERE locationID= $_GET[id2]") or die(mysql_error());
	echo "Location has been deleted!";					
	header ('Location: output.php');	
?>