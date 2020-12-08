<?php
session_start();
include('configure.php');
include('cart.php');
require_once("dbcontroller.php");
if (!isset($_SESSION['name'])) {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
if (isset($_POST['shoppingcart'])) {
    echo "<script type='text/javascript'> document.location = 'shoppingcart.php'; </script>";
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
    <title>Home</title>
</head>
<?php include('navbar.php'); ?>

<body>
 
    <?php include("products.php"); ?>
   <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <body>
        <?php include('footer.php') ?>

</html>
