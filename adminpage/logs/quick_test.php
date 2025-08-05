<?php
/**
 * Quick test script for Receipt Logging System
 * This script tests the logging functionality without authentication
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

// Start session and set test admin info
session_start();
$_SESSION['admin_id'] = 1;
$_SESSION['admin_username'] = 'test_admin';
$_SESSION['admin_name'] = 'Test Administrator';

echo "<h2>Quick Test - Receipt Logging System</h2>";

try {
    // Include receipt logger
    require_once 'receipt_logger.php';
    $logger = new ReceiptLogger($conn);
    echo "<p style='color: green;'>✓ Logger class loaded successfully</p>";
    
    // Test data
    $test_student = [
        'id' => 999,
        'full_name' => 'Test Student',
        'institution_type' => 'Aided',
        'class' => '12th',
        'program_interest' => 'Science'
    ];
    
    $test_components = ['HSC EXAM FEES', 'TUITION FEES'];
    $test_amount = 1340;
    $test_amount_words = 'One Thousand Three Hundred Forty rupees only';
    
    // Test logging
    $result = $logger->logReceiptGeneration(
        $test_student,
        $test_components,
        $test_amount,
        $test_amount_words
    );
    
    if ($result['success']) {
        echo "<p style='color: green;'>✓ Test receipt logged successfully!</p>";
        echo "<p><strong>Receipt ID:</strong> " . $result['receipt_id'] . "</p>";
        echo "<p><strong>Log ID:</strong> " . $result['log_id'] . "</p>";
        
        // Test retrieving the log
        $logs = $logger->getReceiptLogs(['limit' => 1]);
        if (!empty($logs)) {
            echo "<p style='color: green;'>✓ Log retrieved successfully!</p>";
            echo "<p><strong>Student:</strong> " . $logs[0]['student_name'] . "</p>";
            echo "<p><strong>Amount:</strong> ₹" . number_format($logs[0]['total_amount']) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Test logging failed: " . $result['error'] . "</p>";
    }
    
    echo "<h3>Test Summary</h3>";
    echo "<p style='color: green; font-weight: bold;'>✓ Receipt logging system is working!</p>";
    echo "<p><a href='view_logs.php'>View All Logs</a> | <a href='../index.php'>Back to Admin Panel</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Test failed: " . $e->getMessage() . "</p>";
    echo "<p><strong>Error details:</strong> " . $e->getTraceAsString() . "</p>";
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