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
                        <?php } ?>
						
					</ul>
				</nav>
			</header>

		<!-- Banner -->
			<section id="banner">
				<div class="inner">
					<h2>This is iStock</h2>
                    <?php if(isset($_SESSION['usr'])) { ?>
                    <p>Welcome, <?php echo $_SESSION['usr'] ?></a></p>
					<ul class="actions">
						<li><a href="trade.php" class="button big alt">Play Your Stock</a></li>
					</ul>
                    <?php } else { ?> 
					<p>What starts here gets you rich</a></p>
					<ul class="actions">
						<li><a href="login.php?action=signup" class="button big special">Sign Up</a></li>
						<li><a href="#" class="button big alt">About Us</a></li>
					</ul>
                    <?php } ?>
				</div>
			</section>

		<!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
					<h2>Introduction</h2>
					<p></p>
				</header>
				<div class="container">
					<div class="row">
						<div class="4u">
							<section class="special box">
								<i class="icon fa-newspaper-o major"></i>
								<h3>News</h3>
								<p>Latest financial news around the world to help you make a better decision with your personal fund.</p>
							</section>
						</div>
						<div class="4u">
							<section class="special box">
								<i class="icon fa-line-chart major"></i>
								<h3>Stock Forecast</h3>
								<p>Short-term and long-term stock prediction and recommandation with open-code algorithm.</p>
							</section>
						</div>
						<div class="4u">
							<section class="special box">
								<i class="icon fa-exchange major"></i>
								<h3>Virtual Stock</h3>
								<p>Registed users have a change to take part into our virtual stock market with $100,000 initial money.</p>
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