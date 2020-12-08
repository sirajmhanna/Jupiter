<?php
/**
 * adding,remove,update and delete items from shopping cart
 * 
 * case add, remove, update and delete 
 * 
 * @param $db_handle
 * 
 * @return Response status(200) 
 */
if (!isset($_SESSION['name'])) {
	echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
require_once("dbcontroller.php");
$db_handle = new DBController();
if (!empty($_GET["action"])) {
	switch ($_GET["action"]) {
		case "add":
			if (isset($_POST['addtocart'])) {
				if (!empty($_POST["quantity"]) && $_POST["quantity"] > 0) {
					$productByCode = $db_handle->runQuery("SELECT * FROM product WHERE product_code='" . $_GET["code"] . "'");
					$itemArray = array($productByCode[0]["product_code"] => array('name' => $productByCode[0]["product_name"], 'id' => $productByCode[0]["product_id"], 'quantity' => $_POST["quantity"], 'price' => round($productByCode[0]["product_price"] * (1 - (($productByCode[0]["product_sale"]) / 100)), 2), 'image' => $productByCode[0]["product_image"],'code' => $productByCode[0]["product_code"]),);
					// check product quantity from database
					$query = "SELECT product_quantity,product_name FROM product WHERE product_code='" . $_GET["code"] . "'";
					$result = mysqli_query($database, $query);
					while ($row = mysqli_fetch_array($result)) {
						if ($row['product_quantity'] < $_POST["quantity"]) {
							echo "<script type='text/javascript'>alert('The avalibe quantity for $row[product_name] is $row[product_quantity] only.');</script>";
							break;
						} else {
							if (!empty($_SESSION["username"])) {
								if (in_array($productByCode[0]["product_code"], array_keys($_SESSION["username"]))) {
									foreach ($_SESSION["username"] as $k => $v) {
										if ($productByCode[0]["product_code"] == $k) {
											if (empty($_SESSION["username"][$k]["quantity"])) {
												$_SESSION["username"][$k]["quantity"] = 0;
											}
											$x = $_SESSION["username"][$k]["quantity"];
											$x += $_POST["quantity"];
											if ($row['product_quantity'] >= $x) {
												$_SESSION["username"][$k]["quantity"] += $_POST["quantity"];
											} else {
												echo "<script type='text/javascript'>alert('The avalibe quantity for $row[product_name] is $row[product_quantity] only try to edit product quantity  ');</script>";
												break;
											}
										}
									}
								} else {
									$_SESSION["username"] = array_merge($_SESSION["username"], $itemArray);
								}
							} else {
								$_SESSION["username"] = $itemArray;
							}
						}
					}
				}
			}
			break;

		case "remove":
			if (!empty($_SESSION["username"])) {
				foreach ($_SESSION["username"] as $k => $v) {
					if ($_GET["code"] == $k)
						unset($_SESSION["username"][$k]);
					if (empty($_SESSION["username"]))
						unset($_SESSION["username"]);
				}
			}
			break;
		case "update":
			if (!empty($_SESSION["username"])) {
			}
		case "empty":
			unset($_SESSION["username"]);
			echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
			break;
	}
}
