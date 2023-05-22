<?php
  include("session.php");
  $exp_category_dc = mysqli_query($con, "SELECT expensecategory FROM expenses WHERE user_id = '$userid' GROUP BY expensecategory");
  $exp_amt_dc = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' GROUP BY expensecategory");

  $exp_date_line = mysqli_query($con, "SELECT expensedate FROM expenses WHERE user_id = '$userid' GROUP BY expensedate");
  $exp_amt_line = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' GROUP BY expensedate");
?>

<?php
date_default_timezone_set("Asia/kolkata");
$todayExp = $yesterdayExp = $weeklyExp = $monthlyExp = $yearlyExp = $totalExp = 0;

$current_date = date("Y-m-d " , strtotime("now"));
$yesterday_date = date("Y-m-d " , strtotime("yesterday"));
$weekly_date = date("Y-m-d " , strtotime("-1 week"));
$monthly_date = date("Y-m-d " , strtotime("-1 month"));
$yearly_date =  date("Y-m-d " , strtotime("-1 year"));

$todayExp = $yesterdayExp = $weeklyExp = $monthlyExp = $yearlyExp = $totalExp = 0;

// Today's expense
$sql_command_todayExp = "SELECT expense , expensedate FROM expenses WHERE expensedate= '$current_date' AND user_id = '$userid' GROUP BY expensedate";
$result = mysqli_query($con ,$sql_command_todayExp);
$rows =  mysqli_num_rows($result);

if($rows > 0){
    while ($rows = mysqli_fetch_assoc($result) ){
        $todayExp += $rows["expense"];
    }
}

// total expense
$sql_command_totalExp = "SELECT expense FROM expenses WHERE user_id = '$userid' GROUP BY expensedate";
$result_t = mysqli_query($con , $sql_command_totalExp) ;
$rows_t =  mysqli_num_rows($result_t);
if($rows_t > 0){
    while ($rows_t = mysqli_fetch_assoc($result_t) ){
        $totalExp += $rows_t["expense"];
    }
}

// Yesterday's Expense
$sql_command_yesterdayExp = "SELECT expense , expensedate FROM expenses WHERE expensedate = '$yesterday_date' AND user_id = '$userid' GROUP BY expensedate";
$result_y = mysqli_query($con ,$sql_command_yesterdayExp);
$rows_y =  mysqli_num_rows($result_y);

if($rows_y > 0){
    while ($rows_y = mysqli_fetch_assoc($result_y) ){
        $yesterdayExp += $rows_y["expense"];
    }
}

// weekly expense
$sql_command_weeklyExp = "SELECT expense , expensedate FROM expenses WHERE expensedate BETWEEN '$weekly_date' AND '$current_date' AND user_id = '$userid' GROUP BY expensedate";
$result_w = mysqli_query($con , $sql_command_weeklyExp) ;
$rows_w =  mysqli_num_rows($result_w);
if($rows_w > 0){
    while ($rows_w = mysqli_fetch_assoc($result_w) ){
        $weeklyExp += $rows_w["expense"];
    }
}

// monthly expense 
$sql_command_monthlyExp = "SELECT expense , expensedate FROM expenses WHERE expensedate BETWEEN '$monthly_date' AND '$current_date' AND user_id = '$userid' GROUP BY expensedate";
$result_m = mysqli_query($con , $sql_command_monthlyExp) ;
$rows_m =  mysqli_num_rows($result_m);
if($rows_m > 0){
    while ($rows_m = mysqli_fetch_assoc($result_m) ){
        $monthlyExp += $rows_m["expense"];
    }
}

// yearly expense
$sql_command_yearlyExp = "SELECT expense , expensedate  FROM expenses WHERE expensedate BETWEEN '$yearly_date' AND '$current_date' AND  user_id = '$userid' GROUP BY expensedate";
$result_year = mysqli_query($con , $sql_command_yearlyExp) ;
$rows_year =  mysqli_num_rows($result_year);
if($rows_year > 0){
    while($rows_year = mysqli_fetch_assoc($result_year)){
        $yearlyExp += $rows_year['expense'];  
    }
}

