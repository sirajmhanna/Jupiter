<?php
session_start();

require_once("dbcontroller.php");
if (!isset($_SESSION['admin_email'])) {
    echo "<script type='text/javascript'> document.location = 'admin-login.php'; </script>";
}
?>
<!-- calculate total orders for this year-->
<?php
$total_orders_for_this_year = 0;
$year = date("Y");
$query = "SELECT product_id FROM sales WHERE  SYSDATE like '%" . $year . "%'";
$result = mysqli_query($database, $query);
$total_orders = mysqli_num_rows($result);
?>
<!-- calculate total sales for today -->
<?php
$total_sales_for_today = 0;
$day = date("Y-m-d");
$query = "SELECT product_price,item_quantity FROM sales WHERE  SYSDATE like '%" . $day . "%'";
$result = mysqli_query($database, $query);
while($row = mysqli_fetch_array($result)){
$total_sales_for_today += ($row['product_price']*$row['item_quantity']);
}
?>
<!-- calculate total sales for this month -->
<?php
$total_sales_for_this_month = 0;
$month = date("Y-m");
$query = "SELECT product_price,item_quantity FROM sales WHERE  SYSDATE like '%" . $month . "%'";
$result = mysqli_query($database, $query);
while($row = mysqli_fetch_array($result)){
    $total_sales_for_this_month += ($row['product_price']*$row['item_quantity']);
}
?>
<!-- calculate total sales for this year -->
<?php
$total_sales_for_this_year = 0;
$year = date("Y");
$query = "SELECT product_price,item_quantity FROM sales WHERE  SYSDATE like '%" . $year . "%'";
$result = mysqli_query($database, $query);
while($row_year = mysqli_fetch_array($result)){
$total_sales_for_this_year += ($row_year['product_price']*$row_year['item_quantity']);

}
?>
<html lang="en">

<head>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link href="assets/css/simple-sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <title>Admin</title>
</head>

<body>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <div class="d-flex" id="wrapper">

        <?php include('admin-navbar.php'); ?>

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
                                <span class="text-dark d-flex justify-content-center">SALES (DAILY)</span>
                                <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); " />
                                <p class="text-dark d-flex justify-content-center bg-warning" style="border-radius:30px">$<?php echo $total_sales_for_today; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-header">
                                <span class="text-dark d-flex justify-content-center">SALES (MONTHLY)</span>
                                <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); " />
                                <p class="text-dark d-flex justify-content-center bg-warning" style="border-radius:30px">$<?php echo $total_sales_for_this_month; ?></p>

                            </div>

                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-header">
                                <span class="text-dark d-flex justify-content-center">SALES (ANNUAL)</span>
                                <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); ">
                                <p class="text-dark d-flex justify-content-center bg-warning" style="border-radius:30px">$<?php echo $total_sales_for_this_year; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-header">
                                <span class="text-dark d-flex justify-content-center">TOTAL ORDERS (ANNUAL)</span>
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
                <br>
                <?php include('admin-charts.php'); ?>
                <br><br><br>    
            </div>
        </div>
    </div>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>

</html>