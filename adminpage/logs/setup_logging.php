<?php
/**
 * Setup script for Receipt Logging System
 * This script creates the necessary database tables for the logging system
 */

// Database connection
$servername = "localhost";
$username = "cmrit_user";
$password = "test";
$dbname = "cmrit_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Setting up Receipt Logging System</h2>";

// SQL statements to create tables
$tables = [
    'receipt_logs' => "
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
        )
    ",
    
    'receipt_file_logs' => "
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
        )
    ",
    
    'receipt_modifications' => "
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
        )
    "
];

// Create tables
$success_count = 0;
$error_count = 0;

foreach ($tables as $table_name => $sql) {
    echo "<p>Creating table: <strong>$table_name</strong>...</p>";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>✓ Table '$table_name' created successfully</p>";
        $success_count++;
    } else {
        echo "<p style='color: red;'>✗ Error creating table '$table_name': " . $conn->error . "</p>";
        $error_count++;
    }
}

// Create logs directory if it doesn't exist
$logs_dir = __DIR__;
if (!is_dir($logs_dir)) {
    if (mkdir($logs_dir, 0755, true)) {
        echo "<p style='color: green;'>✓ Logs directory created successfully</p>";
    } else {
        echo "<p style='color: red;'>✗ Error creating logs directory</p>";
    }
} else {
    echo "<p style='color: green;'>✓ Logs directory already exists</p>";
}

// Test the logger
echo "<h3>Testing Logger...</h3>";
require_once 'receipt_logger.php';

try {
    $logger = new ReceiptLogger($conn);
    echo "<p style='color: green;'>✓ Logger class loaded successfully</p>";
    
    // Test database connection
    $test_result = $logger->getReceiptLogs(['limit' => 1]);
    echo "<p style='color: green;'>✓ Database connection test successful</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Logger test failed: " . $e->getMessage() . "</p>";
    $error_count++;
}

echo "<h3>Setup Summary</h3>";
echo "<p>Tables created successfully: <strong>$success_count</strong></p>";
echo "<p>Errors encountered: <strong>$error_count</strong></p>";

if ($error_count == 0) {
    echo "<p style='color: green; font-weight: bold;'>✓ Receipt Logging System setup completed successfully!</p>";
    echo "<p><a href='view_logs.php'>View Logs</a> | <a href='../index.php'>Back to Admin Panel</a></p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>✗ Setup completed with errors. Please check the error messages above.</p>";
}

$conn->close();
?>

<style>
    body {
        font-family: Arial, sans-serif;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background: #f5f5f5;
    }
    
    h2, h3 {
        color: #333;
        border-bottom: 2px solid #3498db;
        padding-bottom: 10px;
    }
    
    p {
        margin: 10px 0;
        padding: 5px 0;
    }
    
    a {
        color: #3498db;
        text-decoration: none;
        padding: 10px 20px;
        background: #3498db;
        color: white;
        border-radius: 5px;
        margin: 5px;
        display: inline-block;
    }
    
    a:hover {
        background: #2980b9;
    }
</style> 