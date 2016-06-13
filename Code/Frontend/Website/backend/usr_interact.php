<?php

include_once 'DBConfig.php';

$con = mysqli_connect($server,$usr,$pwd,$db);

$usr_name = $_GET['usr'];
$stock_symbol = $_GET['symbol'];
$action = $_GET['action'];
$stock_num = $_GET['amount'];

//$num_buy = $_GET['numBuy'];
//$num_sell = $_GET['numSell'];

$sql_money = "SELECT money FROM User WHERE name = '".$usr_name."'";
$sql_price = "SELECT Price FROM StockRealtime WHERE Symbol = '".$stock_symbol."' AND Time IN (SELECT MAX(Time) FROM StockRealtime)";
$sql_amount = "SELECT amount FROM UserStock WHERE stockName = '".$stock_symbol."'";

$result = mysqli_query($con, $sql_money);
while($row = $result->fetch_assoc()){
	$usr_money = $row["money"];
}

$result = mysqli_query($con, $sql_price);
while($row = $result->fetch_assoc()){
	$stock_price = $row["Price"];
}

$result = mysqli_query($con, $sql_amount);
while($row = $result->fetch_assoc()){
	$usr_amount = $row["amount"];
}


if ($action == 'buy') 
{
    $remain = $usr_money - $stock_price * $stock_num;
	//echo $usr_money;
    if ($remain < 0)
    {
        echo "Insufficient Balance!";
    } 
    else
    {
        $usr_amount = $usr_amount + $stock_num;
		date_default_timezone_set('America/New_York');
        $curr_time = date('Y-m-d H-i-s', time());

        $sql_update1 = "UPDATE User SET money = ".$remain." WHERE name = '".$usr_name."'";
        $sql_update2 = "UPDATE UserStock SET amount = ".$usr_amount." WHERE stockName = '".$stock_symbol."' AND name = '".$usr_name."'";
        $sql_insert = "INSERT INTO TradeRecord VALUES ('".$usr_name."', '".$stock_symbol."', ".(-$stock_num).", '".$curr_time."', 0)";

        mysqli_query($con, $sql_update1);
        mysqli_query($con, $sql_update2);
        mysqli_query($con, $sql_insert);

        echo "ok";
    }
} 
else if ($action == 'sell')
{
    $usr_amount = $usr_amount - $stock_num;
    if ($usr_amount < 0) {
        echo "Insufficient Holdings!";
    }
    else
    {
        $remain = $usr_money + $stock_price * $stock_num;
		date_default_timezone_set('America/New_York');
        $curr_time = date('Y-m-d H-i-s', time());

        $sql_update1 = "UPDATE User SET money = ".$remain." WHERE name = '".$usr_name."'";
        $sql_update2 = "UPDATE UserStock SET amount = ".$usr_amount." WHERE stockName = '".$stock_symbol."' AND name = '".$usr_name."'";
        $sql_insert = "INSERT INTO TradeRecord VALUES ('".$usr_name."', '".$stock_symbol."', ".$stock_num.", '".$curr_time."', 0)";

        mysqli_query($con, $sql_update1);
        mysqli_query($con, $sql_update2);
        mysqli_query($con, $sql_insert);

        echo "ok";

    }
} 

mysqli_close($con);
?>
