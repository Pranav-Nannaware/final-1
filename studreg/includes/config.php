<?php
/**
 * Database Configuration
 */
define('DB_HOST', 'localhost');
define('DB_USER', 'cmrit_user');
define('DB_PASS', 'test');
define('DB_NAME', 'cmrit_db');

/**
 * Website Configuration
 */
define('SITE_URL', 'http://localhost/cmrit');
define('SITE_NAME', 'CMR Institute of Technology');
define('SITE_EMAIL', 'info@cmrit.edu.in');
define('SITE_PHONE', '+91 1234567890');
define('SITE_ADDRESS', 'CMR Institute of Technology, Medchal Road, Kandlakoya, Hyderabad, Telangana 501401');

/**
 * File Upload Settings
 */
define('UPLOAD_MAX_SIZE', 5242880); // 5MB in bytes
define('ALLOWED_FILE_TYPES', 'jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx');

/**
 * Error Reporting
 */
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_ADDR'] === '127.0.0.1') {
    // Development environment
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    define('ENVIRONMENT', 'development');
} else {
    // Production environment
    error_reporting(0);
    ini_set('display_errors', 0);
    define('ENVIRONMENT', 'production');
}

/**
 * Start Session with security settings
 */
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        ini_set('session.cookie_secure', 1);
    }
    session_start();
}

/**
 * Connect to Database
 */
try {
    $db = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    if (ENVIRONMENT === 'development') {
        die("Database connection failed: " . $e->getMessage());
    } else {
        // Log error and display friendly message
        error_log("Database connection failed: " . $e->getMessage());
        die("A database error occurred. Please try again later.");
    }

}

/**
 * Helper Functions
 */

// Clean user input
function clean($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Get current page name
function getCurrentPage() {
    return basename($_SERVER['PHP_SELF'], '.php');
}

/**
 * Basic functions file content (since functions.php may not exist)
 */
if (!function_exists('redirect')) {
    function redirect($url) {
        header("Location: $url");
        exit();
    }
}

if (!function_exists('flash_message')) {
    function flash_message($message, $type = 'info') {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }
}

if (!function_exists('get_flash_message')) {
    function get_flash_message() {
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            $type = $_SESSION['flash_type'] ?? 'info';
            unset($_SESSION['flash_message'], $_SESSION['flash_type']);
            return ['message' => $message, 'type' => $type];
        }
        return null;
    }
}
?> 