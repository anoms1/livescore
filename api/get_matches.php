<?php
// api/get_matches.php - WORKING VERSION FOR CPANEL
require_once '../config.php';

// Set headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Cache-Control: no-cache, must-revalidate');

// Get database connection
$conn = getDB();

// Check connection
if (!$conn) {
    // Database connection failed
    echo json_encode([
        'success' => false,
        'error' => 'Database connection failed',
        'message' => 'Please check your database configuration',
        'matches' => [],
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit;
}

try {
    // Get matches with scores
    $sql = "SELECT m.*, COALESCE(s.home_goals, 0) as home_goals, COALESCE(s.away_goals, 0) as away_goals
            FROM matches m
            LEFT JOIN scores s ON m.id = s.match_id
            ORDER BY 
                CASE m.status 
                    WHEN 'first' THEN 1
                    WHEN 'second' THEN 2
                    WHEN 'break' THEN 3
                    WHEN 'waiting' THEN 4
                    ELSE 5
                END,
                m.match_date DESC";
    
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception('Query failed: ' . $conn->error);
    }
    
    $matches = [];
    while ($row = $result->fetch_assoc()) {
        // Format data
        $row['id'] = (int)$row['id'];
        $row['home_goals'] = (int)$row['home_goals'];
        $row['away_goals'] = (int)$row['away_goals'];
        $row['first_half_stoppage'] = (int)$row['first_half_stoppage'];
        $row['second_half_stoppage'] = (int)$row['second_half_stoppage'];
        
        // Calculate stoppage time for display
        $stoppage_time = 0;
        if ($row['status'] == 'first') {
            $stoppage_time = $row['first_half_stoppage'];
        } elseif ($row['status'] == 'second') {
            $stoppage_time = $row['second_half_stoppage'];
        }
        $row['stoppage_time'] = $stoppage_time;
        
        // Format date
        $matchDate = new DateTime($row['match_date']);
        $row['formatted_date'] = $matchDate->format('M d, Y H:i');
        
        $matches[] = $row;
    }
    
    $conn->close();
    
    // Success response
    echo json_encode([
        'success' => true,
        'matches' => $matches,
        'total' => count($matches),
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    // Error response
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'matches' => [],
        'timestamp' => date('Y-m-d H:i:s')
    ]);
}
?>