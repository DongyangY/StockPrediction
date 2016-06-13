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
		<!-- <script src="js/skel-layers.min.js"></script> -->
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
                        <?php } ?>
						
					</ul>
				</nav>
			</header>


		<!-- Three -->
			<section id="main" class="wrapper style1">
				<header class="major">
					<h2>Stock Information</h2>
					<p></p>
				</header>
				<div class="container">
					<div class="row">
                        
						<div class="8u">
                        
                        <section>
                        
                        
                        
                                         
                            <?php
			include("backend/methods.php");
			$ticker = "YHOO";

			if (!empty($_POST['ticker'])) {
				$ticker = trim($_POST['ticker']);
			}
			elseif (!empty($_GET['ticker'])) {
				$ticker = trim($_GET['ticker']);
			}

			if (!isset($ticker)) {
				$ticker = "YHOO";
			}
			else {
				// $proceed = validateTicker($ticker);
				// if ($proceed) {
				// }
				// else {
				// 	$ticker = "YHOO";
				// 	echo("symbol not valid, now display YHOO");
				// }
			}

		?>
                          <h3>Stock Chart: <?php echo $ticker; ?></h3>
                          
         
                          
                          
                             <div id = "range">
			<?php
				chartRangeMenu();
			?>
		</div>

		<div id = "chart">			
			<?php
				getChart($ticker);
			?>
		</div>
        
        <!-- js for chart changing -->   
		<script>
		var ticker = "<?= $ticker ?>";
		$(document).ready(function() {
		   $("button").click(
			function() {
				$("#beChanged").replaceWith("<img id='beChanged' class='chart_img' src='http://ichart.yahoo.com/z?s="+ticker+"&t="+$(this).val()+"&q=c&l=on&z=l'>");
				$("button").removeClass("on");
				$(this).addClass("on");
			}
		   );
		 });
		</script>
                          
                          </section>
                        
                            <p></p>
                        
                        
							<section>
                    		<div class="table-wrapper">
								<table>
                                	<h3>Lastest Stock Price</h3>
									<thead>
										<tr>
											<th>Symbol</th>
                                            <th>Time</th>
											<th>Real-time Price</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
										$con = new mysqli($server, $usr, $pwd, $db);

										if ($con->connect_error) die("Connection failed: ".$con->connect_error);
										
										$symbols = array("GOOG", "YHOO", "AAPL", "FB", "MSFT", "AMZN", "SNE", "WMT", "CAJ", "TWTR");
										
										for($i = 0; $i < 10; $i++) {
										$result = $con->query("select * from StockRealtime where Symbol = '".$symbols[$i]."' order by Time desc limit 1");
										
										while($row = $result->fetch_assoc()){
											echo "<tr>";
											echo "<td>".$row["Symbol"]."</td>";
											echo "<td>".$row["Time"]."</td>";
											echo "<td>".$row["Price"]."</td>";
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
                            
							<div class="table-wrapper">
								<table>
                                	<h3>Highest Price in last ten days</h3>
									<thead>
										<tr>
											<th>Symbol</th>
											<th>Date</th>
                                            <th>Days High Price</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
										$con = new mysqli($server, $usr, $pwd, $db);

										if ($con->connect_error) die("Connection failed: ".$con->connect_error);
	
										for($i = 0; $i < 10; $i++) {

											$result = $con->query("select max(DaysHigh) as highest from (select * from StockHistorical where Symbol = '".$symbols[$i]."' order by Date desc limit 10) as T1");
											
											$highest = 0.0;
											while($row = $result->fetch_assoc()){
												$highest = $row["highest"];
											}
											
											$result = $con->query("select Symbol, Date, DaysHigh from StockHistorical where Symbol = '".$symbols[$i]."' AND DaysHigh = ".$highest." order by Date desc limit 10");
											while($row = $result->fetch_assoc()){
												echo "<tr>";
												echo "<td>".$row["Symbol"]."</td>";
												echo "<td>".$row["Date"]."</td>";
												echo "<td>".$row["DaysHigh"]."</td>";
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
                            
                            <div class="table-wrapper">
								<table>
                                	<h3>Average Stock Price in the latest one year</h3>
									<thead>
										<tr>
											<th>Symbol</th>
											<th>Close Price</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
										$con = new mysqli($server, $usr, $pwd, $db);

										if ($con->connect_error) die("Connection failed: ".$con->connect_error);
										
								
										for($i = 0; $i < 10; $i++) {

											$result = $con->query("select Symbol, avg(ClosePrice) as average from StockHistorical where Symbol = '".$symbols[$i]."'");				
											while($row = $result->fetch_assoc()){
												echo "<tr>";
												echo "<td>".$row["Symbol"]."</td>";
												echo "<td>".round($row["average"], 2)."</td>";
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
                            
                            <div class="table-wrapper">
								<table>
                                	<h3>Lowest Stock Price in the latest one year</h3>
									<thead>
										<tr>
											<th>Symbol</th>
											<th>Days Low Price</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
										$con = new mysqli($server, $usr, $pwd, $db);

										if ($con->connect_error) die("Connection failed: ".$con->connect_error);
										
								
										for($i = 0; $i < 10; $i++) {

											$result = $con->query("select Symbol, min(DaysLow) as lowest from StockHistorical where Symbol = '".$symbols[$i]."'");				
											while($row = $result->fetch_assoc()){
												echo "<tr>";
												echo "<td>".$row["Symbol"]."</td>";
												echo "<td>".$row["lowest"]."</td>";
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
                            
                            <div class="table-wrapper">
								<table>
                                	<h3>Companies Whose Average Price lower than Lowest Price of GOOG in the Lastest one Year</h3>
									<thead>
										<tr>
											<th>Id</th>
											<th>Symbol</th>
                                            <th>Full Name</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
										$con = new mysqli($server, $usr, $pwd, $db);

										if ($con->connect_error) die("Connection failed: ".$con->connect_error);		
										
										$result = $con->query("select Symbol, min(DaysLow) as lowest from StockHistorical where Symbol = 'GOOG'");	
											
											$GOOG_lowest = 0.0;
											while($row = $result->fetch_assoc()){
												$GOOG_lowest = $row["lowest"];
											}									
								
										for($i = 0; $i < 10; $i++) {

											$result = $con->query("select avg(ClosePrice) as average from StockHistorical where Symbol = '".$symbols[$i]."'");	
											while($row = $result->fetch_assoc()){
												if($row["average"] < $GOOG_lowest) {
													$result2 = $con->query("select ID, Symbol, Fullname from StockInfo where Symbol = '".$symbols[$i]."'");
													
													while($row2 = $result2->fetch_assoc()){
														echo "<tr>";
														echo "<td>".$row2["ID"]."</td>";
														echo "<td>".$row2["Symbol"]."</td>";
														echo "<td>".$row2["Fullname"]."</td>";
										    			echo "</tr>";
													}
												
												}
											}
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
						<div class="4u">
                        
                        <section>
								<h3>Search</h3>
                                
                                
        
        <div id = "search">
			<?php include("backend/search.php"); ?>
		</div>
        
        
                                
                        </section>
                        
                        <hr />
                        
							<section>
								<h3>Twiter</h3>
		
      


		<div id="stocktwits-widget-news"></div>

        
    <!-- js for stock-twits -->
		<script type="text/javascript" src="http://stocktwits.com/addon/widget/2/widget-loader.min.js"></script>
		<script src="js/stocktwits.js"></script>
        
        
							</section>
                            
                            
							<hr />
                            
                            
                            
                            
							<section>
								<h3>News</h3>
                                <div id = "news">
                                <ul class="alt">
                                    <?php getNews($ticker); ?>								
								</ul>
		                       </div>
	
							</section>
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