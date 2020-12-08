<?php
/**
  * Logout destroy sessions
  * 
  * @author Siraj Mhanna
  *
  * @return Response.
  */
 if(!isset($_SESSION)) 
 { 
     session_start(); 
 }
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<script type='text/javascript'>


</script>
<body>
    <form action="logout.php" method="POST">
    <button class="btn" onClick="javascript:return confirm('Are you sure you want to logout?');" name="logout" style="background-color: rgb(254,198,1);border-radius:50px;width:120px"><i class="fas fa-sign-out-alt fa-2x" ></i></button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</body>
</html>