<?php
require('config.php');
session_start();
$errormsg = "";
if (isset($_POST['email'])) {

  $email = stripslashes($_REQUEST['email']);
  $email = mysqli_real_escape_string($con, $email);
  $password = stripslashes($_REQUEST['password']);
  $password = mysqli_real_escape_string($con, $password);
  $query = "SELECT * FROM `users` WHERE email='$email'and password='" . md5($password) . "'";
  $result = mysqli_query($con, $query) or die(mysqli_error($con));
  $rows = mysqli_num_rows($result);
  if ($rows == 1) {
    $_SESSION['email'] = $email;
    header("Location: index.php");
  } else {
	$errormsg = '<center><div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error!</strong> Incorrect Email or Password!
    </div></center>';
    echo $errormsg;
  }
} else {
}
?>

<!doctype html>
<html lang="en">
  <head>
  	<title>TUSTOS Login Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/loginstyle.css">
	<link rel="stylesheet" href="assets/css/Features-Boxed.css">
    <link rel="stylesheet" href="assets/css/Highlight-Phone.css">

	</head>
	<body style="background-color: #1E1E1E">

	<nav class="navbar navbar-dark navbar-expand-lg fixed-top navbar-custom" style="background: linear-gradient(90deg, #6fb1bf 32%, #0085ff 100%, #6fb1bf 100%), #0085ff;">
        <div class="container"><a class="navbar-brand" href="homepage.php" style="font-size: 23px;margin-left: -27px;color: rgb(255,255,255);">TUSTOS</a><img class="img-fluid justify-content-xxl-center" src="assets/img/TUSTOS%20ICON.png" style="height: 50px;"><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navbarResponsive"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="aboutus.php" style="color: rgb(255,255,255);font-size: 14.8px;width: 114.938px;text-align: center;">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php" style="color: rgb(255,255,255);font-size: 14.8px;width: 85.938px;text-align: center;">Sign Up</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php" style="color: rgb(255,255,255);font-size: 14.8px;width: 85.938px;text-align: center;">Log In</a></li>
                </ul>
            </div>
        </div>
    </nav>
	
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
		      	<div class="icon d-flex align-items-center justify-content-center">
		      		<span class="fa fa-user-o"></span>
		      	</div>
		      	<h3 class="text-center mb-4">Login your Account</h3>
						<form action="#" method="POST" class="login-form">
		      		<div class="form-group">
		      			<input type="text" name="email" class="form-control rounded-left" placeholder="Email" required>
		      		</div>
	            <div class="form-group d-flex">
	              <input type="password" name="password" class="form-control rounded-left" placeholder="Password" required>
	            </div>
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
	            		<label class="checkbox-wrap checkbox-primary">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="#">Forgot Password</a>
								</div>
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="btn btn-primary rounded submit p-3 px-5" style="border-radius:0%">Login</button>
	            </div>
	          </form>

			  <br><br><br><br><p class="text-center">Don't have an account?<a href="register.php" class="text-danger"> Register Here</a></p>
	        </div>			
				</div>				
			</div>		
		</div>	
	</section>

  <script src="js/ljquery.min.js"></script>
  <script src="js/lpopper.js"></script>
  <script src="js/lbootstrap.min.js"></script>
  <script src="js/lmain.js"></script>
	</body>
	<script>
		$("#menu-toggle").click(function(e) {
		  e.preventDefault();
		  $("#wrapper").toggleClass("toggled");
		});
	  </script>
	  <script>
		feather.replace()
	  </script>
</html>

