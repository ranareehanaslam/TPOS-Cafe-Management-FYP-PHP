<?php
include 'includes/header.php';
require 'includes/sqlconnect.php';
include 'includes/sessoincheck.php';
$sql = "SELECT * FROM `tbluser` WHERE role LIKE 'Cashier'";
$all_cashiers = mysqli_query($connection,$sql);
?>
<head>
    <link rel="stylesheet" type="text/css" href="./includes/css/datatables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./includes/css/buttons.bootstrap5.css">
</head>
<div class="container">
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-bs-toggle="tab" id="sales" onclick="loadtable('tblsales',startdate,enddate)"
                                                        href="#tab-1">Sales</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" role="tab" id="refund" data-bs-toggle="tab" href="#tab-2">Refund</a>
            </li>
            <li class="nav-item" role="presentation"><a class="nav-link" role="tab" id="bestselling" data-bs-toggle="tab" href="#tab-3" onclick="loadtable('tblbestselling',startdate,enddate)">Best
                    Sellings</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" role="tab" id="log" data-bs-toggle="tab" href="#tab-4"  onclick="loadtable('tbllog',startdate,enddate)">Log
                    History</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active text-black" role="tabpanel" id="tab-1">
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-xxl-9">
                        <div class="card shadow">
                            <div class="card-header d-flex flex-wrap justify-content-center align-items-center justify-content-sm-between gap-3">
                                <div class="col">
                                    <h2 class="display-5 text-nowrap text-capitalize mb-0">Sales</h2>
                                </div>
                                <div id="reportrange" class="datepicker" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button">Cashier </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item">All</a>
                                    <?php
                                    while ($cashiers = mysqli_fetch_array(
                                        $all_cashiers,MYSQLI_ASSOC)):;
                                        ?>
                                    <a class="dropdown-item"><?php echo $cashiers["name"]?></a>
                                    <?php
                                    endwhile;
                                    // While loop must be terminated
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive text-black">
                                    <div id="tblsales"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane text-black" role="tabpanel" id="tab-2">
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-xxl-9">
                        <div class="card shadow">
                            <div class="card-header d-flex flex-wrap justify-content-center align-items-center justify-content-sm-between gap-3">
                                <div class="col">
                                    <h2 class="display-5 text-nowrap text-capitalize mb-0">Refund</h2>
                                </div>
                                <div id="reportrange" class="datepicker" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover text-black">
                                        <thead>
                                        <tr>
                                            <th>Trans No</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Cashier</th>
                                            <th>Reason</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-truncate" style="max-width: 200px;">1</td>
                                            <td class="text-truncate" style="max-width: 200px;">Tadka Chai</td>
                                            <td>50</td>
                                            <td>2</td>
                                            <td>100</td>
                                            <td>Cashier1</td>
                                            <td>Leaving</td>
                                            <td>5/22/2022</td>
                                        </tr>
                                        <tr>
                                            <td class="text-truncate" style="max-width: 200px;">2</td>
                                            <td class="text-truncate" style="max-width: 200px;">Tadka Chai</td>
                                            <td>50</td>
                                            <td>4</td>
                                            <td>200</td>
                                            <td>Cashier1</td>
                                            <td>Not Cooked well</td>
                                            <td>10/22/2022</td>
                                        </tr>
                                        <tr>
                                            <td class="text-truncate" style="max-width: 200px;">3</td>
                                            <td class="text-truncate" style="max-width: 200px;">Sting</td>
                                            <td>60</td>
                                            <td>10</td>
                                            <td>500</td>
                                            <td>Cashier1</td>
                                            <td>Not Chilled</td>
                                            <td>12/22/2022</td>
                                        </tr>
                                        <tr>
                                            <td class="text-truncate" style="max-width: 200px;">2</td>
                                            <td class="text-truncate" style="max-width: 200px;">Gold Leafe</td>
                                            <td>10</td>
                                            <td>3</td>
                                            <td>30</td>
                                            <td>Cashier1</td>
                                            <td>Leaving</td>
                                            <td>16/22/2022</td>
                                        </tr>
                                        <tr>
                                            <td class="text-truncate" style="max-width: 200px;">2</td>
                                            <td class="text-truncate" style="max-width: 200px;">Tadka Chai</td>
                                            <td>50</td>
                                            <td>6</td>
                                            <td>280</td>
                                            <td>Cashier1</td>
                                            <td>Not Joined</td>
                                            <td>17/22/2022</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <nav>
                                    <ul class="pagination pagination-sm mb-0 justify-content-center">
                                        <li class="page-item"><a class="page-link" aria-label="Previous" href="#"><span
                                                        aria-hidden="true">«</span></a></li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" aria-label="Next" href="#"><span
                                                        aria-hidden="true">»</span></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane text-black" role="tabpanel" id="tab-3">
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-xxl-9">
                        <div class="card shadow">
                            <div class="card-header d-flex flex-wrap justify-content-center align-items-center justify-content-sm-between gap-3">
                                <div class="col">
                                    <h2 class="display-5 text-nowrap text-capitalize mb-0">Best Selling</h2>
                                </div>
                                <div id="reportrange" class="datepicker" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive text-black">
                                    <div id="tblbestselling"></div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <nav>
                                    <ul class="pagination pagination-sm mb-0 justify-content-center">
                                        <li class="page-item"><a class="page-link" aria-label="Previous" href="#"><span
                                                        aria-hidden="true">«</span></a></li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" aria-label="Next" href="#"><span
                                                        aria-hidden="true">»</span></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane text-black" role="tabpanel" id="tab-4">
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-xxl-9">
                        <div class="card shadow">
                            <div class="card-header d-flex flex-wrap justify-content-center align-items-center justify-content-sm-between gap-3">
                                <div class="col">
                                    <h2 class="display-5 text-nowrap text-capitalize mb-0">Log History</h2>
                                </div>
                                <div id="reportrange" class="datepicker" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive text-black">
                                    <div id="tbllog"></div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="./includes/js/records/datejquery.js"></script>
