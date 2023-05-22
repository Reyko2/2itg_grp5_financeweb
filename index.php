<?php
include("session.php");
$exp_category_dc = mysqli_query($con, "SELECT expensecategory FROM expenses WHERE user_id = '$userid' GROUP BY expensecategory");
$exp_amt_dc = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' GROUP BY expensecategory");

$exp_date_line = mysqli_query($con, "SELECT expensedate FROM expenses WHERE user_id = '$userid' GROUP BY expensedate");
$exp_amt_line = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' GROUP BY expensedate");
?>

<?php
date_default_timezone_set("Asia/Manila");
$todayExp = $yesterdayExp = $weeklyExp = $monthlyExp = $yearlyExp = $totalExp = 0;
$previoustodayExp = $previousyesterdayExp = $previousweeklyExp = $previousmonthlyExp = $previousyearlyExp = $previousTotalExp = 0;

$current_date = date("Y-m-d ", strtotime("now"));
$yesterday_date = date("Y-m-d ", strtotime("yesterday"));
$weekly_date = date("Y-m-d ", strtotime("-1 week"));
$monthly_date = date("Y-m-d ", strtotime("-1 month"));
$yearly_date = date("Y-m-d ", strtotime("-1 year"));

//today's budget
$sql_command_todayBudget = "SELECT SUM(budget) FROM budget WHERE budgetdate = '$current_date' AND user_id = '$userid'";
$result_budget = mysqli_query($con, $sql_command_todayBudget);
$row_budget = mysqli_fetch_assoc($result_budget);
$todayBudget = $row_budget['SUM(budget)'];

//last week's budget
$sql_command_lastWeekBudget = "SELECT SUM(budget) AS last_week_budget FROM budget WHERE budgetdate BETWEEN '$weekly_date' AND '$current_date' AND user_id = '$userid'";
$result_lastWeekBudget = mysqli_query($con, $sql_command_lastWeekBudget);
$row_lastWeekBudget = mysqli_fetch_assoc($result_lastWeekBudget);
$lastWeekBudget = $row_lastWeekBudget['last_week_budget'];

//last month's budget
$sql_command_lastMonthBudget = "SELECT SUM(budget) AS last_month_budget FROM budget WHERE budgetdate BETWEEN '$monthly_date' AND '$current_date' AND user_id = '$userid'";
$result_lastMonthBudget = mysqli_query($con, $sql_command_lastMonthBudget);
$row_lastMonthBudget = mysqli_fetch_assoc($result_lastMonthBudget);
$lastMonthBudget = $row_lastMonthBudget['last_month_budget'];

//last year's budget
$sql_command_lastYearBudget = "SELECT SUM(budget) AS last_year_budget FROM budget WHERE budgetdate BETWEEN '$$yearly_date' AND '$current_date' AND user_id = '$userid'";
$result_lastYearBudget = mysqli_query($con, $sql_command_lastYearBudget);
$row_lastYearBudget = mysqli_fetch_assoc($result_lastYearBudget);
$lastYearBudget = $row_lastYearBudget['last_year_budget'];

// Today's expense
$sql_command_todayExp = "SELECT expense, expensedate FROM expenses WHERE expensedate = '$current_date' AND user_id = '$userid'";
$result_today = mysqli_query($con, $sql_command_todayExp);
$rows_today = mysqli_num_rows($result_today);

if ($rows_today > 0) {
  while ($row_today = mysqli_fetch_assoc($result_today)) {
    $todayExp += $row_today["expense"];
  }
}

// total expense
$sql_command_totalExp = "SELECT expense FROM expenses WHERE user_id = '$userid'";
$result_t = mysqli_query($con, $sql_command_totalExp);
$rows_t = mysqli_num_rows($result_t);
if ($rows_t > 0) {
  $previousTotalExp = $totalExp;

  while ($rows_t = mysqli_fetch_assoc($result_t)) {
    $totalExp += $rows_t["expense"];
  }
}

//Yesterday's expense
$sql_command_yesterdayExp = "SELECT expense, expensedate FROM expenses WHERE expensedate = '$yesterday_date' AND user_id = '$userid'";
$result_yesterday = mysqli_query($con, $sql_command_yesterdayExp);
$rows_yesterday = mysqli_num_rows($result_yesterday);

if ($rows_yesterday > 0) {
  while ($row_yesterday = mysqli_fetch_assoc($result_yesterday)) {
    $yesterdayExp += $row_yesterday["expense"];
  }
}

