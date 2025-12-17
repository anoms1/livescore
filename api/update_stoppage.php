<?php
require_once '../config.php';
header('Content-Type: application/json');

$match_id = intval($_GET['match_id'] ?? 0);
$half = $_GET['half'] ?? '';
$minutes = intval($_GET['minutes'] ?? 0);

if (!$match_id || !in_array($half, ['first', 'second']) || $minutes < 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
}

$conn = getDB();

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

if ($half === 'first') {
    $stmt = $conn->prepare("UPDATE matches SET first_half_stoppage = ? WHERE id = ?");
} else {
    $stmt = $conn->prepare("UPDATE matches SET second_half_stoppage = ? WHERE id = ?");
}

$stmt->bind_param("ii", $minutes, $match_id);

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