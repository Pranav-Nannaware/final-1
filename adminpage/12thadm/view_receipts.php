<?php
// view_receipts.php - Student Receipt Management System

// Start session for CSRF protection
session_start();
    // Database connection
    try {
        $db_host = 'localhost';
        $db_name = 'cmrit_db';
        $db_user = 'cmrit_user';
        $db_pass = 'test';
        $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);
    } catch (PDOException $e) {
        die("Database connection failed: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
    }
    
    // Search variables
    $search_reg_no = isset($_GET['reg_no']) ? trim($_GET['reg_no']) : '';
    $search_type = isset($_GET['type']) ? $_GET['type'] : '';
    $search_division = isset($_GET['division']) ? $_GET['division'] : '';
    
    // Base query
    $query = "SELECT id, registration_number, name_of_student, registration_type, class, division, 
                     CASE WHEN receipt_tuition IS NOT NULL THEN 'Yes' ELSE 'No' END as has_tuition_receipt,
                     CASE WHEN receipt_stationary IS NOT NULL THEN 'Yes' ELSE 'No' END as has_stationary_receipt,
                     CASE WHEN receipt_cs IS NOT NULL THEN 'Yes' ELSE 'No' END as has_cs_receipt,
                     CASE WHEN receipt_it IS NOT NULL THEN 'Yes' ELSE 'No' END as has_it_receipt,
                     CASE WHEN receipt_pta IS NOT NULL THEN 'Yes' ELSE 'No' END as has_pta_receipt
              FROM existstudents 
              WHERE class = '12'";
    
    $params = [];
    
    // Add search filters
    if (!empty($search_reg_no)) {
        $query .= " AND registration_number = :reg_no";
        $params[':reg_no'] = $search_reg_no;
    }
    
    if (!empty($search_type)) {
        $query .= " AND registration_type = :type";
        $params[':type'] = $search_type;
    }
    
    if (!empty($search_division)) {
        $query .= " AND division = :division";
        $params[':division'] = $search_division;
    }
    
    // Order the results
    $query .= " ORDER BY registration_number";
    
    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $students = $stmt->fetchAll();
    
    // Check which students are in the approvedstudents table
    $approved_students = [];
    $stmt = $pdo->prepare("SELECT registration_number FROM approvedstudents");
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach ($result as $row) {
        $approved_students[] = $row['registration_number'];
    }
    
    // For viewing individual receipts
    if (isset($_GET['view_receipt']) && isset($_GET['student_id']) && isset($_GET['receipt_type'])) {
        $student_id = $_GET['student_id'];
        $receipt_type = $_GET['receipt_type'];
        
        // Map receipt types to database columns
        $column_mapping = [
            'tuition' => 'receipt_tuition',
            'stationary' => 'receipt_stationary',
            'cs' => 'receipt_cs',
            'it' => 'receipt_it',
            'pta' => 'receipt_pta'
        ];
        
        if (isset($column_mapping[$receipt_type])) {
            $column = $column_mapping[$receipt_type];
            
            $stmt = $pdo->prepare("SELECT registration_number, {$column} FROM existstudents WHERE id = :id");
            $stmt->bindParam(':id', $student_id, PDO::PARAM_INT);
            $stmt->execute();
            $receipt_data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($receipt_data && $receipt_data[$column] !== null) {
                // Send appropriate headers for image display
                header('Content-Type: image/jpeg');
                echo $receipt_data[$column];
                exit;
            }
        }
        
        // If we get here, there was an error
        header('HTTP/1.1 404 Not Found');
        echo "Receipt not found";
        exit;
    }
    
    // For deleting receipt
    if (isset($_GET['delete_receipt']) && isset($_GET['student_id']) && isset($_GET['receipt_type']) && isset($_GET['csrf_token'])) {
        // Verify CSRF token (simple implementation)
        if (!isset($_SESSION['csrf_token']) || $_GET['csrf_token'] !== $_SESSION['csrf_token']) {
            $delete_error = "Invalid security token. Please try again.";
        } else {
            $student_id = $_GET['student_id'];
            $receipt_type = $_GET['receipt_type'];
            
            // Map receipt types to database columns
            $column_mapping = [
                'tuition' => 'receipt_tuition',
                'stationary' => 'receipt_stationary',
                'cs' => 'receipt_cs',
                'it' => 'receipt_it',
                'pta' => 'receipt_pta'
            ];
            
            if (isset($column_mapping[$receipt_type])) {
                $column = $column_mapping[$receipt_type];
                
                try {
                    // Get student info before deletion for confirmation message
                    $stmt = $pdo->prepare("SELECT registration_number, name_of_student FROM existstudents WHERE id = :id");
                    $stmt->bindParam(':id', $student_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $student_info = $stmt->fetch();
                    
                    // Set the receipt column to NULL
                    $stmt = $pdo->prepare("UPDATE existstudents SET {$column} = NULL WHERE id = :id");
                    $stmt->bindParam(':id', $student_id, PDO::PARAM_INT);
                    $stmt->execute();
                    
                    if ($stmt->rowCount() > 0) {
                        $delete_success = "Receipt for " . ucfirst($receipt_type) . " fees has been deleted for student " . 
                                          htmlspecialchars($student_info['name_of_student']) . " (Reg #: " . 
                                          htmlspecialchars($student_info['registration_number']) . ").";
                    } else {
                        $delete_error = "No changes made. Receipt may have already been deleted.";
                    }
                } catch (PDOException $e) {
                    $delete_error = "Database error: " . $e->getMessage();
                }
            } else {
                $delete_error = "Invalid receipt type specified.";
            }
        }
        
        // Regenerate CSRF token after processing
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    // For approving a student
    if (isset($_GET['approve_student']) && isset($_GET['student_id']) && isset($_GET['csrf_token'])) {
        // Verify CSRF token
        if (!isset($_SESSION['csrf_token']) || $_GET['csrf_token'] !== $_SESSION['csrf_token']) {
            $approve_error = "Invalid security token. Please try again.";
        } else {
            $student_id = $_GET['student_id'];
            $receipt_types = isset($_GET['receipt_types']) ? json_decode($_GET['receipt_types'], true) : [];
            
            if (empty($receipt_types)) {
                $approve_error = "No receipts were selected for approval.";
            } else {
                try {
                    // First check if the student exists in existstudents
                    $stmt = $pdo->prepare("SELECT * FROM existstudents WHERE id = :id");
                    $stmt->bindParam(':id', $student_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $student = $stmt->fetch();
                    
                    if ($student) {
                        // Check if the approvedstudents table exists, if not create it
                        $stmt = $pdo->prepare("SHOW TABLES LIKE 'approvedstudents'");
                        $stmt->execute();
                        if ($stmt->rowCount() == 0) {
                            // Create the approvedstudents table with the same structure as existstudents
                            $pdo->exec("CREATE TABLE approvedstudents LIKE existstudents");
                            // Add approval_date column
                            $pdo->exec("ALTER TABLE approvedstudents ADD COLUMN approval_date DATETIME DEFAULT NULL");
                            $pdo->exec("ALTER TABLE approvedstudents ADD COLUMN status ENUM('approved', 'rejected') DEFAULT 'approved'");
                        } else {
                            // Check if approval_date column exists, if not add it
                            $stmt = $pdo->prepare("SHOW COLUMNS FROM approvedstudents LIKE 'approval_date'");
                            $stmt->execute();
                            if ($stmt->rowCount() == 0) {
                                $pdo->exec("ALTER TABLE approvedstudents ADD COLUMN approval_date DATETIME DEFAULT NULL");
                            }
                            
                            // Check if status column exists, if not add it
                            $stmt = $pdo->prepare("SHOW COLUMNS FROM approvedstudents LIKE 'status'");
                            $stmt->execute();
                            if ($stmt->rowCount() == 0) {
                                $pdo->exec("ALTER TABLE approvedstudents ADD COLUMN status ENUM('approved', 'rejected') DEFAULT 'approved'");
                            }
                        }
                        
                        // Create a copy of the student data with only the selected receipts
                        $approved_student = $student;
                        
                        // Map receipt types to database columns
                        $column_mapping = [
                            'tuition' => 'receipt_tuition',
                            'stationary' => 'receipt_stationary',
                            'cs' => 'receipt_cs',
                            'it' => 'receipt_it',
                            'pta' => 'receipt_pta'
                        ];
                        
                        // Clear all receipts that are not selected
                        foreach ($column_mapping as $type => $column) {
                            if (!in_array($type, $receipt_types)) {
                                $approved_student[$column] = null;
                            }
                        }
                        
                        // Check if student is already in approvedstudents table
                        $stmt = $pdo->prepare("SELECT * FROM approvedstudents WHERE registration_number = :reg_no");
                        $stmt->bindParam(':reg_no', $student['registration_number'], PDO::PARAM_STR);
                        $stmt->execute();
                        
                        if ($stmt->rowCount() > 0) {
                            // Update existing record with only selected receipts
                            $sql = "UPDATE approvedstudents SET 
                                    name_of_student = :name, 
                                    registration_type = :type, 
                                    class = :class, 
                                    division = :division, 
                                    receipt_tuition = :tuition, 
                                    receipt_stationary = :stationary, 
                                    receipt_cs = :cs, 
                                    receipt_it = :it, 
                                    receipt_pta = :pta,
                                    approval_date = NOW(),
                                    status = 'approved'
                                    WHERE registration_number = :reg_no";
                                    
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':name', $approved_student['name_of_student'], PDO::PARAM_STR);
                            $stmt->bindParam(':type', $approved_student['registration_type'], PDO::PARAM_STR);
                            $stmt->bindParam(':class', $approved_student['class'], PDO::PARAM_STR);
                            $stmt->bindParam(':division', $approved_student['division'], PDO::PARAM_STR);
                            $stmt->bindParam(':tuition', $approved_student['receipt_tuition'], PDO::PARAM_LOB);
                            $stmt->bindParam(':stationary', $approved_student['receipt_stationary'], PDO::PARAM_LOB);
                            $stmt->bindParam(':cs', $approved_student['receipt_cs'], PDO::PARAM_LOB);
                            $stmt->bindParam(':it', $approved_student['receipt_it'], PDO::PARAM_LOB);
                            $stmt->bindParam(':pta', $approved_student['receipt_pta'], PDO::PARAM_LOB);
                            $stmt->bindParam(':reg_no', $approved_student['registration_number'], PDO::PARAM_STR);
                            $stmt->execute();
                            
                            $approve_success = "Student " . htmlspecialchars($student['name_of_student']) . 
                                               " (Reg #: " . htmlspecialchars($student['registration_number']) . 
                                               ") has been updated in the approved students list with " . count($receipt_types) . " selected receipts.";
                        } else {
                            // Insert new record with only selected receipts
                            $sql = "INSERT INTO approvedstudents 
                                    (registration_number, name_of_student, registration_type, class, division, 
                                    receipt_tuition, receipt_stationary, receipt_cs, receipt_it, receipt_pta, approval_date, status) 
                                    VALUES 
                                    (:reg_no, :name, :type, :class, :division, 
                                    :tuition, :stationary, :cs, :it, :pta, NOW(), 'approved')";
                                    
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':reg_no', $approved_student['registration_number'], PDO::PARAM_STR);
                            $stmt->bindParam(':name', $approved_student['name_of_student'], PDO::PARAM_STR);
                            $stmt->bindParam(':type', $approved_student['registration_type'], PDO::PARAM_STR);
                            $stmt->bindParam(':class', $approved_student['class'], PDO::PARAM_STR);
                            $stmt->bindParam(':division', $approved_student['division'], PDO::PARAM_STR);
                            $stmt->bindParam(':tuition', $approved_student['receipt_tuition'], PDO::PARAM_LOB);
                            $stmt->bindParam(':stationary', $approved_student['receipt_stationary'], PDO::PARAM_LOB);
                            $stmt->bindParam(':cs', $approved_student['receipt_cs'], PDO::PARAM_LOB);
                            $stmt->bindParam(':it', $approved_student['receipt_it'], PDO::PARAM_LOB);
                            $stmt->bindParam(':pta', $approved_student['receipt_pta'], PDO::PARAM_LOB);
                            $stmt->execute();
                            
                            $approve_success = "Student " . htmlspecialchars($student['name_of_student']) . 
                                               " (Reg #: " . htmlspecialchars($student['registration_number']) . 
                                               ") has been approved with " . count($receipt_types) . " selected receipts.";
                        }
                    } else {
                        $approve_error = "Student not found.";
                    }
                } catch (PDOException $e) {
                    $approve_error = "Database error: " . $e->getMessage();
                }
            }
        }
        
        // Regenerate CSRF token after processing
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    // For rejecting a student
    if (isset($_GET['reject_student']) && isset($_GET['student_id']) && isset($_GET['csrf_token'])) {
        // Verify CSRF token
        if (!isset($_SESSION['csrf_token']) || $_GET['csrf_token'] !== $_SESSION['csrf_token']) {
            $reject_error = "Invalid security token. Please try again.";
        } else {
            $student_id = $_GET['student_id'];
            
            try {
                // First check if the student exists in existstudents
                $stmt = $pdo->prepare("SELECT * FROM existstudents WHERE id = :id");
                $stmt->bindParam(':id', $student_id, PDO::PARAM_INT);
                $stmt->execute();
                $student = $stmt->fetch();
                
                if ($student) {
                    // Check if the approvedstudents table exists, if not create it
                    $stmt = $pdo->prepare("SHOW TABLES LIKE 'approvedstudents'");
                    $stmt->execute();
                    if ($stmt->rowCount() == 0) {
                        // Create the approvedstudents table with the same structure as existstudents
                        $pdo->exec("CREATE TABLE approvedstudents LIKE existstudents");
                        // Add approval_date column and status column
                        $pdo->exec("ALTER TABLE approvedstudents ADD COLUMN approval_date DATETIME DEFAULT NULL");
                        $pdo->exec("ALTER TABLE approvedstudents ADD COLUMN status ENUM('approved', 'rejected') DEFAULT 'approved'");
                    } else {
                        // Check if approval_date column exists, if not add it
                        $stmt = $pdo->prepare("SHOW COLUMNS FROM approvedstudents LIKE 'approval_date'");
                        $stmt->execute();
                        if ($stmt->rowCount() == 0) {
                            $pdo->exec("ALTER TABLE approvedstudents ADD COLUMN approval_date DATETIME DEFAULT NULL");
                        }
                        
                        // Check if status column exists, if not add it
                        $stmt = $pdo->prepare("SHOW COLUMNS FROM approvedstudents LIKE 'status'");
                        $stmt->execute();
                        if ($stmt->rowCount() == 0) {
                            $pdo->exec("ALTER TABLE approvedstudents ADD COLUMN status ENUM('approved', 'rejected') DEFAULT 'approved'");
                        }
                    }
                    
                    // Check if student is already in approvedstudents table
                    $stmt = $pdo->prepare("SELECT * FROM approvedstudents WHERE registration_number = :reg_no");
                    $stmt->bindParam(':reg_no', $student['registration_number'], PDO::PARAM_STR);
                    $stmt->execute();
                    
                    if ($stmt->rowCount() > 0) {
                        // Update existing record
                        $sql = "UPDATE approvedstudents SET 
                                name_of_student = :name, 
                                registration_type = :type, 
                                class = :class, 
                                division = :division, 
                                receipt_tuition = :tuition, 
                                receipt_stationary = :stationary, 
                                receipt_cs = :cs, 
                                receipt_it = :it, 
                                receipt_pta = :pta,
                                approval_date = NOW(),
                                status = 'rejected'
                                WHERE registration_number = :reg_no";
                                
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':name', $student['name_of_student'], PDO::PARAM_STR);
                        $stmt->bindParam(':type', $student['registration_type'], PDO::PARAM_STR);
                        $stmt->bindParam(':class', $student['class'], PDO::PARAM_STR);
                        $stmt->bindParam(':division', $student['division'], PDO::PARAM_STR);
                        $stmt->bindParam(':tuition', $student['receipt_tuition'], PDO::PARAM_LOB);
                        $stmt->bindParam(':stationary', $student['receipt_stationary'], PDO::PARAM_LOB);
                        $stmt->bindParam(':cs', $student['receipt_cs'], PDO::PARAM_LOB);
                        $stmt->bindParam(':it', $student['receipt_it'], PDO::PARAM_LOB);
                        $stmt->bindParam(':pta', $student['receipt_pta'], PDO::PARAM_LOB);
                        $stmt->bindParam(':reg_no', $student['registration_number'], PDO::PARAM_STR);
                        $stmt->execute();
                        
                        $reject_success = "Student " . htmlspecialchars($student['name_of_student']) . 
                                          " (Reg #: " . htmlspecialchars($student['registration_number']) . 
                                          ") has been updated with rejected status.";
                    } else {
                        // Insert new record
                        $sql = "INSERT INTO approvedstudents 
                                (registration_number, name_of_student, registration_type, class, division, 
                                receipt_tuition, receipt_stationary, receipt_cs, receipt_it, receipt_pta, approval_date, status) 
                                VALUES 
                                (:reg_no, :name, :type, :class, :division, 
                                :tuition, :stationary, :cs, :it, :pta, NOW(), 'rejected')";
                                
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':reg_no', $student['registration_number'], PDO::PARAM_STR);
                        $stmt->bindParam(':name', $student['name_of_student'], PDO::PARAM_STR);
                        $stmt->bindParam(':type', $student['registration_type'], PDO::PARAM_STR);
                        $stmt->bindParam(':class', $student['class'], PDO::PARAM_STR);
                        $stmt->bindParam(':division', $student['division'], PDO::PARAM_STR);
                        $stmt->bindParam(':tuition', $student['receipt_tuition'], PDO::PARAM_LOB);
                        $stmt->bindParam(':stationary', $student['receipt_stationary'], PDO::PARAM_LOB);
                        $stmt->bindParam(':cs', $student['receipt_cs'], PDO::PARAM_LOB);
                        $stmt->bindParam(':it', $student['receipt_it'], PDO::PARAM_LOB);
                        $stmt->bindParam(':pta', $student['receipt_pta'], PDO::PARAM_LOB);
                        $stmt->execute();
                        
                        $reject_success = "Student " . htmlspecialchars($student['name_of_student']) . 
                                          " (Reg #: " . htmlspecialchars($student['registration_number']) . 
                                          ") has been rejected and added to the records.";
                    }
                } else {
                    $reject_error = "Student not found.";
                }
            } catch (PDOException $e) {
                $reject_error = "Database error: " . $e->getMessage();
            }
        }
        
        // Regenerate CSRF token after processing
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
            // Generate CSRF token if it doesn't exist
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> 12th Admission Payment Management - Administrative Panel</title>
    <link rel="stylesheet" href="../assets/admin-theme.css">
    <style>
        /* Additional custom styles for this page */
        .search-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .search-group {
            flex: 1;
            min-width: 200px;
        }
        .receipt-status {
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            display: block;
            margin-bottom: 8px;
        }
        .status-yes {
            background-color: #e1f5e1;
            color: #2ecc71;
        }
        .status-no {
            background-color: #f9e7e7;
            color: #e74c3c;
        }
        .view-link, .delete-link {
            display: inline-block;
            padding: 4px 6px;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            font-size: 11px;
            margin: 1px;
            min-width: 40px;
            text-align: center;
        }
        .receipt-actions {
            display: flex;
            justify-content: center;
            gap: 3px;
            flex-wrap: wrap; /* Allow buttons to wrap on very small screens */
            align-items: center;
        }
        .receipt-checkbox {
            margin: 0 2px;
            cursor: pointer;
            width: 16px;
            height: 16px;
        }
        .view-link {
            background-color: #3498db;
        }
        .delete-link {
            background-color: #e74c3c;
        }
        .view-link:hover {
            background-color: #2980b9;
        }
        .delete-link:hover {
            background-color: #c0392b;
        }
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: center;
        }
        .approve-btn, .reject-btn {
            display: inline-block;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
            text-align: center;
            text-decoration: none;
            width: 85%;
        }
        .approve-btn {
            background-color: #27ae60;
        }
        .reject-btn {
            background-color: #e74c3c;
        }
        .approve-btn:hover {
            background-color: #219651;
        }
        .reject-btn:hover {
            background-color: #c0392b;
        }
        .logout-link {
            display: block;
            text-align: right;
            margin-bottom: 20px;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            backdrop-filter: blur(10px);
        }
        
        /* Add bottom padding to container to prevent content from being hidden behind fixed buttons */
        .container {
            padding-bottom: 150px;
        }
        
        /* Ensure table content doesn't get cut off */
        .results {
            margin-bottom: 120px;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.7);
        }
        .modal-content {
            margin: auto;
            display: block;
            max-width: 80%;
            max-height: 80%;
        }
        .modal-caption {
            margin: auto;
            display: block;
            width: 80%;
            text-align: center;
            color: white;
            padding: 10px 0;
        }
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }
        .close:hover, .close:focus {
            color: #bbb;
            text-decoration: none;
        }
        
        /* Confirm delete dialog */
        .confirm-dialog {
            display: none;
            position: fixed;
            z-index: 1000;
            padding: 20px;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .confirm-dialog p {
            margin-bottom: 20px;
        }
        .dialog-buttons {
            display: flex;
            justify-content: space-between;
        }
        .confirm-yes {
            background-color: #e74c3c;
        }
        .confirm-no {
            background-color: #7f8c8d;
        }
        .overlay {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>12th Admission Payment Management</h1>
            
            <!-- Success/Error Messages -->
            <?php if (isset($delete_success)): ?>
                <div class="success"><?php echo htmlspecialchars($delete_success); ?></div>
            <?php endif; ?>
            
            <?php if (isset($delete_error)): ?>
                <div class="error"><?php echo htmlspecialchars($delete_error); ?></div>
            <?php endif; ?>
            
            <?php if (isset($approve_success)): ?>
                <div class="success"><?php echo htmlspecialchars($approve_success); ?></div>
            <?php endif; ?>
            
            <?php if (isset($approve_error)): ?>
                <div class="error"><?php echo htmlspecialchars($approve_error); ?></div>
            <?php endif; ?>
            
            <?php if (isset($reject_success)): ?>
                <div class="success"><?php echo htmlspecialchars($reject_success); ?></div>
            <?php endif; ?>
            
            <?php if (isset($reject_error)): ?>
                <div class="error"><?php echo htmlspecialchars($reject_error); ?></div>
            <?php endif; ?>
            
            <!-- Search Form -->
            <form class="search-form" method="GET" action="">
                <div class="search-group">
                    <label for="reg_no">Registration Number:</label>
                    <input type="text" id="reg_no" name="reg_no" value="<?php echo htmlspecialchars($search_reg_no); ?>">
                </div>
                <div class="search-group">
                    <label for="type">Registration Type:</label>
                    <select id="type" name="type">
                        <option value="">All</option>
                        <option value="Aided" <?php echo $search_type === 'Aided' ? 'selected' : ''; ?>>Aided</option>
                        <option value="Unaided" <?php echo $search_type === 'Unaided' ? 'selected' : ''; ?>>Unaided</option>
                    </select>
                </div>
                <div class="search-group">
                    <label for="division">Division:</label>
                    <select id="division" name="division">
                        <option value="">All</option>
                        <option value="A" <?php echo $search_division === 'A' ? 'selected' : ''; ?>>A</option>
                        <option value="B" <?php echo $search_division === 'B' ? 'selected' : ''; ?>>B</option>
                        <option value="C" <?php echo $search_division === 'C' ? 'selected' : ''; ?>>C</option>
                        <option value="D" <?php echo $search_division === 'D' ? 'selected' : ''; ?>>D</option>
                    </select>
                </div>
                <div class="search-group" style="align-self: flex-end;">
                    <button type="submit">Search</button>
                    <a href="view_receipts.php" class="btn">Clear</a>
                </div>
            </form>
            
            <!-- Results Table -->
            <div class="results">
                <h2>Student Payment Receipts</h2>
                <?php if (empty($students)): ?>
                    <p>No records found. Please try different search criteria.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 8%;">Reg #</th>
                                <th style="width: 15%;">Name</th>
                                <th style="width: 7%;">Type</th>
                                <th style="width: 5%;">Division</th>
                                <th style="width: 11%;">Tuition Receipt</th>
                                <th style="width: 11%;">Stationary Receipt</th>
                                <th style="width: 11%;">CS Receipt</th>
                                <th style="width: 11%;">IT Receipt</th>
                                <th style="width: 11%;">PTA Receipt</th>
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td <?php if (in_array($student['registration_number'], $approved_students)): ?>style="border: 2px solid green; background-color: rgba(0, 128, 0, 0.1); font-weight: bold;"<?php endif; ?>>
                                        <?php echo htmlspecialchars($student['registration_number']); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($student['name_of_student']); ?></td>
                                    <td><?php echo htmlspecialchars($student['registration_type']); ?></td>
                                    <td><?php echo htmlspecialchars($student['division']); ?></td>
                                    
                                    <!-- Tuition Receipt -->
                                    <td>
                                        <span class="receipt-status status-<?php echo strtolower($student['has_tuition_receipt']); ?>">
                                            <?php echo $student['has_tuition_receipt']; ?>
                                        </span>
                                        <?php if ($student['has_tuition_receipt'] === 'Yes'): ?>
                                            <div class="receipt-actions">
                                                <input type="checkbox" class="receipt-checkbox" data-student-id="<?php echo $student['id']; ?>" data-receipt-type="tuition">
                                                <a href="javascript:void(0);" onclick="showReceipt(<?php echo $student['id']; ?>, 'tuition')" 
                                                   class="view-link">View</a>
                                                <a href="javascript:void(0);" onclick="confirmDeleteReceipt(<?php echo $student['id']; ?>, 'tuition')" 
                                                   class="delete-link">Delete</a>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Stationary Receipt -->
                                    <td>
                                        <span class="receipt-status status-<?php echo strtolower($student['has_stationary_receipt']); ?>">
                                            <?php echo $student['has_stationary_receipt']; ?>
                                        </span>
                                        <?php if ($student['has_stationary_receipt'] === 'Yes'): ?>
                                            <div class="receipt-actions">
                                                <input type="checkbox" class="receipt-checkbox" data-student-id="<?php echo $student['id']; ?>" data-receipt-type="stationary">
                                                <a href="javascript:void(0);" onclick="showReceipt(<?php echo $student['id']; ?>, 'stationary')" 
                                                   class="view-link">View</a>
                                                <a href="javascript:void(0);" onclick="confirmDeleteReceipt(<?php echo $student['id']; ?>, 'stationary')" 
                                                   class="delete-link">Delete</a>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- CS Receipt -->
                                    <td>
                                        <span class="receipt-status status-<?php echo strtolower($student['has_cs_receipt']); ?>">
                                            <?php echo $student['has_cs_receipt']; ?>
                                        </span>
                                        <?php if ($student['has_cs_receipt'] === 'Yes'): ?>
                                            <div class="receipt-actions">
                                                <input type="checkbox" class="receipt-checkbox" data-student-id="<?php echo $student['id']; ?>" data-receipt-type="cs">
                                                <a href="javascript:void(0);" onclick="showReceipt(<?php echo $student['id']; ?>, 'cs')" 
                                                   class="view-link">View</a>
                                                <a href="javascript:void(0);" onclick="confirmDeleteReceipt(<?php echo $student['id']; ?>, 'cs')" 
                                                   class="delete-link">Delete</a>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- IT Receipt -->
                                    <td>
                                        <span class="receipt-status status-<?php echo strtolower($student['has_it_receipt']); ?>">
                                            <?php echo $student['has_it_receipt']; ?>
                                        </span>
                                        <?php if ($student['has_it_receipt'] === 'Yes'): ?>
                                            <div class="receipt-actions">
                                                <input type="checkbox" class="receipt-checkbox" data-student-id="<?php echo $student['id']; ?>" data-receipt-type="it">
                                                <a href="javascript:void(0);" onclick="showReceipt(<?php echo $student['id']; ?>, 'it')" 
                                                   class="view-link">View</a>
                                                <a href="javascript:void(0);" onclick="confirmDeleteReceipt(<?php echo $student['id']; ?>, 'it')" 
                                                   class="delete-link">Delete</a>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- PTA Receipt -->
                                    <td>
                                        <span class="receipt-status status-<?php echo strtolower($student['has_pta_receipt']); ?>">
                                            <?php echo $student['has_pta_receipt']; ?>
                                        </span>
                                        <?php if ($student['has_pta_receipt'] === 'Yes'): ?>
                                            <div class="receipt-actions">
                                                <input type="checkbox" class="receipt-checkbox" data-student-id="<?php echo $student['id']; ?>" data-receipt-type="pta">
                                                <a href="javascript:void(0);" onclick="showReceipt(<?php echo $student['id']; ?>, 'pta')" 
                                                   class="view-link">View</a>
                                                <a href="javascript:void(0);" onclick="confirmDeleteReceipt(<?php echo $student['id']; ?>, 'pta')" 
                                                   class="delete-link">Delete</a>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Action -->
                                    <td>
                                        <div class="action-buttons">
                                            <a href="javascript:void(0);" onclick="approveStudent(<?php echo $student['id']; ?>)" class="approve-btn">Approve</a>
                                            <a href="javascript:void(0);" onclick="rejectStudent(<?php echo $student['id']; ?>)" class="reject-btn">Reject</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
            
            <div class="actions">
                <a href="index.php" class="btn">Return to Dashboard</a>
                <a href="view_approved_students.php" class="btn">View Approved Students</a>
            </div>
    </div>
    
    <!-- Image Viewing Modal -->
    <div id="receiptModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="receiptImage">
        <div id="modalCaption" class="modal-caption"></div>
    </div>
    
    <script>
        // Variables for receipt viewing
        var modal = document.getElementById('receiptModal');
        var modalImg = document.getElementById('receiptImage');
        var modalCaption = document.getElementById('modalCaption');
        var closeBtn = document.getElementsByClassName('close')[0];
        
        // Function to show receipt in modal
        function showReceipt(studentId, receiptType) {
            // Set the image source to the view_receipt endpoint
            modalImg.src = "?view_receipt=1&student_id=" + studentId + "&receipt_type=" + receiptType;
            
            // Set caption based on receipt type
            var receiptNames = {
                'tuition': 'Tuition Fee',
                'stationary': 'Stationary Fee',
                'cs': 'CS Fee',
                'it': 'IT Fee',
                'pta': 'PTA Fee'
            };
            
            modalCaption.innerHTML = receiptNames[receiptType] + " Receipt";
            
            // Show the modal
            modal.style.display = "block";
        }
        
        // Close modal when clicking the × button
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }
        
        // Close modal when clicking outside the image
        modal.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
        
        // Student approval function
        function approveStudent(studentId) {
            // Get all checked receipt checkboxes for this student
            const checkedReceipts = document.querySelectorAll(`.receipt-checkbox[data-student-id="${studentId}"]:checked`);
            const receiptTypes = Array.from(checkedReceipts).map(checkbox => checkbox.getAttribute('data-receipt-type'));
            
            if (receiptTypes.length === 0) {
                alert("Please select at least one receipt to approve.");
                return;
            }
            
            if (confirm("Are you sure you want to APPROVE this student with the selected receipts?")) {
                window.location.href = "?approve_student=1&student_id=" + studentId + 
                    "&receipt_types=" + JSON.stringify(receiptTypes) +
                    "&csrf_token=<?php echo $_SESSION['csrf_token']; ?>";
            }
        }
        
        // Student rejection function
        function rejectStudent(studentId) {
            if (confirm("Are you sure you want to REJECT this student? This will mark them as rejected in the records.")) {
                window.location.href = "?reject_student=1&student_id=" + studentId + 
                    "&csrf_token=<?php echo $_SESSION['csrf_token']; ?>";
            }
        }
        
        // Receipt deletion confirmation function
        function confirmDeleteReceipt(studentId, receiptType) {
            if (confirm("Are you sure you want to DELETE this " + receiptType + " receipt? This action cannot be undone.")) {
                window.location.href = "?delete_receipt=1&student_id=" + studentId + 
                    "&receipt_type=" + receiptType + 
                    "&csrf_token=<?php echo $_SESSION['csrf_token']; ?>";
            }
        }
        
        // Basic checkbox functionality
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.receipt-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // You can add custom code here to handle checkbox changes
                    // This will be expanded in future functionality
                    console.log('Receipt selected:', {
                        studentId: this.getAttribute('data-student-id'),
                        receiptType: this.getAttribute('data-receipt-type'),
                        checked: this.checked
                    });
                });
            });
        });
    </script>
</body>
</html> 