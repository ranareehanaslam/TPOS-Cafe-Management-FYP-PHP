<style>
    @media all {
        *{
            font-size: 12px !important;
            font-family: 'Times New Roman'!important;
        }
        .printableArea {
            text-align: center;
            align-content: center;
        }
        td,
        th,
        tr,
        table {
            border-top: 1px solid black !important;
            border-collapse: collapse !important;
        }

        td.description,
        th.description {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis !important;
            width: 120px !important;
            max-width: 120px !important;
        }

        td.quantity,
        th.quantity {
            width: 40px !important;
            max-width: 40px !important;
            word-break: break-all  !important;
        }

        td.price,
        th.price {
            width: 40px!important;
            max-width: 40px !important;
            word-break: break-all !important;
        }
        .centered {
            text-align: center !important;
            align-content: center !important;
        }
        .text-start
        {
            text-align: start;
        }
        .text-end
        {
            text-align: end;
        }
        .text-black
        {
            margin: 0px !important;
        }
    }
    .top{
        border: 0px !important;
    }
    .bold{
        font-weight: bold !important;
    }
</style>
<?php
include 'includes/sqlconnect.php';
if(!isset($_GET['tid']))
{
    exit();
}
else{
    $tid=$_GET['tid'];
    $exec = mysqli_query($connection, "SELECT c.id, p.name, p.price, c.qty, c.total FROM tblcart AS c INNER JOIN tblproduct AS p ON p.id = c.pid WHERE c.transno LIKE $tid AND c.status!='Printed'");
    if(mysqli_num_rows($exec) <1)
    {
        echo "<script>self.close();</script>";
        exit();
    }
}
session_start();
?>
<body onload="window.print();"></body>
<p class="text-black centered">Kitchen Invoice</p>
<div class="card-body mx-4" id="printableArea" class="printableArea">
    <div class="container">
        <table style='width:95%;' class="top">
            <tr class="top">
                <td class="text-start top bold">Table:</td>
                <td class="text-end top "><?php echo $_GET['table']?></td>
            </tr>
            <tr class="top">
                <td class="text-start top bold">Invoice#</td>
                <td class="text-end top "><?php echo $_GET['tid']; ?></td>
            </tr>
            <tr class="top">
                <td class="text-start top bold">Date:</td>
                <td class="text-end top "><?php echo $_SESSION["date"];date_default_timezone_set('Asia/Karachi');echo "  ".date('h:i:s A');?></td>
            </tr>
        </table>
        <div id="printbillitems" class="printableArea">
        </div>
    </div>
</div>
<?php
$grandtotal=0;
$exec = mysqli_query($connection, "SELECT c.id, p.name, p.price, c.qty, c.total FROM tblcart AS c INNER JOIN tblproduct AS p ON p.id = c.pid WHERE c.transno LIKE $tid AND c.status!='Printed'");
echo "<table class='text-black printableArea centered' style='width:95%'>
<thead>
<tr>
<th class='description text-start'>Name</th>
<th class='quantity'>Qty</th>
<th class='price'>Price</th>
<th class='price text-end'>Total</th>
</tr>
</thead>
<tbody>";
if (mysqli_num_rows($exec) > 0) {
    $row = mysqli_fetch_all($exec, MYSQLI_ASSOC);
    foreach ($row as $data) {
        $grandtotal += $data['total'];
        $total = $data['qty'] * $data['price'];
        echo "          <tr>
                            <td class='description text-start'>" . $data['name'] . "</td>
                            <td class='quantity'>" . intval($data['qty']) . "</td>
                            <td class='price'>" . intval($data['price']) . "</td>
                            <td class='price text-end'>$total</td>
                            </tr>     
                              ";
    }
    $exec = mysqli_query($connection, "SELECT * FROM `tbldiscount` WHERE transno LIKE '$tid'");
    if (mysqli_num_rows($exec) > 0) {
        $row = mysqli_fetch_row($exec);
        $discount = $row['2'];
        $Nettotal = $grandtotal - $discount;
    } else {
        $Nettotal = $grandtotal;
        $discount = 0;
    }
    echo "
                            <tr>
                            <td colspan='4' class='text-end'>Gross Total:$grandtotal</td>
                            </tr>  
                            <tr>
                            <td colspan='4' class='text-end'>Discount:$discount</td>
                            </tr>  
                            <tr>
                            <td colspan='4' class='text-end'>Net Total:$Nettotal</td>
                            </tr> 
                            </tbody>
                            </table>
 ";
}
$exec = mysqli_query($connection, "UPDATE tblcart SET status= 'Printed' where transno like '$tid'");

?>
<script type="text/javascript">
    setTimeout(function() {
        self.close();
    }, 1000);

</script>