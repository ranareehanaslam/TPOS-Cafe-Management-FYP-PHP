<!-- Header Include -->
<?php
include 'includes/header.php';
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["role"] == "Admin") {
    echo("<body class='bg-secondary text-white'>");
    include 'admindashboard.php';
} else if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["role"] == "Cashier") {
    echo("<body class='bg-white text-white'>");
    $exec=mysqli_query($connection,"SELECT * FROM `tblstart` WHERE status = 'Open'");
        if(mysqli_num_rows($exec)>0) {
            $row = mysqli_fetch_array($exec);
            $tdate = str_replace('-', '', $row["sdate"]);
            $_SESSION["trnsdate"]=$tdate;
            $_SESSION["date"]=$row["sdate"];
    }
    include 'cashierdashboard.php';
}
else
{
    header("location:logout.php");
}
?>

</body>
