<?php
// Direct test of the API
require_once 'config.php';

$conn = getDBConnection();

$sql = "SELECT m.*, s.home_goals, s.away_goals
        FROM matches m 
        LEFT JOIN scores s ON m.id = s.match_id 
        ORDER BY m.match_date";

$result = $conn->query($sql);

if ($result) {
    $matches = [];
    while ($row = $result->fetch_assoc()) {
        $matches[] = $row;
    }
    
    echo "<h2>Direct Database Query Results:</h2>";
    echo "<pre>";
    print_r($matches);
    echo "</pre>";
    
    echo "<h2>JSON Output:</h2>";
    $json = json_encode(['success' => true, 'matches' => $matches], JSON_PRETTY_PRINT);
    echo "<pre>" . htmlspecialchars($json) . "</pre>";
    
    echo "<h2>JSON Last Error:</h2>";
    echo json_last_error_msg();
    
} else {
    echo "Query failed: " . $conn->error;
}

$conn->close();
?>