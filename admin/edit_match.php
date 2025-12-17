<?php
require_once dirname(__DIR__) . '/config.php';
session_start();

$conn = getDB();
if (!$conn) {
    die("Database connection failed");
}

$match_id = intval($_GET['id'] ?? 0);

// Fetch match data
$match = null;
if ($match_id) {
    $stmt = $conn->prepare("SELECT * FROM matches WHERE id = ?");
    $stmt->bind_param("i", $match_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $match = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $match_id) {
    $league_name = $_POST['league_name'];
    $team_home = $_POST['team_home'];
    $team_away = $_POST['team_away'];
    $match_date = $_POST['match_date'];
    
    $stmt = $conn->prepare("UPDATE matches SET league_name = ?, team_home = ?, team_away = ?, match_date = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $league_name, $team_home, $team_away, $match_date, $match_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Match updated successfully!";
        header("Location: index.php");
        exit();
    } else {
        $error = "Update failed: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Match</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Match</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <?php if ($match): ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="league_name" class="form-label">League Name</label>
                                <input type="text" class="form-control" id="league_name" name="league_name" 
                                       value="<?php echo htmlspecialchars($match['league_name']); ?>" required>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="team_home" class="form-label">Home Team</label>
                                    <input type="text" class="form-control" id="team_home" name="team_home" 
                                           value="<?php echo htmlspecialchars($match['team_home']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="team_away" class="form-label">Away Team</label>
                                    <input type="text" class="form-control" id="team_away" name="team_away" 
                                           value="<?php echo htmlspecialchars($match['team_away']); ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="match_date" class="form-label">Match Date & Time</label>
                                <?php 
                                $matchDate = new DateTime($match['match_date']);
                                $formattedDate = $matchDate->format('Y-m-d\TH:i');
                                ?>
                                <input type="datetime-local" class="form-control" id="match_date" name="match_date" 
                                       value="<?php echo $formattedDate; ?>" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Update Match</button>
                                <a href="index.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                        <?php else: ?>
                            <div class="alert alert-danger">
                                <h5>Match not found</h5>
                                <p>The requested match could not be found.</p>
                                <a href="index.php" class="btn btn-secondary">Back to Admin</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>