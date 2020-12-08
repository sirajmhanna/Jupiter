<?php
session_start();
include('configure.php');
require_once("dbcontroller.php");
?>
<!-- calculate total for today-->
<?php
/**
 * Calculate total commision for today 
 * 
 * @param date $today
 * 
 * @return $today_total  
 */
$today_total = 0;
$today = date("Y-m-d");
$query = "SELECT * FROM commission WHERE SYSDATE like '%" . $today . "%' AND employee_id = $_SESSION[employee_id_saver] AND commission_from_seller != 2";
$result = mysqli_query($database, $query);
while ($row = mysqli_fetch_array($result)) {
    $today_total += $row['commission_amount'];
}
?>
<!-- calculate total for this month-->
<?php
/**
 * Calculate total commision for this month 
 * 
 * @param date $month
 * 
 * @return $month_total  
 */
$month_total = 0;
$month = date("Y-m");
$query1 = "SELECT * FROM commission WHERE SYSDATE like '%" . $month . "%' AND employee_id = $_SESSION[employee_id_saver] AND commission_from_seller != 2";
$result1 = mysqli_query($database, $query1);
while ($row1 = mysqli_fetch_array($result1)) {
    $month_total += $row1['commission_amount'];
}
?>
<!-- calculate total for this year-->
<?php
/**
 * Calculate total commision for this year 
 * 
 * @param date $year
 * 
 * @return $year_total  
 */
$year_total = 0;
$year = date("Y");
$query11 = "SELECT * FROM commission WHERE SYSDATE like '%" . $year . "%' AND employee_id = $_SESSION[employee_id_saver] AND commission_from_seller != 2";
$result11 = mysqli_query($database, $query11);
while ($row11 = mysqli_fetch_array($result11)) {
    $year_total += $row11['commission_amount'];
}
?>
<!-- calculate total orders-->
<?php
/**
 * Calculate number of orders
 * 
 * @return $total_orders
 */
$total_orders = 0;
$query = "SELECT * FROM sales WHERE employee_id = $_SESSION[employee_id_saver]";
$result = mysqli_query($database, $query);
$total_orders = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link href="assets/css/simple-sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <title>Dashboard</title>
</head>
<?php include('navbar.php'); ?>

<body>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <div class="d-flex" id="wrapper">
        <?php include('seller_navbar.php'); ?>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" id="menu-toggle" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-header">
                                <span class="text-dark d-flex justify-content-center">EARNINGS (DAILY)</span>
                                <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); " />
                                <p class="text-dark d-flex justify-content-center bg-warning" style="border-radius:30px">$<?php echo $today_total; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-header">
                                <span class="text-dark d-flex justify-content-center">EARNINGS (MONTHLY)</span>
                                <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); " />
                                <p class="text-dark d-flex justify-content-center bg-warning" style="border-radius:30px">$<?php echo $month_total; ?></p>

                            </div>

                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-header">
                                <span class="text-dark d-flex justify-content-center">EARNINGS (ANNUAL)</span>
                                <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); ">
                                <p class="text-dark d-flex justify-content-center bg-warning" style="border-radius:30px">$<?php echo $year_total; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-header">
                                <span class="text-dark d-flex justify-content-center">TOTAL ORDERS</span>
                                <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); " />
                                <p class="text-dark d-flex justify-content-center bg-warning" style="border-radius:30px"><?php echo $total_orders; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="container">
                <?php include('charts.php'); ?>
            </div>
            <br>
            <br>
        </div>
    </div>

    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>
<?php include('footer.php');?>

</html>