<?php
session_start();
require_once("dbcontroller.php");
if (!isset($_SESSION['admin_email'])) {
    echo "<script type='text/javascript'> document.location = 'admin-login.php'; </script>";
}
?>
<?php
function sortByOrder($b, $a) {
    return $a['balance'] - $b['balance'];
}
// collect sellers balance
/**
 * Print sellers balance and add payment for each seller
 * 
 * @return status(201) payment confirmed
 */
$data = array();
$balance = 0;
$query = "SELECT * FROM employee WHERE status = 1";
$result = mysqli_query($database, $query);
while ($row = mysqli_fetch_array($result)) {
    $query1 = "SELECT * FROM commission WHERE employee_id = '$row[employee_id]'";
    $result1 = mysqli_query($database, $query1);
    while ($row1 = mysqli_fetch_array($result1)) {
        if ($row1['commission_from_seller'] == 2) {
            $balance -= $row1['commission_amount'];
        } else {
            $balance += $row1['commission_amount'];
        }
    }
    array_push($data, array("id" => $row['employee_id'], "name" => $row['first_name'] . " " . $row['last_name'], "balance" => $balance));
    $balance = 0;
}
usort($data, 'sortByOrder');
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
    <title>Admin Payments</title>
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
                <h4 class="d-flex justify-content-center">PAYMENTS</h4>
                <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); " />
                <br>
                <table class="table table-striped">
                    <thead>
                        <tr class="bg-warning">
                            <th scope="col">ID</th>
                            <th scope="col">NAME</th>
                            <th scope="col">BALANCE ($)</th>
                            <th scope="col">PAYMENT AMOUNT ($)</th>
                            <th scope="col">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data as $key) {
                        ?>
                            <form action="admin-payments.php" method="POST">
                                <input type="hidden" name="react" value="<?php echo $key['id']; ?>">
                                <tr>
                                    <td><?php echo $key['id']; ?></td>
                                    <td><?php echo $key['name']; ?></td>
                                    <td><?php echo $key['balance']; ?></td>
                                    <td><input type="number" class="form-control col-sm-7" step="any" name="payment_amount" placeholder="add payment amount"></td>
                                    <td><input type="submit" value="SUBMIT" name="submit" onClick="javascript:return confirm('Are you sure you want to add this payment');" class="btn btn-warning" style="border-radius: 30px"></td>
                                </tr>
                            </form>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <br><br>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['submit'])) {
        if ($_POST['payment_amount'] < 0.01) {
            echo "<script type='text/javascript'>alert('Payment is not accepted.');</script>";
        } else {
            $query = "INSERT INTO commission VALUE (0,'$_POST[react]',$_POST[payment_amount],SYSDATE(),2)";
            mysqli_query($database, $query);
            echo "<script type='text/javascript'>alert('You have added a new payment to seller (#$_POST[react]), payment amount: $$_POST[payment_amount]');</script>";
            echo "<script type='text/javascript'> document.location = 'admin-payments.php'; </script>";
        }
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