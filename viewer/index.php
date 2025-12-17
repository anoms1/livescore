<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>⚽ XtraBet LiveScore - Real-Time Football Scores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
            --dark: #1f2937;
            --light: #f8fafc;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            min-height: 100vh;
            -webkit-text-size-adjust: 100%;
            -webkit-tap-highlight-color: transparent;
        }
        
        /* Header - Mobile Optimized */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .header .container {
            padding: 0 15px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo-icon {
            font-size: 1.8rem;
            color: white;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        .site-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }
        
        .site-subtitle {
            font-size: 0.75rem;
            opacity: 0.9;
            margin: 0;
        }
        
        .header-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .live-indicator {
            display: inline-flex;
            align-items: center;
            background: rgba(239, 68, 68, 0.2);
            padding: 6px 12px;
            border-radius: 20px;
            border: 1px solid rgba(239, 68, 68, 0.3);
            font-size: 0.8rem;
        }
        
        .pulse-dot {
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            margin-right: 6px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
        
        .bet-btn {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.85rem;
            white-space: nowrap;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }
        
        .bet-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        }
        
        /* Main Container */
        .main-container {
            padding: 0 12px;
            max-width: 100%;
            overflow-x: hidden;
        }
        
        /* Stats Grid - Mobile First */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin: 20px 0;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .stat-card h6 {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .stat-card h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(to right, #fff, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .stat-card h5 {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }
        
        /* Matches Section */
        .matches-section {
            margin-top: 20px;
        }
        
        .league-header {
            background: rgba(37, 99, 235, 0.15);
            padding: 12px 15px;
            border-radius: 10px;
            margin: 20px 0 12px 0;
            border-left: 4px solid var(--primary);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .league-header h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .league-count {
            background: var(--primary);
            color: white;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        /* Match Card - Mobile Optimized */
        .match-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }
        
        .match-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.03) 50%, transparent 70%);
            transform: translateX(-100%);
        }
        
        .match-card:hover::before {
            animation: shine 1.5s ease;
        }
        
        @keyframes shine {
            100% { transform: translateX(100%); }
        }
        
        .match-card.live {
            border-left: 4px solid var(--danger);
            animation: pulse-glow 2s infinite;
        }
        
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 15px rgba(239, 68, 68, 0.1); }
            50% { box-shadow: 0 0 25px rgba(239, 68, 68, 0.2); }
        }
        
        .match-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .match-status {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .status-badge {
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
        }
        
        .match-time {
            font-size: 0.85rem;
            color: #94a3b8;
            font-weight: 500;
        }
        
        .teams-container {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 10px;
            align-items: center;
            text-align: center;
        }
        
        .team {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        
        .team.home-team {
            align-items: flex-end;
        }
        
        .team.away-team {
            align-items: flex-start;
        }
        
        .team-logo {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            font-size: 16px;
        }
        
        .team-name {
            font-weight: 600;
            font-size: 0.95rem;
            line-height: 1.2;
            word-break: break-word;
            max-width: 100%;
        }
        
        .score-container {
            text-align: center;
            min-width: 80px;
        }
        
        .score {
            font-size: 2rem;
            font-weight: 700;
            font-family: 'Courier New', monospace;
            line-height: 1;
            margin: 5px 0;
        }
        
        .home-score { color: #60a5fa; }
        .away-score { color: #f87171; }
        
        .score-divider {
            font-size: 1.8rem;
            margin: 0 5px;
        }
        
        .match-date {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: 5px;
        }
        
        .match-footer {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        
        .stoppage-badge {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        /* Loading & Error States */
        .loading-container {
            text-align: center;
            padding: 60px 20px;
        }
        
        .spinner-large {
            width: 50px;
            height: 50px;
            border-width: 3px;
        }
        
        .error-container {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            margin: 20px 0;
        }
        
        .error-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        
        /* Refresh Button */
        .refresh-btn {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            z-index: 999;
            transition: all 0.3s ease;
        }
        
        .refresh-btn:active {
            transform: scale(0.95);
        }
        
        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 12px 0;
            z-index: 1000;
        }
        
        .nav-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 5px;
        }
        
        .nav-item.active {
            color: var(--primary);
        }
        
        .nav-icon {
            font-size: 1.2rem;
            margin-bottom: 4px;
        }
        
        .nav-text {
            font-size: 0.7rem;
            font-weight: 500;
        }
        
        /* Modal - Mobile Friendly */
        .modal-content.bg-dark {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .modal-header.border-secondary {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        
        /* Footer */
        .footer {
            padding: 30px 20px;
            text-align: center;
            color: #94a3b8;
            font-size: 0.85rem;
            margin-bottom: 70px; /* Account for bottom nav */
        }
        
        /* Tablet Styles */
        @media (min-width: 768px) {
            .header {
                padding: 1.5rem 0;
            }
            
            .site-title {
                font-size: 1.8rem;
            }
            
            .site-subtitle {
                font-size: 0.9rem;
            }
            
            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 15px;
            }
            
            .stat-card {
                padding: 20px;
            }
            
            .stat-card h2 {
                font-size: 2.2rem;
            }
            
            .match-card {
                padding: 20px;
                margin-bottom: 15px;
            }
            
            .team-logo {
                width: 44px;
                height: 44px;
                font-size: 18px;
            }
            
            .team-name {
                font-size: 1.1rem;
            }
            
            .score {
                font-size: 2.5rem;
            }
        }
        
        /* Desktop Styles */
        @media (min-width: 992px) {
            .main-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
            }
            
            .header {
                padding: 2rem 0;
            }
            
            .site-title {
                font-size: 2rem;
            }
            
            .match-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                border-color: rgba(37, 99, 235, 0.3);
            }
            
            .refresh-btn {
                bottom: 30px;
                right: 30px;
            }
        }
        
        /* Extra Small Devices */
        @media (max-width: 360px) {
            .site-title {
                font-size: 1.2rem;
            }
            
            .team-name {
                font-size: 0.85rem;
            }
            
            .score {
                font-size: 1.8rem;
            }
            
            .stats-grid {
                gap: 8px;
            }
            
            .stat-card {
                padding: 12px;
            }
        }
        
        /* Touch Device Optimizations */
        @media (hover: none) and (pointer: coarse) {
            .match-card:active {
                background: rgba(255, 255, 255, 0.08);
                transform: scale(0.98);
            }
            
            .bet-btn:active,
            .refresh-btn:active {
                transform: scale(0.95);
            }
        }
        
        /* Landscape Mode */
        @media (max-height: 500px) and (orientation: landscape) {
            .header {
                padding: 0.8rem 0;
            }
            
            .matches-section {
                margin-top: 10px;
            }
            
            .match-card {
                padding: 12px;
                margin-bottom: 8px;
            }
            
            .bottom-nav {
                padding: 8px 0;
            }
        }

        /* Animation Modal Styles */
.team-logo-large {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.team-display {
    text-align: center;
    flex: 1;
}

.vs-badge {
    align-self: center;
}

.animation-container {
    position: relative;
    background: rgba(0,0,0,0.1);
    border-radius: 12px;
    padding: 15px;
    margin: 15px 0;
}

.stadium-canvas {
    position: relative;
    overflow: hidden;
    border: 2px solid rgba(255,255,255,0.1);
}

.player {
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
}

.ball {
    transition: all 0.2s ease;
    z-index: 10;
}

.animation-controls {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}

.stat-box {
    padding: 10px;
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.1);
}

.stat-box i {
    font-size: 1.2rem;
    margin-bottom: 5px;
}

.stat-box h6 {
    font-size: 1.3rem;
    margin: 5px 0;
    font-weight: 700;
}

.stat-box small {
    font-size: 0.75rem;
    color: #94a3b8;
}

/* Goal celebration animation */
@keyframes goalCelebration {
    0% { transform: scale(1); }
    50% { transform: scale(1.5); }
    100% { transform: scale(1); }
}

.goal-animation {
    animation: goalCelebration 0.5s ease;
}

/* Player movement animations */
@keyframes movePlayer {
    0% { transform: translate(-50%, -50%); }
    100% { transform: translate(-50%, -50%) translateX(20px); }
}

.player-moving {
    animation: movePlayer 1s ease-in-out infinite alternate;
}

/* Mobile optimization for modal */
@media (max-width: 576px) {
    .team-logo-large {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
    
    .stadium-canvas {
        height: 180px !important;
    }
    
    .animation-controls .btn {
        padding: 5px 10px;
        font-size: 0.8rem;
    }
}

/* Touch device modal improvements */
.modal-content {
    max-height: 90vh;
    overflow-y: auto;
}

.modal-body {
    padding: 20px 15px;
}
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo-container">
                    <div class="logo-icon">
                        <i class="fas fa-futbol"></i>
                    </div>
                    <div>
                        <h1 class="site-title animate__animated animate__fadeIn">XtraBet LiveScore</h1>
                        <p class="site-subtitle">Real-time football scores & updates</p>
                    </div>
                </div>
                <div class="header-controls">
                    <div class="live-indicator d-none d-sm-flex">
                        <span class="pulse-dot"></span>
                        <span class="me-2">LIVE</span>
                    </div>
                    <a href="#" class="bet-btn">
                        <i class="fas fa-coins me-1"></i> Bet Now
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-container">
        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <h6>LIVE MATCHES</h6>
                <h2 id="liveCount">0</h2>
            </div>
            <div class="stat-card">
                <h6>TOTAL GOALS</h6>
                <h2 id="totalGoals">0</h2>
            </div>
            <div class="stat-card">
                <h6>LEAGUES</h6>
                <h2 id="leagueCount">0</h2>
            </div>
            <div class="stat-card">
                <h6>LAST UPDATE</h6>
                <h5 id="lastUpdate">--:--</h5>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loading" class="loading-container">
            <div class="spinner-border text-primary spinner-large" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h4 class="mt-3 animate__animated animate__pulse">Loading live matches...</h4>
            <p class="text-muted">Fetching real-time scores</p>
        </div>

        <!-- Error State -->
        <div id="errorContainer" class="error-container" style="display: none;">
            <div class="error-icon text-warning">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h4>Unable to Load Matches</h4>
            <p id="errorMessage" class="mb-3"></p>
            <button class="btn btn-primary" onclick="loadMatches()">
                <i class="fas fa-redo me-1"></i> Try Again
            </button>
        </div>

        <!-- Matches Container -->
        <div id="matchesContainer" style="display: none;"></div>
    </main>

    <!-- Refresh Button -->
    <button class="refresh-btn" onclick="forceRefresh()" title="Refresh matches">
        <i class="fas fa-sync-alt"></i>
    </button>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <div class="container">
            <div class="nav-grid">
                <a href="#" class="nav-item active" onclick="showSection('matches')">
                    <i class="fas fa-home nav-icon"></i>
                    <span class="nav-text">Home</span>
                </a>
                <a href="#" class="nav-item" target="_blank">
                    <i class="fas fa-coins nav-icon"></i>
                    <span class="nav-text">Bet Now</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-cog nav-icon"></i>
                    <span class="nav-text">Register</span>
                </a>
            </div>
        </div>
    </nav>

<!-- LIVESCORE WIDGET SOCCERSAPI.COM -->
<div id="ls-widget" data-w="wo_w694167419ca15a79c8eb5ef3_6941676fa99b5" class="livescore-widget"></div>
<script type="text/javascript" src="https://ls.soccersapi.com/widget/res/wo_w694167419ca15a79c8eb5ef3_6941676fa99b5/widget.js"></script>
<!-- LIVESCORE WIDGET SOCCERSAPI.COM -->


    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 XtraBet LiveScore. All rights reserved.</p>
        </div>
    </footer>

   <!-- Animation Modal -->
<div class="modal fade" id="animationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Match Preview</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <h4 id="matchTitle" class="mb-2"></h4>
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <div class="team-display">
                            <div class="team-logo-large bg-primary">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h5 id="homeTeamName" class="mt-2 mb-0"></h5>
                        </div>
                        <div class="vs-badge">
                            <span class="badge bg-warning px-3 py-2">VS</span>
                        </div>
                        <div class="team-display">
                            <div class="team-logo-large bg-danger">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h5 id="awayTeamName" class="mt-2 mb-0"></h5>
                        </div>
                    </div>
                </div>
                
                <div class="animation-container mb-4">
                    <div class="stadium-canvas" style="height: 200px; position: relative; background: linear-gradient(to bottom, #2ecc71 0%, #27ae60 100%); border-radius: 10px; overflow: hidden;">
                        <!-- Stadium field -->
                        <div class="field-lines" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                            <!-- Center line -->
                            <div style="position: absolute; top: 0; left: 50%; width: 2px; height: 100%; background: white; opacity: 0.3; transform: translateX(-50%);"></div>
                            <!-- Center circle -->
                            <div style="position: absolute; top: 50%; left: 50%; width: 80px; height: 80px; border: 2px solid white; border-radius: 50%; opacity: 0.3; transform: translate(-50%, -50%);"></div>
                            <!-- Goals -->
                            <div style="position: absolute; top: 50%; left: 10px; width: 5px; height: 40px; background: white; opacity: 0.5; transform: translateY(-50%);"></div>
                            <div style="position: absolute; top: 50%; right: 10px; width: 5px; height: 40px; background: white; opacity: 0.5; transform: translateY(-50%);"></div>
                        </div>
                        
                        <!-- Players -->
                        <div id="playerHome" class="player" style="position: absolute; width: 20px; height: 20px; background: #3b82f6; border-radius: 50%; top: 50%; left: 30%; transform: translate(-50%, -50%);"></div>
                        <div id="playerAway" class="player" style="position: absolute; width: 20px; height: 20px; background: #ef4444; border-radius: 50%; top: 50%; left: 70%; transform: translate(-50%, -50%);"></div>
                        
                        <!-- Ball -->
                        <div id="ball" class="ball" style="position: absolute; width: 12px; height: 12px; background: white; border-radius: 50%; top: 50%; left: 50%; transform: translate(-50%, -50%); box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>
                    </div>
                </div>
                
                <div class="animation-controls text-center mb-0">
                    <button class="btn btn-sm btn-outline-light me-2" onclick="()" id="animationToggle">
                        <i class="fas fa-play"></i> 
                    </button>
                    <button class="btn btn-sm btn-outline-light me-2" onclick="()">
                        <i class="fas fa-futbol"></i> 
                    </button>
                    <button class="btn btn-sm btn-outline-light" onclick="()">
                        <i class="fas fa-redo"></i> 
                    </button>
                </div>
                
                <div class="match-info">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="stat-box">
                                <i class="fas fa-futbol text-primary"></i>
                                <h6 id="homeGoals">0</h6>
                                <small>Goals</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box">
                                <i class="fas fa-clock text-warning"></i>
                                <h6 id="matchTime">0'</h6>
                                <small>Time</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box">
                                <i class="fas fa-futbol text-danger"></i>
                                <h6 id="awayGoals">0</h6>
                                <small>Goals</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Global variables
    let allMatches = [];
    let refreshInterval;
    
    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded, initializing...');
        loadMatches();
        
        // Auto-refresh every 10 seconds
        refreshInterval = setInterval(loadMatches, 10000);
        
        // Handle visibility change (when user switches tabs)
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                loadMatches(); // Refresh when user comes back to tab
            }
        });
        
        // Handle online/offline status
        window.addEventListener('online', function() {
            loadMatches();
            showNotification('Back online! Refreshing matches...', 'success');
        });
        
        window.addEventListener('offline', function() {
            showNotification('You are offline. Some features may not work.', 'warning');
        });
    });
    
    // Load matches from API
    async function loadMatches() {
        console.log('Loading matches...');
        
        // Show loading, hide others
        document.getElementById('loading').style.display = 'block';
        document.getElementById('matchesContainer').style.display = 'none';
        document.getElementById('errorContainer').style.display = 'none';
        
        // Update time
        const now = new Date();
        document.getElementById('lastUpdate').textContent = 
            now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        
        try {
            // Add cache-busting parameter
            const url = `../api/get_matches.php?t=${Date.now()}`;
            const response = await fetch(url, {
                cache: 'no-cache',
                headers: {
                    'Pragma': 'no-cache',
                    'Cache-Control': 'no-cache'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            
            // Get response text
            const text = await response.text();
            
            // Parse JSON
            let data;
            try {
                data = JSON.parse(text);
            } catch (parseError) {
                console.error('JSON Parse Error:', parseError);
                throw new Error('Invalid response from server');
            }
            
            // Check if successful
            if (data.success && data.matches) {
                allMatches = data.matches;
                renderMatches(allMatches);
                updateStats(allMatches);
                
                // Show matches container
                document.getElementById('matchesContainer').style.display = 'block';
            } else {
                throw new Error(data.error || 'Failed to load matches');
            }
            
        } catch (error) {
            console.error('Error loading matches:', error);
            showError(error.message);
        } finally {
            document.getElementById('loading').style.display = 'none';
        }
    }
    
    // Render matches with mobile-optimized layout
    function renderMatches(matches) {
        const container = document.getElementById('matchesContainer');
        
        if (!matches || matches.length === 0) {
            container.innerHTML = `
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-futbol fa-3x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-3">No Matches Available</h4>
                    <p class="text-muted mb-4">There are no matches scheduled at the moment.</p>
                    <a href="#" class="btn bet-btn">
                        <i class="fas fa-coins me-2"></i> Place a Bet
                    </a>
                </div>
            `;
            return;
        }
        
        // Group matches by league
        const matchesByLeague = {};
        matches.forEach(match => {
            if (!matchesByLeague[match.league_name]) {
                matchesByLeague[match.league_name] = [];
            }
            matchesByLeague[match.league_name].push(match);
        });
        
        // Generate HTML with mobile-first design
        let html = '';
        
        Object.keys(matchesByLeague).forEach(league => {
            html += `
                <div class="league-header animate__animated animate__fadeIn">
                    <h4>
                        <i class="fas fa-trophy text-warning"></i>
                        ${escapeHtml(league)}
                    </h4>
                    <span class="league-count">${matchesByLeague[league].length}</span>
                </div>
            `;
            
            matchesByLeague[league].forEach(match => {
                const isLive = match.status === 'first' || match.status === 'second';
                const isEnded = match.status === 'ended';
                
                // Calculate match time
                const matchTime = getMatchTime(match);
                let statusClass = 'bg-secondary';
                let statusText = 'Scheduled';
                
                if (isLive) {
                    statusClass = 'bg-danger';
                    statusText = `LIVE ${matchTime}`;
                } else if (isEnded) {
                    statusClass = 'bg-dark';
                    statusText = 'FT';
                } else if (match.status === 'break') {
                    statusClass = 'bg-warning text-dark';
                    statusText = 'HT';
                }
                
                // Format date for mobile
                const matchDate = new Date(match.match_date);
                const formattedDate = matchDate.toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: 'numeric'
                }) + ' ' + matchDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                
                html += `
                    <div class="match-card ${isLive ? 'live' : ''} animate__animated animate__fadeInUp" 
                         onclick="showAnimation('${escapeHtml(match.team_home)}', '${escapeHtml(match.team_away)}')"
                         style="animation-delay: ${Math.random() * 0.2}s">
                        <div class="match-header">
                            <div class="match-status">
                                <span class="badge ${statusClass} status-badge">
                                    ${statusText}
                                </span>
                                <span class="match-time">${matchTime}</span>
                            </div>
                        </div>
                        
                        <div class="teams-container">
                            <div class="team home-team">
                                <div class="team-logo">
                                    <i class="fas fa-shield-alt" style="color: #60a5fa;"></i>
                                </div>
                                <div class="team-name text-end">${escapeHtml(match.team_home)}</div>
                            </div>
                            
                            <div class="score-container">
                                <div class="score">
                                    <span class="home-score">${match.home_goals}</span>
                                    <span class="score-divider">-</span>
                                    <span class="away-score">${match.away_goals}</span>
                                </div>
                                <div class="match-date">${formattedDate}</div>
                            </div>
                            
                            <div class="team away-team">
                                <div class="team-logo">
                                    <i class="fas fa-shield-alt" style="color: #f87171;"></i>
                                </div>
                                <div class="team-name">${escapeHtml(match.team_away)}</div>
                            </div>
                        </div>
                        
                        ${(match.stoppage_time > 0) ? `
                        <div class="match-footer">
                            <span class="stoppage-badge">
                                <i class="fas fa-clock"></i>
                                +${match.stoppage_time}' stoppage time
                            </span>
                        </div>` : ''}
                    </div>
                `;
            });
        });
        
        container.innerHTML = html;
    }
    
    // Calculate match time
    function getMatchTime(match) {
        if (match.status === 'waiting') {
            const matchDate = new Date(match.match_date);
            return matchDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        }
        
        if (match.status === 'ended') return 'FT';
        if (match.status === 'break') return 'HT';
        
        if (match.start_time && (match.status === 'first' || match.status === 'second')) {
            const startTime = new Date(match.start_time);
            const now = new Date();
            const elapsedMinutes = Math.floor((now - startTime) / (1000 * 60));
            
            if (match.status === 'first') {
                const currentMinute = Math.min(45 + (parseInt(match.first_half_stoppage) || 0), elapsedMinutes);
                return currentMinute > 0 ? currentMinute + "'" : "0'";
            } else {
                const secondHalfElapsed = Math.max(0, elapsedMinutes - 45);
                const currentMinute = Math.min(45 + (parseInt(match.second_half_stoppage) || 0), secondHalfElapsed) + 45;
                return currentMinute + "'";
            }
        }
        
        return "0'";
    }
    
    // Update statistics
    function updateStats(matches) {
        const liveMatches = matches.filter(m => m.status === 'first' || m.status === 'second');
        const totalGoals = matches.reduce((sum, match) => sum + parseInt(match.home_goals) + parseInt(match.away_goals), 0);
        const leagues = [...new Set(matches.map(m => m.league_name))];
        
        // Animate number changes
        animateNumber('liveCount', liveMatches.length);
        animateNumber('totalGoals', totalGoals);
        animateNumber('leagueCount', leagues.length);
    }
    
    // Animate number changes
    function animateNumber(elementId, targetValue) {
        const element = document.getElementById(elementId);
        if (!element) return;
        
        const current = parseInt(element.textContent) || 0;
        const diff = targetValue - current;
        
        if (diff === 0) return;
        
        const duration = 500;
        const startTime = Date.now();
        
        function update() {
            const elapsed = Date.now() - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easeProgress = 1 - Math.pow(1 - progress, 10); // Ease out cubic
            const value = Math.floor(current + diff * easeProgress);
            
            element.textContent = value;
            
            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }
        
        requestAnimationFrame(update);
    }
    
    // Show error message
    function showError(message) {
        document.getElementById('errorMessage').textContent = message;
        document.getElementById('errorContainer').style.display = 'block';
    }
    
    // Force refresh
    function forceRefresh() {
        // Add visual feedback
        const btn = document.querySelector('.refresh-btn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btn.disabled = true;
        
        // Clear existing interval and restart
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
        
        loadMatches().finally(() => {
            // Restore button
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-sync-alt"></i>';
                btn.disabled = false;
            }, 1000);
            
            // Restart auto-refresh
            refreshInterval = setInterval(loadMatches, 10000);
        });
        
        showNotification('Refreshing matches...', 'info');
    }
    
    // Show notification
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existing = document.querySelector('.notification-toast');
        if (existing) existing.remove();
        
        // Create notification
        const notification = document.createElement('div');
        notification.className = `notification-toast notification-${type}`;
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                <span>${message}</span>
            </div>
        `;
        
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            z-index: 9999;
            animation: slideDown 0.3s ease;
            max-width: 90%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        `;
        
        document.body.appendChild(notification);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideUp 0.3s ease';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
        
        // Add animation styles
        if (!document.querySelector('#notification-styles')) {
            const style = document.createElement('style');
            style.id = 'notification-styles';
            style.textContent = `
                @keyframes slideDown {
                    from { transform: translateX(-50%) translateY(-100%); opacity: 0; }
                    to { transform: translateX(-50%) translateY(0); opacity: 1; }
                }
                @keyframes slideUp {
                    from { transform: translateX(-50%) translateY(0); opacity: 1; }
                    to { transform: translateX(-50%) translateY(-100%); opacity: 0; }
                }
            `;
            document.head.appendChild(style);
        }
    }
    
    // Animation variables
