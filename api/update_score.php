<?php
require_once '../config.php';
header('Content-Type: application/json');

$match_id = intval($_GET['match_id'] ?? 0);
$action = $_GET['action'] ?? '';
$team = $_GET['team'] ?? '';

if (!$match_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid match ID']);
    exit;
}

$conn = getDB();

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Get current score
$score_stmt = $conn->prepare("SELECT * FROM scores WHERE match_id = ?");
$score_stmt->bind_param("i", $match_id);
$score_stmt->execute();
$score_result = $score_stmt->get_result();
$current_score = $score_result->fetch_assoc();

if ($action === 'add') {
    if ($team === 'home') {
        $new_goals = $current_score['home_goals'] + 1;
        $update_stmt = $conn->prepare("UPDATE scores SET home_goals = ? WHERE match_id = ?");
    } else {
        $new_goals = $current_score['away_goals'] + 1;
        $update_stmt = $conn->prepare("UPDATE scores SET away_goals = ? WHERE match_id = ?");
    }
    $update_stmt->bind_param("ii", $new_goals, $match_id);
} elseif ($action === 'undo') {
    if ($current_score['home_goals'] > 0) {
        $new_goals = max(0, $current_score['home_goals'] - 1);
        $update_stmt = $conn->prepare("UPDATE scores SET home_goals = ? WHERE match_id = ?");
        $update_stmt->bind_param("ii", $new_goals, $match_id);
    } elseif ($current_score['away_goals'] > 0) {
        $new_goals = max(0, $current_score['away_goals'] - 1);
        $update_stmt = $conn->prepare("UPDATE scores SET away_goals = ? WHERE match_id = ?");
        $update_stmt->bind_param("ii", $new_goals, $match_id);
    } else {
        echo json_encode(['success' => false, 'message' => 'No goals to undo']);
        exit;
    }
} elseif ($action === 'reset') {
    $update_stmt = $conn->prepare("UPDATE scores SET home_goals = 0, away_goals = 0 WHERE match_id = ?");
    $update_stmt->bind_param("i", $match_id);
    
    // Also reset match status
    $status_stmt = $conn->prepare("UPDATE matches SET status = 'waiting', start_time = NULL WHERE id = ?");
    $status_stmt->bind_param("i", $match_id);
    $status_stmt->execute();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit;
}

if (isset($update_stmt) && $update_stmt->execute()) {
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