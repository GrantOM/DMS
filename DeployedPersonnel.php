<?xml version="1.0" encoding="utf-8"?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" >

	<head>
		<title>Deployed Personnel</title>
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
				<ol>
					<li><a href="FindPersonnel.php">Find Personnel</a></li>
					<li><a href="AddPersonnel.php">Add Personnel</a></li>
					<li><a href="ManagePersonnel.php">Modify Personnel</a></li>
					<li><a href="DeployedPersonnel.php">Deployed Personnel</a></li>
				</ol>
			</div>

			<div id="content" class="content">
			
				<div id="stylized" class="myform">
					<form action="DeployedPersonnel.php" method="POST">	
					<h2>Deployed Personnel</h2>
					<p>Here you can search for the current deployed personnel, where they are deployed and for how long they've been there.</p>
					
					<?php require 'GenerateFields.inc';
					//function that generates input fieds, only text boxes in this case though
					input_text('personnelid', 'Personnel ID', "The Person's ID");
					input_text('serviceid', 'Service ID', "Person's Service ID");
					input_text('firstname', 'First Name', "Person's First Name");
					input_text('lastname', 'Last Name', "Person's Last Name");
					?>
					
					<button type="submit" name="search">Search</button>					
					</form>
				</div>
				<?php
				if (isset($_POST['search'])) {
					//create new database object
					$pdo = new PDO('mysql:host=localhost;dbname=inb201_draft', 'INB201', 'disaster');
					
					//this allows us to check for SQL errors with try/catch
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					//create regex variables so that we can search the database for the posted values
					$firstname = preg_replace('#[^a-z 0-9?]#i', '', $_POST['firstname']);
					$lastname = preg_replace('#[^a-z 0-9?]#i', '', $_POST['lastname']);
					
					//I did not bother with making these queries 'secure' as they should only be accessible by an admin
					//and its already possible to return everything from the database
					try {
						
						if(!($_POST['personnelid'] >= 1) && !($_POST['serviceid'] >= 1)){						
							$find = $pdo->query("SELECT * FROM `linklocper`, `personnel` WHERE `linklocper`.`personnelID` = `personnel`.`personnelID` ".
												"AND `firstName` LIKE '%$firstname%'".
												"AND `lastName` LIKE '%$lastname%'");
						
						} else if ($_POST['personnelid'] >= 1) {
							$find = $pdo->query("SELECT * FROM `linklocper`, `personnel` WHERE `linklocper`.`personnelID` = '$_POST[personnelid]' ");
							
						} else if ($_POST['serviceid'] >= 1) { 
							$find = $pdo->query("SELECT * FROM `linklocper`, `personnel` WHERE `linklocper`.`personnelID` = `personnel`.`personnelID`  ".
												"AND `serviceID` = '$_POST[serviceid]' ".
												"AND `firstName` LIKE '%$firstname%'".
												"AND `lastName` LIKE '%$lastname%'");
						}					
					} catch (PDOException $e) {
							echo 'Invalid input', $e->getMessage(); //returns an appropriate error message so that we can determine the problem
					}
					
					//creates styled a table with the appropriate headers
					echo '<table class="altrowstable" id="alternatecolor"><tr><th>Personnel ID</th><th>First Name</th><th>Last Name</th>';
					echo '<th>Service ID</th><th>Time/Date Deployed</th><th>Hours Worked</th>';
						
						//for loop that runs through every value in the $find array that pulled data from the database
						foreach ($find as $data) {
							//get our current timezone
							date_default_timezone_set('Australia/Brisbane');
							//creates a DateTime object that containts the current date and time in YYYY-MM-DD
							//and 24-hour format, to align with the SQL date data type
							$datenow = new DateTime(date('Y/m/d H:I', time()));
							//do the same as above but for the data from the database this time
							$datedeployed = new DateTime($data['deployedDate']);
							//calculate the difference between now and deployment
							$diff = $datedeployed->diff($datenow);
							//convert that difference into a readable format, in this case: hours
							$hours = $diff->h;
							$hours = $hours + ($diff->d*24);
						
								//display all data in the table
								echo '<tr><td>', $data['personnelID'], '</td>';
								echo '<td>', $data['firstName'], '</td>';
								echo '<td>', $data['lastName'], '</td>';
								echo '<td>', $data['serviceID'], '</td>';
								echo '<td>', $data['deployedDate'], '</td>';														
								echo '<td>', $hours, '</td></tr>';														
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