<?php

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	include 'partials/_dbconnect.php';
	$username = $_POST["username"];
	$password = $_POST["password"];
	$showAlert = false;
    $showError = false;

	// Using transactions for read-only operations
    mysqli_autocommit($conn, false);
	try {
		$sql = "select * from credentials where Username='$username' AND Password='$password'";
		$result = mysqli_query($conn, $sql);
		$num = mysqli_num_rows($result);
		if($num == 1)
		{
			echo '<script>alert("login successful")</script>';
			$sql = "Select * from user where username='$username'";
			$result = mysqli_query($conn, $sql);
			$userinfo = mysqli_fetch_assoc($result);
			session_start();
			if($result)
			{
				$showAlert = true;
				$_SESSION['loggedin'] = true;
				$_SESSION['username'] = $username;
				$_SESSION['role'] = $userinfo["UserType"];
				
				header("location: ./index.php");
			}
		}
		else
		{
			echo '<script>alert("login failed")</script>';
			$showError = "Username or Password Do not Match";
		}
		// Commit the transaction if everything is successful
        mysqli_commit($conn);
	} catch (Exception $e) {
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

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
	  
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
		<li class="nav-item fw-semibold">
		  <a class="nav-link" href="./offer-ride.php">Offer Rides</a>
		</li>
		<li class="nav-item fw-semibold">
		  <a class="nav-link" href="./find-ride.php">Find Rides</a>
		</li>
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
		  <a class="nav-link d-lg-none nav-focus" href="./login.php">Sign In</a>
		</li> 
		</ul>
		<button class="btn btn-login-focus d-none d-lg-block">Sign In</button>
		</div>
		</div>
	</nav>
	  
	  <section class="hero">
		<div class="container-lg">
			<div class="row align-items-center">
			<div class="col-sm-12 text-center">
				<div class="reg-hero-box">
						<h1 style="align-items: center; line-height: 200px;color: white; font-size: 35px; font-weight: bold;">Sign In</h1>
				</div>
			</div>
		</div> 
		 </div>
	  </section>
	  <section class="reg-form">
	 <div class="container-lg">
	<div style="border: 2px dashed black;" class="flex min-h-full flex-col justify-center px-6 py-6 lg:px-8">
    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
	  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
		<form class="space-y-6" action="#" method="POST">
		  <div>
			<label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
			<div class="mt-2">
			  <input id="username" name="username" type="text" autocomplete="username" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
			</div>
		  </div>

		  <div>
			<div class="flex items-center justify-between">
			  <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
			</div>
			<div class="mt-2">
			  <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
			</div>
		  </div>

		  <div>
			<button style="background-color: #008773" type="submit" class="flex w-full justify-center rounded-md px-3 py-1.5 text-sm font-semibold leading-6 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
		  </div>
			<p>Don't have an account? <a href="./register.php">Register</a></p>
		</form>
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