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
	if (isset ($foi_id) AND isset($start_date) AND isset($end_date)){
			$result = pg_query($conn, "(SELECT time_stamp :: timestamp without time zone, phenomenon_description, numeric_value, unit
					FROM observation NATURAL JOIN phenomenon
					WHERE (feature_of_interest_id = '$foi_id') AND (time_stamp >= '$start_date'::date))
						INTERSECT
					(SELECT time_stamp :: timestamp without time zone, phenomenon_description, numeric_value, unit
					FROM observation NATURAL JOIN phenomenon
					WHERE (feature_of_interest_id = '$foi_id') AND  (time_stamp <= '$end_date'::date))");	
			return pg_fetch_all($result);
	}	
}

/* Get all observation values of one feature of interest without outliers */
function getAllObservationValuesNO($foi_id, $start_date, $end_date){
	global $conn;
	if (isset ($foi_id) AND isset($start_date) AND isset($end_date)){
		$result = pg_query($conn, "(SELECT time_stamp :: timestamp without time zone, phenomenon_description, numeric_value, unit
				FROM observation NATURAL JOIN phenomenon NATURAL JOIN quality
				WHERE (feature_of_interest_id = '$foi_id') AND (quality_value='no') AND (time_stamp >= '$start_date'::date))
				INTERSECT
				(SELECT time_stamp :: timestamp without time zone, phenomenon_description, numeric_value, unit
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
				$result = pg_query($conn, "(SELECT time_stamp :: timestamp without time zone, offering_id, numeric_value
						FROM observation
						WHERE (feature_of_interest_id = '$foi_id') AND (time_stamp >= '$start_date'::date) 
						AND (offering_id = '$offering1'))
						INTERSECT
						(SELECT time_stamp :: timestamp without time zone, offering_id, numeric_value
						FROM observation
						WHERE (feature_of_interest_id = '$foi_id') AND  (time_stamp <= '$end_date'::date) 
						AND (offering_id = '$offering1')) ORDER BY time_stamp ASC");
				return pg_fetch_all($result);
				break;
			
			case 5:
				$offering1 = func_get_arg(3);
				$offering2 = func_get_arg(4);
				$result = pg_query($conn, "(SELECT time_stamp :: timestamp without time zone, offering_id, numeric_value
						FROM observation
						WHERE (feature_of_interest_id = '$foi_id')  AND (time_stamp >= '$start_date'::date) 
						AND ((offering_id = '$offering1') OR (offering_id = '$offering2')))
						INTERSECT
						(SELECT time_stamp :: timestamp without time zone, offering_id, numeric_value
						FROM observation
						WHERE (feature_of_interest_id = '$foi_id') AND  (time_stamp <= '$end_date'::date) 
						AND ((offering_id = '$offering1') OR (offering_id = '$offering2'))) ORDER BY time_stamp, offering_id ASC");
				return pg_fetch_all($result);
				break;
				
			case 6:
				$offering1 = func_get_arg(3);
				$offering2 = func_get_arg(4);
				$offering3 = func_get_arg(5);
				$result = pg_query($conn, "(SELECT time_stamp :: timestamp without time zone, offering_id, numeric_value
						FROM observation
						WHERE (feature_of_interest_id = '$foi_id') AND (time_stamp >= '$start_date'::date) 
						AND ((offering_id = '$offering1')  OR (offering_id = '$offering2') OR (offering_id = '$offering3')))
						INTERSECT
						(SELECT time_stamp :: timestamp without time zone, offering_id, numeric_value
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
				$result = pg_query($conn, "(SELECT time_stamp :: timestamp without time zone, offering_id, numeric_value
						FROM observation NATURAL JOIN quality
						WHERE (feature_of_interest_id = '$foi_id') AND (quality_value='no') AND (time_stamp >= '$start_date'::date)
						AND (offering_id = '$offering1'))
						INTERSECT
						(SELECT time_stamp :: timestamp without time zone, offering_id, numeric_value
						FROM observation NATURAL JOIN quality
						WHERE (feature_of_interest_id = '$foi_id') AND (quality_value='no') AND (time_stamp <= '$end_date'::date)
						AND (offering_id = '$offering1')) ORDER BY time_stamp ASC");
				return pg_fetch_all($result);
				break;
					
			case 5:
				$offering1 = func_get_arg(3);
				$offering2 = func_get_arg(4);
				$result = pg_query($conn, "(SELECT time_stamp :: timestamp without time zone, offering_id, numeric_value
						FROM observation NATURAL JOIN quality
						WHERE (feature_of_interest_id = '$foi_id') AND (quality_value='no') AND (time_stamp >= '$start_date'::date)
						AND ((offering_id = '$offering1') OR (offering_id = '$offering2')))
						INTERSECT
						(SELECT time_stamp :: timestamp without time zone, offering_id, numeric_value
						FROM observation NATURAL JOIN quality
						WHERE (feature_of_interest_id = '$foi_id') AND (quality_value='no') AND (time_stamp <= '$end_date'::date)
						AND ((offering_id = '$offering1') OR (offering_id = '$offering2'))) ORDER BY time_stamp, offering_id ASC");
				return pg_fetch_all($result);
				break;

			case 6:
				$offering1 = func_get_arg(3);
				$offering2 = func_get_arg(4);
				$offering3 = func_get_arg(5);
				$result = pg_query($conn, "(SELECT time_stamp :: timestamp without time zone, offering_id, numeric_value
						FROM observation NATURAL JOIN quality
						WHERE (feature_of_interest_id = '$foi_id') AND (quality_value='no') AND (time_stamp >= '$start_date'::date)
						AND ((offering_id = '$offering1')  OR (offering_id = '$offering2') OR (offering_id = '$offering3')))
						INTERSECT
						(SELECT time_stamp :: timestamp without time zone, offering_id, numeric_value
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
		$result = pg_query($conn, "SELECT time_stamp, offering_id, numeric_value, unit 
				FROM observation NATURAL JOIN phenomenon
				WHERE (feature_of_interest_id = '$foi_id') AND (time_stamp = (
															SELECT max(time_stamp :: timestamp without time zone) 
															FROM observation 
															WHERE feature_of_interest_id ='$foi_id')) ORDER BY offering_id");
		return pg_fetch_all($result);
	}
}

/* Get the timestamp of one feature_of_interest */
function getTimeStamp($foi_id, $start_date, $end_date){
	global $conn;
	if (isset ($foi_id) AND isset ($start_date) AND isset($end_date)){
		$result = pg_query($conn, "SELECT distinct time_stamp :: timestamp without time zone
									FROM observation
									WHERE (feature_of_interest_id ='$foi_id') AND (time_stamp >= '$start_date'::date) AND (time_stamp <= '$end_date'::date) ORDER BY time_stamp");
		return pg_fetch_all($result);	
	}
}

function arrayToJSON($cols, $rows){
	$table = json_encode(array(
			'cols' => $cols,
			'rows' => $rows),
			JSON_NUMERIC_CHECK);
	return $table;
}
?>