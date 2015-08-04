<?php 
	//prevents a notice of creating a new session when one already exists
	if(!isset($_SESSION)) { 
        session_start(); 
    } 
	
	//removes the login box an displays a welcome message if they're logged in
	if ((isset($_SESSION['isVolunteer'])) || (isset($_SESSION['isEmergency'])) ||(isset($_SESSION['isAdmin']))) {
		include 'DMSHeaderLoggedIn.inc';
	} else {
		include 'DMSHeader.inc';
		}
?>