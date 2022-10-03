<?php
include "includes/sqlconnect.php";
function fetch_data($table,$connection){
    if($table=="tblcategory"or $table=="tbltable"or $table=="tbluser")
    {
        $exec=mysqli_query($connection, "SELECT * from ".$table);
    }
    elseif ($table=="tblsales")
    {
        $exec=mysqli_query($connection, "SELECT * FROM `vwcart` WHERE status='Completed'");
    }
    else
    {
        $exec=mysqli_query($connection, "SELECT * from ".$table." ORDER BY id DESC");
    }

    if(mysqli_num_rows($exec)>0){
        $row= mysqli_fetch_all($exec, MYSQLI_ASSOC);
        return $row;
    }else{
        return $row=[];
    }
}
function tablehelper($id)
{
    ?>
    <script>
        if('<?php echo $id?>'!='#tablesales')
        {
            var option={columns:':visible:not(:last-child)'};
        }

        $('<?php echo $id?>').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                { extend: 'csv', text: '<i class="text-dark fas fa-file-csv"></i> CSV',exportOptions: option,footer: true},
                { extend: 'excel', text: '<i class="text-dark fas fa-file-excel"></i> Excel',exportOptions: option,footer: true},
                { extend: 'pdf', text: '<i class="text-dark fas fa-file-pdf"></i> PDF',exportOptions: option,footer: true},
                { extend: 'print', text: '<i class="text-dark fas fa-print"></i> Print',exportOptions: option,footer: true}
            ]
        } );
    </script>
    <?php

}

