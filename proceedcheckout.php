<?php
session_start();
include('configure.php');
include('cart.php');
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <title>Check Out</title>
    <!-- JavaScript alert -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
</head>
<?php include('navbar.php'); ?>

<body>
    <br>
    <div class="container">
        <form action="proceedcheckout.php" method="POST">
            <div class="card">
                <div class="card-header bg-warning">
                    <div class="row d-flex justify-content-center">
                        <h3 class="text-dark">Purchase Confirmation</h3>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table">
                        <tr>
                            <td>Total</td>
                            <th style="text-align:right"><?php echo "$" . $_SESSION['total_prices']; ?></th>
                        </tr>
                        <tr>
                            <td>Shipping Address <br>
                                <span style="font-size:80%">
                                    <div class="ad"><a href="seller_settings.php" class="text-dark">(Change address)</a></div>
                                </span>
                            </td>
                            <th style="text-align:right"><?php // get seller address
                            /**
                             * Get seller address
                             * @param string $address
                             * 
                             * @return Response html string $address
                             */
                                                            $address = "";
                                                            $query = "SELECT * from employee WHERE employee_id = '$_SESSION[employee_id_saver]'";
                                                            $result = mysqli_query($database, $query);
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                $address = $row['employee_address'];
                                                            }
                                                            ?>
                                <p><?php echo str_replace('//', '<br>', $address) . '<br>'; ?></p>
                            </th>
                        </tr>
                        <tr>
                            <td>Financial Returns</td>
                            <th style="text-align:right"><?php echo "$" . round((($_SESSION['total_prices']) * 0.08), 2); ?></th>
                        </tr>
                    </table>
                    <br>
                    <div class="row d-flex justify-content-center">
                        <input type="submit" onClick="javascript:return confirm('Are you sure you want to checkout?');" name="checkout" value="Confirm order" class="btn bg-warning" style="border-radius: 30px">
                    </div>
                    <br>
                    <div class="row d-flex justify-content-center">
                        <input type="submit" name="backtocart" value="Back to shopping cart" class="btn bg-warning" style="border-radius: 30px">
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<br><br>
<?php include('footer.php'); ?>

</html>
<!-- checkout item to database -->
<?php
/**
 * Confirm order
 * 
 * check quantity in the database
 * update quantity in the database
 * set shopping cart to null
 * add commission to the seller/father seller
 * 
 * @return status(201) order confirmation
 * 
 */
if ($item["quantity"] < 1) {
    echo "<script type='text/javascript'> document.location = 'shoppingcart.php'; </script>";
}
$commission_amount = 0;
$commison_amount_parent = 0;
if (isset($_POST['checkout'])) {
    $query = "SELECT * from employee WHERE employee_id = '$_SESSION[employee_id_saver]'";
    $result = mysqli_query($database, $query);
    while ($row = mysqli_fetch_array($result)) {
        if (empty($row['employee_address'])) {
            echo "<script>alert('Please add your address to checkout');</script>";
        } else {
            $order_id = uniqid();
            foreach ($_SESSION["username"] as $item) {
                $id_product = $item["id"];
                $quantity = $item["quantity"];
                $id_employee = $_SESSION['employee_id_saver'];
                $query = "SELECT product_quantity,product_name,product_price,product_sale FROM product WHERE product_id='$id_product'";
                $result = mysqli_query($database, $query);
                while ($row = mysqli_fetch_array($result)) {
                    $quantity_saver = $row['product_quantity'];
                    if ($row['product_quantity'] < $quantity) {
                        echo "<script type='text/javascript'>alert('The avalibe quantity for $row[product_name] is $row[product_quantity] only try to edit product quantity  ');</script>";
                        break;
                    } else {
                        $price = round(($row['product_price'] * (1 - ($row['product_sale'] / 100))), 2); // price after discount
                        $query = "INSERT INTO sales VALUES ('$order_id','$id_employee','$id_product','$price','$quantity',SYSDATE(),0)";
                        mysqli_query($database, $query);
                        $commission_amount += ($quantity * $price * 0.08);
                        $commison_amount_parent += ($quantity *  $price * 0.02);
                    }
                    $final_quantity_update = $quantity_saver - $quantity; // update database quantity for each item
                    $query1 = "UPDATE product SET product_quantity = '$final_quantity_update' WHERE product_id='$id_product'";
                    mysqli_query($database, $query1);
                }
            }
            $commission_amount = round($commission_amount, 2);
            $commison_amount_parent = round($commison_amount_parent, 2);
            $queryc = "INSERT INTO commission VALUES (0,$_SESSION[employee_id_saver],$commission_amount,SYSDATE(),0)";
            mysqli_query($database, $queryc);
            $query_parent = "SELECT status FROM employee WHERE employee_id = '$_SESSION[parent_id]' and status = 1";
            $result_parent = mysqli_query($database, $query_parent);
            while ($row_result = mysqli_fetch_array($result_parent)) {
                $queryz = "INSERT INTO commission VALUES (0,$_SESSION[parent_id],$commison_amount_parent,SYSDATE(),1)";
                mysqli_query($database, $queryz);
                break;
            }
            echo "<script>
            alertify.alert('Order Status','Your order is confirmed', function(){
            alertify.message('Successfuly');
            document.location = 'shoppingcart.php?action=empty';
            
          });
        </script>";
        }
    }
}

?>
<?php
if (isset($_POST['backtocart'])) {
    echo "<script type='text/javascript'> document.location = 'shoppingcart.php'; </script>";
}
?>