<?php
include("session.php");
$update = false;
$del = false;
$dueamount = "";
$due_date = date("Y-m-d");
$expensecategory = "Entertainment";
$exp_fetched = mysqli_query($con, "SELECT * FROM payments WHERE user_id = '$userid'");
if (isset($_POST['add'])) {
    $dueamount = $_POST['dueamount'];
    $due_date = $_POST['due_date'];
    $expensecategory = $_POST['expensecategory'];

    $payments = "INSERT INTO payments (user_id, payments,due_date,expensecategory) VALUES ('$userid', '$dueamount','$due_date','$expensecategory')";
    $result = mysqli_query($con, $payments) or die("Something Went Wrong!");
    header('location: recurring_payments.php');
}

if (isset($_POST['save'])) {
    // Retrieve the checked payment IDs from the form submission
    $paidPayments = isset($_POST['paid']) ? $_POST['paid'] : [];

    // Loop through the payments and update the database accordingly
    foreach ($paidPayments as $payment_id) {
        // Get the paid status based on the checkbox value
        $paid = isset($_POST['paid']) && in_array($payment_id, $_POST['paid']) ? 1 : 0;

        // Update the 'paid' field in the database for the given payment ID
        // Modify this code based on your database structure and query method
        $updateQuery = "UPDATE payments SET paid = '$paid' WHERE payment_id = '$payment_id' AND user_id = '$userid'";
        // Execute the update query using your database connection
        mysqli_query($con, $updateQuery);
    }
    header('location: recurring_payments.php');
}


if (isset($_POST['update'])) {
    $id = $_GET['edit'];
    $dueamount = $_POST['dueamount'];
    $due_date = $_POST['due_date'];
    $expensecategory = $_POST['expensecategory'];
    $paid = $_POST['paid'];

    $sql = "UPDATE payments SET payments='$dueamount', due_date='$due_date', expensecategory='$expensecategory' WHERE user_id='$userid' AND payment_id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: recurring_payments.php');
}

if (isset($_POST['update'])) {
    $id = $_GET['edit'];
    $dueamount = $_POST['dueamount'];
    $due_date = $_POST['due_date'];
    $expensecategory = $_POST['expensecategory'];
    $paid = $_POST['paid'];

    $sql = "UPDATE payments SET payments='$dueamount', due_date='$due_date', expensecategory='$expensecategory' WHERE user_id='$userid' AND payment_id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: recurring_payments.php');
}

