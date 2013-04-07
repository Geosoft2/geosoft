<?php include 'getobsval.php'; ?>
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
		<link rel="stylesheet" type="text/css" href="lib/css/jquery.mobile-1.3.0.min.css">
		<link rel="stylesheet" type="text/css" href="lib/css/leaflet.css">
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		<script src="https://www.google.com/jsapi"></script>
		<script type="text/javascript" src="lib/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="lib/js/leaflet.js"></script>
		
		<style>article,#map{width:100%;height:300px;margin:0;padding:0;}.info{padding:6px 8px;font:14px/16px Arial,Helvetica,sans-serif;background:white;background:rgba(255,255,255,0.8);box-shadow:0 0 15px rgba(0,0,0,0.2);border-radius:5px;}.info h4{margin:0 0 5px;color:#777;}#map:-webkit-full-screen{width:100%!important;height:100%!important;}#map:-moz-full-screen{width:100%!important;height:100%!important;}#map:full-screen{width:100%!important;height:100%!important;}.leaflet-control-zoom-fullscreen{background-image:url(http://conmenu.com/resource/js/leaflet_plugins/fullscreen/icon-fullscreen.png);}.leaflet-control-zoom-fullscreen.last{margin-top:5px}</style>

		
		<script type="text/javascript" src="lib/js/jquery.mobile-1.3.0.min.js"></script>
		
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
  			<h3>Dies</h3>
  			<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
			</div>
			<div data-role="collapsible">
  			<h3>und jenes</h3>
  			<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
			</div>
			<div data-role="collapsible">
  			<h3>...</h3>
  			<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
			</div>
			<div data-role="collapsible">
  			<h3>...</h3>
  			<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
			</div>
			</div>
			<div date-role"footer">
				
			</div>
			
		</div>
		
	</body>
</html>
