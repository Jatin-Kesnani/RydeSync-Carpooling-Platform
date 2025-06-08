<?php
include 'partials/_dbconnect.php';

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true)
{
	header('location: ./login.php');
	exit;
}

if(isset($_POST['srchbtn']))
{
	$_SESSION['fromhome'] = $_POST['fromhome'];
	$_SESSION['tohome'] = $_POST['tohome'];
	header('location: ./find-ride.php');
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RydeSync</title>
	  
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
		  <a class="nav-link nav-focus" aria-current="page" href="./index.php">Home</a>
		</li>
		<li class="nav-item fw-semibold">
		  <a class="nav-link" href="./about.php">About</a>
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
			if($_SESSION['loggedin'] == false || !isset($_SESSION['loggedin']))
			{
			  echo'<li class="nav-item fw-semibold">
			  	<a class="nav-link d-lg-none" href="./register.php">Sign Up</a>
				</li>
			<li class="nav-item fw-semibold">
			  <a class="nav-link d-lg-none" href="./login.php">Sign In</a>
			</li>';
			}
			else
			{
				echo '<li class="nav-item fw-semibold">
			  	<a class="nav-link d-lg-none" href="./logout.php">Logout</a>
				</li>';
			}
			?> 
		</ul>
			<?php
			if($_SESSION['loggedin'] == false || !isset($_SESSION['loggedin']))
			{
			echo'<button class="btn btn-login d-none d-lg-block"><a style="text-decoration: none; color: white" href="./login.php">Sign In</a></button>';
			}
			else
			{
				echo '<button class="nav-item fw-semibold">
			  	<a class="nav-link" href="./logout.php">Logout</a>
				</button>';
			}
			?>
		</div>
		</div>
	</nav>

	<section class="hero">
		<div class="container-lg">
			<div class="row align-items-center">
			<div class="col-sm-6">
				<h1 style="color: #ff8d22" class="display-3 fw-semibold">Carpooling</h1>
				<h1 style="color: #332F2F;" class="display-3 fw-semibold">Made Easy!</h1>
				<p>	Welcome to Rydesync, where we've redefined the way you commute. 
Say goodbye to solo rides and hello to a smarter, more sustainable way of getting around. 
Our platform is designed to make carpooling easy, efficient, and enjoyable for everyone. 
Whether you're a daily commuter or just looking for an occasional ride, we connect you 
with like-minded individuals headed in the same direction. Save money, reduce your carbon 
footprint, and build connections with fellow travelers. Join us in transforming the way we 
move – because together, we make the journey not just about the destination, but about the 
people we meet along the way. Let's make carpooling the new norm for a greener, more connected world.
				</p>
				<?php
				
				if($_SESSION['role'] == 'r')
				{
					echo'<a href="./offer-ride.php"><button class="btn btn-hero btn-lg mt-4">Offer Rides</button></a>';
				}
				else if($_SESSION['role'] == 'p')
				{
					echo'<a href="./find-ride.php"><button class="btn btn-hero btn-lg mt-4">Book A Ride</button></a>';
				}
				
				?>
			</div>
			<div class="col-sm-6 text-center">
				<img src="img/hero.png" class="img-fluid">
			</div>
		</div> 
		 </div>
	  </section>
	<section class="support-hero">
		<div class="container-lg">
			<div class="row align-items-center">
			<div class="col-sm-6 text-center">
			<img src="img/support-hero.png" class="img-fluid">
		</div>
			<div class="col-sm-6 mt-">
				<h1 class="display-3 text-light fw-semibold"><span style="color: #00d7b7">24</span> Hour Support</h1>
				<p class="text-light">	At Rydesync, we understand that your journey doesn't always follow a 9-to-5 schedule. 
That's why we're committed to providing round-the-clock support to ensure your carpooling 
experience is seamless and stress-free, no matter the time of day. Our dedicated support 
team is ready to assist you with any inquiries, troubleshoot issues, or address concerns, 
ensuring that you're never alone on the road. Your safety and satisfaction are our top priorities, 
and our 24-hour support is just one way we go the extra mile to make your carpooling experience truly 
reliable and convenient. Drive with confidence, knowing that assistance is just a message or call away – 
because your journey matters to us, every hour of every day.
				</p>
			</div>
		</div> 
		 </div>
	  </section>

	<section class="exp-hero">
		<div class="container-lg">
			<div class="row align-items-center">
			<div class="col-sm-6 mt-">
				<h1 class="display-3 text-light fw-semibold">Choose Your
					 <span style="color: #5a4fc5">Role</span> </h1>
					 <p class="text-light">	Customize your commute with Rydesync, where you have the flexibility to decide whether you want to be
 a passenger or a driver. Your choice matters, and we provide the tools to tailor your journey according 
to your preferences. Select the role that suits your needs – enjoy a relaxed ride as a passenger or take 
the driver's seat and share the journey with others. With us, carpooling is not just a mode of transport; 
it's an experience crafted by you, for you. Start shaping your commute today.
				</p>
			</div>
			<div class="col-sm-6 text-center">
			<img src="img/exp-hero.png" class="img-fluid">
		</div>
		</div> 
		 </div>
	  </section>

	<section class="shr-hero">
		<div class="container-lg">
			<div class="row align-items-center">
			<div class="col-sm-6 text-center">
			<img src="img/shr-hero.png" class="img-fluid">
		</div>
			<div class="col-sm-6 mt-">

				<h1 class="display-3 text-light fw-semibold">Share the Ride and <span style="color: #f4a358">Joy!</span></h1>
				<p class="text-light">	Embark on a journey of camaraderie and shared experiences with Rydesync. Our mission goes beyond simply 
connecting passengers and drivers – it's about fostering a sense of joy and connection on the road. When 
you choose to carpool with us, you're not just reaching your destination; you're creating memories and 
forging connections with fellow travelers. Share a laugh, exchange stories, and make your commute more than 
just a ride – make it an adventure. Join our community where every trip becomes an opportunity to spread 
the joy of shared travel. After all, the road is better when it's traveled together. Let's share the ride 
and joy, one carpool at a time!
				</p>
			</div>
		</div> 
		 </div>
	  </section>

	<section class="testinomials">
		<div class="container">
			<h2 class="display-5 fw-semibold mt-5 mb-5 tst-heading">Our <span style="color: #008773">Happy</span> Clients</h2>
			<div id="carouselExample" class="carousel slide">

			  <div class="carousel-inner">
				<div class="carousel-item active">
					<div class="tst-box d-none d-lg-block">
						<div class="row align-items-center">
							<div class="col-lg col-sm-4">
								<div style = "border: none;" class="tst-imgbox">
									<img style = "width: 100%; height: 220px; border-radius: 50%;" class="img-fluid" src="img/Emily_Thompson.jfif" alt="hero">
								</div>
							</div>
							<div class="col-sm-8">
								<div class="test-info">
									<h1>Emily Thompson</h1>
									<img class="star" src="img/star.svg" alt="star">
									<img class="star" src="img/star.svg" alt="star">
									<img class="star" src="img/star.svg" alt="star">
									<img class="star" src="img/star.svg" alt="star">
									<img class="star" src="img/star.svg" alt="star">
									<p class="test-txt">Enjoyed my ride with Rydesync! The app is user-friendly, and I appreciated the prompt 
and courteous service from my driver. Looking forward to more rides!
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="tst-box-sm d-lg-none d-block">
					<p class="tst-sm-txt">Enjoyed my ride with Rydesync! The app is user-friendly, and I appreciated the prompt 
and courteous service from my driver. Looking forward to more rides!</p>
					</div>
				</div>
				<div class="carousel-item">
				  <div class="tst-box d-none d-lg-block">
						<div class="row align-items-center">
							<div class="col-lg col-sm-4">
							<div style = "border: none;" class="tst-imgbox">
									<img style = "width: 100%; height: 220px; border-radius: 50%;" class="img-fluid" src="img/Alex_Rodriguez.jfif" alt="hero">
							</div>
							</div>
							<div class="col-sm-8">
								<div class="test-info">
									<h1>Alex Rodriguez</h1>
									<img class="star" src="img/star.svg" alt="star">
									<img class="star" src="img/star.svg" alt="star">
									<img class="star" src="img/star.svg" alt="star">
									<img class="star" src="img/star.svg" alt="star">
									<img class="star" src="img/star.svg" alt="star">
									<p class="test-txt">Great experience using Rydesync. Found a ride quickly, and the driver
 was friendly and punctual. The app's design is sleek and intuitive, making my daily commute much smoother.
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="tst-box-sm d-lg-none d-block">
					<p class="tst-sm-txt">Great experience using Rydesync. Found a ride quickly, and the driver
 was friendly and punctual. The app's design is sleek and intuitive, making my daily commute much smoother.</p>
					</div>
				</div>
				<div class="carousel-item">
				  <div class="tst-box d-none d-lg-block">
						<div class="row align-items-center">
							<div class="col-lg col-sm-4">
							<div style = "border: none;" class="tst-imgbox">
									<img style = "width: 100%; height: 220px; border-radius: 50%;" class="img-fluid" src="img/Jessica_Chen.jfif" alt="hero">
							</div>
							</div>
							<div class="col-sm-8">
								<div class="test-info">
									<h1>Jessica Chen</h1>
									<img class="star" src="img/star.svg" alt="star">
									<img class="star" src="img/star.svg" alt="star">
									<img class="star" src="img/star.svg" alt="star">
									<img class="star" src="img/star.svg" alt="star">
									<img class="star" src="img/star.svg" alt="star">
									<p class="test-txt">I've been using Rydesync for a few weeks now, and it's been fantastic! The variety of 
drivers and the ease of scheduling rides make it my go-to for daily commuting. Highly recommend!
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="tst-box-sm d-lg-none d-block">
					<p class="tst-sm-txt">I've been using Rydesync for a few weeks now, and it's been fantastic! The variety of 
drivers and the ease of scheduling rides make it my go-to for daily commuting. Highly recommend!</p>
					</div>
				</div>
			  </div>
			  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
				<span class="carousel-control-prev-icon prev-btn" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			  </button>
			  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
				<span class="carousel-control-next-icon next-btn" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			  </button>
			</div>

		</div> 

		<!--FAQS DROPDOWN HERE -->
		<div class="container">
			<h1 style="text-align: left; margin-bottom: 20px;">FAQs</h1>
			<div class="accordion" id="accordionPanelsStayOpenExample">
			  <div class="accordion-item faq-item">
				<h2 class="accordion-header">
				  <button class="accordion-button faq-btn" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
					1. What is Rydesync?
				  </button>
				</h2>
				<div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
				  <div class="accordion-body">
				  Rydesync is a cutting-edge carpooling platform that redefines the way people commute, fostering a 
sense of community and sustainability. At its core, Rydesync is a dynamic solution designed to 
connect individuals with shared destinations, seamlessly transforming daily journeys into shared 
experiences. Whether you're a daily commuter or an occasional traveler, Rydesync offers a user-friendly
 interface that effortlessly matches riders with compatible drivers, optimizing routes and minimizing 
the environmental footprint.
				  </div>
				</div>
			  </div>
			  <div class="accordion-item faq-item">
				<h2 class="accordion-header">
				  <button class="accordion-button collapsed faq-btn2" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
					2. What about Payment Method?
				  </button>
				</h2>
				<div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
				  <div class="accordion-body">
				  Rydesync simplifies the payment process to ensure a hassle-free and transparent experience for both 
riders and passengers. When a rider offers a ride, they specify the amount for the journey. Similarly, 
when a passenger makes a ride request, they also provide the amount they are willing to pay. After the 
completion of the ride, Rydesync facilitates a straightforward settlement process between the rider and passenger. 
Rydesync ensures that everyone involved in the ride-sharing experience can easily and securely handle 
their transactions, promoting a reliable and efficient carpooling community.	
				  </div>
				</div>
			  </div>
			  <div class="accordion-item faq-item">
				<h2 class="accordion-header">
				  <button class="accordion-button collapsed faq-btn3" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
					3. What about safety of Passengers?
				  </button>
				</h2>
				<div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
				  <div class="accordion-body">
				  Safety is our top priority at Rydesync, and we have implemented a robust set of measures to ensure the 
				well-being of our passengers. All drivers on our platform undergo a thorough screening process, including 
				background checks, driving record reviews, and vehicle inspections. We prioritize drivers with a proven 
				track record of responsibility and reliability to create a trustworthy community.	
				  </div>
				</div>
			  </div>
			</div>

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