<?php
/**
 * search bar based on ajax 
 * 
 * @return Response
 */
include('dbcontroller.php');
include('configure.php');
$s1 = $_REQUEST["n"];
$select_query = "SELECT * FROM product WHERE product_name like '%" . $s1 . "%'";
$sql = mysqli_query($database, $select_query);
$s = "";
while ($row = mysqli_fetch_array($sql)) {
	$s=$s."
	<a class='link-p-colr' href='viewitem.php?action=add&code=".$row['product_code']."'>
		<div class='live-outer'>
            	<div class='live-im'>
                	<img src='assets/img/".$row['product_image']."'/>
                </div>
                <div class='live-product-det'>
					<div class='live-product-name'>
					<div>
						<p>&nbsp;&nbsp;&nbsp;".$row['product_name']."</p>
					</div>
					</div>
                    <div class='live-product-price'>
						
                    </div>
                </div>
            </div>
	</a>
	"	;
}
echo $s;
