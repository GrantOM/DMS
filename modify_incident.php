<?php
	//check if user is admin/has an active admin session
	require 'VerifyAdmin.inc';
	//connect to database
	include dirname(__FILE__) . '\connection.php';
	
	//these statements are used to put the current report's values
	//into the input fields to enable easier editing
	if(!isset($_POST['submit'])){
		$q = "SELECT * FROM incident WHERE incidentID = $_GET[id]";
		$results = mysql_query($q);
		$incident = mysql_fetch_array($results);
		
		$q2 = "SELECT * FROM location WHERE locationID = $_GET[id2]";
		$results2 = mysql_query($q2);
		$incident2 = mysql_fetch_array($results2);
		
		$q3 = "SELECT * FROM cost WHERE costID = $_GET[id3]";
		$results3 = mysql_query($q3);
		$incident3 = mysql_fetch_array($results3);
	}
?>
</html>
<head>
	<title>Modify Disaster</title>
	<!-- selected which header to display -->
	<?php require 'DMSSelectHeader.php'?>
<body>
	<div id="wrapper">
	<!-- start page -->
		<div id="page">
		
		<!--includes all the menu buttons-->
		<?php include 'DMSMenu.inc'; ?>

			<!-- sidebar containing related links -->
			<div id="sidebar1" class="sidebar">
				<h2> Related Links </h2>
				<ol>
					<li><a href="NewReport.php">New Report</a></li>	
					<li><a href="EditReports.php">Edit/Delete Report</a></li>	
					<li><a href="DisasterReports.php">Incident Search</a></li>
					<li><a href="HistoricalReports.php">Archived Reports</a></li>
					<li><a href="GraphsStatistics.php">Statistics</a></li>
				</ol>
			</div>
			
			
			<div id="content" class="content">
				<!--Used to display a heading and form textboxes -->
				<div id="stylized" class="myform">
					<h2>Modify Incident</h2>
					<p>Here you can modify the selected incident report.</p>
					<!-- input is posted to this form when submitted -->
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
					
					<fieldset>
					<!-- incident info inputs -->
					<legend>Incident</legend>
					
					<!-- text box input -->
					<label>Disaster Name
					<span class="small"> </span>
					</label>
					<!-- for each input, the data already in the database is displayed in the input box for ease of use -->
					<input type="text" name ="inputIncident" value = "<?php echo @$incident['disasterName']; ?>" placeholder = "SampleTree Fire" />
					
					<label>Disaster Description
					<span class="small"> </span>
					</label>
					<input type="text" name ="inputDescription" value = "<?php echo @$incident['description']; ?>" placeholder = "Large Forest fire near"  />
					
					<!-- time input -->
					<label>Time of Disaster
					<span class="small"> </span>
					</label><input type="time" name ="inputTime" value = "<?php echo @$incident['time']; ?>"	placeholder = "hh:mm:ss"/>
					
					<!-- date input -->
					<label>Date of Disaster
					<span class="small"> </span>
					</label>
					<input type="date" name ="inputDate" value = "<?php echo @$incident['date']; ?>"	placeholder = "yyyy/mm/dd"/>
					
					<!-- number input -->
					<label>Danger of Disaster
					<span class="small"> </span>
					</label>
					<input type="number" name ="inputdangerLevel" placeholder = "1-10" value = "<?php echo @$incident['dangerLevel']; ?>" />
					
					<!-- creates a select box made up of rows from the database -->
					<label>Disaster
					<span class="small"> </span>
					</label>
					<?php 
					//opens a connection to the database from this include file
					include dirname(__FILE__) . '\connection.php';
					
					// query that returns all incident types that aren't the 'placeholder' value
					$query = "SELECT * FROM `itype` WHERE iTypeID > 0";
					
					//submitting the query string to the database
					$result = mysql_query($query);

					//this pulls disaster types from the database and creates a select box with the data
					//it also automatically selects the same value stored in the database for the type of incident
					echo '<select id="type" name="type" required="required"> '.
					'<option value="">Select</option>';
					while($type = mysql_fetch_array($result)) {
						if ($incident['iTypeID'] == $type['iTypeID']) {
						echo "<option value=" .$type['iTypeID']. " selected=\"selected\">" .$type['type']. "</option>";
						} else {
						echo "<option value=" .$type['iTypeID']. ">" .$type['type']. "</option>";
						}
					}
					echo '</select>';
					?>
					</fieldset>
					
					<fieldset>
					<!-- location inputs -->
					<legend>Location</legend>
					<label>Street Name
					<span class="small"> </span>
					</label>
					<input type="text" name ="inputStreet" value = "<?php echo @$incident2['streetName']; ?>" placeholder = "Johnson Street" />
					
					<label>Street Number
					<span class="small"> </span>
					</label>
					<input type="number" name ="inputNumber" value = "<?php echo @$incident2['streetNumber']; ?>" placeholder = "382" />
					
					<label>Suburb
					<span class="small"> </span>
					</label>
					<input type="text" name ="inputSuburb" value = "<?php echo @$incident2['suburb']; ?>" placeholder = "Dawngate" />
					
					<label>Postcode
					<span class="small"> </span>
					</label>
					<input type="text" name ="inputPostCode" value = "<?php echo @$incident2['postCode']; ?>" placeholder = "3862" />
					
					<label>Latitude
					<span class="small"> </span>
					</label>
					<input type="text" name ="inputLattitude" value = "<?php echo @$incident2['mapLat']; ?>" placeholder = "136.10" />
					
					<label>Longitude
					<span class="small"> </span>
					</label>
					<input type="text" name ="inputLongitude" value = "<?php echo @$incident2['mapLon']; ?>" placeholder = "182.86" />
					
					<label>State
					<span class="small"> </span>
					</label>
						<select id="state" name="state" value = "<?php echo @$incident2['state']; ?>">
						<option value="QLD">QLD</option>
						<option value="NSW">NSW</option>
						<option value="NT">NT</option>
						<option value="ACT">ACT</option>
						<option value="SA">SA</option>
						<option value="WA">WA</option>
						<option value="TAS">TAS</option>
						</select>
					
					</fieldset>

					<fieldset>
					<!-- cost inputs -->
					<legend>Cost</legend>
					
					<label>Produce Damage
					<span class="small"> </span>
					</label>
					<input type="text" name ="inputProd" value = "<?php echo @$incident3['prodDamage']; ?>" placeholder = "486,000" />
					
					<label>Infrastructure Damage
					<span class="small"> </span>
					</label>
					<input type="text" name ="inputInfra" value = "<?php echo @$incident3['infDamage']; ?>" placeholder = "100,000" />
					
					<label>Domestic Damage
					<span class="small"> </span>
					</label>
					<input type="text" name ="inputDomestic" value = "<?php echo @$incident3['domDamage']; ?>" placeholder = "1,000,000" />
					
					<label>Lives Lost
					<span class="small"> </span>
					</label>
					<input type="text" name ="inputLives" value = "<?php echo @$incident3['livesLost']; ?>" placeholder = "0" />
					
					</fieldset>
					
					<!-- hidden values that store the $GET values from the URL after form is posted -->
					<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
					<input type="hidden" name="id2" value="<?php echo $_GET['id2'];?>"/>
					<input type ="hidden" name ="id3" value = "<?php echo $_GET['id3'];?>"/>

					<!-- submit button -->
					<button type="submit" name="submit">Modify</button>
					</form>
				</div>
				
				<?php
				// if form is submitted, execture queries to edit the database
				if(isset($_POST['submit'])){
					// query string that updates the incident table
					$u = "UPDATE incident SET `disasterName`='$_POST[inputIncident]', 
					`description`='$_POST[inputDescription]', 
					`time`='$_POST[inputTime]', 
					`date`='$_POST[inputDate]', 
					`dangerLevel`='$_POST[inputdangerLevel]',
					`iTypeID`='$_POST[type]' 
					WHERE incidentID = $_POST[id]";
					
					// query string that updates the location table
					$u2 = "UPDATE location SET `streetName`='$_POST[inputStreet]',
					`streetNumber`='$_POST[inputNumber]',
					`suburb`='$_POST[inputSuburb]',
					`postcode`='$_POST[inputPostCode]',
					`mapLat`='$_POST[inputLattitude]',
					`mapLon`='$_POST[inputLongitude]',
					`state`='$_POST[state]'
					WHERE locationID = $_POST[id2]";
					
					// query string that updates the cost table
					$u3 = "UPDATE cost SET `prodDamage`='$_POST[inputProd]',
					`domDamage`='$_POST[inputDomestic]',
					`infDamage`='$_POST[inputInfra]',
					`livesLost`='$_POST[inputLives]'
					WHERE costID = $_POST[id3]";
					
					// executes the query
					mysql_query($u) or die (mysql_error());	
					mysql_query($u2) or die (mysql_error());
					mysql_query($u3) or die (mysql_error());
					
					// display message and redirect to the Edit Report page
					echo '<i>Report has been modified! Now returning to the Edit/Delete Report page...</i>';
					echo '<meta http-equiv="refresh" content="4; url= http://', $_SERVER['HTTP_HOST'], '/EditReport.php">';
				}
				?>
			</div>
		</div>
	</div>
</body>
</head>
</html>
