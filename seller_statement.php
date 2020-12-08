<?php
session_start();
include('configure.php');
require_once("dbcontroller.php");
if (!isset($_SESSION['name'])) {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
// STATEMENT date
$date = "2020-04";
// Sort a multidimensional array by element containing date
function date_compare($a, $b)
{
    $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);
    return $t1 - $t2;
}
$date = date("Y-m");
?>
<?php
if (!isset($_SESSION['name'])) {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
if (isset($_POST['dashboard'])) {
    echo "<script type='text/javascript'> document.location = 'seller.php'; </script>";
}
if (isset($_POST['settings'])) {
    echo "<script type='text/javascript'> document.location = 'seller_settings.php'; </script>";
}
if (isset($_POST['homepage'])) {
    echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
}
if (isset($_POST['order'])) {
    echo "<script type='text/javascript'> document.location = 'seller_orders.php'; </script>";
}
if (isset($_POST['sellers'])) {
    echo "<script type='text/javascript'> document.location = 'seller_sellers.php'; </script>";
}
if (isset($_POST['seller_statement'])) {
    echo "<script type='text/javascript'> document.location = 'seller_statement.php'; </script>";
}
?>
<?php
$balance = 0;
if (isset($_POST['getdate'])) {
    if ($_POST['date1'] < $_POST['date2'] || $_POST['date1'] == $_POST['date2']) {
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];
        $query = "SELECT commission_amount,commission_from_seller FROM commission WHERE employee_id = '$_SESSION[employee_id_saver]' AND SYSDATE < '$date1'";
        $result = mysqli_query($database, $query);
        while ($row = mysqli_fetch_array($result)) {
            if ($row['commission_from_seller'] == 2) {
                $balance -= $row['commission_amount'];
            } else if ($row['commission_from_seller'] == 1  || $row['commission_from_seller'] == 0) {
                $balance += $row['commission_amount'];
            }
        }
    } else {
        $_POST['date1'] = null;
        $_POST['date2'] = null;
        $date1 = date('Y-m-01');
        $date2 = date('Y-m-d');
        echo "<script type='text/javascript'>alert('You have entered an invalid date.');</script>";
    }
} else {
    $date1 = date('Y-m-01');
    $date2 = date('Y-m-d');
    $query = "SELECT commission_amount,commission_from_seller FROM commission WHERE employee_id = '$_SESSION[employee_id_saver]' AND SYSDATE < '$date1'";
    $result = mysqli_query($database, $query);
    while ($row = mysqli_fetch_array($result)) {
        if ($row['commission_from_seller'] == 2) {
            $balance -= $row['commission_amount'];
        } else if ($row['commission_from_seller'] == 1 || $row['commission_from_seller'] == 0) {
            $balance += $row['commission_amount'];
        }
    }
}
// get statement
$data = array();
$credit = 0;
$debit = 0;
$query = "SELECT employee_id,first_name,last_name,parent_id FROM employee WHERE parent_id = '$_SESSION[employee_id_saver]' OR employee_id = '$_SESSION[employee_id_saver]'";
$result = mysqli_query($database, $query);
while ($row2 = mysqli_fetch_array($result)) {
    $query1 = "SELECT commission_amount,employee_id,SYSDATE FROM commission WHERE employee_id = '$row2[employee_id]' AND SYSDATE BETWEEN '" . $date1 . "' AND  '" . date('Y-m-d', (strtotime('+1 day', strtotime($date2)))) . "' AND commission_from_seller != 2";
    $data1 = mysqli_query($database, $query1);
    while ($row1 = mysqli_fetch_array($data1)) {
        //calculate Revenue from each commisson where parent_id equals user_id
        $credit = ($row1['commission_amount'] / 0.08) * 0.02;
        if ($row1['employee_id'] == $_SESSION['employee_id_saver']) {
            $credit = ($row1['commission_amount']);
        }
        $debit = null;
        $newDate = date("Y-m-d", strtotime($row1['SYSDATE']));
        array_push($data, array("date" => $newDate, "dec" => $row2['first_name'] . " " . $row2['last_name'], "credit" => $credit, "debit" => $debit));
    }
}
// commission from jupiter 
$query = "SELECT * FROM commission WHERE employee_id = '$_SESSION[employee_id_saver]' AND SYSDATE BETWEEN '" . $date1 . "' AND  '" . date('Y-m-d', (strtotime('+2 day', strtotime($date2)))) . "' AND commission_from_seller = 2";
$result = mysqli_query($database, $query);
while ($row = mysqli_fetch_array($result)) {
    $credit = null;
    $newDate1 = date("Y-m-d", strtotime($row['SYSDATE']));
    array_push($data, array("date" => $newDate1, "dec" => "jupiter", "credit" => $credit, "debit" => $row['commission_amount']));
}
usort($data, "date_compare");
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
    <title>Seller Statement</title>
    <script type="text/javascript">
        function printData() {
            var divToPrint = document.getElementById("printTable");
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }

        $('button').on('click', function() {
            printData();
        })
    </script>
    <style>
        [type="date"] {
            background: #fff url(https://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/calendar_2.png) 97% 50% no-repeat;
        }

        [type="date"]::-webkit-inner-spin-button {
            display: none;
        }

        [type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
        }

        label {
            display: block;
        }

        input {
            border: 1px solid #c4c4c4;
            border-radius: 5px;
            background-color: #fff;
            padding: 3px 5px;
            box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
            width: 190px;
        }
    </style>
