<?php
session_start();
include('configure.php');
include('cart.php');
require_once("dbcontroller.php");
if (!isset($_SESSION['name'])) {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}

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
    <title>Orders</title>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <SCRIPT LANGUAGE="JavaScript">
        //script to save scroll position
        /**
            These group of methods will save scroll position x and y then after reload will go back to the save position 
         */
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
    <?php include('navbar.php'); ?>
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
            <br>
            <div class="container">
                <tbody>
                    <?php
                    $data_saver = array();
                    ?>
                    <?php
                    /**
                     * Get all seller orders with details
                     * 
                     * @return Response HTML
                     */
                    $query1 = "SELECT * FROM sales WHERE employee_id = '$_SESSION[employee_id_saver]' ORDER BY SYSDATE DESC";
                    $result1 = mysqli_query($database, $query1);
                    while ($row1 = mysqli_fetch_array($result1)) {
                        $random_order_id = $row1['order_id'];
                        break;
                    }
                    $total_for_each_order = 0;
                    $count_orders = 0;
                    $query = "SELECT * FROM sales WHERE employee_id = '$_SESSION[employee_id_saver]' ORDER BY SYSDATE DESC";
                    $result = mysqli_query($database, $query);
                    $count_orders = mysqli_num_rows($result);
                    while ($row = mysqli_fetch_array($result)) {
                        if ($random_order_id == $row['order_id']) {
                            array_push($data_saver, $row);
                            $total_for_each_order += $row['product_price'] * $row['item_quantity'];
                        } else {
                            foreach ($data_saver as $x) {
                                /**
                                 * View order print all items orderd (product name, id, date, status, quantitiy/price)
                                 * 
                                 * @return Response html
                                 */
                    ?>
                                <div class="card text-dark">
                                    <div class="card-body">
                                        <form action="seller_orders.php" method="POST">
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
                                                    <input type="submit" class="btn btn-warning" id="vieworder" onclick="hideView()" value="VIEW ORDER" name="<?php echo $x['order_id']; ?>">
                                                </div>
                                            </div>
                                            <?php
                                            if (isset($_POST[$x['order_id']])) {
                                            ?>
                                                <br>
                                                <div class="table-responsive" id="orderstable" >
                                                    <table class="table">
                                                        <thead>
                                                            <tr class="text-muted bg-warning">
                                                                <th scope="col">PRODUCT</th>
                                                                <th scope="col">ORDER</th>
                                                                <th scope="col">DATE</th>
                                                                <th scope="col">STATUS</th>
                                                                <th scope="col">PRICE</th>
                                                                <th scope="col">ACTIONS</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-dark">
                                                            <?php
                                                            $status = "";
                                                            $queryx = "SELECT * FROM sales WHERE employee_id = '$_SESSION[employee_id_saver]' AND order_id = '$_POST[react]' ORDER BY SYSDATE DESC";
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
                                                                    echo "<form method='POST' action='seller_orders.php'>
                                                                                <tr>
                                                                     <td>$row1[product_name]</td>
                                                                     <td>$rowx[order_id]</td>
                                                                     <td>$rowx[SYSDATE]</td>
                                                                     <td>$status</td>
                                                                     <td>$$rowx[product_price] for $rowx[item_quantity] item</td>
                                                                     <input type='hidden' name='code' value='$row1[product_code]'>
                                                                     <td><input type='submit' name='view' value='VIEW ITEM' style='border-radius:30px' class='btn btn-warning btn-block'></td>
                             
                                                                        </tr>
                                                                     </form>";
                                                                }
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>
                                                </div>

                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>

                        <?php
                                break;
                            }
                            echo "<br>";
                            $total_for_each_order = 0;
                            $data_saver = array();
                            $random_order_id = $row['order_id'];
                            $total_for_each_order += $row['product_price'] * $row['item_quantity'];
                            array_push($data_saver, $row);
                        }
                    }

                    foreach ($data_saver as $x) {
                        ?>
                        <div class="card text-dark">
                            <div class="card-body">
                                <form action="seller_orders.php" method="POST">
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
                                            <p class="d-flex justify-content-center" style="background-color: pink">&nbsp;
                                                <?php echo "Total Price: $" . $total_for_each_order ?></p>
                                        </div>
                                        <input type="hidden" name="react" value="<?php echo $x['order_id']; ?>">
                                        <div class="col-sm-2 d-flex justify-content-center">
                                            <input type="submit" class="btn btn-warning" value="VIEW ORDER" name="<?php echo $x['order_id']; ?>">
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($_POST[$x['order_id']])) {
                                    ?>
                                        <br>
                                        <div class="table-responsive" >
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-muted bg-warning">
                                                        <th scope="col">PRODUCT</th>
                                                        <th scope="col">ORDER</th>
                                                        <th scope="col">DATE</th>
                                                        <th scope="col">STATUS</th>
                                                        <th scope="col">PRICE</th>
                                                        <th scope="col">ACTIONS</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-dark">
                                                    <?php
                                                    $status = "";
                                                    $queryx = "SELECT * FROM sales WHERE employee_id = '$_SESSION[employee_id_saver]' AND order_id = '$_POST[react]' ORDER BY SYSDATE DESC";
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
                                                            echo "<form method='POST' action='seller_orders.php'>
                                    <tr>
                             <td>$row1[product_name]</td>
                             <td>$rowx[order_id]</td>
                             <td>$rowx[SYSDATE]</td>
                             <td>$status</td>
                             <td>$$rowx[product_price] for $rowx[item_quantity] item</td>
                             <input type='hidden' name='code' value='$row1[product_code]'>
                             <td><input type='submit' name='view' value='VIEW ITEM' style='border-radius:30px' class='btn btn-warning btn-block'></td>
                             
                         </tr>
                         </form>";
                                                        }
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>

                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    <?php break;
                    } ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    <?php if (isset($_POST['view'])) {
        $query = "SELECT * FROM product WHERE product_code='$_POST[code]'";
        $result = mysqli_query($database, $query);
        while ($row = mysqli_fetch_array($result)) {
            $_SESSION['saved_id'] = $row['product_id'];
            $_SESSION['saved_code'] = $row['product_code'];
            $_SESSION['saved_image'] = $row['product_image'];
            $_SESSION['saved_specification'] = $row['product_specification'];
            $_SESSION['saved_price'] = $row['product_price'];
            $_SESSION['saved_name'] = $row['product_name'];
            $_SESSION['saved_description'] = $row['product_description'];
            $_SESSION['saved_sale'] = $row['product_sale'];
        }
        echo "<script type='text/javascript'> document.location = 'viewitem.php'; </script>";
    } ?>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>

</body>
<?php include('footer.php'); ?>

</html>