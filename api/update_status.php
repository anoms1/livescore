<?php
require_once '../config.php';
header('Content-Type: application/json');

$match_id = intval($_GET['match_id'] ?? 0);
$status = $_GET['status'] ?? '';

$valid_statuses = ['waiting', 'first', 'break', 'second', 'ended'];

if (!$match_id || !in_array($status, $valid_statuses)) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
}

$conn = getDB();

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Set start time if starting first half
$start_time = null;
if ($status === 'first') {
    $start_time = date('Y-m-d H:i:s');
}

$stmt = $conn->prepare("UPDATE matches SET status = ?, start_time = COALESCE(?, start_time) WHERE id = ?");
$stmt->bind_param("ssi", $status, $start_time, $match_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
    
    // Trigger update for viewers
    if (file_exists('../viewer/last_update.txt')) {
        file_put_contents('../viewer/last_update.txt', time());
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Update failed']);
}

$conn->close();
?>