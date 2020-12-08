<?php
// database information
$host = "localhost";
$username = "root";
$password = "";
$database_name = "jupiter";

// database connection
//try 
try {
    $database = mysqli_connect($host, $username, $password, $database_name);
}
// catch
catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}
?>

