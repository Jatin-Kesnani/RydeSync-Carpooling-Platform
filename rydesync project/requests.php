<?php
include 'partials/_dbconnect.php';
session_start();

$flag = true;

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true)
{
	header('location: ./login.php');
	exit;
}

if(isset($_POST["cancelbtn"]))
{
	$requestID = $_SESSION['username'];
	$offID = $_POST['riderinfoid'];
	$q = "UPDATE request SET status = 'cancelled' WHERE requestId = '$requestID' and offeringID = '$offID'";
	$result = mysqli_query($conn, $q);
	if($result)
	{
	header('location: ./requests.php');
	}
	else
	{
	$message = 'Error! Request cannot be cancelled';
	echo '<script>alert(\'' . $message . '\')</script>';
	}
}
if(isset($_POST["rejectbtn"]))
{
	$reqID = $_POST['reqId'];
	$offID = $_SESSION['username'];
	$query = "UPDATE REQUEST SET Status = 'rejected' where OfferingID = '$offID' and RequestID='$reqID' and status = 'active'";
	$rejected = mysqli_query($conn, $query);
	if($rejected)
	{
		$message = "Request Rejected!";
		echo '<script>alert(\'' . $message . '\')</script>';
	}
}

if(isset($_POST["acceptbtn"]))
{
	$reqID = $_POST['reqId'];
	$offID = $_SESSION['username'];
	
	$query = "SELECT * from Offering O join Path P on O.PathID = P.PathID where O.OfferingID = '$offID' and O.status = 'active'";
	$temp = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($temp);
	$offseats = $row['SeatsCount'];
	$acceptedPickup = $row['Pickup'];
	$acceptedDropOff = $row['DropOff'];
	
	$query = "SELECT * FROM Request WHERE RequestID = '$reqID' and OfferingID ='$offID' and status = 'active'";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	$reqseats = $row['SeatCount'];	
	
	if($reqseats > $offseats)
	{
		$message = "Error! Requested seats are more than available!";
		echo '<script>alert(\'' . $message . '\')</script>';
	}
	else
	{
		$query = "UPDATE OFFERING SET SeatsCount = SeatsCount - '$reqseats' Where OfferingID = '$offID' and status = 'active'";
		$query2 = "UPDATE REQUEST SET Status = 'accepted' WHERE RequestID = '$reqID' and OfferingID ='$offID' and status = 'active'";
		
		$res = mysqli_query($conn, $query);
		$res2 = mysqli_query($conn, $query2);
		
		if($offseats-$reqseats == 0)
		{
			$query = "INSERT INTO acceptedrides (Pickup, DropOff) Values ('$acceptedPickup', '$acceptedDropOff')";
			$res = mysqli_query($conn, $query);
			
			$rideIdQuery = "Select MAX(RideID) AS MaxRideID from acceptedrides";
			$res3 = mysqli_query($conn, $rideIdQuery);
			$row = mysqli_fetch_assoc($res3);
			$rideID = $row['MaxRideID'];
			
			$temp = "SELECT * FROM REQUEST where OfferingID = '$offID' and status='accepted'";
			$result = mysqli_query($conn, $temp);
			while($row = mysqli_fetch_assoc($result))
			{
				$userID = $row['RequestID'];
				$query1 = "INSERT INTO ridedetails (UserID, RiderID, RideID) Values ('$userID', '$offID', '$rideID')";
				$result1 = mysqli_query($conn, $query1);
				$query2 = "UPDATE REQUEST SET Status='completed' where requestID='$userID' and OfferingID = '$offID' and status='accepted'";
				$result2 = mysqli_query($conn, $query2);
			}
			
			$query = "UPDATE OFFERING SET Status = 'completed' where OfferingID = '$offID' and status='active'";
			mysqli_query($conn, $query);
			
			//jis jis ne request bheji hai sabki rejected
			$query = "UPDATE REQUEST SET Status = 'rejected' where OfferingID = '$offID' and Status = 'active'";
			$rejected = mysqli_query($conn, $query);
		}
		
	}	
}