<script type="text/javascript" src="./includes/js/moment.min.js"></script>
<script type="text/javascript" src="./includes/js/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="./includes/css/daterangepicker.css">
<script>
    var startdate='01/01/2022',enddate=moment().format('YYYY-MM-DD');
    $(document).ready(function () {
        loadtable('tblsales',startdate,enddate)
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start , end) {
            $('.datepicker span').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
            startdate=start.format('YYYY-MM-DD');
            enddate=end.format('YYYY-MM-DD');
            var id=$($(".nav").find(".active").attr('href')).index();
           if(id==0)
           {
               loadtable('tblsales',startdate,enddate);
           }
           else if(id==2)
           {
               loadtable('tblbestselling',startdate,enddate);
           }
           else if(id==3)
           {
               loadtable('tbllog',startdate,enddate);
           }
        }

        $('.datepicker').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment()],
                'Last Year': [moment().subtract(1, 'year').add(1,'day'), moment()],
                'All Time': ['01/01/2022', moment()],
            }
        }, cb);
        cb(start, end);
    });
    function loadtable(tablecalled,startdate,enddate){
        var jsonObj = JSON.stringify(tablecalled);
        var startdate = JSON.stringify(startdate);
        var enddate = JSON.stringify(enddate);
        $.ajax({
            type: "POST",
            data: {"table": jsonObj,
                "startdate": startdate,
                "enddate": enddate
            },
            url: "tablehandling.php",
            dataType: "html",
            success: function(data){
                if(tablecalled=="tblsales") {
                    $("#tblsales").html(data);
                }
                else if (tablecalled=="tbllog") {
                    $("#tbllog").html(data);
                }
                else if (tablecalled=="tblbestselling") {
                    $("#tblbestselling").html(data);
                }
            }
        });
    }
</script>
<script type="text/javascript" src="./includes/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="./includes/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="./includes/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="./includes/js/buttons.bootstrap5.min.js"></script>
<script type="text/javascript" src="./includes/js/jszip.min.js"></script>
<script type="text/javascript" src="./includes/js/pdfmake.min.js"></script>
<script type="text/javascript" src="./includes/js/vfs_fonts.js"></script>
<script type="text/javascript" src="./includes/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="./includes/js/buttons.print.min.js"></script>