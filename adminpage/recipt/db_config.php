<?php
// Database configuration
$servername = "localhost";
$username = "cmrit_user";
$password = "test";
$dbname = "cmrit_db";

// Create connection
function getDBConnection() {
    global $servername, $username, $password, $dbname;
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}
?> 