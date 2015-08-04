<?php
	//this section of PHP runs a few queries so that the input boxes in the form
	//can be pre-populated with data from the database, to make modification a little
	//simpler
	require 'VerifyAdmin.inc';
	
	include dirname(__FILE__) . '\connection.php';
	
	if(!isset($_POST['modify'])){
		$q = "SELECT * FROM personnel WHERE personnelID = $_GET[id] ";
		$results = mysql_query($q);
		$personnel = mysql_fetch_array($results);
		
		$q2 = "SELECT * FROM login WHERE loginID = $_GET[id] ";
		$results2 = mysql_query($q2);
		$personnel2 = mysql_fetch_array($results2);
	}
?>

<?xml version="1.0" encoding="utf-8"?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Modify Personnel</title>
	<!-- selected which header to display -->
	<?php require 'DMSSelectHeader.php'?>
</head>

<body>
	<div id="wrapper">
	<!-- start page -->
		<div id="page">
		
		<!--includes all the menu buttons-->
		<?php include 'DMSMenu.inc'; ?>
			<!-- sidebar with page-relevant links -->
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
					<!-- inputs are posted to this page upon submission -->
					<form action="ModifyPersonnel.php" method="POST">
					<h2>Modify Personnel</h2>
					<p>Here you can modify personnel details. <br/><br/><i style="color:red">Note: if you attempt to change 
					the password and the confirm password does not match, the other changes you made will be sent to the 
					database but the password will remain unchanged.</i></p>
					
					<!-- input that will send data to the database when submitted -->
					<label>Account Username
					<span class="small"> </span>
					</label>
					<input type="text" name="username" value="<?php echo @$personnel2['loginUser']; ?>">
					
					<!-- the password input, if left blank this column in the db table remains unchanged -->
					<label>Password
					<span class="small">Leave blank for no change</span>
					</label>
					<input type="password" name="password">					
					
					<!-- confirms the password input by having the user repeat the password they just entered
					to ensure that they entered what they intended -->
					<label>Confirm Password
					<span class="small"> Confirm new password  </span>
					</label>
					<input type="password" name="conpassword" value="">
					
					<label>Firstname
					<span class="small"></span>
					</label>
					<input type="text" name="firstname" value="<?php echo @$personnel['firstName']; ?>">
					
					<label>Lastname
					<span class="small"></span>
					</label>
					<input type="text" name="lastname" value="<?php echo @$personnel['lastName']; ?>">
					
					<label>Home Phone
					<span class="small"></span>
					</label>
					<input type="text" name="phone" value="<?php echo @$personnel['homePhone']; ?>">
					
					<label>Mobile Phone
					<span class="small"> </span>
					</label>
					<input type="text" name="mobile" value="<?php echo @$personnel['mobilePhone']; ?>">
					
					<label>Email Address
					<span class="small"> </span>
					</label>
					<input type="text" name="email" value="<?php echo @$personnel['emailAddress']; ?>">
					
					<?php 
					// connects to the database
					include dirname(__FILE__) . '\connection.php';

					// query that returns all incident types that aren't the 'placeholder' value
					$query = "SELECT serviceID, serviceName FROM service";
					$result = mysql_query($query);
					?>
					
					<!-- creates a select menu composed of values from the service table in the database.
					the service ID option for the selected person is automatically chosen, instead of the
					first option (which is default)-->
					<label>Select Service
					<span class="small">Select the service the person belongs to</span>
					</label>
					<select id="serviceid" name="serviceid" required="required">
						<option value=""> Select One </option>
						<?php
						while($type = mysql_fetch_array($result)) {
							if (@$personnel['serviceID'] == $type['serviceID']) {
							echo "<option value=" .$type['serviceID']. " selected='selected'>" .$type['serviceName']. "</option>";
							} else {
							echo "<option value=" .$type['serviceID']. ">" .$type['serviceName']. "</option>";
							}
						}
						?>
					</select>
					<!-- submit button that posts input to this page when clicked -->
					<button type="submit" name="modify">Modify</button>
					<!-- hidden input that stores the GET value from the URL after posting -->
					<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>				
					</form>
					
					<?php
					//when modify is clicked the SQL queries are executed
					if(isset($_POST['modify'])){
					//query string that updates personnel with form inputs when executed
					$u = "UPDATE personnel SET `firstName`='$_POST[firstname]', 
					`lastName`='$_POST[lastname]', 
					`homePhone`='$_POST[phone]', 
					`mobilePhone`='$_POST[mobile]', 
					`emailAddress`='$_POST[email]',
					`serviceID`='$_POST[serviceid]' 
					WHERE personnelID = $_POST[id]";
					
					//query string that updates login with form inputs when executed
					//if the password textbox contains an alphanumeric string and matches
					//the confirm password input, the password in the database is updated
					//if not, the password is unchanged
					if(ctype_alnum ($_POST['password']) && ($_POST['password'] == $_POST['conpassword'])) {
						$u2 = "UPDATE login SET `loginUser`='$_POST[username]',
						`loginPass` = SHA2('$_POST[password]', 0),
						`loginGroup`='$_POST[serviceid]'
						WHERE loginID = $_POST[id]";
					} else {
						$u2 = "UPDATE login SET `loginUser`='$_POST[username]',
						`loginGroup`='$_POST[serviceid]'
						WHERE loginID = $_POST[id]";
					}
					
					//execute the queries
					mysql_query($u) or die (mysql_error());	
					mysql_query($u2) or die (mysql_error());
					
					//display appropriate message and redirect to the manage personnel page
					echo '<br/><i>User has been modified! Now returning to the Manage Personnel page...</i>';
					echo '<meta http-equiv="refresh" content="4; url= http://', $_SERVER['HTTP_HOST'], '/ManagePersonnel.php">';
					
					}
					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
