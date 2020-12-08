<?php
include('configure.php');
require_once("dbcontroller.php");
if (!isset($_SESSION['admin_email'])) {
    echo "<script type='text/javascript'> document.location = 'admin-login.php'; </script>";
}
?>
<?php
// spline
$dataPoints = array();
$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$monthsnumber = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
$monthscount = 0;
$totalmonth = 0;
while ($monthscount < 12) {
    if (isset($_POST['date1'])) {
        $y = substr($_POST['date1'],0,4);
        $m = $y . '-' . $monthsnumber[$monthscount];
        
    } else {
        $y = date("Y");
        $m = $y . '-' . $monthsnumber[$monthscount];
    }

    $query = "SELECT product_price,item_quantity FROM sales WHERE SYSDATE like '%" . $m . "%'";
    $data = mysqli_query($database, $query);
    while ($row = mysqli_fetch_array($data)) {
        $totalmonth += ($row['product_price'] * $row['item_quantity']);
    }
    array_push($dataPoints, array("y" => $totalmonth, "label" => $months[$monthscount]));
    $monthscount++;
    $totalmonth = 0;
    if (date("Y-m") == $m) {
        $monthscount = 0;
        break;
    }
}
?>
<script>
    window.onload = function() {
        var chart = new CanvasJS.Chart("chartContainerspline", {
            animationEnabled: true,
            animationDuration: 2000,
            exportEnabled: true,
            zoomEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title: {},
            toolTip: {

            },
            axisY: {
                prefix: "$",
            },
            data: [{
                type: "spline",
                showInLegend: true,
                legendText: "Jupiter Sales",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    }
</script>
<script>
    $(function() {
        $("#datepicker").datepicker({
            dateFormat: 'yy'
        });
    });​
</script>
<style>
    [type="date"] {
        background: #fff url(https://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/calendar_2.png) 97% 50% no-repeat;
    }

    [type="date"]::-webkit-inner-spin-button {
        display: none;
    }

    [type="date"]::-webkit-calendar-picker-indicator {
        opacity: 0;
    }

    label {
        display: block;
    }

    input {
        border: 1px solid #c4c4c4;
        border-radius: 5px;
        background-color: #fff;
        padding: 3px 5px;
        box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
        width: 190px;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="text-dark d-flex justify-content-center">Sales Overview (<?php echo $y; ?>)</h3>
                <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); " />

            </div>
            <div class="card-body">
                <?php $splinecounter = 0;
                $splinecal = 0;
                while ($splinecounter < count($dataPoints)) {
                    $splinecal += $dataPoints[$splinecounter]["y"];
                    $splinecounter++;
                }
                if ($splinecal != 0) {
                    echo "<div id='chartContainerspline' style='height: 370px; width: 100%;'></div>";
                } else {
                    echo "<h4 class='text-dark d-flex justify-content-center'>No Sales</h4>";
                }
                ?>
            </div>
        </div>
        <div class="card-footer bg-warning">
            <form action="admin.php" class="d-flex justify-content-center" method="POST">
            <input type="number" name="date1" min="2019" max="2030" step="1" class="btn col-sm-5 bg-warning" placeholder="Select a year and press enter" onchange="this.form.submit();" value="<?php echo isset($_POST['date1']) ? htmlspecialchars($_POST['date1'], ENT_QUOTES) : ''; ?>">
            </form>
        </div>
    </div>
</div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>