<?php
include 'includes/sqlconnect.php';
if ($_POST) {
    // CATEGORY TABLE SUBMIT
    if(isset($_POST["tableno"]))
    {
        $updateid=json_decode($_POST["tupdateid"]);
        $tbleno = json_decode($_POST["tableno"], true);
        if($updateid==-1)
        {
            $query = "INSERT INTO `tbltable` (`tableno`) VALUES ('" . $tbleno . "')";
        }
        else
        {
            $query = "UPDATE `tbltable` SET `tableno` = '$tbleno' WHERE `tbltable`.`tableno` = '$updateid'";
        }
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
        try {
            if (mysqli_query($connection, $query)) {
                echo "success";
            } else {
                echo "error";
            }
        } catch (mysqli_sql_exception $e) {
            echo "exist";
        }
    } // CATEGORY SUBMIT
    elseif (isset($_POST["category"]))
    {
        $updateid=json_decode($_POST["cupdateid"]);
        $category = json_decode($_POST["category"], true);
        if($updateid==-1)
        {
            $query = "INSERT INTO `tblcategory` (`category`) VALUES ('" . $category . "')";
        }
        else
        {
            $query = "UPDATE `tblcategory` SET `category` = '$category' WHERE `tblcategory`.`category` = '$updateid'";
        }
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
        try {
            if (mysqli_query($connection, $query)) {
                echo "success";
            } else {
                echo "error";
            }
        } catch (mysqli_sql_exception $e) {
            echo "exist";
        }
    }// PRODUCT SUBMIT
    elseif (isset($_POST["txtproduct"])) {
        $name=$_POST['txtproduct'];
        $category=$_POST['txtcategory'];
        $price=$_POST['txtprice'];
        $status=$_POST['txtstatus'];
        $stock=$_POST['stock'];
        $productid=$_POST["productid"];
        if($productid==-1)
        {
            $query = "INSERT INTO `tblproduct` (`name`, `price`, `category`, `stock`, `status`, `image`) VALUES ('" . $name . "','" . $price . "','" . $category . "' ,'" . $stock . "','" . $status . "','" . uploadproductimage($name) . "')";
        }
        else
        {

            if(empty($_FILES['ProductPicutre']['name']))
            {
                $query = "UPDATE `tblproduct` SET `name` = '$name', `price` = '$price', `category` = '$category', `stock` = '$stock', `status` = '$status' WHERE `tblproduct`.`id` = $productid";
            }
            else
            {
                $pictureupload=uploadproductimage($name);
                $query = "UPDATE `tblproduct` SET `name` = '$name', `price` = '$price', `category` = '$category', `stock` = '$stock', `status` = '$status', `image` = '$pictureupload' WHERE `tblproduct`.`id` = $productid";
            }
            }
       mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
        try {
            if (mysqli_query($connection, $query)) {
                echo "success";
            } else {
                echo "error";
            }
        } catch (mysqli_sql_exception $e) {
            echo "exist";
            echo $query;
        }

    }

    // DELETESUBMIT
    if(isset($_POST["deleteitem"]))
    {
        $deleteitem=json_decode($_POST["deleteitem"]);
        $deleteitemtype = json_decode($_POST["deleteitemtype"], true);
        if($deleteitemtype=='table')
        {
            $query = "DELETE FROM `tbltable` WHERE `tbltable`.`tableno` = '$deleteitem'";
        }
        else if($deleteitemtype=='category')
        {
            $query = "DELETE FROM `tblcategory` WHERE `tblcategory`.`category` = '$deleteitem'";
        }
        else if($deleteitemtype=='product')
        {
            $query = "DELETE FROM `tblproduct` WHERE `tblproduct`.`id` = $deleteitem";
        }
        else if($deleteitemtype=='user')
        {
            $query = "DELETE FROM `tbluser` WHERE `tbluser`.`username` = '$deleteitem'";
        }
        else if($deleteitemtype=='coupon')
        {
            $query = "DELETE FROM `tblcoupon` WHERE `tblcoupon`.`id` = '$deleteitem'";
        }
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
}
// USER CREATION AND  UPDATE
if(isset($_POST["username"]))
{
    $name=json_decode($_POST["name"]);
    $username=json_decode($_POST["username"]);
    $role=json_decode($_POST["role"]);
    $password=json_decode($_POST["pass"]);
    $id=json_decode($_POST["productid"]);
    if($id==-1)
    {
        $query="INSERT INTO `tbluser` (`username`, `password`, `name`, `role`) VALUES ('$username', MD5('$password'), '$name', '$role')";
    }
    else
    {
        $query="UPDATE `tbluser` SET `username` = '$username', `password` = MD5('$password'), `name` = '$name', `role` = '$role' WHERE `tbluser`.`username` = '$username'";
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        if (mysqli_query($connection, $query)) {
            echo "success";
        } else {
            echo "error";
        }
    } catch (mysqli_sql_exception $e) {
        echo "exist";
    }
}
// COUPON UPDATE AND ADD
if(isset($_POST["couponid"])) {
    $couponid = json_decode($_POST["couponid"]);
    $coupon = json_decode($_POST["coupon"]);
    $percentage = json_decode($_POST["percentage"]);
    $user = json_decode($_POST["user"]);
    if($couponid==-1)
    {
        $query = "INSERT INTO `tblcoupon` (`user`, `coupon`, `percentage`) VALUES ('$user', '$coupon', '$percentage')";
    }
    else
    {
        $query="UPDATE `tblcoupon` SET `user` = '$user', `coupon` = '$coupon', `percentage` = '$percentage' WHERE `tblcoupon`.`id` = $couponid";
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        if (mysqli_query($connection, $query)) {
            echo "success";
        } else {
            echo "error";
        }
    } catch (mysqli_sql_exception $e) {
        echo "exist";
    }
}
function uploadproductimage($name)
{
    $uploaddir = 'content/productimages/';
    $extension= pathinfo($_FILES['ProductPicutre']['name']);
    $uniqueid=substr(uniqid(rand(), true), 1, 4);
    $uploadfile = $uploaddir.$uniqueid.'-'.$name.'.'.$extension['extension'];
    if (move_uploaded_file($_FILES['ProductPicutre']['tmp_name'], $uploadfile)) {
    return $uploadfile;
    } else {
        echo "error";
        exit();
    }
}