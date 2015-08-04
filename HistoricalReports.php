<?xml version="1.0" encoding="utf-8"?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<title> Archived Reports </title>
	
<head>
	<!-- selected which header to display -->
	<?php require 'DMSSelectHeader.php'?>
</head>
	
<body>
	<!-- start wrapper -->
	<div id="wrapper">
		<!-- start page -->
		<div id="page">
		<!-- menu bar -->
		<?php require 'DMSMenu.inc' ?>
		<!-- displays related links in a sidebar -->
		<div id="sidebar1" class="sidebar">
			<h2> Related Links </h2>	
			<ul>				
				<li><a href="IncidentTracker.php">Incident Tracker</a></li>
				<li><a href="Maps.php">Map</a></li>
			</ul>
		</div>
			<!-- start content -->
			<div id="content" class="content">
	
				<?php require 'GenerateFields.inc';
				// Initiate the database connection
				$pdo = new PDO('mysql:host=localhost;dbname=inb201_draft', 'INB201', 'disaster');
				
				// enable error checking/exception handling
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				// Start DB query and try catch error exception handling
				try {	
				$find = $pdo->query("SELECT * FROM incident, location, itype, cost ".
				"WHERE incident.isresolved = 1 AND location.locationID = incident.locationID " .
				"AND itype.iTypeID = incident.iTypeID AND cost.costID = incident.costID ORDER BY incident.date");
				
				// displays a message if an error/exception is raised
				} catch (PDOException $e){
							echo $e->getMessage();
						} 
				// Create Table 
				echo '<div id="stylized" class="myform">';
				echo '<h2>Past Disaster Reports</h2>';
				echo '<p>Here is a list where you can search for archived disaster and incident reports</p>';
				echo '</div>';
				echo '<table class="altrowstable" id="alternatecolor"><tr><th>Date</th><th>Danger Level</th><th>Disaster</th>';
				echo '<th>Location</th><th>Resolved</th><th>Lives Lost</th>';
				
				// Insert information taken from the database as an array into table through the foreach loop.
				foreach($find as $data) {
											
						echo '<tr><td>', $data['date'], '</td>';
						echo '<td>', $data['dangerLevel'], '</td>';
						echo '<td>', $data['type'], '</td>';
						echo '<td>', $data['streetNumber'], ', ', $data['streetName'], ', ', $data['suburb'], ', ', $data['state'], ', ', $data['postCode'],'</td>';
						echo '<td>', $data['isresolved'], ' (Yes)</td>';
						echo '<td>', $data['livesLost'], '</td></tr>';
				}
				echo '</table>';
				
			?>
			</div>
		</div>
	</div>
	<?php include "Footer.inc" ?>
</body>
</html>