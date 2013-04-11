<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>

	<title>SkyEagle - Karte</title>
	
    <!--script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script-->
	<!--script src="js/ger_dpicker.js"></script-->
	<link rel="stylesheet" type="text/css" href="../css/jquery.mobile-1.3.0.min.css">
	<link rel="stylesheet" type="text/css" href="../css/leaflet.css">
	
	<script src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="../js/leaflet.js"></script>
	
	<style>article,#map{width:100%;height:300px;margin:0;padding:0;}.info{padding:6px 8px;font:14px/16px Arial,Helvetica,sans-serif;background:white;background:rgba(255,255,255,0.8);box-shadow:0 0 15px rgba(0,0,0,0.2);border-radius:5px;}.info h4{margin:0 0 5px;color:#777;}#map:-webkit-full-screen{width:100%!important;height:100%!important;}#map:-moz-full-screen{width:100%!important;height:100%!important;}#map:full-screen{width:100%!important;height:100%!important;}.leaflet-control-zoom-fullscreen{background-image:url(http://conmenu.com/resource/js/leaflet_plugins/fullscreen/icon-fullscreen.png);}.leaflet-control-zoom-fullscreen.last{margin-top:5px}</style>
		
	<script type="text/javascript" src="../js/jquery.mobile-1.3.0.min.js"></script>
</head>
<body>
 
 
 
<div data-role="header" data-position="fixed">
		<a href="homemobile.php" data-rel="back">Zurück</a>

		<!--a href="index.html" data-icon="delete">Cancel</a-->
		<h1>SkyEagle - Karte</h1>
		<a href="hilfe.php">Hilfe</a>
		
		<!--a href="index.html" data-icon="check">Save</a-->
		<div data-role="navbar">
		<ul>
			<li><a href="homemobile.php">Home</a></li>
			<li><a href="#" rel="external">Karte</a></li>
			<li><a href="dia.php">Diagramm</a></li>
			<li><a href="tabelle.php">Tabelle</a></li>		</ul>
		</div><!-- /navbar -->
