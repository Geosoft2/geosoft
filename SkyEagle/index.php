<?php include 'getobsval.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>index</title>
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
		<script>
		    // Load the Visualization API and the piechart package.
		    google.load('visualization', '1', {'packages':['corechart']});
		     
		
			var jsonData = <?php getValues()  ?>;
			var jsonData2 = <?php getValues("TEMPERATURE")  ?>;
			var jsonData3 = <?php getValues("AIR_HUMIDITY") ?>;
		
		//function to draw the chart
		    function drawChart() {
		
		    	// Create our data table out of JSON data loaded from server.
		          var data = new google.visualization.DataTable(jsonData);
		          var data2 = new google.visualization.DataTable(jsonData2);
		          var data3 = new google.visualization.DataTable(jsonData3);
		
		          // Instantiate and draw our chart, passing in some options.
		          var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
		          var chart2 = new google.visualization.LineChart(document.getElementById('chart2_div'));
		          var chart3 = new google.visualization.LineChart(document.getElementById('chart3_div'));
		          
		          chart.draw(data, {width: 400, height: 240});
		          chart2.draw(data2, {width: 400, height: 240});
		          chart3.draw(data3, {width: 400, height: 240});
		        }
			
		
		
			// json-object are empty, do nothing	
			if (jsonData == "" || jsonData2 == "" || jsonData3 == ""){
			}
			// else draw the charts
			else {
		    // Set a callback to run when the Google Visualization API is loaded.
		    google.setOnLoadCallback(drawChart);
		   	}
		</script>
		<style>article,#map{width:100%;height:300px;margin:0;padding:0;}.info{padding:6px 8px;font:14px/16px Arial,Helvetica,sans-serif;background:white;background:rgba(255,255,255,0.8);box-shadow:0 0 15px rgba(0,0,0,0.2);border-radius:5px;}.info h4{margin:0 0 5px;color:#777;}#map:-webkit-full-screen{width:100%!important;height:100%!important;}#map:-moz-full-screen{width:100%!important;height:100%!important;}#map:full-screen{width:100%!important;height:100%!important;}.leaflet-control-zoom-fullscreen{background-image:url(http://conmenu.com/resource/js/leaflet_plugins/fullscreen/icon-fullscreen.png);}.leaflet-control-zoom-fullscreen.last{margin-top:5px}</style>

		
		<script type="text/javascript" src="lib/js/jquery.mobile-1.3.0.min.js"></script>
		
	</head>

	<body>
		<div data-role="page" id="home">
			<div data-role="header" data-position="fixed">
				<a href="index.html" data-rel="back">Zurück</a>
				<h1>Sky Eagle - Home</h1>
				<div data-role="navbar">
					<ul>
						<li><a href="#home">Home</a></li>
						<li><a href="map.php" rel="external">Karte</a></li>
						<li><a href="dia.php">Diagramm</a></li>
						<li><a href="tabelle.php">Tabelle</a></li>
					</ul>
				</div>
			</div>
			<div date-role"content">
			
			</div>
			<div date-role"footer">
				
			</div>
			
		</div>
		
	</body>
</html>
