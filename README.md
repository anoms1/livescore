# livescore
🏆 XtraBet LiveScore - Professional football score tracking for betting/gaming platforms Live scores, real-time updates, admin controls, and mobile optimization for sports betting websites.


# ⚽ XtraBet LiveScore - Real-Time Football Score System

![XtraBet LiveScore](assets/images/logo.png)

A professional, real-time football score tracking system with admin controls, mobile-responsive design, and animated match previews.

## 🎯 Features

- **Real-time Updates** - Auto-refresh every 3 seconds
- **Multi-Match Support** - Handle multiple leagues and matches simultaneously
- **Admin Control Panel** - Full match management (add/edit/delete)
- **Mobile-First Design** - Responsive on all devices
- **Live Animations** - Interactive match previews
- **League Grouping** - Matches organized by league
- **Auto Statistics** - Live match counts, goals, leagues
- **SSE (Server-Sent Events)** - Instant updates for all viewers

## 🚀 Quick Start

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- cPanel hosting (optional)

### Installation

#### Method 1: One-Click Setup
1. Upload files to your server
2. Visit `https://yourdomain.com/setup.php`
3. Follow the setup wizard
4. Done! 🎉

#### Method 2: Manual Installation
```bash
# Clone repository
git clone https://github.com/anoms1/xtrabet-livescore.git

# Upload to server via FTP/cPanel

# Create database
# Import database/live_score.sql via phpMyAdmin

# Configure database
cp config-sample.php config.php
# Edit config.php with your credentials



📱 Usage
For Viewers
Access: https://yourdomain.com/viewer/

Features: Live scores, match animations, auto-updates

For Administrators
Access: https://yourdomain.com/admin/

Features: Add/edit/delete matches, control scores, manage leagues

API Endpoints
GET /api/get_matches.php - Get all matches

POST /api/update_score.php - Update match score

POST /api/update_status.php - Update match status

POST /api/update_stoppage.php - Add stoppage time






📊 Features Breakdown
Core Features
✅ Real-time score updates

✅ Multiple leagues support

✅ Live match timing with stoppage

✅ Match status tracking (waiting, live, ended)

✅ Goal notifications

✅ Mobile responsive design

Admin Features
✅ Add/Edit/Delete matches

✅ Start/Stop matches

✅ Update scores in real-time

✅ Add stoppage time

✅ Reset matches

✅ League management

Viewer Features
✅ Live match indicators

✅ Match animations on click

✅ Auto-refresh

✅ League grouping

✅ Match statistics

✅ Mobile navigation

🔧 Advanced Configuration
Customizing Branding
Edit viewer/css/style.css:

css
:root {
    --brand-primary: #FF6B00;    /* Your brand color */
    --brand-secondary: #003366;  /* Secondary color */
}






