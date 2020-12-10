<?php
session_start();
require_once("dbcontroller.php");
if (!isset($_SESSION['admin_email'])) {
    echo "<script type='text/javascript'> document.location = 'admin-login.php'; </script>";
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
    <title>Admin Sellers</title>
    <style>
        a{
            color: black
        }
    </style>
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
                <form action="admin-sellers.php" class="d-flex justify-content-center" method="POST">
                    <input class="form-control col-sm-7" style="border-color: rgb(254,198,1)" type="text" name="searchvalue" placeholder="Search for sellers (enter seller name or seller id)" aria-label="Search">
                    <input type="submit" class="col-sm-1 btn btn-warning" value="SEARCH" name="search">
                </form>
                <br>
                <table class="table table-striped">
                    <thead>
                        <tr class="bg-warning">
                            <th scope="col">ID</th>
                            <th scope="col">NAME</th>
                            <th scope="col">ADDRESS</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col">PHONE</th>
                            <th scope="col">PARENT_ID</th>
                            <th scope="col">TOTAL(annual)</th>
                            <th scope="col">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        /**
                         * Print all sellers 
                         * 
                         * @return Response html (sellers name, email, phone, total(annual))
                         */
                        $total = 0;
                        $year = date("Y");
                        if (isset($_POST['search'])) {
                            $value = $_POST['searchvalue'];
                            $query = "SELECT * FROM employee WHERE first_name like '%" . $value . "%' OR employee_id like '%" . $value . "%'";
                            $result = mysqli_query($database, $query);
                            while ($row = mysqli_fetch_array($result)) {
                                $q = "SELECT * from sales WHERE employee_id = '$row[employee_id]' AND SYSDATE like '%" . $year . "%'";
                                $r = mysqli_query($database,$q);
                                while($rr = mysqli_fetch_array($r)){
                                $total += ($rr['product_price']*$rr['item_quantity']);
                                }
                                $address = str_replace('//', '<br>', $row['employee_address']) . '<br>';
                                $status = $row['status'];
                                if($row['status'] == 1){
                                    $status = "enabled";
                                }
                                else if($row['status'] == 2){
                                    $status = "disabled";
                                }
                                echo "
                                <tr>
                            <td scope='col'>$row[employee_id]</td>
                            <td scope='col'>$row[first_name] $row[last_name]</td>
                            <td scope='col'>$address</td>
                            <td scope='col'><a href='mailto:$row[employee_email]'>$row[employee_email]</a></td>
                            <td scope='col'><a href='tel:$row[employee_phone]'>$row[employee_phone]</a></td>
                            <td scope='col'>$row[parent_id]</td>
                            <td scope='col'>$total</td>
                            <td scope='col'>$status</td>
                        </tr>
                                ";
                            }
                        } else {
                            $query = "SELECT * FROM employee WHERE status != 3";
                            $result = mysqli_query($database, $query);
                            while ($row = mysqli_fetch_array($result)) {
                                $q = "SELECT * from sales WHERE employee_id = '$row[employee_id]' AND SYSDATE like '%" . $year . "%'";
                                $r = mysqli_query($database,$q);
                                while($rr = mysqli_fetch_array($r)){
                                $total += ($rr['product_price']*$rr['item_quantity']);
                                }
                                $address = str_replace('//', '<br>', $row['employee_address']) . '<br>';
                                $status = $row['status'];
                                if($row['status'] == 1){
                                    $status = "enabled";
                                }
                                else if($row['status'] == 2){
                                    $status = "disabled";
                                }
                                echo "
                                <tr>
                            <td scope='col'>$row[employee_id]</td>
                            <td scope='col'>$row[first_name] $row[last_name]</td>
                            <td scope='col'>$address</td>
                            <td scope='col'><a href='mailto:$row[employee_email]'>$row[employee_email]</a></td>
                            <td scope='col'><a href='tel:$row[employee_phone]'>$row[employee_phone]</a></td>
                            <td scope='col'>$row[parent_id]</td>
                            <td scope='col'>$total</td>
                            <td scope='col'>$status</td>

                        </tr>
                                ";
                            }
                        }
                        ?>
                    </tbody>
                </table>
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