if(isset($_POST['startridebtn']))
{
	$offID = $_SESSION['username'];
	
	$query = "SELECT * from Offering O join Path P on O.PathID = P.PathID where O.OfferingID = '$offID' and O.status = 'active'";
	$temp = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($temp);
	$offseats = $row['SeatsCount'];
	$acceptedPickup = $row['Pickup'];
	$acceptedDropOff = $row['DropOff'];

	$query = "INSERT INTO acceptedrides (Pickup, DropOff) Values ('$acceptedPickup', '$acceptedDropOff')";
	$res = mysqli_query($conn, $query);

	$rideIdQuery = "Select MAX(RideID)AS MaxRideID from acceptedrides";
	$res3 = mysqli_query($conn, $rideIdQuery);
	$row = mysqli_fetch_assoc($res3);
	$rideID = $row['MaxRideID'];

	$temp = "SELECT * FROM REQUEST where OfferingID = '$offID' and status='accepted'";
	$result = mysqli_query($conn, $temp);
	while($row = mysqli_fetch_assoc($result))
	{
		$userID = $row['RequestID'];
		$query1 = "INSERT INTO ridedetails (UserID, RiderID, RideID) Values ('$userID', '$offID', '$rideID')";
		$result1 = mysqli_query($conn, $query1);
		$query2 = "UPDATE REQUEST SET Status='completed' where requestID='$userID' and OfferingID = '$offID' and status='accepted'";
		$result2 = mysqli_query($conn, $query2);
	}

	$query = "UPDATE OFFERING SET Status = 'completed' where OfferingID = '$offID' and status='active'";
	mysqli_query($conn, $query);
	
	//jis jis ne request bheji hai sabki rejected
	$query = "UPDATE REQUEST SET Status = 'rejected' where OfferingID = '$offID' and Status = 'active'";
	$rejected = mysqli_query($conn, $query);
}


