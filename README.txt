LIVE SCORE SYSTEM - INSTALLATION GUIDE

1. REQUIREMENTS:
   - PHP 7.4 or higher
   - MySQL 5.7 or higher
   - Web server (Apache/Nginx)
   - XAMPP/WAMP/MAMP recommended

2. INSTALLATION:
   a. Extract the zip file to your web server directory
   b. Create a MySQL database named: live_score_system
   c. Import the SQL file from database/live_score.sql
   d. Update database credentials in config.php if needed

3. ACCESS:
   - Admin Panel: http://localhost/your-folder/admin/
   - Viewer Page: http://localhost/your-folder/viewer/

4. FEATURES:
   - Multi-match live score system
   - Admin controls for all matches
   - Real-time updates for viewers
   - Group matches by league
   - Click teams for cartoon animations
   - Mobile responsive design

5. ADMIN CONTROLS:
   - Add/edit/delete matches
   - Start/stop matches
   - Update scores
   - Add stoppage time
   - Reset matches

6. NOTES:
   - No admin login required for demo (auto-login)
   - Real-time updates using Server-Sent Events
   - Cartoon animations using HTML5 Canvas
   - All data persists in MySQL database

7. TROUBLESHOOTING:
   - Ensure MySQL is running
   - Check PHP error logs
   - Verify file permissions
   - Clear browser cache if issues occur

Enjoy your Live Score System!