<?php
// XtraBet LiveScore - SIMPLE cPanel Configuration
// ================================================
// CHANGE THESE 4 LINES ONLY:

$db_host = 'localhost';                 // Keep as 'localhost'
$db_user = 'extralea_livescore';         // Your cPanel database username
$db_pass = 'saeYYSCUcEr8tfKLABhv';         // Your database password
$db_name = 'extralea_livescore';        // Your database name

// ================================================
// DO NOT EDIT BELOW THIS LINE
// ================================================

// Database connection function
function getDB() {
    global $db_host, $db_user, $db_pass, $db_name;
    
    // Create connection
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    // Check connection
    if ($conn->connect_error) {
        // Return false instead of dying
        return false;
    }
    
    // Set charset
    $conn->set_charset("utf8mb4");
    
    return $conn;
}

// Set timezone
date_default_timezone_set('UTC');

// Simple error handling
error_reporting(0);
?>