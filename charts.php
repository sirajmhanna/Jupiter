<?php
include('configure.php');
include_once('seller.php');
require_once("dbcontroller.php");
if (!isset($_SESSION['name'])) {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
?>
<?php
// spline
/**
 * Fill array 
 * 
 * This method calculates total commission in each month 
 * 
 * @param float $totalmonth
 * @param int $monthscount
 * @param array $months
 * @param array monthsnumber
 * 
 * @return array $dataPoints 
 */
$dataPoints = array();
$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$monthsnumber = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
$monthscount = 0;
$totalmonth = 0;
while ($monthscount < 12) {
    $y = date("Y");
    $m = $y . '-' . $monthsnumber[$monthscount];
    $query = "SELECT commission_amount FROM commission WHERE employee_id = '$_SESSION[employee_id_saver]' AND SYSDATE like '%" . $m . "%' AND commission_from_seller != 2";
    $data = mysqli_query($database, $query);
    while ($row = mysqli_fetch_array($data)) {
        $totalmonth += $row['commission_amount'];
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
<?php
//doughnut
/**
 * Fill array 
 * 
 * This method calculates the financial returns from each sellers in this year
 * 
 * @param float $totalsaver
 * @param int $thisyear
 * 
 * @return array $dataPoints2
 */
$dataPoints2 = array();
$thisyear = date("Y");
$totalsaver = 0;
$query = "SELECT employee_id,first_name,last_name,parent_id FROM employee WHERE status = 1 AND parent_id = '$_SESSION[employee_id_saver]' OR employee_id = '$_SESSION[employee_id_saver]'";
$result = mysqli_query($database, $query);
while ($row2 = mysqli_fetch_array($result)) {
    $query1 = "SELECT commission_amount,employee_id FROM commission WHERE employee_id = '$row2[employee_id]' AND SYSDATE like '%" . $thisyear . "%' AND commission_from_seller = 0";
    $data1 = mysqli_query($database, $query1);
    while ($row1 = mysqli_fetch_array($data1)) {
        if ($row1['employee_id'] == $_SESSION['employee_id_saver']) {
            if($row2['parent_id'] == $row2['employee_id']){
                $totalsaver += ($row1['commission_amount'] / 0.08) * 0.02;
            }
            $totalsaver += $row1['commission_amount'];
        } else {
            $totalsaver += ($row1['commission_amount'] / 0.08) * 0.02;
        }
    }
    $douname = $row2['first_name'];
    $douname .= " " . $row2['last_name'];
    $totalsaver = round($totalsaver, 2);
    array_push($dataPoints2, array("label" => "$douname", "symbol" => "", "y" => $totalsaver));
    $totalsaver = 0;
}
?>
<!-- Legends chart -->
<?php
/**
 * Fill array 
 * 
 * This method calculates the financial returns from each sellers in each month
 * 
 * @param float $totalsaver
 * @param int $thisyear
 * 
 * @return array $dataPoints44
 */
$dataPoints44 = array();
$dataPointsarray = array();
$months44 = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$monthsnumber44 = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
$monthscount44 = 0;
$totalmonth44 = 0;
$queryforall = "SELECT employee_id,first_name,last_name FROM employee WHERE parent_id = '$_SESSION[employee_id_saver]' AND employee_id != '$_SESSION[employee_id_saver]' AND status = 1";
$result = mysqli_query($database, $queryforall);
while ($row2 = mysqli_fetch_array($result)) {
    $dataPoints44 = array();
    while ($monthscount44 < 12) {
        $y = date("Y");
        $m = $y . '-' . $monthsnumber44[$monthscount44];
        $query = "SELECT commission_amount,employee_id FROM commission WHERE employee_id = '$row2[employee_id]' AND SYSDATE like '%" . $m . "%' AND commission_from_seller = 0";
        $data = mysqli_query($database, $query);
        while ($row = mysqli_fetch_array($data)) {
            //calculate Revenue from each commisson where parent id equals user_id
            $totalmonth44 += ($row['commission_amount'] / 0.08) * 0.02;
            $totalmonth44 = round($totalmonth44, 2);
        }
        $legendname = $row2['first_name'];
        $legendname .= " " . $row2['last_name'];
        array_push($dataPoints44, array("label" => $months44[$monthscount44], "y" => $totalmonth44, "username" => $legendname));
        $monthscount44++;
        $totalmonth44 = 0;
        $totalmonth = 0;
        if (date("Y-m") == $m) {
            $monthscount44 = 0;
            $totalmonth44 = 0;
            break;
        }
    }
    array_push($dataPointsarray, $dataPoints44);
}
?>


<script>
    window.onload = function() {
        var chart = new CanvasJS.Chart("chartContainerspline", {
            animationEnabled: true,
            animationDuration: 2000,
            exportEnabled: true,
            zoomEnabled: true,
            theme: "light2",
            title: {},
            toolTip: {

            },
            axisY: {
                prefix: "$",
            },
            data: [{
                type: "spline",
                showInLegend: true,
                legendText: "<?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?>",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

        var chart11 = new CanvasJS.Chart("chartContainerdought", {

            animationEnabled: true,
            animationDuration: 2000,
            theme: "light2",
            title: {},
            data: [{
                type: "doughnut",
                showInLegend: true,
                legendText: "{label} : #percent%",
                toolTipContent: "<b>{label}:</b> ${y} (#percent%)",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart11.render();
        var chart44 = new CanvasJS.Chart("chartContainerLegends", {
            animationEnabled: true,
            animationDuration: 2000,
            exportEnabled: true,
            zoomEnabled: true,
            theme: "light2",
            title: {},
            axisY: {
                prefix: "$",
            },
            toolTip: {

            },
            legend: {
                cursor: "pointer",
                itemclick: toggleDataSeries
            },
            data: [
                <?php
                $x = 0;
                while ($x < count($dataPointsarray)) {
                    $name = $dataPointsarray[$x][0]["username"];
                    echo "{ type: 'spline',
                    name: '$name',
                    toolTipContent: '<b>{label}:</b> {y}',
					showInLegend: true,
					dataPoints: " . json_encode($dataPointsarray[$x], JSON_NUMERIC_CHECK) . "},";
                    $x++;
                } ?>
            ]
        });

        chart44.render();

        function toggleDataSeries(e) {
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            chart44.render();
        }
    }
</script>

<div class="row">
    <div class="col-sm-8">
        <div class="card">
            <div class="card-header">
                <h3 class="text-dark d-flex justify-content-center">Earnings Overview</h3>
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
                    echo "<h4 class='text-dark d-flex justify-content-center'>No Earnings Yet</h4>";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-header">
                <h3 class="text-dark d-flex justify-content-center">Revenue Sources</h3>
                <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); " />
            </div>
            <div class="card-body">
                <div id="chartContainerdought" style="height: 370px; width: 100%;">

                    <?php $xq = 0;
                    $xt = 0;
                    while ($xq < count($dataPoints2)) {
                        $xt += $dataPoints2[$xq]["y"];
                        $xq++;
                    }
                    if ($xt == 0) {
                        echo "<script type='text/javascript'>
                    document.getElementById('chartContainerdought').style.display = 'none';
                    </script>";
                    } else {
                        echo "<script type='text/javascript'>
                    document.getElementById('h1n1').style.display = 'none';
                    </script>";
                    } ?>
                </div>
                <div id="h1n1">
                    <?php
                    if ($xt == 0) {
                        echo "<h4 class='text-dark d-flex justify-content-center'>No revenues from sellers</h4>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="text-dark d-flex justify-content-center">Earnings From Sellers</h3>
                <hr style="border: 0; height: 4px; 
    background-image: -webkit-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -moz-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -ms-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0);
    background-image: -o-linear-gradient(left, #f0f0f0, rgb(163, 153, 119), #f0f0f0); " />
            </div>
            <div class="card-body">
                <div id="chartContainerLegends" style="height: 370px; width: 100%;"></div>
                <?php if (empty($dataPointsarray)) {
                    echo "<script type='text/javascript'>
                    document.getElementById('chartContainerLegends').style.display = 'none';
                    </script>";;
                } ?>
                <?php if (empty($dataPointsarray)) {
                    echo "<h4 class='text-dark d-flex justify-content-center'>You have no sellers</h4>";
                    echo "<h5 class='text-dark d-flex justify-content-center'>Add sellers to increase your profits</h5>";
                } ?>
            </div>
        </div>
    </div>
</div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>