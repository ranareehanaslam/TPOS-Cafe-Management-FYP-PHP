<body class="bg-secondary">
<!-- Header Include -->
<?php
include 'includes/header.php';
include 'includes/sqlconnect.php';
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION["role"])) {
    header("location: dashboard.php");
} else {

}
?>

<div class="modal-signin py-5">
    <div class="modal-dialog">
        <div class="modal-content rounded-5 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <!-- <h5 class="modal-title">Modal title</h5> -->
                <h2 class="fw-bold mb-0 text-black">Login to CafePOS</h2>
                <br>
            </div>
            <div class="modal-body p-5 pt-0 text-black">
                <form class="" action="" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" name="username" class="form-control rounded-4" id="floatingInput" required placeholder="admin">
                        <label for="floatingInput">User Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control rounded-4" id="floatingPassword" required placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-4 btn-primary" type="submit">Login</button>
                </form>
                <div class="p-1 text-center text-danger fs-4" id="response"></div>
            </div>
        </div>
    </div>
</div>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate credentials
    // Prepare a select statement
    $pwd = md5($_POST["password"]);
    $sql = mysqli_query($connection, "SELECT * FROM tbluser WHERE username='" . $_POST["username"] . "' AND password='" . $pwd . "'");
    if ($sql->num_rows) {
        $row = mysqli_fetch_array($sql);
        $_SESSION["loggedin"] = true;
        $_SESSION["role"] = $row["role"];
        $username=$_SESSION["username"] = $row["username"];
        $_SESSION["name"] = $row["name"];
        date_default_timezone_set("Asia/Karachi");
        $date=date("Y-m-d");
        $time=date('h:i:s A');
        $sql = mysqli_query($connection, "INSERT INTO `tbllog` (`user`, `sdate`, `timein`, `timeout`, `status`) VALUES ( '$username', '$date', '$time', '', 'Online');");
        $sqlid = mysqli_insert_id($connection);
        $_SESSION["loginid"]=$sqlid;
        $row = mysqli_fetch_array(mysqli_query($connection, "SELECT * FROM tblsetting"));
        $_SESSION["shopname"]=$row["shopname"];
        $_SESSION["h1"]=$row["h1"];
        $_SESSION["h2"]=$row["h2"];
        $_SESSION["h3"]=$row["h3"];
        header("location:dashboard.php");
        exit();
    } else {
        echo "<script>
                const box = document.getElementById('response');
                const text = document.createTextNode('Invalid Login');
                box.appendChild(text);
                </script>";
    }

}

?>
<script src="./includes/js/bootstrap.bundle.min.js"></script>
</body>