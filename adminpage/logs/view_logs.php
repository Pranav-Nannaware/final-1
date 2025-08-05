<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

// Include database connection and logger
require_once '../includes/db_config.php';
require_once 'receipt_logger.php';

$logger = new ReceiptLogger($conn);

// Handle filters
$filters = [];
if ($_GET) {
    if (!empty($_GET['student_name'])) $filters['student_name'] = $_GET['student_name'];
    if (!empty($_GET['date_from'])) $filters['date_from'] = $_GET['date_from'];
    if (!empty($_GET['date_to'])) $filters['date_to'] = $_GET['date_to'];
    if (!empty($_GET['admin_id'])) $filters['admin_id'] = $_GET['admin_id'];
    if (!empty($_GET['limit'])) $filters['limit'] = $_GET['limit'];
}

// Handle export
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    $filepath = $logger->exportLogsToCSV($filters);
    if (file_exists($filepath)) {
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        unlink($filepath); // Delete temporary file
        exit();
    }
}

// Get logs
$logs = $logger->getReceiptLogs($filters);
$stats = $logger->getReceiptStats($filters['date_from'] ?? null, $filters['date_to'] ?? null);

// Calculate summary statistics
$total_receipts = count($logs);
$total_amount = array_sum(array_column($logs, 'total_amount'));
$avg_amount = $total_receipts > 0 ? $total_amount / $total_receipts : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Receipt Logs - Admin Panel</title>
    <link rel="stylesheet" href="../assets/admin-theme.css">
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        
        .stat-card h3 {
            margin: 0;
            font-size: 2em;
        }
        
        .stat-card p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        
        .filters-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .log-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .log-table th {
            background: #343a40;
            color: white;
            padding: 12px;
            text-align: left;
        }
        
        .log-table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .log-table tr:hover {
            background-color: #f8f9fa;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: bold;
        }
        
        .status-generated { background: #d4edda; color: #155724; }
        .status-printed { background: #cce5ff; color: #004085; }
        .status-downloaded { background: #fff3cd; color: #856404; }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            margin: 20px 0;
        }
        
        .btn-export {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-export:hover {
            background: #218838;
        }
        
        .receipt-details {
            max-width: 300px;
            word-wrap: break-word;
        }
        
        .fee-components {
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Receipt Generation Logs</h1>
            <a href="../index.php" class="btn btn-secondary">← Back to Admin Panel</a>
        </div>
        
        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3><?php echo number_format($total_receipts); ?></h3>
                <p>Total Receipts</p>
            </div>
            <div class="stat-card">
                <h3>₹<?php echo number_format($total_amount); ?></h3>
                <p>Total Amount</p>
            </div>
            <div class="stat-card">
                <h3>₹<?php echo number_format($avg_amount, 2); ?></h3>
                <p>Average Amount</p>
            </div>
            <div class="stat-card">
                <h3><?php echo count(array_unique(array_column($logs, 'student_id'))); ?></h3>
                <p>Unique Students</p>
            </div>
        </div>
        
        <!-- Filters Section -->
        <div class="filters-section">
            <h3>Filter Logs</h3>
            <form method="GET" action="">
                <div class="filters-grid">
                    <div>
                        <label>Student Name:</label>
                        <input type="text" name="student_name" value="<?php echo htmlspecialchars($_GET['student_name'] ?? ''); ?>" 
                               placeholder="Search by student name">
                    </div>
                    <div>
                        <label>Date From:</label>
                        <input type="date" name="date_from" value="<?php echo $_GET['date_from'] ?? ''; ?>">
                    </div>
                    <div>
                        <label>Date To:</label>
                        <input type="date" name="date_to" value="<?php echo $_GET['date_to'] ?? ''; ?>">
                    </div>
                    <div>
                        <label>Limit Results:</label>
                        <select name="limit">
                            <option value="50" <?php echo ($_GET['limit'] ?? '50') == '50' ? 'selected' : ''; ?>>50</option>
                            <option value="100" <?php echo ($_GET['limit'] ?? '50') == '100' ? 'selected' : ''; ?>>100</option>
                            <option value="200" <?php echo ($_GET['limit'] ?? '50') == '200' ? 'selected' : ''; ?>>200</option>
                            <option value="500" <?php echo ($_GET['limit'] ?? '50') == '500' ? 'selected' : ''; ?>>500</option>
                        </select>
                    </div>
                </div>
                <div style="margin-top: 15px;">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="?" class="btn btn-secondary">Clear Filters</a>
                </div>
            </form>
        </div>
        
        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="?<?php echo http_build_query(array_merge($_GET, ['export' => 'csv'])); ?>" class="btn-export">
                📊 Export to CSV
            </a>
        </div>
        
        <!-- Logs Table -->
        <div class="table-responsive">
            <table class="log-table">
                <thead>
                    <tr>
                        <th>Receipt ID</th>
                        <th>Student Details</th>
                        <th>Fee Components</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Admin</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($log['receipt_id']); ?></strong>
                        </td>
                        <td class="receipt-details">
                            <strong><?php echo htmlspecialchars($log['student_name']); ?></strong><br>
                            <small>Class: <?php echo htmlspecialchars($log['class']); ?></small><br>
                            <small>Type: <?php echo htmlspecialchars($log['institution_type']); ?></small>
                        </td>
                        <td class="fee-components">
                            <?php 
                            $components = json_decode($log['fee_components'], true);
                            if (is_array($components)) {
                                echo implode(', ', array_keys($components));
                            } else {
                                echo htmlspecialchars($log['fee_components']);
                            }
                            ?>
                        </td>
                        <td>
                            <strong>₹<?php echo number_format($log['total_amount']); ?></strong>
                        </td>
                        <td>
                            <?php echo date('d/m/Y', strtotime($log['receipt_date'])); ?><br>
                            <small><?php echo date('H:i', strtotime($log['created_at'])); ?></small>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($log['admin_name']); ?><br>
                            <small><?php echo htmlspecialchars($log['ip_address']); ?></small>
                        </td>
                        <td>
                            <span class="status-badge status-<?php echo $log['status']; ?>">
                                <?php echo ucfirst($log['status']); ?>
                            </span>
                        </td>
                        <td>
                            <button onclick="viewReceiptDetails(<?php echo $log['id']; ?>)" class="btn btn-sm btn-info">
                                View
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <?php if (empty($logs)): ?>
        <div style="text-align: center; padding: 40px; color: #666;">
            <h3>No logs found</h3>
            <p>Try adjusting your filters or generate some receipts first.</p>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Receipt Details Modal -->
    <div id="receiptModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="receiptDetails"></div>
        </div>
    </div>
    
    <script>
        function viewReceiptDetails(logId) {
            // This would typically make an AJAX call to get detailed receipt information
            alert('Receipt details for log ID: ' + logId + '\nThis would show detailed receipt information in a modal.');
        }
        
        // Modal functionality
        var modal = document.getElementById("receiptModal");
        var span = document.getElementsByClassName("close")[0];
        
        span.onclick = function() {
            modal.style.display = "none";
        }
        
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html> 