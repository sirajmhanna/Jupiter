<?php
session_start();
require_once("dbcontroller.php");
include('phpmailer.php');
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
    <title>Admin Mails</title>
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
            <br>
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h4 class="d-flex justify-content-center">Mail Sellers</h4>
                    </div>
                    <div class="card-body">
                        <form action="admin-mails.php" method="POST">
                            <div class="row col-sm-12">
                                <p class="form-control col-sm-1">To</p><input class="form-control col-sm-11" type="text" value="ALL@jupiter.com" disabled>
                            </div>
                            <input class="form-control" type="text" placeholder="Subject" name="subject" required>
                            <hr>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">add \n to break into a new line Example (Dear jupiter,\n You are smart...)</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="8" name="body" placeholder="body..." required></textarea>
                            </div>

                    </div>
                    <div class="card-footer">
                        <input type="submit" value="SUBMIT" name="send" class="form-control bg-warning" onClick="javascript:return confirm('Are you sure you want to send this email');">
                        </form>
                        <?php
                        /**
                         * send email to all jupiter sellers
                         * 
                         * @param string $subject
                         * @param string $body
                         * 
                         * @return status(200) sent
                         */
                        if (isset($_POST['send'])) {
                            $subject = $_POST['subject'];
                            $body = $_POST['body'];
                            $query = "SELECT * FROM employee WHERE status = 1";
                            $result = mysqli_query($database, $query);
                            while ($row = mysqli_fetch_array($result)) {
                                phpMailer("JUPITER", "$row[employee_email]", "$subject", "$body");
                            }
                        }
                        ?>
                    </div>
                </div>
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