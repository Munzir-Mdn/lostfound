CREATE DATABASE IF NOT EXISTS lost_found_db;
USE lost_found_db;

CREATE TABLE IF NOT EXISTS lost_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  date_lost DATE NOT NULL,
  image VARCHAR(255),
  status ENUM('pending', 'claimed') DEFAULT 'pending'
);
