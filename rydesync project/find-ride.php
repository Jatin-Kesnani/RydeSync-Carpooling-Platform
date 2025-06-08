<?php
	include 'partials/_dbconnect.php';
	session_start();
	$searchflag = 0;
	if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true)
	{
		header('location: ./login.php');
		exit;
	}
	if($_SESSION['role'] != 'p')
	{
		header('location: ./index.php');
	}	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(isset($_POST["srchbtn"]))
		{
			$searchflag = 1;
			$from = $_POST["from"];
			$to = $_POST["to"];
			$date = $_POST["date"];
			$time = $_POST["time"];
			$username = $_SESSION['username'];

			$search1 = "
			SELECT * FROM OFFERING O Join Path P on O.PathID = P.PathID
			WHERE status = 'active' and
			P.Pickup LIKE '%$from%' and 
			(P.DropOff LIKE '%$to%' OR P.P1 LIKE '%$to%'  OR P.P2 LIKE '%$to%')
			";

			$search2 = "
			SELECT * FROM OFFERING O Join Path P on O.PathID = P.PathID
			WHERE status = 'active' and
			P.P1 LIKE '%$from%' and 
			(P.DropOff LIKE '%$to%' OR P.P2 LIKE '%$to%')
			";

			$search3 = "
			SELECT * FROM OFFERING O Join Path P on O.PathID = P.PathID
			WHERE status = 'active' and
			P.P2 LIKE '%$from%' and 
			P.DropOff LIKE '%$to%'
			";

			$sr1 = mysqli_query($conn, $search1);
			$sr2 = mysqli_query($conn, $search2);
			$sr3 = mysqli_query($conn, $search3);
		}
		if(isset($_POST["reqbtn1"]))
		{
			$_SESSION["requestedRider"] = $_POST["reqrider1"];
			header('location: ./make-request.php');
		}
		if(isset($_POST["reqbtn2"]))
		{
			$_SESSION["requestedRider"] = $_POST["reqrider2"];
			header('location: ./make-request.php');
		}
		if(isset($_POST["reqbtn3"]))
		{
			$_SESSION["requestedRider"] = $_POST["reqrider3"];
			header('location: ./make-request.php');
		}
		if(isset($_POST["reqbtn4"]))
		{
			$_SESSION["requestedRider"] = $_POST["reqrider4"];
			header('location: ./make-request.php');
		}
	}


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Find a Ride</title>
	  
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
					<h1 style="align-items: center; line-height: 200px;color: white; font-size: 35px; font-weight: bold;">Find a Ride</h1>
				</div>
			</div>
		</div> 
		 </div>
	  </section>
	  
	<section class="container-lg">
	  <section class="search-sec">
				<div class="container">
					<h2 style="margin-bottom: 25px; color: #5a4fc5;">Need a Ride?</h2>
					
					
					<form action="#" method="post" novalidate="novalidate">
						<div class="row">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 p-0">
										<label for="from" class="block text-sm font-semibold leading-6 text-gray-900">From</label>
										<input name="from" id="from" type="text" class="form-control search-slt" placeholder="Leaving From..." required>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 p-0">
										<label for="To" class="block text-sm font-semibold leading-6 text-gray-900">To</label>
										<input name="to" id="to" type="text" class="form-control search-slt" placeholder="Going to..." required>
									</div>
								</div>
							</div>
						</div>
						<br><br>
						<div class="row">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 p-0">
										<label for="date" class="block text-sm font-semibold leading-6 text-gray-900">Date</label>
										<input name="date" id="date" type="date" class="form-control search-slt" placeholder="" required>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 p-0">
										<label for="time" class="block text-sm font-semibold leading-6 text-gray-900">Time</label>
										<input name="time" id="time" type="time" class="form-control search-slt" placeholder="" required>
									</div>
								</div>
							</div>
						</div>
						<br><br>
						<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 p-0">
							<button name="srchbtn" id="srchbtn" type="submit" class="btn wrn-btn">Search</button>
						</div>
						</div>
					</form>

				</div>
		</section>
	  
		<div class="mx-auto max-w-2xl text-center">
		<h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Filter and Browse Rides.</h2>
		<p class="mt-2 text-lg leading-8 text-gray-600">find the perfect ride for you and make a request!</p>
	  </div>
		<br><br>
		<div class='flex justify-center'>
    	<div class="flex">
        <div class="overflow-x-auto relative">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">Driver Name</th>
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
				<form method="post" >
                <?php
				if($searchflag == 0)
				{
					$find = "SELECT * FROM OFFERING O JOIN Path P ON O.PathId = P.PathId WHERE O.status = 'active'";
					$result = mysqli_query($conn, $find);

					while ($row = mysqli_fetch_assoc($result))
					{
						$temp = $row['OfferingID'];
						$query = "SELECT * FROM USER WHERE Username='$temp'";
						$r = mysqli_query($conn, $query);
						$riderInfo = mysqli_fetch_assoc($r);
						?>
						<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
							<input type="hidden" name="reqrider1" id="reqrider1" value="<?php echo $temp ?>">
							<td class="py-4 px-6"><?php echo $riderInfo['Full_Name']; ?></td>
							<td class="py-4 px-6"><?php echo $row['Pickup']; ?></td>
							<td class="py-4 px-6"><?php echo $row['P1']; ?></td>
							<td class="py-4 px-6"><?php echo $row['P2']; ?></td>
							<td class="py-4 px-6"><?php echo $row['DropOff']; ?></td>
							<td class="py-4 px-6"><?php echo $row['SeatsCount']; ?></td>
							<td class="py-4 px-6"><?php echo $row['Amount']; ?></td>
							<td class="py-4 px-6"><?php echo $row['DeptDate']; ?></td>
							<td class="py-4 px-6"><?php echo $row['DeptTime']; ?></td>
							<td class="py-4 px-6"><button name="reqbtn1" id="reqbtn1" type="submit" class="btn btn-success">Make Request</button></td>
						</tr>
					</form>
					<form method="post">
					<?php
					}
				}
				else
				{
					while ($row = mysqli_fetch_assoc($sr1))
					{
						$temp = $row['OfferingID'];
						$query = "SELECT * FROM USER WHERE Username='$temp'";
						$r = mysqli_query($conn, $query);
						$riderInfo = mysqli_fetch_assoc($r);
						?>
						<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
							<input type="hidden" name="reqrider2" id="reqrider2" value="<?php echo $temp ?>">
							<td class="py-4 px-6"><?php echo $riderInfo['Full_Name']; ?></td>
							<td class="py-4 px-6"><?php echo $row['Pickup']; ?></td>
							<td class="py-4 px-6"><?php echo $row['P1']; ?></td>
							<td class="py-4 px-6"><?php echo $row['P2']; ?></td>
							<td class="py-4 px-6"><?php echo $row['DropOff']; ?></td>
							<td class="py-4 px-6"><?php echo $row['SeatsCount']; ?></td>
							<td class="py-4 px-6"><?php echo $row['Amount']; ?></td>
							<td class="py-4 px-6"><?php echo $row['DeptDate']; ?></td>
							<td class="py-4 px-6"><?php echo $row['DeptTime']; ?></td>
							<td class="py-4 px-6"><button name="reqbtn2" id="reqbtn2" type="submit" class="btn btn-success">Make Request</button></td>
						</tr>
					</form>
					<form method="post">
					<?php
					}
					while ($row = mysqli_fetch_assoc($sr2))
					{
						$temp = $row['OfferingID'];
						$query = "SELECT * FROM USER WHERE Username='$temp'";
						$r = mysqli_query($conn, $query);
						$riderInfo = mysqli_fetch_assoc($r);
						?>
						<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
							<input type="hidden" name="reqrider3" id="reqrider3" value="<?php echo $temp ?>">
							<td class="py-4 px-6"><?php echo $riderInfo['Full_Name']; ?></td>
							<td class="py-4 px-6"><?php echo $row['Pickup']; ?></td>
							<td class="py-4 px-6"><?php echo $row['P1']; ?></td>
							<td class="py-4 px-6"><?php echo $row['P2']; ?></td>
							<td class="py-4 px-6"><?php echo $row['DropOff']; ?></td>
							<td class="py-4 px-6"><?php echo $row['SeatsCount']; ?></td>
							<td class="py-4 px-6"><?php echo $row['Amount']; ?></td>
							<td class="py-4 px-6"><?php echo $row['DeptDate']; ?></td>
							<td class="py-4 px-6"><?php echo $row['DeptTime']; ?></td>
							<td class="py-4 px-6"><button name="reqbtn3" id="reqbtn3" type="submit" class="btn btn-success">Make Request</button></td>
						</tr>
					</form>
					<form method="post">
					<?php
					}
					while ($row = mysqli_fetch_assoc($sr3))
					{
						$temp = $row['OfferingID'];
						$query = "SELECT * FROM USER WHERE Username='$temp'";
						$r = mysqli_query($conn, $query);
						$riderInfo = mysqli_fetch_assoc($r);
						?>
						<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
							<input type="hidden" name="reqrider4" id="reqrider4" value="<?php echo $temp ?>">
							<td class="py-4 px-6"><?php echo $riderInfo['Full_Name']; ?></td>
							<td class="py-4 px-6"><?php echo $row['Pickup']; ?></td>
							<td class="py-4 px-6"><?php echo $row['P1']; ?></td>
							<td class="py-4 px-6"><?php echo $row['P2']; ?></td>
							<td class="py-4 px-6"><?php echo $row['DropOff']; ?></td>
							<td class="py-4 px-6"><?php echo $row['SeatsCount']; ?></td>
							<td class="py-4 px-6"><?php echo $row['Amount']; ?></td>
							<td class="py-4 px-6"><?php echo $row['DeptDate']; ?></td>
							<td class="py-4 px-6"><?php echo $row['DeptTime']; ?></td>
							<td class="py-4 px-6"><button name="reqbtn4" id="reqbtn4" type="submit" class="btn btn-success"><a href="./make-request.php" style="text-decoration: none; color: white">Make Request</a></button></td>
						</tr>
					</form>
					<?php
					}
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
	  
  </body>
</html>