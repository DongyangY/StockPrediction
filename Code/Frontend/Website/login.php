<!DOCTYPE HTML>
<!--
	Ion by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Login</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
        <script src="js/login.js"></script>        
        
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>


	</head>
	<body id="top">

		<!-- Header -->
			<header id="header" class="skel-layers-fixed">
				<h1><a href="#">iStock</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="#">Forecast</a></li>
                        <li><a href="news.php">News</a></li>
						<li><a href="#">VSE</a></li>
					</ul>
				</nav>
			</header>
            
        <!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
					<h2>Welcome to ISTOCK</h2>
					<p>Join us immediately</p>
				</header>
				<div class="container">
                	<div class="row">
                    
                    <div class="6u">
                    <section class="box">
                    	<a href="#" class="image"><img src="images/login.jpg" height="227" width="390" /></a>
                    </section>
                    </div>
                    
                	<div class="6u">
					<section class="special box">
						<h3>
                        <?php if($_GET['action'] == 'login') { ?>
                        <a class='login' href="#">Login</a> / <a class='signup' href="#" style="color: #649ecf; text-decoration: underline;">Signup</a>
                        <?php } else { ?>
                        <a class='login' href="#" style="color: #649ecf; text-decoration: underline;">Login</a> / <a class='signup' href="#">Signup</a>
                        <?php } ?>
                        </h3> 
                        <p></p> 
                        <form>
							<div class="12u$(xsmall)">
								<input type="text" name="name" id="name" value="" placeholder="Name" />
							</div>
                            <p></p>
                            <div class="12u$(xsmall)">
								<input type="password" name="pwd" id="pwd" value="" placeholder="Password" />
							</div>
                            <p></p>
                            <div class="12u$ align-right">
								<input type="submit" id="submit" value="Submit" class="special" />
							</div>
						</form>
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
