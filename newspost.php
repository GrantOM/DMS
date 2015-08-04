<?php require 'VerifyAdmin.inc';?>
<?xml version="1.0" encoding="utf-8"?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" >
<title>Create News Post</title>

<head>
	<!-- selected which header to display -->
	<?php require 'DMSSelectHeader.php'?>
</head>
	
<body>
	<div id="wrapper">
	<!-- start page -->
		<div id="page">
			<!-- menu bar -->
			<?php include 'DMSMenu.inc'; ?>
			<!-- sidebar with related links -->
			<div id="sidebar1" class="sidebar">
				<h2>Related Links</h2>
				<ol>
					<li><a href="IncidentTracker.php">Incident Tracker</a></li>
					<li><a href="Maps.php">Incident Map</a></li>
					<li><a href="Contact.php">Emergency Contacts</a></li>
				</ol>
			</div>
		<!-- start content -->
		<div class="content" id="content">
			<!-- the news post input form, made as an inc as
			it was originally located on the index -->
			<?php include 'indexpostnews.inc';?>
		</div>
	</div>
	<!-- spaces the sidebar/content from the bottom of the page-->
	<?php include "Footer.inc" ?>
</body>
	
</html>