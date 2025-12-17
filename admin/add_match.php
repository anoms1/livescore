<?php
require_once dirname(__DIR__) . '/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getDB();
    
    if (!$conn) {
        $_SESSION['error'] = "Database connection failed";
        header("Location: index.php");
        exit;
    }
    
    $league_name = $_POST['league_name'];
    $team_home = $_POST['team_home'];
    $team_away = $_POST['team_away'];
    $match_date = $_POST['match_date'];
    
    // Insert match
    $stmt = $conn->prepare("INSERT INTO matches (league_name, team_home, team_away, match_date, status) VALUES (?, ?, ?, ?, 'waiting')");
    $stmt->bind_param("ssss", $league_name, $team_home, $team_away, $match_date);
    
    if ($stmt->execute()) {
        $match_id = $conn->insert_id;
        
        // Insert score record
        $score_stmt = $conn->prepare("INSERT INTO scores (match_id, home_goals, away_goals) VALUES (?, 0, 0)");
        $score_stmt->bind_param("i", $match_id);
        
        if ($score_stmt->execute()) {
            $_SESSION['success'] = "Match added successfully!";
        } else {
            $_SESSION['error'] = "Match added but score record failed";
        }
        $score_stmt->close();
        
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to add match: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Match</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-plus"></i> Add New Match</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label for="league_name" class="form-label">League Name</label>
                                <select class="form-select" id="league_name" name="league_name" required>
                                    <option value="Premier League">Premier League</option>
                                    <option value="La Liga">La Liga</option>
                                    <option value="Bundesliga">Bundesliga</option>
                                    <option value="Serie A">Serie A</option>
                                    <option value="Ligue 1">Ligue 1</option>
                                    <option value="Champions League">Champions League</option>
                                    <option value="Europa League">Europa League</option>
                                    <option value="Kuwait Xtra League U18">Kuwait Xtra League U18</option>
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="team_home" class="form-label">Home Team</label>
                                    <input type="text" class="form-control" id="team_home" name="team_home" 
                                           placeholder="e.g., Manchester United" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="team_away" class="form-label">Away Team</label>
                                    <input type="text" class="form-control" id="team_away" name="team_away" 
                                           placeholder="e.g., Liverpool" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="match_date" class="form-label">Match Date & Time</label>
                                <input type="datetime-local" class="form-control" id="match_date" name="match_date" 
                                       value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Add Match</button>
                                <a href="index.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>