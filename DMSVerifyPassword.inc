<?php
//checks if the password belongs to the given username and if they're also an admin
//returns true if a row is returned
function checkAdminPassword($username, $password) {
	$pdo = new PDO('mysql:host=localhost;dbname=inb201_draft', 'INB201', 'disaster');

		$stmt = $pdo->prepare('SELECT * '.
		'FROM login '.
		'WHERE loginUser = :username and loginPass = SHA2(:password, 0) and loginGroup = 1');
		$stmt->bindValue(':username', $username);
		$stmt->bindValue(':password', $password);
		$stmt->execute();
		return $stmt->rowCount() > 0;
}
//checks if the password belongs to the given username and if they're also a service person
//returns true if a row is returned
function checkEmergencyServicePassword($username, $password) {
	$pdo = new PDO('mysql:host=localhost;dbname=inb201_draft', 'INB201', 'disaster');

		$stmt = $pdo->prepare('SELECT * '.
		'FROM login '.
		'WHERE loginUser = :username and loginPass = SHA2(:password, 0) and loginGroup > 1');
		$stmt->bindValue(':username', $username);
		$stmt->bindValue(':password', $password);
		$stmt->execute();
		return $stmt->rowCount() > 0;
}
//checks if the password belongs to the given username and if they're also an volunteer
//returns true if a row is returned
function checkVolunteerPassword($username, $password) {
	$pdo = new PDO('mysql:host=localhost;dbname=inb201_draft', 'INB201', 'disaster');

		$stmt = $pdo->prepare('SELECT * '.
		'FROM login '.
		'WHERE loginUser = :username and loginPass = SHA2(:password, 0) and loginGroup = 0');
		$stmt->bindValue(':username', $username);
		$stmt->bindValue(':password', $password);
		$stmt->execute();
		return $stmt->rowCount() > 0;
}
?>
