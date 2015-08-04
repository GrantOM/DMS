<?php
	require 'VerifyAdmin.inc';
	
	include dirname(__FILE__) . '\connection.php';
	
	if(!isset($_POST['deploy'])){	
		$q3 = "SELECT * FROM linklocper WHERE personnelID = $_GET[id] ";
		$results3 = mysql_query($q3);
		$personnel3 = mysql_fetch_array($results3);
	}
?>

<?xml version="1.0" encoding="utf-8"?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Deploy Personnel</title>
	<!-- selected which header to display -->
	<?php require 'DMSSelectHeader.php'?>
</head>

<body>
	<div id="wrapper">
	<!-- start page -->
		<div id="page">
		
		<!--includes all the menu buttons-->
		<?php include 'DMSMenu.inc'; ?>

			<!-- sidebar that containts relevant links to the current page -->
			<div id="sidebar1" class="sidebar">
				<h2> Related Links </h2>
				<ol>
					<li><a href="FindPersonnel.php">Find Personnel</a></li>
					<li><a href="AddPersonnel.php">Add Personnel</a></li>
					<li><a href="ManagePersonnel.php">Modify Personnel</a></li>
					<li><a href="DeployedPersonnel.php">Deployed Personnel</a></li>
				</ol>
			</div>

			<div id="content" class="content">
						
				<div id="stylized" class="myform">
					<form action="DeployPersonnel.php" method="POST">
					<h2>Deploy Personnel</h2>
					<p>Here you can deploy an individual personnel to a location or cease their deployment.</p>

					<?php
					//connects to DB
					include dirname(__FILE__) . '\connection.php';
					
					// query that returns all location types
					$query = "SELECT * FROM location";
					$result = mysql_query($query);
					?>
					
					<!-- creates a select box based on the entries in the location table -->
					<label>Deployment Location
					<span class="small">Select none to end deployment</span>
					</label>
					<select id="location" name="location">
						<option value="">Return to Base</option>
						<?php 
						while($type = mysql_fetch_array($result)) {
								echo "<option value=" .$type['locationID']. ">" .$type['streetNumber'] . ", " . $type['streetName'].
									", ". $type['suburb'] ."</option>";
						}
						?>
					</select>
					
					<button type="submit" name="deploy">Deploy</button>
					
					<!-- Hidden input to record the id in the URL -->
					<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
					
					</form>
					<?php
					if(isset($_POST['deploy'])){
					
					//count the rows returned from the query. This will allow us to call the appropriate
					//DELETE, UPDATE or INSERT query
					$testquery = "SELECT * FROM linklocper WHERE personnelID = '$_POST[id]'";
					$query = mysql_query($testquery) or die(mysql_error());
					$count = mysql_num_rows($query);
					
					//records the current time of the deployment
					date_default_timezone_set('Australia/Brisbane');
					$datenow = date('Y-m-d H:I', time());
					
					if (($_POST['location']) == "") {
						$u3 = "DELETE FROM linklocper WHERE personnelID = $_POST[id]";
					} else if ($count > 0) {
						$u3 = "UPDATE linklocper SET deployedDate = '$datenow', locationID = '$_POST[location]' WHERE personnelID = $_POST[id]";
					} else {
						$u3 = "INSERT INTO `linklocper` VALUES ($_POST[location], $_POST[id], '$datenow')";
					}
					
					echo "<br/><br/>";
					
					//execute the query
					mysql_query($u3) or die (mysql_error());
					
					//display appropriate success message
					if (($_POST['location']) == "") {
						echo '<br/><i>Service has ended its deployment! Now returning to the Manage Personnel page...</i>';
					} else {					
						echo '<br/><i>Service has been deployed! Now returning to the Manage Personnel page...</i>';
					}
					
					//redirect the user to the personnel management page after 4 seconds
					echo '<meta http-equiv="refresh" content="4; url= http://', $_SERVER['HTTP_HOST'], '/ManagePersonnel.php">';
					
					}
					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
