<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "TPOS";
global $connection;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
try {
    $connection = mysqli_connect($servername, $username, $password, $dbname);
    if(basename($_SERVER['PHP_SELF'])=="dberror.php")
    {
        header("location:login.php");
    }
    else
    {

    }
} catch (mysqli_sql_exception $e) {
    if(basename($_SERVER['PHP_SELF'])=="dberror.php")
    {

    }
    else
    {
        header("location:dberror.php");
    }

}

// Check connection
if ($connection === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>