let animationInterval;
let isAnimating = false;
let ballPosition = { x: 50, y: 50 };
let ballDirection = { x: 1, y: 0.5 };
let matchTime = 0;
let homeGoals = 0;
let awayGoals = 0;
let currentMatch = null;

// Show animation modal with match details
function showAnimation(homeTeam, awayTeam, matchData = null) {
    // Store match data if provided
    if (matchData) {
        currentMatch = matchData;
        homeGoals = parseInt(matchData.home_goals) || 0;
        awayGoals = parseInt(matchData.away_goals) || 0;
        matchTime = calculateAnimationTime(matchData);
    } else {
        // Find match in allMatches
        const match = allMatches.find(m => 
            m.team_home === homeTeam && m.team_away === awayTeam
        );
        if (match) {
            currentMatch = match;
            homeGoals = parseInt(match.home_goals) || 0;
            awayGoals = parseInt(match.away_goals) || 0;
            matchTime = calculateAnimationTime(match);
        } else {
            homeGoals = Math.floor(Math.random() * 4);
            awayGoals = Math.floor(Math.random() * 4);
            matchTime = Math.floor(Math.random() * 90);
        }
    }
    
    // Update modal content
    document.getElementById('matchTitle').textContent = `${homeTeam} vs ${awayTeam}`;
    document.getElementById('homeTeamName').textContent = homeTeam;
    document.getElementById('awayTeamName').textContent = awayTeam;
    document.getElementById('homeGoals').textContent = homeGoals;
    document.getElementById('awayGoals').textContent = awayGoals;
    document.getElementById('matchTime').textContent = matchTime + "'";
    
    // Reset animation state
    resetAnimation();
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('animationModal'));
    modal.show();
    
    // Start animation automatically
    setTimeout(() => {
        startAnimation();
    }, 500);
}

