<?php require 'VerifyAdmin.inc' ?>
<?xml version="1.0" encoding="utf-8"?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<title> Manage Personnel </title>
		<!-- selected which header to display -->
		<?php require 'DMSSelectHeader.php'?>
</head>
	
<body>
	<div id="wrapper">
	<!-- start page -->
		<div id="page">
		
		<!--includes all the menu buttons-->
		<?php include 'DMSMenu.inc'; ?>
			<!-- sidebar containing relevant links -->
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
				<form action="ManagePersonnel.php" method="POST">
					<h2> Manage Personnel </h2>
					<p>Here is manage personnel page, you can search for personnel and edit or delete their details and now
					you can search for any currently deployed personnel, where they've been deployed to and how long the've 
					been deployed by clicking the 'Deployment' link the table for the person you wish to deploy/return to base.
					<br/><br/><i>Note: A blank search will return all personnel</i></p>
					
					<?php 
					//external file with functions that when called create input fields
					require 'GenerateFields.inc';
					input_text('serviceid', 'Service ID', "Person's Service ID");
					input_text('firstname', 'First Name', "Person's First Name");
					input_text('lastname', 'Last Name', "Person's Last Name");
					
					//submit button
					echo '<button type="submit" name="search">Search</button>';
					
					//connnect to database
					include dirname(__FILE__) . '\connection.php';
					
					if (isset($_POST['search'])) {
						//regex variables that will be used to compare the input strings to strings in the database
						$firstname = preg_replace('#[^a-z 0-9?]#i', '', $_POST['firstname']);
						$lastname = preg_replace('#[^a-z 0-9?]#i', '', $_POST['lastname']);
						
						if(!(is_numeric($_POST['serviceid']))){
							//selects all personnel if the serviceID input does not have a number in it
							$sqlCommand = "SELECT * FROM `personnel` WHERE `personnelID` > 0 ".
										"AND `firstName` LIKE '%$firstname%'".
										"AND `lastName` LIKE '%$lastname%'";
						} else {
							//if serviceID is set to a number, the search includes only those with the corresponding service ID
							$sqlCommand = "SELECT * FROM `personnel` WHERE `personnelID` > 0 ".
										"AND `firstName` LIKE '%$firstname%' ".
										"AND `lastName` LIKE '%$lastname%' ".
										"AND serviceID = '". $_POST['serviceid'] ."'";
						}
						//execute the query and assign the number of rows returned to a variable
						$query = mysql_query($sqlCommand) or die(mysql_error());
						$count = mysql_num_rows($query);
						
						//if at least one row is returned, display some of the personnel information and
						//display the links to the modify and delete pages for those personnel
						if($count >= 1){
							echo '<h2>Found Personnel</h2>';
							echo '<table class="altrowstable" id="alternatecolor"><tr><th>Personnel ID</th><th>First Name</th><th>Last Name</th> '.
									'<th>Service ID</th><th>Deploy</th><th>Modify</th><th>Delete</th>';
							while($row = mysql_fetch_array($query)){
								echo '<tr><td>', $row['personnelID'], '</td>';
								echo '<td>', $row['firstName'], '</td>';
								echo '<td>', $row['lastName'], '</td>';
								echo '<td>', $row['serviceID'], '</td>';
								echo "<td><a href=\"DeployPersonnel.php?id=" . $row['personnelID'] . "\">Deployment</a></td>";
								echo "<td><a href=\"ModifyPersonnel.php?id=" . $row['personnelID'] . "\">Modify Person</a></td>";
								echo "<td><a href=\"DeletePersonnel.php?id=" . $row['personnelID'] . "\">Delete Person</a></td></tr>";						
							}
							echo "</table>";
						}
					}
					?>

				</form>
			</div>
		</div>
	</div>
	<!--provides space between the bottom of the screen and the content/sidebars-->
	<?php include "Footer.inc" ?>
</body>
	
</html>