$tips="";
if($todayExp = 0){
  $tips = "You have not spent today!";
}
  ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">


  <title>TUSTOS</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style2.css" rel="stylesheet">

  <!-- Feather JS for Icons -->
  <script src="js/feather.min.js"></script>
  <style>
    .card a {
      color: #000;
      font-weight: 500;
    }

    .card a:hover {
      color: #28a745;
      text-decoration: dotted;
    }
    body {
    
    }
  </style>

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="border-right" id="sidebar-wrapper">
      <div class="user" style = "background-color:#e1ffff">
        <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="120">
        <h5><?php echo $username ?></h5>
        <p><?php echo $useremail ?></p>
      </div>
      <div class="sidebar-heading">Management</div>
      <div class="list-group list-group-flush">
        <a href="index.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="home"></span> Dashboard</a>
        <a href="add_expense.php" class="list-group-item list-group-item-action "><span data-feather="plus-square"></span> Add Expenses</a>
        <a href="manage_expense.php" class="list-group-item list-group-item-action "><span data-feather="dollar-sign"></span> Manage Expenses</a>
      </div>
      <div class="sidebar-heading">Settings </div>
      <div class="list-group list-group-flush">
        <a href="profile.php" class="list-group-item list-group-item-action "><span data-feather="user"></span> Profile</a>
        <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="power"></span> Logout</a>
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

      <div class="container-fluid">
        <div class="fade-in">
          <h1><center>Hello, <?php echo $username ?></center></h1>
          <h5><center><?php echo $tips ?></center></h5>
        </div>
        <h3 class="mt-4">Dashboard</h3>
        <div class="row">
          <div class="col-md">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col text-center">
                    <a href="add_expense.php"><img src="icon/addex.png" width="57px" />
                      <p>Add Expenses</p>
                    </a>
                  </div>
                  <div class="col text-center">
                    <a href="manage_expense.php"><img src="icon/maex.png" width="57px" />
                      <p>Manage Expenses</p>
                    </a>
                  </div>
                  <div class="col text-center">
                    <a href="profile.php"><img src="icon/prof.png" width="57px" />
                      <p>User Profile</p>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <h3 class="mt-4">Full-Expense Report</h3>
        <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-10">
                            <div class="card-body">
                                <h3 class="card-title text-white">Today's Expense</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $todayExp; ?></h2>
                                    <p class="text-white mb-0"><?php echo date("jS F " , strtotime("now")); ?></p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-usd"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-10">
                            <div class="card-body">
                                <h3 class="card-title text-white">Yesterday's Expense</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $yesterdayExp; ?></h2>
                                    <p class="text-white mb-0"><?php echo date("jS F " , strtotime("yesterday")); ?></p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-usd"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-10">
                            <div class="card-body">
                                <h3 class="card-title text-white">Last 7 Day's Expense</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $weeklyExp; ?></h2>
                                    <p class="text-white mb-0"><?php echo date("jS F" , strtotime("-7 days")); echo " - " . date("jS F " , strtotime("now")); ?></p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-dollar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-10">
                            <div class="card-body">
                                <h3 class="card-title text-white">Last 30 Day's Expense</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $monthlyExp; ?></h2>
                                    <p class="text-white mb-0"><?php echo date("jS F" , strtotime("-30 days")); echo " - " . date("jS F " , strtotime("now")); ?></p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-usd"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class = "col-3">

                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-10">
                            <div class="card-body">
                                <h3 class="card-title text-white">One Year Expense</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $yearlyExp; ?></h2>
                                    <p class="text-white mb-0"><?php echo date("d F Y" , strtotime("-1 year")); echo " - " . date("d F Y" , strtotime("now")); ?></p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-usd"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-10">
                            <div class="card-body">
                                <h3 class="card-title text-white">Total Expense</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $totalExp; ?></h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-usd"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                

        <h3 class="mt-4">Graph Report</h3>
        <div class="row">
          <div class="col-md">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title text-center">Yearly Expenses</h5>
              </div>
              <div class="card-body">
                <canvas id="expense_line" height="150"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title text-center">Expense Category</h5>
              </div>
              <div class="card-body">
                <canvas id="expense_category_pie" height="150"></canvas>
              </div>
            </div>
          </div>
        </div>



        
              

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
    feather.replace()
  </script>
  <script>
    var ctx = document.getElementById('expense_category_pie').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [<?php while ($a = mysqli_fetch_array($exp_category_dc)) {
                    echo '"' . $a['expensecategory'] . '",';
                  } ?>],
        datasets: [{
          label: 'Expense by Category',
          data: [<?php while ($b = mysqli_fetch_array($exp_amt_dc)) {
                    echo '"' . $b['SUM(expense)'] . '",';
                  } ?>],
          backgroundColor: [
            '#6f42c1',
            '#dc3545',
            '#28a745',
            '#007bff',
            '#ffc107',
            '#20c997',
            '#17a2b8',
            '#fd7e14',
            '#e83e8c',
            '#6610f2'
          ],
          borderWidth: 1
        }]
      }
    });

    var line = document.getElementById('expense_line').getContext('2d');
    var myChart = new Chart(line, {
      type: 'line',
      data: {
        labels: [<?php while ($c = mysqli_fetch_array($exp_date_line)) {
                    echo '"' . $c['expensedate'] . '",';
                  } ?>],
        datasets: [{
          label: 'Expense by Month (Whole Year)',
          data: [<?php while ($d = mysqli_fetch_array($exp_amt_line)) {
                    echo '"' . $d['SUM(expense)'] . '",';
                  } ?>],
          borderColor: [
            '#006fff'
          ],
          backgroundColor: [
            '#6f42c1',
            '#dc3545',
            '#28a745',
            '#007bff',
            '#ffc107',
            '#20c997',
            '#17a2b8',
            '#fd7e14',
            '#e83e8c',
            '#6610f2'
          ],
          fill: false,
          borderWidth: 2
        }]
      }
    });
  </script>

</body>

</html>