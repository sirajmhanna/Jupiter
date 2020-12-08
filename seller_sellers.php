<?php
session_start();
include('configure.php');
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
    <title>Sellers</title>
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
    <style>
        div.dxdiag a:hover {
            background-color: rgb(254, 198, 1);
        }
    </style>
</head>
<?php include('navbar.php'); ?>

<body onLoad="loadScroll()" onUnload="saveScroll()">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <div class="d-flex" id="wrapper">
        <?php include('seller_navbar.php'); ?>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" id="menu-toggle" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
            <div class="container">
                <div class="row">
                    <?php
                    /**
                     * Get all child sellers
                     * 
                     * load all the sellers hired by the user
                     * 
                     * @return Response HTML
                     */
                    $query = "SELECT * FROM employee WHERE parent_id = '$_SESSION[employee_id_saver]' AND employee_id != '$_SESSION[employee_id_saver]' AND status != 2";
                    $result = mysqli_query($database, $query);
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <div class="col-sm-6">
                            <div class="card" style="height: calc(100% - 15px);margin-bottom: 15px;">
                                <div class="card-header">
                                    <h4 class="d-flex justify-content-center text-dark"><?php echo $row['first_name'] . " " . $row['last_name']; ?></h4>
                                    <span class="d-flex justify-content-center text-dark"><?php if($row['status'] == 3){echo "seller not activated yet, contact admin for more information";} ?></span>
                                </div>
                                <div class="card-body">
                                    <p class="d-flex justify-content-center text-dark btn"><?php echo "ID: " . $row['employee_id']; ?></p>
                                    <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); " />
                                    <div class="dxdiag"><a href="mailto: <?php echo $row['employee_email']; ?>" class="d-flex justify-content-center text-dark btn"><?php echo "EMAIL: <br>" . $row['employee_email']; ?></a></div>
                                    <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); " />
                                    <p class="d-flex justify-content-center text-dark btn flex-fill"><?php echo "ADDRESS: <br>" . str_replace('//', '<br>', $row['employee_address']) . '<br>'; ?></p>
                                    <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); " />
                                    <div class="dxdiag"><a href="tel:<?php echo $row['employee_phone']; ?>" class="text-dark d-flex justify-content-center text-dark btn"><?php echo "PHONE NUMBER: <br>" . $row['employee_phone']; ?></a></div>

                                </div>
                                <div class="card-footer">
                                    <form action="seller_sellers.php" method="POST" class="d-flex justify-content-center">
                                        <input type="hidden" name="react" value="<?php echo $row['employee_id']; ?>">
                                        <input type="submit" value="Remove Seller" id="myBtn" onClick="javascript:return confirm('Are you sure you want to remove seller?');" class="btn btn-warning" style="border-radius: 30px" name="removeseller">
                                    </form>
                                </div>
                            </div>
                            <br>
                        </div>
                    <?php
                    }
                    ?>
                    <?php
                    //remove sellers
                    /**
                     * Remove child seller
                     * 
                     * @return Response
                     */
                    if (isset($_POST['removeseller'])) {
                        $saved_id = $_POST['react'];
                        $query1 = "UPDATE employee SET status = '2' WHERE employee_id='$saved_id'";
                        mysqli_query($database, $query1);
                        echo "<script type='text/javascript'> document.location = 'seller_sellers.php'; </script>";
                    }
                    ?>
                    <?php
                    $query = "SELECT parent_id FROM employee WHERE parent_id = '$_SESSION[employee_id_saver]' AND employee_id != '$_SESSION[employee_id_saver]' AND status != 2";
                    $result = mysqli_query($database, $query);
                    $sellers_count = mysqli_num_rows($result);
                    if ($sellers_count < 4) { ?>
                        <div class="col-sm-<?php if ($sellers_count == 0 || $sellers_count == 2) {
                                                echo "12";
                                            } else {
                                                echo "6";
                                            } ?>">
                            <div class="card d-flex justify-content-center text-dark" style="height: calc(100% - 15px);margin-bottom: 15px;">
                                <div class="row d-flex justify-content-center">
                                    <form action="seller_sellers.php" method="POST">
                                        <button type="submit" value="ADD SELLERS" class="btn text-dark" name="addsellers">
                                            <i class="fas fa-plus-circle fa-8x text-warning"></i>

                                        </button>
                                        <p class="d-flex justify-content-center">ADD SELLERS</p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php }
                    $sellers_count++;
                    ?>
                </div>
                <br>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['addsellers'])) {
        echo "<script type='text/javascript'> document.location = 'seller_addsellers.php'; </script>";
    }
    ?>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>
<?php include('footer.php'); ?>

</html>