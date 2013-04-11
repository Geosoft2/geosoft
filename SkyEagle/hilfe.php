<?php include '../php/getobsval.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Hilfe</title>
		<meta name="description" content="" />
		<meta name="author" content="Niclas" />

		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="../css/jquery.mobile-1.3.0.min.css">
		<link rel="stylesheet" type="text/css" href="../css/leaflet.css">
	
		<script src="https://www.google.com/jsapi"></script>
		<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="../js/leaflet.js"></script>
		
		<style>article,#map{width:100%;height:300px;margin:0;padding:0;}.info{padding:6px 8px;font:14px/16px Arial,Helvetica,sans-serif;background:white;background:rgba(255,255,255,0.8);box-shadow:0 0 15px rgba(0,0,0,0.2);border-radius:5px;}.info h4{margin:0 0 5px;color:#777;}#map:-webkit-full-screen{width:100%!important;height:100%!important;}#map:-moz-full-screen{width:100%!important;height:100%!important;}#map:full-screen{width:100%!important;height:100%!important;}.leaflet-control-zoom-fullscreen{background-image:url(http://conmenu.com/resource/js/leaflet_plugins/fullscreen/icon-fullscreen.png);}.leaflet-control-zoom-fullscreen.last{margin-top:5px}</style>

		
		<script type="text/javascript" src="../js/jquery.mobile-1.3.0.min.js"></script>
		
	</head>

	<body>
		<div data-role="page" id="home">
			<div data-role="header" data-position="fixed">
				<a href="homemobile.php" data-rel="back">Zurück</a>
				<h1>Sky Eagle - Hilfe</h1>
				<a href="hilfe.php">Hilfe</a>
				<div data-role="navbar">
					<ul>
						<li><a href="homemobile.php">Home</a></li>
						<li><a href="map.php" rel="external">Karte</a></li>
						<li><a href="dia.php">Diagramm</a></li>
						<li><a href="tabelle.php">Tabelle</a></li>
					</ul>
				</div>
			</div>
			<div date-role"content">
			<div data-role="collapsible">
  			<h3>Wie werden die Daten validiert?</h3>
  			<p>Die Datenvalidierung erfolgt mithilfe einer zweiseitigen "moving window" Validierung. Die validierten Daten kann man sowohl im Diagramm, als auch in der Tabellenansicht betrachten, wenn man auf "Bereinigte Daten" klickt.</p>
			</div>
			
			<div data-role="collapsible">
  			<h3>Was ist ein Air Quality Egg?</h3>
  			<p>Ein Air Quality Egg (kurz: AQE) ist ein über Kick-Starter finanziertes Projekt. Gestartet wurde es von der Gruppierung Sensmakers. Das Air Quality Egg soll eine günstige und möglichst weltweit verteiltes Luftqualitätssensornetzwerk werden. Mithilfe dieses Netzwerks soll dann für jedermann eine erste gute Anlaufstelle zu dem Thema Luftqualität realisiert werden. Die gesammelten Daten dieses Sensornetzwerkes werden auf cosm.com hoch geladen und können von dort weiter verarbeitet werden.</p>
			</div>
			<div data-role="collapsible">
  			<h3>Kann ich auch mitmachen?</h3>
  			<p>Mitmachen kann jeder der Interesse daran hat sein eigenes Air Quality Egg aufzustellen. Dabei geht es ganz einfach: AQE kaufen, aufstellen und bei cosm.com mit #muensteregg taggen und dein AQE erscheint automatisch nach ungefähr einer Stunde nach dem hochladen auf Skyeagle.</p>
			</div>
			
			<div data-role="collapsible">
  			<h3>Was ist eine Lanuv-Station?</h3>
  			<p>Lanuv ist das "Landesamt für Natur, Umwelt und Verbraucherschutz NRW". Die Lanuv-Stationen, die auf unserer Seite dargestellt werden, sind Luftqualitätsmessstationen. Weitere Informationen gibt es auf der Lanuv Website.</p>
			</div>
			
			<div data-role="collapsible">
  			<h3>Was ist cosm?</h3>
  			<p>Cosm ist eine Plattform um gesammelte Daten online zur Verfügung und zur Weiterverarbeitung bereit zu stellen.</p>
			</div>
			
			<div data-role="collapsible">
  			<h3>Warum haben manche Air Quality Eggs keine Werte?</h3>
  			<p>Die Air Quality Eggs sind noch ein junges Projekt und besitzen noch einige "Kinderkrankheiten". Es wird ständig daran gearbeitet Fehler zu beheben. Ebenso können AQEs ohne Werte nicht mehr am Netz sein und so keine Werte mehr liefern.</p>
			</div>
			
			<div data-role="collapsible">
  			<h3>Warum wird die Karte nicht angezeigt?</h3>
  			<p>Damit die Karte angezeigt wird muss Javascript im Browser aktiviert sein. Dies ist in den Browsereinstellungen möglich.</p>
			</div>
			
			<div data-role="collapsible">
  			<h3>Wo bekomme ich weitere Informationen über die gemessenen Werte?</h3>
  			<p>Wenn auf der Karte eine Messstation ausgewählt wird, so öffnet sich ein kleines Popup. Klickt man innerhalb dessen auf einen Messparameter, so öffnet sich automatisch ein weiteres Fenster zu einem Wikipediaartikel des jeweiligen Messwertes.</p>
			</div>
			
			<div data-role="collapsible">
  			<h3>Warum werden in den Popups teilweise keine Werte angezeigt?</h3>
  			<p>Das kann dadurch passieren, dass noch keine aktuellen Werte vorliegen. Sobald es passende Werte gibt, werden sie sofort auf der Karte in Skyeagle angezeigt.</p>
			</div>
			
			<div data-role="collapsible">
  			<h3>Wie kommen Ausreißer zu Stande?</h3>
  			<p>Ausreißer können viele Gründe haben, wie beispielsweise Messfehler oder unnatürliche Einflüsse. Eine erste Ausreißererkennung haben wir mit Skyeagle realisiert.</p>
			</div>
			
			<div data-role="collapsible">
  			<h3>Wieso werden in meinem Zeitintervall keine Werte in der Tabelle angezeigt?</h3>
  			<p>Falls keine Werte angezeigt werden, liegt es daran, dass für diesen Zeitpunkt keine Werte in der Datenbank vorliegen.</p>
			</div>
			
			</div>
			<div date-role"footer">
				
			</div>
			
		</div>
		
	</body>
</html>
