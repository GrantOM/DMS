<?php require 'VerifyUser.inc' ?>
<?xml version="1.0" encoding="utf-8"?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Report Search</title>
		<!-- selected which header to display -->
		<?php require 'DMSSelectHeader.php'?>
	</head>
	
	<body>
		<div id="wrapper">
			<div id="page">

				<?php require 'DMSMenu.inc' ?>

				<div id="sidebar1" class="sidebar">
					<h2> RelatedLinks </h2>
						<ol>
							<li><a href="NewReport.php">New Report</a></li>	
							<li><a href="EditReport.php">Edit/Delete Report</a></li>	
							<li><a href="DisasterReports.php">Incident Search</a></li>
							<li><a href="HistoricalReports.php">Archived Reports</a></li>
							<li><a href="GraphsStatistics.php">Statistics</a></li>
						</ol>
				</div>
			
				<div id="content" class="content">		
									
					<?php
						require 'GenerateFields.inc';
						
						echo '<div id="stylized" class="myform">';
						echo '<form action="DisasterReports.php" method="GET" >';
						echo '<h1>Find Disaster Report</h1>';
						echo '<p>Use this form to search for a disaster report.</p>';
						
						echo '<label>Disaster '.
						'<span class="small">Select type of disaster</span> '.
						'</label> ';
						include dirname(__FILE__) . '\connection.php';
						
						// query that returns all incident types that aren't the 'placeholder' value
						$query = "SELECT * FROM itype WHERE iTypeID > 0";

						$result = mysql_query($query);
						// Create drop-down box to choose disaster type.
						echo '<select id="" name="disaster" required="required"> '.
						'<option value="">Select</option>';
						while($type = mysql_fetch_array($result)) {
							echo "<option value=" .$type['iTypeID']. ">" .$type['type']. "</option>";
						}
						echo '</select>';
						
						// Create drop-down box to choose if the disaster is resolved.					
						echo '<label>Incident Resolved? '.
						'<span class="small">Select the status of the incident</span> '.
						'</label> ' .
						'<select id="resolved" name="resolved" required="required"> ' .
						'<option value="">Select</option>' .
						'<option value="1">Yes</option>' .
						'<option value="0">No</option>' .
						'</select>';
						
						// Create text-box to enter a date.
						echo '<label>Date<span class="small">Enter the date</span></label>';
						echo '<input type="date" name="date" id="date" placeholder="YYYY-MM-DD"/>';

						echo '<button type="submit" name="find">Find</button>';
						echo '<div class="spacer"></div>';
						echo '</form>';
						echo '</div>';
					?>
					
							
					<?php 
					if (isset($_GET['find'])) {
				
						$pdo = new PDO('mysql:host=localhost;dbname=inb201_draft', 'INB201', 'disaster');
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						
						try {
						// Queries database with set parameters. If input for date is entered, show results specific to date. Else date is not specific.
							if ($_GET['date'] != "") {
								$find = $pdo->query("SELECT * FROM incident, location, cost, itype ".
													"WHERE itype.iTypeID = '" .$_GET['disaster']. "' AND incident.locationID = location.locationID ".
													"AND itype.iTypeID = incident.iTypeID AND incident.costID = cost.costID ".
													"AND incident.isresolved = '" .$_GET['resolved']. "' AND incident.date = '" .$_GET['date']. "'" );
							} else {
								$find = $pdo->query("SELECT * FROM incident, location, cost, itype ".
													"WHERE itype.iTypeID = '" .$_GET['disaster']. "' AND incident.locationID = location.locationID ".
													"AND itype.iTypeID = incident.iTypeID AND incident.costID = cost.costID ".
													"AND incident.isresolved = '" .$_GET['resolved']. "'");
							}
							
						} catch (PDOException $e){
							echo $e->getMessage();
						} 
						
						echo '<h2> Search Results: </h2>';
						// Create table for output with headers listed below:
						echo '<table class="altrowstable" id="alternatecolor" style="width:200px"><tr><th>Date</th><th>Danger Level</th><th>Disaster</th>';
						echo '<th>Location</th><th>Resolved</th><th>Domestic Damage</th><th>Infrastructure Damage</th>';
						echo '<th>Produce Damage</th><th>Lives Lost</th></tr>';
						
						foreach($find as $data) {
						// Enter output from database into table.
							echo '<tr><td>', $data['date'], '</td>';
							echo '<td>', $data['dangerLevel'], '</td>';
							echo '<td>', $data['disasterName'], '</td>';
							echo '<td>', $data['streetNumber'], ', ', $data['streetName'], ', ', $data['suburb'], ', ', $data['state'], ', ', $data['postCode'],'</td>';
							echo '<td>', $data['isresolved'], '</td>';
							echo '<td>', $data['domDamage'], '</td>';
							echo '<td>', $data['infDamage'], '</td>';
							echo '<td>', $data['prodDamage'], '</td>';
							echo '<td>', $data['livesLost'], '</td>';
							echo '</tr>';
						}
						echo '</table>';
					}					
					?>
					
				</div>									
			</div>
		</div>
		<?php include "Footer.inc" ?>
	</body>
	
</html>