<?php

header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');

include_once('DBConfig.php');

$con=mysqli_connect($server,$usr,$pwd,$db);

if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


$resultArray = array();
$tempArray = array();

$dataLength = 200;

$sql = array();

$sql[1] = "SELECT * FROM AIBAY ORDER BY Date DESC LIMIT ".$dataLength;
$sql[2] = "SELECT * FROM AISTS ORDER BY Date DESC LIMIT ".$dataLength;
$sql[3] = "SELECT * FROM AISVM ORDER BY Date DESC LIMIT ".$dataLength;
$sql[4] = "SELECT * FROM AIANN ORDER BY Date DESC LIMIT ".$dataLength;

for($i = 1; $i <= 4; $i++) {
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