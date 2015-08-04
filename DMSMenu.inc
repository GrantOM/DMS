<!--this include contains the menu buttons, add to every page-->
	<link rel="stylesheet" href="menu.css" type="text/css" media="screen" />	
	<!-- list of 'buttons' that can have nested lists, which will become drop-down menus -->
	<div id="navbar">
		<ul id="nav">
		<li><a href="Index.php">Home</a></li>
		<?php 
		if ((isset($_SESSION['isEmergency'])) || (isset($_SESSION['isAdmin']))) { 
			echo '<li><a href="#"> Staff Tools </a>'.
				'<ul>' .
					'<li><a href="#">Disaster Management</a>' .
						'<ul>' .
							'<li><a href="DisasterReports.php">Search Reports</a></li>' .
							'<li><a href="NewReport.php">New Report</a></li>' .
							'<li><a href="EditReport.php">Edit/Delete Report</a></li>' .
							'<li><a href="HistoricalReports.php">Archived Reports</a></li>' .
							'<li><a href="ArchivedReports.php">Archived Reports</a></li>' .
							'<li><a href="GraphsStatistics.php">Statistics</a></li>' .
						'</ul>' .
					'</li>' .
					'<li><a href="#">Personnel Management</a>' .
						'<ul>' .
							'<li><a href="FindPersonnel.php">Find Personnel</a></li>' .
							'<li><a href="DeployedPersonnel.php">Deployed Personnel</a></li>' .
							'<li><a href="AddPersonnel.php">Add Personnel</a></li>' .
							'<li><a href="ManagePersonnel.php">Manage Personnel</a></li>' .
						'</ul>' .
					'</li>' .
					'<li><a href="newspost.php"> Create News Post </a></li>' .
				'</ul>' .
			'</li>';
		}
		?>
		<li><a href="SafetyTips.php">Safety Tips</a></li>
		<li><a href="IncidentTracker.php">Public Incident Tracker</a></li>
		<li><a href="Maps.php">View Map</a></li>
		<li><a href="HistoricalReports.php">Report Archive</a></li>
		<li><a href="Contact.php">Emergency Contacts</a></li>
		</ul>
	</div><br/><br/>