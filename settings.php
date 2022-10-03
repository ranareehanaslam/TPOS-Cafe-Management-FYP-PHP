<?php
include 'includes/header.php';
require 'includes/sqlconnect.php';
include 'includes/sessoincheck.php';
$res = mysqli_query($connection, "SELECT * FROM tblsetting");
$row = mysqli_fetch_row($res)
?>
<div class="container text-black">
    <div class="row align-items-center justify-content-center">
        <div class="col-xl-10 col-xxl-9">
            <div class="card shadow">
                <div class="card-header d-flex flex-wrap justify-content-center align-items-center justify-content-sm-between gap-3">
                    <div class="col">
                        <h2 class="display-5 text-dark text-nowrap text-capitalize mb-0">Settings</h2>
                    </div>
                </div>
                <div class="card-body">
                    <form id="shopsettings" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3"><label class="form-label" for="shopname"><strong>Shop Name</strong><br></label>
                                    <input class="form-control" type="text" id="shopname" name="shopname" placeholder="Shop name" value="<?php echo $row[1]?>" required></div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label" for="header1"><strong>Header 1</strong></label>
                                    <input class="form-control" type="text" id="header1" name="header1" value="<?php echo $row[2]?>" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3"><label class="form-label" for="header2"><strong>Header 2</strong></label>
                                    <input class="form-control" type="text" id="header2" name="header2" value="<?php echo $row[3]?>" ></div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label" for="header3"><strong>Header 3</strong></label>
                                    <input class="form-control" type="text" id="header3" name="header3" value="<?php echo $row[4]?>"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3"><label class="form-label" for="header2"><strong>Header Logo</strong></label>
                                    <input class="form-control" type="file" id="hLogo" name="hLogo"  accept=".png"/>
                            </div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label" for="header3"><strong>Invoice Logo</strong></label>
                                    <input class="form-control" type="file" id="iLogo" name="iLogo"  accept=".png"/>
                            </div>
                        </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary btn-sm" type="submit">Save Settings</button>
                            <div class="<?php if(isset($messsage)){if($messsage=='success'){echo 'h2 p-1 text-center text-success';}else{echo 'h2 p-1 text-center text-danger';}}?>" id="response"><?php if(isset($messsage)){if($messsage=='success'){echo 'RECORD UPDATED SUCCESSFULLY';}else{echo 'UNABLE TO UPDATE RECORD';}}?></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if(isset($_POST["shopname"]))
{
$shopname=$_POST["shopname"];
$header1=$_POST["header1"];
$header2=$_POST["header2"];
$header3=$_POST["header3"];
$query="UPDATE `tblsetting` SET `shopname` = '$shopname', `h1` = '$header1', `h2` = '$header2', `h3` = '$header3' WHERE `tblsetting`.`id` = 1";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
try {
    if (mysqli_query($connection, $query)) {
        $messsage="success";
    } else {
        $messsage="error";
    }
} catch (mysqli_sql_exception $e) {
    $messsage="error";
}
if(isset($_FILES['hLogo']['name'])){
    move_uploaded_file($_FILES['hLogo']['tmp_name'], 'hLogo.png');
}

if(isset($_FILES['iLogo']['name'])){
    move_uploaded_file($_FILES['iLogo']['tmp_name'], 'iLogo.png');

}



}
?>