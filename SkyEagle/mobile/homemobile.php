<?php include '../php/getobsval.php'; ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />

		
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>index</title>
		<meta name="description" content="" />
		<meta name="author" content="Niclas" />

		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		
		<script src="https://www.google.com/jsapi"></script>
		<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="../js/jquery.mobile-1.3.0.min.js"></script>
		
	</head>

	<body>
		<div data-role="page" id="home">
			
			<!-- create header with navbar-->
			<div data-role="header" data-position="fixed">
				<a href="homemobile.php" data-rel="back">Zurück</a>
				<h1>Sky Eagle - Home</h1>
				<a href="hilfe.php">Hilfe</a>
				<div data-role="navbar">
					<ul>
						<li><a href="#home">Home</a></li>
						<li><a href="map.php" rel="external">Karte</a></li>
						<li><a href="dia.php" rel="external">Diagramm</a></li>
						<li><a href="tabelle.php">Tabelle</a></li>
					</ul>
				</div>
			</div>
			<div date-role"content">
			Wie ist eigentlich die Luftqualität vor meiner Haustür?<br><br>
				Wenn Sie aus Münster stammen und sich diese oder eine ähnliche Frage schon einmal gestellt haben, sind Sie hier richtig:<br><br>
				SkyEagle ist eine Plattform zur Visualisierung von Luftqualitätsinformationen im Raum Münster.<br><br>
				Neben offiziellen Messwerten zweier Stationen des Landesamts für  Natur, Umwelt und Verbraucherschutz NRW (<a href="http://www.lanuv.nrw.de" target="_blank">Lanuv</a>), werden auch Messdaten aus einer noch relativ neuen Quelle angeboten, den sogenannten Air Quality Eggs (<a href="http://airqualityegg.com/" target="_blank">AQEs</a>).<br><br>
				Diese gingen aus einem <a href="http://www.kickstarter.com/projects/edborden/air-quality-egg" target="_blank">Kickstarter</a> Projekt hervor und bieten Privatnutzern die Möglichkeit, selbst die Schadstoffwerte vor der heimischen Haustür zu messen  und zu einer offenen Sensorplattform im Internet hoch zu laden (<a href="http://cosm.com/" target="_blank">cosm</a>).<br><br>
				Aktuelle Messwerte können über Karte, Tabellen- und Diagrammansicht abgerufen werden.<br><br>
				Über die Popups der Karte lassen sich die aktuellsten Messwerte der jeweiligen Station abrufen. <br><br>
				Über die Weiterleitung zur jeweiligen Ansicht, erhalten Sie eine Veranschaulichung der Messwerte der letzten 2 Tage.<br><br>
				Zusätzlich bietet SkyEagle einen Sensor Observation Service (SOS) an. Über diesen lassen sich gemessene Daten als XML-Dateien abfragen.	
			<hr>
				<b>Impressum</b><br>
			    Bei Fragen, Anregungen und Kritik stehen wir Ihnen gerne zur Verfügung. Sie erreichen uns per Post, E-Mail oder per Telefon.<br>
				Max Mustermann AG<br>
				Kurze Straße 12<br>
				48151 Münster<br>
				Telefon: +49 251 / 1234567<br>
				E-Mail: info@maxmustermannag.de
			</div>
			<div data-role="footer">
		<h1><a href="../php/Home.php" rel="external" >Desktop-Ansicht</a></h1>
		</div>
				
		</div>
		
	</body>
</html>
