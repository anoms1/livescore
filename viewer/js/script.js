// Enhanced JavaScript with error handling
document.addEventListener('DOMContentLoaded', function() {
    console.log('Document loaded, initializing...');
    
    // Initialize with error handling
    try {
        loadMatches();
        setupSSE();
        setupCanvas();
        setupEventListeners();
        
        // Show loading state
        showLoadingState();
        
        // Auto-refresh every 10 seconds
        setInterval(loadMatches, 10000);
        
        console.log('Initialization complete');
    } catch (error) {
        console.error('Initialization error:', error);
        showErrorState('Failed to initialize: ' + error.message);
    }
});

function showLoadingState() {
    const container = document.getElementById('matchesContainer');
    container.innerHTML = `
        <div class="loading-state text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h4 class="mt-3 animate__animated animate__pulse">Loading Live Matches...</h4>
            <p class="text-muted">Fetching real-time football scores</p>
            <div class="mt-4">
                <div class="progress" style="height: 5px; max-width: 300px; margin: 0 auto;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
                </div>
            </div>
        </div>
    `;
}

function showErrorState(message) {
    const container = document.getElementById('matchesContainer');
    container.innerHTML = `
        <div class="error-state text-center py-5">
            <div class="error-icon mb-4">
                <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
            </div>
            <h4 class="text-warning">Unable to Load Matches</h4>
            <p class="text-muted mb-4">${message}</p>
            <button class="btn btn-primary" onclick="loadMatches()">
                <i class="fas fa-redo"></i> Try Again
            </button>
            <div class="mt-4">
                <small class="text-muted">
                    If the problem persists, please check:
                    <ul class="list-unstyled mt-2">
                        <li><i class="fas fa-database"></i> Database connection</li>
                        <li><i class="fas fa-server"></i> Server status</li>
                        <li><i class="fas fa-wifi"></i> Internet connection</li>
                    </ul>
                </small>
            </div>
        </div>
    `;
}

function showEmptyState() {
    const container = document.getElementById('matchesContainer');
    container.innerHTML = `
        <div class="empty-state text-center py-5">
            <div class="empty-icon mb-4">
                <i class="fas fa-futbol fa-3x text-muted"></i>
            </div>
            <h4 class="text-muted">No Matches Scheduled</h4>
            <p class="text-muted mb-4">There are no matches available at the moment.</p>
            <div class="mt-4">
                <a href="../admin/" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add Matches in Admin Panel
                </a>
            </div>
            <div class="mt-4">
                <small class="text-muted">
                    Admin Panel: <a href="../admin/" class="text-primary">Click here to add matches</a>
                </small>
            </div>
        </div>
    `;
}

function loadMatches() {
    console.log('Loading matches...');
    
    // Show loading indicator
    document.querySelectorAll('.live-indicator').forEach(el => {
        el.innerHTML = `
            <span class="pulse-dot"></span>
            <span class="live-text">LOADING</span>
            <span class="update-time">Updating...</span>
        `;
    });
    
    fetch('../api/get_matches.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Matches data received:', data);
            
            // Update live indicator
            document.querySelectorAll('.live-indicator').forEach(el => {
                el.innerHTML = `
                    <span class="pulse-dot"></span>
                    <span class="live-text">LIVE</span>
                    <span class="update-time">Updated ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                `;
            });
            
            if (data.success) {
                if (data.matches && data.matches.length > 0) {
                    renderMatches(data.matches);
                    updateStats(data.matches);
                    
                    // Show success notification
                    showNotification('success', `Loaded ${data.matches.length} matches`);
                } else {
                    showEmptyState();
                    updateStats([]);
                }
            } else {
                showErrorState(data.error || 'Failed to load matches');
                console.error('API Error:', data.error);
            }
        })
        .catch(error => {
            console.error('Error loading matches:', error);
            showErrorState('Network error: ' + error.message);
            
            // Show connection error in live indicator
            document.querySelectorAll('.live-indicator').forEach(el => {
                el.innerHTML = `
                    <span class="pulse-dot" style="background: #f59e0b;"></span>
                    <span class="live-text" style="color: #f59e0b;">OFFLINE</span>
                    <span class="update-time">Connection lost</span>
                `;
            });
        });
}

function updateStats(matches) {
    try {
        const liveMatches = matches.filter(m => m.status === 'first' || m.status === 'second');
        const totalGoals = matches.reduce((sum, match) => sum + match.home_goals + match.away_goals, 0);
        const leagues = [...new Set(matches.map(m => m.league_name))];
        const teams = [...new Set(matches.flatMap(m => [m.team_home, m.team_away]))];
        
        // Update stats with animation
        animateValue('live-matches-count', parseInt(document.getElementById('live-matches-count').textContent) || 0, liveMatches.length, 500);
        animateValue('total-goals', parseInt(document.getElementById('total-goals').textContent) || 0, totalGoals, 1000);
        animateValue('active-matches', parseInt(document.getElementById('active-matches').textContent) || 0, liveMatches.length, 500);
        animateValue('total-leagues', parseInt(document.getElementById('total-leagues').textContent) || 0, leagues.length, 500);
        animateValue('total-teams', parseInt(document.getElementById('total-teams').textContent) || 0, teams.length, 500);
        
    } catch (error) {
        console.error('Error updating stats:', error);
    }
}

function animateValue(elementId, start, end, duration) {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const value = Math.floor(progress * (end - start) + start);
        element.textContent = value;
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

function setupSSE() {
    try {
        // For browsers that support EventSource
        if (typeof EventSource !== 'undefined') {
            const eventSource = new EventSource('sse.php');
            
            eventSource.onmessage = function(event) {
                try {
                    const data = JSON.parse(event.data);
                    if (data.type === 'update') {
                        console.log('SSE Update received:', data);
                        loadMatches();
                        
                        // Show update notification
                        showNotification('info', 'Live scores updated!', 2000);
                    }
                } catch (e) {
                    console.error('SSE parse error:', e);
                }
            };
            
            eventSource.onerror = function(error) {
                console.log('SSE connection error, falling back to polling');
                eventSource.close();
            };
            
            // Store reference for cleanup
            window.sseConnection = eventSource;
        }
    } catch (error) {
        console.error('SSE setup error:', error);
    }
}

function showNotification(type, message, duration = 3000) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        z-index: 9999;
        animation: slideInRight 0.3s ease;
        max-width: 300px;
    `;
    
    document.body.appendChild(notification);
    
    // Remove after duration
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, duration);
}

// Add CSS animations for notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);

// ... [Rest of your JavaScript functions remain the same]