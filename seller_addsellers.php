<?php
session_start();
include('configure.php');
require_once("dbcontroller.php");
include('phpmailer.php');
if (!isset($_SESSION['name'])) {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
$errors = array(); //errors array 
// function to generate random password
/**
 * Generate random passwords
 * 
 * @param string $alphabet
 * @param array $pass
 * 
 * @return $pass
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
    return implode($pass); //turn the array into a string
}
?>
<?php
// check if seller greater than 4
$query = "SELECT parent_id FROM employee WHERE parent_id = '$_SESSION[employee_id_saver]' AND employee_id != '$_SESSION[employee_id_saver]' ";
$result = mysqli_query($database, $query);
if (mysqli_num_rows($result) >= 4) {
    echo "<script type='text/javascript'> document.location = 'seller_sellers.php'; </script>";
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
    <!-- JavaScript alert -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
    <title>Sellers</title>
    <style>
        a:hover {
            background-color: rgb(254, 198, 1);
        }
    </style>
</head>
<?php include('navbar.php'); ?>

<body>
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
                <div class="row d-flex justify-content-center">
                    <div class="col-sm-4">
                        <div class="card" style="border-radius:30px;border-color:rgb(163, 153, 119);border-width: thick;">
                            <br>
                            <h4 class="d-flex justify-content-center text-dark">Adding Sellers </h4>
                            <div class="card-body text-dark">
                                <p>* Enter seller first name</p>
                                <p>* Enter seller last name</p>
                                <p>* Enter seller email</p>
                                <p>* Enter seller phone number</p>
                                <p>* Click on ADD SELLER</p>
                                <p>An email will be sent to the seller containing all the details needed after the acceptance from the company.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <p>

                        </p>
                    </div>
                    <div class="col-sm-7">
                        <form action="seller_addsellers.php" method="POST" class="col-sm-11" style="border-width: thick;border-radius: 30px;background-color: rgb(163, 153, 119)">
                            <br>
                            <div class="form-group d-flex justify-content-center"><img src="assets/img/jupiterlogo.png" alt="logo" height="100"></div>
                            <br>
                            <div class="form-group"><input class="form-control btn" type="text" style="background-color: #ffff;border-radius:50px" placeholder="First Name" name="firstname" required value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname'], ENT_QUOTES) : ''; ?>"></div>
                            <div class="form-group"><input class="form-control btn" type="text" style="background-color: #ffff;border-radius:50px" placeholder="Last Name" name="lastname" required value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname'], ENT_QUOTES) : ''; ?>"></div>
                            <div class="form-group"><input class="form-control btn" type="email" style="background-color: #ffff;border-radius:50px" placeholder="Email" name="email" required></div>
                            <div class="form-group"><input class="form-control btn" type="number" style="background-color: #ffff;border-radius:50px" placeholder="Phoner Number" name="phone" required value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone'], ENT_QUOTES) : ''; ?>"></div>
                            <br>
                            <div class="form-group"><input class="form-control btn btn-warning" type="submit" value="ADD SELLER" style="border-radius:50px" name="addseller"></div>
                            <br>
                        </form>
                    </div>
                </div>
                <br>
                <?php
                /**
                 * Adding child sellers
                 * 
                 * @param string $first_name
                 * @param string $last_name
                 * @param string email
                 * @param string $phone
                 * @param string $password
                 * 
                 * @return status(201) seller added
                 */
                if (isset($_POST['addseller'])) {
                    $first_name = $_POST['firstname'];
                    $last_name = $_POST['lastname'];
                    $email = $_POST['email'];
                    $phone = $_POST['phone'];
                    $parent_id = $_SESSION['employee_id_saver'];
                    $password = randomPassword();
                    $address = "";
                    $q = "SELECT employee_email FROM employee WHERE employee_email = '$email'";
                    $r = mysqli_query($database, $q);
                    if (mysqli_num_rows($r) > 0) {
                        echo "<script type='text/javascript'>alert('An account with this email already exists');</script>";
                    } else {
                        $password = md5($password);
                        $query = "INSERT INTO employee VALUES(0,'$first_name','$last_name','$email','$password','$phone','$address','$parent_id',3)";
                        mysqli_query($database, $query);
                        phpMailer("JUPITER", "$_SESSION[email]", "Adding Seller", "Dear $_SESSION[first_name] $_SESSION[last_name],\n\nYou have requested to add a new seller that goes by the name of $first_name $last_name. \n\nWe will be looking into your file as soon as possible and we will be in touch soon.\n\n Best regards.");
                        echo "<script>
                        alertify.alert('Adding Seller','A new seller has been added check your email for more information.', function(){
                        alertify.message('Successfuly');
                        document.location = 'seller_sellers.php';});
                        </script>";
                    }
                }
                ?>
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
<?php include('footer.php'); ?>

</html>