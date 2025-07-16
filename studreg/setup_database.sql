-- Database setup for Student Registration System
-- Run this SQL in your MySQL/phpMyAdmin

-- Create database (if it doesn't exist)
-- CREATE DATABASE IF NOT EXISTS cmrit_db;
USE cmrit_db;

-- Create user and grant privileges
-- (Run these if you need to create the database user)
-- CREATE USER 'cmrit_user'@'localhost' IDENTIFIED BY 'test';
-- GRANT ALL PRIVILEGES ON cmrit_db.* TO 'cmrit_user'@'localhost';
-- FLUSH PRIVILEGES;

-- Create the student_register table
CREATE TABLE IF NOT EXISTS student_register (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    father_name VARCHAR(255) NOT NULL,
    mother_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    mobile_number VARCHAR(15) NOT NULL,
    guardian_mobile_number VARCHAR(15) NOT NULL,
    dob DATE NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    class ENUM('11th', '12th') NOT NULL,
    program_interest VARCHAR(100) NOT NULL,
    institution_type ENUM('Aided', 'Unaided') NOT NULL,
    caste VARCHAR(50) NOT NULL,
    category ENUM('Open', 'Reserved', 'EWS') NOT NULL,
    school_udise_number VARCHAR(20) NOT NULL,
    aadhaar_number VARCHAR(12) NOT NULL,
    tenth_marks INT NOT NULL,
    tenth_percentage DECIMAL(5,2) NOT NULL,
    current_address TEXT NOT NULL,
    permanent_address TEXT NOT NULL,
    
    -- Document storage as BLOB
    tenth_marksheet LONGBLOB,
    school_leaving_certificate LONGBLOB,
    aadhaar_card LONGBLOB,
    passport_photo LONGBLOB,
    caste_certificate LONGBLOB,
    non_creamy_layer_certificate LONGBLOB,
    ews_eligibility_certificate LONGBLOB,
    domicile_certificate LONGBLOB,
    
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create index on email for faster lookups
CREATE INDEX idx_email ON student_register(email);
CREATE INDEX idx_registration_date ON student_register(registration_date); 