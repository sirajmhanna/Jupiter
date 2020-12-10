<?php
session_start();
require_once("dbcontroller.php");
include('phpmailer.php');
if (!isset($_SESSION['admin_email'])) {
    echo "<script type='text/javascript'> document.location = 'admin-login.php'; </script>";
}
function randomPassword()
{
    $alphabet = 'abcdefghijklmnopq*&^%$#@?>rstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890/*-+-*&^%$#@?><":}{';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 10; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
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
    <title>Admin Manange Sellers</title>
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
    <style>
        a {
            color: black
        }
    </style>
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
                <h4 class="d-flex justify-content-center">MANAGE SELLERS REQUEST</h4>
                <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); " />
                <?php
                $querya = "SELECT * FROM employee WHERE status = 3";
                $resulta = mysqli_query($database, $querya);
                if (mysqli_num_rows($resulta) < 1) {
                    echo "<script type='text/javascript'>
                    document.getElementById('table123').style.display = 'none';
                    </script>";
                    echo "<h5 class='d-flex justify-content-center'>You have no request</h5>";
                } else {
                ?>
                    <div id="table123">
                        <table class="table table-striped">
                            <thead>
                                <tr class="bg-warning" align="center">
                                    <th scope="col">NAME</th>
                                    <th scope="col">EMAIL</th>
                                    <th scope="col">PHONE</th>
                                    <th scope="col">REQEUST FROM</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM employee WHERE status = 3";
                                $result = mysqli_query($database, $query);
                                while ($row = mysqli_fetch_array($result)) {
                                    $from = "";
                                    $q  = "SELECT first_name,last_name,parent_id FROM employee WHERE employee_id = '$row[parent_id]'";
                                    $r = mysqli_query($database, $q);
                                    while ($rr = mysqli_fetch_array($r)) {
                                        $from = $rr['first_name'] . " " . $rr['last_name'];
                                    }
                                    echo "
                        <form action='admin-sellers-manage.php' method='POST'>
                        <tr align='center'>
                            <td>$row[first_name] $row[last_name]</td>
                            <td><a href='mailto:$row[employee_email]'>$row[employee_email]</a></td>
                            <td><a href='tel:$row[employee_phone]'>$row[employee_phone]</a></td>
                            <td>$from</td>
                            <td>
                            <input type='hidden' name='react' value='$row[employee_id]'>
                            <input type='hidden' name='react2' value='$row[parent_id]'>
                            <input type='submit' value='Accept' name='add' style='border-radius:30px' class='btn btn-warning'>
                            <input type='submit' value='Delete' name='delete' style='border-radius:30px' class='btn btn-danger'>
                            </td>
                        </tr>
                        </form>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                }
                ?>
                <?php
                /**
                 * Accept sellers requests
                 * 
                 * @return status(200) accepted
                 */
                if (isset($_POST['add'])) {
                    $query = "UPDATE employee SET status = 1 WHERE employee_id = '$_POST[react]'";
                    mysqli_query($database, $query);
                    $query1 = "SELECT * FROM employee WHERE employee_id = '$_POST[react]'";
                    $result1 = mysqli_query($database, $query1);
                    $qqq = "SELECT * FROM employee WHERE employee_id = '$_POST[react2]'";
                    $rrr = mysqli_query($database, $qqq);
                    while ($rows = mysqli_fetch_array($rrr)) {
                        phpMailer("JUPITER", "$rows[employee_email]", "Acceptance Letter", "Dear $rows[first_name] $rows[last_name],\n\nThe request to add a new seller has been accepted.\n\nPlease contact the company for more details.\n\nBest regards.");
                        break;
                    }
                    while ($row1 = mysqli_fetch_array($result1)) {
                        $password = randomPassword();
                        $md5_password = md5($password);
                        $q = "UPDATE employee SET employee_password = '$md5_password' WHERE employee_id = '$row1[employee_id]'";
                        mysqli_query($database, $q);
                        phpMailer("JUPITER", "$row1[employee_email]", "Acceptance Letter", "Dear $row1[first_name] $row1[last_name],\n\nYou have been accepted as a seller in our company JUPITER s.a.r.l \n\nLogin details:\n\nEmail: $row1[employee_email]\nPassword: $password\n\nOnce logged in you can change your password.  \n\nBest regards.");
                    }
                    echo "<script type='text/javascript'>alert('You have added a new seller');</script>";
                    echo "<script type='text/javascript'> document.location = 'admin-sellers-manage.php'; </script>";
                }
                /**
                 * Reject sellers requests
                 * 
                 * @return status(200) rejected
                 */
                if (isset($_POST['delete'])) {
                    $query = "DELETE FROM employee WHERE employee_id = '$_POST[react]'";
                    mysqli_query($database, $query);
                    $query1 = "SELECT * FROM employee WHERE employee_id = '$_POST[react]'";
                    $result1 = mysqli_query($database, $query1);
                    $qqq = "SELECT * FROM employee WHERE employee_id = '$_POST[react2]'";
                    $rrr = mysqli_query($database, $qqq);
                    while ($rows = mysqli_fetch_array($rrr)) {
                        phpMailer("JUPITER", "$rows[employee_email]", "Seller Request", "Dear $rows[first_name] $rows[last_name],\n\nThe request to add a new seller has been rejected.\n\nPlease contact the company for more details.\n\nBest regards.");
                        break;
                    }
                }
                ?>
                <br><br>
                <h4 class="d-flex justify-content-center">REMOVE SELLERS</h4>
                <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); " />
                <table class="table">
                    <thead>
                        <tr class="bg-warning">
                            <th scope="col">NAME</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col">PHONE</th>
                            <th scope="col">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM employee WHERE status = 1 AND employee_id != parent_id";
                        $result = mysqli_query($database, $query);
                        while ($row = mysqli_fetch_array($result)) {

                        ?>
                            <form action="admin-sellers-manage.php" method="POST">
                                <tr>
                                    <input type="hidden" name="react22" value="<?php echo $row['employee_id']; ?>">
                                    <input type="hidden" name="react3" value="<?php echo $row['first_name']; ?>">
                                    <input type="hidden" name="react4" value="<?php echo $row['last_name']; ?>">
                                    <input type="hidden" name="react5" value="<?php echo $row['employee_email']; ?>">
                                    <input type="hidden" name="react6" value="<?php echo $row['parent_id']; ?>">
                                    <td><?php echo $row['first_name'] . " " . $row['last_name'] ?></td>
                                    <td> <a href="mailto:<?php echo $row['employee_email']; ?>"><?php echo $row['employee_email']; ?></a></td>
                                    <td> <a href="tel:<?php echo $row['employee_phone']; ?>"><?php echo $row['employee_phone']; ?></a> </td>
                                    <td><input type="submit" value="REMOVE" onClick="javascript:return confirm('Are you sure you want to remove this seller?');" name="removeseller" class="btn btn-warning" style="border-radius: 30px"></td>
                                </tr>
                            </form>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                /**
                 * Remove seller
                 * 
                 * @return Response status(200)
                 */
                if (isset($_POST['removeseller'])) {
                    $query = "UPDATE employee SET status = 2 WHERE employee_id = '$_POST[react22]'";
                    mysqli_query($database, $query);
                    $qqq = "SELECT * FROM employee WHERE employee_id = '$_POST[react6]'";
                    $rrr = mysqli_query($database, $qqq);
                    while ($rows = mysqli_fetch_array($rrr)) {
                        phpMailer("JUPITER", "$rows[employee_email]", "Account Disabled", "Dear $rows[first_name] $rows[last_name],\n\nSeller $_POST[react3] $_POST[react4] account has been disabled.\n\nPlease contact the company for more details.\n\nBest regards.");
                        break;
                    }
                    phpMailer("JUPITER", "$_POST[react5]", "Account Disabled", "Dear $_POST[react3] $_POST[react4],\n\nYour account has been disabled.\n\nContact parent seller for more details.\n\nBest regards.");
                    echo "<script type='text/javascript'>alert('You have removed seller $_POST[react3] $_POST[react4]');</script>";
                    echo "<script type='text/javascript'> document.location = 'admin-sellers-manage.php'; </script>";
                }
                ?>
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