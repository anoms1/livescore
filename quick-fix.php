<?php
// quick-fix.php - Emergency fix for common cPanel issues
echo "<h1>XtraBet LiveScore - Quick Fix</h1>";

// Fix 1: Check and create config.php if missing
if (!file_exists('config.php')) {
    echo "<h3>Creating config.php...</h3>";
    $default_config = '<?php
// Default configuration - CHANGE THESE!
$db_host = "localhost";
$db_user = "YOUR_CPANEL_USERNAME";
$db_pass = "YOUR_PASSWORD";
$db_name = "YOUR_DATABASE_NAME";

function getDB() {
    global $db_host, $db_user, $db_pass, $db_name;
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) return false;
    $conn->set_charset("utf8mb4");
    return $conn;
}

date_default_timezone_set("UTC");
error_reporting(0);
?>';
    
    if (file_put_contents('config.php', $default_config)) {
        echo "<p style='color:green;'>✓ Created config.php</p>";
        echo "<p><strong>IMPORTANT:</strong> Edit config.php with your cPanel credentials</p>";
    } else {
        echo "<p style='color:red;'>✗ Cannot create config.php - check permissions</p>";
    }
}

// Fix 2: Create .htaccess if missing
if (!file_exists('.htaccess')) {
    echo "<h3>Creating .htaccess...</h3>";
    $htaccess = 'Options -Indexes
ErrorDocument 404 /404.html
ErrorDocument 500 /500.html';
    
    if (file_put_contents('.htaccess', $htaccess)) {
        echo "<p style='color:green;'>✓ Created .htaccess</p>";
    }
}

// Fix 3: Create required directories
$dirs = ['admin', 'viewer', 'api', 'database'];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0755)) {
            echo "<p style='color:green;'>✓ Created directory: $dir</p>";
        }
    }
}

// Fix 4: Check PHP version
echo "<h3>PHP Version Check</h3>";
echo "<p>PHP Version: " . phpversion() . "</p>";
if (version_compare(phpversion(), '7.4', '<')) {
    echo "<p style='color:orange;'>⚠ PHP 7.4 or higher recommended</p>";
} else {
    echo "<p style='color:green;'>✓ PHP version OK</p>";
}

// Fix 5: Check extensions
echo "<h3>Required Extensions</h3>";
$extensions = ['mysqli', 'json', 'session'];
foreach ($extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<p style='color:green;'>✓ $ext enabled</p>";
    } else {
        echo "<p style='color:red;'>✗ $ext NOT enabled</p>";
    }
}

echo "<hr>";
echo "<h2>Quick Actions</h2>";
echo "<ul>";
echo "<li><a href='database-test.php'>Test Database Connection</a></li>";
echo "<li><a href='install-database.php'>Install Database Tables</a></li>";
echo "<li><a href='viewer/'>Test Viewer Page</a></li>";
echo "<li><a href='admin/'>Test Admin Panel</a></li>";
echo "</ul>";

echo "<style>
    body { font-family: Arial; padding: 20px; max-width: 800px; margin: 0 auto; }
    h1, h2, h3 { color: #333; }
</style>";
?>