if(isset($_POST['feedbackbtn']))
{
	$offID2 = $_POST['riderOffID'];
	$offNo2 = $_POST['riderOffNo'];
	$userID2 = $_SESSION['username'];
	$_SESSION['feedbackOffNo'] = $offNo2;
	$_SESSION['feedbackUserId'] = $userID2;
	$_SESSION['feedbackOffId'] = $offID2;
	header('location: ./feedback.php');
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Requests</title>
	  
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
			<li class="nav-item fw-semibold nav-focus">
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
			<div class="col-sm-12 text-center">
				<div class="reg-hero-box"> <!--ye requests heading rider ke paas ayegi and passenger ke paas my requests ayega-->
					<h1 style="align-items: center; line-height: 200px;color: white; font-size: 35px; font-weight: bold;">Requests</h1>
				</div>
			</div>
		</div> 
		 </div>
	  </section>

	<section class="container-lg">
		<div class="mx-auto max-w-2xl text-center">
		<h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Review your Requests</h2>
		<p class="mt-2 text-lg leading-8 text-gray-600">view your requests, cancel anytime and view past requests.</p>
	  </div>
		<br><br>
		<div class='flex justify-center'>
    	<div class="flex">
        <div class="overflow-x-auto relative">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr><?php
					if ($_SESSION['role'] == 'r')
						{echo '<th scope="col" class="py-3 px-6">Passenger Name</th>';}
					else
                    	{echo '<th scope="col" class="py-3 px-6">Driver Name</th>';}?>
                    <th scope="col" class="py-3 px-6">Amount Offered</th>
                    <th scope="col" class="py-3 px-6">No of seats requested</th>
                    <th scope="col" class="py-3 px-6">Message</th>
                    <th scope="col" class="py-3 px-6">Status</th>
					<?php
					if($_SESSION['role'] == 'r')
                    	echo'<th scope="col" class="py-3 px-6">Operation</th>';
					?>
                </tr>
                </thead>
                <tbody>
					<?php
						if ($_SESSION['role'] == 'p') {
							$username = $_SESSION['username'];
							$query = "select * from request r join offering o on r.OfferingID = o.OfferingID where r.requestId = '$username' and r.status = 'active' and o.status = 'active'";
							$res = mysqli_query($conn, $query);
							$row = null;
							if (mysqli_num_rows($res) > 0) {
								while ($row = mysqli_fetch_assoc($res)) {
									$rider = mysqli_fetch_assoc(mysqli_query($conn, "select * from user where username = '{$row['OfferingID']}'"));
						?>
									<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
										<td class="py-4 px-6"><?php echo $rider['Full_Name']; ?></td>
										<td class="py-4 px-6"><?php echo $row['Amount']; ?></td>
										<td class="py-4 px-6"><?php echo $row['SeatCount']; ?></td>
										<td class="py-4 px-6"><?php echo $row['Comments']; ?></td>
										<td class="py-4 px-6">
											<form method="POST" > <input type="hidden" name="riderinfoid" id="riderinfoid" value="<?php echo $row['OfferingID'] ?>">
												<button type="submit" name="cancelbtn" id="cancelbtn" class="btn btn-danger">Cancel</button>
											</form>
										</td>
									</tr>
						<?php
								}
							}
						}
						else if($_SESSION['role'] == 'r')
						{
							$username = $_SESSION['username'];
							$query = "select * from request where offeringId = '$username' and status = 'active'";
							$res = mysqli_query($conn, $query);
							$row = null;
							if (mysqli_num_rows($res) > 0) {
								while ($row = mysqli_fetch_assoc($res)) {
									$pas = mysqli_fetch_assoc(mysqli_query($conn, "select * from user where username = '{$row['RequestID']}'"));
						?>
									<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
										<td class="py-4 px-6"><?php echo $pas['Full_Name']; ?></td>
										<td class="py-4 px-6"><?php echo $row['Amount']; ?></td>
										<td class="py-4 px-6"><?php echo $row['SeatCount']; ?></td>
										<td class="py-4 px-6"><?php echo $row['Comments']; ?></td>
										<td class="py-4 px-6"><?php echo $row['Status']; ?></td>
										<td class="py-4 px-6"><?php

											{
											?>
											<form method="POST" > <input type="hidden" name="riderinfoid" id="riderinfoid" value="<?php echo $row['OfferingID'] ?>"><br>
												<input type="hidden" id="reqId" name="reqId" value="<?php echo $row['RequestID'] ?>"> 
												<button type="submit" name="acceptbtn" id="acceptbtn" class="btn btn-success">Accept</button>
												<button type="submit" name="rejectbtn" id="rejectbtn" class="btn btn-danger">Reject</button>
											</form><?php } ?>
										</td>
									</tr>
						<?php
								}
							}
							else
							{
								$query = "select * from request where offeringId = '$username' and status = 'accepted'";
								$res = mysqli_query($conn, $query);
								if (mysqli_num_rows($res) == 0)
								{
									$flag = false;
								}
							}
						}
						?>
										</tbody>
									</table>
							</div>
						</div>	
</div>
<br>
<br>
<div class="mx-auto max-w-2xl text-center">
	
	<?php
	if($_SESSION['role'] == 'r' && $flag == true)
	{
		echo'<form method="post">
			<button type="submit" name="startridebtn" id="startridebtn" class="btn btn-success">Start My Ride</button>
		</form>';
	}
	?>
	
		<br><br>
		<h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Past Requests</h2>
	  </div>

<br><br><br>
<div class='flex justify-center'>
    	<div class="flex">
        <div class="overflow-x-auto relative">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">Driver Name</th>
                    <th scope="col" class="py-3 px-6">Amount Offered</th>
                    <th scope="col" class="py-3 px-6">No of seats requested</th>
                    <th scope="col" class="py-3 px-6">Message</th>
                    <th scope="col" class="py-3 px-6">Status</th>
					<?php
					if($_SESSION['role'] == 'p')
                    	echo'<th scope="col" class="py-3 px-6">Operation</th>';
					?>
                </tr>
                </thead>
                <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
				<?php
						if ($_SESSION['role'] == 'p') {
							$username = $_SESSION['username'];
							$query = "select * from request where requestId = '$username' and status != 'active'";
							$res = mysqli_query($conn, $query);
							$row = null;
							if (mysqli_num_rows($res) > 0) {
								while ($row = mysqli_fetch_assoc($res)) {
									$rider = mysqli_fetch_assoc(mysqli_query($conn, "select * from user where username = '{$row['OfferingID']}'"));
						?>
									<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
										<td class="py-4 px-6"><?php echo $rider['Full_Name']; ?></td>
										<td class="py-4 px-6"><?php echo $row['Amount']; ?></td>
										<td class="py-4 px-6"><?php echo $row['SeatCount']; ?></td>
										<td class="py-4 px-6"><?php echo $row['Comments']; ?></td>
										<td class="py-4 px-6"><?php echo $row['Status']; ?></td>
										<td class="py-4 px-6"><?php
											
											if($row['Status'] == 'completed')
											{
												$query="select*from offering where OfferingID = '{$row['OfferingID']}' and Status='completed'";
												$r = mysqli_query($conn, $query);
												$row = mysqli_fetch_assoc($r);
												$offNo = $row['OfferingNo'];
											?>
											<form method="POST" >
												<input type="hidden" name="riderOffNo" id="riderOffNo" value="<?php echo $offNo ?>">
												<input type="hidden" name="riderOffID" id="riderOffID" value="<?php echo $row['OfferingID'] ?>">
												<button type="submit" name="feedbackbtn" id="feedbackbtn" class="btn btn-dark">Feedback</button>
											</form>
											<?php }
											else{
												echo'<p>N/A</p>';
											}
											
											?>
										</td>
									</tr>
						<?php
								}
							}
						}
						else if($_SESSION['role'] == 'r')
						{
							$username = $_SESSION['username'];
							$query = "select * from request where offeringId = '$username' and status != 'active'";
							$res = mysqli_query($conn, $query);
							$row = null;
							if (mysqli_num_rows($res) > 0) {
								while ($row = mysqli_fetch_assoc($res)) {
									$pas = mysqli_fetch_assoc(mysqli_query($conn, "select * from user where username = '{$row['RequestID']}'"));
						?>
									<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
										<td class="py-4 px-6"><?php echo $pas['Full_Name']; ?></td>
										<td class="py-4 px-6"><?php echo $row['Amount']; ?></td>
										<td class="py-4 px-6"><?php echo $row['SeatCount']; ?></td>
										<td class="py-4 px-6"><?php echo $row['Comments']; ?></td>
										<td class="py-4 px-6"><?php echo $row['Status']; ?></td>
									</tr>
						<?php
								}
							}

						}
						?>
                </tr>
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
	  
  </body>
</html>