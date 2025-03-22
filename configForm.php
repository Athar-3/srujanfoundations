<?php
$error = '';
if ($_POST) {
    // Connect to the database using mysqli
    $connect = mysqli_connect($_POST['dbHost'], $_POST['dbUser'], $_POST['dbPass'], $_POST['dbName']);

    if ($connect) {
        // Write database credentials to config file
        $dbConf = dirname(__FILE__).'/dbConfig/dbconf.php';
        $handle = fopen($dbConf, 'w') or die('Cannot open file: '.$dbConf);
        $data = '<?php $userName="'.$_POST['dbUser'].'";'."\n";
        $data .= '$passWord="'.$_POST['dbPass'].'";'."\n";
        $data .= '$dbName="'.$_POST['dbName'].'";'."\n";
        $data .= '$host="'.$_POST['dbHost'].'"; ?>';
        fwrite($handle, $data);
        header('Location: site/index'); 
        exit(); // Stop further execution
    } else {
        $error = 'Database Connection Failed: ' . mysqli_connect_error();
    }
}
?>
