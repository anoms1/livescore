<?php
// install-database.php - One-click database installation
echo "<h1>Install Database for XtraBet LiveScore</h1>";

// Check if config exists
if (!file_exists('config.php')) {
    die("<p style='color:red;'>config.php not found. Please run setup.php first.</p>");
}

include 'config.php';

// Test connection
$conn = getDB();
if (!$conn) {
    die("<p style='color:red;'>Cannot connect to database. Check your config.php credentials.</p>");
}

echo "<p style='color:green;'>✓ Connected to database successfully</p>";

// SQL to create tables
$sql = "
-- Create matches table
CREATE TABLE IF NOT EXISTS `matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `league_name` varchar(100) NOT NULL,
  `team_home` varchar(100) NOT NULL,
  `team_away` varchar(100) NOT NULL,
  `match_date` datetime NOT NULL,
  `status` enum('waiting','first','break','second','ended') DEFAULT 'waiting',
  `start_time` datetime DEFAULT NULL,
  `first_half_stoppage` int(11) DEFAULT 0,
  `second_half_stoppage` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create scores table
CREATE TABLE IF NOT EXISTS `scores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL,
  `home_goals` int(11) DEFAULT 0,
  `away_goals` int(11) DEFAULT 0,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `match_id` (`match_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data
INSERT INTO `matches` (`league_name`, `team_home`, `team_away`, `match_date`, `status`) VALUES
('Premier League', 'Manchester United', 'Liverpool', DATE_ADD(NOW(), INTERVAL 1 DAY), 'waiting'),
('Premier League', 'Chelsea', 'Arsenal', DATE_ADD(NOW(), INTERVAL 2 DAY), 'waiting'),
('La Liga', 'Barcelona', 'Real Madrid', DATE_ADD(NOW(), INTERVAL 3 DAY), 'waiting'),
('La Liga', 'Atletico Madrid', 'Sevilla', DATE_ADD(NOW(), INTERVAL 4 DAY), 'waiting'),
('Bundesliga', 'Bayern Munich', 'Borussia Dortmund', DATE_ADD(NOW(), INTERVAL 5 DAY), 'waiting');

INSERT INTO `scores` (`match_id`, `home_goals`, `away_goals`) VALUES
(1, 0, 0),
(2, 0, 0),
(3, 0, 0),
(4, 0, 0),
(5, 0, 0);
";

// Split SQL into individual queries
$queries = explode(';', $sql);
$success_count = 0;
$error_count = 0;

echo "<h3>Executing SQL queries...</h3>";
echo "<pre style='background: #f8f9fa; padding: 15px; border-radius: 5px; max-height: 400px; overflow-y: auto;'>";

foreach ($queries as $query) {
    $query = trim($query);
    if (!empty($query)) {
        // Add semicolon back for execution
        $query .= ';';
        
        echo "Executing: " . substr($query, 0, 100) . "...<br>";
        
        if ($conn->query($query)) {
            echo "<span style='color:green;'>✓ Success</span><br>";
            $success_count++;
        } else {
            echo "<span style='color:red;'>✗ Error: " . $conn->error . "</span><br>";
            $error_count++;
        }
        echo "<br>";
    }
}

echo "</pre>";

// Check if tables were created
echo "<h3>Verifying installation...</h3>";
$tables = ['matches', 'scores'];
foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result && $result->num_rows > 0) {
        echo "<p style='color:green;'>✓ Table '$table' created successfully</p>";
    } else {
        echo "<p style='color:red;'>✗ Table '$table' NOT created</p>";
    }
}

$conn->close();

echo "<hr>";
echo "<h2>Installation Summary</h2>";
echo "<p>Successful queries: <strong>$success_count</strong></p>";
echo "<p>Failed queries: <strong>$error_count</strong></p>";

if ($error_count == 0) {
    echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 5px;'>
        <h3>🎉 Installation Complete!</h3>
        <p>Database has been successfully installed.</p>
        <p><a href='viewer/' style='font-size: 1.2em;'>▶ Go to Live Scores</a></p>
        <p><a href='admin/' style='font-size: 1.2em;'>⚙ Go to Admin Panel</a></p>
    </div>";
} else {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; border-radius: 5px;'>
        <h3>⚠ Installation Had Errors</h3>
        <p>Some queries failed. You may need to manually create tables in phpMyAdmin.</p>
        <p><a href='database-test.php'>↻ Run Database Test</a></p>
    </div>";
}
?>