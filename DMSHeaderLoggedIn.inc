<!-- links to the stylesheets -->
<link href="DMSStyle.css" rel="stylesheet" type="text/css"/>
<link href="default.css" rel="stylesheet" type="text/css"/>

<!--event handler for login button-->
<?php
if (isset($_POST['logout'])) 
	{
	include 'DMSLogout.php';
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

<div class="group" id="header" >
	<!-- header logo -->
	<a href="index.php"> <img src="images/DMSlogo.png" width="300" height="120" style="float:left"> </a>
	<!-- displays a welcome message -->
	<div id="login">
		<form id="loggedinheader" name="loggedinheader" method="post" action="">	
			<?php echo 'Welcome, ', $_SESSION['USERNAME'], '.'?>
			<a href="DMSLogout.php"> Logout </a>
		</form>
	</div>
</div>