// Calculate animation time based on match status
function calculateAnimationTime(match) {
    if (match.status === 'waiting') return 0;
    if (match.status === 'ended') return 90;
    if (match.status === 'break') return 45;
    
    if (match.start_time && (match.status === 'first' || match.status === 'second')) {
        const startTime = new Date(match.start_time);
        const now = new Date();
        const elapsedMinutes = Math.floor((now - startTime) / (1000 * 60));
        
        if (match.status === 'first') {
            return Math.min(45 + (parseInt(match.first_half_stoppage) || 0), elapsedMinutes);
        } else {
            const secondHalfElapsed = Math.max(0, elapsedMinutes - 45);
            return Math.min(45 + (parseInt(match.second_half_stoppage) || 0), secondHalfElapsed) + 45;
        }
    }
    
    return Math.floor(Math.random() * 90);
}

// Start animation
function startAnimation() {
    if (isAnimating) return;
    
    isAnimating = true;
    document.getElementById('animationToggle').innerHTML = 
    
    animationInterval = setInterval(() => {
        // Move ball
        ballPosition.x += ballDirection.x;
        ballPosition.y += ballDirection.y;
        
        // Bounce off walls
        if (ballPosition.x <= 5 || ballPosition.x >= 95) {
            ballDirection.x *= -1;
            // Add some randomness
            ballDirection.y += (Math.random() - 0.5) * 0.5;
        }
        
        if (ballPosition.y <= 10 || ballPosition.y >= 90) {
            ballDirection.y *= -1;
            ballDirection.x += (Math.random() - 0.5) * 0.5;
        }
        
        // Keep direction vectors normalized
        const speed = Math.sqrt(ballDirection.x * ballDirection.x + ballDirection.y * ballDirection.y);
        ballDirection.x = (ballDirection.x / speed) * 1.5;
        ballDirection.y = (ballDirection.y / speed) * 1.5;
        
        // Update ball position
        const ball = document.getElementById('ball');
        if (ball) {
            ball.style.left = ballPosition.x + '%';
            ball.style.top = ballPosition.y + '%';
        }
        
        // Move players towards ball
        movePlayersTowardsBall();
        
        // Increment match time slowly
        if (matchTime < 90) {
            matchTime += 0.1;
            document.getElementById('matchTime').textContent = Math.floor(matchTime) + "'";
        }
        
    }, 50); // Update every 50ms
}

