<?php include_once 'backend/session.php' ?>
<?php include_once 'backend/DBConfig.php' ?>

<!DOCTYPE HTML>
<!--
	Ion by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Home</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>        
        <script src="js/logoff.js"></script>     
    	<script src="js/management.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['annotationchart']}]}"></script>
        <script src="js/AIChart.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
            
            <link href='http://fonts.googleapis.com/css?family=Varela+Round|Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
            
		</noscript>


	</head>
	<body id="top">

		<!-- Header -->
			<header id="header" class="skel-layers-fixed">
				<h1><a href="#">iStock</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="forecast.php">Forecast</a></li>
                        <li><a href="news.php">News</a></li>
						<li><a href="vse.php">VSE</a></li>
                        <?php if(isset($_SESSION['usr'])) { ?>
                        <li><a href="#" class="button special" id = "logoff">Log Off</a></li>
                        <?php } else { ?> 
						<li><a href="login.php?action=login" class="button special">Log In</a></li>
                        <?php } ?>
						
					</ul>
				</nav>
			</header>

		<!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
					<h2>Manage Your Account</h2>
					<p class="session_name"><?php echo $_SESSION['usr']; ?></p>
				</header>
				<div class="container">
                	<div class="row">
                	<div class="3u">
                	
                    <h3>Trade</h3>  
                    <p></p>            	
                		<form>
                    		<div class="12u$">
								<div class="select-wrapper">
									<select id="symbol">
										<option value="0">GOOG</option>
										<option value="1">YHOO</option>
						    			<option value="2">AAPL</option>
							    		<option value="3">FB</option>
                            	        <option value="4">MSFT</option>
                                        <option value="5">AMZN</option>
                                        <option value="6">SNE</option>
                                    	<option value="7">WMT</option>
                                    	<option value="8">CAJ</option>
                                    	<option value="9">TWTR</option>
									</select>
								</div>                            
							</div>
                            <p></p>    
                            <div class="12u 12u$(xsmall)">
								<input type="text" name="amount" id="amount" value="" placeholder="Amount" />
							</div> 
                            <p></p>
                            
                            <div class="8u 12u$(small)">
								<input type="radio" id="action-buy" name="action" checked>
								<label for="action-buy">Buy</label>
						    </div>
							<div class="8u 12$(small)">
								<input type="radio" id="action-sell" name="action">
								<label for="action-sell">Sell</label> 
                            </div>  
                            <p></p>
                            <div class="12u$ align-right">
								<ul class="actions">
									<li><input type="submit" value="Go" class="special" /></li>
									</ul>
							</div>                                                    	
                    	</form>
                    
                    </div>
                    
                    <div class="8u">
                    
                    	<h3>AI History</h3>
                    <div id='chart_div5' style='width: 850px; height: 500px;'></div>
                    
                    </div>
                    
                    </div>
                
                    
                    
                    <section>
                    		<div class="table-wrapper">
                            <hr />
								<table>
                                	<h3>Balance</h3>
									<thead>
										<tr>
											<th>User</th>
											<th>Balance</th>
                                            <th>Total</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
									    
										$total = 0.0;
										
										$con = new mysqli($server, $usr, $pwd, $db);

										if ($con->connect_error) die("Connection failed: ".$con->connect_error);
										
										$result = $con->query("select * from StockRealtime order by Time desc limit 10");
										
										while($row = $result->fetch_assoc()){
											
											$result_i = $con->query("select * from UserStock where name = '".$_SESSION['usr']."' AND stockName = '".$row["Symbol"]."'");
											while($row_i = $result_i->fetch_assoc()){
											  $total += $row_i["amount"] * $row["Price"];
										    }
										}
										
										$result = $con->query("select * from User where name = '".$_SESSION['usr']."'");
										
										while($row = $result->fetch_assoc()){
											echo "<tr>";
											echo "<td>".$row["name"]."</td>";
											echo "<td>".$row["money"]."</td>";
											echo "<td>".($row["money"] + $total)."</td>";
										    echo "</tr>";
										}
										$con->close();		
							     	?>
									</tbody>
									<tfoot>
									</tfoot>
								</table>
							</div>
                            
							<div class="table-wrapper">
                             <hr />
								<table>
                                	<h3>Holdings</h3>
									<thead>
										<tr>
											<th>Symbol</th>
											<th>Holdings</th>
                                            <th>STS Suggestion</th>
                                            <th>Bayesian Suggestion</th>
                                            <th>SVM Suggestion</th>
                                            <th>ANN Suggestion</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
										$con = new mysqli($server, $usr, $pwd, $db);

										if ($con->connect_error) die("Connection failed: ".$con->connect_error);
										
										$STS_action = array();
										$result = $con->query("select * from SPredictionSTS order by Date desc limit 10");
										while($row = $result->fetch_assoc()){
											$STS_action[$row["Symbol"]] = $row["Action"];
										}
										
										$Bayesian_action = array();
										$result = $con->query("select * from SPredictionBayesian order by Date desc limit 10");
										while($row = $result->fetch_assoc()){
											$Bayesian_action[$row["Symbol"]] = $row["Action"];
										}
										
										$SVM_action = array();
										$result = $con->query("select * from PredictionSVM where Date = 'predict day 1'");
										while($row = $result->fetch_assoc()){
											$SVM_action[$row["Symbol"]] = $row["Action"];
										}	
										
										$ANN_action = array();
										$result = $con->query("select * from PredictionANN where Date = 'predict day 1'");
										while($row = $result->fetch_assoc()){
											$ANN_action[$row["Symbol"]] = $row["Action"];
										}					
										
										$result = $con->query("select * from UserStock where name = '".$_SESSION['usr']."'");
										
										while($row = $result->fetch_assoc()){
											echo "<tr>";
											echo "<td>".$row["stockName"]."</td>";
											echo "<td>".$row["amount"]."</td>";
											echo "<td>".$STS_action[$row["stockName"]]."</td>";
											echo "<td>".$Bayesian_action[$row["stockName"]]."</td>";
											echo "<td>".$SVM_action[$row["stockName"]]."</td>";
											echo "<td>".$ANN_action[$row["stockName"]]."</td>";
										    echo "</tr>";
										}
										$con->close();		
							     	?>
									</tbody>
									<tfoot>
									</tfoot>
								</table>
							</div>
                            
                            <div class="table-wrapper">
                            <hr />
								<table>
                                	<h3>Record</h3>
                                    <h4>Negative value means buy; positive means sell</h4>
									<thead>
										<tr>
											<th>Symbol</th>
											<th>Amount</th>
                                            <th>Time</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
										$con = new mysqli($server, $usr, $pwd, $db);

										if ($con->connect_error) die("Connection failed: ".$con->connect_error);
										
										$result = $con->query("select * from TradeRecord where name = '".$_SESSION['usr']."'");
										
										while($row = $result->fetch_assoc()){
											echo "<tr>";
											echo "<td>".$row["stockName"]."</td>";
											echo "<td>".$row["amount"]."</td>";
											echo "<td>".$row["time"]."</td>";
										    echo "</tr>";
										}
										$con->close();		
							     	?>
									</tbody>
									<tfoot>
									</tfoot>
								</table>
							</div>
					</section>
				</div>
			</section>		
			
		<!-- Footer -->
			<footer id="footer">
				<div class="container">
					
					<ul class="copyright">
						<li>&copy; iStock. All rights reserved.</li>
                        <li>Team: Software Engineering Group 7 2015</li>
						<li>Design: <a href="http://templated.co">TEMPLATED</a></li>
					</ul>
				</div>
			</footer>

	</body>
</html>