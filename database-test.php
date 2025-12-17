<?php
echo "<h1>XtraBet LiveScore - Database Connection Test</h1>";
echo "<hr>";

// Test 1: Basic PHP check
echo "<h3>Test 1: PHP Environment</h3>";
echo "<p>PHP Version: <strong>" . phpversion() . "</strong></p>";
echo "<p>Server: <strong>" . $_SERVER['SERVER_SOFTWARE'] . "</strong></p>";
echo "<hr>";

// Test 2: Check config.php
echo "<h3>Test 2: Configuration File</h3>";
if (file_exists('config.php')) {
    echo "<p style='color:green;'>✓ config.php file exists</p>";
    
    // Read config to see what's in it
    $config_content = file_get_contents('config.php');
    echo "<p>Config file size: " . strlen($config_content) . " bytes</p>";
    
    // Include config
    include 'config.php';
    
    // Check if variables are set
    if (isset($db_host) && isset($db_user) && isset($db_name)) {
        echo "<p style='color:green;'>✓ Database variables are set:</p>";
        echo "<ul>";
        echo "<li>Host: <code>" . htmlspecialchars($db_host) . "</code></li>";
        echo "<li>User: <code>" . htmlspecialchars($db_user) . "</code></li>";
        echo "<li>Database: <code>" . htmlspecialchars($db_name) . "</code></li>";
        echo "<li>Password: <code>" . (empty($db_pass) ? '(empty)' : '******') . "</code></li>";
        echo "</ul>";
    } else {
        echo "<p style='color:red;'>✗ Database variables NOT set in config.php</p>";
    }
} else {
    echo "<p style='color:red;'>✗ config.php file NOT FOUND</p>";
    echo "<p>Create config.php with your cPanel database credentials</p>";
}
echo "<hr>";

// Test 3: Test MySQL connection
echo "<h3>Test 3: MySQL Database Connection</h3>";
if (isset($db_host) && isset($db_user) && isset($db_name)) {
    echo "<p>Attempting to connect to database...</p>";
    
    // Test connection without config.php functions
    $test_conn = @new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    if ($test_conn->connect_error) {
        echo "<p style='color:red;'>✗ CONNECTION FAILED: " . $test_conn->connect_error . "</p>";
        
        echo "<h4>Troubleshooting Steps:</h4>";
        echo "<ol>";
        echo "<li><strong>Check cPanel MySQL Databases:</strong> Make sure database exists</li>";
        echo "<li><strong>Check Username Format:</strong> Should be 'cpanelusername_dbuser'</li>";
        echo "<li><strong>Check Database Name:</strong> Should be 'cpanelusername_database'</li>";
        echo "<li><strong>Check Password:</strong> Use the exact password from cPanel</li>";
        echo "<li><strong>Check Privileges:</strong> User must have ALL privileges on database</li>";
        echo "</ol>";
        
        echo "<h4>How to get correct credentials:</h4>";
        echo "1. Login to cPanel<br>";
        echo "2. Go to 'MySQL Databases'<br>";
        echo "3. Under 'Current Databases' - copy database name<br>";
        echo "4. Under 'Current Users' - copy username<br>";
        echo "5. Use the password you set when creating user";
    } else {
        echo "<p style='color:green;'>✓ SUCCESS! Connected to database</p>";
        
        // Check if tables exist
        echo "<h4>Checking database tables...</h4>";
        $tables = $test_conn->query("SHOW TABLES");
        
        if ($tables && $tables->num_rows > 0) {
            echo "<p style='color:green;'>✓ Tables found: " . $tables->num_rows . "</p>";
            echo "<ul>";
            while ($row = $tables->fetch_array()) {
                echo "<li>" . $row[0] . "</li>";
            }
            echo "</ul>";
            
            // Check for our specific tables
            $check_matches = $test_conn->query("SHOW TABLES LIKE 'matches'");
            $check_scores = $test_conn->query("SHOW TABLES LIKE 'scores'");
            
            if ($check_matches->num_rows > 0 && $check_scores->num_rows > 0) {
                echo "<p style='color:green;'>✓ Required tables (matches, scores) exist</p>";
            } else {
                echo "<p style='color:orange;'>⚠ Some required tables missing</p>";
                echo "<p><a href='install-database.php'>Click here to install database</a></p>";
            }
        } else {
            echo "<p style='color:orange;'>⚠ No tables found in database</p>";
            echo "<p><a href='install-database.php'>Click here to install database</a></p>";
        }
        
        $test_conn->close();
    }
} else {
    echo "<p style='color:red;'>✗ Cannot test connection - database variables not set</p>";
}
echo "<hr>";

// Test 4: Test config.php functions
echo "<h3>Test 4: Config.php Functions</h3>";
if (function_exists('getDB')) {
    echo "<p style='color:green;'>✓ getDB() function exists</p>";
    
    $conn = getDB();
    if ($conn) {
        echo "<p style='color:green;'>✓ getDB() function works correctly</p>";
        $conn->close();
    } else {
        echo "<p style='color:red;'>✗ getDB() function returns false</p>";
    }
} else {
    echo "<p style='color:red;'>✗ getDB() function NOT FOUND</p>";
}
echo "<hr>";

// Test 5: File permissions
echo "<h3>Test 5: File Permissions</h3>";
$files = [
    'config.php' => 'Should be 644',
    'index.php' => 'Should be 644',
    'admin/' => 'Should be 755',
    'viewer/' => 'Should be 755',
    'api/' => 'Should be 755'
];

foreach ($files as $file => $recommended) {
    if (file_exists($file)) {
        $perms = substr(sprintf('%o', fileperms($file)), -4);
        echo "<p>" . $file . ": <code>" . $perms . "</code> ($recommended)</p>";
    }
}
echo "<hr>";

// Summary
echo "<h2>Summary</h2>";
echo "<p><a href='setup.php' style='font-size: 1.2em;'>↻ Run Setup Wizard Again</a></p>";
echo "<p><a href='viewer/' style='font-size: 1.2em;'>▶ Go to Live Scores</a></p>";
echo "<p><a href='admin/' style='font-size: 1.2em;'>⚙ Go to Admin Panel</a></p>";

// Add quick fix form
echo "<hr><h3>Quick Fix: Update Config</h3>";
echo "<form method='POST' action='update-config.php' style='background: #f8f9fa; padding: 20px; border-radius: 10px;'>
    <div class='mb-3'>
        <label>Database Host:</label>
        <input type='text' name='host' value='localhost' class='form-control'>
    </div>
    <div class='mb-3'>
        <label>Database Username:</label>
        <input type='text' name='username' value='' placeholder='cpanelusername_dbuser' class='form-control'>
    </div>
    <div class='mb-3'>
        <label>Database Password:</label>
        <input type='password' name='password' value='' class='form-control'>
    </div>
    <div class='mb-3'>
        <label>Database Name:</label>
        <input type='text' name='database' value='' placeholder='cpanelusername_database' class='form-control'>
    </div>
    <button type='submit' class='btn btn-primary'>Update Config</button>
</form>";

// Add CSS
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; max-width: 1000px; margin: 0 auto; }
    h1 { color: #333; }
    h3 { color: #555; margin-top: 30px; }
    .form-control { padding: 8px; margin: 5px 0; width: 100%; max-width: 400px; }
    .btn { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
    .btn:hover { background: #0056b3; }
</style>";
?>