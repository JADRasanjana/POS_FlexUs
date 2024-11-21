<!DOCTYPE html>
<html lang="en">
<head>
<title>Inventory Management System || Home Page</title>

<!-- Custom Theme files -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/fasthover.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
<!-- //Custom Theme files -->
<!-- font-awesome icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<!-- js -->
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" href="css/jquery.countdown.css" /> <!-- countdown --> 
<!-- //js -->  
<!-- web fonts --> 
<link href='//fonts.googleapis.com/css?family=Glegoo:400,700' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<!-- //web fonts -->  
<!-- start-smooth-scrolling -->
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<!-- //end-smooth-scrolling --> 
<style>
  body {
    background-color: #2E363F; /* Apply #2E363F to the entire background */
    color: #fff; /* Set text color to white for better contrast */
  }

  .carousel-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px; /* Set a minimum height for centering vertically */
  }

  .carousel-inner img {
    margin: auto; /* Center the image inside the carousel item */
  }

  .header, .footer, .navigation {
    background-color: #2E363F; /* Apply #2E363F to header, footer, and navigation */
  }

  .w3l_logo h1 a {
    color: #ff4d4d; /* Red color for the logo text */
  }

  .navbar-default {
    border-color: #2E363F; /* Remove the border color */
  }

  .navbar-default .navbar-nav > li > a {
    color: #fff; /* Set navigation link color to white */
  }

  .navbar-default .navbar-nav > li > a:hover,
  .navbar-default .navbar-nav > li > a:focus {
    color: #ff4d4d; /* Change link color on hover to red */
  }

  .footer {
    padding: 20px 0; /* Adjust padding for the footer */
  }

  .footer-copy {
    background-color: #2E363F; /* Apply the same background to the footer */
  }

  .footer-copy p {
    color: #fff; /* White text in the footer */
  }

  .footer-copy-pos a img {
    filter: invert(100%); /* Invert arrow color to white */
  }
</style>
</head> 
<body>
	<!-- for bootstrap working -->
	<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>
	<!-- //for bootstrap working -->
	

	<!-- header -->
	<div class="header" id="home1">
		<div class="container">

			<div class="w3l_logo">
				<h1><a href="index.php">Inventory Management System</a></h1>
			</div>
		
		</div>
	</div>
	<!-- //header -->
	<!-- navigation -->
	<div class="navigation">
		<div class="container">
			<nav class="navbar navbar-default">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header nav_2">
					<button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div> 
				<div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
					<ul class="nav navbar-nav">
						<li ><a href="index.php" class="act">Home</a></li>	
						
						<li><a href="admin/login.php">Admin</a></li> 
					  
						
					</ul>
				</div>
			</nav>
		</div>
	</div>
	<!-- //navigation -->
	
	<!-- Carousel -->
	<div class="carousel-container">
	  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
	    <div class="carousel-inner">
	      <div class="carousel-item active">
	        <img class="d-block w-100" src="images/new_bg/bg1.jpeg" alt="First slide">
	      </div>
	      <!-- <div class="carousel-item">
	        <img class="d-block w-100" src="images/new_bg/bg1.jpeg" alt="Second slide">
	      </div>
	      <div class="carousel-item">
	        <img class="d-block w-100" src="images/new_bg/bg1.jpeg" alt="Third slide">
	      </div> -->
	    </div>
	    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
	      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	      <span class="sr-only">Previous</span>
	    </a>
	    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
	      <span class="carousel-control-next-icon" aria-hidden="true"></span>
	      <span class="sr-only">Next</span>
	    </a>
	  </div>
	</div>
	<!-- //Carousel --> 
	
	<!-- footer -->
	<div class="footer">
		
		<div class="footer-copy">
			<div class="footer-copy1">
				<div class="footer-copy-pos">
					<a href="#home1" class="scroll"><img src="images/arrow.png" alt=" " class="img-responsive" /></a>
				</div>
			</div>
			<div class="container">
				<p>Inventory Management System @ 2024 | <a href="https://mtrixlabs.com/">MatrixLabs</a></p>
			</div>
		</div>
	</div>
	<!-- //footer --> 
	<!-- cart-js -->
	<script src="js/minicart.js"></script>
	<script>
        w3ls.render();

        w3ls.cart.on('w3sb_checkout', function (evt) {
        	var items, len, i;

        	if (this.subtotal() > 0) {
        		items = this.items();

        		for (i = 0, len = items.length; i < len; i++) { 
        		}
        	}
        });
    </script>  
	<!-- //cart-js -->   
</body>
</html>
