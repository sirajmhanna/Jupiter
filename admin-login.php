<?php 
include('dbcontroller.php');
$errors = array();

if (!isset($_SESSION)) {
    session_start();
} else {
    $x = $_SESSION['admin_email'];
    session_destroy();
    session_start();
    $_SESSION['admin_email'] = $x;
}
if (isset($_SESSION['admin_email'])) {
    if ($_SESSION['admin_email'] != '') {
        echo "<script type='text/javascript'> document.location = 'admin.php'; </script>";
    }
}

/**
  * Admin login authentication via email and password
  * Add email and password
  * 
  * @author Siraj Mhanna
  *
  * @param string $email
  * @param string $password
  * @return Response.
  */
if (isset($_POST['login_admin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (count($errors) == 0) {
        $query = "SELECT * FROM admin WHERE admin_email = '$email' AND admin_password = '$password' ";
        $result = mysqli_query($database, $query);
        if (mysqli_num_rows($result) == 1) {
            $_SESSION['admin_email'] = $email;
            while($row = mysqli_fetch_array($result)){
                $_SESSION['admin_first_name'] = $row['first_name'];
                $_SESSION['admin_last_name'] = $row['last_name'];
            }
            
            echo "<script type='text/javascript'> document.location = 'admin.php'; </script>";
        } else {
            array_push($errors, "Wrong username or password ");
        }
    }
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <title>Admin Login</title>
</head>
<body class="bg-warning">
    <br>
    <div class="container bg">
        <div class="row d-flex justify-content-center">
        <form method="POST" action="admin-login.php" class="col-sm-5" style="background-color: rgb(163, 153, 119);border-radius:30px">
            <div class="btn d-flex justify-content-center"><a href="index.php"><img src="assets/img/jupiterlogo.png" class="col-sm-12"></a></div>
            <br>
            <div class="btn d-flex justify-content-center"><h1 class="text-warning">ADMIN LOGIN</h1></div>
            <div class=""><input class="form-control btn justify-content-center"  style="background-color: #ffff;border-radius:50px" type="email" name="email" id="email" placeholder="Email" required></div>
            <div class="form-group"><input class="form-control btn" type="password"  style="background-color: #ffff;border-radius:50px" name="password" id="password" placeholder="Password" required></div>
            <div class="form-group"><button class="btn btn-primary btn-block text-dark" type="submit" name="login_admin" style="border-radius:50px;border-color:rgb(254,198,1);background-color: rgb(254,198,1);">Log In</button></div>
            <?php include('registration_errors.php'); ?>
        </form>
        </div>
    </div>
</body>
</html>