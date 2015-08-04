<?xml version="1.0" encoding="utf-8"?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<title> Safety Tips </title>

	<head>
		<!-- selected which header to display -->
		<?php require 'DMSSelectHeader.php'?>
	</head>
	
	<body>
	<div id="wrapper">
		<!-- start page -->
		<div id="page">
			
			<!-- includes all the menu buttons -->
			<?php include 'DMSMenu.inc'; ?>
			
		  
			<script language="javascript" type="text/javascript">
				// this javascript function allows the submenus in the sidebar to be displayed/hidden
				// when the appropriate submenu item is clicked
				function subMenu(show) {
					if (show){
						// hides the submenu div if its already visible when clicked, if its not
						// visible, it is displayed and others are hidden (if not already)
						if (document.getElementById('sub_menu').style.display == 'block') {
							document.getElementById('sub_menu').style.display = 'none';
						} else {
							document.getElementById('sub_menu_deux').style.display = 'none';
							document.getElementById('sub_menu_trois').style.display = 'none';
							document.getElementById('sub_menu').style.display = 'block';
						}
					} else {
						document.getElementById('sub_menu').style.display = 'none';
					}
				}
				
				function subMenu2(show) {
					if (show){
						if (document.getElementById('sub_menu_deux').style.display == 'block') {
							document.getElementById('sub_menu_deux').style.display = 'none';
						} else {
							document.getElementById('sub_menu').style.display = 'none';
							document.getElementById('sub_menu_trois').style.display = 'none';
							document.getElementById('sub_menu_deux').style.display = 'block';
						}
					} else {
						document.getElementById('sub_menu_deux').style.display = 'none';
					}
				}
				
				function subMenu3(show) {
					if (show){
						if (document.getElementById('sub_menu_trois').style.display == 'block') {
							document.getElementById('sub_menu_trois').style.display = 'none';
						} else {
							document.getElementById('sub_menu').style.display = 'none';
							document.getElementById('sub_menu_deux').style.display = 'none';
							document.getElementById('sub_menu_trois').style.display = 'block';
						}
					} else {
						document.getElementById('sub_menu_trois').style.display = 'none';
					}
				}
				
				// this function allows different divs to be displayed one at a time, by hiding all other divs except the div that corresponds to the
				// link that was clicked. It iterates through all of the div names in the div array, hiding each one until it comes across 'onediv', which 
				// is then displayed. The loop then continues hiding all other divs that are not 'onediv'
				function showHide(d) {
					var onediv = document.getElementById(d);
					var divs=['storm_info','cyclone_info','flood_info','fire_info', 'plan_info', 'supply_info', 'prep_info', 'during_info', 'after_info', 'temp'];
					for (var i = 0;i < divs.length; i++) {
						if (onediv != document.getElementById(divs[i])) {
							document.getElementById(divs[i]).style.display = 'none'; // hide all divs that are not assigned to 'onediv'
						}
					}
					onediv.style.display = 'block'; //display the div assigned to 'onediv'
				}
			</script>
				
			<div id="wrapper">
				<!-- start page -->
				<div id="page">
					<!-- sidebar with related links and hideable divs -->
					<div id="sidebar1" class="sidebar">
						<h2> Safety Info </h2>
						<ul>
							<li>
							<!-- menu link - when clicked it displays all the submenu links if they are not already visible -->
							<a href="#" onclick="javascript:subMenu(true);"><b>Disasters</b></a><br/>
							<!-- div that is hidden until the link above is clicked -->
							<div id="sub_menu" class="submenu" style="display:none">
								<ul class="submenu">
									<!-- when a link is clicked, it displays the information in the content div corresponding
									to that link, and hides all others -->
									<li><a href="#" onclick="javascript:showHide('storm_info');">Storm</a></li>
									<li><a href="#" onclick="javascript:showHide('cyclone_info');">Cyclone</a></li>
									<li><a href="#" onclick="javascript:showHide('flood_info');">Flood</a></li>
									<li><a href="#" onclick="javascript:showHide('fire_info');">Fire</a></li>
								</ul>
							</div>
							</li>
							
							<li>
							<!-- menu link - when clicked it displays all the submenu links if they are not already visible -->
							<a href="#" onclick="javascript:subMenu2(true);"><b>Preparation</b></a><br/>
							<div style="display:none" id="sub_menu_deux">
								<ul class="submenu">
									<!-- when a link is clicked, it displays the information in the content div corresponding
									to that link, and hides all others -->
									<li><a href="#" onclick="javascript:showHide('plan_info');">Step One: Plan</a></li>
									<li><a href="#" onclick="javascript:showHide('supply_info');">Step Two: Supply</a></li>
									<li><a href="#" onclick="javascript:showHide('prep_info');">Step Three: Prep</a></li>
								</ul>
							</div>
							</li>
							
							<li>
							<!-- menu link - when clicked it displays all the submenu links if they are not already visible -->
							<a href="#" onclick="javascript:subMenu3(true);"><b>What To Do</b></a><br/>
							<div style="display:none" id="sub_menu_trois">
								<ul class="submenu">
									<!-- when a link is clicked, it displays the information in the content div corresponding
									to that link, and hides all others -->
									<li><a href="#" onclick="javascript:showHide('during_info');">During an Event</a></li>
									<li><a href="#" onclick="javascript:showHide('after_info');">After an Event</a></li>
								</ul>
							</div>
							</li>
						</ul>
							
							<h2> Related Pages </h2>
							<ol>
							<li><a href="Contact.php">Emergency Contact Numbers</a></li>
							</ol>
					</div>

					</div>
					
					<div id="content" class="content">
					
						<h1 class="title"> Safety Tips </h1>
						<!-- temporary div containing message that tells the user how to use the page -->
						<div id="temp">
							<i>Click a link on the left to get started.</i>
						</div>
						
						<!-- hidden div that contains information about storms that becomes visible when the Storm link 
						above is clicked. The next lot of divs within the content div are similar -->
						<div style="display:none" id="storm_info">
							<h3>Storm:</h3>
							<p>A storm is a difference in air pressure, forming from the meeting of warm and cold air. 
							Some seasons (such as summer) are more prone to storms due to the cooler air and warm air 
							meeting. It is important that you have an emergency preparation completed before storm season 
							begins.</p>
						</div>
						
						<div style="display:none" id="cyclone_info">
							<h3>Cyclone:</h3>
							<p>A tropical cyclone is more prone up in far North Queensland. Cyclones are caused by low-pressure
							systems, which produce damaging winds in excess of 90km/hour. Due to cyclones forming in tropical
							oceans, they are also prone to carry excessive amounts of water, which can lead to flooding in the
							target area.</p>
						</div>
						
						<div style="display:none" id="flood_info">
							<h2>Flood</h2>
							<p>A flood is when water inundates land. Excessive amounts of rain and/or overflowing of creeks and rivers
							can cause flooding. There are many different types of flooding, including flash flooding, which is caused
							quite quickly and generally after heavy rainfall. </p>

						</div>
						
						<div style="display:none" id="fire_info">
							<h2>Fire</h2>
							<p>
							The most common types of fire disasters that occur in Queensland are bushfires. Bushfires are slow moving, 
							and mainly found in areas with a large amount of natural build up, such as forests. Other common types of 
							fire disasters include domestic fires, generally starting from electrical equipment. To prevent electrical 
							fires, ensure electrical equipment found within the home is regularly checked for safety. To ensure an 
							electrical cord is safe, ensure that the wires are not exposed, frayed or torn.	
							</p><br/>
							<center>Below is an indication of the fire danger rating scale:</center>
							<!-- fire danger scale image -->
							<center><img src="images/FScale.png"></center>
							<br/><br/>
							<center>The danger rating scale is an indication of predicted severity of the fire.</center>
							<!-- scale definitions image -->
							<center><img src="images/Definitions.png"></center>
						</div>
						
						<div style="display:none" id="plan_info">
							<p>To ensure maximum safety for you, your family and your community, it is important to make sure that all
							steps are covered. Below is a guide to ensuring maximum safety:</p>

							<h2>Step One: Prepare an emergency plan</h2>
							
							<ol>
								<li>Discuss an emergency meeting point with the family.</li>
								<li>Create an emergency contact list including after hours emergency care services.</li>
								<li>Sign up for the governments emergency alert services at http://www.emergencyalert.gov.au/</li>
							</ol>
						</div>
						
						<div style="display:none" id="supply_info">
							<h2>Step Two: Prepare an emergency and evacuation kit</h2>

							<p>Ensure the emergency kit is stored in a waterproof container.</p>
							
							<ol>
							<li>If there is anyone in your household who requires constant medication (such as asthmatics, diabetics etc).
							Make sure you include these emergency medications, and keep a list of the expiry dates of each medication kept 
							within the kit.</li>
							<li>Maintain a fully stocked first aid kit </li>
							<li>A supply of fresh water </li>
							<li>Torch with spare batteries</li>
							<li>Gloves</li>
							<li>Battery operated radio with spare batteries</li>
							<li>Mobile phone with spare battery</li>
							<li>If you live in a flood prone area, have an emergency supply of sandbags</li>
							<li>If you live in a severe strong wind area (eg cyclones), have strong tape and spare sturdy cardboard to tape
							across windows on the inside and outside</li>
							</ol>

							Evacuation Kit:
							<ol>
							<li>warm clothing</li>
							<li>sleeping bag</li>
							<li>blankets</li>
							<li>essential medication</li>
							<li>mobile and charger/spare battery</li>
							</ol>

						</div>
						
						<div style="display:none" id="prep_info">
							<h2>Step Three: Prepare your home</h2>

							<p>During severe storm season in Queensland, it is important to make sure that your area is properly
							maintained to prevent possible disasters. Below are some tips to effectively maintain your home, and keep it safe:</p>

							Maintaining outside the home:
							<ol>
								<li>Ensure that large plants such as trees are trimmed back well away from power lines and poles. </li>
								<li>Regularly clear the gutter and overhanding branches, to allow water to clear away as quickly as possible.</li>
								<li>Regularly check the roof and gutters for damage including rust or general damage.</li>
							</ol>

							Maintaining inside the home:
							<ol>
								<li>Ensure that all electrical equipment is up to date with safety checks. Replace any appliances that have broken power cords.</li>
								<li>Ensure that your insurance is up to date, and make sure it covers your home, contents and car for all types of disasters 
								(eg flood, storm, fire, severe wind etc).</li>
								<li>Ensure you can easily access the main power and water supply, if in the event it needs to be turned off.</li>
								<li>Find a strong area of the house for shelter. Try to find a room that has minimal windows, and minimal electricity.</li>
								<li>Have spare camping appliances such as stove, spare fuel for your vehicle and water supply incase a disturbance to
								the water supply arises during the disaster.</li>
							</ol>

						</div>
						
						<div style="display:none" id="during_info">
							<h2>During a disaster event</h2>

							<p>Make sure you listen to updates. Below are some websites to keep updated on the latest information:</p>
							<ul>
								<li>Bureau of Meteorology for weather updates: <a href="http://www.bom.gov.au">http://www.bom.gov.au</a></li>
								<li>Your local council for local updates (including evacuation centers): <a href="http://www.qldcouncils.com.au/web/guest">
								http://www.qldcouncils.com.au/web/guest</a></li>
							</ul>
						</div>
						
						<div style="display:none" id="after_info">
							<h2>After a disaster event</h2>

							<p>If your home has been affected, carefully assess the damage, so you can report to your insurance provider an
							accurate indication of the scale of damage.  Important things to remember:</p>
							<ul>
								<li>Do not try to turn on any electrical sockets or appliances. </li>
								<li>Ensure you are wearing appropriate clothing, particularly footwear. </li>
								<li>Take photos of the damage for insurance purposes and keep invoices from tradespeople.</li>
							</ul>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include "Footer.inc" ?>
	</body>
	
</html>