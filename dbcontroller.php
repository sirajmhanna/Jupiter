<?php
class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "jupiter";
	private $conn;
	
	
	function __construct() {
		$this->conn = $this->connectDB();
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
	function runQuery($query) {
		$result = mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysqli_query($this->conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
}

// database information
$hostx = "localhost";
$usernamex = "root";
$passwordx = "";
$database_name = "jupiter";
// database connection
try {
    $database = mysqli_connect($hostx, $usernamex, $passwordx, $database_name);
}
// catch
catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}
?>