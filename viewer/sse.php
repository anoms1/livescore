<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set proper headers for SSE
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('X-Accel-Buffering: no'); // Disable nginx buffering
header('Access-Control-Allow-Origin: *');

// Prevent script timeout
set_time_limit(0);

// Disable output buffering
while (ob_get_level() > 0) {
    ob_end_flush();
}

// Flush buffers
ob_implicit_flush(true);

// Initialize last update time
$lastUpdateFile = 'last_update.txt';
if (!file_exists($lastUpdateFile)) {
    file_put_contents($lastUpdateFile, time());
}

$lastUpdate = file_get_contents($lastUpdateFile);

// Send initial connection message
echo "event: connected\n";
echo "data: " . json_encode(['type' => 'connected', 'time' => date('Y-m-d H:i:s')]) . "\n\n";
ob_flush();
flush();

// Main SSE loop
while (true) {
    // Check if client is still connected
    if (connection_aborted()) {
        break;
    }
    
    // Check for updates
    clearstatcache(); // Clear file stat cache
    $currentUpdate = file_exists($lastUpdateFile) ? file_get_contents($lastUpdateFile) : 0;
    
    if ($currentUpdate != $lastUpdate) {
        $lastUpdate = $currentUpdate;
        
        echo "event: update\n";
        echo "data: " . json_encode([
            'type' => 'update',
            'timestamp' => $lastUpdate,
            'time' => date('Y-m-d H:i:s')
        ]) . "\n\n";
        ob_flush();
        flush();
    }
    
    // Send heartbeat every 5 seconds
    echo ": heartbeat\n\n";
    ob_flush();
    flush();
    
    // Wait 3 seconds before next check
    sleep(3);
    
    // Break after 30 minutes to prevent memory leaks (browser will reconnect)
    static $counter = 0;
    $counter++;
    if ($counter > 600) { // 30 minutes * 20 iterations per minute
        break;
    }
}
?>