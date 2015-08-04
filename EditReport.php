<?phprequire 'VerifyAdmin.inc';?>
<?xml version="1.0" encoding="utf-8"?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" >
<title>Edit Incident Report</title>
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
			
			<!-- creates the sidebar -->
			<div id="sidebar1" class="sidebar">
				<h2>Most Popular Pages</h2>
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
				//some basic SQL error reporting
				error_reporting(E_ALL);
				ini_set('display_errors', '1');
				$search_output = "";
				// connect to the Database
				include dirname(__FILE__) . '\connection.php';

				// Process the search query
				if(isset($_POST['searchquery']) && $_POST['searchquery'] != ""){
				// run code if condition meets here	
					$searchquery = preg_replace('#[^a-z 0-9?]#i', '', $_POST['searchquery']);
					//if the disaster is of type 0 then run this code
					if($_POST['filter1'] == "0"){
						$sqlCommand = "SELECT * FROM `incident` WHERE `iTypeID` = 0 AND `disasterName` LIKE '%$searchquery%'";
					}else if($_POST['filter1'] == "1"){
						$sqlCommand = "SELECT * FROM `incident` WHERE `iTypeID` = 1 AND `disasterName` LIKE '%$searchquery%'";
					}else if($_POST['filter1'] == "2"){
						$sqlCommand = "SELECT * FROM `incident` WHERE `iTypeID` = 2 AND `disasterName` LIKE '%$searchquery%'";
					}else if($_POST['filter1'] == "3"){
						$sqlCommand = "SELECT * FROM `incident` WHERE `iTypeID` = 3 AND `disasterName` LIKE '%$searchquery%'";
					}else if($_POST['filter1'] == "4"){
						$sqlCommand = "SELECT * FROM `incident` WHERE `iTypeID` = 4 AND `disasterName` LIKE '%$searchquery%'";
					}else if($_POST['filter1'] == "5"){
						$sqlCommand = "SELECT * FROM `incident` WHERE `iTypeID` = 5 AND `disasterName` LIKE '%$searchquery%'";
					}else if($_POST['filter1'] == "6"){
						$sqlCommand = "SELECT * FROM `incident` WHERE `iTypeID` = 6 AND `disasterName` LIKE '%$searchquery%'";
					}
					//execute the query
					$query = mysql_query($sqlCommand) or die(mysql_error());
					// return number of rows returned from query
					$count = mysql_num_rows($query);
					
					//if there is at least 1 row retuned run the following code
					if($count >= 1){
						//Returns some basic information about each person returned from the query so they can be idetinfied
						//and then each person has two links added below their info where their information can be modified or
						//deleted
						while($row = mysql_fetch_array($query)){
							$incidentID = $row["incidentID"];
							$disasterName = $row["disasterName"];
							$disasterDesc = $row["description"];
							//links to admin controls page that allows editing of information
							$search_output .= "<br/><b>Incident ID:</b>$incidentID <br/>
							<b>Disaster Name:</b>$disasterName<br/>
							<b>Disaster Description:</b>$disasterDesc<br/> 
							<a href=\"modify_incident.php?id=" . $row['incidentID'] . "&id2=". $row['locationID'] .
							"&id3=" . $row['costID'] . "\">Modify Incident</a> 
							<a href=\"delete_incident.php?id=" . $row['incidentID'] . "&id2=". $row['locationID'] .
							"&id3=" . $row['costID'] . "\">Delete Incident</a><br/><br/>";
						} // close while
					} else {
						$search_output .= "No rows returned";					
					}
				}
				?>
				
				<!--Used to display a heading and form textboxes -->
				<div id="stylized" class="myform">
					<h2>Modify/Delete Report</h2>
					<p>Use this form to edit or delete existing disaster reports.</p>	
					<!-- post data to page when submitted -->
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					
					<fieldset>
					<legend>Incident Search Form</legend>		
					
					<!-- text input box -->
					<label>Disaster Name
					<span class="small">Name of the report</span>
					</label>
					<input name="searchquery" type="text">
					
					<!-- select menu made up of database rows -->
					<label>Disaster Type
					<span class="small">Type of disaster</span>
					</label>
					<?php 
					//opens a connection to the database from this include file
					include dirname(__FILE__) . '\connection.php';
					
					//query string that returns all incident types that aren't the 'placeholder' value
					$query = "SELECT * FROM `itype` WHERE iTypeID > 0";
					
					//submitting the query string to the database
					$result = mysql_query($query);

					//this pulls disaster types from the database and creates a select box with the data
					echo '<select id="filter1" name="filter1" required="required"> '.
					'<option value="">Select</option>';
					while($type = mysql_fetch_array($result)) {
						echo "<option value=" .$type['iTypeID']. ">" .$type['type']. "</option>";
					}
					echo '</select>';
					?>
					</fieldset>
					<!-- submit button -->
					<input name="myBtn" type="submit">
				</div>
				<br />
				<br />
				<div>
				<!-- return the info generated from the SQL query and the conditional statments above -->
				<?php echo $search_output; ?>
				</div>
				</form>		
			</div>
		</div>
	</div>
	<?php include "Footer.inc" ?>
	</body>	
</html>