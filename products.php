    <?php
    include('cart.php');
    // function to sort array
    /**
     * sort array 
     * @param array $key
     * 
     * @return array $key
     */
    function build_sorter($key)
    {
        return function ($b, $a) use ($key) {
            return strnatcmp($a[$key], $b[$key]);
        };
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>products</title>
        <link rel="stylesheet" href="assets/css/Shop-item-1.css">
        <link rel="stylesheet" href="assets/css/Shop-item.css">
        <link rel="stylesheet" href="swiper-5.3.6/package/css/swiper.min.css">
        <style>
            html,
            body {
                position: relative;
                height: 100%;
            }

            body {
                background: #eee;
                font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
                font-size: 14px;
                color: #000;
                margin: 0;
                padding: 0;
            }

            .swiper-container {
                width: 100%;
                height: 100%;

            }

            .swiper-slide {
                text-align: center;
                font-size: 18px;
                background: #fff;

                /* Center slide text vertically */
                display: -webkit-box;
                display: -ms-flexbox;
                display: -webkit-flex;
                display: flex;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                -webkit-justify-content: center;
                justify-content: center;
                -webkit-box-align: center;
                -ms-flex-align: center;
                -webkit-align-items: center;
                align-items: center;
            }
        </style>
        <style>
            .image {
                opacity: 1;
                display: block;
                width: 100%;
                height: 250;
                transition: .5s ease;
                backface-visibility: hidden;
            }

            .middle {
                transition: .5s ease;
                opacity: 0;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
                text-align: center;
            }

            .container:hover .image {
                opacity: 0.3;
            }

            .container:hover .middle {
                opacity: 1;
            }

            .text {
                color: white;
                font-size: 16px;
                padding: 16px 32px;
            }
        </style>

    </head>

    <body style="background-color: rgb(254,198,1)">
        
        <?php include('swiper.php'); ?>
        <br id="br3"><br id="br4">
        <div class="container" id="divIdtopselling" style="border-radius: 30px;margin-top: 1px">
            <?php include('topselling.php'); ?>
        </div>
        <br id="br2">
        <hr id="hrcut" style="border: 0; height: 3px; 
    background-image: -webkit-linear-gradient(left, rgb(254,198,1), rgb(163, 153, 119), rgb(254,198,1));
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), rgb(163, 153, 119)); " />
        <br>
        <div class="container" style="background-color: rgb(163, 153, 119);border-radius:30px;margin-top:1px" id="myDiv">
            <br id="br1">
            <div class="row" id="hotdeals">
                <div class="col-sm-5">
                    <hr style="border: 0; height: 3px; 
    background-image: -webkit-linear-gradient(left, rgb(163, 153, 119), rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); " />
                </div>
                <div class="col-sm-2">
                    <h4 class="d-flex justify-content-center">HOT DEALS</h4>
                </div>
                <div class="col-sm-5">
                    <hr style="border: 0; height: 3px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), rgb(163, 153, 119));
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), rgb(163, 153, 119)); " />
                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <?php
                if (isset($_POST['searchbtn'])) {
                    /** 
                     * Search button
                     * Search for items in the database 
                     * 
                     * @param string $serach_input
                     * 
                     * @return Response 
                    */
                    $serach_input = $_POST['searchbar'];
                    $selected_option = $_POST['selectedoption'];
                    if (!empty($serach_input)) {
                        echo "<script type='text/javascript'>
                    document.getElementById('divId').style.display = 'none';
                    document.getElementById('divIdtopselling').style.display = 'none';
                    document.getElementById('hotdeals').style.display = 'none';
                    document.getElementById('hrcut').style.display = 'none';
                    document.getElementById('br1').style.display = 'none';
                    document.getElementById('br2').style.display = 'none';
                    document.getElementById('br3').style.display = 'none';
                    document.getElementById('br4').style.display = 'none';
                    
                    </script>";
                    }
                    if ($selected_option == 'all' && !empty($serach_input)) {
                        $product_array = $db_handle->runQuery("SELECT * FROM product WHERE product_name like '%" . $serach_input . "%'");
                    } else if ($selected_option != 'all') {
                        echo "<script type='text/javascript'>
                    document.getElementById('divId').style.display = 'none';
                    document.getElementById('divIdtopselling').style.display = 'none';
                    document.getElementById('hotdeals').style.display = 'none';
                    document.getElementById('hrcut').style.display = 'none';
                    document.getElementById('br1').style.display = 'none';
                    document.getElementById('br2').style.display = 'none';
                    document.getElementById('br3').style.display = 'none';
                    document.getElementById('br4').style.display = 'none';
                    
                    </script>";
                        $product_array = $db_handle->runQuery("SELECT * FROM product WHERE product_name like '%" . $serach_input . "%' AND  product_type like '%" . $selected_option . "%'");
                    } else {
                        $product_array = $db_handle->runQuery("SELECT * FROM product WHERE product_quantity > 0 ORDER BY RAND() LIMIT 12");
                        usort($product_array, build_sorter('product_sale'));
                    }
                } else {
                    /**
                     * 
                     */
                    $product_array = $db_handle->runQuery("SELECT * FROM product WHERE product_quantity > 0 ORDER BY RAND() LIMIT 12");
                    usort($product_array, build_sorter('product_sale'));
                    if (isset($_POST['desktop'])) {
                        echo "<script type='text/javascript'>
                        document.getElementById('divId').style.display = 'none';
                        document.getElementById('divIdtopselling').style.display = 'none';
                        document.getElementById('hotdeals').style.display = 'none';
                        document.getElementById('hrcut').style.display = 'none';
                        document.getElementById('br1').style.display = 'none';
                        document.getElementById('br2').style.display = 'none';
                        document.getElementById('br3').style.display = 'none';
                        document.getElementById('br4').style.display = 'none';
                        </script>";
                        //product array contains all products sorted from most saled to least
                        $product = array();
                        $query = "SELECT product_id FROM product WHERE product_type like '%" . 'desktop' . "%'";
                        $result = mysqli_query($database, $query);
                        while ($row = mysqli_fetch_array($result)) {
                            $querysum = "SELECT product_id,SUM(item_quantity) AS item_quantity FROM sales WHERE product_id = '$row[product_id]'";
                            $resultsum = mysqli_query($database, $querysum);
                            while ($rowsum = mysqli_fetch_array($resultsum)) {
                                if ($rowsum['item_quantity'] > 0) {
                                    array_push($product, $rowsum);
                                }
                            }
                        }
                        usort($product, build_sorter('item_quantity'));
                        // add product to $product_array
                        $product_array = array();
                        foreach ($product as $key) {
                            $query = "SELECT * FROM product WHERE product_id = '$key[product_id]' AND product_quantity > 0 LIMIT 16";
                            $result = mysqli_query($database, $query);
                            while ($row = mysqli_fetch_array($result)) {
                                array_push($product_array, $row);
                            }
                        }
                    }
                    if (isset($_POST['laptop'])) {
                        echo "<script type='text/javascript'>
                        document.getElementById('divId').style.display = 'none';
                        document.getElementById('divIdtopselling').style.display = 'none';
                        document.getElementById('hotdeals').style.display = 'none';
                        document.getElementById('hrcut').style.display = 'none';
                        document.getElementById('br1').style.display = 'none';
                        document.getElementById('br2').style.display = 'none';
                        document.getElementById('br3').style.display = 'none';
                        document.getElementById('br4').style.display = 'none';
                        </script>";
                        //product array contains all products sorted from most saled to least
                        $product = array();
                        $query = "SELECT product_id FROM product WHERE product_type like '%" . 'laptop' . "%'";
                        $result = mysqli_query($database, $query);
                        while ($row = mysqli_fetch_array($result)) {
                            $querysum = "SELECT product_id,SUM(item_quantity) AS item_quantity FROM sales WHERE product_id = '$row[product_id]'";
                            $resultsum = mysqli_query($database, $querysum);
                            while ($rowsum = mysqli_fetch_array($resultsum)) {
                                if ($rowsum['item_quantity'] > 0) {
                                    array_push($product, $rowsum);
                                }
                            }
                        }
                        usort($product, build_sorter('item_quantity'));
                        $product_array = array();
                        foreach ($product as $key) {
                            $query = "SELECT * FROM product WHERE product_id = '$key[product_id]' AND product_quantity > 0 LIMIT 16";
                            $result = mysqli_query($database, $query);
                            while ($row = mysqli_fetch_array($result)) {
                                array_push($product_array, $row);
                            }
                        }
                    }
                    if (isset($_POST['phone'])) {
                        echo "<script type='text/javascript'>
                        document.getElementById('divId').style.display = 'none';
                        document.getElementById('divIdtopselling').style.display = 'none';
                        document.getElementById('hotdeals').style.display = 'none';
                        document.getElementById('hrcut').style.display = 'none';
                        document.getElementById('br1').style.display = 'none';
                        document.getElementById('br2').style.display = 'none';
                        document.getElementById('br3').style.display = 'none';
                        document.getElementById('br4').style.display = 'none';
                        </script>";
                        //product array contains all products sorted from most saled to least
                        $product = array();
                        $query = "SELECT product_id FROM product WHERE product_type like '%" . 'phone' . "%'";
                        $result = mysqli_query($database, $query);
                        while ($row = mysqli_fetch_array($result)) {
                            $querysum = "SELECT product_id,SUM(item_quantity) AS item_quantity FROM sales WHERE product_id = '$row[product_id]'";
                            $resultsum = mysqli_query($database, $querysum);
                            while ($rowsum = mysqli_fetch_array($resultsum)) {
                                if ($rowsum['item_quantity'] > 0) {
                                    array_push($product, $rowsum);
                                }
                            }
                        }
                        usort($product, build_sorter('item_quantity'));
                        $product_array = array();
                        foreach ($product as $key) {
                            $query = "SELECT * FROM product WHERE product_id = '$key[product_id]' AND product_quantity > 0 LIMIT 16";
                            $result = mysqli_query($database, $query);
                            while ($row = mysqli_fetch_array($result)) {
                                array_push($product_array, $row);
                            }
                        }
                    }
                }
                if (!empty($product_array)) {
                    foreach ($product_array as $key => $value) {
                ?>
                        <?php
                        $xyz = $product_array[$key]['product_id'];
                        $query = "SELECT * FROM product WHERE product_id = '$xyz'";
                        $result = mysqli_query($database, $query);
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <div class="col-sm-3">
                                <form method='POST' action='profile.php?action=add&code=<?php echo $product_array[$key]['product_code']; ?>'>
                                    <div class="card text-dark" style="border: none;border-radius:30px;">
                                        <div class="card-img-top d-flex justify-content-center" style="position: relative;">
                                            <img src='assets/img/<?php echo $product_array[$key]['product_image']; ?>' class="card-img-top d-flex justify-content-center" style="height:250px;width:100%;border-radius:15px;border: 10px solid transparent">
                                            <?php
                                            if ($row['product_quantity'] < 1) {
                                                echo "<img src='assets/img/stockout.png' class='card-img-top d-flex justify-content-center' style='height:200px;width:100%;border-radius:15px;  position: absolute;opacity: .7'>";
                                            }
                                            ?>
                                        </div>
                                        <div class='card-body w-100'>
                                            <?php $in = $product_array[$key]['product_name']; ?>
                                            <h6 class="card-title d-flex justify-content-center" style="background-color:rgb(176,188,203);border-radius:5px;display:inline"><?php $out = strlen($in) > 25 ? substr($in, 0, 25) . ".." : $in;
                                                                                                                                                                            echo  $out ?></h6>
                                            <?php
                                            $xxx = $product_array[$key]['product_sale'];
                                            $yyy = $product_array[$key]['product_price'];
                                            ?>
                                            <h5 class="card-title d-flex justify-content-center" style="background-color: pink;border-radius:30px"><?php echo '$' . round((($product_array[$key]['product_price']) * (1 - $product_array[$key]['product_sale'] / 100)), 2) . ' &nbsp; ' ?> <?php echo "<strike>" . ($xxx > 0 ? "$$yyy" : "") . "</strike>"; ?> </h5>
                                            <?php $xin = $product_array[$key]['product_description']; ?>
                                            <p class="card-title d-flex justify-content-center" style="height: 100px"><?php $xout = strlen($xin) > 101 ? substr($xin, 0, 101) . ".." : $xin;
                                                                                                                        echo $xout; ?></p>

                                            <p></p>
                                            <input type="submit" class="btn btn-block col-sm-12 text-black" style="background-color: rgb(254,198,1);border-radius:30px;margin-top: 25px;" value="View Item" name="viewitem" <?php if ($row['product_quantity'] < 1) {
                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                        } ?>>
                                            <p></p>
                                            <?php
                                            if (isset($_POST['viewitem'])) {
                                                $_SESSION['item_saver'] = $product_array[$key]['product_code'];
                                                $x = $_SESSION['item_saver'];
                                                $query = "SELECT * FROM product WHERE product_code='" . $_GET["code"] . "'";
                                                $result = mysqli_query($database, $query);
                                                while ($row = mysqli_fetch_array($result)) {
                                                    $_SESSION['saved_id'] = $row['product_id'];
                                                    $_SESSION['saved_code'] = $row['product_code'];
                                                    $_SESSION['saved_image'] = $row['product_image'];
                                                    $_SESSION['saved_specification'] = $row['product_specification'];
                                                    $_SESSION['saved_price'] = $row['product_price'];
                                                    $_SESSION['saved_name'] = $row['product_name'];
                                                    $_SESSION['saved_description'] = $row['product_description'];
                                                    $_SESSION['saved_sale'] = $row['product_sale'];

                                                    if ($row['product_quantity'] > 0) {
                                                        echo "<script type='text/javascript'> document.location = 'viewitem.php'; </script>";
                                                    }
                                                }
                                                echo "<script type='text/javascript'>alert('product is out of stock');</script>";
                                                echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </form><br>
                            </div>
                    <?php }
                } else if (!empty($serach_input)) {
                    echo "<p class='text-white d-flex justify-content-center' style='margin-left:15px'> No results for $serach_input
                Try checking your spelling or use more general terms</p>";
                } ?>

            </div>
        </div>
        <!-- Swiper JS -->
        <script src="swiper-5.3.6/package/js/swiper.min.js"></script>
        <script>
            var swiper = new Swiper('.swiper-container', {
                spaceBetween: 30,
                centeredSlides: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        </script>
    </body>


    </html>