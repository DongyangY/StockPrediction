<?php

@$id = $_GET['id'];

header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');

include_once('DBConfig.php');

$con = mysqli_connect($server,$usr,$pwd,$db);

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$short_term_total = 200;
$long_term_total = 20;
$stock_name = array("GOOG", "YHOO", "AAPL", "FB", "MSFT", "AMZN", "SNE", "WMT", "CAJ", "TWTR");

$sql = array("", "SELECT * FROM StockHistorical WHERE Symbol = '".$stock_name[$id]."' ORDER BY Date DESC LIMIT ".$short_term_total,
				 "SELECT * FROM SPredictionBayesian WHERE Symbol = '".$stock_name[$id]."' ORDER BY Date DESC LIMIT ".$short_term_total,
				 "SELECT * FROM SPredictionSTS WHERE Symbol = '".$stock_name[$id]."' ORDER BY Date DESC LIMIT ".$short_term_total,
				 "SELECT * FROM PredictionSVM WHERE Symbol = '".$stock_name[$id]."' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$short_term_total,
				 "SELECT * FROM PredictionANN WHERE Symbol = '".$stock_name[$id]."' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$short_term_total,
				 "SELECT * FROM LPredictionBayesian WHERE Symbol = '".$stock_name[$id]."' ORDER BY Position DESC LIMIT ".$long_term_total,
				 "SELECT * FROM LPredictionSTS WHERE Symbol = '".$stock_name[$id]."' ORDER BY Position DESC LIMIT ".$long_term_total,
				 "SELECT * FROM PredictionMACD WHERE Symbol = '".$stock_name[$id]."' ORDER BY Date DESC LIMIT ".$short_term_total,
				 "SELECT * FROM SPredictionBayesian WHERE Symbol = '".$stock_name[$id]."' ORDER BY Date DESC LIMIT 1",
				 "SELECT * FROM SPredictionSTS WHERE Symbol = '".$stock_name[$id]."' ORDER BY Date DESC LIMIT 1",
				 "SELECT * FROM PredictionSVM WHERE Symbol = '".$stock_name[$id]."' AND Date = 'predict day 1'",
				 "SELECT * FROM PredictionSVM WHERE Symbol = '".$stock_name[$id]."' AND Date = 'predict day 2'",
				 "SELECT * FROM PredictionANN WHERE Symbol = '".$stock_name[$id]."' AND Date = 'predict day 1'",
				 "SELECT * FROM PredictionANN WHERE Symbol = '".$stock_name[$id]."' AND Date = 'predict day 2'",
				 "SELECT Symbol, AVG(RelativeDifference) AS avg FROM SPredictionBayesian WHERE Symbol = '".$stock_name[$id]."'",
				 "SELECT Symbol, AVG(RelativeDifference) AS avg FROM SPredictionSTS WHERE Symbol = '".$stock_name[$id]."'",
				 "SELECT Symbol, AVG(RelativeDifference) AS avg FROM PredictionSVM WHERE Symbol = '".$stock_name[$id]."' AND Date LIKE '%-%-%'",
				 "SELECT Symbol, AVG(RelativeDifference) AS avg FROM PredictionANN WHERE Symbol = '".$stock_name[$id]."' AND Date LIKE '%-%-%'");

$result_arr = array();
$temp_arr = array();

for($i = 1; $i <= 18; $i++) {
	if ($result = mysqli_query($con, $sql[$i])) {    
  		while($row = $result->fetch_object()) {
        	$temp_arr = $row;
        	array_push($result_arr, $temp_arr);
    	} 
	}
}

echo json_encode($result_arr);

@mysqli_close($result);
@mysqli_close($con);

?>