// Stop animation
function stopAnimation() {
    isAnimating = false;
    clearInterval(animationInterval);
    document.getElementById('animationToggle').innerHTML = '<i class="fas fa-play"></i> Play';
}

// Toggle animation play/pause
function toggleAnimation() {
    if (isAnimating) {
        stopAnimation();
    } else {
        startAnimation();
    }
}

// Move players towards ball
function movePlayersTowardsBall() {
    const playerHome = document.getElementById('playerHome');
    const playerAway = document.getElementById('playerAway');
    
    if (!playerHome || !playerAway) return;
    
    // Get current positions (simplified)
    const homeRect = playerHome.getBoundingClientRect();
    const awayRect = playerAway.getBoundingClientRect();
    const ballRect = document.getElementById('ball').getBoundingClientRect();
    
    // Move home player towards ball (simplified animation)
    const homeX = parseFloat(playerHome.style.left || '30');
    const homeY = parseFloat(playerHome.style.top || '50');
    
    const ballX = ballPosition.x;
    const ballY = ballPosition.y;
    
    // Move towards ball slowly
    const newHomeX = homeX + (ballX - homeX) * 0.02;
    const newHomeY = homeY + (ballY - homeY) * 0.02;
    
    playerHome.style.left = newHomeX + '%';
    playerHome.style.top = newHomeY + '%';
    
    // Move away player away from ball (defending)
    const awayX = parseFloat(playerAway.style.left || '70');
    const awayY = parseFloat(playerAway.style.top || '50');
    
    const newAwayX = awayX + (ballX - awayX) * 0.01;
    const newAwayY = awayY + (ballY - awayY) * 0.01;
    
    playerAway.style.left = newAwayX + '%';
    playerAway.style.top = newAwayY + '%';
}

