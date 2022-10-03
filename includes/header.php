<?php
session_start();
include dirname(__FILE__) . '/sqlconnect.php';
$shopname=mysqli_fetch_row(mysqli_query($connection,"SELECT * FROM `tblsetting` "))[1];
?>
<head>
    <title>
        <?php echo $shopname;?> Cafe
    </title>
    <link rel="stylesheet" href="./includes/css/modals.css">
    <link rel="icon" href="./includes/images/favicon.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="./includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/css/headers.css">
    <link rel="stylesheet" href="./includes/fontawesome/css/all.css">
    <link rel="stylesheet" href="./includes/css/navbar.css">
    <link rel="stylesheet" href="./includes/css/tpos.css">
    <script src="./includes/js/bootstrap.bundle.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <style>
        html, body {
            height: 100%;
        }
    </style>
</head>
<body>
<!-- HEADER COP-->
<header style="top: 0 !important;z-index: 2020;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-0">
        <div class="container-fluid">
            <a class="navbar-brand" href="Dashboard.php"><?php echo $shopname; if(file_exists("./hLogo.png")){echo "<img src='./hLogo.png'style='margin-bottom:10px' alt='Logo' width='32'height='32'>";} ?>
            </a>
            <?php
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["role"] == "Admin") {
    echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">';
    echo '<span class="navbar-toggler-icon"></span>';
    echo '</button>';
}
            ?>


            <div class="collapse navbar-collapse" id="navbarsExample03">
                <ul class="navbar-nav ms-auto mb-2 mb-sm-0">
                    <?php
                    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["role"] == "Admin") {
                        echo("<li class='nav-item'><a class='nav-link active' href='dashboard.php'>Home</a></li>");
                        echo("<li class='nav-item'><a class='nav-link active' href='management.php'>Management</a></li>");
                        echo("<li class='nav-item'><a class='nav-link active' href='records.php'>Records</a></li>");
                        echo("<li class='nav-item'><a class='nav-link active' href='settings.php'>Settings</a></li>");
                        echo("<li class='nav-item'><a class='nav-link active' href='accounts.php'>Accounts</a></li>");
                        echo("<li class='nav-item'><a class='nav-link active' href='backup.php'>Backup</a></li>");
                        echo("<li class='nav-item'><a class='nav-link active' href='coupons.php'>Coupons</a></li>");
                        echo("<li class='nav-item'><a class='nav-link active' href='logout.php'>Logout</a></li>");
                    } elseif (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["role"] == "Cashier") {
                        echo("CASHIER | ").$_SESSION["name"];
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
</body>