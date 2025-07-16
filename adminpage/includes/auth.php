<?php
// Authentication helper functions

function check_admin_login() {
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check if user is logged in
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: ./login.php');
        exit();
    }
    
    // Check session timeout (8 hours)
    $timeout = 8 * 60 * 60; // 8 hours in seconds
    if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $timeout) {
        // Session expired
        session_destroy();
        header('Location: ./login.php?expired=1');
        exit();
    }
    
    // Update login time
    $_SESSION['login_time'] = time();
}

function get_admin_info() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    return [
        'id' => $_SESSION['admin_id'] ?? null,
        'username' => $_SESSION['admin_username'] ?? null,
        'full_name' => $_SESSION['admin_full_name'] ?? null
    ];
}

function is_admin_logged_in() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function logout_admin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Clear all session variables
    $_SESSION = array();
    
    // Destroy the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy the session
    session_destroy();
}
?> 