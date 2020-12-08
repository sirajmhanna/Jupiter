<?php
session_start();
include('configure.php');
include('cart.php');
if (!isset($_SESSION['name'])) {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
if (isset($_POST['continueshopping'])) {
    echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
}
$quantity_saver = 0;
?>

<!DOCTYPE html>
<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <title>Shopping Cart</title>
    <script type="text/javascript">
        // ES6 Modules or TypeScript
        import Swal from 'sweetalert2'

        // CommonJS
        const Swal = require('sweetalert2')
    </script>
</head>
<!-- navbar -->
<?php include('navbar.php'); ?>

<body>

    <!-- shopping table -->
    <div id="shopping-cart">
        <div class="txt-heading d-flex justify-content-center">
            <h4>Shopping Cart</h4>
        </div>
        <a id="btnEmpty" onClick="javascript:return confirm('Click ok if you want to clear shopping cart');" href="shoppingcart.php?action=empty" <?php if (empty($item)) {
                                                                                        echo "class='btn disabled'";
                                                                                    } ?>>Empty Cart</a>
        <form action="shoppingcart.php" method="POST" style="margin-top: 10px">
            <input type="submit" name="continueshopping" value="Continue Shopping" class="btn btn-md row" style="background-color: rgb(254,198,1);margin-left:1px">
        </form>
        <?php
        if (isset($_SESSION["username"])) {
            $total_quantity = 0;
            $total_price = 0;
        ?>
            <div class="table-responsive">
                <table class="table">
                    <th style="text-align:left;">Item</th>
                    <th></th>
                    <th style="text-align:right;" width="5%">Quantity</th>
                    <th style="text-align:right;" width="10%">Unit Price</th>
                    <th style="text-align:right;" width="10%">Price</th>
                    <th style="text-align:center;" width="5%">Remove</th>
                    </tr>
                    <?php
                    /**
                     * print array item containg items
                     * 
                     * @param array $item
                     * 
                     * @return response html total price 
                     */
                    foreach ($_SESSION["username"] as $item) {
                        $item_price = $item["quantity"] * $item["price"];
                    ?>
                        <tr>
                            <td scope="col"><img src="assets/img/<?php echo $item["image"]; ?>" style="height:50px;width:50px" class="cart-item-image" /><?php echo $item["name"]; ?></td>
                            <td></td>
                            <td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
                            <td style="text-align:right;"><?php echo "$ " . $item["price"]; ?></td>
                            <td style="text-align:right;"><?php echo "$ " . number_format($item_price, 2); ?></td>
                            <td style="text-align:center;"><a href="shoppingcart.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="assets/img/icon-delete.png" alt="Remove Item" /></a></td>
                        </tr>
                    <?php
                        $total_quantity += $item["quantity"];
                        $total_price += ($item["price"] * $item["quantity"]);
                        $quantity_saver += $item["quantity"];
                        echo "<script type='text/javascript'> var total =  $total_quantity; </script>";
                    }
                    ?>

                    <tr>
                        <td colspan="2" align="right">Total:</td>
                        <td align="right"><?php echo $total_quantity; ?></td>
                        <td align="right" colspan="2"><strong style="background-color: pink"><?php echo "$ " . number_format($total_price, 2); ?><?php $_SESSION['total_prices'] = $total_price; ?></strong></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        <?php
        } else {
        ?>
            <div class="no-records">
                <h4>Your Cart is Empty</h4>
            </div>
        <?php
        }
        ?>
        <div class="container">
            <form action="shoppingcart.php" method="POST" class="row d-flex justify-content-center">
                <input type="submit" value="Proceed Checkout" name="checkout" class="btn col-sm-6 btn-block" style="background-color: rgb(254,198,1)" <?php if ($quantity_saver < 1) {
                                                                                                                                                            echo "disabled";
                                                                                                                                                        } ?>>
            </form>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

<?php include('footer.php'); ?>

</html>
<?php
/**
 * checkout 
 * 
 * @return Response proceed to checkout
 */
if (isset($_POST['checkout'])) {
    if ($quantity = $item["quantity"]) {
        echo "<script type='text/javascript'> document.location = 'proceedcheckout.php'; </script>";
    }
}
?>