</div>
	
 

 
<div data-role="content" style="padding: 15px">
<article data-role="content" style="margin: 0; padding: 0">
<div id="map"></div>
</article>
<div data-role="popup" id="popupBasic" data-overlay-theme="a" data-theme="d" data-tolerance="10,10" data-transition="none" class="ui-content">
</div>
</div>
<?php
			ini_set( "display_errors", 0);
			include_once '../php/dbconnector.php';
			/* Every variable of the getter functions to get the actual data */
			$eggname = getName();				
			$eggfoi = getFoiIdMap();
			$eggcoords = getEggCoords();
			$eggtemp = getLatestOffering('TEMPERATURE');
			$egghum = getLatestOffering('AIR_HUMIDITY');
			$eggco = getLatestOffering('CO_CONCENTRATION');
			$eggno2 = getLatestOffering('NO2_CONCENTRATION');
			$eggo3 = getLatestOffering('O3_CONCENTRATION');
			$eggtime = getLatestTimeStamp();

			$lanuvname = getLanuvName();
			$lanuvfoi = getLanuvFoiId();
			$lanuvcoords = getLanuvCoords();
			$lanuvno = getLatestLanuvOffering('NO_CONCENTRATION');
			$lanuvno2 = getLatestLanuvOffering('NO2_CONCENTRATION');
			$lanuvpm10 = getLatestLanuvOffering('PM10_CONCENTRATION');
			$lanuvso2 = getLatestLanuvOffering('SO2_CONCENTRATION');
			$lanuvo3 = getLatestLanuvOffering('O3_CONCENTRATION');
			$lanuvtime = getLatestLanuvTimeStamp();
			
			/* Define today and two days ago for the redirection from the popup to the table.
				To totday a day must be added up so the datepicker chooses the correct day. */
				
			$vorgestern = date("Y-m-d", strtotime("-2 day"));
			$heute = date("Y-m-d", strtotime("+1 day"));

		?>
		
		<script language="javascript" type="text/javascript">
		
		var map;

		function load_map() {
			
			map = new L.map('map', {zoomControl: true}).setView([51.947, 7.62],13);
			L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 18,
				attribution: 'Map data &copy; 2012 <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
			}).addTo(map);
			var eggIcon = L.icon({
				iconUrl: '../images/egg_v1.png',
				iconSize: [22,28]
			});
			var lanuvIcon = L.icon({
				iconUrl: '../images/lanuv_antenna.png',
				iconSize: [28,30]
			});
						
			var i = 0;						
			var EierLayer = new Array();	// Used for the layer selection of the eggs
			/* -------Json encoding of the variables at the beginning. eval() so something will be added to the object------- */
			var EierNamen = eval(' (' + <?php print json_encode(json_encode($eggname)); ?> + ')');
			var EierFoi = eval(' (' + <?php print json_encode(json_encode($eggfoi)); ?> + ')');
			var EierCoords = eval( ' (' + <?php print json_encode(json_encode($eggcoords)); ?> + ')');
			var EierTemp = eval( ' (' + <?php print json_encode(json_encode($eggtemp)); ?> + ')');
			var EierLuft = eval( ' (' + <?php print json_encode(json_encode($egghum)); ?> + ')');
			var EierCO = eval( ' (' + <?php print json_encode(json_encode($eggco)); ?> + ')');
			var EierNO2 = eval( ' (' + <?php print json_encode(json_encode($eggno2)); ?> + ')');
			var EierO3 = eval( ' (' + <?php print json_encode(json_encode($eggo3)); ?> + ')');
			var EierTime = eval( ' (' + <?php print json_encode(json_encode($eggtime)); ?> + ')');
			
			while (i <= EierFoi.length - 1) {						// passing through all eggs which are saved in the database
				var EggName = EierNamen[i].feature_of_interest_name;	// get the egg name
				
				var EggFoi = EierFoi[i].feature_of_interest_id;
				
				var EggCoordX = EierCoords[i].st_y;		// egg coordinates. x are y coordinate are swapped in the database
				var EggCoordY = EierCoords[i].st_x;
				
				/* Output of all values. If there is no value a '-' is written */
				
				if (EierTemp[i] === undefined) {var EggTemp = '-'}	 
				else var EggTemp = EierTemp[i].numeric_value;			
		
				if (EierLuft[i] === undefined) {var EggHum = '-'}
				else var EggHum = EierLuft[i].numeric_value;
				
				if (EierCO[i] === undefined) {var EggCO = '-'}
				else var EggCO = EierCO[i].numeric_value;
				
				if (EierNO2[i] === undefined) {var EggNO2 = '-'}
				else var EggNO2 = EierNO2[i].numeric_value;
				
				if (EierO3[i] === undefined) {var EggO3 = '-'}
				else var EggO3 = EierO3[i].numeric_value;
				
				if (EierTime[i] === undefined) {var EggTime = '-'}
				else var EggTime = EierTime[i].time_stamp;
			
				/* Create Popups for each egg. Marker is bound to coordinates and containts links to Wikipedia articles.
					By clicking the link to the table a table is created with measuring values of today, yesterday and two days ago. */
					
				var markerEggs = L.marker([EggCoordX, EggCoordY],{icon: eggIcon}).bindPopup(
					EggName+"</br>Letzte Messung: "+EggTime+"</br><a href=\"http://de.wikipedia.org/wiki/Temperatur\" target=\"_blank\">Temperatur</a>: "
					+EggTemp+" °C</br><a href=\"http://de.wikipedia.org/wiki/Luftfeuchtigkeit\"target=\"_blank\">Luftfeuchtigkeit</a>: "
					+EggHum+" %</br><a href=\"http://de.wikipedia.org/wiki/Kohlenstoffmonoxid\"target=\"_blank\">Kohlenstoffmonoxid</a>: "
					+EggCO+" ppm</br><a href=\"http://de.wikipedia.org/wiki/Stickstoffdioxid\"target=\"_blank\">Stickstoffdioxid</a>: "
					+EggNO2+" ppm</br><a href=\"http://de.wikipedia.org/wiki/Ozon\"target=\"_blank\">Ozon</a>: "
					+EggO3+" ppm</br></br><a href=\"Tabelle.php?starting=<?php echo $vorgestern?>&ending=<?php echo $heute?>&foiid="+EggFoi+"\"_blank\">Tabelle</a> "
					+"<br><a href=\"Diagramme.php\"_blank\">Diagramme</a>")
					;
				EierLayer[i] = markerEggs;		// Layer array for all eggs
				i++;
			}
			
			/* Analogue to the part above for the Air Quality Eggs */
			
			var j = 0;
			var LanuvLayer = new Array();
			var LanuvName = eval(' (' + <?php print json_encode(json_encode($lanuvname)); ?> + ')');
			var LanuvFoi = eval(' (' + <?php print json_encode(json_encode($lanuvfoi)); ?> + ')');
			var LanuvCoords = eval( ' (' + <?php print json_encode(json_encode($lanuvcoords)); ?> + ')');
			var LanuvNO = eval( ' (' + <?php print json_encode(json_encode($lanuvno)); ?> + ')');
			var LanuvNO2 = eval( ' (' + <?php print json_encode(json_encode($lanuvno2)); ?> + ')');
			var LanuvPM10 = eval( ' (' + <?php print json_encode(json_encode($lanuvpm10)); ?> + ')');
			var LanuvSO2 = eval( ' (' + <?php print json_encode(json_encode($lanuvso2)); ?> + ')');
			var LanuvO3 = eval( ' (' + <?php print json_encode(json_encode($lanuvo3)); ?> + ')');
			var LanuvTime = eval( ' (' + <?php print json_encode(json_encode($lanuvtime)); ?> + ')');
			
			while (j <= LanuvFoi.length - 1) {
				var LANUVName = LanuvName[j].feature_of_interest_name;
				
				var LANUVFoi = LanuvFoi[j].feature_of_interest_id;
				
				var LANUVCoordX = LanuvCoords[j].st_x;		
				var LANUVCoordY = LanuvCoords[j].st_y;
				
				if (LanuvNO[j] === undefined) {var LANUVNO = '-'}
				else var LANUVNO = LanuvNO[j].numeric_value;
				
				if (LanuvNO2[j] === undefined) {var LANUVNO2 = '-'}
				else var LANUVNO2 = LanuvNO2[j].numeric_value;
				
				if (LanuvPM10[j] === undefined) {var LANUVPM10 = '-'}
				else var LANUVPM10 = LanuvPM10[j].numeric_value;
				
				if (LanuvSO2[j] === undefined) {var LANUVSO2 = '-'}
				else var LANUVSO2 = LanuvSO2[j].numeric_value;
				
				if (LanuvO3[j] === undefined) {var LANUVO3 = '-'}
				else var LANUVO3 = LanuvO3[j].numeric_value;
				
				if (LanuvTime[j] === undefined) {var LANUVTime = '-'}
				else var LANUVTime = LanuvTime[j].time_stamp;

				/* Distinction between Geist and Weseler is needed, because both measuring stations are not using the same measuring parameters */
				
				if (LANUVFoi == 'Geist') {
					var markerLanuv = L.marker([LANUVCoordX, LANUVCoordY],{icon: lanuvIcon}).bindPopup(
						LANUVName+"</br>Letzte Messung: "+LANUVTime+"</br><a href=\"http://de.wikipedia.org/wiki/Stickstoffmonoxid\" target=\"_blank\">Stickstoffmonoxid</a>: "
						+Math.round((LANUVNO / 1.23) * 100000) / 100000 +" ppm</br><a href=\"http://de.wikipedia.org/wiki/Stickstoffdioxid\" target=\"_blank\">Stickstoffdioxid</a>: "
						+Math.round((LANUVNO2 * 0.000532) * 100000) / 1000000 +" ppm</br><a href=\"http://de.wikipedia.org/wiki/PM10\" target=\"_blank\">Feinstaub</a>: "
						+Math.round(LANUVPM10 * 100000) / 100000 +" &micro;g/m&sup3;</br><a href=\"http://de.wikipedia.org/wiki/Schwefeldioxid\" target=\"_blank\">Schwefeldioxid</a>: "
						+Math.round((LANUVSO2 / 2.86) * 100000) / 100000 +" ppm</br><a href=\"http://de.wikipedia.org/wiki/Ozon\" target=\"_blank\">Ozon</a>: "
						+Math.round((LANUVO3 * 2 / 1000) * 100000) / 100000 +" ppm</br></br><a href=\"Tabelle.php?starting=<?php echo $vorgestern?>&ending=<?php echo $heute?>&foiid="+LANUVFoi+"\"_blank\">Tabelle</a> "
						+"<br><a href=\"Diagramme.php\"_blank\">Diagramme</a>")
					;
				}
				else {
					var markerLanuv = L.marker([LANUVCoordX, LANUVCoordY],{icon: lanuvIcon}).bindPopup(
						LANUVName+"</br>Letzte Messung: "+LANUVTime+"</br><a href=\"http://de.wikipedia.org/wiki/Stickstoffmonoxid\" target=\"_blank\">Stickstoffmonoxid</a>: "
						+Math.round((LANUVNO / 1.23) * 100000) / 100000 +" ppm</br><a href=\"http://de.wikipedia.org/wiki/Stickstoffdioxid\" target=\"_blank\">Stickstoffdioxid</a>: "
						+Math.round((LANUVNO2 * 0.000532) * 100000) / 100000 +" ppm</br><a href=\"http://de.wikipedia.org/wiki/PM10\" target=\"_blank\">Feinstaub</a>: "
						+Math.round((LANUVPM10 * 59.26902) * 100000) / 100000 +" &micro;g/m&sup3;</br></br><a href=\"Tabelle.php?starting=<?php echo $vorgestern?>&ending=<?php echo $heute?>&foiid="+LANUVFoi+"\"_blank\">Tabelle</a> "
						+"<br><a href=\"Diagramme.php\"_blank\">Diagramme</a>")
					;
				}
				LanuvLayer[j] = markerLanuv;
				j++;
			}
			/* Defining both layer groups and add them to the map */
			var AQEs = L.layerGroup(EierLayer);
			var Lanuvs = L.layerGroup(LanuvLayer);
			
			var OverlayMaps = {
					"Air Quality Eggs": AQEs,
					"Lanuv Stationen": Lanuvs
				};
			map.addLayer(AQEs);
			map.addLayer(Lanuvs);
				
			L.control.layers(null,OverlayMaps).addTo(map);
			
		}

		window.onload = load_map;
		
		</script>
</body>
</html>