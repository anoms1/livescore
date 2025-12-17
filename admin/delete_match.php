<?php
require_once dirname(__DIR__) . '/config.php';
session_start();

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "No match ID provided";
    header("Location: index.php");
    exit();
}

$match_id = intval($_GET['id']);

if ($match_id <= 0) {
    $_SESSION['error'] = "Invalid match ID";
    header("Location: index.php");
    exit();
}

$conn = getDB();

if (!$conn) {
    $_SESSION['error'] = "Database connection failed";
    header("Location: index.php");
    exit();
}

// Start transaction for safety
$conn->begin_transaction();

try {
    // First, delete the score record
    $delete_score = $conn->prepare("DELETE FROM scores WHERE match_id = ?");
    $delete_score->bind_param("i", $match_id);
    $delete_score->execute();
    $delete_score->close();
    
    // Then delete the match
    $delete_match = $conn->prepare("DELETE FROM matches WHERE id = ?");
    $delete_match->bind_param("i", $match_id);
    $delete_match->execute();
    
    if ($delete_match->affected_rows > 0) {
        // Commit transaction
        $conn->commit();
        
        $_SESSION['success'] = "Match deleted successfully!";
        
        // Trigger update for viewers
        if (file_exists('../viewer/last_update.txt')) {
            file_put_contents('../viewer/last_update.txt', time());
        }
    } else {
        // Rollback if no rows affected
        $conn->rollback();
        $_SESSION['error'] = "Match not found or already deleted";
    }
    
    $delete_match->close();
    
} catch (Exception $e) {
    // Rollback on error
    $conn->rollback();
    $_SESSION['error'] = "Error deleting match";
}

$conn->close();

// Redirect back to admin panel
header("Location: index.php");
exit();
?>