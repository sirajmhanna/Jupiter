<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading d-flex justify-content-center">
        <img src="assets/img/jupiterlogo.png" alt="logo" style="height:50px">
    </div>
    <div class="list-group list-group-flush">
        <form action="admin.php" method="post" style="margin-top: 18px">
            <input type="submit" value="Dashboard" name="dashboard" class="btn btn-block" style="background-color: rgb(254,198,1)">
            <input type="submit" value="Manage Products" name="products" class="btn btn-block" style="background-color: rgb(254,198,1)">
            <input type="submit" value="Manage Orders" name="orders" class="btn btn-block" style="background-color: rgb(254,198,1)">         
            <input type="submit" value="Manage Sellers" name="managesellers" class="btn btn-block" style="background-color: rgb(254,198,1)">         
            <input type="submit" value="Payments" name="payment" class="btn btn-block" style="background-color: rgb(254,198,1)">         
            <input type="submit" value="Sellers" name="sellers" class="btn btn-block" style="background-color: rgb(254,198,1)">         
            <input type="submit" value="Mail" name="mail" class="btn btn-block" style="background-color: rgb(254,198,1)">         
            <input type="submit" value="Logout" name="logout" onClick="javascript:return confirm('Are you sure you want to logout?');" class="btn btn-block" style="background-color: rgb(254,198,1)">         
        </form>
    </div>
</div>

<?php
if (isset($_POST['products'])) {
    echo "<script type='text/javascript'> document.location = 'admin-products.php'; </script>";
}
if (isset($_POST['payment'])) {
    echo "<script type='text/javascript'> document.location = 'admin-payments.php'; </script>";
}
if (isset($_POST['dashboard'])) {
    echo "<script type='text/javascript'> document.location = 'admin.php'; </script>";
}
if (isset($_POST['orders'])) {
    echo "<script type='text/javascript'> document.location = 'admin-orders.php'; </script>";
}
if (isset($_POST['mail'])) {
    echo "<script type='text/javascript'> document.location = 'admin-mails.php'; </script>";
}
if (isset($_POST['sellers'])) {
    echo "<script type='text/javascript'> document.location = 'admin-sellers.php'; </script>";
}
if (isset($_POST['managesellers'])) {
    echo "<script type='text/javascript'> document.location = 'admin-sellers-manage.php'; </script>";
}
if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    echo "<script type='text/javascript'> document.location = 'admin-login.php'; </script>";
}
?>