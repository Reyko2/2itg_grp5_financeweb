<?php
require('config.php');
if (isset($_REQUEST['firstname'])) {
  if ($_REQUEST['password'] == $_REQUEST['confirm_password']) {
    $firstname = stripslashes($_REQUEST['firstname']);
    $firstname = mysqli_real_escape_string($con, $firstname);
    $lastname = stripslashes($_REQUEST['lastname']);
    $lastname = mysqli_real_escape_string($con, $lastname);

    $email = stripslashes($_REQUEST['email']);

    function emailExists($email, $con) {
        $email = $con->real_escape_string($email);
    
        $sql = "SELECT email FROM users WHERE email = '$email'";
        $result = $con->query($sql);
    
        if ($result->num_rows > 0) {
            return true; // Email already exists
        } else {
            return false; // Email does not exist
        }
    }


    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con, $password);


    $trn_date = date("Y-m-d H:i:s");

    if ($_REQUEST['password'] != $_REQUEST['confirm_password']) 
    {
        $errormsg = '<center><div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Error!</strong> Please Re-enter Password and Confirm Password.
        </div></center>';
        echo $errormsg;  
    }
        else 
        {
        $query = "INSERT into `users` (firstname, lastname, password, email, trn_date) VALUES ('$firstname','$lastname', '" . md5($password) . "', '$email', '$trn_date')";
        $result = mysqli_query($con, $query);
        header("Location: login.php");
        }

    if (emailExists($email, $con)) 
    {
        $errormsg = '<center><div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Error!</strong> Email Has Already Been Used.
        </div></center>';
        echo $errormsg;  
    } 
    
    
  } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TUSTOS Register</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

     <!-- jQuery -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Main css -->
    <link rel="stylesheet" href="css/regstyle.css">
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

    <div class="main">

        <section class="signup">
            <!-- <img src="images/signup-bg.jpg" alt=""> -->
            <div class="container">
                <div class="signup-content">
                    <form action="" method="POST" autocomplete="off">
                        <h2 class="form-title">Create account</h2>
                        <div class="form-group">
                            <input type="text" class="form-input" name="firstname" id="name" placeholder="First Name" required="required"/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" name="lastname" id="name" placeholder="Last Name" required="required"/>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-input" name="email" id="email" placeholder="Your Email" required="required"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" name="password" id="password" placeholder="Password" required="required"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" name="confirm_password" id="confirm_password" placeholder="Confirm password" required="required"/>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                            <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Sign up"/>
                        </div>
                    </form>
                    <p class="loginhere">
                        Have already an account ? <a href="login.php" class="loginhere-link">Login here</a>
                    </p>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/regjquery.min.js"></script>
    <script src="js/regmain.js"></script>
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