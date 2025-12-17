<?php
// Use root config.php
require_once dirname(__DIR__) . '/config.php';
session_start();

// Simple admin authentication
if (!isset($_SESSION['admin_logged_in'])) {
    $_SESSION['admin_logged_in'] = true;
}

// Get database connection using the new function
$conn = getDB(); // Changed from getDBConnection()

if (!$conn) {
    die("Database connection failed. Please check your configuration.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - XtraBet LiveScore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .admin-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .match-card { transition: transform 0.3s; }
        .match-card:hover { transform: translateY(-5px); }
        .status-badge { font-size: 0.8em; }
    </style>
</head>
<body>
    <div class="admin-header py-3 mb-4 shadow">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
                <a href="../viewer/" class="btn btn-light" target="_blank">View Live Scores</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2>All Matches</h2>
            </div>
            <div class="col-md-4 text-end">
                <a href="add_match.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Match
                </a>
            </div>
        </div>

        <?php
        // Get all matches grouped by league
        $sql = "SELECT m.*, s.home_goals, s.away_goals 
                FROM matches m 
                LEFT JOIN scores s ON m.id = s.match_id 
                ORDER BY m.league_name, m.match_date DESC";
        $result = $conn->query($sql);

        if (!$result) {
            echo "<div class='alert alert-danger'>Error loading matches: " . $conn->error . "</div>";
        } else {
            $matches_by_league = [];
            while ($row = $result->fetch_assoc()) {
                $matches_by_league[$row['league_name']][] = $row;
            }
        ?>
        
        <?php if (empty($matches_by_league)): ?>
            <div class="alert alert-info">
                <h4>No matches found</h4>
                <p>Add your first match using the button above.</p>
            </div>
        <?php else: ?>
            <?php foreach ($matches_by_league as $league => $matches): ?>
            <div class="card mb-4">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-trophy"></i> <?php echo htmlspecialchars($league); ?>
                    </h5>
                    <span class="badge bg-light text-dark"><?php echo count($matches); ?> matches</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($matches as $match): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card match-card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="badge 
                                                <?php echo $match['status'] == 'waiting' ? 'bg-secondary' : 
                                                       ($match['status'] == 'ended' ? 'bg-danger' : 'bg-success'); ?> status-badge">
                                                <?php echo strtoupper($match['status']); ?>
                                            </span>
                                            <?php if ($match['status'] == 'first' || $match['status'] == 'second'): ?>
                                            <span class="badge bg-warning text-dark status-badge">LIVE</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                                    data-bs-toggle="dropdown">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="edit_match.php?id=<?php echo $match['id']; ?>">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a></li>
                                                <li><a class="dropdown-item" href="delete_match.php?id=<?php echo $match['id']; ?>" 
                                                       onclick="return confirm('Delete this match?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center mb-3">
                                        <h5><?php echo htmlspecialchars($match['team_home']); ?> vs 
                                            <?php echo htmlspecialchars($match['team_away']); ?></h5>
                                        <div class="display-4">
                                            <span class="text-primary"><?php echo $match['home_goals']; ?></span> - 
                                            <span class="text-danger"><?php echo $match['away_goals']; ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="match-controls">
                                        <?php if ($match['status'] == 'waiting'): ?>
                                        <button class="btn btn-success btn-sm w-100 mb-2" 
                                                onclick="updateStatus(<?php echo $match['id']; ?>, 'first')">
                                            <i class="fas fa-play"></i> Start Match
                                        </button>
                                        <?php elseif ($match['status'] == 'first'): ?>
                                        <div class="btn-group w-100 mb-2">
                                            <button class="btn btn-success btn-sm" 
                                                    onclick="addGoal(<?php echo $match['id']; ?>, 'home')">
                                                <i class="fas fa-futbol"></i> +1 Home
                                            </button>
                                            <button class="btn btn-warning btn-sm" 
                                                    onclick="updateStatus(<?php echo $match['id']; ?>, 'break')">
                                                1st Half End
                                            </button>
                                            <button class="btn btn-danger btn-sm" 
                                                    onclick="addGoal(<?php echo $match['id']; ?>, 'away')">
                                                +1 Away <i class="fas fa-futbol"></i>
                                            </button>
                                        </div>
                                        <button class="btn btn-info btn-sm w-100 mb-2" 
                                                onclick="addStoppage(<?php echo $match['id']; ?>, 'first')">
                                            <i class="fas fa-clock"></i> Add Stoppage (1st)
                                        </button>
                                        <?php elseif ($match['status'] == 'break'): ?>
                                        <button class="btn btn-success btn-sm w-100 mb-2" 
                                                onclick="updateStatus(<?php echo $match['id']; ?>, 'second')">
                                            <i class="fas fa-play"></i> Start 2nd Half
                                        </button>
                                        <?php elseif ($match['status'] == 'second'): ?>
                                        <div class="btn-group w-100 mb-2">
                                            <button class="btn btn-success btn-sm" 
                                                    onclick="addGoal(<?php echo $match['id']; ?>, 'home')">
                                                <i class="fas fa-futbol"></i> +1 Home
                                            </button>
                                            <button class="btn btn-warning btn-sm" 
                                                    onclick="updateStatus(<?php echo $match['id']; ?>, 'ended')">
                                                End Match
                                            </button>
                                            <button class="btn btn-danger btn-sm" 
                                                    onclick="addGoal(<?php echo $match['id']; ?>, 'away')">
                                                +1 Away <i class="fas fa-futbol"></i>
                                            </button>
                                        </div>
                                        <button class="btn btn-info btn-sm w-100 mb-2" 
                                                onclick="addStoppage(<?php echo $match['id']; ?>, 'second')">
                                            <i class="fas fa-clock"></i> Add Stoppage (2nd)
                                        </button>
                                        <?php elseif ($match['status'] == 'ended'): ?>
                                        <button class="btn btn-primary btn-sm w-100 mb-2" 
                                                onclick="resetMatch(<?php echo $match['id']; ?>)">
                                            <i class="fas fa-redo"></i> Reset Match
                                        </button>
                                        <?php endif; ?>
                                        
                                        <button class="btn btn-outline-secondary btn-sm w-100" 
                                                onclick="undoGoal(<?php echo $match['id']; ?>)">
                                            <i class="fas fa-undo"></i> Undo Last Goal
                                        </button>
                                    </div>
                                    
                                    <div class="mt-3 text-center text-muted">
                                        <small>
                                            <i class="far fa-calendar"></i> 
                                            <?php 
                                            $matchDate = new DateTime($match['match_date']);
                                            echo $matchDate->format('M d, Y H:i');
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <?php } // End if result ?>
        
        <?php $conn->close(); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function updateStatus(matchId, status) {
        fetch(`../api/update_status.php?match_id=${matchId}&status=${status}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                alert('Network error: ' + error.message);
            });
    }
    
    function addGoal(matchId, team) {
        fetch(`../api/update_score.php?match_id=${matchId}&team=${team}&action=add`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                alert('Network error: ' + error.message);
            });
    }
    
    function undoGoal(matchId) {
        fetch(`../api/update_score.php?match_id=${matchId}&action=undo`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                alert('Network error: ' + error.message);
            });
    }
    
    function addStoppage(matchId, half) {
        const minutes = prompt(`Enter stoppage minutes for ${half} half:`);
        if (minutes && !isNaN(minutes) && minutes >= 0) {
            fetch(`../api/update_stoppage.php?match_id=${matchId}&half=${half}&minutes=${minutes}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    alert('Network error: ' + error.message);
                });
        }
    }
    
    function resetMatch(matchId) {
        if (confirm('Reset this match to zero?')) {
            fetch(`../api/update_score.php?match_id=${matchId}&action=reset`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    alert('Network error: ' + error.message);
                });
        }
    }
    </script>
</body>
</html>