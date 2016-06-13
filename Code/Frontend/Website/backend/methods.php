<?php

//retrieve related news from yahoo
function getNews($ticker) {
	$request_url = "http://finance.yahoo.com/rss/headline?s=".$ticker;
	$xml = simplexml_load_file($request_url) or die("feed not loaded");
	$titleArray = array();
	$tempTitles = "";
		
	foreach($xml->channel->item as $item) {
		$title = $item->title;	
				
		if(avoidRedundancy($title, $titleArray)=="go"){
			$tempTitles .= $title.",tom,";
			$titleArray = explode(",tom,", $tempTitles);
			echo "<li><a href=" . $item->link ." target='_blank'>" . $item->title . "</a><br>".$item->pubDate."</li>";	
		} else{
		}
	}
}

//trim the Date to desired format
function trimDate($orgDate) {
	$Po = strpos($orgDate, '201');
	return substr($orgDate,0,$Po+5);
}

//redundancy removal function
function avoidRedundancy($title, $titleArray) {
	if(!in_array($title, $titleArray)){
		return "go";
	}else{
		return "stop";}
}

//output the chart html code
function getChart($ticker) {
	// $ticker = "GOOG";
	$range = "1d";
	$width = 750;
	$chart_url = "http://ichart.yahoo.com/z?s=".$ticker."&t=".$range."&q=c&l=on&z=l";
	echo '<img id="beChanged" src="'.$chart_url.'" style="width:'.$width.'px">';					
}

//output the chart range menu
function chartRangeMenu(){
	echo 	
	'<button class="range" value="1d">1 day</button>
	<button class="range" value="5d">5 days</button>
	<button class="range" value="3m">3 months</button>
	<button class="range" value="6m">6 months</button>
	<button class="range" value="2y">2 years</button>
	<button class="range" value="5y">5 years</button>';
}

// ticker validation
function validateTicker($ticker){
	if(empty($ticker)){
		return false;
	}else{
		$url = "http://download.finance.yahoo.com/d/quotes.csv?s=".$ticker."&f=v&e=.csv";
		
		$file = fopen($url, "r");
		while(!feof($file)){
			$string = fgets($file, 50);
		}
		fclose($file);
			
		if(strpos($string,"A") == 2){
			return false;
		}else{
			return true;
		}
	}
}

?>	



