<?php
include('dbcontroller.php');
$errors = array();
if (!isset($_SESSION)) {
    session_start();
} else {
    $x = $_SESSION['name'];
    session_destroy();
    session_start();
    $_SESSION['name'] = $x;
}
if (isset($_SESSION['name'])) {
    if ($_SESSION['name'] != '') {
        echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
    }
}

/**
  * Login authentication via email and password
  * Add email and password
  * 
  * @author Siraj Mhanna
  *
  * @param string $email
  * @param string $password
  * @return Response.
  */
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM employee WHERE employee_email = '$email' AND employee_password = '$password' AND status = 1";
        $result = mysqli_query($database, $query);
        $counter = 0;
        if (mysqli_num_rows($result) == 1) {
            $_SESSION['name'] = $email;
            while ($row = mysqli_fetch_array($result)) {
                $_SESSION['employee_id_saver'] = $row['employee_id'];
                $_SESSION['employee_password'] = $row['employee_password'];
                $_SESSION['parent_id'] = $row['parent_id'];
                $_SESSION['first_name'] = $row['first_name'];
                $_SESSION['email'] = $row['employee_email'];
                $_SESSION['last_name'] = $row['last_name'];
                $_SESSION['phone'] = $row['employee_phone'];
                $_SESSION['address'] = $row['employee_address'];
            }
            echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
        } else {
            $queryemail = "SELECT status FROM employee WHERE employee_email = '$email'";
            $resulteamil = mysqli_query($database, $queryemail);
            while($row = mysqli_fetch_array($resulteamil)){
                $counter = $row['status'];
            }
            if($counter == 2){
                array_push($errors, "Your account has been disabled");
            }
            else if(mysqli_num_rows($resulteamil) == 0){
                array_push($errors, "No account with that email exists");
            }
            else if($counter == 3){
                array_push($errors, "Account isn't activated yet");
            }
            else{
                array_push($errors, "Incorrect email and password combination"); 
            }
           
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Log In</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>


<body class="bg-warning">
    <br>
    <div class="container">
        <div class="row d-flex justify-content-center">
                <form method="POST" action="login.php" class="col-sm-5" style="background-color: rgb(163, 153, 119);border-radius:30px;">
                    <br>
                    <div class="btn d-flex justify-content-center"><a href="index.php"><img src="assets/img/jupiterlogo.png" class="col-sm-12"></a></div>
                    <br>
                    <br>
                    <div class=""><input class="form-control btn justify-content-center" style="background-color: #ffff;border-radius:50px" type="email" name="email" id="email" placeholder="Email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : ''; ?>"></div>
                    <div class="form-group"><input class="form-control btn" type="password" style="background-color: #ffff;border-radius:50px" name="password" id="password" placeholder="Password" required></div>
                    <div class="form-group"><button class="btn btn-primary btn-block text-dark" type="submit" name="login" style="border-radius:50px;border-color:rgb(254,198,1);background-color: rgb(254,198,1);">Log In</button></div>
                    <br>
                    <div class="row justify-content-center"><a class=" text-dark" href="forgot_password.php">Forgot your password?</a></div>
                    <br>
                    <?php include('registration_errors.php'); ?>
                </form>
        </div>
    </div>

    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>