if (isset($_POST['delete'])) {
    $id = $_GET['delete'];
    $dueamount = $_POST['dueamount'];
    $due_date = $_POST['due_date'];
    $expensecategory = $_POST['expensecategory'];
    $paid = $_POST['paid'];

    $sql = "DELETE FROM payments WHERE user_id='$userid' AND payment_id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: recurring_payments.php');
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($con, "SELECT * FROM payments WHERE user_id='$userid' AND payment_id=$id");
    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $dueamount = $n['payments'];
        $due_date = $n['due_date'];
        $expensecategory = $n['expensecategory'];
        $paid = $n['paid'];
    } else {
        echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $del = true;
    $record = mysqli_query($con, "SELECT * FROM payments WHERE user_id='$userid' AND payment_id=$id");

    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $dueamount = $n['payments'];
        $due_date = $n['due_date'];
        $expensecategory = $n['expensecategory'];
        $paid = $n['paid'];
    } else {
        echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add payments</title>
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
            <div class="user">
                <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="120">
                <h5><?php echo $username ?></h5>
                <p><?php echo $useremail ?></p>
            </div>
            <div class="sidebar-heading" style="background-color:#e1ffff">Management</div>
            <div class="list-group list-group-flush">
                <a href="index.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action"><span data-feather="home"></span> Dashboard</a>
                <a href="add_budget.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action"><span data-feather="dollar-sign"></span> Add Budget</a>
                <a href="manage_budget.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action"><span data-feather="bar-chart-2"></span> Manage Budget</a>
                <a href="recurring_payments.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action sidebar-active"><span data-feather="activity"></span> Recurring Payments</a>
                <a href="add_expense.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action"><span data-feather="plus-square"></span> Add Expense</a>
                <a href="manage_expense.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action"><span data-feather="bar-chart"></span> Manage Expense</a>
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
                                <a class="dropdown-item" href="profile.php">Your Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container">
                <h3 class="mt-4 text-center">Add Your Due Payments</h3>
                <hr>
                <div class="row ">

                    <div class="col-md-3"></div>

                    <div class="col-md" style="margin:0 auto;">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label for="dueamount" class="col-sm-6 col-form-label"><b>Enter Amount to Pay($)</b></label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control col-sm-12" value="<?php echo $dueamount; ?>" id="dueamount" name="dueamount" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="due_date" class="col-sm-6 col-form-label"><b>Due Date</b></label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control col-sm-12" value="<?php echo $due_date; ?>" name="due_date" id="due_date" required>
                                </div>
                            </div>
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-6 pt-0"><b>Category</b></legend>
                                    <div class="col-md">

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory4" value="Medicine" <?php echo ($expensecategory == 'Medicine') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory4">
                                                Medicine
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory3" value="Food" <?php echo ($expensecategory == 'Food') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory3">
                                                Food
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory2" value="Bills & Recharges" <?php echo ($expensecategory == 'Bills & Recharges') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory2">
                                                Bills and Recharges
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory1" value="Entertainment" <?php echo ($expensecategory == 'Entertainment') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory1">
                                                Entertainment
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory7" value="Clothings" <?php echo ($expensecategory == 'Clothings') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory7">
                                                Clothings
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory6" value="Rent" <?php echo ($expensecategory == 'Rent') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory6">
                                                Rent
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory8" value="Household Items" <?php echo ($expensecategory == 'Household Items') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory8">
                                                Household Items
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory5" value="Others" <?php echo ($expensecategory == 'Others') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory5">
                                                Others
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group row">
                                <div class="col-md-12 text-right">
                                    <?php if ($update == true) : ?>
                                        <button class="btn btn-lg btn-block btn-warning" style="border-radius: 0%;" type="submit" name="update">Update</button>
                                    <?php elseif ($del == true) : ?>
                                        <button class="btn btn-lg btn-block btn-danger" style="border-radius: 0%;" type="submit" name="delete">Delete</button>
                                    <?php else : ?>
                                        <button type="submit" name="add" class="btn btn-lg btn-block btn-success" style="border-radius: 0%;">Add payments</button>
                                    <?php endif ?>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-3"></div>
                    
                </div>



                <div class="container-fluid">
                <h3 class="mt-4 text-center">Manage Payments</h3>
                <hr>
                <div class="row justify-content-center">
                <form action="" method="post">                 
                    <div class="container bg-light shadow mt-5">
                        <table class="table table-bordered table-hover border-primary">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Payments</th>
                                    <th>Expense Category</th>
                                    <th>Paid</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>

                            <?php $count=1; while ($row = mysqli_fetch_array($exp_fetched)) { ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row['due_date']; ?></td>
                                    <td><?php echo $row['payments']; ?></td>
                                    <td><?php echo $row['expensecategory']; ?></td>
                                    <td>
                                        <input type="hidden" name="paid_<?php echo $row['payment_id']; ?>" value="0">
                                        <input type="checkbox" name="paid[]" value="<?php echo $row['payment_id']; ?>" <?php if ($row['paid'] == 1) echo "checked"; ?>>
                                    </td>
                                    <td class="text-center">
                                        <a href="recurring_payments.php?edit=<?php echo $row['payment_id']; ?>" class="btn btn-primary btn-sm" style="border-radius:0%;">Edit</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="recurring_payments.php?delete=<?php echo $row['payment_id']; ?>" class="btn btn-danger btn-sm" style="border-radius:0%;">Delete</a>
                                    </td>
                                </tr>
                            <?php $count++; } ?>
                        </table>
                    </div>
                    <center><button type="submit" name="save">Save Payment Status</center></button>
                 </form>
                    

                    </div>
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