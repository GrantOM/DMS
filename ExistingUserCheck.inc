<?php
	function checkExistingUsers($username) {
		//create database object
		$pdocheck = new PDO('mysql:host=localhost;dbname=inb201_draft', 'INB201', 'disaster');
		
		//create prepared statement for database
		$stmt = $pdocheck->prepare('SELECT * '.
		'FROM login '.
		'WHERE loginUser = :username');
		
		//bind variable to prepared statement variable
		$stmt->bindValue(':username', $username);
		
		//execute prpared statement
		$stmt->execute();
		
		//when called this function will return the number of rows returned from the query
		return $stmt->rowCount() > 0;
	}
?>
						