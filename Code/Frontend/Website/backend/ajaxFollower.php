<?php

include_once 'DBConfig.php';

if($_POST['action'] == "login") {
	
	$con = new mysqli($server, $usr, $pwd, $db);

	if ($con->connect_error) die("Connection failed: ".$con->connect_error);

	$result = $con->query("select password from User where name = '".$_POST['usr']."'");
	
	while($row = $result->fetch_assoc()){
		if($row["password"] == $_POST['pwd']){
			session_start();
			$_SESSION['usr'] = $_POST['usr'];
			echo "ok";
		}
		else echo "wrong";	
	}
	$con->close();
}

if($_POST['action'] == "signup") {
	
	$con = new mysqli($server, $usr, $pwd, $db);

	if ($con->connect_error) die("Connection failed: ".$con->connect_error);

	$result1 = $con->query("insert into User values ('".$_POST['usr']."', 1000000, '".$_POST['pwd']."')");
	$result2 = $con->query("insert into UserStock values ('".$_POST['usr']."', 'GOOG', 0)");
	$result3 = $con->query("insert into UserStock values ('".$_POST['usr']."', 'YHOO', 0)");
	$result4 = $con->query("insert into UserStock values ('".$_POST['usr']."', 'AAPL', 0)");
	$result5 = $con->query("insert into UserStock values ('".$_POST['usr']."', 'FB', 0)");
	$result6 = $con->query("insert into UserStock values ('".$_POST['usr']."', 'MSFT', 0)");
	$result2 = $con->query("insert into UserStock values ('".$_POST['usr']."', 'AMZN', 0)");
	$result3 = $con->query("insert into UserStock values ('".$_POST['usr']."', 'SNE', 0)");
	$result4 = $con->query("insert into UserStock values ('".$_POST['usr']."', 'WMT', 0)");
	$result5 = $con->query("insert into UserStock values ('".$_POST['usr']."', 'CAJ', 0)");
	$result6 = $con->query("insert into UserStock values ('".$_POST['usr']."', 'TWTR', 0)");
	
	
	if($result1 && $result2 && $result3 && $result4 && $result5 && $result1) {
		session_start();
		$_SESSION['usr'] = $_POST['usr'];
		echo "ok";
	}
	else "wrong";
	
	$con->close();
}

if($_GET['action'] == "logoff") {
	session_start();
	session_destroy();
}

?>