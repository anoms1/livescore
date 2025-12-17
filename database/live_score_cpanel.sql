-- XtraBet LiveScore - Database Structure for cPanel
-- Run this in phpMyAdmin or cPanel MySQL Databases

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Create database if not exists (run this separately in cPanel)
-- CREATE DATABASE IF NOT EXISTS `your_database_name` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
-- USE `your_database_name`;

-- Table structure for matches
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
  PRIMARY KEY (`id`),
  KEY `league_name` (`league_name`),
  KEY `status` (`status`),
  KEY `match_date` (`match_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for scores
CREATE TABLE IF NOT EXISTS `scores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL,
  `home_goals` int(11) DEFAULT 0,
  `away_goals` int(11) DEFAULT 0,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `match_id` (`match_id`),
  CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample data
INSERT INTO `matches` (`league_name`, `team_home`, `team_away`, `match_date`, `status`) VALUES
('Premier League', 'Manchester United', 'Liverpool', NOW() + INTERVAL 1 DAY, 'waiting'),
('Premier League', 'Chelsea', 'Arsenal', NOW() + INTERVAL 2 DAY, 'waiting'),
('La Liga', 'Barcelona', 'Real Madrid', NOW() + INTERVAL 3 DAY, 'waiting'),
('La Liga', 'Atletico Madrid', 'Sevilla', NOW() + INTERVAL 4 DAY, 'waiting'),
('Bundesliga', 'Bayern Munich', 'Borussia Dortmund', NOW() + INTERVAL 5 DAY, 'waiting');

INSERT INTO `scores` (`match_id`, `home_goals`, `away_goals`) VALUES
(1, 0, 0),
(2, 0, 0),
(3, 0, 0),
(4, 0, 0),
(5, 0, 0);