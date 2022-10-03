<?php
include "includes/sqlconnect.php";
session_start();
function fetch_data($table,$connection,$categorycalled){
    if($categorycalled=="All")
    {
        $exec=mysqli_query($connection, "SELECT * from ".$table." ORDER BY id ASC");
    }
    elseif($categorycalled=="Nill")
    {
        $exec=mysqli_query($connection, "SELECT * from ".$table);
    }
    else
    {
        $exec=mysqli_query($connection,"SELECT * FROM `tblproduct` WHERE `category`='$categorycalled'  ORDER BY `tblproduct`.`category` DESC ");
    }

    if(mysqli_num_rows($exec)>0){
        $row= mysqli_fetch_all($exec, MYSQLI_ASSOC);
        return $row;
    }else{
        return $row=[];
    }
}
//Function Show Products
function show_products($fetchData){
    $count=0;
    if(count($fetchData)>0){
        $sn=1;
        foreach($fetchData as $data){
            $stock=$data['stock'];
            if($stock==0||$data['status']=="not-available")
            {

            }
            else
            {
                if($count==0)
                {
                    echo " <div class='row'>";
                }
                $count++;

                echo "
                            <div class='col-sm-3 col-6 m-auto' style='padding-top: 10px;padding-bottom: 10px;'>
                                <div class='card'>
                                    <div class='card-header bg-primary text-center text-truncate'>
                                        ".$data['name']."
                                    </div>
                                    <button class='productsshow' data-bs-toggle='modal' data-bs-target='#itemadd' data-itemid='".$data['id']."' data-price='".$data['price']."'>
                                        <img class='card-img-top' src='".$data['image']."' alt='Product Image' height='120' width='136'>
                                        "; if($stock==-1)
            {
                echo "STOCK <span>&#8734;</span> ";
            }
            else{
                echo "STOCK:$stock";
            }
                                            echo "
                                    </button>
                                    <div class='card-footer bg-dark text-center'>
                                        PKR ".$data['price']."
                                    </div>
                                </div>
                            </div>
                            ";
                if($count==4)
                {
                    echo "</div>";
                    $count=0;
                }
            }
            $sn++;
        }

    }else{
        echo" <div class='bg-dark text-center '>NO PRODUCTS FOUND IN DATABASE</div>";
    }
    echo "</div>";

}
//Function Show Tables
function show_tables($fetchData){
    $colour="card-content text-primary";
    $count=0;
    if(count($fetchData)>0){

        $sn=1;
        foreach($fetchData as $data){
            if($count==4)
            {
                $count=0;
            }
            if($count==0)
            {
                echo " <div class='row' style='padding-bottom: 20px;'>";
            }
            $count++;
            if($data['bill']=='0.00'){$colour="card-content text-primary";}else{$colour="card-content text-danger";}
            echo "<div class='col-xl-3 col-sm-6 col-12'>
                                    <div class='card bg-dark'>
                                        <button class='rounded tbltable' value='".$data['tableno']."' type='submit'>
                                            <div class='".$colour."'>
                                                <div class='card-body text-center'>
                                                    <div class='col'>
                                                        <i class='fas fa-chair fa-2x'></i>
                                                    </div>
                                                    <div class='col'>
                                                        <h5>TBL ".$data['tableno']."</h5>
                                                        <p>RS==".$data['bill']."</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>";
            if($count==4)
            {
                echo "</div>";
            }
            $sn++;
        }

    }else{
        echo" <div class='bg-dark text-center '>NO PRODUCTS FOUND IN DATABASE</div>";
    }
    echo "</div>";

}
//Function Show REFUND ITEMS
function sohw_refunditems($fetchData){
    echo "<table class='table table-hover text-black'>
            <thead class='bg-dark text-white'>
            <tr>
            <th>TBL NO</th>
            <th>TR#</th>
            <th>DESCRIPTION</th>
            <th>PRICE</th>
            <th>ORDER</th>
            <th>TOTAL</th>
            <th class='text-end'>Actions</th>
            </tr>
            </thead>
            <tbody>";
    if(count($fetchData)>0){
        foreach($fetchData as $data){
            echo "              <tr>
                                <td class='text-truncate' style='max-width: 200px;'>".$data['tableno']."</td>
                                <td class='text-truncate' style='max-width: 200px;'>".$data['transno']."</td>
                                <td class='text-truncate' style='max-width: 200px;'>".$data['name']."</td>
                                <td class='text-truncate' style='max-width: 200px;'>".$data['price']."</td>
                                <td class='text-truncate' style='max-width: 200px;'>".$data['qty']."</td>
                                <td class='text-truncate' style='max-width: 200px;'>".$data['total']."</td>
                                <td class='text-end'>
                                <button class='btn btn-sm' type='button' data-bs-toggle='modal'
                                data-bs-target='#itemrefund' data-refunditemamount='".$data['total']."' data-refunditemprice='".$data['price']."' data-refunditemname='".$data['name']."' data-refunditemqty='".$data['qty']."'><i
                                class='fa-solid fa-person-walking-arrow-loop-left fa-2x text-primary'></i>
                                </button>
                                </td>
                                </tr>
          ";
        }
    }else{
        echo "<tr>
        <td colspan='8'>No Data Found</td>
       </tr>";
    }

    echo "</tbody></table>";


}
$dbtablename=json_decode($_POST["tablecalled"], true);
if($dbtablename=="tblproduct")
{
    $fetchData= fetch_data("tblproduct",$connection,json_decode($_POST["categorycalled"]));
    show_products($fetchData);
}
else if($dbtablename=="startofday")
{
    $cashstartofday=json_decode($_POST["cashstartofday"], true);
    $startdate=json_decode($_POST["startdate"], true);
    if(mysqli_num_rows(mysqli_query($connection,"SELECT * FROM `tblstart` WHERE status = 'Open'"))>0) {
        echo "exist";
    }
    else if(mysqli_num_rows(mysqli_query($connection,"SELECT * FROM `tblstart` WHERE sdate = '$startdate'"))>0)
    {
        echo "closed";
    }
    else
    {
        $exec=mysqli_query($connection, "INSERT INTO `tblstart` (`sdate`, `initialcash`, `status`) VALUES ('$startdate', '$cashstartofday', 'Open')");
        $_SESSION["date"]=$startdate;
        $tdate = str_replace('-', '', $startdate);
        $_SESSION["trnsdate"]=$tdate;
        echo "success";
    }
}
else if($dbtablename=="tbltable")
{
    $fetchData= fetch_data("vwtable",$connection,'Nill');
    show_tables($fetchData);
}
else if($dbtablename=="loadtransactionno")
{
    $tempid="NILL";
    $transactiondate=$_SESSION["trnsdate"];
    $tableid=json_decode($_POST["tableid"], true);
    $exec=mysqli_query($connection,"SELECT * FROM `tblcart` WHERE transno like '$transactiondate%' ORDER BY `tblcart`.`transno` ASC");
    if(mysqli_num_rows($exec)>0){
        $row= mysqli_fetch_all($exec, MYSQLI_ASSOC);
        foreach ($row as $item) {
            if($row['0'])
            {
                $tempid=$item["transno"];
            }
            if($item["tableno"]==$tableid&&($item["status"]=="Pending"||$item["status"]=="Printed"))
            {
                echo $item["transno"];
                exit();
            }
        }
        echo $tempid+1;
    }
    else{
        echo $_SESSION["trnsdate"]."0001";
    }
}
else if($dbtablename=="addprodut")
{
    $date=$_SESSION["date"];
    $user=$_SESSION["username"];
    $itemid=json_decode($_POST["itemid"], true);
    $quantity=json_decode($_POST["quantity"], true);
    $price=json_decode($_POST["price"], true);
    $tableid=json_decode($_POST["tableid"], true);
    $transactionno=json_decode($_POST["transactionno"], true);
    $total=$price*$quantity;
    $stock=mysqli_fetch_row(mysqli_query($connection,"SELECT * FROM `tblproduct` WHERE id='$itemid'"))[4];
    if($stock!='-1'&&$quantity>$stock)
    {
        echo $stock;
    }
    else
    {
        echo '-2';
        if(mysqli_fetch_row(mysqli_query($connection,"SELECT COUNT(*) FROM tblcart WHERE transno=$transactionno AND pid=$itemid AND status='Pending'"))[0]>0)
        {
            mysqli_query($connection,"UPDATE tblcart SET qty=qty+$quantity WHERE transno=$transactionno AND pid=$itemid");
            mysqli_query($connection,"UPDATE tblcart SET total=price*qty WHERE transno=$transactionno AND pid=$itemid");
            mysqli_query($connection,"UPDATE tblcart SET status='Pending' WHERE transno=$transactionno AND pid=$itemid");
            if(mysqli_fetch_row(mysqli_query($connection,"SELECT * FROM `tblproduct` WHERE id='$itemid'"))[4]>=0)
            {
                mysqli_query($connection,"UPDATE `tblproduct` SET `stock` = stock-$quantity WHERE `tblproduct`.`id` = $itemid");
            }
        }
        else
        {
            mysqli_query($connection,"INSERT INTO `tblcart` (`transno`, `pid`, `price`, `tdate`, `tableno`, `qty`, `user`, `total`) VALUES ('$transactionno', '$itemid', '$price', '$date', '$tableid', '$quantity', '$user', '$total')");
            if(mysqli_fetch_row(mysqli_query($connection,"SELECT * FROM `tblproduct` WHERE id='$itemid'"))[4]>=0)
            {
                mysqli_query($connection,"UPDATE `tblproduct` SET `stock` = stock-$quantity WHERE `tblproduct`.`id` = $itemid");
            }
        }
    }
}
else if($dbtablename=="showcart") {
    $transactionno = json_decode($_POST["transactionno"], true);
    $exec = mysqli_query($connection, "SELECT c.id, p.name, p.price, c.qty, c.total FROM tblcart AS c INNER JOIN tblproduct AS p ON p.id = c.pid WHERE c.transno LIKE $transactionno");
    if (mysqli_num_rows($exec) > 0) {
        $row = mysqli_fetch_all($exec, MYSQLI_ASSOC);
        foreach ($row as $data) {
            echo "                  <tr>
                                    <td class='text-truncate' style='max-width: 200px;'>" . $data['name'] . "</td>
                                    <td class='text-truncate' style='max-width: 100px;'>" . intval($data['price']) . "</td>
                                    <td class='text-truncate' style='max-width: 100px;'>" . intval($data['qty']) . "</td>
                                    <td class='text-truncate total-price' style='max-width: 100px;'>" . intval($data['total']) . "</td>
                                    <td class='text-center'>
                                    <button class='btn btn-sm' type='button' data-id='" . $data['id'] . "' data-name='" . $data['name'] . "' data-bs-toggle='modal' data-bs-target='#deleteitem'><i class='fa fa-trash fs-5 text-danger'></i>
                                    </button>
                                    </td>
                                    </tr>
                              ";
        }
    } else {

    }
}
else if($dbtablename=="deletecartitem")
{

    $tableid=json_decode($_POST["deleteid"], true);
    $row=mysqli_fetch_row(mysqli_query($connection,"SELECT * FROM `tblcart` WHERE id='$tableid'"));
    $qty=$row[6];
    $pid=$row[2];
    if(mysqli_fetch_row(mysqli_query($connection,"SELECT * FROM `tblproduct` WHERE id='$pid'"))[4]>=0)
    {

        mysqli_query($connection,"UPDATE `tblproduct` SET `stock` = stock+$qty WHERE `tblproduct`.`id` = $pid");
    }
    $query="DELETE FROM `tblcart` WHERE `tblcart`.`id` = $tableid";
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        if (mysqli_query($connection, $query)) {
            echo "success";
        } else {
            echo "error";
        }
    } catch (mysqli_sql_exception $e) {
        echo $e;
    }
}
else if($dbtablename=="acceptpayment")
{
    $transactionno=json_decode($_POST["transactionno"], true);
    $table=json_decode($_POST["table"], true);
    $total=json_decode($_POST["total"], true);
    $cashier=$_SESSION["name"];
    $sdate=$_SESSION["date"];
    $stime=json_decode($_POST["time"], true);
    $transactionno=json_decode($_POST["transactionno"], true);
    $query="INSERT INTO tblsales(transno, total, sdate, stime, cashier)values('$transactionno', '$total', '$sdate', '$stime', '$cashier')";
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        if (mysqli_query($connection, $query)) {
            $query = "UPDATE tblcart SET status= 'Completed' where transno like '$transactionno'";
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
            try {
                if (mysqli_query($connection, $query)) {
                    if(mysqli_num_rows(mysqli_query($connection,"SELECT * FROM `tblstart` WHERE status = 'Open'")))
                        echo "success";
                }
            }
            catch (mysqli_sql_exception $e) {
                echo $e;
            }
        } else {
            echo "error";
        }
    } catch (mysqli_sql_exception $e) {
        echo $e;
    }
}
else if($dbtablename=="endofday")
{
    $exec=mysqli_query($connection,"SELECT * FROM tblcart WHERE status!='Completed'");
    if(mysqli_num_rows($exec)>0){
        echo "error";
    }else {
        if (mysqli_query($connection,"UPDATE tblstart SET status= 'Closed' where status like 'Open'")) {
            echo "success";
            unset($_SESSION["trnsdate"]);
            unset($_SESSION["date"]);
        }
        else
        {
            echo "error";
        }
    }
}
else if($dbtablename=="checkday")
{
    if(mysqli_num_rows(mysqli_query($connection,"SELECT * FROM `tblstart` WHERE status = 'Open'"))>0)
    {

    }
    else{
        echo "closed";
    }
}
else if($dbtablename=="readsales")
{
    $date=mysqli_fetch_row((mysqli_query($connection,"SELECT * FROM `tblstart` ORDER BY `tblstart`.`sdate` DESC")))[1];
    $sale=mysqli_fetch_row(mysqli_query($connection,"SELECT ifnull(sum(total),0) as total from tblcart where tdate between '$date' and '$date'"))[0];
    $initialcash=mysqli_fetch_row(mysqli_query($connection,"SELECT * FROM `tblstart` WHERE sdate LIKE '$date'"))[2];
    $tdate = str_replace('-', '', $date);
    $discount=mysqli_fetch_row(mysqli_query($connection,"SELECT SUM(discount) FROM `tbldiscount` WHERE transno LIKE '$tdate%'"))[0];
    $container_arr = array();
    $arr = array(
        'date' =>  $date,
        'initialcash'  => $initialcash,
        'sale'  => $sale,
        'discount'  => $discount,
        'total' => ($sale+$initialcash)-$discount
    );
    array_push(  $container_arr, (array)$arr );
    echo json_encode($container_arr);

}
else if($dbtablename=="salesofdaytable")
{
    $dateofsale=json_decode($_POST["date"], true);
    $tdate = str_replace('-', '', $dateofsale);
    $discount=mysqli_fetch_row(mysqli_query($connection,"SELECT SUM(discount) FROM `tbldiscount` WHERE transno LIKE '$tdate%'"))[0];
    $exec = mysqli_query($connection, "SELECT c.id, c.transno, c.pid, p.name, c.price, c.qty, c.total, c.tableno FROM tblcart AS c INNER JOIN tblproduct AS p ON p.id = c.pid WHERE c.tdate between '$dateofsale' AND '$dateofsale' AND c.status LIKE 'Completed';");

    if (mysqli_num_rows($exec) > 0) {
        $discount=0;
        $row = mysqli_fetch_all($exec, MYSQLI_ASSOC);
        $i=0;
        $totalsale=0;
        $totalitems=0;
        foreach ($row as $data) {
            $i++;
            $totalsale+=$data['total'];
            $totalitems+=$data['qty'];
            echo "                  <tr>
                                    <td>$i</td>
                                    <td colspan='2' class='text-truncate' style='max-width: 200px;'>" . $data['transno'] . "</td>
                                    <td colspan='2' class='text-truncate' style='max-width: 200px;'>" . $data['tableno'] . "</td>
                                    <td colspan='2' class='text-truncate' style='max-width: 200px;'>" . $data['name'] . "</td>
                                    <td class='text-truncate' style='max-width: 200px;'>" . $data['price'] . "</td>
                                    <td class='text-truncate' style='max-width: 200px;'>" . $data['qty'] . "</td>
                                    <td class='text-truncate' style='max-width: 200px;'>" . $data['total'] . "</td>
                                    </tr>
                              ";
        }
        $grandtotal=$totalsale-$discount;
        echo "  <td colspan='8' class='text-dark'>SUB TOTAL</td>
                <td>$totalitems</td>
                <td>$totalsale</td>
                </tr>
                <tr>
                <td colspan='8' class='text-dark'>DISCOUNT</td>
                <td></td>
                <td>$discount</td>
                </tr>
                <tr>
                <tr>
                <td colspan='8' class='text-dark'>GRAND TOTAL</td>
                <td></td>
                <td>$grandtotal</td>
                </tr>
                <tr>
                                    
        ";
        echo "</tbody></table>";
    } else {

    }

}
else if($dbtablename=="refunditems")
{
    $datecheck=$_SESSION["date"];
    $exec=mysqli_fetch_all(mysqli_query($connection,"SELECT c.id, c.transno, c.pid, p.name, c.price, c.qty, c.total, c.tableno FROM tblcart AS c INNER JOIN tblproduct AS p ON p.id = c.pid WHERE c.tdate between '$datecheck' AND '$datecheck' AND c.status LIKE 'Completed';"), MYSQLI_ASSOC);
    sohw_refunditems($exec);
}
else if($dbtablename=="discountadd")
{
    $discount=json_decode($_POST["discount"], true);
    $transno=json_decode($_POST["transno"], true);
    if(mysqli_num_rows(mysqli_query($connection,"SELECT * FROM `tbldiscount` WHERE transno LIKE '$transno'"))>0)
    {
        $exec=mysqli_query($connection, "UPDATE `tbldiscount` SET `discount` = '$discount' WHERE `tbldiscount`.`transno` = '$transno'");
    }
    else{
        $exec=mysqli_query($connection, "INSERT INTO `tbldiscount` ( `transno`, `discount`) VALUES ('$transno','$discount')");
    }

}
else if($dbtablename=="checkdiscount")
{
    $container_arr = array();
    $transno=json_decode($_POST["transno"], true);
    $exec=mysqli_query($connection,"SELECT * FROM `tbldiscount` WHERE transno LIKE '$transno'");
    if(mysqli_num_rows($exec)>0)
    {
        $exec=mysqli_fetch_row($exec);
        $discount=$exec[2];
        if($discount==null||$discount=='0'||$discount=='')
        {
            echo "-1";
        }
        else{
            echo $discount;
        }
    }
}

?>