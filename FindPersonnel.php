<?php require 'VerifyAdmin.inc' ?>
<?xml version="1.0" encoding="utf-8"?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Find Personnel</title>

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
			<!-- sidebar with relevant links -->
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
				<!-- div that defines the form's CSS class -->
				<div id="stylized" class="myform">
					<!-- input is from this page posted to itself -->
					<form action="FindPersonnel.php" method="POST">	
					<h2>Find Personnel</h2>
					<p>Here you can search for personnel.</p>
					
					<?php 
					//allows text boxes to be created by methods
					require 'GenerateFields.inc';
					//fucntions that require a name for the input, a label, and a sub-label for each input
					input_text('personnelid', 'Personnel ID', "The Person's ID");
					input_text('serviceid', 'Service ID', "Person's Service ID");
					input_text('firstname', 'First Name', "Person's First Name");
					input_text('lastname', 'Last Name', "Person's Last Name");
					
					//connects to the database
					include dirname(__FILE__) . '\connection.php';

					// query that returns all incident types that aren't the 'placeholder' value
					$query = "SELECT serviceID, serviceName FROM service";
					$result = mysql_query($query);
					?>
					<!-- select box made up of services from the database, with the appropriate IDs as values-->
					<label>Select Service
					<span class="small">Select the service the person belongs to</span>
					</label>
					<select id="service" name="service">
						<option value=""> Select One </option>
						<?php
						while($type = mysql_fetch_array($result)) {
							echo "<option value=" .$type['serviceID']. ">" .$type['serviceName']. "</option>";
						}
						?>
					</select>
					<!-- submit button that posts data to this page when clicked -->
					<button type="submit" name="search">Search</button>
					</form>
				</div>
				<?php
				// conditional statement that executes when search has been clicked
				if (isset($_POST['search'])) {
					
					//creates database object
					$pdo = new PDO('mysql:host=localhost;dbname=inb201_draft', 'INB201', 'disaster');
					//allows the database object to handle exceptions and/or general errors
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					//regex variables that will be used to compare input strings and database contents
					$firstname = preg_replace('#[^a-z 0-9?]#i', '', $_POST['firstname']);
					$lastname = preg_replace('#[^a-z 0-9?]#i', '', $_POST['lastname']);
					
					//these queries are not 'secure' as they should only be accessible by an admin or service personnel
					try {
						//the following conditional statements allow the user to use only 1 text box input to search 
						if(!(is_numeric($_POST['personnelid'])) && !(is_numeric($_POST['serviceid']))){
							//returns all rows that are similar to the firstname or lastname inputs - if left blank they return all rows
							$find = $pdo->query("SELECT * FROM `personnel`, `service` WHERE `personnel`.`personnelID` > 0 ".
												"AND personnel.serviceID = service.serviceID ".
												"AND `firstName` LIKE '%$firstname%'".
												"AND `lastName` LIKE '%$lastname%'");
												
						} else if ((is_numeric($_POST['personnelid']))) {
							//returns the row that corresponds to the given personnel ID - should only ever return 1 row
							$find = $pdo->query("SELECT * FROM `personnel`, `service` WHERE `personnel`.`personnelID` = '$_POST[personnelid]' ".
												"AND `personnel`.`serviceID` = `service`.`serviceID` ");
							
						} else if (!(is_numeric($_POST['serviceid']))) { 
							//returns all rows that contain the given service ID
							$find = $pdo->query("SELECT * FROM `personnel`, `service` WHERE `personnel`.`personnelID` > 0 ".
												"AND `personnel`.`serviceID` = `service`.`serviceID` ".
												"AND `service`.`serviceID` = '$_POST[serviceid]' ".
												"AND `firstName` LIKE '%$firstname%'".
												"AND `lastName` LIKE '%$lastname%'");
						}					
					} catch (PDOException $e) {
							//if there is an error it outputs the SQL error message
							echo 'Invalid input', $e->getMessage();
					}

					//create a styled table
					echo '<table class="altrowstable" id="alternatecolor"><tr><th>Personnel ID</th><th>First Name</th><th>Last Name</th>';
					echo '<th>Service</th><th>Login ID</th>';
					
					//foreach loop goes through index in the array returned from the database query and creates a table with those values
					foreach ($find as $data) {
							echo '<tr><td>', $data['personnelID'], '</td>';
							echo '<td>', $data['firstName'], '</td>';
							echo '<td>', $data['lastName'], '</td>';
							echo '<td>', $data['serviceName'], '</td>';
							echo '<td>', $data['loginID'], '</td></tr>';														
					}
					echo '</table>';
				}
				?>
			</div>
		</div>
	</div>
</body>
	
	
</html>