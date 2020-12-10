<?php
session_start();

require_once("dbcontroller.php");
if (!isset($_SESSION['admin_email'])) {
    echo "<script type='text/javascript'> document.location = 'admin-login.php'; </script>";
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
    <title>Admin Products</title>
    <SCRIPT LANGUAGE="JavaScript">
        //script to save scroll position
        var db = (document.body) ? 1 : 0;
        var scroll = (window.scrollTo) ? 1 : 0;

        function setCookie(name, value, expires, path, domain, secure) {
            var curCookie = name + "=" + escape(value) +
                ((expires) ? "; expires=" + expires.toGMTString() : "") +
                ((path) ? "; path=" + path : "") +
                ((domain) ? "; domain=" + domain : "") +
                ((secure) ? "; secure" : "");
            document.cookie = curCookie;
        }

        function getCookie(name) {
            var dc = document.cookie;
            var prefix = name + "=";
            var begin = dc.indexOf("; " + prefix);
            if (begin == -1) {
                begin = dc.indexOf(prefix);
                if (begin != 0) return null;
            } else {
                begin += 2;
            }
            var end = document.cookie.indexOf(";", begin);
            if (end == -1) end = dc.length;
            return unescape(dc.substring(begin + prefix.length, end));
        }

        function saveScroll() {
            if (!scroll) return;
            var now = new Date();
            now.setTime(now.getTime() + 365 * 24 * 60 * 60 * 1000);
            var x = (db) ? document.body.scrollLeft : pageXOffset;
            var y = (db) ? document.body.scrollTop : pageYOffset;
            setCookie("xy", x + "_" + y, now);
        }

        function loadScroll() {
            if (!scroll) return;
            var xy = getCookie("xy");
            if (!xy) return;
            var ar = xy.split("_");
            if (ar.length == 2) scrollTo(parseInt(ar[0]), parseInt(ar[1]));
        }
    </SCRIPT>
</head>

<body onLoad="loadScroll()" onUnload="saveScroll()">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <div class="d-flex" id="wrapper">
        <?php include('admin-navbar.php'); ?>
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" id="menu-toggle" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>

            <div class="container">
                <br>
                <!-- add product -->
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="d-flex justify-content-center">Add products</h6>
                        </div>
                        <div class="card-body d-flex justify-content-center bg-warning">
                            <form action="admin-products.php" method="POST" class="col-sm-5" enctype="multipart/form-data">
                                <div class="form-group"><input class="form-control btn" type="text" style="background-color: #ffff;border-radius:50px" name="product_name" placeholder="Product name" required></div>
                                <div class="form-group"><input class="form-control btn" type="text" style="background-color: #ffff;border-radius:50px" name="product_des" placeholder="Product description" required></div>
                                <span class="d-flex justify-content-center">&nbsp;&nbsp; add ||| to break into a new line</span>
                                <div class="form-group"><textarea class="form-control btn" type="text" style="background-color: #ffff;border-radius:30px" name="product_spc" placeholder="Product specification" required></textarea></div>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <img src="" alt="">
                                        <input type="file" class="custom-file-input" name="file" style="border-radius: 30px">
                                        <label class="custom-file-label" for="inputGroupFile01" style="border-radius: 5px">Choose product image</label>
                                    </div>
                                </div>
                                <div class="form-group"><input class="form-control btn" type="number" step="any" style="background-color: #ffff;border-radius:50px" name="product_price" placeholder="Product price" required></div>
                                <div class="form-group"><input class="form-control btn" type="number" style="background-color: #ffff;border-radius:50px" name="product_quantity" placeholder="Product quantity" required></div>
                                <div class="form-group"><input class="form-control btn" type="text" style="background-color: #ffff;border-radius:50px" name="product_brand" placeholder="Product brand" required></div>
                                <div class="form-group"><input class="form-control btn" type="text" style="background-color: #ffff;border-radius:50px" name="product_type" placeholder="Product type (laptop,phone..)" required></div>
                        </div>
                        <div class="card-footer">
                            <input type="submit" value="ADD PRODUCT" name="btn-upload" class="btn btn-block btn-warning" style="border-radius: 30px">

                            </form>
                        </div>
                    </div>
                    <hr>
                    <!-- edit products quantity -->
                    <div class="container-fuiled">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="d-flex justify-content-center">Edit products quantity</h6>
                            </div>
                            <div class="card-body d-flex justify-content-center bg-warning ">
                                <form action="admin-products.php" method="post" class="col-sm-5">

                                    <div class="text-white row d-flex justify-content-center">
                                        <p>select product you want to edit:</p>
                                    </div>
                                    <div class="form-group row">
                                        <select name="selected_productedit" require size="0" class="btn btn-block bg-white col-sm-12" style="border-radius: 30px">
                                            <option value="">View product list</option>
                                            <?php
                                            $selected_name = $_POST['search_nameupdate'];
                                            if (isset($_POST['search_btnq'])) {
                                                $query = ("SELECT product_name FROM product WHERE product_name like '%" . $selected_name . "%' ");
                                            } else {
                                                $query = ("SELECT product_name,product_quantity FROM product");
                                            }
                                            $result = mysqli_query($database, $query);
                                            if (mysqli_num_rows($result)) {
                                                while ($row = mysqli_fetch_row($result)) {
                                                    print("<option value=\"$row[0]\">$row[0]  || QUANTITY =  $row[1]</option>");
                                                }
                                            } else {
                                                print("<option value=\"\">No results for $selected_name</option>");
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <input type="number" name="quantity_saver" class="form-control btn bg-white" placeholder="Enter Quantity" style="border-radius: 30px" required>


                            </div>
                            <div class="card-footer">
                                <input type="submit" value="EDIT QUANTITY" name="edit_product" class="btn btn-block btn-warning" style="border-radius: 30px">
                                <?php
                                if (isset($_POST['edit_product'])) {
                                    $selected_productedit = $_POST['selected_productedit'];
                                    if ($selected_productedit == '') {
                                        echo "<script type='text/javascript'>alert('No product selected to edit quantity');</script>";
                                    } else {
                                        $product_q = $_POST['quantity_saver'];
                                        if ($product_q < 0) {
                                            echo "<script type='text/javascript'>alert('quantity must be greater than or equal to 0');</script>";
                                        } else {
                                            $query = "UPDATE product SET product_quantity = '$product_q' WHERE product_name = '$selected_productedit'";
                                            mysqli_query($database, $query);
                                            echo "<script type='text/javascript'>alert('$selected_productedit quantity is updated');</script>";
                                            echo "<script type='text/javascript'> document.location = 'admin-products.php'; </script>";
                                        }
                                    }
                                } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- remove product card -->
                    <div class="contaner-fuiled">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="d-flex justify-content-center">Remove products</h6>
                            </div>
                            <div class="card-body d-flex justify-content-center bg-warning">
                                <form action="admin-products.php" method="post" class="col-sm-5">
                                    <div class="text-white row d-flex justify-content-center">
                                        <p>select product you want to remove:</p>
                                    </div>
                                    <div class="form-group row">
                                        <select name="selected_product" require size="0" class="btn btn-block bg-white" style="border-radius: 30px">
                                            <option value="">View product list</option>
                                            <?php

                                            $query = ("SELECT product_name,product_quantity FROM product");

                                            $result = mysqli_query($database, $query);
                                            if (mysqli_num_rows($result)) {
                                                while ($row = mysqli_fetch_row($result)) {
                                                    print("<option value=\"$row[0]\">$row[0]</option>");
                                                }
                                            } else {
                                                print("<option value=\"\">No results for $selected_name</option>");
                                            }
                                            ?>
                                        </select>
                                    </div>
                            </div>
                            <div class="card-footer">
                                <input type="submit" value="REMOVE PRODUCT" name="delete_product" class="btn btn-block btn-warning" style="border-radius: 30px">
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- discount -->
                    <div class="container-fuiled">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="d-flex justify-content-center">Products discount</h6>
                            </div>
                            <div class="card-body d-flex justify-content-center bg-warning">
                                <form action="admin-products.php" method="post" class="col-sm-5">
                                    <div class="text-white row d-flex justify-content-center">
                                        <p>select product to add discount:</p>
                                    </div>
                                    <div class="form-group row">
                                        <select name="selected_productsale" require size="0" class="btn btn-block bg-white col-sm-12" style="border-radius: 30px">
                                            <option value="">View product list</option>
                                            <?php
                                            $selected_namesale = $_POST['search_namesale'];
                                            if (isset($_POST['search_btnsale'])) {
                                                $query = ("SELECT product_name FROM product WHERE product_name like '%" . $selected_namesale . "%' ");
                                            } else {
                                                $query = ("SELECT product_name FROM product");
                                            }
                                            $result = mysqli_query($database, $query);
                                            if (mysqli_num_rows($result)) {
                                                while ($row = mysqli_fetch_row($result)) {
                                                    print("<option value=\"$row[0]\">$row[0]</option>");
                                                }
                                            } else {
                                                print("<option value=\"\">No results for $selected_namesale</option>");
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <input type="number" name="sale_saver" class="form-control btn bg-white" placeholder="Enter discount between 0 & 99" style="border-radius: 30px" required>
                            </div>
                            <div class="card-footer">
                                <input type="submit" value="ADD DISCOUNT" name="discount_product" class="btn btn-block btn-warning" style="border-radius: 30px">
                                <?php
                                if (isset($_POST['discount_product'])) {
                                    $sale_saver = $_POST['sale_saver'];
                                    if ($sale_saver >= 0 && $sale_saver <= 99) {
                                        $selected_productsale = $_POST['selected_productsale'];
                                        $query = "UPDATE product SET product_sale = '$sale_saver' WHERE product_name = '$selected_productsale'";
                                        mysqli_query($database, $query);
                                        $msg = "$sale_saver% discount for $selected_productsale added";
                                        echo "<script type='text/javascript'>alert('$msg');</script>";
                                    } else {
                                        echo "<script type='text/javascript'>alert('discount must be between 0 & 99');</script>";
                                    }
                                }
                                ?>
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="container-fuiled">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="d-flex justify-content-center">EDIT PRODUCTS</h6>
                            </div>
                            <div class="card-body d-flex justify-content-center bg-warning">
                                <form action="admin-products.php" method="POST" class="col-sm-5" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <select name="sep" onchange="this.form.submit()" require size="0" class="btn btn-block bg-white col-sm-12" style="border-radius: 30px">
                                            <option value="<?php echo isset($_POST['sep']) ? htmlspecialchars($_POST['sep'], ENT_QUOTES) : ''; ?>"><?php if (isset($_POST['sep'])) {
                                                                                                                                                        echo $_POST['sep'];
                                                                                                                                                    } else {
                                                                                                                                                        echo "View product list";
                                                                                                                                                    } ?></option>
                                            <?php
                                            $query = ("SELECT product_name FROM product");
                                            $result = mysqli_query($database, $query);
                                            if (mysqli_num_rows($result)) {
                                                while ($row = mysqli_fetch_row($result)) {
                                                    print("<option value=\"$row[0]\">$row[0]</option>");
                                                }
                                            } else {
                                                print("<option value=\"\">No Products yet</option>");
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body d-flex justify-content-center bg-warning">
                                <?php
                                if (isset($_POST['sep'])) {
                                    $name = $_POST['sep'];
                                    $q = ("SELECT * FROM product WHERE product_name like '%" . $name . "%' ");
                                    $r = mysqli_query($database, $q);
                                    while ($erow = mysqli_fetch_array($r)) {
                                ?>
                                        <form action="admin-products.php" method="POST" class="col-sm-5" enctype="multipart/form-data">
                                            <div class="row">
                                                <input type="hidden" name="react" value="<?php echo $erow['product_code'] ?>">
                                                <input type="hidden" name="imagereact" value="<?php echo $erow['product_image'] ?>">
                                                <span>&nbsp;&nbsp;Product name*</span>
                                                <input class="btn btn-block form-control" type="text" style="background-color: #ffff;border-radius:50px" name="eproduct_name" placeholder="Product name" value="<?php echo $erow['product_name']; ?>" required>
                                                <span>&nbsp;&nbsp;Product description*</span>
                                                <input class="btn btn-block form-control" type="text" style="background-color: #ffff;border-radius:50px" name="eproduct_des" placeholder="Product name" value="<?php echo $erow['product_description']; ?>" required>
                                                <span>&nbsp;&nbsp;Product specification*</span>
                                                <textarea class="form-control btn" type="text" style="background-color: #ffff;border-radius:30px" name="eproduct_spc" placeholder="Product specification" required><?php echo $erow['product_specification']; ?></textarea>
                                                <span>&nbsp;&nbsp;Product image* </span>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <img src="" alt="">
                                                        <input type="file" class="custom-file-input" name="file" style="border-radius: 30px" value="<?php echo $erow['product_image']; ?>">
                                                        <label class="custom-file-label" for="inputGroupFile01" style="border-radius: 5px">Choose product image</label>
                                                    </div>
                                                </div>
                                                <span>&nbsp;&nbsp;(Current image)</span>
                                                <img src='assets/img/<?php echo $erow['product_image']; ?>' class="card-img-top d-flex justify-content-center" style="height:250px;width:100%;border-radius:15px;border: 10px solid transparent">
                                                <span>&nbsp;&nbsp;Product price*</span>
                                                <input class="form-control btn" type="number" step="any" style="background-color: #ffff;border-radius:50px" name="eproduct_price" placeholder="Product price" value="<?php echo $erow['product_price']; ?>" required>
                                                <span>&nbsp;&nbsp;Product quantity*</span>
                                                <input class="form-control btn" type="number" style="background-color: #ffff;border-radius:50px" name="eproduct_quantity" placeholder="Product quantity" value="<?php echo $erow['product_quantity']; ?>" required>
                                                <span>&nbsp;&nbsp;Product brand*</span>
                                                <input class="form-control btn" type="text" style="background-color: #ffff;border-radius:50px" name="eproduct_brand" placeholder="Product brand" value="<?php echo $erow['product_brand']; ?>" required>
                                                <span>&nbsp;&nbsp;Product type*</span>
                                                <input class="form-control btn" type="text" style="background-color: #ffff;border-radius:50px" name="eproduct_type" placeholder="Product type (laptop,phone..)" value="<?php echo $erow['product_type']; ?>" required>


                                            </div>
                                    <?php
                                    }
                                }
                                    ?>
                            </div>
                            <div class="card-footer">

                                <input type="submit" value="EDIT PRODUCT" name="eedit_product" class="btn btn-block btn-warning" style="border-radius: 30px">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>

</html>

<?php
//edit products
/**
 * Edit products 
 * 
 * @param string $product_code
 * @param string $product_name
 * @param string $product_description
 * @param string $product_specification
 * @param float $product_price
 * @param int $product_quantity
 * @param string $product_brand
 * @param string $product_type
 * 
 * @return status(200) updated 
 */
if (isset($_POST['eedit_product'])) {
    $product_code = $_POST['react'];
    $product_name = $_POST['eproduct_name'];
    $product_description = $_POST['eproduct_des'];
    $product_specification = $_POST['eproduct_spc'];
    $product_price = $_POST['eproduct_price'];
    $product_quantity = $_POST['eproduct_quantity'];
    $product_brand = $_POST['eproduct_brand'];
    $product_type = $_POST['eproduct_type'];

    $file = rand(1000, 100000) . "-" . $_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $folder = "assets/img/";
    $new_size = $file_size / 1024;
    $new_file_name = strtolower($file);
    $final_file = str_replace(' ', '-', $new_file_name);
    if (!empty($final_file)) {
        if (move_uploaded_file($file_loc, $folder . $final_file)) {
            $qq = "UPDATE product SET product_image = '$final_file',product_name = '$product_name', product_description = '$product_description', product_specification = '$product_specification', product_price = '$product_price', product_quantity = '$product_quantity' , product_type = '$product_type', product_brand = '$product_brand' WHERE product_code = '$product_code'";
            mysqli_query($database, $qq);
            echo "<script>alert('product successfully updated');</script>";
        } else {
            $q = "UPDATE product SET product_name = '$product_name', product_description = '$product_description', product_specification = '$product_specification', product_price = '$product_price', product_quantity = '$product_quantity' , product_type = '$product_type', product_brand = '$product_brand' WHERE product_code = '$product_code'";
            mysqli_query($database, $q);
            echo "<script>alert('product successfully updated');</script>";
        }
    }
}
// add product php
/**
 * Add products 
 * 
 * @param string $product_code
 * @param string $product_name
 * @param string $product_description
 * @param string $product_specification
 * @param float $product_price
 * @param int $product_quantity
 * @param string $product_brand
 * @param string $product_type
 * 
 * @return status(201) product added
 */
if (isset($_POST['btn-upload'])) {

    $product_code = uniqid();
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_des'];
    $product_specification = $_POST['product_spc'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];
    $product_brand = $_POST['product_brand'];
    $product_type = $_POST['product_type'];

    $file = rand(1000, 100000) . "-" . $_FILES['file']['name'];

    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $folder = "assets/img/";

    $new_size = $file_size / 1024;

    $new_file_name = strtolower($file);

    $final_file = str_replace(' ', '-', $new_file_name);

    if (move_uploaded_file($file_loc, $folder . $final_file)) {
        $sql = "INSERT INTO product VALUES(0,'$product_code','$product_name','$product_description','$product_specification','$final_file','$product_price',0,'$product_quantity','$product_brand','$product_type')";
        mysqli_query($database, $sql);
?>
        <script>
            alert('product successfully uploaded');
            window.location.href = 'admin-products.php?success';
        </script>
    <?php
    } else {
    ?>
        <script>
            alert('error while uploading product');
            window.location.href = 'admin-products.php.?fail';
        </script>
<?php
    }
}
?>
<?php
//remove product php
/**
 * Remove products 
 * set product quantity to 0
 * 
 * @param string $product_name
 * 
 * @return status(200) removed 
 */
if (isset($_POST['delete_product'])) {
    $selected_product = $_POST['selected_product'];
    $query = "UPDATE product SET product_quantity = 0 WHERE product_name = '$selected_product' ";
    $result = mysqli_query($database, $query);
    $message = "$selected_product is successfuly removed";
    if ($selected_product == '') {
        echo "<script type='text/javascript'>alert('No product selected');</script>";
    } else {
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>