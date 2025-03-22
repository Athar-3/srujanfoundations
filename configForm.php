<?php
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $dbHost = htmlspecialchars($_POST['dbHost']);
    $dbUser = htmlspecialchars($_POST['dbUser']);
    $dbPass = htmlspecialchars($_POST['dbPass']);
    $dbName = htmlspecialchars($_POST['dbName']);

    // Connect to the database using mysqli
    $connect = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

    if ($connect) {
        // Ensure dbConfig directory exists
        $dbConfigDir = dirname(__FILE__) . '/dbConfig';
        if (!is_dir($dbConfigDir)) {
            mkdir($dbConfigDir, 0777, true);
        }

        // Create database configuration file
        $dbConf = $dbConfigDir . '/dbconf.php';
        $handle = fopen($dbConf, 'w') or die('Cannot open file: ' . $dbConf);

        $data = "<?php\n";
        $data .= "\$userName = '$dbUser';\n";
        $data .= "\$passWord = '$dbPass';\n";
        $data .= "\$dbName = '$dbName';\n";
        $data .= "\$host = '$dbHost';\n";
        $data .= "?>";

        fwrite($handle, $data);
        fclose($handle);

        // Redirect to the main page after successful installation
        header('Location: index.php');
        exit(); // Stop further execution
    } else {
        $error = 'Database Connection Failed: ' . mysqli_connect_error();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSec Installation</title>
    <link rel="stylesheet" href="css/installation.css">
</head>
<body>
    <div class="install-header">
        <h1>EduSec Installation</h1>
    </div>

    <div class="container">
        <div class="content">
            <h2>Database Setup</h2>
            <p>Please enter your database details to proceed.</p>

            <form action="configForm.php" method="POST">
                <label for="dbHost">Host Name:</label>
                <input type="text" id="dbHost" name="dbHost" required>

                <label for="dbUser">Username:</label>
                <input type="text" id="dbUser" name="dbUser" required>

                <label for="dbPass">Password:</label>
                <input type="password" id="dbPass" name="dbPass">

                <label for="dbName">Database Name:</label>
                <input type="text" id="dbName" name="dbName" required>

                <input type="submit" value="Install">
            </form>

            <?php if ($error): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
