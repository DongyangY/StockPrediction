<?php
	//stock history
	
    $BASE_URL = "http://query.yahooapis.com/v1/public/yql";

    $yql_query = 'select * from yahoo.finance.historicaldata where symbol = "YHOO" and startDate = "2014-11-08" and endDate = "2015-02-08"';
    $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json" . "&env=store://datatables.org/alltableswithkeys";

    // Make call with cURL
    $session = curl_init($yql_query_url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
    $json = curl_exec($session);
	
	//print_r($json);
	
    // Convert JSON to PHP object
    $phpObj =  json_decode($json);
    if(!is_null($phpObj->query->results)){
		foreach($phpObj->query->results->quote as $quote){
			echo "Symbol: " . $quote->Symbol . "Date: " . $quote->Date . "Open: " . $quote->Open . "<br>";
		}
	} 

?>