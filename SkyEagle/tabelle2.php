<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

	<title>SkyEagle - Tabelle</title>
	<!--link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" /-->
    
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
 
	<div data-role="page" id="tabelle">

  	<div data-role="header" data-position="fixed">
  		<a href="index.html" data-rel="back">Zurück</a>
		<!--a href="index.html" data-icon="delete">Cancel</a-->
		<h1>SkyEagle - Tabelle</h1>
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
	
	
	<table data-role="table" id="table-column-toggle" data-mode="columntoggle" class="ui-responsive table-stroke" data-column-btn-text="Werte...">
			<?php
			ini_set( "display_errors", 0);
			include_once 'dbconnectorK2.php';
			
			/* Part für die unbereinigte bzw. bereinigte Tabelle. Es wird gecheckt, ob ein Feature of Interest, ein Startdatum, ein Enddatum 
				und ein Radiobutton ausgewählt wurde */
				
			if (isset($_POST['foi']) AND isset($_POST['startdate']) AND isset($_POST['enddate']) AND isset($_POST["Ausreisser"])){
				$selected_radio = $_POST['Ausreisser'];
				
				/* Der Part für die unbereinigte Tabelle */	
				
				if ($selected_radio == 'Unbereinigt'){
					$start = $_POST['startdate'];
					$end = $_POST['enddate'];
					$foi = $_POST['foi'];
					$num = getTableNumRows($foi,$start,$end);			// Variable für die Tabellengröße
					$result1 = getTableTimeStamp($foi,$start,$end);
					
					/* Ausschließen der bestimmten Kombinationen, da manche Messwerte nur begrenzt und nicht bei jeder Messstation
						verfügbar sind. So ist z.B. SO2 nur bei der Lanuv-Station 'Geist' verfügbar */
						
					if ($foi != 'Weseler' AND $foi != 'Geist'){$result2 = getTableOffering($foi,$start,$end, TEMPERATURE);}
					if ($foi != 'Weseler' AND $foi != 'Geist'){$result3 = getTableOffering($foi,$start,$end, AIR_HUMIDITY);}
					if ($foi != 'Weseler' AND $foi != 'Geist'){$result4 = getTableOffering($foi,$start,$end, CO_CONCENTRATION);}
					$result5 = getTableOffering($foi,$start,$end, NO2_CONCENTRATION);
					if ($foi != 'Weseler'){$result6 = getTableOffering($foi,$start,$end, O3_CONCENTRATION);}
					if ($foi == 'Weseler' OR $foi == 'Geist'){$result7 = getTableLanuvOffering($foi,$start,$end, NO_CONCENTRATION);}
					if ($foi == 'Geist'){$result8 = getTableLanuvOffering($foi,$start,$end, SO2_CONCENTRATION);}
					if ($foi == 'Weseler' OR $foi == 'Geist'){$result9 = getTableLanuvOffering($foi,$start,$end, PM10_CONCENTRATION);}
					
					/* Die Tabelle für die Air Quality Eggs */ 
					if ($foi != 'Weseler' AND $foi != 'Geist'){	
		?>
		<thead>
		<tr>
            <th data-priority="1">Zeit</th>
            <th data-priority="1">&#176;C</th>
            <th data-priority="1">r.F.</th>
            <th data-priority="2">CO</th>
            <th data-priority="3">NO<sub>2</sub></th>
            <th data-priority="4">O<sub>3</sub></th>
        </tr>
        </thead>
		<?php
		/* Zeile für Zeile wird ausgelesen und anschließend in die erstellte Tabelle geschrieben */
						$i = 0;
						while($i < $num){
							$time_stamp=pg_result($result1,$i,"time_stamp");
							$temperature=pg_result($result2,$i,"numeric_value");
							$humidity = pg_result($result3,$i,"numeric_value");
							$co = pg_result($result4,$i,"numeric_value");
							$no2 = pg_result($result5,$i,"numeric_value");
							$o3 = pg_result($result6,$i,"numeric_value");
		?>
		
		<tr>
			<td><?php echo $time_stamp; ?></td>
			<td><?php echo $temperature; ?></td>
			<td><?php echo $humidity; ?></td>
			<td><?php echo $co; ?></td>
			<td><?php echo $no2; ?></td>
			<td><?php echo $o3; ?></td>
		</tr>
		
		<?php
				$i++;
						}
					}
			/* Der Teil analog für die Lanuv-Station an der Weseler Straße. Diese misst NO, NO2 und PM10 und benötigt daher eine eigene Tabelle */
						if ($foi == 'Weseler'){
		?>
		<thead>
		<tr>
            <th data-priority="1">Zeit</th>
            <th data-priority="1">NO</th>
            <th data-priority="1">NO<sub>2</sub></th>
            <th data-priority="2">PM10</th>
        </tr>
        </thead>
		
		
		<?php
						$i = 0;
						while($i < $num){
						$time_stamp = pg_result($result1,$i,"time_stamp");
						$no = pg_result($result7,$i,"numeric_value");
						$no2 = pg_result($result5,$i,"numeric_value");
						$pm10 = pg_result($result9,$i,"numeric_value");
		?>
		
		<tr>
			<td><?php echo $time_stamp; ?></td>
			<td><?php echo $no; ?></td>
			<td><?php echo $no2; ?></td>
			<td><?php echo $pm10; ?></td>
		</tr>
		
		<?php
						$i++;
						}
					}
			/* Der Teil analog für die Lanuv-Station im Geistviertel. Diese misst NO, NO2, SO2, O3 und PM10 und benötigt daher eine eigene Tabelle */
						if ($foi == 'Geist'){
		?>
		<thead>
		<tr>
            <th data-priority="1">Zeit</th>
            <th data-priority="1">NO</th>
            <th data-priority="1">NO<sub>2</sub></th>
            <th data-priority="2">PM10</th>
            <th data-priority="3">SO<sub>2</sub></th>
            <th data-priority="4">O<sub>3</sub></th>
        </tr>
        </thead>
		
		
		<?php
						$i = 0;
						while($i < $num){
						$time_stamp = pg_result($result1,$i,"time_stamp");
						$no = pg_result($result7,$i,"numeric_value");
						$no2 = pg_result($result5,$i,"numeric_value");
						$pm10 = pg_result($result9,$i,"numeric_value");
						$so2 = pg_result($result8,$i,"numeric_value");
						$o3 = pg_result($result6,$i,"numeric_value");
		?>
		
		<tr>
			<td><?php echo $time_stamp; ?></td>
			<td><?php echo $no; ?></td>
			<td><?php echo $no2; ?></td>
			<td><?php echo $pm10; ?></td>
			<td><?php echo $so2; ?></td>
			<td><?php echo $o3; ?></td>
		</tr>
		
		<?php
						$i++;
						}
						}
				}
			/* Der Teil für die bereinigten Tabellen. Prinzipiell ist die Vorgehensweise analog zum obigen Teil. */
				if ($selected_radio == 'Bereinigt'){
					$start = $_POST['startdate'];
					$end = $_POST['enddate'];
					$foi = $_POST['foi'];
					$num = getTableBerNumRows($foi,$start,$end);
					$result1 = getTableBerTimeStamp($foi,$start,$end);
					if ($foi != 'Weseler' AND $foi != 'Geist'){$result2 = getTableBerOffering($foi,$start,$end, TEMPERATURE);}
					if ($foi != 'Weseler' AND $foi != 'Geist'){$result3 = getTableBerOffering($foi,$start,$end, AIR_HUMIDITY);}
					if ($foi != 'Weseler' AND $foi != 'Geist'){$result4 = getTableBerOffering($foi,$start,$end, CO_CONCENTRATION);}
					$result5 = getTableBerOffering($foi,$start,$end, NO2_CONCENTRATION);
					if ($foi != 'Weseler'){$result6 = getTableBerOffering($foi,$start,$end, O3_CONCENTRATION);}
					if ($foi == 'Weseler' OR $foi == 'Geist'){$result7 = getTableLanuvBerOffering($foi,$start,$end, NO_CONCENTRATION);}
					if ($foi == 'Geist'){$result8 = getTableLanuvBerOffering($foi,$start,$end, SO2_CONCENTRATION);}
					if ($foi == 'Weseler' OR $foi == 'Geist'){$result9 = getTableLanuvBerOffering($foi,$start,$end, PM10_CONCENTRATION);}
					
					if ($foi != 'Weseler' AND $foi != 'Geist'){
		?>
		<thead>
		<tr>
            <th data-priority="1">Zeit</th>
            <th data-priority="1">&#176;C</th>
            <th data-priority="1">r.F.</th>
            <th data-priority="2">CO</th>
            <th data-priority="3">NO<sub>2</sub></th>
            <th data-priority="4">O<sub>3</sub></th>
        </tr>
        </thead>
		
		<?php
			/* Zusätzliche Überprüfung, ob es sich um einen Ausreißer handelt oder ob der Wert bereits getestet wurde. Anschließend
				werden in der Tabelle Ausreißer rot markiert und noch nicht überprüfte Werte grau. */
						$i = 0;
						while($i < $num){
							$time_stamp = pg_result($result1,$i,"time_stamp");
							$temperature = pg_result($result2,$i,"numeric_value");
								$tempout = pg_result($result2,$i,"quality_value");
							$humidity = pg_result($result3,$i,"numeric_value");
								$humout = pg_result($result3,$i,"quality_value");
							$co = pg_result($result4,$i,"numeric_value");
								$coout = pg_result($result4,$i,"quality_value");
							$no2 = pg_result($result5,$i,"numeric_value");
								$no2out = pg_result($result5,$i,"quality_value");
							$o3 = pg_result($result6,$i,"numeric_value");
								$o3out = pg_result($result6,$i,"quality_value");
		?>
		<tr>
			<td><?php echo $time_stamp; ?></td>
			<td><?php if ($tempout == 'no') echo $temperature;
						elseif ($tempout == 'yes') echo '<span style="color:#FF0000">'.$temperature.'</span>';
							else echo '<span style="color:#C0C0C0">'.$temperature.'</span>'?></td>
			<td><?php if ($humout == 'no') echo $humidity; 
						elseif ($humout == 'yes') echo '<span style="color:#FF0000">'.$humidity.'</span>';
							else echo '<span style="color:#C0C0C0">'.$humidity.'</span>'?></td>
			<td><?php if ($coout == 'no') echo $co;
						elseif ($coout == 'yes') echo '<span style="color:#FF0000">'.$co.'</span>';
							else echo '<span style="color:#C0C0C0">'.$co.'</span>'?></td>
			<td><?php if ($no2out == 'no') echo $no2;
						elseif ($no2out == 'yes') echo '<span style="color:#FF0000">'.$no2.'</span>';
							else echo '<span style="color:#C0C0C0">'.$no2.'</span>'?></td>
			<td><?php if ($o3out == 'no') echo $o3;
						elseif ($tempout == 'yes') echo '<span style="color:#FF0000">'.$o3.'</span>';
							else echo '<span style="color:#C0C0C0">'.$o3.'</span>'?></td>
		</tr>
		
		<?php
						$i++;
						}
					}
				/* Der Teil für die Station an der Weseler Straße */
						if ($foi == 'Weseler'){
		?>
		<thead>
		<tr>
            <th data-priority="1">Zeit</th>
            <th data-priority="1">NO</th>
            <th data-priority="1">NO<sub>2</sub></th>
            <th data-priority="2">PM10</th>
        </tr>
        </thead>
		
		
		<?php
							$i = 0;
							while($i < $num){
							$time_stamp = pg_result($result1,$i,"time_stamp");
							$no = pg_result($result7,$i,"numeric_value");
								$noout = pg_result($result7,$i,"quality_value");
							$no2 = pg_result($result5,$i,"numeric_value");
								$no2out = pg_result($result5,$i,"quality_value");
							$pm10 = pg_result($result9,$i,"numeric_value");
								$pm10out = pg_result($result9,$i,"quality_value");
		?>
		
		<tr>
			<td><?php echo $time_stamp; ?></td>
			<td><?php if ($noout == 'no') echo $no;
						elseif ($noout == 'yes') echo '<span style="color:#FF0000">'.$no.'</span>';
							else echo '<span style="color:#C0C0C0">'.$no.'</span>'?></td>
			<td><?php if ($no2out == 'no') echo $no2;
						elseif ($no2out == 'yes') echo '<span style="color:#FF0000">'.$no2.'</span>';
							else echo '<span style="color:#C0C0C0">'.$no2.'</span>'?></td>
			<td><?php if ($pm10out == 'no') echo $pm10;
						elseif ($pm10out == 'yes') echo '<span style="color:#FF0000">'.$pm10.'</span>';
							else echo '<span style="color:#C0C0C0">'.$pm10.'</span>'?></td>
		</tr>
		
		<?php
						$i++;
							}
						}
				/* Der Teil für die Station im Geistviertel */
						if ($foi == 'Geist'){
		?>
		
		<thead>
		<tr>
            <th data-priority="1">Zeit</th>
            <th data-priority="1">NO</th>
            <th data-priority="1">NO<sub>2</sub></th>
            <th data-priority="2">PM10</th>
            <th data-priority="3">SO<sub>2</sub></th>
            <th data-priority="4">O<sub>3</sub></th>
        </tr>
        </thead>
		
		
		<?php
							$i = 0;
							while($i < $num){
							$time_stamp = pg_result($result1,$i,"time_stamp");
							$no = pg_result($result7,$i,"numeric_value");
								$noout = pg_result($result7,$i,"quality_value");
							$no2 = pg_result($result5,$i,"numeric_value");
								$no2out = pg_result($result5,$i,"quality_value");
							$pm10 = pg_result($result9,$i,"numeric_value");
								$pm10out = pg_result($result9,$i,"quality_value");
							$so2 = pg_result($result8,$i,"numeric_value");
								$so2out = pg_result($result8,$i,"quality_value");
							$o3 = pg_result($result6,$i,"numeric_value");
								$o3out = pg_result($result6,$i,"quality_value");
		?>
		
		<tr>
			<td><?php echo $time_stamp; ?></td>
			<td><?php if ($noout == 'no') echo $no;
						elseif ($noout == 'yes') echo '<span style="color:#FF0000">'.$no.'</span>';
							else echo '<span style="color:#C0C0C0">'.$no.'</span>'?></td>
			<td><?php if ($no2out == 'no') echo $no2;
						elseif ($no2out == 'yes') echo '<span style="color:#FF0000">'.$no2.'</span>';
							else echo '<span style="color:#C0C0C0">'.$no2.'</span>'?></td>
			<td><?php if ($pm10out == 'no') echo $pm10;
						elseif ($pm10out == 'yes') echo '<span style="color:#FF0000">'.$pm10.'</span>';
							else echo '<span style="color:#C0C0C0">'.$pm10.'</span>'?></td>
			<td><?php if ($so2out == 'no') echo $so2;
						elseif ($so2out == 'yes') echo '<span style="color:#FF0000">'.$so2.'</span>';
							else echo '<span style="color:#C0C0C0">'.$so2.'</span>'?></td>
			<td><?php if ($o3out == 'no') echo $pm10;
						elseif ($o3out == 'yes') echo '<span style="color:#FF0000">'.$o3.'</span>';
							else echo '<span style="color:#C0C0C0">'.$o3.'</span>'?></td>
		</tr>
		
		<?php
							$i++;
							}
						}
				}
			}
			//pg_close();
		?>
	</table>		
	</div>
	
  </body>

</html>