// Celebrate goal animation
function celebrateGoal() {
    // Randomly choose which team scores
    const scoringTeam = Math.random() > 0.5 ? 'home' : 'away';
    
    if (scoringTeam === 'home') {
        homeGoals++;
        document.getElementById('homeGoals').textContent = homeGoals;
    } else {
        awayGoals++;
        document.getElementById('awayGoals').textContent = awayGoals;
    }
    
    // Goal celebration animation
    const ball = document.getElementById('ball');
    ball.classList.add('goal-animation');
    
    // Flash the scoring team's side
    const teamDisplay = scoringTeam === 'home' ? 
        document.getElementById('homeTeamName') : 
        document.getElementById('awayTeamName');
    
    const originalColor = teamDisplay.style.color;
    teamDisplay.style.color = '#fbbf24';
    teamDisplay.style.transition = 'color 0.3s';
    
    // Reset ball to center after goal
    setTimeout(() => {
        ballPosition = { x: 50, y: 50 };
        ball.style.left = '50%';
        ball.style.top = '50%';
        ball.classList.remove('goal-animation');
        teamDisplay.style.color = originalColor;
    }, 1000);
    
    // Show notification
    showNotification(`${scoringTeam === 'home' ? 'Home' : 'Away'} team scores!`, 'success');
}

