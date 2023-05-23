<?php
include("session.php");
$update = false;
$del = false;
$budgetamount = "";
$budgetdate = date("Y-m-d");
if (isset($_POST['add'])) {
    $budgetamount = $_POST['budgetamount'];
    $budgetdate = $_POST['budgetdate'];

    $budget = "INSERT INTO budget (user_id, budget, budgetdate) VALUES ('$userid', '$budgetamount', '$budgetdate')";
    $result = mysqli_query($con, $budget) or die("Something Went Wrong!");
    header('location: add_budget.php');
}

if (isset($_POST['update'])) {
    $id = $_GET['edit'];
    $budgetamount = $_POST['budgetamount'];
    $budgetdate = $_POST['budgetdate'];

    $sql = "UPDATE budget SET budget='$budgetamount', budgetdate='$budgetdate' WHERE user_id='$userid' AND budget_id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Record was updated successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: manage_budget.php');
}

if (isset($_POST['delete'])) {
    $id = $_GET['delete'];
    $budgetamount = $_POST['budgetamount'];
    $budgetdate = $_POST['budgetdate'];

    $sql = "DELETE FROM budget WHERE user_id='$userid' AND budget_id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Record was deleted successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: manage_budget.php');
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($con, "SELECT * FROM budget WHERE user_id='$userid' AND budget_id=$id");
    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $budgetamount = $n['budget'];
        $budgetdate = $n['budgetdate'];
    } else {
        echo "WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data";
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $del = true;
    $record = mysqli_query($con, "SELECT * FROM budget WHERE user_id='$userid' AND budget_id=$id");

    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $budgetamount = $n['budget'];
        $budgetdate = $n['budgetdate'];
    } else {
        echo "WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data";
    }
}
?>

<!-- The remaining HTML code -->

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add Budget</title>
    <link rel = "icon" href = "icon\TUSTOS ICON.png" type = "image/x-icon">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Feather JS for Icons -->
    <script src="js/feather.min.js"></script>

</head>

<body>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper" style="background-color:#e1ffff">
      <div class="user" style="background-color:#e1ffff">
        <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="120">
        <h5><?php echo $username ?></h5>
        <p><?php echo $useremail ?></p>
      </div>
      <div class="sidebar-heading" style="background-color:#e1ffff">Management</div>
      <div class="list-group list-group-flush">
        <a href="index.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action"><span data-feather="home"></span> Dashboard</a>
        <a href="add_budget.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action sidebar-active"><span data-feather="dollar-sign"></span> Add Budget</a>
        <a href="manage_budget.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action"><span data-feather="bar-chart-2"></span> Manage Budget</a>
        <a href="recurring_payments.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action"><span data-feather="activity"></span> Recurring Payments</a>
        <a href="add_expense.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action "><span data-feather="plus-square"></span> Add Expenses</a>
        <a href="manage_expense.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action "><span data-feather="bar-chart"></span> Manage Expenses</a>
      </div>
      <div class="sidebar-heading" style="background-color:#e1ffff">Settings </div>
      <div class="list-group list-group-flush">
        <a href="profile.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action "><span data-feather="user"></span> Profile</a>
        <a href="logout.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action "><span data-feather="power"></span> Logout</a>
      </div>
    </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light  border-bottom">


                <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
                    <span data-feather="menu"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="25">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="profile.phcol-mdp">Your Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container">
                <h3 class="mt-4 text-center">Add Your Daily budget</h3>
                <hr>
                <div class="row ">

                    <div class="col-md-3"></div>

                    <div class="col-md" style="margin:0 auto;">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label for="budgetamount" class="col-sm-6 col-form-label"><b>Enter Amount($)</b></label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control col-sm-12" value="<?php echo $budgetamount; ?>" id="budgetamount" name="budgetamount" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="budgetdate" class="col-sm-6 col-form-label"><b>Date</b></label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control col-sm-12" value="<?php echo $budgetdate; ?>" name="budgetdate" id="budgetdate" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 text-right">
                                    <?php if ($update == true) : ?>
                                        <button class="btn btn-lg btn-block btn-warning" style="border-radius: 0%;" type="submit" name="update">Update</button>
                                    <?php elseif ($del == true) : ?>
                                        <button class="btn btn-lg btn-block btn-danger" style="border-radius: 0%;" type="submit" name="delete">Delete</button>
                                    <?php else : ?>
                                        <button type="submit" name="add" class="btn btn-lg btn-block btn-success" style="border-radius: 0%;">Add budget</button>
                                    <?php endif ?>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-3"></div>
                    
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <!-- Menu Toggle Script -->
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
    <script>
        feather.replace();
    </script>
    <script>

    </script>
</body>
</html>