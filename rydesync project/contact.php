<?php
include 'partials/_dbconnect.php';

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true)
{
	header('location: ./login.php');
	exit;
}
else{
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$Fname = $_POST["first-name"];
		$Lname = $_POST["last-name"];
		$Email = $_POST["email"];
		$PhoneNo = $_POST["phone-number"];
		$Message = $_POST["message"];
		$sno = mysqli_num_rows(mysqli_query($conn, "select * from queries"));

		$validationError = false;
		$errorMessages = array();

		if (!preg_match("/^[a-zA-Z]+$/", $Fname)) {
			$validationError = true;
			$errorMessages[] = "Invalid First Name";
		} else if (!preg_match("/^[a-zA-Z]+$/", $Lname)) {
			$validationError = true;
			$errorMessages[] = "Invalid Last Name";
		} else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
			$validationError = true;
			$errorMessages[] = "Invalid Email Address";
		} else if (!preg_match("/^[0-9]{11}$/", $PhoneNo)) {
			$validationError = true;
			$errorMessages[] = "Invalid Phone Number";
		}

		// Using transactions for atomicity
		mysqli_autocommit($conn, false);

		try {
			if (!$validationError) {
				$fullname = $Fname . " " . $Lname;
				$addquery = "INSERT INTO queries (QueryID, Full_Name, Email, Phone_No, Message) 
							 VALUES ('$sno', '$fullname', '$Email' , '$PhoneNo','$Message')";
				
				// Execute the user details query
				mysqli_query($conn, $addquery);
	
				// Commit the transaction if everything is successful
				mysqli_commit($conn);
	
				echo '<script type="text/javascript">
					 alert("Query Sent Successfully.");
					 </script>';
			} 
			else {
				foreach ($errorMessages as $error) {
					echo '<script type="text/javascript">
						alert("' . $error . '");
					</script>';
				}
			}
		}
		catch (Exception $e) {
			// Rollback the transaction on failure
			mysqli_rollback($conn);
	
			echo '<script type="text/javascript">
				alert("Transaction failed: ' . $e->getMessage() . '");
			</script>';
		} finally {
			// Always turn autocommit back on, whether successful or not
			mysqli_autocommit($conn, true);
		}
	}
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us</title>
	  
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
		  <li class="nav-item fw-semibold nav-focus">
		  <a class="nav-link" href="#">Contact</a>
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
			<div class="col-sm-12 text-center">
				<div class="reg-hero-box">
					<h1 style="align-items: center; line-height: 200px;color: white; font-size: 35px; font-weight: bold;">Contact Us</h1>
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
		<h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Have any Queries?</h2>
		<p class="mt-2 text-lg leading-8 text-gray-600">Feel free to reach out to us and help us improve!</p>
	  </div>
	  <form action="#" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
		<div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
		  <div>
			<label for="first-name" class="block text-sm font-semibold leading-6 text-gray-900">First name</label>
			<div class="mt-2.5">
			  <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
			</div>
		  </div>
		  <div>
			<label for="last-name" class="block text-sm font-semibold leading-6 text-gray-900">Last name</label>
			<div class="mt-2.5">
			  <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
			</div>
		  </div>
		  <div class="sm:col-span-2">
			<label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Email</label>
			<div class="mt-2.5">
			  <input type="email" name="email" id="email" autocomplete="email" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
			</div>
		  </div>
		  <div class="sm:col-span-2">
			<label for="phone-number" class="block text-sm font-semibold leading-6 text-gray-900">Phone number</label>
			<div class="relative mt-2.5">
			  <div class="absolute inset-y-0 left-0 flex items-center">
				<label for="country" class="sr-only">Country</label>
				<select id="country" name="country" class="h-full rounded-md border-0 bg-transparent bg-none py-0 pl-4 pr-9 text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
				  <option>PK</option>
				</select>
				  <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
				</svg>
			  </div>
			  <input type="tel" name="phone-number" id="phone-number" autocomplete="tel" class="block w-full rounded-md border-0 px-3.5 py-2 pl-20 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
			</div>
		  </div>
		  <div class="sm:col-span-2">
			<label for="message" class="block text-sm font-semibold leading-6 text-gray-900">Message</label>
			<div class="mt-2.5">
			  <textarea name="message" id="message" rows="4" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
			</div>
		  </div>
		</div>
		<div class="mt-10">
		  <button style="background-color: #008773" type="submit" class="block w-full rounded-md px-3.5 py-2.5 text-center text-sm font-semibold text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Let's talk</button>
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