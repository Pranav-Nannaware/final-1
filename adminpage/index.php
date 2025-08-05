<?php
// Include authentication check
require_once 'includes/auth.php';
check_admin_login();

// Get admin information
$admin_info = get_admin_info();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Student Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('image.png') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            color: #333;
            position: relative;
        }

        /* Add overlay for readability */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(245, 245, 245, 0.85);
            z-index: 0;
        }
        .header, .container, .modules-grid, .dashboard-title, .module-card, .stats-overview {
            position: relative;
            z-index: 1;
        }

        .header {
            background: #ffffff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid #e0e0e0;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .logo i {
            margin-right: 0.5rem;
            color: #3498db;
        }

        .user-info {
            display: flex;
            align-items: center;
            color: #718096;
            gap: 1rem;
        }

        .user-info .admin-name {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logout-btn {
            background: #e74c3c;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #c0392b;
            transform: translateY(-1px);
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .dashboard-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .dashboard-title h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 0.5rem;
        }

        .dashboard-title p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }

        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .module-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }

        .module-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: #3498db;
        }

        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .module-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1.5rem;
        }

        .admin-icon { background: #3498db; }
        .receipt-icon { background: #e74c3c; }
        .student-icon { background: #2ecc71; }
        .logs-icon { background: #9b59b6; }

        .module-card h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: #2d3748;
        }

        .module-card p {
            color: #718096;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .features-list {
            list-style: none;
            margin-bottom: 1.5rem;
        }

        .features-list li {
            padding: 0.3rem 0;
            color: #4a5568;
            font-size: 0.9rem;
        }

        .features-list li::before {
            content: '✓';
            color: #48bb78;
            font-weight: bold;
            margin-right: 0.5rem;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #2980b9;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(52, 152, 219, 0.3);
        }

        .btn-secondary {
            background: #95a5a6;
            margin-left: 0.5rem;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
            box-shadow: 0 2px 8px rgba(149, 165, 166, 0.3);
        }

        .stats-overview {
            background: #ffffff;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border: 1px solid #e0e0e0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            border-radius: 4px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #3498db;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #718096;
            font-size: 0.9rem;
        }

        .footer {
            text-align: center;
            padding: 2rem;
            color: #7f8c8d;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }
            
            .modules-grid {
                grid-template-columns: 1fr;
            }
            
            .dashboard-title h1 {
                font-size: 2rem;
            }
            
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div class="logo">
                <i class="fas fa-graduation-cap"></i>
                Bharat English School & Jr. College
            </div>
            <div class="user-info">
                <div class="admin-name">
                    <i class="fas fa-user-circle"></i>
                    <span><?php echo htmlspecialchars($admin_info['full_name']); ?></span>
                </div>
                <a href="logout.php" class="logout-btn" onclick="return confirm('Are you sure you want to logout?')">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="dashboard-title">
            <h1>Admin Dashboard</h1>
            <p>Comprehensive management system for student registration, receipts, and administration</p>
        </div>

        <div class="modules-grid">
            <!-- Admin Management Module -->
            <div class="module-card">
                <div class="module-icon admin-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h3>12th Admission Management</h3>
                <p>Complete administrative control panel for managing student approvals, viewing receipts, and generating reports.</p>
                <ul class="features-list">
                    <li>Student Receipt Management</li>
                    <li>Approval/Rejection System</li>
                    <li>Data Export & Reports</li>
                    <li>Secure Authentication</li>
                </ul>
                <a href="12thadm/index.php" class="btn">
                    <i class="fas fa-arrow-right"></i> Manage
                </a>
            </div>

            <!-- Receipt Generation Module -->
            <div class="module-card">
                <div class="module-icon receipt-icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <h3>New Payment Receipt Generator</h3>
                <p>Automated fee calculation and receipt generation system for aided and unaided students with comprehensive fee structures.</p>
                <ul class="features-list">
                    <li>Dynamic Fee Calculation</li>
                    <li>Aided/Unaided Categories</li>
                    <li>Professional Receipt Format</li>
                    <li>Student Search & Selection</li>
                </ul>
                <a href="recipt/index.php" class="btn">
                    <i class="fas fa-calculator"></i> Generate Receipts
                </a>
            </div>

            <!-- Student Management Module -->
            <div class="module-card">
                <div class="module-icon student-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>New Admission Registration</h3>
                <p>Comprehensive student registration system with document management, data export, and complete student lifecycle management.</p>
                <ul class="features-list">
                    <li>Student Registration</li>
                    <li>Document Upload & Management</li>
                    <li>Data Export (PDF/Excel)</li>
                    <li>Advanced Search & Filtering</li>
                </ul>
                <a href="studmanage/index.php" class="btn">
                    <i class="fas fa-edit"></i> Manage Students
                </a>
            </div>

            <!-- Receipt Logs Module -->
            <div class="module-card">
                <div class="module-icon logs-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Receipt Generation Logs</h3>
                <p>Comprehensive logging and audit system for all receipt generation activities with detailed tracking and reporting.</p>
                <ul class="features-list">
                    <li>Receipt Generation Tracking</li>
                    <li>Admin Activity Monitoring</li>
                    <li>Statistical Reports</li>
                    <li>Data Export & Analytics</li>
                    <li>Real-time Receipt Logging</li>
                </ul>
                <a href="logs/view_logs.php" class="btn">
                    <i class="fas fa-chart-bar"></i> View Logs
                </a>
            </div>


        </div>


    </div>

    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on load
            const cards = document.querySelectorAll('.module-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });

            // Add click ripple effect to buttons
            document.querySelectorAll('.btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>
</body>
</html> 