// weekly expense
$sql_command_weeklyExp = "SELECT expense , expensedate FROM expenses WHERE expensedate BETWEEN '$weekly_date' AND '$current_date' AND user_id = '$userid'";
$result_w = mysqli_query($con, $sql_command_weeklyExp);
$rows_w = mysqli_num_rows($result_w);
if ($rows_w > 0) {
  while ($rows_w = mysqli_fetch_assoc($result_w)) {
    $weeklyExp += $rows_w["expense"];
  }
}

// monthly expense 
$sql_command_monthlyExp = "SELECT expense , expensedate FROM expenses WHERE expensedate BETWEEN '$monthly_date' AND '$current_date' AND user_id = '$userid'";
$result_m = mysqli_query($con, $sql_command_monthlyExp);
$rows_m = mysqli_num_rows($result_m);
if ($rows_m > 0) {
  while ($rows_m = mysqli_fetch_assoc($result_m)) {
    $monthlyExp += $rows_m["expense"];
  }
}

// yearly expense
$sql_command_yearlyExp = "SELECT expense , expensedate  FROM expenses WHERE expensedate BETWEEN '$yearly_date' AND '$current_date' AND  user_id = '$userid'";
$result_year = mysqli_query($con, $sql_command_yearlyExp);
$rows_year = mysqli_num_rows($result_year);
if ($rows_year > 0) {
  while ($rows_year = mysqli_fetch_assoc($result_year)) {
    $yearlyExp += $rows_year['expense'];
  }
}

//graph check
$exp_amt_line_g = "SELECT expensedate, SUM(expense) AS total_expense FROM expenses WHERE user_id = '$userid' GROUP BY expensedate ORDER BY expensedate";
$result_g = mysqli_query($con, $exp_amt_line_g);
$data_g = array();
while ($row_g = mysqli_fetch_assoc($result_g)) {
  $data_g[] = $row_g;
}

// Check if the graph is increasing or decreasing
$isIncreasing = true;
$isDecreasing = true;
$totalDataPoints = count($data_g);
for ($i = 1; $i < $totalDataPoints; $i++) {
  if ($data_g[$i]['total_expense'] > $data_g[$i - 1]['total_expense']) {
    $isDecreasing = false;
  } elseif ($data_g[$i]['total_expense'] < $data_g[$i - 1]['total_expense']) {
    $isIncreasing = false;
  }
}

$tips = "";
$tips2 = "";
$tips3 = "";
$tips = ($todayExp > 0) ? "You have spent today!" : "You have not spent today!";
$tips2 = ($todayExp > $todayBudget) ? "<strong>You're over today's budget</strong><br></br>Analyze the reasons behind the overspending. Determine if it was due to an unexpected expense or if there is a pattern of consistently exceeding the budget." : "<strong>You're within budget</strong><br></br>Congratulations! We encourage maintaining this responsible spending behavior. Suggest continuing to track expenses, sticking to the budget, and considering saving any remaining funds for future needs or unexpected expenses.";

// graph result
if ($isIncreasing) {
  $tips3 = "Your spending is increasing overtime, check and manage your expenses";
} elseif ($isDecreasing) {
  $tips3 = "You're spending less this time, keep it up and you'll increase your budget over time";
} else {
  $tips3 = "Keep managing your expenses";
}




