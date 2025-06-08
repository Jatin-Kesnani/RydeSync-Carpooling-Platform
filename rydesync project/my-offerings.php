<?php
include 'partials/_dbconnect.php';

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

if(isset($_POST["cancelbtn"]))
{
	$offID = $_SESSION['username'];
	$query = "UPDATE OFFERING SET status = 'cancelled' WHERE OfferingID = '$offID' and Status = 'active'";
	$cancelled = mysqli_query($conn, $query);
	if($cancelled)
	{
		//mujhe kisne request bheji hai unsabki rejected
		$query = "UPDATE REQUEST SET Status = 'rejected' where OfferingID = '$offID' and Status = 'active'";
		$rejected = mysqli_query($conn, $query);
		if($rejected)
		{
			$message = "your received requests have been rejected!";
			echo '<script>alert(\'' . $message . '\')</script>';
		}
		header('location: ./my-offerings.php');
	}
	else
	{
		$message = 'Error! Offering cannot be cancelled'; 
		echo '<script>alert(\'' . $message . '\')</script>';
	}
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Offerings</title>
	  
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
				echo'<li class="nav-item fw-semibold nav-focus">';
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
			<div class="col-sm-12 text-center">
				<div class="reg-hero-box">
					<h1 style="align-items: center; line-height: 200px;color: white; font-size: 35px; font-weight: bold;">My Offerings</h1>
				</div>
			</div>
		</div> 
		 </div>
	  </section>

	<section class="container-lg">
		<div class="mx-auto max-w-2xl text-center">
		<h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Review your Offerings</h2>
		<p class="mt-2 text-lg leading-8 text-gray-600">view your offerings, cancel anytime and view past offerings.</p>
	  </div>
		<br><br>
		<div class='flex justify-center'>
    	<div class="flex">
        <div class="overflow-x-auto relative">
		<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    	<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="py-3 px-6">From</th>
            <th scope="col" class="py-3 px-6">Point 1</th>
            <th scope="col" class="py-3 px-6">Point 2</th>
            <th scope="col" class="py-3 px-6">To</th>
            <th scope="col" class="py-3 px-6">No of Seats</th>
            <th scope="col" class="py-3 px-6">Amount</th>
            <th scope="col" class="py-3 px-6">Departure Date</th>
            <th scope="col" class="py-3 px-6">Departure Time</th>
            <th scope="col" class="py-3 px-6">Operation</th>
        </tr>
    </thead>
    <tbody>
        <?php
		
        $offId = $_SESSION['username'];
        $find = "SELECT * FROM OFFERING O JOIN Path P ON O.PathId = P.PathId WHERE O.OfferingID = '$offId' AND O.status = 'active'";
        $result = mysqli_query($conn, $find);

        $row = mysqli_fetch_assoc($result);
		if(mysqli_num_rows($result) > 0)
		{
            ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-4 px-6"><?php echo $row['Pickup']; ?></td>
                <td class="py-4 px-6"><?php echo $row['P1']; ?></td>
                <td class="py-4 px-6"><?php echo $row['P2']; ?></td>
                <td class="py-4 px-6"><?php echo $row['DropOff']; ?></td>
                <td class="py-4 px-6"><?php echo $row['SeatsCount']; ?></td>
                <td class="py-4 px-6"><?php echo $row['Amount']; ?></td>
                <td class="py-4 px-6"><?php echo $row['DeptDate']; ?></td>
                <td class="py-4 px-6"><?php echo $row['DeptTime']; ?></td>
				<form method="post">
                <td class="py-4 px-6"><button name="cancelbtn" id="cancelbtn" type="submit" class="btn btn-danger">Cancel</button></td>
				</form>
            </tr>
			<?php
		}
			
			?>
    </tbody>
</table>
</div>
</div>
</div>
<br><br>
<div class="mx-auto max-w-2xl text-center">
		<h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Past Offerings</h2>
	  </div>

<br><br><br>
<div class='flex justify-center'>
    	<div class="flex">
        <div class="overflow-x-auto relative">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="py-3 px-6">From</th>
            <th scope="col" class="py-3 px-6">Point 1</th>
            <th scope="col" class="py-3 px-6">Point 2</th>
            <th scope="col" class="py-3 px-6">To</th>
            <th scope="col" class="py-3 px-6">No of Seats</th>
            <th scope="col" class="py-3 px-6">Amount</th>
            <th scope="col" class="py-3 px-6">Departure Date</th>
            <th scope="col" class="py-3 px-6">Departure Time</th>
            <th scope="col" class="py-3 px-6">Operation</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $offId = $_SESSION['username'];
        $find = "SELECT * FROM OFFERING O JOIN Path P ON O.PathId = P.PathId WHERE O.OfferingID = '$offId' AND status <> 'active'";
        $result = mysqli_query($conn, $find);

        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-4 px-6"><?php echo $row['Pickup']; ?></td>
                <td class="py-4 px-6"><?php echo $row['P1']; ?></td>
                <td class="py-4 px-6"><?php echo $row['P2']; ?></td>
                <td class="py-4 px-6"><?php echo $row['DropOff']; ?></td>
                <td class="py-4 px-6"><?php echo $row['SeatsCount']; ?></td>
                <td class="py-4 px-6"><?php echo $row['Amount']; ?></td>
                <td class="py-4 px-6"><?php echo $row['DeptDate']; ?></td>
                <td class="py-4 px-6"><?php echo $row['DeptTime']; ?></td>
                <td class="py-4 px-6">N/A</td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

    </div>
</div>
</div>
		<br><br><br>
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
	  
	 <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  </body>
</html>

