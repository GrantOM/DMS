<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Map</title>
<head>
<?php require 'DMSSelectHeader.php'?>
<!-- stylesheet for the map and its interface -->
<link rel="stylesheet" type="text/css" href="Leaflet/dist/leaflet.css" />
</head>



<body >
	<div id="wrapper">
	  <!-- start page -->
		<div id="page">
		
			<!--includes all the menu buttons-->
			<?php include 'DMSMenu.inc'; ?>		
			<!-- sidebar with relevant links -->
			<div id="sidebar1" class="sidebar">
				<h2> Related Links </h2>
				<ol>
					<li><a href="IncidentTracker.php">Public Incident Tracker</a></li>
					<li><a href="HistoricalReports.php"> Archived Reports</a></li>
				</ol>
			</div>

			<div id="content" class="content">
				<!-- this the div that the map places itself within -->
				<div id="map" style=" width: 670px; height: 320px; margin: 20px auto 0 auto;"></div>
				
				<!-- posts input data to this page -->
				<form id="report-form" name="report-form" method="GET">
				
				<?php
				// connect to database
				include dirname(__FILE__) . '\connection.php';

				// query that returns all incident types that aren't the 'placeholder' value
				$query = "SELECT incident.incidentID, incident.disasterName, location.suburb FROM incident, location WHERE incident.locationID = location.locationID";
				
				// execute query
				$result = mysql_query($query);
				?>
				
				
				<!-- div that provides styled input fields -->
				<div id="stylized" class="myform">
					<h1>Incident Map</h1>
					<p>Use this form to locate any incidents in the nearby area</p>

					<!-- select box comprised of incident and location data from database -->
					<label>Select Incident
					<span class="small">Select the incident you wish to locate</span>
					</label>
					<select id="disaster" name="disaster" required="required">
						<option value=""> Select One </option>
						<?php 
						while($type = mysql_fetch_array($result)) {
							echo "<option value=" .$type['incidentID']. ">" .$type['disasterName'] . ", " . $type['suburb']. "</option>";
						}
						?>
					</select>
					<!-- submit button with inline styling as its normal position is not suitable for this form -->
					<button type="submit" style="margin:0 0 0 15px;">Locate</button>
				</div>
				<?php
				//create new database object
				$pdo = new PDO('mysql:host=localhost;dbname=inb201_draft', 'INB201', 'disaster');
				//enable error checking on the database object
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				try {
				//query that gets incident data for the message box and location data for the map marker
				$find = $pdo->query("SELECT description, disasterName, dangerLevel, suburb, ".
										"mapLat, mapLon, streetNumber,streetName, postCode, state ".
										"FROM incident, location ".
										"WHERE incident.locationID = location.locationID AND ".
										"'" . @$_GET['disaster']. "' = incident.incidentID")->fetch();
				
				}
				// if error is caught display error message
				catch (PDOException $e)
				{
				echo 'Invalid input', $e->getMessage();
				}
				
				//variables that will be used by the javascript to generate message boxes and map markers
				$xcoord = $find['mapLat'];
				$ycoord = $find['mapLon'];
				$name = $find['disasterName'];
				$desc = $find['description'];
				$loc = $find['streetNumber'] . " " . $find['streetName'] . " " . $find['suburb']  . " " . $find['postCode'] . " " . $find['state'];
				?>

				<!-- the following two lines allow the php variables (defined above) to be used in the external
				javascript files -->
				<script type="text/javascript">var xcoord = "<?= $xcoord ?>";</script>
				<script type="text/javascript">var ycoord = "<?= $ycoord ?>";</script>
				<script type="text/javascript">var name = "<?= $name ?>";</script>
				<script type="text/javascript">var desc = "<?= $desc ?>";</script>
				<script type="text/javascript">var loc = "<?= $loc ?>";</script>
				<script type="text/javascript" src="Leaflet/dist/leaflet.js"></script>
				<script type="text/javascript" src="Leaflet/dist/leafletembed.js"></script>

				</form>
			</div>
		</div>	
	</div>
	<?php include "Footer.inc" ?>
</body>

</html>
