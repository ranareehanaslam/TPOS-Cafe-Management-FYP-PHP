<?php
include 'includes/header.php';
require 'includes/sqlconnect.php';
include 'includes/sessoincheck.php';
?>
<div class="container">
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-bs-toggle="tab"
                                                        href="#tab-1">Backup DB</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-2">Restore
                    DB</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" role="tabpanel" id="tab-1">
                <div>
                    <form method="post">
                    <button class="btn btn-primary" type="submit" name="downloaddb">Download DB</button>
                    </form>
                </div>
            </div>
            <div class="tab-pane" role="tabpanel" id="tab-2">
                <form method="post" action="" enctype="multipart/form-data" id="restoredb">
                <div>
                    <label for="sqlupload" class="form-label">Backup File:</label>
                    <input class="form-control" type="file" id="sqlupload" name="sqlupload" required accept=".sql"/>
                    <button class="btn btn-primary" type="submit" name="uploaddb">Upload DB</button>
                </div>
                </form>
                <?php
                if (! empty($response)) {
                ?>
                <div class="response <?php echo $response["type"]; ?>
                ">
                <?php echo nl2br($response["message"]); ?>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$conn=$connection;
if(isset($_POST['downloaddb']))
{
    downloaddb($conn);
}
else if(isset($_POST['uploaddb']))
{
    uploaddb($conn);
}
function downloaddb($conn)
{
    {

        $database_name='tpos';
        $conn->set_charset("utf8");
        // Get All Table Names From the Database
        $tables = array();
        $sql = "SHOW TABLES";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }

        $sqlScript = "";
        foreach ($tables as $table) {

            // Prepare SQLscript for creating table structure
            $query = "SHOW CREATE TABLE $table";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($result);

            $sqlScript .= "\n\n" . $row[1] . ";\n\n";


            $query = "SELECT * FROM $table";
            $result = mysqli_query($conn, $query);

            $columnCount = mysqli_num_fields($result);

            // Prepare SQLscript for dumping data for each table
            for ($i = 0; $i < $columnCount; $i ++) {
                while ($row = mysqli_fetch_row($result)) {
                    $sqlScript .= "INSERT INTO $table VALUES(";
                    for ($j = 0; $j < $columnCount; $j ++) {
                        $row[$j] = $row[$j];

                        if (isset($row[$j])) {
                            $sqlScript .= '"' . $row[$j] . '"';
                        } else {
                            $sqlScript .= '""';
                        }
                        if ($j < ($columnCount - 1)) {
                            $sqlScript .= ',';
                        }
                    }
                    $sqlScript .= ");\n";
                }
            }

            $sqlScript .= "\n";
        }

        if(!empty($sqlScript))
        {
            // Save the SQL script to a backup file
            $backup_file_name = $database_name . '_backup_' . time() . '.sql';
            $fileHandler = fopen($backup_file_name, 'w+');
            $number_of_lines = fwrite($fileHandler, $sqlScript);
            fclose($fileHandler);
            // Download the SQL backup file to the browser
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($backup_file_name));
            ob_clean();
            flush();
            readfile($backup_file_name);
            exec('rm ' . $backup_file_name);
            unlink($backup_file_name);
        }
        else
        {
            echo '<script>alert("Unable To Genrate Backup")</script>';
        }
    }
}

function uploaddb($conn)
{
            if (is_uploaded_file($_FILES["sqlupload"]["tmp_name"])) {

            }
            else
            {
                echo('<div class="alert alert-danger alert-dismissible d-flex align-items-center fade show"><i class="bi-exclamation-octagon-fill"></i><strong>Error!</strong> Select SQL File<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                exit();
            }

    $conn2 =new mysqli('localhost', 'root', '');
    if ($conn2->query("Drop DATABASE tpos")) {
    }
    if ($conn2->errno) {
        echo('<div class="alert alert-danger alert-dismissible d-flex align-items-center fade show"><strong>Error!</strong> Problem in executing the SQL query' . $conn2->error. '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
        exit();
    }
    if ($conn2->query("CREATE Database tpos")) {
    }
    if ($conn2->errno) {
        echo('<div class="alert alert-danger alert-dismissible d-flex align-items-center fade show"><strong>Error!</strong> Problem in executing the SQL query' . $conn2->error. '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
        exit();
    }
    $query = '';
    $sqlScript=file(realpath(($_FILES["sqlupload"]["name"])));
    //$sqlScript = file(file_get_contents($_FILES["sqlupload"]["tmp_name"]));
    foreach ($sqlScript as $line)	{

        $startWith = substr(trim($line), 0 ,2);
        $endWith = substr(trim($line), -1 ,1);

        if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
            continue;
        }

        $query = $query . $line;
        if ($endWith == ';') {
            mysqli_query($conn,$query) or die('<div class="alert alert-danger alert-dismissible d-flex align-items-center fade show"><strong>Error!</strong> Problem in executing the SQL query' . $query. '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
            $query= '';
        }
    }
    echo '<div class="alert alert-success alert-dismissible fade show"><strong>Success!</strong> SQL file imported successfully.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
}
?>