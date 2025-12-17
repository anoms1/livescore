<?php
// update-config.php - Quick config update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $database = $_POST['database'];
    
    $config_content = '<?php
// XtraBet LiveScore - Database Configuration
$db_host = \'' . addslashes($host) . '\';
$db_user = \'' . addslashes($username) . '\';
$db_pass = \'' . addslashes($password) . '\';
$db_name = \'' . addslashes($database) . '\';

function getDB() {
    global $db_host, $db_user, $db_pass, $db_name;
    
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    if ($conn->connect_error) {
        return false;
    }
    
    $conn->set_charset("utf8mb4");
    return $conn;
}

date_default_timezone_set(\'UTC\');
error_reporting(0);
?>';
    
    if (file_put_contents('config.php', $config_content)) {
        echo "<h1>Config Updated Successfully</h1>";
        echo "<p>Configuration has been saved to config.php</p>";
        
        // Test the new connection
        include 'config.php';
        $conn = getDB();
        
        if ($conn) {
            echo "<p style='color:green;'>✓ Database connection successful with new credentials!</p>";
            $conn->close();
        } else {
            echo "<p style='color:red;'>✗ Database connection still failing</p>";
            echo "<p>Please check your credentials and try again.</p>";
        }
        
        echo "<p><a href='database-test.php'>↻ Test Database Again</a></p>";
        echo "<p><a href='viewer/'>▶ Go to Live Scores</a></p>";
    } else {
        echo "<h1>Error Saving Config</h1>";
        echo "<p>Could not write to config.php. Check file permissions.</p>";
        echo "<p>Manual fix: Create config.php with this content:</p>";
        echo "<pre style='background: #f8f9fa; padding: 15px;'>" . htmlspecialchars($config_content) . "</pre>";
    }
    
    echo "<style>body { font-family: Arial; padding: 20px; }</style>";
    exit;
}

// If not POST, redirect to test page
header('Location: database-test.php');
?>