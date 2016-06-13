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
        <script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['annotationchart']}]}"></script>    
    	<script src="js/HistoricalStockChart.js"></script>
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
                        <? } ?>
						
					</ul>
				</nav>
			</header>

			
		<!-- Two -->
			<section id="two" class="wrapper style1">
				<header class="major">
					<h2>Short Term Prediction</h2>
					<p></p>
				</header>
				<div class="container">
                <div class="row">
                
                    <div class="8u">
                    <h3>Forecast History</h3>                 
    				<div id='chart_div1' style='width: 800px; height: 500px;'></div>
                    </div>
                    
                    <div class="4u">
                    
                    <h3>Select Stock</h3>
                    
                    <form>
                    	<div class="row uniform 50%">
                    		<div class="6u$">
							<div class="select-wrapper">
								<select name="category" id="category" onChange="select_symbol1(this)">
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
                    	</div>
                    	
                    </form>
                    
                    <hr />
                    
                             <div class="table-wrapper">
								<table id = "predict">
                                	<h3>Predict Next Two days</h3>
									<thead>
										<tr>
											<th>Symbol</th>
                                            <th>Strategy</th>
                                            <th>Day1</th>
											<th>Day2</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
										$con = new mysqli($server, $usr, $pwd, $db);

										if ($con->connect_error) die("Connection failed: ".$con->connect_error);
									
										$result = $con->query("select * from SPredictionBayesian where Symbol = 'GOOG' order by Date desc limit 1");
										
										while($row = $result->fetch_assoc()){
											echo "<tr>";
											echo "<td>".$row["Symbol"]."</td>";
											echo "<td>Bayesian</td>";
											echo "<td>".$row["ClosePriceTarget1"]."</td>";
											echo "<td>".$row["ClosePriceTarget2"]."</td>";
										    echo "</tr>";
										}
										
										$result = $con->query("select * from SPredictionSTS where Symbol = 'GOOG' order by Date desc limit 1");
										
										while($row = $result->fetch_assoc()){
											echo "<tr>";
											echo "<td>".$row["Symbol"]."</td>";
											echo "<td>STS</td>";
											echo "<td>".$row["ClosePriceTarget1"]."</td>";
											echo "<td>".$row["ClosePriceTarget2"]."</td>";
										    echo "</tr>";
										}
										
										$result = $con->query("select * from PredictionSVM where Symbol = 'GOOG' AND Date = 'predict day 1'");
										
										while($row = $result->fetch_assoc()){
											$day1 = $row["ClosePriceTarget"];
										}
										
										$result = $con->query("select * from PredictionSVM where Symbol = 'GOOG' AND Date = 'predict day 2'");
										
										while($row = $result->fetch_assoc()){
											$day2 = $row["ClosePriceTarget"];
										}
										
										echo "<tr>";
										echo "<td>GOOG</td>";
										echo "<td>SVM</td>";
										echo "<td>".$day1."</td>";
										echo "<td>".$day2."</td>";
										echo "</tr>";
										
										$result = $con->query("select * from PredictionANN where Symbol = 'GOOG' AND Date = 'predict day 1'");
										
										while($row = $result->fetch_assoc()){
											$day1 = $row["ClosePriceTarget"];
										}
										
										$result = $con->query("select * from PredictionANN where Symbol = 'GOOG' AND Date = 'predict day 2'");
										
										while($row = $result->fetch_assoc()){
											$day2 = $row["ClosePriceTarget"];
										}
										
										echo "<tr>";
										echo "<td>GOOG</td>";
										echo "<td>ANN</td>";
										echo "<td>".$day1."</td>";
										echo "<td>".$day2."</td>";
										echo "</tr>";
										
										
										$con->close();		
							     	?>
									</tbody>
									<tfoot>
									</tfoot>
								</table>
                                
							</div>                                                   
                           
                    </div>
                    
                
                     <div class="8u">
                         <hr />
                         <h3>Relative Error</h3>      
                         <div id='chart_div2' style='width: 800px; height: 500px;'></div>
                     </div>
                     
                     <div class="4u">
                         <hr />
                         <div class="table-wrapper">
								<table id = "error">
                                	<h3>Average Relative Error</h3>
									<thead>
										<tr>
											<th>Symbol</th>
                                            <th>Strategy</th>
                                            <th>Error(%)</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
										$con = new mysqli($server, $usr, $pwd, $db);

										if ($con->connect_error) die("Connection failed: ".$con->connect_error);
									
										$result = $con->query("select Symbol, avg(RelativeDifference) as avg from SPredictionBayesian where Symbol = 'GOOG'");
										
										while($row = $result->fetch_assoc()){
											echo "<tr>";
											echo "<td>".$row["Symbol"]."</td>";
											echo "<td>Bayesian</td>";
											echo "<td>".Round($row["avg"], 2)."</td>";
										    echo "</tr>";
										}
										
										$result = $con->query("select Symbol, avg(RelativeDifference) as avg from SPredictionSTS where Symbol = 'GOOG'");
										
										while($row = $result->fetch_assoc()){
											echo "<tr>";
											echo "<td>".$row["Symbol"]."</td>";
											echo "<td>STS</td>";
											echo "<td>".Round($row["avg"], 2)."</td>";
										    echo "</tr>";
										}
										
										$result = $con->query("select Symbol, avg(RelativeDifference) as avg from PredictionSVM where Symbol = 'GOOG' AND Date LIKE '%-%-%'");
										
										while($row = $result->fetch_assoc()){
											echo "<tr>";
											echo "<td>".$row["Symbol"]."</td>";
											echo "<td>SVM</td>";
											echo "<td>".Round($row["avg"], 2)."</td>";
										    echo "</tr>";
										}
										
										$result = $con->query("select Symbol, avg(RelativeDifference) as avg from PredictionANN where Symbol = 'GOOG' AND Date LIKE '%-%-%'");
										
										while($row = $result->fetch_assoc()){
											echo "<tr>";
											echo "<td>".$row["Symbol"]."</td>";
											echo "<td>ANN</td>";
											echo "<td>".Round($row["avg"], 2)."</td>";
										    echo "</tr>";
										}
										
										
										$con->close();		
							     	?>
									</tbody>
									<tfoot>
									</tfoot>
								</table>
                                
							</div>     
                     </div>
                     
                     
                </div>          
				</div>
			</section>
        
        <!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
					<h2>Long Term Prediction</h2>
					<p></p>
				</header>
				<div class="container">
                <div class="row">
                  <div class="8u">
                  <h3>Half Month Trend</h3>
                    <div id='chart_div0' style='width: 800px; height: 500px;'></div>
                  </div>
                  
                  <div class="4u">
                  <h3>Select Stock</h3>
                    <form>
                    	<div class="row uniform 50%">
                    		<div class="6u$">
							<div class="select-wrapper">
								<select name="category" id="category" onChange="select_symbol0(this)">
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
                    	</div>
                    	
                    </form>
                  </div>
                  
                  
                  
                 
                  <div class="8u">
                  <hr />
                  <h3>Exponetial Moving Average (EMA)</h3>
                    <div id='chart_div3' style='width: 800px; height: 500px;'></div>
                  
                  <hr />
                  <h3>Moving Average Convergence Divergence (MACD)</h3>
                    <div id='chart_div4' style='width: 800px; height: 500px;'></div>
                  </div>
                  
                  <div class="4u">
                  <hr />
                  
                  <table id = "recommend">
                                	<h3>Action Recommendation</h3>
									<thead>
										<tr>
											<th>Symbol</th>
                                            <th>Date</th>
                                            <th>Action</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
										$con = new mysqli($server, $usr, $pwd, $db);

										if ($con->connect_error) die("Connection failed: ".$con->connect_error);
									
										$result = $con->query("select * from PredictionMACD where Symbol = 'GOOG' order by Date desc");
										
										while($row = $result->fetch_assoc()){
											if($row["Action"] == 1) {
												echo "<tr>";
												echo "<td>".$row["Symbol"]."</td>";
												echo "<td>".$row["Date"]."</td>";
												echo "<td>BUY</td>";
										    	echo "</tr>";
											}
											if($row["Action"] == 2) {
												echo "<tr>";
												echo "<td>".$row["Symbol"]."</td>";
												echo "<td>".$row["Date"]."</td>";
												echo "<td>Strongly BUY</td>";
										    	echo "</tr>";
											}
											if($row["Action"] == 3) {
												echo "<tr>";
												echo "<td>".$row["Symbol"]."</td>";
												echo "<td>".$row["Date"]."</td>";
												echo "<td>SELL</td>";
										    	echo "</tr>";
											}
											if($row["Action"] == 4) {
												echo "<tr>";
												echo "<td>".$row["Symbol"]."</td>";
												echo "<td>".$row["Date"]."</td>";
												echo "<td>Strongly SELL</td>";
										    	echo "</tr>";
											}

										}					
										
										$con->close();		
							     	?>
									</tbody>
									<tfoot>
									</tfoot>
								</table>
                    
                  </div>              
                  
                  
                  
                    
                    
                    
    				
                </div>
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