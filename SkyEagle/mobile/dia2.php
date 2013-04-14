<?php 	//include 'getobsval.php'; 
		include '../php/chartform.php';
		include '../php/chkbox.php';
		include 'getobsvalmobile.php';
		include 'chartdisoptsmobile.php';

/* for $_GET */
		$foi = getVar("foiid");
		$startdate = getVar("starting");
		$enddate = getVar("ending");
		//$observation = getVar("observation");
/* if $foi, startdate, enddate and observation != '', then override $_POST */		
		if ($foi != ''){
			$_POST['foi'] = $_GET['foiid'];
		}
		
		if ($startdate != ''){
			$_POST['startdate'] = $_GET['starting'];
		}
		
		if ($enddate != ''){
			$_POST['enddate'] = $_GET['ending'];
		}
		
/*		if ($observation != ''){
			$_POST['observation'] = $_GET['observation'];
		} */
		
		?>

<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

	<title>SkyEagle - Diagramm</title>
	<!--link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" /-->
    
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />

	<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
	<script src="https://www.google.com/jsapi"></script>
	

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

    <?php AQEChartOptions();?>
}
	else {
    	// Create our data table out of JSON data loaded from server.
   		// Instantiate and draw our chart, passing in some options.
    	
		<?php 
		//Number of offerings
		if (isset($_POST['observation'])){
			$numoff = count($_POST['observation']);
			switch($numoff){
				case 1: ?> var data = new google.visualization.DataTable(<?php getValues($_POST['observation']['0'])?>);
				var chart = new google.visualization.LineChart(document.getElementById('chart_div')); <?php
		        break;
		        
				case 2: ?> var data = new google.visualization.DataTable(<?php getValues($_POST['observation']['0'])?>);
				var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
				var data2 = new google.visualization.DataTable(<?php getValues($_POST['observation']['1'])?>);
				var chart2 = new google.visualization.LineChart(document.getElementById('chart2_div')); <?php
				break;
				
				case 3: ?> var data = new google.visualization.DataTable(<?php getValues($_POST['observation']['0'])?>);
				var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
				var data2 = new google.visualization.DataTable(<?php getValues($_POST['observation']['1'])?>);
				var chart2 = new google.visualization.LineChart(document.getElementById('chart2_div'));
				var data3 = new google.visualization.DataTable(<?php getValues($_POST['observation']['2'])?>);
				var chart3 = new google.visualization.LineChart(document.getElementById('chart3_div')); <?php
				break;
				
				case 4: ?> var data = new google.visualization.DataTable(<?php getValues($_POST['observation']['0'])?>);
				var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
				var data2 = new google.visualization.DataTable(<?php getValues($_POST['observation']['1'])?>);
				var chart2 = new google.visualization.LineChart(document.getElementById('chart2_div'));
				var data3 = new google.visualization.DataTable(<?php getValues($_POST['observation']['2'])?>);
				var chart3 = new google.visualization.LineChart(document.getElementById('chart3_div'));
				var data4 = new google.visualization.DataTable(<?php getValues($_POST['observation']['3'])?>);
				var chart4 = new google.visualization.LineChart(document.getElementById('chart4_div')); <?php
				break;				
		        
		}
}
?>


        <?php
        //PM 10 checked?
        if (isset($_POST['PM10'])){ if($_POST['PM10'] == "PM10_CONCENTRATION"){ ?>
		var data5 = new google.visualization.DataTable(<?php getValues("PM10_CONCENTRATION")?>);
        var chart5 = new google.visualization.LineChart(document.getElementById('chart5_div'));
		<?php }}?>
        <?php lanuvChartOptions();	?>
        
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



	
<script type="text/javascript" src="../js/jquery.mobile-1.3.0.min.js"></script>

</head>

  <body onload="changeForm(document.getElementById('foi').value)">

	<div data-role="page" id="dia">
		
		<!-- create header with navbar-->
	  	<div data-role="header" data-position="fixed">
	  		<a href="homemobile.php" data-rel="back">Zurück</a>
			<h1>SkyEagle - Diagramm</h1>
			<a href="hilfe.php">Hilfe</a>
			<div data-role="navbar">
			<ul>
				<li><a href="homemobile.php">Home</a></li>
				<li><a href="map.php" rel="external">Karte</a></li>
				<li><a href="dia.php" rel="external">Diagramm</a></li>
				<li><a href="tabelle.php">Tabelle</a></li>
			</ul>
			</div><!-- /navbar -->
		</div>
		<div date-role="content">  
			<!--load google charts charts-->
		<?php 
				if (isset($_POST['foi'])){
					if ($_POST['foi'] != "Geist" OR $_POST['foi'] != "Weseler"){
						echo '
						<div id="chart_div"></div>
						<div id="chart2_div"></div>
						<div id="chart3_div"></div> ';
						}
					else { echo '<div id="chart_div"></div>';
								//PM10 checked
								if(isset($_POST['PM10'])){ if($_POST['PM10'] == "PM10_CONCENTRATION"){
								echo '
								<div id="chart2_div"></div>';}}
								}
								} ?>
		</div>
   </div>
	
  </body>

</html>