// Reset animation
function resetAnimation() {
    stopAnimation();
    
    // Reset positions
    ballPosition = { x: 50, y: 50 };
    ballDirection = { x: 1, y: 0.5 };
    
    const ball = document.getElementById('ball');
    if (ball) {
        ball.style.left = '50%';
        ball.style.top = '50%';
        ball.classList.remove('goal-animation');
    }
    
    const playerHome = document.getElementById('playerHome');
    const playerAway = document.getElementById('playerAway');
    
    if (playerHome) {
        playerHome.style.left = '30%';
        playerHome.style.top = '50%';
    }
    
    if (playerAway) {
        playerAway.style.left = '70%';
        playerAway.style.top = '50%';
    }
    
    // Reset match data if available
    if (currentMatch) {
        homeGoals = parseInt(currentMatch.home_goals) || 0;
        awayGoals = parseInt(currentMatch.away_goals) || 0;
        matchTime = calculateAnimationTime(currentMatch);
    } else {
        homeGoals = 0;
        awayGoals = 0;
        matchTime = 0;
    }
    
    // Update displays
    document.getElementById('homeGoals').textContent = homeGoals;
    document.getElementById('awayGoals').textContent = awayGoals;
    document.getElementById('matchTime').textContent = Math.floor(matchTime) + "'";
    
    document.getElementById('animationToggle').innerHTML = '<i class="fas fa-play"></i> Play';
}

