<?php require 'VerifyAdmin.inc';?>
<xml version="1.0" encoding="utf-8"?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" >
<title>Create Incident Report</title>
	<head>
		<!-- selected which header to display -->
		<?php require 'DMSSelectHeader.php'?>
	</head>
	
	<body>
	
	<div id="wrapper">
	<!-- start page -->
		<div id="page">	
			<!--includes all the menu buttons-->
			<?php include 'DMSMenu.inc';?>
			<!-- sidebar containing related links -->
			<div id="sidebar1" class="sidebar">
				<h2>Related Pages</h2>
				<ol>
					<li><a href="IncidentTracker.php">Incident Tracker</a></li>
					<li><a href="Maps.php">Incident Map</a></li>
					<li><a href="Contacts.php">Emergency Contacts</a></li>
				</ol>
			</div>
			
			<div id="content" class="content">
			<?php
			//includes the connection.php which removes redundant coding
			include dirname(__FILE__) . '\connection.php';
			
			$query = "SELECT * FROM `incident`"; 
			?>
			
			<!--Used to display a heading and form textboxes -->
			<div id="stylized" class="myform">
				<h2>Create Report</h2>
				<p>Use this form to create a new disaster entry in the database.</p>
				<!-- when submitted, the data is sent to another page that contains SQL INSERT queries, so
				that the input from this page goes to the database -->
				<form action="disaster_report.php" method="post">
				
				<fieldset>
				
				<!--fieldset containing inputs that will be added to the incident table-->
				<legend>Disaster</legend>
				
				<!-- input field that records data on submission to the database -->
				<label>Disaster Name
				<span class="small"> </span>
				</label>
				<input type="text" name ="inputIncident" value = "" placeholder = "SampleTree Fire" />
				
				<label>Disaster Description
				<span class="small"> </span>
				</label>
				<input type="text" name ="inputDescription" value = "" placeholder = "Large Forest fire near"  />
				
				<label>Time of Incident
				<span class="small"> </span>
				</label>
				<input type="time" name ="inputTime" value = ""	placeholder = "hh:mm:ss"/>
				
				<label>Date of Incident
				<span class="small"> </span>
				</label>
				<input type="date" name ="inputDate" value = ""	placeholder = "yyyy/mm/dd"/>
				
				<label>Danger of Incident
				<span class="small"> </span>
				</label>
				<input type="number" name ="inputdangerLevel" placeholder = "1-10" value = "" />
				
				<!-- creates a select menu/drop down box containing all the disaster types in the database -->
				<label>Select Disaster Type
				<span class="small"> </span>
				</label>
					<?php 
					//opens a connection to the database from this include file
					include dirname(__FILE__) . '\connection.php';
					
					//query string that returns all incident types that aren't the 'placeholder' value
					$query = "SELECT * FROM `itype` WHERE iTypeID > 0";
					
					//submitting the query string to the database
					$result = mysql_query($query);

					//this pulls disaster types from the database and creates a select box with the data
					echo '<select id="type" name="type" required="required"> '.
					'<option value="">Select</option>';
					while($type = mysql_fetch_array($result)) {
						echo "<option value=" .$type['iTypeID']. ">" .$type['type']. "</option>";
					}
					echo '</select>';
					?>
				</fieldset>
				<br/>
				<!--fieldset containing inputs that will be added to the location table-->
				<fieldset>
				<!-- title for the fieldset -->
				<legend>Location</legend>
				
				<label>Street Name
				<span class="small"> </span>
				</label>
				<input type="text" name ="inputStreet" value = "" placeholder = "Avalon Place" />
				
				<label>Street Number
				<span class="small"> </span>
				</label>
				<input type="number" name ="inputNumber" value = "" placeholder = "9" />
				
				<label>Suburb Name
				<span class="small"> </span>
				</label>
				<input type="text" name ="inputSuburb" value = "" placeholder = "Upper Kedron" />
				
				<label>Postcode
				<span class="small"> </span>
				</label>
				<input type="text" name ="inputPostCode" value = "" placeholder = "4055" />
				
				<label>Latitude
				<span class="small"> </span>
				</label>
				<input type="text" name ="inputLattitude" value = "" placeholder = "136.10" />
				
				<label>Longitude
				<span class="small"> </span>
				</label>
				<input type="text" name ="inputLongitude" value = "" placeholder = "182.86" />
				
				<!-- drop down box containing states -->
				<label>State
				<span class="small"> </span>
				</label>
				<select id="state" name="state">
					<option value="0">QLD</option>
					<option value="1">NSW</option>
					<option value="2">NT</option>
					<option value="3">ACT</option>
					<option value="4">SA</option>
					<option value="5">WA</option>
					<option value="6">TAS</option>
				</select>
				</fieldset>
				<br />
				
				<!--fieldset containing inputs that will be added to the cost table-->
				<fieldset>
				<legend>Cost</legend>
				
				<label>Produce Damage
				<span class="small"> </span>
				</label>
				<input type="text" name ="inputProd" value = "" placeholder = "486,000" />
				
				<label>Infrastructure Damage
				<span class="small"> </span>
				</label>
				<input type="number" name ="inputInfra" value = "" placeholder = "100,000" />
				
				<label>Domestic Damage
				<span class="small"> </span>
				</label>
				<input type="text" name ="inputDomestic" value = "" placeholder = "1,000,000" />
				
				<label>Lives Lost
				<span class="small"> </span>
				</label>
				<input type="text" name ="inputLives" value = "" placeholder = "0" />
				</fieldset>
				<!-- creates a button that posts the data (or submits) when clicked -->
				<input type="submit" name="submit" />
			</form>
			</div>
		</div>
	</div>
	<?php include "Footer.inc" ?>
	</body>
	
</html>