</head>
<?php include('navbar.php'); ?>

<body>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <div class="d-flex" id="wrapper">
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="list-group">
                <form action="seller.php" method="post" style="margin-top: 18px">
                    <input type="submit" value="Dashboard" name="dashboard" class="btn btn-block" style="background-color: rgb(254,198,1)">
                    <input type="submit" value="Sellers" name="sellers" class="btn btn-block" style="background-color: rgb(254,198,1)">
                    <input type="submit" value="Orders" name="order" class="btn btn-block" name="viewproducts" style="background-color: rgb(254,198,1)">
                    <input type="submit" value="Seller Statement" name="seller_statement" class="btn btn-block" name="viewproducts" style="background-color: rgb(254,198,1)">
                    <input type="submit" value="Privacy & Addresses" name="settings" class="btn btn-block" style="background-color: rgb(254,198,1)">
                    <input type="submit" value="Back To Home Page" name="homepage" class="btn btn-block" style="background-color: rgb(254,198,1)">
                </form>
                <br>
                <div class="card bg-warning text-dark">
                    <p class="d-flex justify-content-center">Change Statement Date</p>
                    <div class="card-body">
                        <form action="seller_statement.php" method="POST">
                            <p>FROM
                                <input class="btn btn-block col-sm-12 bg-white" required name="date1" type="date" value="<?php echo isset($_POST['date1']) ? htmlspecialchars($_POST['date1'], ENT_QUOTES) : ''; ?>">
                            </p>
                            <p>TO
                                <input class="btn btn-block col-sm-12 bg-white" required name="date2" type="date" value="<?php echo isset($_POST['date2']) ? htmlspecialchars($_POST['date2'], ENT_QUOTES) : ''; ?>">
                            </p>
                            <br>
                            <input type="submit" class="btn btn-block btn-warning col-sm-12 bg-white" style="border-radius: 30px" value="Request Statement" name="getdate">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" id="menu-toggle" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
            <br>
            <div class="container" id="printTable">
                <div class="row text-dark">
                    <div class="col-sm-2">
                        <p style="font-size:15px">JUPITER <small>s.a.r.l</small> <br> Rashaya al wadi <br> +961 76544203</p>
                    </div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-3">
                        <img src="assets/img/jupiterlogo.png" alt="logo" style="height: 70px">
                    </div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-3">
                        <br>
                        <h4>ACCOUNT STATEMENT</h4>
                    </div>
                </div>
                <hr>
                <div class="row text-dark">
                    <div class="col-sm-3">
                        <h2><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></h2>
                    </div>
                    <div class="col-sm-5"></div>
                    <div class="col-sm-4 ">
                        <table border="1" class="text-dark" style="width:100%">
                            <tr style="text-align: center">
                                <th>Statement period</th>
                                <th>Account No</th>
                            </tr>
                            <tr>
                                <td>
                                    <center><?php echo $date1 . " to " . date('Y-m-d', (strtotime('+1 day', strtotime($date2)))) ?></center>
                                </td>
                                <td>
                                    <center><?php echo $_SESSION['employee_id_saver']; ?></center>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-warning">
                            <tr align="center">
                                <th scope="col">DATE</th>
                                <th scope="col">DESCRIPTION</th>
                                <th scope="col">DEBIT ($)</th>
                                <th scope="col">CREDIT ($)</th>
                                <th scope="col">BALANCE ($)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            /**
                             * Print seller statment 
                             * 
                             * calulate debit and credit amount then adding them to the balance 
                             * 
                             * @return Response html from each transaction
                             */
                            if (empty($data)) {
                                echo "<tr><td><h4>You have no transaction for this period</h4></td></tr>";
                            }
                            $dec = "";
                            foreach ($data as $key) {
                                if ($key['dec'] == 'jupiter') {
                                    $dec = "payment from jupiter";
                                    $balance -= $key['debit'];
                                } else {
                                    $dec = "revenue from " . $key['dec'];
                                    $balance += $key['credit'];
                                }
                            ?>
                                <tr align="center">
                                    <td><?php echo $key['date']; ?></td>
                                    <td><?php echo $dec; ?></td>
                                    <td><?php echo round($key['debit'],2); ?></td>
                                    <td><?php echo round($key['credit'],2); ?></td>
                                    <td><?php echo round($balance,2); ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="container d-flex justify-content-center">
                <div class="row col-sm-4 d-flex justify-content-center">
                    <input type="submit" value="Print Statement" class="btn btn-block btn-warning" onclick="printData()">
                </div>
            </div>
            <br><br><br><br><br>
            <script>
                $("#menu-toggle").click(function(e) {
                    e.preventDefault();
                    $("#wrapper").toggleClass("toggled");
                });
            </script>
</body>
<?php include('footer.php'); ?>

</html>