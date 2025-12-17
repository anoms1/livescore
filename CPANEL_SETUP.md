# cPanel Deployment Guide for XtraBet LiveScore

## Step 1: Create Database in cPanel

1. Login to your cPanel
2. Go to "MySQL Databases"
3. Create a new database:
   - Database name: `yourcpanel_livescore` (replace yourcpanel with your username)
4. Create a new user:
   - Username: `yourcpanel_livescore`
   - Password: `strongpassword123`
5. Add user to database with ALL privileges

## Step 2: Upload Files to cPanel

1. Use cPanel File Manager or FTP to upload files
2. Upload to: `public_html/livescore/` (or your preferred folder)
3. File structure should be: