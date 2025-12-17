<?php
require_once '../config.php';

echo "<h2>Live Score System Debug</h2>";

try {
    $conn = getDBConnection();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    echo "<p style='color: green;'>✓ Database connected successfully</p>";
    
    // Check tables
    $tables = ['matches', 'scores'];
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows > 0) {
            echo "<p style='color: green;'>✓ Table '$table' exists</p>";
            
            // Count rows
            $count = $conn->query("SELECT COUNT(*) as count FROM $table")->fetch_assoc();
            echo "<p>Rows in $table: " . $count['count'] . "</p>";
            
            // Show sample data
            if ($table == 'matches') {
                $matches = $conn->query("SELECT * FROM matches LIMIT 5");
                echo "<h3>Sample Matches:</h3>";
                echo "<table border='1' cellpadding='5'>";
                echo "<tr><th>ID</th><th>League</th><th>Home</th><th>Away</th><th>Status</th><th>Date</th></tr>";
                while ($row = $matches->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['league_name'] . "</td>";
                    echo "<td>" . $row['team_home'] . "</td>";
                    echo "<td>" . $row['team_away'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>" . $row['match_date'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } else {
            echo "<p style='color: red;'>✗ Table '$table' does NOT exist</p>";
        }
    }
    
    // Check API endpoint
    echo "<h3>API Test:</h3>";
    $api_url = '../api/get_matches.php';
    $api_result = file_get_contents($api_url);
    if ($api_result) {
        $data = json_decode($api_result, true);
        echo "<p style='color: green;'>✓ API is working</p>";
        echo "<pre>" . json_encode($data, JSON_PRETTY_PRINT) . "</pre>";
    } else {
        echo "<p style='color: red;'>✗ API failed</p>";
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}
?>