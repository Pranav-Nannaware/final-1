<?php
/**
 * Receipt Logger Class
 * Handles all logging operations for receipt generation
 */

class ReceiptLogger {
    private $conn;
    private $log_dir;
    private $admin_info;
    
    public function __construct($db_connection, $log_directory = null) {
        $this->conn = $db_connection;
        $this->log_dir = $log_directory ?: __DIR__;
        $this->admin_info = $this->getAdminInfo();
    }
    
    /**
     * Get current admin information from session
     */
    private function getAdminInfo() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return [
            'id' => $_SESSION['admin_id'] ?? null,
            'username' => $_SESSION['admin_username'] ?? 'unknown',
            'name' => $_SESSION['admin_name'] ?? 'Unknown Admin',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'session_id' => session_id()
        ];
    }
    
    /**
     * Generate unique receipt ID
     */
    private function generateReceiptId() {
        $timestamp = date('YmdHis');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));
        return "RCPT-{$timestamp}-{$random}";
    }
    
    /**
     * Log receipt generation
     */
    public function logReceiptGeneration($student_data, $fee_components, $total_amount, $amount_in_words) {
        try {
            $receipt_id = $this->generateReceiptId();
            $receipt_date = date('Y-m-d');
            $academic_year = date('Y') . '-' . (date('Y') + 1);
            
            // Prepare fee components JSON
            $fee_components_json = json_encode($fee_components, JSON_UNESCAPED_UNICODE);
            
            $sql = "INSERT INTO receipt_logs (
                receipt_id, student_id, student_name, student_registration_number,
                institution_type, class, program_interest, fee_components,
                total_amount, amount_in_words, receipt_date, academic_year,
                admin_id, admin_username, admin_name, ip_address, user_agent, session_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->conn->prepare($sql);
            
            // Create variables for bind_param (needs variables that can be passed by reference)
            $student_id = $student_data['id'];
            $student_name = $student_data['full_name'];
            $registration_number = $student_data['registration_number'] ?? null;
            $institution_type = $student_data['institution_type'];
            $class = $student_data['class'];
            $program_interest = $student_data['program_interest'] ?? null;
            $admin_id = $this->admin_info['id'];
            $admin_username = $this->admin_info['username'];
            $admin_name = $this->admin_info['name'];
            $ip_address = $this->admin_info['ip_address'];
            $user_agent = $this->admin_info['user_agent'];
            $session_id = $this->admin_info['session_id'];
            
            $stmt->bind_param(
                "sissssssdsssssssss",
                $receipt_id,
                $student_id,
                $student_name,
                $registration_number,
                $institution_type,
                $class,
                $program_interest,
                $fee_components_json,
                $total_amount,
                $amount_in_words,
                $receipt_date,
                $academic_year,
                $admin_id,
                $admin_username,
                $admin_name,
                $ip_address,
                $user_agent,
                $session_id
            );
            
            if ($stmt->execute()) {
                $log_id = $stmt->insert_id;
                $stmt->close();
                
                // Log to file as well
                $this->logToFile($receipt_id, $student_data, $fee_components, $total_amount);
                
                return [
                    'success' => true,
                    'receipt_id' => $receipt_id,
                    'log_id' => $log_id
                ];
            } else {
                throw new Exception("Failed to insert receipt log: " . $stmt->error);
            }
        } catch (Exception $e) {
            error_log("Receipt logging error: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Log receipt modification
     */
    public function logReceiptModification($receipt_log_id, $modification_type, $old_values = null, $new_values = null, $notes = '') {
        try {
            $sql = "INSERT INTO receipt_modifications (
                receipt_log_id, modification_type, old_values, new_values,
                admin_id, admin_username, ip_address, notes
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $old_values_json = $old_values ? json_encode($old_values) : null;
            $new_values_json = $new_values ? json_encode($new_values) : null;
            
            $stmt = $this->conn->prepare($sql);
            
            // Create variables for bind_param
            $admin_id = $this->admin_info['id'];
            $admin_username = $this->admin_info['username'];
            $ip_address = $this->admin_info['ip_address'];
            
            $stmt->bind_param(
                "isssssss",
                $receipt_log_id,
                $modification_type,
                $old_values_json,
                $new_values_json,
                $admin_id,
                $admin_username,
                $ip_address,
                $notes
            );
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Receipt modification logging error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Log file generation
     */
    public function logFileGeneration($receipt_log_id, $file_type, $file_path, $file_size = null) {
        try {
            $file_hash = file_exists($file_path) ? hash_file('sha256', $file_path) : null;
            
            $sql = "INSERT INTO receipt_file_logs (
                receipt_log_id, file_type, file_path, file_size, file_hash
            ) VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("issis", $receipt_log_id, $file_type, $file_path, $file_size, $file_hash);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("File logging error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Log to file system
     */
    private function logToFile($receipt_id, $student_data, $fee_components, $total_amount) {
        $log_entry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'receipt_id' => $receipt_id,
            'admin' => $this->admin_info,
            'student' => [
                'id' => $student_data['id'],
                'name' => $student_data['full_name'],
                'class' => $student_data['class'],
                'institution_type' => $student_data['institution_type']
            ],
            'fee_components' => $fee_components,
            'total_amount' => $total_amount,
            'ip_address' => $this->admin_info['ip_address']
        ];
        
        $log_file = $this->log_dir . '/receipt_generation_' . date('Y-m-d') . '.log';
        $log_line = date('Y-m-d H:i:s') . ' | ' . json_encode($log_entry) . PHP_EOL;
        
        file_put_contents($log_file, $log_line, FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Get receipt logs with filters
     */
    public function getReceiptLogs($filters = []) {
        $sql = "SELECT rl.*, 
                       COUNT(rfl.id) as file_count,
                       COUNT(rm.id) as modification_count
                FROM receipt_logs rl
                LEFT JOIN receipt_file_logs rfl ON rl.id = rfl.receipt_log_id
                LEFT JOIN receipt_modifications rm ON rl.id = rm.receipt_log_id
                WHERE 1=1";
        
        $params = [];
        $types = '';
        
        if (!empty($filters['student_name'])) {
            $sql .= " AND rl.student_name LIKE ?";
            $params[] = '%' . $filters['student_name'] . '%';
            $types .= 's';
        }
        
        if (!empty($filters['date_from'])) {
            $sql .= " AND rl.receipt_date >= ?";
            $params[] = $filters['date_from'];
            $types .= 's';
        }
        
        if (!empty($filters['date_to'])) {
            $sql .= " AND rl.receipt_date <= ?";
            $params[] = $filters['date_to'];
            $types .= 's';
        }
        
        if (!empty($filters['admin_id'])) {
            $sql .= " AND rl.admin_id = ?";
            $params[] = $filters['admin_id'];
            $types .= 'i';
        }
        
        $sql .= " GROUP BY rl.id ORDER BY rl.created_at DESC";
        
        if (!empty($filters['limit'])) {
            $sql .= " LIMIT " . (int)$filters['limit'];
        }
        
        $stmt = $this->conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get receipt statistics
     */
    public function getReceiptStats($date_from = null, $date_to = null) {
        $sql = "SELECT 
                    COUNT(*) as total_receipts,
                    SUM(total_amount) as total_amount,
                    COUNT(DISTINCT student_id) as unique_students,
                    COUNT(DISTINCT admin_id) as unique_admins,
                    AVG(total_amount) as avg_amount,
                    institution_type,
                    DATE(receipt_date) as date
                FROM receipt_logs
                WHERE 1=1";
        
        $params = [];
        $types = '';
        
        if ($date_from) {
            $sql .= " AND receipt_date >= ?";
            $params[] = $date_from;
            $types .= 's';
        }
        
        if ($date_to) {
            $sql .= " AND receipt_date <= ?";
            $params[] = $date_to;
            $types .= 's';
        }
        
        $sql .= " GROUP BY institution_type, DATE(receipt_date) ORDER BY date DESC";
        
        $stmt = $this->conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Export logs to CSV
     */
    public function exportLogsToCSV($filters = []) {
        $logs = $this->getReceiptLogs($filters);
        
        $filename = 'receipt_logs_' . date('Y-m-d_H-i-s') . '.csv';
        $filepath = $this->log_dir . '/' . $filename;
        
        $fp = fopen($filepath, 'w');
        
        // CSV headers
        fputcsv($fp, [
            'Receipt ID', 'Student Name', 'Class', 'Institution Type',
            'Total Amount', 'Fee Components', 'Receipt Date', 'Admin Name',
            'Created At', 'Status'
        ]);
        
        // CSV data
        foreach ($logs as $log) {
            fputcsv($fp, [
                $log['receipt_id'],
                $log['student_name'],
                $log['class'],
                $log['institution_type'],
                $log['total_amount'],
                $log['fee_components'],
                $log['receipt_date'],
                $log['admin_name'],
                $log['created_at'],
                $log['status']
            ]);
        }
        
        fclose($fp);
        return $filepath;
    }
}
?> 