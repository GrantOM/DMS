<?php
// check for active admin session
require 'VerifyAdmin.inc';
// enable error reporting 
error_reporting(E_ALL);
ini_set('display_errors', '1');
$search_output = "";
// connect to the Database
include dirname(__FILE__) . '\connection.php';

// Process the search query
if(isset($_POST['searchquery']) && $_POST['searchquery'] != ""){
// run code if condition meets here	
	$searchquery = preg_replace('#[^a-z 0-9?]#i', '', $_POST['searchquery']);
	if($_POST['filter1'] == "0"){
		$sqlCommand = "SELECT * FROM `incident` WHERE `iTypeID` = 0 AND `disasterName` LIKE '%$searchquery%'";
	}else if($_POST['filter1'] == "1"){
		$sqlCommand = "SELECT * FROM `incident` WHERE `iTypeID` = 1 AND `disasterName` LIKE '%$searchquery%'";
	}else if($_POST['filter1'] == "2"){
		$sqlCommand = "SELECT * FROM `incident` WHERE `iTypeID` = 2 AND `disasterName` LIKE '%$searchquery%'";
	}else if($_POST['filter1'] == "3"){
		$sqlCommand = "SELECT * FROM `incident` WHERE `iTypeID` = 3 AND `disasterName` LIKE '%$searchquery%'";
	}else if($_POST['filter1'] == "4"){
		$sqlCommand = "SELECT * FROM `incident` WHERE `iTypeID` = 4 AND `disasterName` LIKE '%$searchquery%'";
	}else if($_POST['filter1'] == "5"){
		$sqlCommand = "SELECT * FROM `incident` WHERE `iTypeID` = 5 AND `disasterName` LIKE '%$searchquery%'";
	}else if($_POST['filter1'] == "6"){
		$sqlCommand = "SELECT * FROM `incident` WHERE `iTypeID` = 6 AND `disasterName` LIKE '%$searchquery%'";
	}else if($_POST['filter1'] == "7"){
		$sqlCommand = "SELECT * FROM `incident` WHERE `iTypeID` = 7 AND `disasterName` LIKE '%$searchquery%'";
	}
	//execute query and count rows returned
	$query = mysql_query($sqlCommand) or die(mysql_error());
	$count = mysql_num_rows($query);
	
	// when a row is returned some info and modify/delete links are displayed
	if($count >= 1){
		//$search_output .= "<hr />$count results for <strong>$searchquery</strong><hr />$sqlCommand<hr />";
		while($row = mysql_fetch_array($query)){
   			$incidentID = $row["incidentID"];
			$disasterDesc =$row["description"];
   			$search_output .= "Item ID: <br> $incidentID <br> Disaster Description: <br> $disasterDesc<br/> 
   			<a href=\"modify_incident.php?id=" . $row['incidentID'] . "&id2=". $row['locationID'] . "&id3=" . $row['costID'] . "\">Modify Incident</a> 
   			<a href=\"delete_incident.php?id=" . $row['incidentID'] . "&id2=". $row['locationID'] . "&id3=" . $row['costID'] . "\">Delete Incident</a><br/>";
   		} // close while
	} else {
		echo "No rows returned";		
	}
}
?>

<html>
<head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<fieldset>
<legend>Incident Search Form</legend>

<p><label>Search a Disaster (by name): <input name="searchquery" type="text"></label></p>
<p><label>Search by Type:</label></p> <select name="filter1">
<option value="0">None</option>
<option value="1">Fire</option>
<option value="2">Flood</option>
<option value="3">Hurricane</option>
<option value="4">Tropical Storm</option>
<option value="5">LandSlide</option>
<option value="6">Biological Outbreak</option>
</select>

</fieldset>
<input name="myBtn" type="submit">
<br/>
<br/>
<div>
<?php echo $search_output; ?>
</div>
</form>		
</body>	
</head>	
</html>