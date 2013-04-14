<?php 
include '../php/tabform.php'
?>
<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

	<title>SkyEagle - Tabelle</title>
    
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
	
	<script src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="../js/jquery.mobile-1.3.0.min.js"></script>

</head>
<body>
	<div data-role="page" id="tabelle">
	<!-- create header with navbar-->
  	<div data-role="header" data-position="fixed">
  		<a href="homemobile.php" data-rel="back">Zurück</a>

		<h1>SkyEagle - Tabelle</h1>
		<a href="hilfe.php">Hilfe</a>
		<div data-role="navbar">
		<ul>
			<li><a href="homemobile.php">Home</a></li>
			<li><a href="map.php" rel="external">Karte</a></li>
			<li><a href="dia.php" rel="external">Diagramm</a></li>
			<li><a href="#">Tabelle</a></li>
		</ul>
		</div><!-- /navbar -->
	</div>
	<form action = "tabelle2.php" method ="post" name="form">
		<fieldset>
		
		<!--load option list-->	
			<p>
				<label><b>Bitte w&auml;hlen Sie eine Messstation:</b></label>
				<?php
					createOptionList();
				?>
			</p>
		</fieldset>
		
		<!--create date field-->
		<fieldset>
			<legend><b>Bitte w&auml;hlen Sie ein Zeitintervall:</b></legend>				
			<input  
	       name="startdate" 
	       type="date" 
	       data-role="datebox" 
	       id="datepicker" 
	       min="2013-03-22"
	       value="<?php echo date('Y-m-d', time() - 86400); ?>" 
	       />
	        <input   
	       name="enddate" 
	       type="date" 
	       data-role="datebox" 
	       id="datepicker2" 
	       value="<?php echo date('Y-m-d'); ?>" 
	       />
	       
			</fieldset>
			
			<!--create radio buttons to choice outlier yes/no-->
			<label><b>Bitte w&auml;hlen Sie aus, ob das Diagramm Ausrei&szlig;er beinhalten soll oder nicht:</b></label>
			<fieldset data-role="controlgroup" data-type="horizontal">
	    			
				<input type="radio" name="Ausreisser" id="radio-choice-22" value="Unbereinigt"  />
	         	<label for="radio-choice-22">unbereinigt</label>
	
	         	<input type="radio" name="Ausreisser" id="radio-choice-23" value="Bereinigt"  />
	         	<label for="radio-choice-23">bereinigt</label>
			</fieldset>
		
		<fieldset>
			<input type="submit" value="Anzeigen" />
		</fieldset>
	</form>
	
	</div>		
</body>