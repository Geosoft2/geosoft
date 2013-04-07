<?php include 'getobsval.php'; ?>

<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

	<title>SkyEagle - Diagramm</title>
	<!--link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" /-->
    
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.css" />
	<link rel="stylesheet" type="text/css" href="lib/css/jquery.mobile-1.3.0.min.css">
	<link rel="stylesheet" type="text/css" href="lib/css/leaflet.css">
	<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
	<script src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="lib/js/jquery-1.9.1.min.js"></script>
	<script src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="lib/js/leaflet.js"></script>
	
	<style>article,#map{width:100%;height:300px;margin:0;padding:0;}.info{padding:6px 8px;font:14px/16px Arial,Helvetica,sans-serif;background:white;background:rgba(255,255,255,0.8);box-shadow:0 0 15px rgba(0,0,0,0.2);border-radius:5px;}.info h4{margin:0 0 5px;color:#777;}#map:-webkit-full-screen{width:100%!important;height:100%!important;}#map:-moz-full-screen{width:100%!important;height:100%!important;}#map:full-screen{width:100%!important;height:100%!important;}.leaflet-control-zoom-fullscreen{background-image:url(http://conmenu.com/resource/js/leaflet_plugins/fullscreen/icon-fullscreen.png);}.leaflet-control-zoom-fullscreen.last{margin-top:5px}</style>

	<script>
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});
     
    //get the data
	var jsonData = <?php getValues()  ?>;
	var jsonData2 = <?php getValues("TEMPERATURE")  ?>;
	var jsonData3 = <?php getValues("AIR_HUMIDITY") ?>;
	var foi = "<?php if (isset($_POST['foi'])){ echo $_POST['foi']; } ?>";

//function to draw the chart
    function drawChart() {

	if (!(foi == "Geist" || foi == "Weseler")){		
    	
    	// Create our data table out of JSON data loaded from server.
          var data = new google.visualization.DataTable(jsonData);
          var data2 = new google.visualization.DataTable(jsonData2);
          var data3 = new google.visualization.DataTable(jsonData3);

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
          var chart2 = new google.visualization.LineChart(document.getElementById('chart2_div'));
          var chart3 = new google.visualization.LineChart(document.getElementById('chart3_div'));

          
          chart.draw(data, {width: 320, height: 400,  vAxis:{title: "Werte in ppm", viewWindow:{min: 0}}, hAxis:{title: "Datum", slantedText:false}});
          chart2.draw(data2, {width: 320, height: 400, vAxis:{title: "Temperatur in �C"}, hAxis:{slantedText:false}});
          chart3.draw(data3, {width: 320, height: 400, vAxis:{title:"rel. Luftfeuchtigkeit in %", viewWindow:{min: 0}},hAxis:{slantedText:false}});
	}
	else {
    	// Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(jsonData);

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        
        chart.draw(data, {width: 700, height: 400, vAxis:{title: "Werte in �g/m�", viewWindow:{min: 0}}, hAxis:{title: "Datum", slantedText:false}});
	}
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

<script>
// enable or disable the checkboxes
function changeForm(name){
	var checkboxCO = document.getElementById("chkCO"),
		checkboxO3 = document.getElementById("chkO3"),
		checkboxSO2 = document.getElementById("chkSO2"),
		checkboxPM10 = document.getElementById("chkPM10");
		checkboxNO = document.getElementById("chkNO");
// If Lanuv-station Geist is set, disable CO-Checkbox and enable O3, SO2, PM10 and NO
	if (name == "Geist"){
		checkboxCO.setAttribute('disabled', true);
		checkboxO3.removeAttribute('disabled');
		checkboxSO2.removeAttribute('disabled');
		checkboxPM10.removeAttribute('disabled');
		checkboxNO.removeAttribute('disabled');
	}
// If Lanuv-Station Weseler is set, disable CO, O3 and SO2-Checkbox and enable PM10 and NO
	else { if (name == "Weseler") {
		checkboxCO.setAttribute('disabled', true);
		checkboxO3.setAttribute('disabled', true);
		checkboxSO2.setAttribute('disabled', true);
		checkboxPM10.removeAttribute('disabled');
		checkboxNO.removeAttribute('disabled');
	}
// else AQE is set
	else {
		checkboxCO.removeAttribute('disabled');
		checkboxO3.removeAttribute('disabled');
		checkboxSO2.setAttribute('disabled', true);
		checkboxPM10.setAttribute('disabled', true);
		checkboxNO.setAttribute('disabled', true);
		
	}
	}
}

</script>
	
<script type="text/javascript" src="lib/js/jquery.mobile-1.3.0.min.js"></script>

</head>

  <body>

	<div data-role="page" id="dia">
	  	<div data-role="header" data-position="fixed">
	  		<a href="index.html" data-rel="back">Zurück</a>
			<!--a href="index.html" data-icon="delete">Cancel</a-->
			<h1>SkyEagle - Diagramm</h1>
			<!--a href="index.html" data-icon="check">Save</a-->
			<div data-role="navbar">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="map.php" rel="external">Karte</a></li>
				<li><a href="dia.php">Diagramm</a></li>
				<li><a href="tabelle.php">Tabelle</a></li>
			</ul>
			</div><!-- /navbar -->
		</div>
		  
		
		
		<a href="#dia2"></a>
	    <div id="chart_div"></div>
	    <div id="chart2_div"></div>
	    <div id="chart3_div"></div>
   </div>
	
  </body>

</html>