<?php
session_start();
require_once("dbcontroller.php");
if (!isset($_SESSION['admin_email'])) {
    echo "<script type='text/javascript'> document.location = 'admin-login.php'; </script>";
}
include('phpmailer.php');
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
    <link rel="stylesheet" href="assets/css/admin-orders.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link href="assets/css/simple-sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <title>Admin Orders</title>
    <script type="text/javascript">
    // print function 
        function PrintElem(elem) {
            var mywindow = window.open('', 'PRINT', 'height=800,width=800');
            mywindow.document.write(document.getElementById(elem).innerHTML);
            mywindow.document.close();
            mywindow.focus();
            mywindow.print();
            mywindow.close();

            return true;
        }
    </script>
    <SCRIPT LANGUAGE="JavaScript">
        //script to save scroll position
        var db = (document.body) ? 1 : 0;
        var scroll = (window.scrollTo) ? 1 : 0;

        function setCookie(name, value, expires, path, domain, secure) {
            var curCookie = name + "=" + escape(value) +
                ((expires) ? "; expires=" + expires.toGMTString() : "") +
                ((path) ? "; path=" + path : "") +
                ((domain) ? "; domain=" + domain : "") +
                ((secure) ? "; secure" : "");
            document.cookie = curCookie;
        }

        function getCookie(name) {
            var dc = document.cookie;
            var prefix = name + "=";
            var begin = dc.indexOf("; " + prefix);
            if (begin == -1) {
                begin = dc.indexOf(prefix);
                if (begin != 0) return null;
            } else {
                begin += 2;
            }
            var end = document.cookie.indexOf(";", begin);
            if (end == -1) end = dc.length;
            return unescape(dc.substring(begin + prefix.length, end));
        }

        function saveScroll() {
            if (!scroll) return;
            var now = new Date();
            now.setTime(now.getTime() + 365 * 24 * 60 * 60 * 1000);
            var x = (db) ? document.body.scrollLeft : pageXOffset;
            var y = (db) ? document.body.scrollTop : pageYOffset;
            setCookie("xy", x + "_" + y, now);
        }

        function loadScroll() {
            if (!scroll) return;
            var xy = getCookie("xy");
            if (!xy) return;
            var ar = xy.split("_");
            if (ar.length == 2) scrollTo(parseInt(ar[0]), parseInt(ar[1]));
        }
    </SCRIPT>

</head>

