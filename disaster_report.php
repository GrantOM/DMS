<?php
	//checks that the user is an admin
	require 'VerifyAdmin.inc';
	
	//connects to the database
	include dirname(__FILE__) . '\connection.php';
	
	//assigning the data taken from the new report page to variables
	$name = $_POST['inputIncident'];
	$desc = $_POST['inputDescription'];
	$time = $_POST['inputTime'];
	$date = $_POST['inputDate'];
	$danger = $_POST['inputdangerLevel'];
	$type = $_POST['type'];
	$street= $_POST['inputStreet'];
	$number = $_POST['inputNumber'];
	$suburb = $_POST['inputSuburb'];
	$postcode = $_POST['inputPostCode'];
	$lattitude = $_POST['inputLattitude'];
	$longitude = $_POST['inputLongitude'];
	$state = $_POST['state'];	
	$inf = $_POST['inputInfra'];
	$prod = $_POST['inputProd'];
	$domestic = $_POST['inputDomestic'];
	$lives = $_POST['inputLives'];

	//check if the form has been submitted, if not display a message and return to the new report page
	if(!$_POST['submit']){
		echo "please fill out the form";
		echo '<meta http-equiv="refresh" content="2; url= http://', $_SERVER['HTTP_HOST'], '/NewReport.php">';
	} else {
		//query that inserts the location data into the database
		mysql_query("INSERT INTO location (`locationID`,`streetName`,`streetNumber`,`suburb`,`postCode`,`mapLat`,`mapLon`,`state`)
					VALUES(NULL, '$street','$number','$suburb','$postcode','$lattitude','$longitude','$state')") or die (mysql_error());
		$q = mysql_insert_id();
		//query that inserts the cost data into the database
		mysql_query("INSERT INTO cost (`costID`, `prodDamage`, `domDamage`, `infDamage`, `livesLost`)
					VALUES(NULL, '$prod', '$domestic' ,'$inf', '$lives')") or die (mysql_error());
		$q2 = mysql_insert_id();
		//query that inserts the incident data into the database
		mysql_query ("INSERT INTO incident (`incidentID`,`disasterName`,`description`, `time`, `date`,`dangerLevel`, `isresolved`, `isPublic`, `iTypeID`,`locationID`, `costID`)
					VALUES(NULL, '$name','$desc', '$time', '$date', '$danger','0','0','$type','$q', '$q2')") or die (mysql_error());
		//displays a message and redirects to the new report page
		echo "The Report Has been added";
		echo '<meta http-equiv="refresh" content="2; url= http://', $_SERVER['HTTP_HOST'], '/NewReport.php">';
	}
?>					