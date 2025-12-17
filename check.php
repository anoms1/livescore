<?php
// check.php - Database Test Script
echo "<h2>XtraBet LiveScore - Database Test</h2>";

// Test 1: Check if we can connect to MySQL
echo "<h3>Test 1: MySQL Connection</h3>";
$test_mysql = @new mysqli('localhost', 'root', '');
if ($test_mysql->connect_error) {
    echo "<p style='color:red'>✗ Cannot connect to MySQL: " . $test_mysql->connect_error . "</p>";
} else {
    echo "<p style='color:green'>✓ Connected to MySQL server</p>";
    $test_mysql->close();
}

// Test 2: Check config.php
echo "<h3>Test 2: Configuration File</h3>";
if (file_exists('config.php')) {
    echo "<p style='color:green'>✓ config.php exists</p>";
    
    include 'config.php';
    
    // Test connection using config
    if (function_exists('getDBConnection')) {
        $conn = getDBConnection();
        if ($conn) {
            echo "<p style='color:green'>✓ Database connection successful via config.php</p>";
            
            // Test query
            $result = $conn->query("SELECT 1 as test");
            if ($result) {
                echo "<p style='color:green'>✓ Query execution successful</p>";
            }
            $conn->close();
        } else {
            echo "<p style='color:red'>✗ Database connection failed via config.php</p>";
        }
    } else {
        echo "<p style='color:red'>✗ getDBConnection() function not found in config.php</p>";
    }
} else {
    echo "<p style='color:orange'>⚠ config.php not found. Run setup.php first.</p>";
}

// Test 3: Check file permissions
echo "<h3>Test 3: File Permissions</h3>";
$files = ['config.php', 'setup.php', '.htaccess'];
foreach ($files as $file) {
    if (file_exists($file)) {
        $perms = substr(sprintf('%o', fileperms($file)), -4);
        echo "<p>" . $file . ": " . $perms . "</p>";
    }
}

// Test 4: PHP Info
echo "<h3>Test 4: PHP Information</h3>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>MySQLi Enabled: " . (extension_loaded('mysqli') ? 'Yes' : 'No') . "</p>";
echo "<p>JSON Enabled: " . (extension_loaded('json') ? 'Yes' : 'No') . "</p>";

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li><a href='setup.php'>Run Setup Wizard</a></li>";
echo "<li><a href='viewer/'>Test Viewer Page</a></li>";
echo "<li><a href='admin/'>Test Admin Panel</a></li>";
echo "</ol>";
?>