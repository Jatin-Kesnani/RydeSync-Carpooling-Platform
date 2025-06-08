<?php

session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true)
{
	header('location: ./login.php');
	exit;
}
if($_SESSION['role'] != 'r')
{
	header('location: ./index.php');
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	include 'partials/_dbconnect.php';
	$model = $_POST["model"];
	$year = $_POST["year"];
	$seatCap = $_POST["seat-capacity"];
	$regNo = $_POST["reg-no"];
	$username = $_SESSION["username"];
	$query = "SELECT VehicleID from Vehicle Where Model = '$model' and Year = '$year' and SeatingCapacity = '$seatCap'";
	$result = mysqli_query($conn, $query);
	
	if(mysqli_num_rows($result) == 0)
	{
		$addVehicle = "INSERT INTO Vehicle (Model, Year, SeatingCapacity) Values ('$model', '$year', '$seatCap')";
		$temp = mysqli_query($conn, $addVehicle);
		if($temp)
		{
			$message = 'Vehicle has been registered!';
			echo '<script>alert(\'' . $message . '\')</script>';
		}
		$query = "SELECT VehicleID from Vehicle Where Model = '$model' and Year = '$year' and SeatingCapacity = '$seatCap'";
		$result = mysqli_query($conn, $query);
		
	}
	$row = mysqli_fetch_assoc($result);
	$vid = $row["VehicleID"];
	$addVehReg = "INSERT INTO vehiclereg (RegNo, vehicleid) values('$regNo', '$vid')";
	$temp = mysqli_query($conn, $addVehReg);
	if($temp)
	{
		$message = 'Vehicle has been registered!';
		echo '<script>alert(\'' . $message . '\')</script>';
		$addRider = "INSERT INTO rider (RiderID, RidesCount, Rating, NumberPlate) VALUES ('$username', 0, 0, '$regNo')";
		$temp = mysqli_query($conn, $addRider);
		if(!$temp)
		{
			$message = 'Rider Info was not added!';
			echo '<script>alert(\'' . $message . '\')</script>';
		}
		header('location: ./index.php');
	}
}


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Vehicle</title>
	  
	  <!--bootstrap css-->
	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	  <!--bootstrap css-->
	  
	  <!--tailwind css-->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
	  <!--tailwind css-->
	  
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
		  <li class="nav-item fw-semibold">
		  <a class="nav-link d-lg-none" href="./register.php">Sign Up</a>
		</li>
			<li class="nav-item fw-semibold">
		  <a class="nav-link d-lg-none" href="./login.php">Sign In</a>
		</li> 
		</ul>
		<button class="btn btn-login d-none d-lg-block"><a style="text-decoration: none; color: white" href="./login.php">Sign In</a></button>
		</div>
		</div>
	</nav>
	  
	<section class="hero">
		<div class="container-lg">
			<div class="row align-items-center">
			<div class="col-sm-12 text-center">
				<div class="reg-hero-box">
					<h1 style="align-items: center; line-height: 200px;color: white; font-size: 35px; font-weight: bold;">Vehicle Registration</h1>
				</div>
			</div>
		</div> 
		 </div>
	  </section>

	<section class="container-lg">
			
	<div class="isolate bg-transparent px-6 py-24 sm:py-32 lg:px-8">
	  <div class="absolute inset-x-0 top-[-10rem] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[-20rem]" aria-hidden="true">
		<div class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
	  </div>
	  <div class="mx-auto max-w-2xl text-center">
		<h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Register Your Vehicle</h2>
		<p class="mt-2 text-lg leading-8 text-gray-600">you are just one step away from sharing your rides and saving money!</p>
	  </div>
	  <form action="#" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
		<div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
		  <div class="sm:col-span-2">
			<label for="model" class="block text-sm font-semibold leading-6 text-gray-900">Model</label>
			<div class="mt-2.5">
			  <input type="text" name="model" id="model" autocomplete="amount" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
			</div>
		  </div>
		  <div>
			<label for="year" class="block text-sm font-semibold leading-6 text-gray-900">Year</label>
			<div class="mt-2.5">
			  <input type="number" name="year" id="year" autocomplete="family-name" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
			</div>
		  </div>
			<div class="sm:col-span-1">
			<label for="seat-capacity" class="block text-sm font-semibold leading-6 text-gray-900">Seating Capacity</label>
			<div class="mt-2.5">
			  <input type="number" name="seat-capacity" id="seat-capacity" autocomplete="family-name" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
			</div>
		  </div>
			<div class="sm:col-span-2">
			<label for="reg-no" class="block text-sm font-semibold leading-6 text-gray-900">Registration Number</label>
			<div class="mt-2.5">
			  <input type="text" name="reg-no" id="reg-no" autocomplete="amount" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
			</div>
		  </div>
		</div>
		<div class="mt-10">
		  <button style="background-color: #008773" type="submit" class="block w-full rounded-md px-3.5 py-2.5 text-center text-sm font-semibold text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register Vehicle</button>
		</div>
	  </form>
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