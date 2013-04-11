<?php 
include '../php/tabform.php'
?>
<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

	<title>SkyEagle - Tabelle</title>
	<!--link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" /-->
    
	<link rel="stylesheet" type="text/css" href="../css/jquery.mobile-1.3.0.min.css">
	<link rel="stylesheet" type="text/css" href="../css/leaflet.css">
	
	<script src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="../js/leaflet.js"></script>
	
	<style>article,#map{width:100%;height:300px;margin:0;padding:0;}.info{padding:6px 8px;font:14px/16px Arial,Helvetica,sans-serif;background:white;background:rgba(255,255,255,0.8);box-shadow:0 0 15px rgba(0,0,0,0.2);border-radius:5px;}.info h4{margin:0 0 5px;color:#777;}#map:-webkit-full-screen{width:100%!important;height:100%!important;}#map:-moz-full-screen{width:100%!important;height:100%!important;}#map:full-screen{width:100%!important;height:100%!important;}.leaflet-control-zoom-fullscreen{background-image:url(http://conmenu.com/resource/js/leaflet_plugins/fullscreen/icon-fullscreen.png);}.leaflet-control-zoom-fullscreen.last{margin-top:5px}</style>

	<script type="text/javascript" src="../js/jquery.mobile-1.3.0.min.js"></script>

</head>
<body>
	<div data-role="page" id="tabelle">

  	<div data-role="header" data-position="fixed">
  		<a href="homemobile.php" data-rel="back">Zurück</a>

		<!--a href="index.html" data-icon="delete">Cancel</a-->
		<h1>SkyEagle - Tabelle</h1>
		<a href="hilfe.php">Hilfe</a>
		<!--a href="index.html" data-icon="check">Save</a-->
		<div data-role="navbar">
		<ul>
			<li><a href="homemobile.php">Home</a></li>
			<li><a href="map.php" rel="external">Karte</a></li>
			<li><a href="dia.php">Diagramm</a></li>
			<li><a href="#">Tabelle</a></li>
		</ul>
		</div><!-- /navbar -->
	</div>
	<form action = "tabelle2.php" method ="post" name="form">
		<fieldset>
			<legend>Selecting Test</legend>
			<p>
				<label>Messstation</label>
				<?php
					createOptionList();
				?>
			</p>
		</fieldset>
		<fieldset>
			<legend>von - bis</legend>			
			<input  
	       name="startdate" 
	       type="date" 
	       data-role="datebox" 
	       id="datepicker" 
	       min="2013-03-22"
	       />
	        <input   
	       name="enddate" 
	       type="date" 
	       data-role="datebox" 
	       id="datepicker2" 
	       />
				<!--input type = "text" 
					id="datepicker"
					name = "startdate"
					value = "2013-03-22"
					/>
					
				<input type = "text"
					id="datepicker2"
					name = "enddate"
					value = "2013-03-27"
					/-->
							
			</fieldset>
			</fieldset>
			<label><b>Werte</b></label>
			<fieldset data-role="controlgroup" data-type="horizontal">
	    			
				<input type="radio" name="Ausreisser" id="radio-choice-22" value="Unbereinigt"  />
	         	<label for="radio-choice-22">unbereinigte</label>
	
	         	<input type="radio" name="Ausreisser" id="radio-choice-23" value="Bereinigt"  />
	         	<label for="radio-choice-23">bereinigte</label>
			</fieldset>
		
		<fieldset>
			<input type="submit" value="Anzeigen" />
		</fieldset>
	</form>
	
	</div>		
</body>