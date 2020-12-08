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
    <title>Settings</title>
</head>
<body>
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="d-flex justify-content-center text-dark">ADDRESSES</h4>
                    </div>
                    <div class="card-body bg-warning">
                        <form action="seller_settings.php" method="POST">
                            <?php // get employee address
                            $address = "";
                            $query = "SELECT * from employee WHERE employee_id = '$_SESSION[employee_id_saver]'";
                            $result = mysqli_query($database, $query);
                            while ($row = mysqli_fetch_array($result)) {
                                $address = $row['employee_address'];
                            }
                            ?>
                            <h4 class="text-muted">Saved address: </h4>
                            <p class="text-muted"><?php echo str_replace('//', '<br>', $address) . '<br>'; ?></p>
                            <div class="form-group "><input class="form-control btn bg-muted" type="text" style="background-color: #ffff;border-radius:50px" name="streetaddress" placeholder="Street address" required></div>
                            <div class="form-group "><input class="form-control btn bg-muted" type="text" style="background-color: #ffff;border-radius:50px" name="apartment" placeholder="Apartment,suite,unit ect" required></div>
                            <div class="form-group "><input class="form-control btn bg-muted" type="text" style="background-color: #ffff;border-radius:50px" name="city" placeholder="Town / City" required></div>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <input type="submit" value="UPDATE ADDRESS" name="saveaddress" class="btn col-sm-4 btn-warning" style="border-radius: 30px">
                        </form>
                    </div>
                </div>
            </div>
            <br>
            <hr class="col-sm-10" style="border: 0; height: 3px; 
    background-image: -webkit-linear-gradient(left, rgb(254,198,1), rgb(163, 153, 119), rgb(254,198,1));
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), rgb(163, 153, 119)); " />
            <br>
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h4 class="d-flex justify-content-center text-dark">ACCOUNT DETAILS</h4>
                    </div>
                    <div class="card-body bg-warning">
                        <form action="seller_settings.php" method="POST">
                            <?php // get employee address
                            $address = "";
                            $query = "SELECT * from employee WHERE employee_id = '$_SESSION[employee_id_saver]'";
                            $result = mysqli_query($database, $query);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>

                                <div class="row">
                                    <div class="col-sm-6 form-group"><span>&nbsp;&nbsp;First name*</span><input type="text" value="<?php echo $row['first_name']; ?>" class="form-control btn bg-muted" name="firstname" placeholder="First name" style="background-color: #ffff;border-radius:50px" required></div>
                                    <div class="col-sm-6 form-group"><span>&nbsp;&nbsp;Last name*</span><input type="text" value="<?php echo $row['last_name']; ?>" class="form-control btn bg-muted" name="lastname" placeholder="Last name" style="background-color: #ffff;border-radius:50px" required></div>
                                </div>
                                <div class="form-group"><span>&nbsp;&nbsp;Email address*</span><input class="form-control btn bg-muted" value="<?php echo $row['employee_email']; ?>" type="email" style="background-color: #ffff;border-radius:50px" name="email" placeholder="Email address" required></div>
                                <div class="form-group"><span>&nbsp;&nbsp;Phone number*</span><input class="form-control btn bg-muted" value="<?php echo $row['employee_phone']; ?>" type="text" style="background-color: #ffff;border-radius:50px" name="phonenumber" placeholder="Phone number" required></div>
                                <p class="text-muted">PASSWORD CHANGE</p>
                                <hr>
                            <?php } ?>
                            <div class="form-group"><span>&nbsp;&nbsp;Current password (leave blank to leave unchanged)</span><input class="form-control btn bg-muted" type="password" style="background-color: #ffff;border-radius:50px" name="currentpassword" placeholder="Current password"></div>
                            <div class="form-group"><span>&nbsp;&nbsp;New password (leave blank to leave unchanged)</span><input class="form-control btn bg-muted" type="password" style="background-color: #ffff;border-radius:50px" name="newpassword" placeholder="New password"></div>
                            <div class="form-group"><span>&nbsp;&nbsp;Confirm new password (leave blank to leave unchanged)</span><input class="form-control btn bg-muted" type="password" style="background-color: #ffff;border-radius:50px" name="confirmnew" placeholder="Confirm password"></div>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <input type="submit" value="UPDATE ACCOUNT DETAILS" name="accountdetails" class="btn col-sm-4 btn-warning" style="border-radius: 30px">
                        </form>
                    </div>
                </div>
            </div>
            <br><br><br><br>
        </div>
    </div>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>
<?php include('footer.php'); ?>

</html>
<?php
// save new address
if (isset($_POST['saveaddress'])) {
    $street_address = $_POST['streetaddress'];
    $apartment = $_POST['apartment'];
    $city = $_POST['city'];
    $address = "Street address: " . $street_address . " // Apartment: " . $apartment . " " . " // Town/City: " . $city;
    $query = "UPDATE employee SET employee_address = '$address' WHERE employee_id = '$_SESSION[employee_id_saver]'";
    mysqli_query($database, $query);
    echo "<script type='text/javascript'> document.location = 'seller_settings.php'; </script>";
}
// update account information
if (isset($_POST['accountdetails'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phonenumber'];
    $current_password = $_POST['currentpassword'];
    $current_password = md5($current_password);
    $new_password = $_POST['newpassword'];
    $confirm_new = $_POST['confirmnew'];

    if (empty($current_password) || empty($new_password) || empty($confirm_new)) {
        $query = "UPDATE employee SET first_name = '$firstname' WHERE employee_id = '$_SESSION[employee_id_saver]'";
        mysqli_query($database, $query);
        $query = "UPDATE employee SET last_name = '$lastname' WHERE employee_id = '$_SESSION[employee_id_saver]'";
        mysqli_query($database, $query);
        $query = "UPDATE employee SET employee_email = '$email' WHERE employee_id = '$_SESSION[employee_id_saver]'";
        mysqli_query($database, $query);
        $query = "UPDATE employee SET employee_phone = '$phone' WHERE employee_id = '$_SESSION[employee_id_saver]'";
        mysqli_query($database, $query);
        echo "<script type='text/javascript'>alert('Account details have been updated');</script>";
        echo "<script type='text/javascript'> document.location = 'seller_settings.php'; </script>";
    } else if (!empty($current_password) && !empty($new_password) && !empty($confirm_new)) {
        if (strcmp($_SESSION['employee_password'], $current_password) == 0) {
            if (strcmp($new_password, $confirm_new) == 0) {
                $new_password = md5($new_password);
                $query = "UPDATE employee SET employee_password = '$new_password' WHERE employee_id = '$_SESSION[employee_id_saver]'";
                mysqli_query($database, $query);
                $query = "UPDATE employee SET first_name = '$firstname' WHERE employee_id = '$_SESSION[employee_id_saver]'";
                mysqli_query($database, $query);
                $query = "UPDATE employee SET last_name = '$lastname' WHERE employee_id = '$_SESSION[employee_id_saver]'";
                mysqli_query($database, $query);
                $query = "UPDATE employee SET employee_email = '$email' WHERE employee_id = '$_SESSION[employee_id_saver]'";
                mysqli_query($database, $query);
                $_SESSION['employee_password'] = $new_password;
                //md5
                echo "<script type='text/javascript'>alert('Account details have been updated');</script>";
            } else {
                echo "<script type='text/javascript'>alert('Password confirmation does not match Password');</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('Your current account password is wrong');</script>";
        }
    }
}
?>