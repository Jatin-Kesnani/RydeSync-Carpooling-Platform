<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    $Fname = $_POST["first-name"];
    $Lname = $_POST["last-name"];
    $Email = $_POST["email"];
    $Country = $_POST["country"];
    $PhoneNo = $_POST["phone"];
    $St = $_POST["street-address"];
    $city = $_POST["city"];
    $State = $_POST["region"];
    $ZIP = $_POST["postal-code"];
    $accType = $_POST["AccountType"];

    $validationError = false;
    $errorMessages = array();

    if (!preg_match("/^[a-zA-Z]+$/", $Fname)) {
        $validationError = true;
        $errorMessages[] = "Invalid First Name";
    }

    else if (!preg_match("/^[a-zA-Z]+$/", $Lname)) {
        $validationError = true;
        $errorMessages[] = "Invalid Last Name";
    }

    else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $validationError = true;
        $errorMessages[] = "Invalid Email Address";
    }

    else if (!preg_match("/^[0-9]{11}$/", $PhoneNo)) {
        $validationError = true;
        $errorMessages[] = "Invalid Phone Number";
    }
    
    // Using transactions for atomicity
    mysqli_autocommit($conn, false);

    try {
      $checkUsernameQuery = "SELECT * FROM user WHERE Username='$username'";
      $checkUsernameResult = mysqli_query($conn, $checkUsernameQuery);
      if (mysqli_num_rows($checkUsernameResult) > 0) {
          echo '<script type="text/javascript">
              alert("Username already exists. Please choose a different username.");
              </script>';
          $validationError = true;
      } 

      if (!$validationError) {
          $fullname = $Fname . " " . $Lname;
          $userDet = "INSERT INTO user (Username, Full_Name, Phone_No, UserType, email) VALUES ('$username', '$fullname', '$PhoneNo','$accType', '$Email')";
          $credentials = "INSERT INTO credentials (username, password) VALUES ('$username', '$password')";
          $address = "INSERT INTO address (userID, country, city, state,street, postalcode) VALUES ('$username', '$Country', '$city', '$State','$St', '$ZIP')";
          mysqli_query($conn, $userDet);
          mysqli_query($conn, $credentials);
          mysqli_query($conn, $address);

          // Commit the transaction if everything is successful
          mysqli_commit($conn);

          echo '<script type="text/javascript">
              alert("Registration Successful. Kindly Log-In");
              </script>';
      } else {
          foreach ($errorMessages as $error) {
              echo '<script type="text/javascript">
                  alert("' . $error . '");
              </script>';
          }
      }
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
    <title>Register</title>
	  
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
		  <a class="nav-link d-lg-none nav-focus" href="./register.php">Sign Up</a>
		</li>
			<li class="nav-item fw-semibold">
		  <a class="nav-link d-lg-none" href="./login.php">Sign In</a>
		</li> 
		</ul>
			<button class="btn btn-login d-none d-lg-block"><a href="./login.php">Sign In</a></button>
		</div>
		</div>
	</nav>
	  
	  <section class="hero">
		<div class="container-lg">
			<div class="row align-items-center">
			<div class="col-sm-12 text-center">
				<div class="reg-hero-box">
						<h1 style="align-items: center; line-height: 200px;color: white; font-size: 35px; font-weight: bold;">Register</h1>
				</div>
			</div>
		</div> 
		 </div>
	  </section>
	  <section class="reg-form">
	  	<div class="container-lg">
  <form id="registrationForm" method="POST" onsubmit="return validateForm(event)">
  <div class="space-y-12">
    <div class="border-b border-gray-900/10 pb-12">
      <h2 class="text-base font-semibold leading-7 text-gray-900">Profile</h2>
      <p class="mt-1 text-sm leading-6 text-gray-600">This information will be displayed publicly so be careful what you share.</p>

      <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-4">
          <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
          <div class="mt-2">
            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
              <input type="text" name="username" id="username" autocomplete="username" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 input-color" placeholder="janesmith" required>
            </div>
          </div>
        </div>
		
		 <div class="sm:col-span-4">
          <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
          <div class="mt-2">
            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
              <input type="password" name="password" id="password" autocomplete="password" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 input-color" placeholder="**" required>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="border-b border-gray-900/10 pb-12">
      <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
      <p class="mt-1 text-sm leading-6 text-gray-600">Use a permanent address where you can receive mail.</p>

      <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-3">
          <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">First name</label>
          <div class="mt-2">
            <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
          </div>
        </div>

        <div class="sm:col-span-3">
          <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Last name</label>
          <div class="mt-2">
            <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
          </div>
        </div>

        <div class="sm:col-span-4">
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
          <div class="mt-2">
            <input id="email" name="email" type="email" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
          </div>
        </div>

        <div class="sm:col-span-3">
          <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Country</label>
          <div class="mt-2">
            	<input id="country" name="country" type="text" autocomplete="country" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
          </div>
        </div>
		  
		<div class="sm:col-span-3">
          <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Phone No</label>
          <div class="mt-2">
            	<input id="phone" name="phone" type="number" autocomplete="phone" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
          </div>
        </div>

        <div class="col-span-full">
          <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Street</label>
          <div class="mt-2">
            <input type="text" name="street-address" id="street-address" autocomplete="street-address" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
          </div>
        </div>

        <div class="sm:col-span-2 sm:col-start-1">
          <label for="city" class="block text-sm font-medium leading-6 text-gray-900">City</label>
          <div class="mt-2">
            <input type="text" name="city" id="city" autocomplete="address-level2" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
          </div>
        </div>

        <div class="sm:col-span-2">
          <label for="region" class="block text-sm font-medium leading-6 text-gray-900">State / Province</label>
          <div class="mt-2">
            <input type="text" name="region" id="region" autocomplete="address-level1" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
          </div>
        </div>

        <div class="sm:col-span-2">
          <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">ZIP / Postal code</label>
          <div class="mt-2">
            <input type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
          </div>
        </div>

        <div class="sm:col-span-2">
            <label for="AccountType" class="block text-sm font-medium leading-6 text-gray-900">Account Type</label>
            <select id="AccountType" name="AccountType" class="form-select" aria-label="Default select example">
			  <option value="p">Passenger</option>
			  <option value="r">Rider</option>
			</select>
         </div>
        </div>
      </div>
    </div>
  </div>
  <div class="mt-4 flex items-center justify-center gap-x-60">
        <button style="background-color: #008773" type="submit"
                class="rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register
        </button>
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
  <script>
    function validateForm(event) {
    // Add any additional client-side validation here if needed

    // Example: Check if validation is successful
      if (/* your validation conditions */) {
          return true; // Allow form submission
      } else {
          alert("Validation failed. Please check your inputs.");
          event.preventDefault(); // Prevent form submission
          return false;
      }
    }
  </script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>  
	  
  </body>
</html>