function show_product($fetchData){
    $id="tableproduct";
    echo "<table class='table table-hover text-black' id='$id'>
        <thead>
        <tr>
        <th>No</th>
        <th>Name</th>
        <th>Price</th>
        <th>Category</th>
        <th>Stock</th>
        <th>Status</th>
        <th class='text-center'>Actions</th>
        </tr>
        </thead>
        <tbody>";
    if(count($fetchData)>0){
        $sn=1;
        foreach($fetchData as $data){
            $stock="";
            if($data['stock']==-1)
            {$stock="DISABLED";}
            else{$stock=$data['stock'];}
            echo "
                    <tr>
                        <td>".$sn."</td>
                        <td class='text-truncate' style='max-width: 200px;'>".$data['name']."</td>
                        <td class='text-truncate' style='max-width: 200px;'>".$data['price']."</td>
                        <td class='text-truncate' style='max-width: 200px;'>".$data['category']."</td>
                        <td class='text-truncate' style='max-width: 200px;'>".$stock."</td>
                        <td class='text-truncate' style='max-width: 200px;'>".$data['status']."</td>
                        <td class='text-center'>
                            <button class='btn btn-sm' type='button' data-id='".$data['id']."' data-name='".$data['name']."' data-price='".$data['price']."' data-category='".$data['category']."' data-stock='".$data['stock']."' data-image='".$data['image']."' data-status='".$data['status']."' data-bs-toggle='modal' data-bs-target='#productmodal'><i
                                        class='fas fa-edit fs-5 text-primary'></i></button>
                            <button class='btn btn-sm' type='button' data-type='product' data-id='".$data['id']."' data-name='".$data['name']."' data-bs-toggle='modal' data-bs-target='#delete'><i
                                        class='fa fa-trash fs-5 text-primary'></i></button>
                        </td>
                    </tr>
          ";
            $sn++;
        }
    }else{
        echo "<tr>
        <td colspan='7'>No Data Found</td>
       </tr>";
    }
    echo "</table>";
    $id="#".$id;
    tablehelper($id);
}
function show_category($fetchData){
    $id="tablecategory";
    echo "<table class='table table-hover text-black' id='$id'>
        <thead>
        <tr>
        <th>Category</th>
        <th class='text-end'>Actions</th>
        </tr>
        </thead>
        <tbody>";
    if(count($fetchData)>0){
        $sn=1;
        foreach($fetchData as $data){
            echo "
                    <tr>
                        <td class='text-truncate' style='max-width: 200px;'>".$data['category']."</td>
                       <td class='text-end'>
                            <button class='btn btn-sm' type='button' data-category='".$data['category']."' data-bs-toggle='modal' data-bs-target='#categorymodal'><i
                                        class='fas fa-edit fs-5 text-primary'></i></button>
                            <button class='btn btn-sm' type='button' data-type='category' data-category='".$data['category']."' data-bs-toggle='modal' data-bs-target='#delete'><i
                                        class='fa fa-trash fs-5 text-primary'></i></button>
                        </td>
                    </tr>
          ";
            $sn++;
        }
    }else{
        echo "<tr>
        <td colspan='3'>No Data Found</td>
       </tr>";
    }
    echo "</table>";
    $id="#".$id;
    tablehelper($id);
}
function show_tables($fetchData){
    $id="tabletable";
    echo "<table class='table table-hover text-black' id='$id'>
        <thead>
        <tr>
        <th>Table</th>
        <th class='text-end'>Actions</th>
        </tr>
        </thead>
        <tbody>";
    if(count($fetchData)>0){
        $sn=1;
        foreach($fetchData as $data){
            echo "
                    <tr>
                        <td class='text-truncate' style='max-width: 200px;'>".$data['tableno']."</td>
                       <td class='text-end'>
                            <button class='btn btn-sm btn-modal' id='update' type='button' data-table='".$data['tableno']."' data-bs-toggle='modal' data-bs-target='#tabelmodal'><i
                                        class='fas fa-edit fs-5 text-primary'></i></button>
                            <button class='btn btn-sm' type='button' data-type='table' data-table='".$data['tableno']."' data-bs-toggle='modal' data-bs-target='#delete'><i
                                        class='fa fa-trash fs-5 text-primary'></i></button>
                        </td>
                    </tr>";
            $sn++;
        }
    }else{
        echo "<tr>
        <td colspan='3'>No Data Found</td>
       </tr>";
    }
    echo "</table>";
    $id="#".$id;
    tablehelper($id);
}
//SHOW USERS TABLE
function show_users($fetchData){
    $id="tableusers";
    echo "<table class='table table-hover text-black' id='$id'>
        <thead>
        <tr>
        <th>No</th>
        <th>Username</th>
        <th>Name</th>
        <th>Role</th>
        <th class='text-center'>Actions</th>
        </tr>
        </thead>
        <tbody>";
    if(count($fetchData)>0){
        $sn=1;
        foreach($fetchData as $data){
            echo "
                    <tr>
                        <td>".$sn."</td>
                        <td class='text-truncate' style='max-width: 200px;'>".$data['username']."</td>
                        <td class='text-truncate' style='max-width: 200px;'>".$data['name']."</td>
                        <td class='text-truncate' style='max-width: 200px;'>".$data['role']."</td>
                        <td class='text-center'>
                            <button class='btn btn-sm' type='button' data-id='1' data-username='".$data['username']."' data-name='".$data['name']."' data-role='".$data['role']."' data-bs-toggle='modal' data-bs-target='#updateuser'><i
                                        class='fas fa-edit fs-5 text-primary'></i></button>
                            <button class='btn btn-sm' type='button' data-username='".$data['username']."' data-name='".$data['name']."' data-bs-toggle='modal' data-bs-target='#delete'><i
                                        class='fa fa-trash fs-5 text-primary'></i></button>
                        </td>
                   </tr>
          ";
            $sn++;
        }
    }else{
        echo "<tr>
        <td colspan='3'>No Data Found</td>
       </tr>";
    }
    echo "</table>";
    $id="#".$id;
    tablehelper($id);
}
//SHOW COUPONS TABLE
function show_coupons($fetchData){
    $id="tablecoupon";
    echo "<table class='table table-hover text-black' id='$id'>
        <thead>
        <tr>
        <th>No</th>
        <th>Generated By</th>
        <th>Coupon Code</th>
        <th>Percentage</th>
        <th class='text-center'>Actions</th>
        </tr>
        </thead>
        <tbody>";
    if(count($fetchData)>0){
        $sn=1;
        foreach($fetchData as $data){
            echo "
                    <tr>
                        <td>".$sn."</td>
                        <td class='text-truncate' style='max-width: 200px;'>".$data['user']."</td>
                        <td class='text-truncate' style='max-width: 200px;'>".$data['coupon']."</td>
                        <td class='text-truncate' style='max-width: 200px;'>".$data['percentage'].'%'."</td>
                        <td class='text-center'>
                            <button class='btn btn-sm' type='button' data-id='".$data['id']."' data-user='".$data['user']."' data-coupon='".$data['coupon']."' data-percentage='".$data['percentage']."' data-bs-toggle='modal' data-bs-target='#updatecoupon'><i
                                        class='fas fa-edit fs-5 text-primary'></i></button>
                            <button class='btn btn-sm' type='button' data-id='".$data['id']."' data-coupon='".$data['coupon']."' data-bs-toggle='modal' data-bs-target='#delete'><i
                                        class='fa fa-trash fs-5 text-primary'></i></button>
                        </td>
                   </tr>
          ";
            $sn++;
        }
    }else{
        echo "<tr>
        <td colspan='5'>No Data Found</td>
       </tr>";
    }
    echo "</table>";
    $id="#".$id;
    tablehelper($id);
}
function show_sales($fetchData,$discount)
{
    $sales=0;
    $boolean=false;
    $id="tablesales";
    echo "<table class='table table-hover text-black' id='$id'>
        <thead>
        <tr>
        <th>#</th>
        <th>Trans No</th>
        <th>Tbl#</th>
        <th>Name</th>
        <th>Price</th>
        <th>Qty</th>
        <th>DISC</th>
        <th>Total</th>
        <th>Cashier</th>
        <th>Date</th>
        </tr>
        </thead>
        <tbody>";
    if(count($fetchData)>0){

        $boolean=true;
        $sn=1;
        foreach($fetchData as $data){
            $sales+=$data['total'];
            echo "
                    <tr>
                                    <td>$sn</td>
                                    <td class='text-truncate' style='max-width: 200px;'>".$data['transno']."</td>
                                     <td class='text-truncate' style='max-width: 150px;'>".$data['tableno']."</td>
                                    <td class='text-truncate' style='max-width: 150px;'>".$data['name']."</td>
                                    <td>".$data['price']."</td>
                                    <td>".$data['qty']."</td>
                                    <td>0</td>
                                    <td>".$data['total']."</td>
                                    <td>".$data['user']."</td>
                                    <td class='text-truncate' style='max-width: 200px;'>".$data['tdate']."</td>
                   </tr>
          ";
            $sn++;
        }
    }else{
        echo "<tr>
        <td colspan='8'>No Data Found</td>
       </tr>";
    }
    echo "</tbody>
                <tfoot>
                <tr>
                <td class='text-white'></td>
                <td class='text-truncate' style='max-width: 200px;'>DISCOUNT</td>
                <td colspan='5'></td>
                <td>$discount</td>
                <td colspan='2'></td>
                </tr>
                <tr>
                <td class='text-white'></td>
                <td class='text-truncate' style='max-width: 200px;'>TOTAL</td>
                <td colspan='5'></td>
                <td>$sales</td>
                <td colspan='2'></td>
                </tr>
                </tfoot>
                </table>
          ";

    $id="#".$id;
    if($boolean)
    {
        tablehelper($id);
    }
}
function show_log($fetchData)
{
    $boolean=false;
    $id="tablelog";
    echo "<table class='table table-hover text-black' id='$id'>
        <thead>
        <tr>
        <th>#</th>
        <th>User</th>
        <th>Date</th>
        <th>TIME IN</th>
        <th>TIME OUT</th>
        <th>Status</th>
        </tr>
        </thead>
        <tbody>";
    if(count($fetchData)>0){
        $boolean=true;
        $sn=1;
        foreach($fetchData as $data){
            echo "
                    <tr>
                                    <td>$sn</td>
                                    <td class='text-truncate' style='max-width: 200px;'>".$data['user']."</td>
                                    <td class='text-truncate' style='max-width: 200px;'>".$data['sdate']."</td>
                                    <td>".$data['timein']."</td>
                                    <td>".$data['timeout']."<br></td>
                                    <td>".$data['status']."</td>
                   </tr>
          ";
            $sn++;
        }
    }else{
        echo "<tr>
        <td colspan='8'>No Data Found</td>
       </tr>";
    }

    echo "</tbody></table>";
    $id="#".$id;
    if($boolean)
    {
        tablehelper($id);
    }
}
function show_bestselling($fetchData)
{
    $boolean=false;
    $id="tablebestselling";
    echo "<table class='table table-hover text-black' id='$id'>
        <thead>
        <tr>
        <th>#</th>
        <th>Name</th>
        <th>Price</th>
        <th>Order</th>
        <th>Total</th>
        </tr>
        </thead>
        <tbody>";
    if(count($fetchData)>0){
        $boolean=true;
        $sn=1;
        foreach($fetchData as $data){
            echo "

                    <tr>
                                    <td class='text-truncate' style='max-width: 200px;'>$sn</td>
                                    <td class='text-truncate' style='max-width: 200px;'>".$data['name']."</td>
                                    <td>".$data['price']."</td>
                                    <td>".$data['qty']."</td>
                                    <td>".$data['total']."</td>
                   </tr>
          ";
            $sn++;
        }
    }else{
        echo "<tr>
        <td colspan='8'>No Data Found</td>
       </tr>";
    }

    echo "</tbody></table>";
    $id="#".$id;
    if($boolean)
    {
        tablehelper($id);
    }
}
$dbtablename=json_decode($_POST["table"], true);
if($dbtablename=="tblproduct")
{
    $fetchData= fetch_data("tblproduct",$connection);
    show_product($fetchData);
}
elseif($dbtablename=="tblcategory")
{
    $fetchData= fetch_data("tblcategory",$connection);
    show_category($fetchData);
}
elseif($dbtablename=="tbltable")
{
    $fetchData= fetch_data("tbltable",$connection);
    show_tables($fetchData);
}
elseif($dbtablename=="tbluser")
{
    $fetchData= fetch_data($dbtablename,$connection);
    show_users($fetchData);
}
elseif($dbtablename=="tblcoupon")
{
    $fetchData= fetch_data($dbtablename,$connection);
    show_coupons($fetchData);
}
elseif($dbtablename=="categorydropdown")
{
    $fetchData= fetch_data('tblcategory',$connection);
    echo $fetchData;
}
elseif($dbtablename=="tblsales")
{
    $fetchData= fetch_data($dbtablename,$connection);
    $startdate=json_decode($_POST["startdate"], true);
    $enddate=json_decode($_POST["enddate"], true);
    $exec=mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM `vwcart` WHERE status='Completed' AND tdate BETWEEN '$startdate' AND '$enddate'"),MYSQLI_ASSOC);
    $stdate = str_replace('-', '', $startdate);
    $etdate = str_replace('-', '', $enddate);
    $stdate =$stdate.'0000';
    $etdate = $etdate.'9999';
    $discount=mysqli_fetch_row(mysqli_query($connection,"SELECT IFNULL(SUM(discount),0) FROM `tbldiscount` WHERE transno BETWEEN '$stdate' AND '$etdate'"))[0];
    show_sales($exec,$discount);
}
elseif($dbtablename=="tbllog")
{
    $startdate=json_decode($_POST["startdate"], true);
    $enddate=json_decode($_POST["enddate"], true);
    $exec=mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM `tbllog` WHERE sdate BETWEEN '$startdate' AND '$enddate'"),MYSQLI_ASSOC);
    show_log($exec);
}
elseif($dbtablename=="tblbestselling")
{
    $startdate=json_decode($_POST["startdate"], true);
    $enddate=json_decode($_POST["enddate"], true);
    $exec=mysqli_fetch_all(mysqli_query($connection, "SELECT distinct name, price, ifnull(sum(qty),0) as qty, ifnull(sum(total),0) as total from vwcart WHERE tdate BETWEEN '$startdate' AND '$enddate' group by name order by qty desc,total desc"),MYSQLI_ASSOC);
    show_bestselling($exec);
}
?>