<?php 

include 'config.php';

$HOST = $db["host"];
$PORT = $db["port"];
$USER = $db["user"];
$DBNAME = $db["name"];
$PASSWORD = $db["password"];

$conn = pg_connect("host=$HOST port=$PORT dbname=$DBNAME user=$USER password=$PASSWORD");

/*Get the Coordinates of one or all feature_of_interest */
function getCoords(){
	global $conn;
	$numargs = func_num_args();
	/* all foi */
	if ($numargs == 0){
		$result= pg_query($conn,"SELECT ST_X(geom), ST_Y(geom) FROM feature_of_interest");
		return pg_fetch_all($result);
	}
	/* one foi */
	else
	{
		$foi_id = func_get_arg(0);
		$result = pg_query($conn,"SELECT ST_X(geom), ST_Y(geom) 
				FROM feature_of_interest 
				WHERE feature_of_interest_id = '$foi_id' ");
		return pg_fetch_all($result);
	}
}

/* Get the name and the id of all feature_of_interest */
function getFoi(){
	global $conn;
	$result = pg_query($conn, "SELECT feature_of_interest_name, feature_of_interest_id
								FROM feature_of_interest
								ORDER BY feature_of_interest_name ASC");
	return pg_fetch_all($result);
}

/* Fliegt wahrscheinlich raus! ... oder nicht? */
function getFoiID($lat, $long){
	global $conn;
	if (isset ($lat) AND isset($long)){
			$result = pg_query($conn,"SELECT feature_of_interest_id 
					FROM feature_of_interest 
					WHERE ST_X(geom) = '$lat' AND ST_Y(geom) = '$long'");
			return pg_fetch_all($result);
	}
}
 

/* Get all observation values of one feature of interest */
function getAllObservationValues($foi_id, $start_date, $end_date){
	global $conn;
	if (isset ($foi_id) AND isset($start_date) AND isset($end_date) AND isset($outliers)){
			$result = pg_query($conn, "(SELECT time_stamp, phenomenon_description, numeric_value, unit
					FROM observation NATURAL JOIN phenomenon
					WHERE (feature_of_interest_id = '$foi_id') AND (time_stamp >= '$start_date'::date))
						INTERSECT
					(SELECT time_stamp, phenomenon_description, numeric_value, unit
					FROM observation NATURAL JOIN phenomenon
					WHERE (feature_of_interest_id = '$foi_id') AND  (time_stamp <= '$end_date'::date))");	
			return pg_fetch_all($result);
	}	
}

/* Get all observation values of one feature of interest without outliers */
function getAllObservationValuesNO($foi_id, $start_date, $end_date){
	global $conn;
	if (isset ($foi_id) AND isset($start_date) AND isset($end_date) AND isset($outliers)){
		$result = pg_query($conn, "(SELECT time_stamp, phenomenon_description, numeric_value, unit
				FROM observation NATURAL JOIN phenomenon NATURAL JOIN quality
				WHERE (feature_of_interest_id = '$foi_id') AND (quality_value='no') AND (time_stamp >= '$start_date'::date))
				INTERSECT
				(SELECT time_stamp, phenomenon_description, numeric_value, unit
				FROM observation NATURAL JOIN phenomenon NATURAL JOIN quality
				WHERE (feature_of_interest_id = '$foi_id') AND (quality_value='no') AND  (time_stamp <= '$end_date'::date))");
		return pg_fetch_all($result);
	}
}

/* Get the observation values of one feature of interest */
function getObservationValues($foi_id, $start_date, $end_date){
	global $conn;
	if (isset ($foi_id) AND isset($start_date) AND isset($end_date)){
		$numargs = func_num_args();
		switch($numargs){
			case 4:
				$offering1 = func_get_arg(3);
				$result = pg_query($conn, "(SELECT time_stamp, offering_id, numeric_value
						FROM observation
						WHERE (feature_of_interest_id = '$foi_id') AND (time_stamp >= '$start_date'::date) 
						AND (offering_id = '$offering1'))
						INTERSECT
						(SELECT time_stamp, offering_id, numeric_value
						FROM observation
						WHERE (feature_of_interest_id = '$foi_id') AND  (time_stamp <= '$end_date'::date) 
						AND (offering_id = '$offering1')) ORDER BY time_stamp ASC");
				return pg_fetch_all($result);
				break;
			
			case 5:
				$offering1 = func_get_arg(3);
				$offering2 = func_get_arg(4);
				$result = pg_query($conn, "(SELECT time_stamp, offering_id, numeric_value
						FROM observation
						WHERE (feature_of_interest_id = '$foi_id')  AND (time_stamp >= '$start_date'::date) 
						AND ((offering_id = '$offering1') OR (offering_id = '$offering2')))
						INTERSECT
						(SELECT time_stamp, offering_id, numeric_value
						FROM observation
						WHERE (feature_of_interest_id = '$foi_id') AND  (time_stamp <= '$end_date'::date) 
						AND ((offering_id = '$offering1') OR (offering_id = '$offering2'))) ORDER BY time_stamp, offering_id ASC");
				return pg_fetch_all($result);
				break;
				
			case 6:
				$offering1 = func_get_arg(3);
				$offering2 = func_get_arg(4);
				$offering3 = func_get_arg(5);
				$result = pg_query($conn, "(SELECT time_stamp, offering_id, numeric_value
						FROM observation
						WHERE (feature_of_interest_id = '$foi_id') AND (time_stamp >= '$start_date'::date) 
						AND ((offering_id = '$offering1')  OR (offering_id = '$offering2') OR (offering_id = '$offering3')))
						INTERSECT
						(SELECT time_stamp, offering_id, numeric_value
						FROM observation
						WHERE (feature_of_interest_id = '$foi_id') AND  (time_stamp <= '$end_date'::date) 
						AND ((offering_id = '$offering1')  OR (offering_id = '$offering2') OR (offering_id = '$offering3'))) ORDER BY time_stamp, offering_id ASC");
				return pg_fetch_all($result);
				break;
		}
	}
}

/* Get the observation of one feature of interest without outliers */
function getObservationValuesNO($foi_id, $start_date, $end_date){
	global $conn;
	if (isset ($foi_id) AND isset($start_date) AND isset($end_date)){
		$numargs = func_num_args();
		switch($numargs){
			case 4:
				$offering1 = func_get_arg(3);
				$result = pg_query($conn, "(SELECT time_stamp, offering_id, numeric_value
						FROM observation NATURAL JOIN quality
						WHERE (feature_of_interest_id = '$foi_id') AND (quality_value='no') AND (time_stamp >= '$start_date'::date)
						AND (offering_id = '$offering1'))
						INTERSECT
						(SELECT time_stamp, offering_id, numeric_value
						FROM observation NATURAL JOIN quality
						WHERE (feature_of_interest_id = '$foi_id') AND (quality_value='no') AND (time_stamp <= '$end_date'::date)
						AND (offering_id = '$offering1')) ORDER BY time_stamp ASC");
				return pg_fetch_all($result);
				break;
					
			case 5:
				$offering1 = func_get_arg(3);
				$offering2 = func_get_arg(4);
				$result = pg_query($conn, "(SELECT time_stamp, offering_id, numeric_value
						FROM observation NATURAL JOIN quality
						WHERE (feature_of_interest_id = '$foi_id') AND (quality_value='no') AND (time_stamp >= '$start_date'::date)
						AND ((offering_id = '$offering1') OR (offering_id = '$offering2')))
						INTERSECT
						(SELECT time_stamp, offering_id, numeric_value
						FROM observation NATURAL JOIN quality
						WHERE (feature_of_interest_id = '$foi_id') AND (quality_value='no') AND (time_stamp <= '$end_date'::date)
						AND ((offering_id = '$offering1') OR (offering_id = '$offering2'))) ORDER BY time_stamp, offering_id ASC");
				return pg_fetch_all($result);
				break;

			case 6:
				$offering1 = func_get_arg(3);
				$offering2 = func_get_arg(4);
				$offering3 = func_get_arg(5);
				$result = pg_query($conn, "(SELECT time_stamp, offering_id, numeric_value
						FROM observation NATURAL JOIN quality
						WHERE (feature_of_interest_id = '$foi_id') AND (quality_value='no') AND (time_stamp >= '$start_date'::date)
						AND ((offering_id = '$offering1')  OR (offering_id = '$offering2') OR (offering_id = '$offering3')))
						INTERSECT
						(SELECT time_stamp, offering_id, numeric_value
						FROM observation NATURAL JOIN quality
						WHERE (feature_of_interest_id = '$foi_id') AND (quality_value='no') AND (time_stamp <= '$end_date'::date)
						AND ((offering_id = '$offering1')  OR (offering_id = '$offering2') OR (offering_id = '$offering3'))) ORDER BY time_stamp, offering_id ASC");
				return pg_fetch_all($result);
				break;
		}
	}
}

/* Get the last observation values of one feature_of_interest */
function getLastObservationValues($foi_id){
	global $conn;
	if (isset ($foi_id)){
		$result = pg_query($conn, "SELECT time_stamp, phenomenon_description, numeric_value, unit 
				FROM observation NATURAL JOIN phenomenon 
				WHERE (feature_of_interest_id = '$foi_id') AND (time_stamp = (
															SELECT max(time_stamp) 
															FROM observation 
															WHERE feature_of_interest_id ='$foi_id'))");
		return pg_fetch_all($result);
	}
}

function getTimeStamp($foi_id, $start_date, $end_date){
	global $conn;
	if (isset ($foi) AND isset ($startdate) AND isset($enddate)){
		$result = pg_query($conn, "SELECT distinct time_stamp 
									FROM observation
									WHERE (feature_of_interest_id ='$foi_id') AND (time_stamp >= '$start_date'::date) AND (time_stamp <= '$end_date'::date) ORDER BY time_stamp");
	}
}

function arrayToJSON($cols, $rows){
	$table = json_encode(array(
			'cols' => $cols,
			'rows' => $rows),
			JSON_NUMERIC_CHECK);
	return $table;
}

//-----------------------------------------------------------------------------

function getTableNumRows($foi_id, $start_date, $end_date){
	global $conn;
	if (isset ($foi_id) AND isset ($start_date) AND isset ($end_date)){
		$result = pg_query($conn, "SELECT distinct time_stamp 
									FROM observation 
									WHERE feature_of_interest_id = '$foi_id' AND time_stamp >= '$start_date'::date AND time_stamp <= '$end_date'::date");
		$num = pg_num_rows($result);
	return $num;
	}
}
									
function getTableTimeStamp($foi_id, $start_date, $end_date){
	global $conn;
		$result1 = pg_query($conn, "SELECT distinct time_stamp 
									FROM observation 
									WHERE feature_of_interest_id = '$foi_id' AND time_stamp >= '$start_date'::date AND time_stamp <= '$end_date'::date ORDER BY time_stamp asc");
		return $result1;
}

function getTableTemperature($foi_id, $start_date, $end_date){
	global $conn;
		$result2 = pg_query($conn, "SELECT numeric_value 
									FROM observation 
									WHERE feature_of_interest_id = '$foi_id' AND offering_id = 'TEMPERATURE' AND time_stamp >= '$start_date'::date AND time_stamp <= '$end_date'::date ORDER BY time_stamp asc");
		return $result2;
}

function getTableAirHumidity($foi_id, $start_date, $end_date){
	global $conn;
		$result3 = pg_query($conn, "SELECT numeric_value 
									FROM observation 
									WHERE feature_of_interest_id = '$foi_id' AND offering_id = 'AIR_HUMIDITY' AND time_stamp >= '$start_date'::date AND time_stamp <= '$end_date'::date ORDER BY time_stamp asc");
		return $result3;
}

function getTableCO($foi_id, $start_date, $end_date){
	global $conn;
		$result4 = pg_query($conn, "SELECT numeric_value 
									FROM observation 
									WHERE feature_of_interest_id = '$foi_id' AND offering_id = 'CO_CONCENTRATION' AND time_stamp >= '$start_date'::date AND time_stamp <= '$end_date'::date ORDER BY time_stamp asc");
		return $result4;
}

function getTableNO2($foi_id, $start_date, $end_date){
	global $conn;
		$result5 = pg_query($conn, "SELECT numeric_value 
									FROM observation 
									WHERE feature_of_interest_id = '$foi_id' AND offering_id = 'NO2_CONCENTRATION' AND time_stamp >= '$start_date'::date AND time_stamp <= '$end_date'::date ORDER BY time_stamp asc");
		return $result5;
}

function getTableO3($foi_id, $start_date, $end_date){
	global $conn;
		$result6 = pg_query($conn, "SELECT numeric_value 
									FROM observation 
									WHERE feature_of_interest_id = '$foi_id' AND offering_id = 'O3_CONCENTRATION' AND time_stamp >= '$start_date'::date AND time_stamp <= '$end_date'::date ORDER BY time_stamp asc");
		return $result6;
}

function getName(){
	global $conn;
	$result = pg_query($conn, "SELECT feature_of_interest_name
								FROM feature_of_interest");
	return pg_fetch_all($result);
}

function getFoiIdMap(){
	global $conn;
	$result = pg_query($conn, "SELECT feature_of_interest_id
								FROM feature_of_interest");
	return pg_fetch_all($result);
}

function getLatestTemp(){
	global $conn;
		$result = pg_query($conn, "SELECT time_stamp, numeric_value
								FROM observation
								WHERE time_stamp = (SELECT MAX(time_stamp) FROM observation) AND offering_id = 'TEMPERATURE'");
		return pg_fetch_all($result);
}

function getLatestHum(){
	global $conn;
		$result = pg_query($conn, "SELECT time_stamp, numeric_value
								FROM observation
								WHERE time_stamp = (SELECT MAX(time_stamp) FROM observation) AND offering_id = 'AIR_HUMIDITY'");
		return pg_fetch_all($result);
}

function getLatestO3(){
	global $conn;
		$result = pg_query($conn, "SELECT time_stamp, numeric_value
								FROM observation
								WHERE time_stamp = (SELECT MAX(time_stamp) FROM observation) AND offering_id = 'O3_CONCENTRATION'");
		return pg_fetch_all($result);
}

function getLatestNO2(){
	global $conn;
		$result = pg_query($conn, "SELECT time_stamp, numeric_value
								FROM observation
								WHERE time_stamp = (SELECT MAX(time_stamp) FROM observation) AND offering_id = 'NO2_CONCENTRATION'");
		return pg_fetch_all($result);
}

function getLatestCO(){
	global $conn;
		$result = pg_query($conn, "SELECT time_stamp, numeric_value
								FROM observation
								WHERE time_stamp = (SELECT MAX(time_stamp) FROM observation) AND offering_id = 'CO_CONCENTRATION'");
		return pg_fetch_all($result);
}

function getTableBerNumRows($foi_id, $start_date, $end_date){
	global $conn;
	if (isset ($foi_id) AND isset ($start_date) AND isset ($end_date)){
		$result = pg_query($conn, "SELECT distinct time_stamp 
									FROM observation NATURAL JOIN phenomenon NATURAL JOIN quality 
									WHERE (feature_of_interest_id = '$foi_id') AND (time_stamp >= '$start_date'::date) AND (time_stamp <= '$end_date'::date)");
		$num = pg_num_rows($result);
	return $num;
	}
}

function getTableBerTimeStamp($foi_id, $start_date, $end_date){
	global $conn;
		$result1 = pg_query($conn, "SELECT distinct time_stamp 
									FROM observation NATURAL JOIN phenomenon NATURAL JOIN quality 
									WHERE (feature_of_interest_id = '$foi_id') AND (time_stamp >= '$start_date'::date) AND (time_stamp <= '$end_date'::date) order by time_stamp asc");
		return $result1;
}

function getTableBerTemperature($foi_id, $start_date, $end_date){
	global $conn;
		$result2 = pg_query($conn, "SELECT numeric_value, quality_value
									FROM observation NATURAL JOIN phenomenon NATURAL JOIN quality 
									WHERE (feature_of_interest_id = '$foi_id') AND (offering_id='TEMPERATURE') AND (time_stamp >= '$start_date'::date) AND (time_stamp <= '$end_date'::date) order by time_stamp asc");
		return $result2;
}

function getTableBerAirHumidity($foi_id, $start_date, $end_date){
	global $conn;
		$result3 = pg_query($conn, "SELECT numeric_value, quality_value
									FROM observation NATURAL JOIN phenomenon NATURAL JOIN quality 
									WHERE (feature_of_interest_id = '$foi_id') AND (offering_id='AIR_HUMIDITY') AND (time_stamp >= '$start_date'::date) AND (time_stamp <= '$end_date'::date) order by time_stamp asc");
		return $result3;
}

function getTableBerCO($foi_id, $start_date, $end_date){
	global $conn;
		$result4 = pg_query($conn, "SELECT numeric_value, quality_value
									FROM observation NATURAL JOIN phenomenon NATURAL JOIN quality 
									WHERE (feature_of_interest_id = '$foi_id') AND (offering_id='CO_CONCENTRATION') AND (time_stamp >= '$start_date'::date) AND (time_stamp <= '$end_date'::date) order by time_stamp asc");
		return $result4;
}

function getTableBerNO2($foi_id, $start_date, $end_date){
	global $conn;
		$result5 = pg_query($conn, "SELECT numeric_value, quality_value
									FROM observation NATURAL JOIN phenomenon NATURAL JOIN quality 
									WHERE (feature_of_interest_id = '$foi_id') AND (offering_id='NO2_CONCENTRATION') AND (time_stamp >= '$start_date'::date) AND (time_stamp <= '$end_date'::date) order by time_stamp asc");
		return $result5;
}

function getTableBerO3($foi_id, $start_date, $end_date){
	global $conn;
		$result6 = pg_query($conn, "SELECT numeric_value, quality_value
									FROM observation NATURAL JOIN phenomenon NATURAL JOIN quality 
									WHERE (feature_of_interest_id = '$foi_id') AND (offering_id='O3_CONCENTRATION') AND (time_stamp >= '$start_date'::date) AND (time_stamp <= '$end_date'::date) order by time_stamp asc");
		return $result6;
}

?>