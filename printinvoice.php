<style>
@media all {
     *{
        font-size: 12px !important;
        font-family: 'Times New Roman'!important;
    }
    .printableAreafont{
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
    .image {
        width: 155px;
        max-width: 155px;
    }
    .title
    {
        font-size: 20px !important;
        font-weight: bold;
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
if(!isset($_GET['tid']))
{
    exit();
}
session_start();
?>
<body onload="window.print();"></body>

<div class="card-body mx-4" id="printableArea" class="printableArea">
    <div class="container">
        <p class="centered text-black printableAreafont title"> <?php echo $_SESSION["shopname"]?></p>
        <p class="centered text-black printableAreafont">
            <?php if(file_exists("./iLogo.png")){echo " <img class='image centered' src='./iLogo.png' alt='Logo' style='width: 155px;max-width: 155px;'>";} ?>
            <br><?php echo $_SESSION["h1"]?>
            <br><?php echo $_SESSION["h2"]?>
            <br><?php echo $_SESSION["h3"]?>
        </p>
        <table style='width:95%;' class="top">
            <tr class="top">
                <td class="text-start top bold">Cashier Name:</td>
                <td class="text-end top "><?php echo $_SESSION["name"]?></td>
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
include 'includes/sqlconnect.php';
$tid=$_GET['tid'];
$grandtotal=0;
$exec = mysqli_query($connection, "SELECT c.id, p.name, p.price, c.qty, c.total FROM tblcart AS c INNER JOIN tblproduct AS p ON p.id = c.pid WHERE c.transno LIKE $tid");
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
?>
<p class="text-black centered">Thank for your purchase</p>
<script type="text/javascript">
    setTimeout(function() {
        self.close();
    }, 1000);

</script>