<?php
$conn = new mysqli('localhost', 'root', '', 'live_score_system');

echo "<h2>Database Debug</h2>";

// Check all matches
$result = $conn->query("SELECT * FROM matches ORDER BY id DESC");
echo "<h3>All Matches (" . $result->num_rows . "):</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>League</th><th>Home</th><th>Away</th><th>Status</th><th>Created</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['league_name'] . "</td>";
    echo "<td>" . $row['team_home'] . "</td>";
    echo "<td>" . $row['team_away'] . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "<td>" . $row['created_at'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Check all scores
$scores = $conn->query("SELECT * FROM scores");
echo "<h3>All Scores (" . $scores->num_rows . "):</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Match ID</th><th>Home Goals</th><th>Away Goals</th></tr>";
while ($row = $scores->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['match_id'] . "</td>";
    echo "<td>" . $row['home_goals'] . "</td>";
    echo "<td>" . $row['away_goals'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Check for matches without scores
$orphaned = $conn->query("
    SELECT m.id, m.league_name, m.team_home, m.team_away 
    FROM matches m 
    LEFT JOIN scores s ON m.id = s.match_id 
    WHERE s.match_id IS NULL
");
echo "<h3>Matches without scores (" . $orphaned->num_rows . "):</h3>";
if ($orphaned->num_rows > 0) {
    echo "<ul>";
    while ($row = $orphaned->fetch_assoc()) {
        echo "<li>Match ID " . $row['id'] . ": " . $row['team_home'] . " vs " . $row['team_away'] . "</li>";
    }
    echo "</ul>";
    
    // Fix button
    echo '<button onclick="fixScores()">Fix Missing Scores</button>';
} else {
    echo "<p style='color:green'>✓ All matches have scores</p>";
}

$conn->close();
?>

<script>
function fixScores() {
    if (confirm('Create missing score records?')) {
        fetch('fix_scores.php')
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload();
            });
    }
}
</script>