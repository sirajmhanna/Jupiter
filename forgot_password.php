<?php
include('dbcontroller.php');
include('phpmailer.php');
$errors = array();
/**
 * generate random passwords 
 *
 * @return string $pass 
 */
function randomPassword()
{
    $alphabet = 'abcdefghijklmnopq*&^%$#@?>rstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890/*-+-*&^%$#@?><":}{';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 10; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}
?>
<?php
/**
 * Rest account password 
 * Rest account password if email exists in the database / send the new password via email
 * 
 * @param string $email
 * @return Response 
 */
if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $first = "";
    $last = "";
    //check if email exists
    $query = "SELECT employee_email,first_name,last_name FROM employee WHERE employee_email = '$email'";
    $result = mysqli_query($database, $query);
    if (mysqli_num_rows($result) < 1) {
        array_push($errors, "No account with that email exists");
    } else if (mysqli_num_rows($result) == 1) {
        while ($row = mysqli_fetch_array($result)) {
            $first = $row['first_name'];
            $last = $row['last_name'];
            break;
        }
        $new_password = randomPassword();
        $new_password_md5 = md5($new_password);
        $q = "UPDATE employee SET employee_password = '$new_password_md5' WHERE employee_email = '$email'";
        mysqli_query($database,$q);
        phpMailer("JUPITER", "$email", "Password Reset", "Dear $first $last,\n\nYour password has been successfully reset.\n\nYour new password is: $new_password\n\nOnce your password has been reset we strongly recommend that you change it.\nBest regards.");
        echo "<script type='text/javascript'>alert('Your password has been successfully reset and sent by email')</script>";
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

</head>

<body class="bg-warning">
    <div class="container">
        <br><br>
        <div class="row d-flex justify-content-center">
            <form action="forgot_password.php" method="POST" class="col-sm-5" style="background-color: rgb(163, 153, 119);border-radius:30px;">
                <br>
                <h3><i class="fa fa-lock fa-4x d-flex justify-content-center"></i></h3>
                <br>
                <h2 class="text-center">Forgot Password?</h2>
                <p class="text-center">You can reset your password here.</p>
                <br>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                        <input id="email" name="email" placeholder="email address" class="form-control text-center" style="border-radius: 30px" type="email">
                    </div>
                </div>
                <div class="form-group d-flex justify-content-center">
                    <input type="submit" value="Reset Password" name="reset" class="btn btn-warning col-sm-9" style="border-radius: 30px">
                </div>
                <?php include('registration_errors.php'); ?>
            </form>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>