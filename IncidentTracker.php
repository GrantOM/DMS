<?xml version="1.0" encoding="utf-8"?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<title> Incident Tracker </title>

<head>
	<!-- selected which header to display -->
	<?php require 'DMSSelectHeader.php'?>
</head>

<body>
	
	<div id="wrapper">
	<!-- start page -->
		<div id="page">

			<!--includes all the menu buttons-->
			<?php include 'DMSMenu.inc'; ?>			
			
			<div id="sidebar1" class="sidebar">
				<h2> Related Links </h2>
				<ul>
					<li><a href="Maps.php">Map</a></li>
					<li><a href="Contact.php">Emergency Contacts</a></li>
				</ul>
			</div>


			<div id="content">
			
				<div id="stylized" class="myform">
					<!-- this posts/gets data to/from the page on submit -->
					<form method="GET" action="IncidentTracker.php">
					<h2>Emergency Event Search</h2>
					<p>Here you can search for and find information about emergencies occuring in and around your area.</p>
					
					<!-- this label and span tag allow styling of the form inputs -->
					<label>Disaster
					<span class="small">Select type of disaster</span>
					</label>				
					<?php 
					//opens a connection to the database from this include file
					include dirname(__FILE__) . '\connection.php';
					
					//query string that returns all incident types that aren't the 'placeholder' value
					$query = "SELECT * FROM `itype` WHERE iTypeID > 0";
					
					//submitting the query string to the database
					$result = mysql_query($query);

					//this pulls disaster types from the database and creates a select box with the data
					echo '<select id="disaster" name="disaster" required="required"> '.
					'<option value="">Select</option>';
					while($type = mysql_fetch_array($result)) {
						echo "<option value=" .$type['iTypeID']. ">" .$type['type']. "</option>";
					}
					echo '</select>';
					?>

					<!-- select box for the input that will search for resolved or unresolved disasters -->
					<label>Status
					<span class="small">Has the incident been resolved?</span>
					</label>
					<select id="resolved" name="resolved" required="required" value="<?php $_GET['resolved']; ?>">
					<option value=""> Select </option>
					<option value="1"> Yes </option>
					<option value="0"> No </option>
					</select>

					<!-- date input that allows us to search by date -->
					<label>Date
					<span class="small">Date the incident occured</span>
					</label>
					<input type="date" name ="date" placeholder = "YYYY-MM-DD" />

					<!-- creates a button that when clicked will search for reports in the database -->
					<button type="submit" name="search">Search</button>
					<div class="spacer"></div>

					</form>
				</div>
				<?php
				//only run this section of code if the search button has been clicked
				if (isset($_GET['search'])) {
					//creates a new database object using the details required to access the database
					$pdo = new PDO('mysql:host=localhost;dbname=inb201_draft', 'INB201', 'disaster');
					//sends a query to the database that searches for disaster reports based of data that was entered on the page
					$find = $pdo->query("SELECT * FROM incident, location ".
											"WHERE incident.iTypeID = '" .$_GET['disaster']. "' AND incident.locationID = location.locationID ".
											"AND incident.isresolved = '" .$_GET['resolved']. "'" );
					//create a new (styled) table and headers before the foreach loop that prints the data retrieved from
					//the database
					echo '<h2> Search Results: </h2>';	
					echo '<table class="altrowstable" id="alternatecolor"><tr><th>Date</th><th>Danger Level</th><th>Disaster</th>';
					echo '<th>Location</th><th>Resolved</th><th>Map View</th>';
					//foreach loop that returns each row of data from the array created by the query and displays them in
					//table rows
					foreach($find as $data) {					
						echo '<tr><td>', $data['date'], '</td>';
						echo '<td>', $data['dangerLevel'], '</td>';
						echo '<td>', $data['description'], '</td>';
						echo '<td>', $data['streetNumber'], ', ', $data['streetName'], ', ', $data['suburb'], ', ', $data['postCode'],'</td>';
						echo '<td>', $data['isresolved'], '</td>';
						echo '<td><a href="Maps.php?disaster=', $data['incidentID'],'&button=Submit">Link</a></td></tr>';
					}
					echo '</table>';
				}
				?>
			</div>
		</div>
	</div>
	<!-- footer file that spaces the content and sidebar from the very bottom of the page -->
	<?php include "Footer.inc" ?>
</body>	
</html>