<body onLoad="loadScroll()" onUnload="saveScroll()">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <div class="d-flex" id="wrapper">
        <?php include('admin-navbar.php'); ?>
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" id="menu-toggle" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>

            <div class="container">
                <tbody>
                    <?php
                    $data_saver = array();
                    $query1 = "SELECT * FROM sales WHERE order_status = 0 ORDER BY SYSDATE ASC";
                    $result1 = mysqli_query($database, $query1);
                    while ($row1 = mysqli_fetch_array($result1)) {
                        $random_order_id = $row1['order_id'];
                        break;
                    }
                    $total_for_each_order = 0;
                    $query = "SELECT * FROM sales WHERE order_status = 0 ORDER BY SYSDATE ASC";
                    $result = mysqli_query($database, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        if ($random_order_id == $row['order_id']) {
                            array_push($data_saver, $row);
                            $total_for_each_order += $row['product_price'] * $row['item_quantity'];
                        } else {
                            foreach ($data_saver as $x) {
                    ?> <br>
                                <div class="card text-dark">
                                    <div class="card-body">
                                        <form action="admin-orders.php" method="POST">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p><?php echo "Order ID: " . $x['order_id'] ?></p>
                                                </div>
                                                <div class="col-sm-2">
                                                    <?php
                                                    $date_time = $x['SYSDATE'];
                                                    $new_date = date("Y-m-d", strtotime($date_time));
                                                    ?>
                                                    <p><?php echo "Date: " . $new_date ?></p>
                                                </div>
                                                <div class="col-sm-1">

                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="d-flex justify-content-center" style="background-color: pink">
                                                        <?php echo "Total Price: $" . $total_for_each_order ?></p>
                                                </div>
                                                <div class="col-sm-2 d-flex justify-content-center">
                                                    <input type="hidden" name="react" value="<?php echo $x['order_id']; ?>">
                                                    <input type="hidden" name="react2" value="<?php echo $total_for_each_order; ?>">
                                                    <input type="submit" class="btn btn-warning" id="vieworder" onclick="hideView()" value="VIEW ORDER" name="<?php echo $x['order_id']; ?>">
                                                </div>
                                            </div>
                                            <?php
                                            if (isset($_POST[$x['order_id']])) {
                                            ?>
                                                <br>
                                                <div id="printcard">
                                                <div class="table-responsive" >
                                                    <table class="table text-dark" >
                                                        <thead>
                                                            <tr class="text-muted bg-warning" align="center">
                                                                <th scope="col">PRODUCT</th>
                                                                <th scope="col">PRODUCT-CODE</th>
                                                                <th scope="col">QUANTITY</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-dark">
                                                            <?php
                                                            $status = "";
                                                            $queryx = "SELECT * FROM sales WHERE order_id = '$_POST[react]' ORDER BY SYSDATE ASC";
                                                            $resultx = mysqli_query($database, $queryx);
                                                            while ($rowx = mysqli_fetch_array($resultx)) {
                                                                $query1 = "SELECT * FROM product WHERE product_id = '$rowx[product_id]'";
                                                                $result1 = mysqli_query($database, $query1);
                                                                while ($row1 = mysqli_fetch_array($result1)) {
                                                                    if ($rowx['order_status'] == 0) {
                                                                        $status = "In Progress";
                                                                    } else {
                                                                        $status = "Completed";
                                                                    }
                                                                    echo "<form method='POST' action='admin-orders.php'>
                                                                                <tr align='center'>
                                                                     <td>$row1[product_name]</td>
                                                                     <td>$row1[product_code]</td>
                                                                     <td>$rowx[item_quantity]</td>
                                                                        </tr>
                                                                     </form>";
                                                                }
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <?php
                                                    $qaddress = "SELECT * FROM employee WHERE employee_id = '$x[employee_id]'";
                                                    $raddress = mysqli_query($database, $qaddress);
                                                    while ($rowaddress = mysqli_fetch_array($raddress)) {
                                                        $address = $rowaddress['employee_address'];
                                                    ?>
                                                        <div class="col-sm-6 text-dark">
                                                            <h5 class="d-flex justify-content-center"><?php echo $rowaddress['first_name'] . " " . $rowaddress['last_name'] ?></h5>
                                                            <h6 class="d-flex justify-content-center"><?php echo "Email: " . $rowaddress['employee_email'] ?></h6>
                                                            <h6 class="d-flex justify-content-center"><?php echo "Phone: " . $rowaddress['employee_phone'] ?></h6>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <h5>SHIPPING ADDRESS:</h5>
                                                            <p class="text-dark"><?php echo str_replace('//', '<br>', $address) . '<br>'; ?></p>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-center">
                                                    <input type="submit" value="PRINT ORDER" id="printbtn" class="btn btn-warning text-dark col-sm-2" onclick="PrintElem('printcard')" style="border-radius: 30px">
                                                    <div class="col-sm-1"></div>
                                                    <input type="submit" value="MARK AS DONE" id="donebtn" onClick="javascript:return confirm('Press OK to mark as done');" class="btn btn-warning text-dark col-sm-4" name="markasdone" style="border-radius: 30px">
                                                </div>
                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>
                        <?php
                                break;
                            }
                            $total_for_each_order = 0;
                            $data_saver = array();
                            $random_order_id = $row['order_id'];
                            $total_for_each_order += $row['product_price'] * $row['item_quantity'];
                            array_push($data_saver, $row);
                        }
                    }
                    foreach ($data_saver as $x) {
                        ?>
                        <br>
                        <div class="card text-dark">
                            <div class="card-body" id="printTable">
                                <form action="admin-orders.php" method="POST">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p><?php echo "Order ID: " . $x['order_id'] ?></p>
                                        </div>
                                        <div class="col-sm-2">
                                            <?php
                                            $date_time = $x['SYSDATE'];
                                            $new_date = date("Y-m-d", strtotime($date_time));
                                            ?>
                                            <p><?php echo "Date: " . $new_date ?></p>
                                        </div>
                                        <div class="col-sm-1">

                                        </div>
                                        <div class="col-sm-4">
                                            <p class="d-flex justify-content-center" style="background-color: pink">
                                                <?php echo "Total Price: $" . $total_for_each_order ?></p>
                                        </div>
                                        <div class="col-sm-2 d-flex justify-content-center">
                                            <input type="hidden" name="react" value="<?php echo $x['order_id']; ?>">
                                            <input type="hidden" name="react2" value="<?php echo $total_for_each_order; ?>">
                                            <input type="submit" class="btn btn-warning" id="vieworder" onclick="hideView()" value="VIEW ORDER" name="<?php echo $x['order_id']; ?>">
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($_POST[$x['order_id']])) {
                                    ?>
                                        <br>
                                        <div id="printcard">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-muted bg-warning" align="center">
                                                        <th scope="col">PRODUCT</th>
                                                        <th scope="col">PRODUCT-CODE</th>
                                                        <th scope="col">QUANTITY</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-dark">
                                                    <?php
                                                    $status = "";
                                                    $queryx = "SELECT * FROM sales WHERE order_id = '$_POST[react]'";
                                                    $resultx = mysqli_query($database, $queryx);
                                                    while ($rowx = mysqli_fetch_array($resultx)) {
                                                        $query1 = "SELECT * FROM product WHERE product_id = '$rowx[product_id]'";
                                                        $result1 = mysqli_query($database, $query1);
                                                        while ($row1 = mysqli_fetch_array($result1)) {
                                                            if ($rowx['order_status'] == 0) {
                                                                $status = "In Progress";
                                                            } else {
                                                                $status = "Completed";
                                                            }
                                                            echo "<form method='POST' action='admin-orders.php'>
                                                                                <tr align='center'>
                                                                     <td>$row1[product_name]</td>
                                                                     <td>$row1[product_code]</td>
                                                                     <td>$rowx[item_quantity]</td>
                                                                        </tr>
                                                                     </form>";
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <?php
                                            $qaddress = "SELECT * FROM employee WHERE employee_id = '$x[employee_id]'";
                                            $raddress = mysqli_query($database, $qaddress);
                                            while ($rowaddress = mysqli_fetch_array($raddress)) {
                                                $address = $rowaddress['employee_address'];
                                            ?>
                                                <div class="col-sm-6 text-dark">
                                                    <h5 class="d-flex justify-content-center"><?php echo $rowaddress['first_name'] . " " . $rowaddress['last_name'] ?></h5>
                                                    <h6 class="d-flex justify-content-center"><?php echo "Email: " . $rowaddress['employee_email'] ?></h6>
                                                    <h6 class="d-flex justify-content-center"><?php echo "Phone: " . $rowaddress['employee_phone'] ?></h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h5>SHIPPING ADDRESS:</h5>
                                                    <p class="text-dark"><?php echo str_replace('//', '<br>', $address) . '<br>'; ?></p>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-center">
                                            <input type="submit" value="PRINT ORDER" id="printbtn" class="btn btn-warning text-dark col-sm-2" onclick="PrintElem('printcard')" style="border-radius: 30px">
                                            <div class="col-sm-1"></div>
                                            <input type="submit" value="MARK AS DONE" id="donebtn" onClick="javascript:return confirm('Press OK to mark as done');" class="btn btn-warning text-dark col-sm-4" name="markasdone" style="border-radius: 30px">
                                        </div>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    <?php break;
                    } ?>
                    <br>
                </tbody>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['markasdone'])) {
        $query = "UPDATE sales SET order_status = 1 WHERE order_id = '$_POST[react]'";
        mysqli_query($database, $query);
        $q = "SELECT employee_id,order_id FROM sales WHERE order_id = '$_POST[react]'";
        $r = mysqli_query($database, $q);
        while ($row123 = mysqli_fetch_array($r)) {
            $qq = "SELECT * FROM employee WHERE employee_id = '$row123[employee_id]'";
            $rr = mysqli_query($database, $qq);
            while ($row321 = mysqli_fetch_array($rr)) {
                phpMailer("JUPITER", "$row321[employee_email]", "Order Confirmation", "Dear $row321[first_name] $row321[last_name],\n\nOrder is now complete and will be shipout today for delivery within the next 72 business hours.\n\nTotal of your order $$_POST[react2]\n\nOrder ID: $row123[order_id]\n\nVisit our website for more information.");
            }
            break;
        }
        echo "<script type='text/javascript'>alert('order is marked as done');</script>";
        echo "<script type='text/javascript'> document.location = 'admin-orders.php'; </script>";
    }
    ?>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>

</html>