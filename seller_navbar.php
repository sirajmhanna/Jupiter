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
    </div>
</div>


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