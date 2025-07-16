<?php
// Admin Setup Script
// This script helps set up the admin system for the first time

require_once 'includes/db_config.php';

$message = '';
$error = '';

// Check if admin_users table exists
$table_exists = false;
$result = $conn->query("SHOW TABLES LIKE 'admin_users'");
if ($result->num_rows > 0) {
    $table_exists = true;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    
    if (empty($username) || empty($password) || empty($full_name)) {
        $error = 'Please fill in all required fields.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } else {
        try {
            // Create table if it doesn't exist
            if (!$table_exists) {
                $create_table_sql = "
                CREATE TABLE `admin_users` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `username` varchar(50) NOT NULL UNIQUE,
                    `password_hash` varchar(255) NOT NULL,
                    `full_name` varchar(100) NOT NULL,
                    `email` varchar(100) DEFAULT NULL,
                    `is_active` tinyint(1) DEFAULT 1,
                    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                ";
                
                if ($conn->query($create_table_sql)) {
                    $table_exists = true;
                } else {
                    throw new Exception("Error creating table: " . $conn->error);
                }
            }
            
            // Hash password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert admin user
            $stmt = $conn->prepare("INSERT INTO admin_users (username, password_hash, full_name, email) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("ssss", $username, $password_hash, $full_name, $email);
            
            if ($stmt->execute()) {
                $message = "Admin user created successfully! You can now login with username: " . htmlspecialchars($username);
            } else {
                throw new Exception("Error creating admin user: " . $stmt->error);
            }
            
            $stmt->close();
            
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Setup - Student Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .setup-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
        }

        .setup-header {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .setup-header h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            font-weight: 300;
        }

        .setup-header p {
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .setup-form {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2d3748;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f7fafc;
        }

        .form-control:focus {
            outline: none;
            border-color: #3498db;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .btn-setup {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-setup:hover {
            background: linear-gradient(135deg, #2980b9 0%, #1f5f8b 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
        }

        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #c6f6d5;
            color: #2f855a;
            border: 1px solid #9ae6b4;
        }

        .alert-error {
            background: #fed7d7;
            color: #c53030;
            border: 1px solid #feb2b2;
        }

        .setup-footer {
            text-align: center;
            padding: 1rem 2rem 2rem;
            color: #718096;
            font-size: 0.85rem;
        }

        .setup-footer a {
            color: #3498db;
            text-decoration: none;
        }

        .setup-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="setup-container">
        <div class="setup-header">
            <h1><i class="fas fa-cog"></i> Admin Setup</h1>
            <p>Create your first admin account</p>
        </div>
        
        <form class="setup-form" method="POST" action="">
            <?php if (!empty($message)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="username">Username *</label>
                <input type="text" id="username" name="username" class="form-control" 
                       placeholder="Enter username" required 
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="full_name">Full Name *</label>
                <input type="text" id="full_name" name="full_name" class="form-control" 
                       placeholder="Enter your full name" required 
                       value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" 
                       placeholder="Enter your email" 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" class="form-control" 
                       placeholder="Enter password (min 6 characters)" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password *</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" 
                       placeholder="Confirm your password" required>
            </div>
            
            <button type="submit" class="btn-setup">
                <i class="fas fa-user-plus"></i> Create Admin Account
            </button>
        </form>
        
        <div class="setup-footer">
            <p>After creating your account, you can <a href="login.php">login here</a></p>
            <p>&copy; 2024 Student Management System. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 