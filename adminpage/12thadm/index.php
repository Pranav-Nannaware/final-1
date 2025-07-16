<?php
// 12thadm/index.php - Administrative Management Dashboard
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>12th Admission Management Dashboard - Student Registration System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/admin-theme.css">
    <style>
        .nav-header {
            background: #ffffff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 2rem;
        }
        
        .nav-header h1 {
            color: #2c3e50;
            margin: 0;
            border-bottom: none;
            font-size: 1.8rem;
        }
        
        .nav-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .nav-links a {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .nav-links a:hover {
            background: #f8f9fa;
            color: #2980b9;
        }
        
        .admin-card {
            border-left: 4px solid #3498db;
        }
        
        .admin-card h3 {
            color: #2c3e50;
            margin-bottom: 1rem;
        }
        
        .admin-card p {
            color: #7f8c8d;
            margin-bottom: 1.5rem;
        }
        
        .footer-links {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e0e0e0;
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <div class="nav-header">
        <h1><i class="fas fa-user-shield"></i> 12th Admission Management Dashboard</h1>
        <div class="nav-links">
            <a href="../index.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="../recipt/index.php"><i class="fas fa-receipt"></i> New Payment Receipt Generator</a>
            <a href="../studmanage/index.php"><i class="fas fa-users"></i> Student Management</a>
        </div>
    </div>

    <div class="container">
        <div class="admin-menu">
            <div class="admin-card">
                <h3><i class="fas fa-receipt"></i> Receipt Management</h3>
                <p>View and manage student receipt uploads, approve or reject student submissions for 12th grade admissions.</p>
                <a href="view_receipts.php" class="btn">Access</a>
            </div>
            
            <div class="admin-card">
                <h3><i class="fas fa-check-circle"></i> Approved Students</h3>
                <p>View the complete list of approved and rejected students with their admission details.</p>
                <a href="view_approved_students.php" class="btn">Access</a>
            </div>
            
            <div class="admin-card">
                <h3><i class="fas fa-download"></i> Student Data Export</h3>
                <p>Download comprehensive student data reports in Excel format with advanced filtering options.</p>
                <a href="export_student_data.php" class="btn">Access</a>
            </div>
        </div>
    </div>
</body>
</html> 