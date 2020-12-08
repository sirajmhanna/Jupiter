<?php
session_start();
include('configure.php');
include('cart.php');
if (!isset($_SESSION['name'])) {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
if (isset($_POST['backtoprofile'])) {
    echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
}
if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            $id = $_GET['code'];
    }
    $query = "SELECT * FROM product WHERE product_code='" . $_GET["code"] . "'";
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
}
?>
<!DOCTYPE html>
<html>

<head>
    <TITLE>View Item</TITLE>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <style>
        .zoomA {
            width: 600px;
            height: auto;
            transition-duration: 1s;
            transition-timing-function: ease;
        }

        .zoomA:hover {
            transform: scale(1.2);
        }
    </style>
</head>
</head>

<body>

    <?php include("navbar.php"); ?>
    <br><br>
    <div class="container text-dark">
        <?php
        $xyz = $_SESSION['saved_id'];
        $query = "SELECT * FROM product WHERE product_id = '$xyz'";
        $result = mysqli_query($database, $query);
        while ($row = mysqli_fetch_array($result)) {
        ?>
            <form method='POST' class="row d-flex justify-content-center" action='viewitem.php?action=add&code=<?php echo $_SESSION['saved_code']; ?>'>
                <div class="col-sm-7 d-flex justify-content-center" style="padding: 13px">
                    <img src='assets/img/<?php echo $_SESSION['saved_image']; ?>' style="height: 395px;width:80%" class="zoomA">
                    <?php
                    if ($row['product_quantity'] < 1) {
                        echo "<img src='assets/img/stockout.png' class='card-img-top d-flex justify-content-center zoomA' style='height:200px;width:100%;border-radius:15px;  position: absolute;opacity: .7'>";
                    }
                    ?>
                </div>
                <div class="col-sm-5 text-dark" style="padding: 13px">
                    <h6><?php echo $_SESSION['saved_description'] ?></h6>
                    <hr>
                    <?php
                    $xxx = $_SESSION['saved_sale'];
                    $yyy = $_SESSION['saved_price'];
                    ?>
                    <h5 class="d-flex justify-content-center" style="background-color: pink"><?php echo '$' . round((($_SESSION['saved_price']) * (1 - $_SESSION['saved_sale'] / 100)), 2) . ' &nbsp; ' ?> <?php echo "<strike>" . ($xxx > 0 ? "$$yyy" : "") . "</strike>"; ?></h5>
                    <hr>
                    <h6><?php echo str_replace('|||', '<br>', $_SESSION['saved_specification']) ?></h6>
                    <br><br><br><br>
                    <div class="d-flex justify-content-center row text-dark" style="padding: 13px">
                        <button type='submit' class='btn d-inline-flex p-2 col-sm-9 d-flex justify-content-center' style='background-color:rgb(254,198,1);border-radius:30px' name="addtocart" <?php if ($row['product_quantity'] < 1) {
                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                            }  ?>>Add to cart</button>
                        <input type="number" class="product-quantity col-sm-2" name="quantity" style="border-radius: 30px;" value="1" size="2" <?php if ($row['product_quantity'] < 1) {
                                                                                                                                                    echo "disabled";
                                                                                                                                                }  ?> />
                    </div>
                </div>
            </form>
    </div>
    <br>
    <br>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <form action="viewitem.php" method="POST">
                <input type="submit" name="backtoprofile" value="Back to home page" class="btn btn-lg row text-dark" style="background-color: rgb(254,198,1)">
            </form>
        </div>
    </div>
    <br>
<?php } ?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
<br>
<?php include('footer.php') ?>

</html>