?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">


  <title>Dashboard</title>
  <link rel="icon" href="icon\TUSTOS ICON.png" type="image/x-icon">

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style2.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


  <!-- JS scripts -->
  <script src="js/feather.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var tipsArray = [
        '<?php echo $tips ?>',
        '<?php echo $tips3 ?>'
      ];
      var currentIndex = 0;

      // Function to show the tips and fade them out after 3 seconds
      function showTip() {
        document.getElementById("tips").innerHTML = '<center>' + tipsArray[currentIndex] + '</center>';
        fadeIn();
        setTimeout(function () {
          fadeOut();
          currentIndex = (currentIndex + 1) % tipsArray.length; // Move to the next tip in the array
          setTimeout(showTip, 3000); // Recursively call the function to show the next tip
        }, 10000);
      }

      // Function to fade in the tips
      function fadeIn() {
        var tipsElement = document.getElementById("tips");
        tipsElement.style.opacity = "0";
        tipsElement.style.transition = "opacity 0.5s";
        tipsElement.style.display = "block";
        setTimeout(function () {
          tipsElement.style.opacity = "1";
        }, 10);
      }

      // Function to fade out the tips
      function fadeOut() {
        var tipsElement = document.getElementById("tips");
        tipsElement.style.opacity = "0";
        setTimeout(function () {
          tipsElement.style.display = "none";
        }, 500);
      }

      showTip(); // Start showing the tips
    });
  </script>





  <style>
    .card a {
      color: #000;
      font-weight: 500;
    }

    .card a:hover {
      color: #28a745;
      text-decoration: dotted;
    }
  </style>

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="border-right" id="sidebar-wrapper" style="background-color:#e1ffff">
      <div class="user" style="background-color:#e1ffff">
        <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="120">
        <h5>
          <?php echo $username ?>
        </h5>
        <p>
          <?php echo $useremail ?>
        </p>
      </div>
      <div class="sidebar-heading" style="background-color:#e1ffff">Management</div>
      <div class="list-group list-group-flush">
        <a href="index.php" style="background-color:#e1ffff"
          class="list-group-item list-group-item-action sidebar-active"><span data-feather="home"></span> Dashboard</a>
        <a href="add_budget.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action"><span
            data-feather="dollar-sign"></span> Add Budget</a>
        <a href="manage_budget.php" style="background-color:#e1ffff"
          class="list-group-item list-group-item-action"><span data-feather="bar-chart-2"></span> Manage Budget</a>
        <a href="add_expense.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action "><span
            data-feather="plus-square"></span> Add Expenses</a>
        <a href="manage_expense.php" style="background-color:#e1ffff"
          class="list-group-item list-group-item-action "><span data-feather="bar-chart"></span> Manage Expenses</a>
      </div>
      <div class="sidebar-heading" style="background-color:#e1ffff">Settings </div>
      <div class="list-group list-group-flush">
        <a href="profile.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action "><span
            data-feather="user"></span> Profile</a>
        <a href="logout.php" style="background-color:#e1ffff" class="list-group-item list-group-item-action "><span
            data-feather="power"></span> Logout</a>
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
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
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
            <h1>
              <center>Hello,
                <?php echo $username ?>&nbsp;<span class="info-icon" style="font-size: 16px;" data-toggle="modal"
                  data-target="#tipsModal">
                  <i class="fa fa-info-circle"></i></span>
              </center>
            </h1>
            <h5 id="tips">
              <center>
                <?php echo $tips ?>
              </center>
            </h5>
            <br></br>
  
            <!-- Modal -->
            <div class="modal fade" id="tipsModal" tabindex="-1" role="dialog" aria-labelledby="tipsModalLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="tipsModalLabel">Tips</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <?php echo $tips2 ?>
                  </div>
                </div>
              </div>
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
  
            <h3 class="mt-4">Budget</h3>
            <div class="row">
              <div class="col-lg-3 col-sm-6">
                <div class="card gradient-10 mx-auto" style="max-width: 300px;">
                  <div class="card-body">
                    <h3 class="card-title text-white">Today's Budget</h3>
                    <div class="d-inline-block">
                      <h2 class="text-white">
                        <?php echo $todayBudget; ?>
                      </h2>
                      <p class="text-white mb-0">
                        <?php echo date("jS F ", strtotime("now")); ?>
                      </p>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-usd"></i></span>
                  </div>
                </div>
              </div>
  
              <div class="col-lg-3 col-sm-6">
                <div class="card gradient-10 mx-auto" style="max-width: 300px;">
                  <div class="card-body">
                    <h3 class="card-title text-white">Last Week's Budget</h3>
                    <div class="d-inline-block">
                      <h2 class="text-white">
                        <?php echo $lastWeekBudget; ?>
                      </h2>
                      <p class="text-white mb-0">
                        <?php echo date("jS F", strtotime("-1 week")); ?>
                      </p>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-usd"></i></span>
                  </div>
                </div>
              </div>
  
              <div class="col-lg-3 col-sm-6">
                <div class="card gradient-10 mx-auto" style="max-width: 300px;">
                  <div class="card-body">
                    <h3 class="card-title text-white">Last Month's Budget</h3>
                    <div class="d-inline-block">
                      <h2 class="text-white">
                        <?php echo $lastMonthBudget; ?>
                      </h2>
                      <p class="text-white mb-0">
                        <?php echo date("jS F", strtotime("-30 days"));
                        echo " - " . date("jS F ", strtotime("now")); ?>
                      </p>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-usd"></i></span>
                  </div>
                </div>
              </div>
  
              <div class="col-lg-3 col-sm-6">
                <div class="card gradient-10 mx-auto" style="max-width: 300px;">
                  <div class="card-body">
                    <h3 class="card-title text-white">Last Year's Budget</h3>
                    <div class="d-inline-block">
                      <h2 class="text-white">
                        <?php echo $lastYearBudget; ?>
                      </h2>
                      <p class="text-white mb-0">
                        <?php echo date("d F Y", strtotime("-1 year"));
                        echo " - " . date("d F Y", strtotime("now")); ?>
                      </p>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-usd"></i></span>
                  </div>
                </div>
              </div>
            </div>
  
          
        </div>

        <div class="fade-in">
          <h3 class="mt-4">Full-Expense Report</h3>
          <div class="row">
            <div class="col-lg-3 col-sm-6">
              <div class="card gradient-10 mx-auto" style="max-width: 300px;">
                <div class="card-body">
                  <h3 class="card-title text-white">Today's Expense</h3>
                  <div class="d-inline-block">
                    <h2 class="text-white">
                      <?php echo $todayExp; ?>
                    </h2>
                    <p class="text-white mb-0">
                      <?php echo date("jS F ", strtotime("now")); ?>
                    </p>
                  </div>
                  <span class="float-right display-5 opacity-5"><i class="fa fa-usd"></i></span>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div class="card gradient-10 mx-auto" style="max-width: 300px;">
                <div class="card-body">
                  <h3 class="card-title text-white">Yesterday's Expense</h3>
                  <div class="d-inline-block">
                    <h2 class="text-white">
                      <?php echo $yesterdayExp; ?>
                    </h2>
                    <p class="text-white mb-0">
                      <?php echo date("jS F ", strtotime("yesterday")); ?>
                    </p>
                  </div>
                  <span class="float-right display-5 opacity-5"><i class="fa fa-usd"></i></span>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div class="card gradient-10 mx-auto" style="max-width: 300px;">
                <div class="card-body">
                  <h3 class="card-title text-white">Last Week's Expense</h3>
                  <div class="d-inline-block">
                    <h2 class="text-white">
                      <?php echo $weeklyExp; ?>
                    </h2>
                    <p class="text-white mb-0">
                      <?php echo date("jS F", strtotime("-7 days"));
                      echo " - " . date("jS F ", strtotime("now")); ?>
                    </p>
                  </div>
                  <span class="float-right display-5 opacity-5"><i class="fa fa-dollar"></i></span>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div class="card gradient-10 mx-auto" style="max-width: 300px;">
                <div class="card-body">
                  <h3 class="card-title text-white">Last Month's Expense</h3>
                  <div class="d-inline-block">
                    <h2 class="text-white">
                      <?php echo $monthlyExp; ?>
                    </h2>
                    <p class="text-white mb-0">
                      <?php echo date("jS F", strtotime("-30 days"));
                      echo " - " . date("jS F ", strtotime("now")); ?>
                    </p>
                  </div>
                  <span class="float-right display-5 opacity-5"><i class="fa fa-usd"></i></span>
                </div>
              </div>
            </div>
    
            <div class="col-lg-3 col-sm-6">
              <div class="card gradient-10 mx-auto" style="max-width: 300px;">
                <div class="card-body">
                  <h3 class="card-title text-white">Yearly Expense</h3>
                  <div class="d-inline-block">
                    <h2 class="text-white">
                      <?php echo $yearlyExp; ?>
                    </h2>
                    <p class="text-white mb-0">
                      <?php echo date("d F Y", strtotime("-1 year"));
                      echo " - " . date("d F Y", strtotime("now")); ?>
                    </p>
                  </div>
                  <span class="float-right display-5 opacity-5"><i class="fa fa-usd"></i></span>
                </div>
              </div>
            </div>
    
            <div class="col-lg-3 col-sm-6">
              <div class="card gradient-10 mx-auto" style="max-width: 300px;">
                <div class="card-body">
                  <h3 class="card-title text-white">Total Expense</h3>
                  <div class="d-inline-block">
                    <h2 class="text-white">
                      <?php echo $totalExp; ?>
                    </h2>
                  </div>
                  <span class="float-right display-5 opacity-5"><i class="fa fa-usd"></i></span>
                </div>
              </div>
            </div>
    
    
    
    
          </div>
        </div>
  
  
        <div class="fade-in">
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
  
  </div>





    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <!-- Menu Toggle Script -->
    <script>
      $("#menu-toggle").click(function (e) {
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