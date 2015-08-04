<?php require 'VerifyUser.inc' ?>
<?xml version="1.0" encoding="utf-8"?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title> Statisticts </title>
		<!-- selected which header to display -->
		<?php require 'DMSSelectHeader.php'?>	
	</head>
	
	<body>
	<div id="wrapper">
		<div id="page">
		
			<?php require 'DMSMenu.inc' ?>
			
			<div id="sidebar1" class="sidebar">
				<h2> Report Disaster </h2>		
					<ol>
						<li><a href="NewReport.php">New Report</a></li>	
						<li><a href="EditReports.php">Edit/Delete Report</a></li>	
						<li><a href="DisasterReports.php">Incident Search</a></li>
						<li><a href="HistoricalReports.php">Archived Reports</a></li>
						<li><a href="GraphsStatistics.php">Statistics</a></li>
					</ol>
			</div>
			
			<div id="content" class="content">
			
				<div id="stylized" class="myform">
					<h2> Statistics Page </h2>
					<p>Here you can view the disaster and incident staticistics for the selected period.</p>
				<form method="GET">
				<label>Date<span class="small">Enter the first date</span></label>
				<input type="date" name="date" id="date" placeholder="YYYY-MM-DD"/>					
				
				<label>Date<span class="small">Enter the second date</span></label>
				<input type="date" name="date2" id="date2" placeholder="YYYY-MM-DD"/>											

				<button type="submit" name="find">Find</button>
				</form>
				<div class="spacer"></div>
				</div>

				<?php 
					if (isset($_GET['find'])) {
						// Initiate the database connection		
						$pdo = new PDO('mysql:host=localhost;dbname=inb201_draft', 'INB201', 'disaster');
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						
						//Start DB query and try catch error exception handling
						try {									
						$find = $pdo->query("SELECT * FROM incident, cost, itype ".
											"WHERE incident.date >= '" .$_GET['date']. "' AND incident.date <= '" .$_GET['date2']. "' AND incident.costID = cost.costID AND itype.iTypeID = incident.iTypeID ORDER BY Type, date"); 
						} catch (PDOException $e){
							echo $e->getMessage();
						} 
						// Create Table 						
						echo '<h2> Search Results: </h2>';
							
						echo '<table class="altrowstable" id="alternatecolor"><tr><th>Date</th><th>Incident Name</th><th>Incident Description</th>';
						echo '<th>Incident Type</th><th>Produce Cost ($)</th><th>Domestic Cost ($)</th><th>Infrastructure Cost ($)</th>';
						echo '<th>Lives Lost</th>';
						
						// set variables to 0
						$prodtotal = 0;
						$domtotal = 0;
						$inftotal = 0;
						$livetotal = 0;
						
						foreach($find as $data) {
							
							$pnum = $data['prodDamage'];
							$prodtotal += (integer)$pnum;
							
							$dnum = $data['domDamage'];
							$domtotal += (integer)$dnum;
							
							$inum = $data['infDamage'];
							$inftotal += (integer)$inum;
							
							$lnum = $data['livesLost'];
							$livetotal += (integer)$lnum;
							
						// Enter query output into table created.		
								echo '<tr><td>', $data['date'], '</td>';
								echo '<td>', $data['disasterName'], '</td>';
								echo '<td>', $data['description'], '</td>';
								echo '<td>', $data['type'], '</td>';
								echo '<td>', $data['prodDamage'], '</td>';
								echo '<td>', $data['domDamage'], '</td>';
								echo '<td>', $data['infDamage'], '</td>';
								echo '<td>', $data['livesLost'], '</td>';
								echo '</tr>';
									
						}
						// Create secondary row filling with defined variables
						echo '<tr><td></td>';
						echo '<td></td>';
						echo '<td></td>';
						echo '<td></td>';							
						echo '<td> Total $', $prodtotal, '</td>';
						echo '<td> Total $', $domtotal, '</td>';
						echo '<td> Total $', $inftotal, '</td>';
						echo '<td> Total ', $livetotal, '</td>';
						echo '</tr>';
						echo '</table>';
					}							
				?>					
			</div>
		</div>
	</div>
	<?php include "Footer.inc" ?>
	</body>
</html>