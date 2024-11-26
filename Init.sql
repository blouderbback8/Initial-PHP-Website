-- Drop the database completely and recreate it
DROP DATABASE IF EXISTS bjj_lineage;
CREATE DATABASE bjj_lineage;
USE bjj_lineage;

-- Disable foreign key checks
SET FOREIGN_KEY_CHECKS = 0;

-- Create LoginAttempts table for tracking failed login attempts
CREATE TABLE LoginAttempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX(email)
);

-- Create Users table with role column
CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user' -- Added role column with default value
);

-- Create Fighters table
CREATE TABLE Fighters (
    fighter_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    age INT,
    belt_rank VARCHAR(50),
    gender VARCHAR(10)
);

-- Create Schools table
CREATE TABLE Schools (
    school_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(100)
);

-- Create fighter_affiliations table with foreign keys
CREATE TABLE fighter_affiliations (
    affiliation_id INT AUTO_INCREMENT PRIMARY KEY,
    fighter_id INT,
    school_id INT,
    join_date DATE,
    FOREIGN KEY (fighter_id) REFERENCES Fighters(fighter_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (school_id) REFERENCES Schools(school_id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create Tournaments table
CREATE TABLE Tournaments (
    tournament_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(100) NOT NULL,
    date DATE NOT NULL
);

-- Create Instructors table with foreign keys
CREATE TABLE Instructors (
    instructor_id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT,
    student_id INT,
    date DATE,
    FOREIGN KEY (teacher_id) REFERENCES Fighters(fighter_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (student_id) REFERENCES Fighters(fighter_id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- Insert sample data into Fighters table
INSERT INTO Fighters (name, age, belt_rank, gender) VALUES
('Brian Ortega', 32, 'Black Belt', 'Male'),
('Kron Gracie', 35, 'Brown Belt', 'Male'),
('Mackenzie Dern', 30, 'Black Belt', 'Female'),
('Rickson Gracie', 65, 'Red Belt', 'Male'),
('Helio Gracie', 95, 'Red Belt', 'Male'),
('Gordon Ryan', 28, 'Black Belt', 'Male');

-- Insert sample data into Schools table
INSERT INTO Schools (name, location) VALUES
('Gracie Academy', 'Rio de Janeiro, Brazil'),
('10th Planet Jiu-Jitsu', 'Los Angeles, USA'),
('Alliance Jiu-Jitsu', 'Sao Paulo, Brazil');

-- Insert sample data into fighter_affiliations table
INSERT INTO fighter_affiliations (fighter_id, school_id, join_date) VALUES
(1, 1, '2010-01-01'),
(2, 1, '2005-01-01'),
(3, 2, '2012-06-15'),
(4, 1, '1980-01-01'),
(6, 3, '2018-03-10');

-- Insert sample data into Instructors table
INSERT INTO Instructors (teacher_id, student_id, date) VALUES
(4, 1, '2010-01-01'),
(4, 2, '2005-01-01'),
(5, 4, '1980-01-01');

-- Insert sample data into Tournaments table
INSERT INTO Tournaments (name, location, date) VALUES
('IBJJF World Championship', 'Los Angeles, USA', '2023-06-15'),
('UFC 264', 'Las Vegas, USA', '2021-07-10'),
('ADCC 2022', 'Abu Dhabi, UAE', '2022-09-18');

-- View data in each table in a grid format
SELECT * FROM Users;
SELECT * FROM Fighters;
SELECT * FROM Schools;
SELECT * FROM fighter_affiliations;
SELECT * FROM Tournaments;
SELECT * FROM Instructors;
