<?php
include 'includes/header.php';
include 'includes/sqlconnect.php';
if(isset($_SESSION["loginid"]))
{
    $id=$_SESSION["loginid"];
    date_default_timezone_set("Asia/Karachi");
    $time=date('h:i:s A');
    $sql = mysqli_query($connection, "UPDATE `tbllog` SET `timeout` = '$time', `status` = 'Offline' WHERE `tbllog`.`id` = $id;");
}
$_SESSION["loggedin"] === false;
$_SESSION["role"] = "";
unset($_SESSION['loggedin']);
unset($_SESSION['role']);
unset($_SESSION['username']);
unset($_SESSION["name"]);
session_destroy();
header("location: login.php");
