# Receipt Generation Logging System

## Overview

The Receipt Generation Logging System is a comprehensive audit and tracking system for all receipt generation activities in the Bharat English School & Jr. College management system. It provides detailed logging, monitoring, and reporting capabilities for administrators.

## Features

### 🔍 **Complete Audit Trail**
- Track every receipt generation with unique receipt IDs
- Monitor admin activities and IP addresses
- Record all fee components and amounts
- Store session information for security

### 📊 **Advanced Analytics**
- Real-time statistics and reporting
- Filter logs by date, student, admin, or amount
- Export data to CSV format
- Visual dashboard with key metrics

### 🔒 **Security & Compliance**
- Secure logging with admin authentication
- IP address tracking for audit purposes
- Session management and user agent logging
- Data integrity with file hashing

### 📈 **Performance Monitoring**
- Track receipt generation patterns
- Monitor admin productivity
- Analyze fee structure usage
- Generate compliance reports

## System Architecture

### Database Tables

1. **`receipt_logs`** - Main logging table
   - Receipt details and student information
   - Fee components and amounts
   - Admin information and timestamps
   - Status tracking and metadata

2. **`receipt_file_logs`** - File generation tracking
   - PDF, HTML, and image file logs
   - File size and hash verification
   - File path management

3. **`receipt_modifications`** - Audit trail
   - Track all modifications to receipts
   - Before/after value comparison
   - Admin action logging

### File Structure

```
adminpage/logs/
├── receipt_logger.php          # Main logging class
├── view_logs.php              # Log viewer interface
├── setup_logging.php          # Database setup script
├── receipt_logs.sql           # Database schema
├── README.md                  # This documentation
└── *.log                      # Daily log files
```

## Installation & Setup

### 1. Database Setup
Run the setup script to create necessary tables:
```
http://your-domain/adminpage/logs/setup_logging.php
```

### 2. Integration
The logging system is automatically integrated into the receipt generator. No additional configuration required.

### 3. Access Logs
Navigate to Admin Panel → Receipt Generation Logs to view and manage logs.

## Usage

### For Administrators

#### Viewing Logs
1. Access the admin panel
2. Click on "Receipt Generation Logs"
3. Use filters to search specific logs
4. Export data as needed

#### Key Features
- **Filter by Date Range**: Select specific periods
- **Search by Student**: Find receipts for specific students
- **Admin Filtering**: View logs by specific administrators
- **Export to CSV**: Download data for external analysis

### For Developers

#### Adding Logging to New Features
```php
// Include the logger
require_once 'logs/receipt_logger.php';
$logger = new ReceiptLogger($conn);

// Log an activity
$logger->logReceiptGeneration($student_data, $fee_components, $total_amount, $amount_in_words);

// Log modifications
$logger->logReceiptModification($log_id, 'modified', $old_values, $new_values);

// Log file generation
$logger->logFileGeneration($log_id, 'pdf', $file_path, $file_size);
```

#### Custom Logging
```php
// Get filtered logs
$logs = $logger->getReceiptLogs([
    'student_name' => 'John Doe',
    'date_from' => '2024-01-01',
    'date_to' => '2024-12-31',
    'limit' => 100
]);

// Get statistics
$stats = $logger->getReceiptStats('2024-01-01', '2024-12-31');

// Export logs
$filepath = $logger->exportLogsToCSV($filters);
```

## Configuration

### Database Connection
The system uses the existing database configuration from `adminpage/includes/db_config.php`.

### Log File Storage
Log files are stored in the `adminpage/logs/` directory with daily rotation:
- `receipt_generation_YYYY-MM-DD.log`

### Security Settings
- Admin authentication required for all log access
- IP address logging enabled
- Session tracking for audit purposes

## Monitoring & Maintenance

### Daily Tasks
- Check log file sizes
- Monitor database table growth
- Review error logs

### Weekly Tasks
- Export and archive old logs
- Review admin activity patterns
- Generate compliance reports

### Monthly Tasks
- Analyze receipt generation trends
- Review security logs
- Update logging configurations

## Troubleshooting

### Common Issues

1. **Logs not appearing**
   - Check database connection
   - Verify admin session
   - Ensure tables are created

2. **Export fails**
   - Check file permissions
   - Verify disk space
   - Review error logs

3. **Performance issues**
   - Add database indexes
   - Archive old logs
   - Optimize queries

### Error Logs
Check the following locations for error information:
- PHP error log
- Database error log
- Application log files

## Security Considerations

### Data Protection
- All sensitive data is encrypted in transit
- Database connections use prepared statements
- File uploads are validated and sanitized

### Access Control
- Admin authentication required
- Session-based access control
- IP address logging for audit

### Compliance
- GDPR-compliant data handling
- Audit trail for all activities
- Secure data retention policies

## API Reference

### ReceiptLogger Class

#### Constructor
```php
ReceiptLogger($db_connection, $log_directory = null)
```

#### Methods

**logReceiptGeneration($student_data, $fee_components, $total_amount, $amount_in_words)**
- Logs a new receipt generation
- Returns array with success status and receipt ID

**logReceiptModification($receipt_log_id, $modification_type, $old_values, $new_values, $notes)**
- Logs modifications to existing receipts
- Returns boolean success status

**getReceiptLogs($filters = [])**
- Retrieves filtered logs
- Supports date, student, admin, and limit filters

**getReceiptStats($date_from = null, $date_to = null)**
- Returns statistical data
- Supports date range filtering

**exportLogsToCSV($filters = [])**
- Exports logs to CSV format
- Returns file path of exported file

## Support

For technical support or questions about the logging system:
1. Check this documentation
2. Review error logs
3. Contact system administrator

## Version History

- **v1.0.0** - Initial release with basic logging
- **v1.1.0** - Added export functionality and statistics
- **v1.2.0** - Enhanced security and audit features

---

*This logging system is designed to provide comprehensive audit capabilities while maintaining high performance and security standards.* 