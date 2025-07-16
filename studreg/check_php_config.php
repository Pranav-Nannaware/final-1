<?php
// PHP Configuration Checker for File Uploads
// Run this to verify PHP is configured correctly for file uploads

echo "<h2>PHP File Upload Configuration Check</h2>";

$checks = [
    'file_uploads' => ini_get('file_uploads'),
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'max_input_vars' => ini_get('max_input_vars'),
    'max_file_uploads' => ini_get('max_file_uploads'),
    'upload_tmp_dir' => ini_get('upload_tmp_dir') ?: sys_get_temp_dir(),
    'memory_limit' => ini_get('memory_limit'),
    'max_execution_time' => ini_get('max_execution_time')
];

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Setting</th><th>Current Value</th><th>Status</th></tr>";

foreach ($checks as $setting => $value) {
    $status = "OK";
    $color = "green";
    
    switch ($setting) {
        case 'file_uploads':
            if (!$value) {
                $status = "DISABLED - File uploads are turned off!";
                $color = "red";
            }
            break;
        case 'upload_max_filesize':
            $bytes = return_bytes($value);
            if ($bytes < 1024 * 1024) { // Less than 1MB
                $status = "TOO SMALL - Should be at least 1MB";
                $color = "orange";
            }
            break;
        case 'post_max_size':
            $bytes = return_bytes($value);
            if ($bytes < 8 * 1024 * 1024) { // Less than 8MB
                $status = "TOO SMALL - Should be at least 8MB for multiple files";
                $color = "orange";
            }
            break;
        case 'max_file_uploads':
            if ($value < 10) {
                $status = "TOO LOW - Should be at least 10 for multiple files";
                $color = "orange";
            }
            break;
    }
    
    echo "<tr>";
    echo "<td><strong>$setting</strong></td>";
    echo "<td>$value</td>";
    echo "<td style='color: $color'>$status</td>";
    echo "</tr>";
}

echo "</table>";

// Check temp directory permissions
$tmpDir = $checks['upload_tmp_dir'];
echo "<h3>Temporary Directory Check</h3>";
echo "<p><strong>Temp Directory:</strong> $tmpDir</p>";

if (is_dir($tmpDir)) {
    echo "<p style='color: green'>✓ Directory exists</p>";
    if (is_writable($tmpDir)) {
        echo "<p style='color: green'>✓ Directory is writable</p>";
    } else {
        echo "<p style='color: red'>✗ Directory is NOT writable</p>";
    }
} else {
    echo "<p style='color: red'>✗ Directory does NOT exist</p>";
}

// Test file creation
$testFile = $tmpDir . DIRECTORY_SEPARATOR . 'test_' . time() . '.tmp';
if (file_put_contents($testFile, 'test')) {
    echo "<p style='color: green'>✓ Can create test files</p>";
    unlink($testFile);
} else {
    echo "<p style='color: red'>✗ Cannot create test files</p>";
}

function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    $val = (int)$val;
    switch($last) {
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return $val;
}

echo "<h3>Recommendations</h3>";
echo "<ul>";
echo "<li>Ensure file_uploads = On</li>";
echo "<li>Set upload_max_filesize = 2M (or higher)</li>";
echo "<li>Set post_max_size = 8M (should be larger than upload_max_filesize)</li>";
echo "<li>Set max_file_uploads = 20 (to allow multiple files)</li>";
echo "<li>Ensure temp directory has proper write permissions</li>";
echo "</ul>";
?> 