// Update match card click to pass match data
function updateMatchCardClick() {
    document.querySelectorAll('.match-card').forEach(card => {
        card.onclick = function() {
            const matchId = this.getAttribute('data-match-id');
            const match = allMatches.find(m => m.id == matchId);
            
            if (match) {
                showAnimation(match.team_home, match.team_away, match);
            } else {
                // Fallback if match not found
                const teams = this.querySelector('.team-name');
                if (teams) {
                    const homeTeam = this.querySelector('.home-team .team-name')?.textContent.trim();
                    const awayTeam = this.querySelector('.away-team .team-name')?.textContent.trim();
                    if (homeTeam && awayTeam) {
                        showAnimation(homeTeam, awayTeam);
                    }
                }
            }
        };
    });
}

// Update renderMatches function to add data attributes
function renderMatches(matches) {
    const container = document.getElementById('matchesContainer');
    
    if (!matches || matches.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-futbol fa-3x text-muted"></i>
                </div>
                <h4 class="text-muted mb-3">No Matches Available</h4>
                <p class="text-muted mb-4">There are no matches scheduled at the moment.</p>
                <a href="#" class="btn bet-btn">
                    <i class="fas fa-coins me-2"></i> Place a Bet
                </a>
            </div>
        `;
        return;
    }
    
    // Group matches by league
    const matchesByLeague = {};
    matches.forEach(match => {
        if (!matchesByLeague[match.league_name]) {
            matchesByLeague[match.league_name] = [];
        }
        matchesByLeague[match.league_name].push(match);
    });
    
    // Generate HTML with mobile-first design
    let html = '';
    
    Object.keys(matchesByLeague).forEach(league => {
        html += `
            <div class="league-header animate__animated animate__fadeIn">
                <h4>
                    <i class="fas fa-trophy text-warning"></i>
                    ${escapeHtml(league)}
                </h4>
                <span class="league-count">${matchesByLeague[league].length}</span>
            </div>
        `;
        
        matchesByLeague[league].forEach(match => {
            const isLive = match.status === 'first' || match.status === 'second';
            const isEnded = match.status === 'ended';
            
            // Calculate match time
            const matchTime = getMatchTime(match);
            let statusClass = 'bg-secondary';
            let statusText = 'Scheduled';
            
            if (isLive) {
                statusClass = 'bg-danger';
                statusText = `LIVE ${matchTime}`;
            } else if (isEnded) {
                statusClass = 'bg-dark';
                statusText = 'FT';
            } else if (match.status === 'break') {
                statusClass = 'bg-warning text-dark';
                statusText = 'HT';
            }
            
            // Format date for mobile
            const matchDate = new Date(match.match_date);
            const formattedDate = matchDate.toLocaleDateString('en-US', { 
                month: 'short', 
                day: 'numeric'
            }) + ' ' + matchDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            
            html += `
                <div class="match-card ${isLive ? 'live' : ''} animate__animated animate__fadeInUp" 
                     data-match-id="${match.id}"
                     style="animation-delay: ${Math.random() * 0.2}s">
                    <div class="match-header">
                        <div class="match-status">
                            <span class="badge ${statusClass} status-badge">
                                ${statusText}
                            </span>
                            <span class="match-time">${matchTime}</span>
                        </div>
                    </div>
                    
                    <div class="teams-container">
                        <div class="team home-team">
                            <div class="team-logo">
                                <i class="fas fa-shield-alt" style="color: #60a5fa;"></i>
                            </div>
                            <div class="team-name text-end">${escapeHtml(match.team_home)}</div>
                        </div>
                        
                        <div class="score-container">
                            <div class="score">
                                <span class="home-score">${match.home_goals}</span>
                                <span class="score-divider">-</span>
                                <span class="away-score">${match.away_goals}</span>
                            </div>
                            <div class="match-date">${formattedDate}</div>
                        </div>
                        
                        <div class="team away-team">
                            <div class="team-logo">
                                <i class="fas fa-shield-alt" style="color: #f87171;"></i>
                            </div>
                            <div class="team-name">${escapeHtml(match.team_away)}</div>
                        </div>
                    </div>
                    
                    ${(match.stoppage_time > 0) ? `
                    <div class="match-footer">
                        <span class="stoppage-badge">
                            <i class="fas fa-clock"></i>
                            +${match.stoppage_time}' stoppage time
                        </span>
                    </div>` : ''}
                </div>
            `;
        });
    });
    
    container.innerHTML = html;
    
    // Add click event listeners to match cards
    updateMatchCardClick();
}

// Clean up animation when modal closes
document.getElementById('animationModal').addEventListener('hidden.bs.modal', function() {
    stopAnimation();
    resetAnimation();
});

// Handle escape key to close modal
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = bootstrap.Modal.getInstance(document.getElementById('animationModal'));
        if (modal) {
            modal.hide();
        }
    }
});
       
    // Utility function to escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Handle section switching
    function showSection(section) {
        // For future expansion if needed
        showNotification(`Showing ${section}`, 'info');
    }
    </script>
</body>
</html>