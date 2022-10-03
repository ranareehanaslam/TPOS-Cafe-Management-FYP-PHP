<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["role"] == "Cashier") {
    $url= basename($_SERVER['PHP_SELF']);
        if($url!="dashboard.php")
        {
            header("location: dashboard.php");
        }

}
elseif (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["role"] == "Admin")) {
    header("location: login.php");
}

