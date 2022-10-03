<?php
include 'includes/sqlconnect.php';
include 'includes/sessoincheck.php';
?>
<style>
    .box{
        margin-top: 10px;
        padding-top: 50px;
        padding-bottom: 50px;
        font-size: 27px;
        font-weight: bold;
        text-align: center;
        background: #dbdfe5;
    }
    .fa-icons,.fa,.fas,.fa-solid{
        color: #146ebe !important;
    }
    a, a:hover, a:focus, a:active {
        text-decoration: none;
        color: inherit;
    }

</style>

<div class="container-fluid text-dark">
    <div class="row justify-content-center">
        <div class="col-xl-3 col-md-6 col-xxl-3"><a href='Management.php'><div class="box"><i class="fa-icons fas fa-tasks"></i>Management</div></a></div>
        <div class="col-xl-3 col-md-6 col-xxl-3"><a href='records.php'><div class="box"><i class="fa-icons fa-solid fa-list"></i> Records</div></a></div>
        <div class="col-xl-3 col-md-6 col-xxl-3"><a href='settings.php'><div class="box"><i class="fa-solid fa-gears"></i> Settings</div></a></div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-3 col-md-6 col-xxl-3"><a href='accounts.php'><div class="box"><i class="fa-icons fa-solid fa-user"></i> Accounts</div></a></div>
        <div class="col-xl-3 col-md-6 col-xxl-3"><a href='backup.php'><div class="box"><i class="fas fa-hdd"></i> Backup</div></a></div>
        <div class="col-xl-3 col-md-6 col-xxl-3"><a href='coupons.php'><div class="box"><i class="fa fa-gift"></i> Coupons</div></a></div>
    </div>
</div>
