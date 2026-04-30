-- Create database if not exists
CREATE DATABASE IF NOT EXISTS government_desk;
-- Use the database
USE government_desk;
-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    login_time DATETIME DEFAULT CURRENT_TIMESTAMP
);
-- Create the feedback table in your government_desk database
CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rating INT NOT NULL,
    feedback TEXT,
    submit_time DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS grievances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    grievance_text TEXT NOT NULL,
    file_path VARCHAR(255),
    submission_time DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create the callback table in your government_desk database
CREATE TABLE IF NOT EXISTS callbacks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phone_number VARCHAR(20) NOT NULL,
    submission_time DATETIME DEFAULT CURRENT_TIMESTAMP
);
