<?php
// admin/debug.php - Admin Panel Debug
echo "<h1>Admin Panel Debug</h1>";

// Test 1: Check if we can include config.php
echo "<h3>Test 1: Configuration File</h3>";
$config_path = dirname(__DIR__) . '/config.php';
echo "<p>Config path: " . $config_path . "</p>";

if (file_exists($config_path)) {
    echo "<p style='color:green;'>✓ config.php exists</p>";
    
    include $config_path;
    
    // Check if getDB function exists
    if (function_exists('getDB')) {
        echo "<p style='color:green;'>✓ getDB() function exists</p>";
        
        // Test database connection
        $conn = getDB();
        if ($conn) {
            echo "<p style='color:green;'>✓ Database connection successful</p>";
            
            // Check if tables exist
            $result = $conn->query("SHOW TABLES");
            echo "<p>Tables in database: " . $result->num_rows . "</p>";
            
            // Check for matches table
            $matches = $conn->query("SELECT COUNT(*) as count FROM matches");
            if ($matches) {
                $row = $matches->fetch_assoc();
                echo "<p>Matches in database: " . $row['count'] . "</p>";
            }
            
            $conn->close();
        } else {
            echo "<p style='color:red;'>✗ Database connection failed</p>";
        }
    } else {
        echo "<p style='color:red;'>✗ getDB() function NOT FOUND</p>";
    }
} else {
    echo "<p style='color:red;'>✗ config.php NOT FOUND</p>";
}

// Test 2: Check session
echo "<h3>Test 2: Session</h3>";
session_start();
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session status: " . session_status() . "</p>";

// Test 3: Check file permissions
echo "<h3>Test 3: File Permissions</h3>";
$files = [
    '../config.php',
    'index.php',
    'add_match.php',
    'edit_match.php',
    'delete_match.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $perms = substr(sprintf('%o', fileperms($file)), -4);
        echo "<p>" . $file . ": " . $perms . "</p>";
    } else {
        echo "<p>" . $file . ": NOT FOUND</p>";
    }
}

echo "<hr>";
echo "<h2>Quick Fixes</h2>";
echo "<ul>";
echo "<li><a href='../setup.php'>Run Setup Wizard</a></li>";
echo "<li><a href='../database-test.php'>Test Database Connection</a></li>";
echo "<li><a href='index.php?force=1'>Force Load Admin</a></li>";
echo "</ul>";

echo "<style>
    body { font-family: Arial; padding: 20px; }
    h1, h2, h3 { color: #333; }
</style>";
?>