<?php
include 'partials/_dbconnect.php';

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true)
{
	header('location: ./login.php');
	exit;
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us</title>
	  
	  <!--bootstrap css-->
	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	  <!--bootstrap css-->
	  
	  <link rel="stylesheet" type="text/css" href="css/main.css">
	  
  </head>
  <body style="background-color: #f5ebe1">
	
	<nav style="background-color: #eddece" class="navbar navbar-expand-lg fixed-top shadow-sm">
		<div class="container-lg">
		<a class="navbar-brand fw-bold" href="#">rydesync</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mx-auto">
		<li class="nav-item fw-semibold">
		  <a class="nav-link" aria-current="page" href="./index.php">Home</a>
		</li>
		<li class="nav-item fw-semibold">
		  <a class="nav-link nav-focus" href="./about.php">About</a>
		</li>
		<?php
			if($_SESSION['role'] == 'r')
			{
				echo'<li class="nav-item fw-semibold">';
				  echo'<a class="nav-link" href="./offer-ride.php">Offer Rides</a>';
				echo'</li>';
				echo'<li class="nav-item fw-semibold">';
				  echo'<a class="nav-link" href="./my-offerings.php">My Offerings</a>';
				echo'</li>';
			}
			if($_SESSION['role'] == 'p')
			{
				echo'<li class="nav-item fw-semibold">';
			  		echo'<a class="nav-link" href="./find-ride.php">Find Rides</a>';
				echo'</li>';
			}
		?>	
		<li class="nav-item fw-semibold">
		  <a class="nav-link" href="./requests.php">Requests</a>
		</li>
		  <li class="nav-item fw-semibold">
		  <a class="nav-link" href="./contact.php">Contact</a>
		</li>
			<?php
			if($_SESSION['loggedin'] == true || isset($_SESSION['loggedin']))
			{
				echo '<li class="nav-item fw-semibold">
			  	<a class="nav-link d-lg-none" href="./logout.php">Logout</a>
				</li>';
			}
			else
			{
			  echo'<li class="nav-item fw-semibold">
			  	<a class="nav-link d-lg-none" href="./register.php">Sign Up</a>
				</li>
			<li class="nav-item fw-semibold">
			  <a class="nav-link d-lg-none" href="./login.php">Sign In</a>
			</li>';
			}
			
			?> 
		</ul>
			<?php
			if($_SESSION['loggedin'] == true || isset($_SESSION['loggedin']))
			{
				echo '<button class="nav-item fw-semibold">
			  	<a class="nav-link" href="./logout.php">Logout</a>
				</button>';
			}
			else
			{
				echo'<button class="btn btn-login d-none d-lg-block"><a style="text-decoration: none; color: white" href="./login.php">Sign In</a></button>';
			}
			?>
		</div>
		</div>
	</nav>

	<section class="hero">
		<div class="container-lg">
			<div class="row align-items-center">
			<div class="col-sm-6">
				<h1 style="color: #ff8d22" class="display-3 fw-semibold">About Us</h1>
				<br>
				<p>	Welcome to Rydesync, where innovation meets a commitment to revolutionize the way we commute. Founded by a 
dynamic team of three individuals, all pursuing Bachelor's degrees in Computer Science at FAST University, 
we share a common vision of creating a transformative carpooling experience. Our journey began with a passion 
for leveraging technology to address transportation challenges, and it has evolved into the development of 
Rydesync—a platform designed to bring people together, optimize commuting, and contribute to a more sustainable 
future. As students with a deep appreciation for the power of collaboration and community, we strive to make 
commuting not only efficient but also enjoyable. At Rydesync, we believe in the potential of every shared ride 
to forge connections, reduce environmental impact, and redefine the way we navigate our daily lives. Join us 
on this exciting journey as we drive innovation and connectivity in the world of transportation.
				</p>
				<br>
				<button class="btn btn-about-hero btn-lg mt-4">Read More</button>
				<br><br>
			</div>
			<div class="col-sm-6 text-center">
				<div class="about-hero-box">
					<img src="img/hero.png" class="about-box-img" alt="about-hero">
				</div>
			</div>
		</div> 
		 </div>
	  </section>
	  
	<section class="hero">
		<div class="container-lg">
			<div class="row align-items-center">
				<div class="col-sm-6">
					<h1><span class="display-3 fw-semibold" style="color: #008773; letter-spacing: 4px;">Meet Our Team</span></h1>
					<br><br>
				</div>
				<div class="col-sm-6"></div>
			</div>
			<div class="row align-items-center">
				<div class="col-sm-6 text-center">
					<div style="background-color: #ff8d22;" class="team-box-left">
						<p class="box-left-text">Akshay<br>Mandhan</p>
						<div class="img-box-left">
							<img style = "height: 300px;
		width: 100%;
		border-radius: 800px;
		background-color: black;
		" src="img/akshay.jpeg">
						</div>
					</div>
				</div>
				<div class="col-sm-6"></div>
			</div> 
			<div class="row align-items-center">
				<div class="col-sm-6">
				</div>
				<div class="col-sm-6">
					<div style="background-color: #5a4fc5;" class="team-box-right">
						<p class="box-right-text">Jatin<br>Kesnani</p>
						<div class="img-box-right">
							<img style = "height: 300px;
							width: 100%;
							border-radius: 800px;
							background-color: black;
							" src="img/jatin.jpeg">
						</div>
					</div>
				</div>
			</div>
			<div class="row align-items-center">
				<div class="col-sm-6 text-center">
					<div style="background-color: #008773;" class="team-box-left">
						<p class="box-left-text">Neeraj<br>Otwani</p>
						<div class="img-box-left">
							<img style = "height: 300px;
						width: 100%;
						border-radius: 800px;
						background-color: black;
						" src="img/neeraj.jpeg">
						</div>
					</div>
				</div>
				<div class="col-sm-6"></div>
			</div> 
			<br><br><br>
		</div>
	  </section>
	  
	<footer>
    <div class="container-fluid">
        <div class="row">
            <div style="text-align: center; margin-top: 30px;" class="footer-col-rt col-md-6">
                <a class="navbar-brand fw-bold ft-logo" href="#">rydesync</a>
				<p style="margin-top: 100px;">Akshay Apartment, Clifton Block 9, Karachi<br>+92-333-7306589</p>
            </div>
            <div style="text-align: center; margin-top: 30px;" class="footer-col-lf col-md-6">
                <a href="#" class="footer-link">About Us</a>
                <a href="#" class="footer-link">Rides</a>
                <a href="#" class="footer-link">Features</a>
                <a href="#" class="footer-link">Contact Us</a>
            </div>
        </div>
    </div>
	</footer>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>  
	  
  </body>
</html>