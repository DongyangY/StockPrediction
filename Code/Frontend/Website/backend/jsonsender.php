<?php

@$id=$_GET['id'];

header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');

include_once('DBConfig.php');

$con=mysqli_connect($server,$usr,$pwd,$db);

if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//$id = 0;

$resultArray = array();
$tempArray = array();

$dataLength = 200;
$dataLength1 = 20;

$sql = array();

switch($id){

case 0:
	$sql[1] = "SELECT * FROM StockHistorical WHERE Symbol = 'GOOG' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[2] = "SELECT * FROM SPredictionBayesian WHERE Symbol = 'GOOG' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[3] = "SELECT * FROM SPredictionSTS WHERE Symbol = 'GOOG' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[4] = "SELECT * FROM PredictionSVM WHERE Symbol = 'GOOG' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[5] = "SELECT * FROM PredictionANN WHERE Symbol = 'GOOG' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[6] = "SELECT * FROM LPredictionBayesian WHERE Symbol = 'GOOG' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[7] = "SELECT * FROM LPredictionSTS WHERE Symbol = 'GOOG' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[8] = "SELECT * FROM PredictionMACD WHERE Symbol = 'GOOG' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[9] = "select * from SPredictionBayesian where Symbol = 'GOOG' order by Date desc limit 1";
	$sql[10] = "select * from SPredictionSTS where Symbol = 'GOOG' order by Date desc limit 1";
	$sql[11] = "select * from PredictionSVM where Symbol = 'GOOG' AND Date = 'predict day 1'";
	$sql[12] = "select * from PredictionSVM where Symbol = 'GOOG' AND Date = 'predict day 2'";
	$sql[13] = "select * from PredictionANN where Symbol = 'GOOG' AND Date = 'predict day 1'";
	$sql[14] = "select * from PredictionANN where Symbol = 'GOOG' AND Date = 'predict day 2'";
	$sql[15] = "select Symbol, avg(RelativeDifference) as avg from SPredictionBayesian where Symbol = 'GOOG'";
	$sql[16] = "select Symbol, avg(RelativeDifference) as avg from SPredictionSTS where Symbol = 'GOOG'";
	$sql[17] = "select Symbol, avg(RelativeDifference) as avg from PredictionSVM where Symbol = 'GOOG' AND Date LIKE '%-%-%'";
	$sql[18] = "select Symbol, avg(RelativeDifference) as avg from PredictionANN where Symbol = 'GOOG' AND Date LIKE '%-%-%'";
  break;

case 1:
   $sql[1] = "SELECT * FROM StockHistorical WHERE Symbol = 'YHOO' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[2] = "SELECT * FROM SPredictionBayesian WHERE Symbol = 'YHOO' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[3] = "SELECT * FROM SPredictionSTS WHERE Symbol = 'YHOO' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[4] = "SELECT * FROM PredictionSVM WHERE Symbol = 'YHOO' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[5] = "SELECT * FROM PredictionANN WHERE Symbol = 'YHOO' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[6] = "SELECT * FROM LPredictionBayesian WHERE Symbol = 'YHOO' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[7] = "SELECT * FROM LPredictionSTS WHERE Symbol = 'YHOO' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[8] = "SELECT * FROM PredictionMACD WHERE Symbol = 'YHOO' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[9] = "select * from SPredictionBayesian where Symbol = 'YHOO' order by Date desc limit 1";
	$sql[10] = "select * from SPredictionSTS where Symbol = 'YHOO' order by Date desc limit 1";
	$sql[11] = "select * from PredictionSVM where Symbol = 'YHOO' AND Date = 'predict day 1'";
	$sql[12] = "select * from PredictionSVM where Symbol = 'YHOO' AND Date = 'predict day 2'";
	$sql[13] = "select * from PredictionANN where Symbol = 'YHOO' AND Date = 'predict day 1'";
	$sql[14] = "select * from PredictionANN where Symbol = 'YHOO' AND Date = 'predict day 2'";
	$sql[15] = "select Symbol, avg(RelativeDifference) as avg from SPredictionBayesian where Symbol = 'YHOO'";
	$sql[16] = "select Symbol, avg(RelativeDifference) as avg from SPredictionSTS where Symbol = 'YHOO'";
	$sql[17] = "select Symbol, avg(RelativeDifference) as avg from PredictionSVM where Symbol = 'YHOO' AND Date LIKE '%-%-%'";
	$sql[18] = "select Symbol, avg(RelativeDifference) as avg from PredictionANN where Symbol = 'YHOO' AND Date LIKE '%-%-%'";
  break;

case 2:
	$sql[1] = "SELECT * FROM StockHistorical WHERE Symbol = 'AAPL' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[2] = "SELECT * FROM SPredictionBayesian WHERE Symbol = 'AAPL' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[3] = "SELECT * FROM SPredictionSTS WHERE Symbol = 'AAPL' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[4] = "SELECT * FROM PredictionSVM WHERE Symbol = 'AAPL' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[5] = "SELECT * FROM PredictionANN WHERE Symbol = 'AAPL' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[6] = "SELECT * FROM LPredictionBayesian WHERE Symbol = 'AAPL' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[7] = "SELECT * FROM LPredictionSTS WHERE Symbol = 'AAPL' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[8] = "SELECT * FROM PredictionMACD WHERE Symbol = 'AAPL' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[9] = "select * from SPredictionBayesian where Symbol = 'AAPL' order by Date desc limit 1";
	$sql[10] = "select * from SPredictionSTS where Symbol = 'AAPL' order by Date desc limit 1";
	$sql[11] = "select * from PredictionSVM where Symbol = 'AAPL' AND Date = 'predict day 1'";
	$sql[12] = "select * from PredictionSVM where Symbol = 'AAPL' AND Date = 'predict day 2'";
	$sql[13] = "select * from PredictionANN where Symbol = 'AAPL' AND Date = 'predict day 1'";
	$sql[14] = "select * from PredictionANN where Symbol = 'AAPL' AND Date = 'predict day 2'";
	$sql[15] = "select Symbol, avg(RelativeDifference) as avg from SPredictionBayesian where Symbol = 'AAPL'";
	$sql[16] = "select Symbol, avg(RelativeDifference) as avg from SPredictionSTS where Symbol = 'AAPL'";
	$sql[17] = "select Symbol, avg(RelativeDifference) as avg from PredictionSVM where Symbol = 'AAPL' AND Date LIKE '%-%-%'";
	$sql[18] = "select Symbol, avg(RelativeDifference) as avg from PredictionANN where Symbol = 'AAPL' AND Date LIKE '%-%-%'";
  break;

case 3:
	$sql[1] = "SELECT * FROM StockHistorical WHERE Symbol = 'FB' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[2] = "SELECT * FROM SPredictionBayesian WHERE Symbol = 'FB' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[3] = "SELECT * FROM SPredictionSTS WHERE Symbol = 'FB' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[4] = "SELECT * FROM PredictionSVM WHERE Symbol = 'FB' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[5] = "SELECT * FROM PredictionANN WHERE Symbol = 'FB' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[6] = "SELECT * FROM LPredictionBayesian WHERE Symbol = 'FB' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[7] = "SELECT * FROM LPredictionSTS WHERE Symbol = 'FB' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[8] = "SELECT * FROM PredictionMACD WHERE Symbol = 'FB' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[9] = "select * from SPredictionBayesian where Symbol = 'FB' order by Date desc limit 1";
	$sql[10] = "select * from SPredictionSTS where Symbol = 'FB' order by Date desc limit 1";
	$sql[11] = "select * from PredictionSVM where Symbol = 'FB' AND Date = 'predict day 1'";
	$sql[12] = "select * from PredictionSVM where Symbol = 'FB' AND Date = 'predict day 2'";
	$sql[13] = "select * from PredictionANN where Symbol = 'FB' AND Date = 'predict day 1'";
	$sql[14] = "select * from PredictionANN where Symbol = 'FB' AND Date = 'predict day 2'";
	$sql[15] = "select Symbol, avg(RelativeDifference) as avg from SPredictionBayesian where Symbol = 'FB'";
	$sql[16] = "select Symbol, avg(RelativeDifference) as avg from SPredictionSTS where Symbol = 'FB'";
	$sql[17] = "select Symbol, avg(RelativeDifference) as avg from PredictionSVM where Symbol = 'FB' AND Date LIKE '%-%-%'";
	$sql[18] = "select Symbol, avg(RelativeDifference) as avg from PredictionANN where Symbol = 'FB' AND Date LIKE '%-%-%'";
  break;

case 4:
  $sql[1] = "SELECT * FROM StockHistorical WHERE Symbol = 'MSFT' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[2] = "SELECT * FROM SPredictionBayesian WHERE Symbol = 'MSFT' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[3] = "SELECT * FROM SPredictionSTS WHERE Symbol = 'MSFT' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[4] = "SELECT * FROM PredictionSVM WHERE Symbol = 'MSFT' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[5] = "SELECT * FROM PredictionANN WHERE Symbol = 'MSFT' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[6] = "SELECT * FROM LPredictionBayesian WHERE Symbol = 'MSFT' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[7] = "SELECT * FROM LPredictionSTS WHERE Symbol = 'MSFT' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[8] = "SELECT * FROM PredictionMACD WHERE Symbol = 'MSFT' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[9] = "select * from SPredictionBayesian where Symbol = 'MSFT' order by Date desc limit 1";
	$sql[10] = "select * from SPredictionSTS where Symbol = 'MSFT' order by Date desc limit 1";
	$sql[11] = "select * from PredictionSVM where Symbol = 'MSFT' AND Date = 'predict day 1'";
	$sql[12] = "select * from PredictionSVM where Symbol = 'MSFT' AND Date = 'predict day 2'";
	$sql[13] = "select * from PredictionANN where Symbol = 'MSFT' AND Date = 'predict day 1'";
	$sql[14] = "select * from PredictionANN where Symbol = 'MSFT' AND Date = 'predict day 2'";
	$sql[15] = "select Symbol, avg(RelativeDifference) as avg from SPredictionBayesian where Symbol = 'MSFT'";
	$sql[16] = "select Symbol, avg(RelativeDifference) as avg from SPredictionSTS where Symbol = 'MSFT'";
	$sql[17] = "select Symbol, avg(RelativeDifference) as avg from PredictionSVM where Symbol = 'MSFT' AND Date LIKE '%-%-%'";
	$sql[18] = "select Symbol, avg(RelativeDifference) as avg from PredictionANN where Symbol = 'MSFT' AND Date LIKE '%-%-%'";
  break;

case 5:
	$sql[1] = "SELECT * FROM StockHistorical WHERE Symbol = 'AMZN' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[2] = "SELECT * FROM SPredictionBayesian WHERE Symbol = 'AMZN' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[3] = "SELECT * FROM SPredictionSTS WHERE Symbol = 'AMZN' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[4] = "SELECT * FROM PredictionSVM WHERE Symbol = 'AMZN' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[5] = "SELECT * FROM PredictionANN WHERE Symbol = 'AMZN' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[6] = "SELECT * FROM LPredictionBayesian WHERE Symbol = 'AMZN' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[7] = "SELECT * FROM LPredictionSTS WHERE Symbol = 'AMZN' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[8] = "SELECT * FROM PredictionMACD WHERE Symbol = 'AMZN' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[9] = "select * from SPredictionBayesian where Symbol = 'AMZN' order by Date desc limit 1";
	$sql[10] = "select * from SPredictionSTS where Symbol = 'AMZN' order by Date desc limit 1";
	$sql[11] = "select * from PredictionSVM where Symbol = 'AMZN' AND Date = 'predict day 1'";
	$sql[12] = "select * from PredictionSVM where Symbol = 'AMZN' AND Date = 'predict day 2'";
	$sql[13] = "select * from PredictionANN where Symbol = 'AMZN' AND Date = 'predict day 1'";
	$sql[14] = "select * from PredictionANN where Symbol = 'AMZN' AND Date = 'predict day 2'";
	$sql[15] = "select Symbol, avg(RelativeDifference) as avg from SPredictionBayesian where Symbol = 'AMZN'";
	$sql[16] = "select Symbol, avg(RelativeDifference) as avg from SPredictionSTS where Symbol = 'AMZN'";
	$sql[17] = "select Symbol, avg(RelativeDifference) as avg from PredictionSVM where Symbol = 'AMZN' AND Date LIKE '%-%-%'";
	$sql[18] = "select Symbol, avg(RelativeDifference) as avg from PredictionANN where Symbol = 'AMZN' AND Date LIKE '%-%-%'";
  break;

case 6:
	$sql[1] = "SELECT * FROM StockHistorical WHERE Symbol = 'SNE' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[2] = "SELECT * FROM SPredictionBayesian WHERE Symbol = 'SNE' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[3] = "SELECT * FROM SPredictionSTS WHERE Symbol = 'SNE' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[4] = "SELECT * FROM PredictionSVM WHERE Symbol = 'SNE' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[5] = "SELECT * FROM PredictionANN WHERE Symbol = 'SNE' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[6] = "SELECT * FROM LPredictionBayesian WHERE Symbol = 'SNE' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[7] = "SELECT * FROM LPredictionSTS WHERE Symbol = 'SNE' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[8] = "SELECT * FROM PredictionMACD WHERE Symbol = 'SNE' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[9] = "select * from SPredictionBayesian where Symbol = 'SNE' order by Date desc limit 1";
	$sql[10] = "select * from SPredictionSTS where Symbol = 'SNE' order by Date desc limit 1";
	$sql[11] = "select * from PredictionSVM where Symbol = 'SNE' AND Date = 'predict day 1'";
	$sql[12] = "select * from PredictionSVM where Symbol = 'SNE' AND Date = 'predict day 2'";
	$sql[13] = "select * from PredictionANN where Symbol = 'SNE' AND Date = 'predict day 1'";
	$sql[14] = "select * from PredictionANN where Symbol = 'SNE' AND Date = 'predict day 2'";
	$sql[15] = "select Symbol, avg(RelativeDifference) as avg from SPredictionBayesian where Symbol = 'SNE'";
	$sql[16] = "select Symbol, avg(RelativeDifference) as avg from SPredictionSTS where Symbol = 'SNE'";
	$sql[17] = "select Symbol, avg(RelativeDifference) as avg from PredictionSVM where Symbol = 'SNE' AND Date LIKE '%-%-%'";
	$sql[18] = "select Symbol, avg(RelativeDifference) as avg from PredictionANN where Symbol = 'SNE' AND Date LIKE '%-%-%'";
  break;

case 7:
	$sql[1] = "SELECT * FROM StockHistorical WHERE Symbol = 'WMT' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[2] = "SELECT * FROM SPredictionBayesian WHERE Symbol = 'WMT' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[3] = "SELECT * FROM SPredictionSTS WHERE Symbol = 'WMT' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[4] = "SELECT * FROM PredictionSVM WHERE Symbol = 'WMT' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[5] = "SELECT * FROM PredictionANN WHERE Symbol = 'WMT' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[6] = "SELECT * FROM LPredictionBayesian WHERE Symbol = 'WMT' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[7] = "SELECT * FROM LPredictionSTS WHERE Symbol = 'WMT' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[8] = "SELECT * FROM PredictionMACD WHERE Symbol = 'WMT' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[9] = "select * from SPredictionBayesian where Symbol = 'WMT' order by Date desc limit 1";
	$sql[10] = "select * from SPredictionSTS where Symbol = 'WMT' order by Date desc limit 1";
	$sql[11] = "select * from PredictionSVM where Symbol = 'WMT' AND Date = 'predict day 1'";
	$sql[12] = "select * from PredictionSVM where Symbol = 'WMT' AND Date = 'predict day 2'";
	$sql[13] = "select * from PredictionANN where Symbol = 'WMT' AND Date = 'predict day 1'";
	$sql[14] = "select * from PredictionANN where Symbol = 'WMT' AND Date = 'predict day 2'";
	$sql[15] = "select Symbol, avg(RelativeDifference) as avg from SPredictionBayesian where Symbol = 'WMT'";
	$sql[16] = "select Symbol, avg(RelativeDifference) as avg from SPredictionSTS where Symbol = 'WMT'";
	$sql[17] = "select Symbol, avg(RelativeDifference) as avg from PredictionSVM where Symbol = 'WMT' AND Date LIKE '%-%-%'";
	$sql[18] = "select Symbol, avg(RelativeDifference) as avg from PredictionANN where Symbol = 'WMT' AND Date LIKE '%-%-%'";
  break;

case 8:
	$sql[1] = "SELECT * FROM StockHistorical WHERE Symbol = 'CAJ' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[2] = "SELECT * FROM SPredictionBayesian WHERE Symbol = 'CAJ' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[3] = "SELECT * FROM SPredictionSTS WHERE Symbol = 'CAJ' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[4] = "SELECT * FROM PredictionSVM WHERE Symbol = 'CAJ' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[5] = "SELECT * FROM PredictionANN WHERE Symbol = 'CAJ' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[6] = "SELECT * FROM LPredictionBayesian WHERE Symbol = 'CAJ' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[7] = "SELECT * FROM LPredictionSTS WHERE Symbol = 'CAJ' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[8] = "SELECT * FROM PredictionMACD WHERE Symbol = 'CAJ' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[9] = "select * from SPredictionBayesian where Symbol = 'CAJ' order by Date desc limit 1";
	$sql[10] = "select * from SPredictionSTS where Symbol = 'CAJ' order by Date desc limit 1";
	$sql[11] = "select * from PredictionSVM where Symbol = 'CAJ' AND Date = 'predict day 1'";
	$sql[12] = "select * from PredictionSVM where Symbol = 'CAJ' AND Date = 'predict day 2'";
	$sql[13] = "select * from PredictionANN where Symbol = 'CAJ' AND Date = 'predict day 1'";
	$sql[14] = "select * from PredictionANN where Symbol = 'CAJ' AND Date = 'predict day 2'";
	$sql[15] = "select Symbol, avg(RelativeDifference) as avg from SPredictionBayesian where Symbol = 'CAJ'";
	$sql[16] = "select Symbol, avg(RelativeDifference) as avg from SPredictionSTS where Symbol = 'CAJ'";
	$sql[17] = "select Symbol, avg(RelativeDifference) as avg from PredictionSVM where Symbol = 'CAJ' AND Date LIKE '%-%-%'";
	$sql[18] = "select Symbol, avg(RelativeDifference) as avg from PredictionANN where Symbol = 'CAJ' AND Date LIKE '%-%-%'";
  break;

case 9:
	$sql[1] = "SELECT * FROM StockHistorical WHERE Symbol = 'TWTR' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[2] = "SELECT * FROM SPredictionBayesian WHERE Symbol = 'TWTR' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[3] = "SELECT * FROM SPredictionSTS WHERE Symbol = 'TWTR' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[4] = "SELECT * FROM PredictionSVM WHERE Symbol = 'TWTR' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[5] = "SELECT * FROM PredictionANN WHERE Symbol = 'TWTR' AND Date LIKE '%-%-%' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[6] = "SELECT * FROM LPredictionBayesian WHERE Symbol = 'TWTR' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[7] = "SELECT * FROM LPredictionSTS WHERE Symbol = 'TWTR' ORDER BY Position DESC LIMIT ".$dataLength1;
	$sql[8] = "SELECT * FROM PredictionMACD WHERE Symbol = 'TWTR' ORDER BY Date DESC LIMIT ".$dataLength;
	$sql[9] = "select * from SPredictionBayesian where Symbol = 'TWTR' order by Date desc limit 1";
	$sql[10] = "select * from SPredictionSTS where Symbol = 'TWTR' order by Date desc limit 1";
	$sql[11] = "select * from PredictionSVM where Symbol = 'TWTR' AND Date = 'predict day 1'";
	$sql[12] = "select * from PredictionSVM where Symbol = 'TWTR' AND Date = 'predict day 2'";
	$sql[13] = "select * from PredictionANN where Symbol = 'TWTR' AND Date = 'predict day 1'";
	$sql[14] = "select * from PredictionANN where Symbol = 'TWTR' AND Date = 'predict day 2'";
	$sql[15] = "select Symbol, avg(RelativeDifference) as avg from SPredictionBayesian where Symbol = 'TWTR'";
	$sql[16] = "select Symbol, avg(RelativeDifference) as avg from SPredictionSTS where Symbol = 'TWTR'";
	$sql[17] = "select Symbol, avg(RelativeDifference) as avg from PredictionSVM where Symbol = 'TWTR' AND Date LIKE '%-%-%'";
	$sql[18] = "select Symbol, avg(RelativeDifference) as avg from PredictionANN where Symbol = 'TWTR' AND Date LIKE '%-%-%'";
  break;

}

for($i = 1; $i <= 18; $i++) {
if ($result = mysqli_query($con, $sql[$i])){
    
    while($row = $result->fetch_object()){
        $tempArray = $row;
        array_push($resultArray, $tempArray);
    }
    
}
}

echo json_encode($resultArray);

@mysqli_close($result);
@mysqli_close($con);

?>