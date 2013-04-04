<?php 

include_once 'dbconnector.php';

if (isset($_POST['observation'])){
$obs = $_POST['observation'];
$numargs = count($obs);
$rows = array();
$cols = array();
switch ($numargs) {
	// 1 offering
	case 1:
		$obs1 = $obs ['0'];

		$cols = array(
				array('label' => 'date','type' => 'string'),
				array('label' => $obs1,'type' => 'number'));
		
		$rows = getObservationValues($_POST['foi'], $_POST['startdate'], $_POST['enddate'], $obs1);		
		
		for($i = 0; $i < count($rows); $i++ ){
			$row = $rows[$i];
			$temp = array();
			$temp[] = array('v' => $row['time_stamp']);
			$temp[] = array('v' => $row['numeric_value']);
			
			$trows[] = array('c' => $temp);
			unset($temp);		
		}
		
		$table = arrayToJSON($cols, $trows);	
		echo $table;
	break;
		
	// 2 offerings
	case 2:
		$obs1 = $obs['0'];
		$obs2 = $obs['1'];

		$cols = array(
				array('label' => 'date','type' => 'string'),
				array('label' => $obs1, 'type' => 'number'),
				array('label' => $obs2, 'type' => 'number'));
		
		$rows = getObservationValues($_POST['foi'], $_POST['startdate'], $_POST['enddate'], $obs1, $obs2);

		
		for($i = 0; $i < count($rows); $i++){
			$row = $rows[$i];
			$temp = array();
			$temp[] = array('v' => $row['time_stamp']);
			$temp[] = array('v' => $row['numeric_value']);
			$i++;
			$row = $rows[$i];
			$temp[] = array('v' => $row['numeric_value']);
			
			$trows[] = array('c' => $temp);
			unset($temp);
		}
		
		$table = arrayToJSON($cols, $trows);	
		echo $table;	
	break;
			
	case 3:
		$obs1 = $obs['0'];
		$obs2 = $obs['1'];
		$obs3 = $obs['2'];
		
		$cols = array(
				array('label' => 'date','type' => 'string'),
				array('label' => $obs1, 'type' => 'number'),
				array('label' => $obs2, 'type' => 'number'),
				array('label' => $obs3, 'type' => 'number'));
		
		$rows = getObservationValues($_POST['foi'], $_POST['startdate'], $_POST['enddate'], $obs1, $obs2, $obs3);

		for($i = 0; $i < count($rows); $i++){
			$row = $rows[$i];
			$temp = array();
			$temp[] = array('v' => $row['time_stamp']);
			$temp[] = array('v' => $row['numeric_value']);
			$i++;
			$row = $rows[$i];
			$temp[] = array('v' => $row['numeric_value']);
			$i++;
			$row = $rows[$i];
			$temp[] = array('v' => $row['numeric_value']);
				
			$trows[] = array('c' => $temp);
			unset($temp);
		}
		
		$table = arrayToJSON($cols, $trows);	
		echo $table;
	break;
	}
}
?>