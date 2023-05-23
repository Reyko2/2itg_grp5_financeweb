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
	<link rel = "icon" href = "icon\TUSTOS ICON.png" type = "image/x-icon">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="assets/css/Features-Boxed.css">
    <link rel="stylesheet" href="assets/css/Highlight-Phone.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/loginstyle.css">

	</head>
	<body style="background-color: #1E1E1E">

	
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
	            <div class="form-group row">
				<div class="col-sm-6">
					<div class="form-check">
					<input type="checkbox" class="form-check-input" id="rememberCheckbox" checked>
					<label class="form-check-label" for="rememberCheckbox">Remember Me</label>
					</div>
				</div>
				</div>
	            <div class="form-group">
	            	<button type="submit" class="btn btn-primary rounded submit p-3 px-5" style="border-radius:0%">Login</button>
	            </div>
	          </form>

			  <br><br><br><br><p class="text-center">Don't have an account?<a href="register.php" > Register Here</a></p>
	        </div>			
				</div>				
			</div>		
		</div>	
	</section>

	<script>
  // Add this code to handle the checkbox behavior
  $(document).ready(function() {
    $('.checkbox-wrap input[type="checkbox"]').change(function() {
      if ($(this).is(":checked")) {
        $(this).closest('.checkbox-wrap').addClass("checked");
      } else {
        $(this).closest('.checkbox-wrap').removeClass("checked");
      }
    });
  });
</script>
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

