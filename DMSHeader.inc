<?php
if (isset($_POST['login'])) {
		
		//verifies that the account exists by calling 3 functions for each user group
		require 'DMSVerifyPassword.inc';
		
		//checks login details
		if(checkAdminPassword($_POST['username'], $_POST['password'])) {
			session_start();
			$_SESSION['isAdmin'] = true;
			$_SESSION['USERNAME'] = $_POST['username'];
			header("Location: http://{$_SERVER['HTTP_HOST']}");
			exit();
		
		} elseif(checkEmergencyServicePassword($_POST['username'], $_POST['password'])) {
			session_start();
			$_SESSION['isEmergency'] = true;
			$_SESSION['USERNAME'] = $_POST['username'];
			header("Location: http://{$_SERVER['HTTP_HOST']}/Index.php");
			exit();
			
		} elseif(checkVolunteerPassword($_POST['username'], $_POST['password'])) {
			session_start();
			$_SESSION['isVolunteer'] = true;
			$_SESSION['USERNAME'] = $_POST['username'];
			header("Location: http://{$_SERVER['HTTP_HOST']}/Index.php");
			exit();
			
		} else {
			echo '<div class="loginfail">';
			echo 'Login Failed, check your details and try again.';
			echo '</div>';
		}
		
	}
?>

<!-- alternate colours on table rows -->
<script type="text/javascript">
	function altRows(id){
		if(document.getElementsByTagName){  
			
			var table = document.getElementById(id);  
			var rows = table.getElementsByTagName("tr"); 
			 
			for(i = 0; i < rows.length; i++){          
				if(i % 2 == 0){
					rows[i].className = "evenrowcolor";
				}else{
					rows[i].className = "oddrowcolor";
				}      
			}
		}
	}
	window.onload=function(){
		altRows('alternatecolor');
	}
</script>

<link href="DMSStyle.css" rel="stylesheet" type="text/css"/>
<link href="default.css" rel="stylesheet" type="text/css"/>

<div  id="header">
	<!-- header logo -->
	<a href="index.php"> <img src="images/DMSlogo.png" width="300" height="120" style="float:left"/> </a>

	<!-- login box -->
	<div id="login">	
		<form id="loginform" name="loginform" method="post" action="#">
			<label for="username">Username:</label>
			<input  id="username" type="text" name="username" required="required" value="<?php
				if(isset($_POST['username']))
					echo htmlspecialchars($_POST['username'])?>"/><br/>
					
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" required="required" value="<?php
				if(isset($_POST['password']))
					echo htmlspecialchars($_POST['password'])?>"/><br/>
			
			<!-- link to volunteer registration page -->
			<a href="Register.php">Register</a>
			
			<input type="submit" name="login" value="Login"/>
		</form>	
	</div>
</div>
