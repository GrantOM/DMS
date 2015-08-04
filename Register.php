<?xml version="1.0" encoding="utf-8"?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Register</title>
	<head>
		<!-- selected which header to display -->
		<?php require 'DMSSelectHeader.php'?>
	</head>
	
	<body>
	
	<div id="wrapper">
		<!-- start page -->
		<div id="page">
			<!-- menu bar -->
			<?php require 'DMSMenu.inc' ?>
			<!-- relates links sidebar -->
			<div id="sidebar1" class="sidebar">
				<h2> Related Links </h2>
				<ol>
					<li><a href="index.php">Home</a></li>
					<li><a href="IncidentTracker.php">Incident Tracker</a></li>
					<li><a href="Maps.php">Incident Locator</a></li>
				</ol>
			</div>
			<!-- start content -->
			<div id="content" class="content">
				<div id="stylized" class="myform">
					<h2> Sign-up </h2>
					<p>Here is the sign up page</p>
					<!-- post input to this form on submission -->
					<form method="POST" action="Register.php">
				
					<?php 
					//external file that allows input field creation with functions
					require 'GenerateFields.inc';
					
					//array that will store error messages
					$errors = array();
					
					//input fields created by calling functions
					input_text_checked($errors, 'registerusername', 'Username', 'Must be 4 - 20 Characters');
					input_password_checked($errors, 'registerpassword', 'Password', 'Min. 6 characters, no spaces or symbols');
					input_password_checked($errors, 'confirmpassword', 'Confirm Password', 'Re-type your password');
					input_text_checked($errors, 'registerfirstname', 'First Name', 'Your first name');
					input_text_checked($errors, 'registerlastname', 'Last Name', 'Your last name');
					input_text_checked($errors, 'registerhomephone', 'Phone No.', 'Daytime contact number');
					input_text_checked($errors, 'registermobilephone', 'Mobile', 'Mobile contact number');
					input_text_checked($errors, 'registeremail', 'Email', 'Email address');
					
					//submit button
					echo '<button type="submit" name="create">Sign-Up</button>';
					echo '</form></div>';
				
				if (isset($_POST['create'])) {
						//external file with functions that use regex to check for invalid input
						require 'ValidateInput.inc';
						//these are calls to these functions to check validity
						validateUsername($errors, $_POST, 'registerusername');
						validatePassword($errors, $_POST, 'registerpassword');
						confirmPassword($errors, $_POST, 'registerpassword', 'confirmpassword');
						
						//creates a list of error messages if there are any
						echo '<ul style="list-style:none">';
						if ($errors) {
							echo '<b> Submission unsuccessful, check below for errors. </b><br/>';
							//displays each error in the errors array
							foreach($errors as $error) {
							echo '<li>', $error, '</li>';
							}
							
							} else {
								//external file with a fucntion that checks that the username that was input doesn't already exist
								require 'ExistingUserCheck.inc';
								
								//checkExistingUsers returns true if 1 or more rows are returned when an SQL query searching
								//for any instances of its argument within the login table in the database	
								if (checkExistingUsers($_POST['registerusername'])) {
									echo 'Username already exists, please enter a different username';
								} else {
									//create database object
									$pdo = new PDO('mysql:host=localhost;dbname=inb201_draft', 'INB201', 'disaster');
									//allow database object to handle errors/exceptions
									$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									//try catch enables handing of SQL exceptions, so in the event of an exception, we have feedback
									//that can tell us what is causing there error and possibly where
									try
									{
										//prepared statement to be executed with the database object
										//the statement will insert values into the login table
										$stmt = $pdo->prepare('INSERT INTO login '.
																'VALUES (:id, :username, SHA2(:password, 0), :group); '			
										);
										//bind the prepared statement placeholder variables to actual variables
										$stmt->bindValue(':id', 0);
										$stmt->bindValue(':username', $_POST['registerusername']);
										$stmt->bindValue(':password', $_POST['registerpassword']);
										$stmt->bindValue(':group', 0);
										//execute prepared statement
										$stmt->execute();
										
										//gets the row that was just now inserted into the table and assign the ID column of that row to $userid
										$getid = $pdo->query("SELECT * FROM login WHERE loginUser = '" .$_POST['registerusername']. "'")->fetch();
										$userid = $getid['loginID'];
										
										//prepared statement to be executed with the database object
										//the statement will insert values into the personnel table
										$stmt3 = $pdo->prepare(	'INSERT INTO personnel '.
																'VALUES (:personnelid, :firstname, :middlename, :lastname, :homephone, :mobilephone, '.
																':email, :userid, :group) '
										);
										//bind the prepared statement placeholder variables to actual variables
										$stmt3->bindValue(':personnelid', 0);
										$stmt3->bindValue(':firstname', $_POST['registerfirstname']);
										$stmt3->bindValue(':lastname', $_POST['registerlastname']);
										$stmt3->bindValue(':middlename', $_POST['registerlastname']);
										$stmt3->bindValue(':homephone', $_POST['registerhomephone']);
										$stmt3->bindValue(':mobilephone', $_POST['registermobilephone']);
										$stmt3->bindValue(':email', $_POST['registeremail']);
										$stmt3->bindValue(':userid', $userid);
										$stmt3->bindValue(':group', 0);
										//execute prepared statement
										$stmt3->execute();
										
									//display message if an error or exception is caught
									} catch (PDOException $e) {
										echo 'Invalid input', $e->getMessage();
									} 
									//if no error, display success message
									echo "User added successfully";
								}
							}
						}	
					//}
				?>
				
				</form>
			</div>
		</div>
	</div>
	<?php include "Footer.inc" ?>
	</body>
	
</html>