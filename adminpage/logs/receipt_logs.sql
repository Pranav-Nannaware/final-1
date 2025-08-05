-- Receipt Logging System Database Schema
-- This table will store all receipt generation activities for audit and tracking

CREATE TABLE IF NOT EXISTS receipt_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    receipt_id VARCHAR(50) NOT NULL UNIQUE,
    student_id INT NOT NULL,
    student_name VARCHAR(255) NOT NULL,
    student_registration_number VARCHAR(50),
    institution_type ENUM('Aided', 'Unaided') NOT NULL,
    class VARCHAR(10) NOT NULL,
    program_interest VARCHAR(100),
    
    -- Fee components and amounts
    fee_components JSON NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    amount_in_words TEXT NOT NULL,
    
    -- Receipt details
    receipt_date DATE NOT NULL,
    academic_year VARCHAR(20) NOT NULL,
    receipt_number VARCHAR(50),
    
    -- Admin information
    admin_id INT,
    admin_username VARCHAR(100),
    admin_name VARCHAR(255),
    
    -- System information
    ip_address VARCHAR(45),
    user_agent TEXT,
    session_id VARCHAR(255),
    
    -- Status and metadata
    status ENUM('generated', 'printed', 'downloaded', 'cancelled', 'modified') DEFAULT 'generated',
    notes TEXT,
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Indexes for better performance
    INDEX idx_student_id (student_id),
    INDEX idx_receipt_date (receipt_date),
    INDEX idx_admin_id (admin_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
);

-- Create a table for receipt file logs (if files are saved)
CREATE TABLE IF NOT EXISTS receipt_file_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    receipt_log_id INT NOT NULL,
    file_type ENUM('pdf', 'html', 'image') NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size INT,
    file_hash VARCHAR(64),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (receipt_log_id) REFERENCES receipt_logs(id) ON DELETE CASCADE,
    INDEX idx_receipt_log_id (receipt_log_id),
    INDEX idx_file_type (file_type)
);

-- Create a table for receipt modifications (audit trail)
CREATE TABLE IF NOT EXISTS receipt_modifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    receipt_log_id INT NOT NULL,
    modification_type ENUM('created', 'modified', 'cancelled', 'printed', 'downloaded') NOT NULL,
    old_values JSON,
    new_values JSON,
    admin_id INT,
    admin_username VARCHAR(100),
    ip_address VARCHAR(45),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (receipt_log_id) REFERENCES receipt_logs(id) ON DELETE CASCADE,
    INDEX idx_receipt_log_id (receipt_log_id),
    INDEX idx_modification_type (modification_type),
    INDEX idx_created_at (created_at)
); 