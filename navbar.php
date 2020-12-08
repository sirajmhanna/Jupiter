<?php
include('configure.php');
require_once("dbcontroller.php");
if (!isset($_SESSION['name'])) {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}

?>
<script>
    function lightbg_clr() {
        $('#qu').val("");
        $('#textbox-clr').text("");
        $('#search-layer').css({
            "width": "auto",
            "height": "auto"
        });
        $('#livesearch').css({
            "display": "none"
        });
        $("#qu").focus();
    };

    function fx(str) {
        var s1 = document.getElementById("qu").value;
        var xmlhttp;
        if (str.length == 0) {
            document.getElementById("livesearch").innerHTML = "";
            document.getElementById("livesearch").style.border = "0px";
            document.getElementById("search-layer").style.width = "auto";
            document.getElementById("search-layer").style.height = "auto";
            document.getElementById("livesearch").style.display = "block";
            $('#textbox-clr').text("");
            return;
        }
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("livesearch").innerHTML = xmlhttp.responseText;
                document.getElementById("search-layer").style.width = "100%";
                document.getElementById("search-layer").style.height = "100%";
                document.getElementById("livesearch").style.display = "block";
                $('#textbox-clr').text("X");
            }
        }
        xmlhttp.open("GET", "call_ajax.php?n=" + s1, true);
        xmlhttp.send();
    }
</script>
<link rel="stylesheet" href="assets/css/searchstyle.css">
<!-- navbar -->
<nav class="navbar navbar-expand-lg navbar-light " style="background-color: rgb(163, 153, 119)">
    <a class="navbar-brand" href="profile.php">
        <img src="assets/img/jupiterlogo.png" alt="logo" style="height: auto;width:180px">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form method="POST" action="profile.php" style="width: 100%">
            <div class="d-flex justify-content-center">
                <select name="selectedoption" class="btn" style="border: 2px solid rgb(254,198,1);background-color:#FFFFFF;">
                    <option value="all">All</option>
                    <option value="laptop">Laptop</option>
                    <option value="desktop">Desktop</option>
                    <option value="phone">Phone</option>
                </select>
                <input type="text" class="col-sm-8" placeholder="Search for items..." name="searchbar" onKeyUp="fx(this.value)" autocomplete="off" id="qu" class="btn" style="background-color:#FFFFFF;width:65%;border: 2px solid rgb(254,198,1);text-align: center; ">
                <div id="livesearch" class="col-sm-3" style="position:absolute;background-color:#FFFFFF;margin-top:50px;border-radius:5px"></div>
                <button class="btn fas fa-search fa-2x" type="submit" name="searchbtn" style="background-color: rgb(254,198,1);border: 2px solid rgb(254,198,1);"></button>
            </div>
        </form>
        <ul class="navbar-nav ml-auto ">
            <li class="nav-item" style="justify-content: right;padding:5px">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" data-toggle="dropdown" style="background-color: rgb(254,198,1);border-radius:50px;width:120px">
                        <i class="fas fa-cart-arrow-down fa-2x" style="color: black"><span id="total" style="color: red;padding:5px"></span></i>
                    </button>

                    <div class="dropdown-menu " style="background-color:rgb(176,188,203)">
                        <div id="shopping-cart " style="width: 320px;">
                            <hr>
                            <form action="profile.php" method="POST" class="d-flex justify-content-center">
                                <input type="submit" class="btn btn-lg text-black" style="background-color: rgb(254,198,1)" value="View Shopping Cart" name="shoppingcart">
                            </form>
                            <br>

                            <?php
                            if (isset($_SESSION["username"])) {
                                $total_quantity = 0;
                                $total_price = 0;
                            ?>
                                <div class="table-responsive d-flex justify-content-center">
                                    <table border="2" cellpadding="2" cellspacing="1" class="table d-flex justify-content-center btn" style="margin-bottom:70px">
                                        <tbody>
                                            <tr>
                                                <th style="text-align:left;">Item</th>
                                                <th style="text-align:right;" width="5%">Quantity</th>
                                                <th style="text-align:right;" width="10%">Price</th>

                                            </tr>
                                            <?php
                                            foreach ($_SESSION["username"] as $item) {
                                                $item_price = $item["quantity"] * $item["price"];
                                            ?>
                                                <tr>
                                                    <td>
                                                        <h6><?php echo $item["name"]; ?></h6>
                                                    </td>

                                                    <td style="text-align:center;">
                                                        <h6><?php echo $item["quantity"]; ?></h6>
                                                    </td>

                                                    <td style="text-align:center;">
                                                        <h6><?php echo "$ " . number_format($item_price, 2); ?></h6>
                                                    </td>
                                                    </td>
                                                </tr>
                                            <?php
                                                $total_quantity += $item["quantity"];
                                                $total_price += ($item["price"] * $item["quantity"]);
                                                echo "<script type='text/javascript'> document.getElementById('total').innerHTML =  $total_quantity; </script>";
                                            }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr style="background-color: pink">
                                                <td>
                                                    <h5 class="text-black">Total price:</h5>
                                                </td>
                                                <td colspan="2"><strong>
                                                        <h6 class="text-black"><?php echo "$ " . number_format($total_price, 2); ?></h6>
                                                    </strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            <?php
                            } else {
                            ?>
                                <div class="no-records">Your Cart is Empty</div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </li>

            <li class="nav-item " style="padding:5px">
                <div class="dropdown">
                    <style>
                        button:active:focus {
                            color: white;
                            background-color: white;
                            border-color: white;
                        }
                    </style>
                    <button class="btn dropdown-toggle" data-toggle="dropdown" style="background-color: rgb(254,198,1);border-radius:50px;width:120px;box-shadow: none;"><i class="fas fa-user fa-2x"></i> </button>
                    <div class="dropdown-menu" style="background-color:rgb(176,188,203)">
                        <form action="profile.php" method="POST">
                            <button type="submit" class="dropdown-item btn btn-white d-flex justify-content-center" name="seller" style="border-radius:15px;list-style-position:inside;border: 4px solid rgb(254,198,1)"><i class="fas fa-user btn fa-x">&nbsp; MY ACCOUNT</i></button>
                        </form>
                    </div>
            </li>
            <li class="nav-item" style="padding:5px;">
                <?php include('logout.php'); ?>
            </li>
        </ul>
    </div>
</nav>
<?php
if (isset($_POST['seller'])) {
    echo "<script type='text/javascript'> document.location = 'seller.php'; </script>";
}
?>