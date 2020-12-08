<?php
/**
  * Session start and authentication request
  * 
  * @author Siraj Mhanna
  *
  * @param SESSION name
  * @return Response.
  */
session_start();
echo "<script type='text/javascript'> document.location = 'login.php'; </script>";
if (isset($_SESSION['name'])) {
    if ($_SESSION['name'] != '') {
        echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
    }
}
?>