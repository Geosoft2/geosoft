<?php 	//include 'getobsval.php'; 
		include '../php/chartform.php';
		include '../php/chkbox.php';
		include 'getobsvalmobile.php';
		include 'chartdisoptsmobile.php';
		
/* for $_GET */
		$g_foi = getVar("foiid");
		$g_startdate = getVar("starting");
		$g_enddate = getVar("ending");
		

		//$observation = getVar("observation");
/* if $foi, startdate, enddate and observation != '', then override $_POST */		
		if ($g_foi != ''){
			$_POST['foi'] = $_GET['foiid'];
		}
		
		if ($g_startdate != ''){
			$_POST['startdate'] = $_GET['starting'];
		}
		
		if ($g_enddate != ''){
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
    
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
	
	<script src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>

	

	
	<script type="text/javascript" src="../js/jquery.mobile-1.3.0.min.js"></script>
	<!-- function to refresh the chechboxes, when select is change -->
	<script type="text/javascript">
	$(document).ready(function(){
	    $("#foi").change(function() {
	        $("input[type='checkbox']").checkboxradio("refresh");
	    });
	});
    </script>
    
  
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
				<li><a href="#">Diagramm</a></li>
				<li><a href="tabelle.php">Tabelle</a></li>
			</ul>
			</div><!-- /navbar -->
		</div>
		<div data-role="content">  
		<form action = "dia2.php" method ="post" id="form" name="form" data-ajax="false">
			<fieldset>
				
			<!--load option list-->
			<p>
				<label><b>Bitte w&auml;hlen Sie eine Messstation:</b></label>
						<?php createOptionList();?>
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
	       value="<?php echo date('Y-m-d', time() - 86400); ?>" 
	       />
	        <input   
	       name="enddate" 
	       type="date" 
	       data-role="datebox" 
	       id="datepicker2" 
	       value="<?php echo date('Y-m-d'); ?>"
	       />
	       
			<!--create radio buttons to choice outlier yes/no-->
			</fieldset>
			<label><b>Bitte w&auml;hlen Sie aus, ob das Diagramm Ausrei&szlig;er beinhalten soll oder nicht:</b></label>
			<fieldset data-role="controlgroup" data-type="horizontal">
	    		
	    		<input type="radio" name="outliers" id="radio-choice-22" value="yes" checked></input>
	    		<label for="radio-choice-22">unbereinigt</label>
				<input type="radio" name="outliers" id="radio-choice-23" value="no"></input>
				<label for="radio-choice-23">bereinigt</label>	
				
			</fieldset>
			<legend><b>Bitte w&auml;hlen Sie aus, welche Messwerte sie im Diagramm anzeigen wollen.<font color="red">Es d&uuml;fen max. 3 Werte ausgew&auml;t werden.</font></b></legend>
			<fieldset data-role="controlgroup" data-type="horizontal" data-ajax="false">	
						
				
				<?php 
							createCheckboxes();
						?>			
					
			</p>
			</fieldset>
		
			<fieldset>
				<input class = "searchButton" type="submit" value="Anzeigen" />
			</fieldset>	
			
		</form>
		</div>
		
	   
   </div>

  </body>

</html>