<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Index</title>

	<link href="file:default.css" rel="stylesheet" type="text/css" media="screen" />
	<link rel="stylesheet" href="menu.css" type="text/css" media="screen" />
	<!-- selects which header to display if the user is already logged in -->
	<?php include 'DMSSelectHeader.php';?>	
</head>

<body>
<div id="wrapper">
	<!-- start page -->
	<div id="page">
		<!--includes all the menu buttons-->
		<?php include 'DMSMenu.inc'; ?>
			<!--sidebar with links to the most popular pages -->
			<div id="sidebar1" class="sidebar">
				<h2>Most Popular Pages</h2>
				<ol>
					<li><a href="IncidentTracker.php">Incident Tracker</a></li>
					<li><a href="Maps.php">Incident Map</a></li>
					<li><a href="Contact.php">Emergency Contacts</a></li>
				</ol>
				
				<!-- this section of PHP displays a menu in the sidebar that contains links to the map
				 for the last 5 incidents reported-->
				<?php 
				// connect to database
				include dirname(__FILE__) . '\connection.php';
				
				// only selects the last 5 entries from the database
				$query = "SELECT * FROM incident ORDER BY incident.incidentID DESC LIMIT 5";
				
				// execute the query and retutrn rows as an array
				$result = mysql_query($query);
				$type = mysql_fetch_array($result);
				
				// display the disaster names and use the IDs to make a link to the map page that displays the incident
				// using the GET method on Maps.php
				echo '<h2> Recent Reports</h2>';
				echo '<ol>';
				while($type = mysql_fetch_array($result)) {
					echo '<li><a href="Maps.php?disaster=' .$type['incidentID']. '">' .$type['disasterName']. '</a></li>';
				}
				echo '</ol>';
				?>
			</div>
			<!-- start content -->
			<div id="content">
				<div class="post">
					<h1 class="title">Welome to the Disaster Management Website</h1>
					
					<div class="entry">
						<p> This is the unofficial Disaster Management Website for the Brisbane area, here you can find information on current, recent
						and past disasters as well as information on what to do before, during and after a disaster. Emergency contact details can also
						be found on the 'Emergency Contact Numbers' page.</p>
					</div>
				</div>
				<!-- displays the news post text file -->
				<?php include_once "textonly.txt";?>

			</div>
		</div>
	</div>
	<!--provides space between the bottom of the screen and the content/sidebars-->
	<?php include "Footer.inc" ?>
</body>
</html>
