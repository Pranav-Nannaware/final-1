<?php
// Enable comprehensive error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log errors to a file for server-side debugging
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

// Start session to retrieve form data only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the main configuration file for proper database connection
require_once 'includes/config.php';

// Check if we have form data
if (!isset($_SESSION['form_data']) || !isset($_SESSION['form_files'])) {
    // Redirect back to the form if no data
    header('Location: registration.php');
    exit();
}

// Get form data from session
$postData = $_SESSION['form_data'];
$_FILES = $_SESSION['form_files'];

// Log the start of processing
error_log("Process registration started: " . date('Y-m-d H:i:s'));
error_log("Processing data for: " . (isset($postData['full_name']) ? $postData['full_name'] : 'Unknown'));

// Debug: Log file information
foreach ($_FILES as $fieldName => $file) {
    if (isset($file['name']) && $file['name']) {
        error_log("File uploaded - Field: {$fieldName}, Name: {$file['name']}, Size: {$file['size']}, Type: {$file['type']}, Error: {$file['error']}");
    }
}

try {
    // Validate mobile numbers: allow only digits
    $mobileNumber = $postData['mobile_number'] ?? '';
    $guardianMobileNumber = $postData['guardian_mobile_number'] ?? '';
    
    if (!ctype_digit($mobileNumber) || !ctype_digit($guardianMobileNumber)) {
        throw new Exception("Invalid mobile number format. Mobile numbers must contain only numeric digits.");
    }
    
    // Collect and sanitize form data
    $fullName = trim(htmlspecialchars($postData['full_name'] ?? ''));
    $fatherName = trim(htmlspecialchars($postData['father_name'] ?? ''));
    $motherName = trim(htmlspecialchars($postData['mother_name'] ?? ''));
    $email = filter_var(trim($postData['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $dob = $postData['dob'] ?? '';
    $gender = htmlspecialchars($postData['gender'] ?? '');
    $class = htmlspecialchars($postData['class'] ?? '');
    $programInterest = htmlspecialchars($postData['program_interest'] ?? '');
    $institutionType = htmlspecialchars($postData['institution_type'] ?? '');
    $caste = htmlspecialchars($postData['caste'] ?? '');
    $category = htmlspecialchars($postData['category'] ?? '');
    $currentAddress = trim(htmlspecialchars($postData['current_address'] ?? ''));
    $permanentAddress = trim(htmlspecialchars($postData['permanent_address'] ?? ''));
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format. Please provide a valid email address.");
    }
    
    // Validate date format
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $dob)) {
        throw new Exception("Invalid date format. Please use YYYY-MM-DD format.");
    }
    
    // Use the global database connection from config.php
    if (!isset($db)) {
        throw new Exception("Database connection not available. Please check configuration.");
    }
    
    // Helper function to handle file uploads to BLOB (matching database schema)
    function processFileToBlob($fieldName) {
        // If no file is uploaded
        if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] != UPLOAD_ERR_OK) {
            // Return null for all files - database allows NULL values
            return null;
        }
        
        $file = $_FILES[$fieldName];
        
        // Check if file exists and is readable
        if (!file_exists($file['tmp_name']) || !is_readable($file['tmp_name'])) {
            throw new Exception("Uploaded file for {$fieldName} is not accessible. Please try uploading again.");
        }
        
        // Validate file size (1MB max)
        $maxFileSize = 1 * 1024 * 1024;
        if ($file['size'] > $maxFileSize) {
            throw new Exception("File too large: {$fieldName} exceeds 1MB size limit.");
        }
        
        // Get file extension from original filename
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
        
        // Validate file extension first
        if (!in_array($fileExtension, $allowedExtensions)) {
            throw new Exception("Invalid file extension for {$fieldName}. Only JPG, JPEG, PNG, or PDF files allowed. Uploaded: {$fileExtension}");
        }
        
        // Validate MIME type if finfo is available
        if (function_exists('finfo_open')) {
            $allowedMimeTypes = [
                'image/jpeg', 
                'image/jpg',
                'image/pjpeg',
                'image/png', 
                'application/pdf',
                'application/x-pdf'
            ];
            
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo !== false) {
                $mimeType = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);
                
                if ($mimeType && !in_array($mimeType, $allowedMimeTypes)) {
                    throw new Exception("Invalid file type for {$fieldName}. Only JPG, PNG, or PDF allowed. Detected MIME type: {$mimeType}");
                }
            }
        }
        
        // Additional validation: Check file signature (magic bytes)
        $fileContent = file_get_contents($file['tmp_name']);
        if ($fileContent === false) {
            throw new Exception("Failed to read file: {$fieldName}.");
        }
        
        // Validate file signatures
        $fileSignature = bin2hex(substr($fileContent, 0, 8));
        $validSignatures = [
            'ffd8ff',           // JPEG
            '89504e47',         // PNG
            '25504446',         // PDF
            '504b0304',         // Some PDF variants
        ];
        
        $isValidSignature = false;
        foreach ($validSignatures as $signature) {
            if (strpos($fileSignature, $signature) === 0) {
                $isValidSignature = true;
                break;
            }
        }
        
        if (!$isValidSignature) {
            throw new Exception("Invalid file format for {$fieldName}. File appears to be corrupted or not a valid JPG, PNG, or PDF file.");
        }
        
        return $fileContent;
    }
    
    // Process all files to BLOB format
    $tenthMarksheetBlob = processFileToBlob('tenth_marksheet');
    $schoolLeavingCertificateBlob = processFileToBlob('school_leaving_certificate');
    $aadhaarCardBlob = processFileToBlob('aadhaar_card');
    $passportPhotoBlob = processFileToBlob('passport_photo');
    $casteCertificateBlob = processFileToBlob('caste_certificate');
    $nonCreamyLayerCertBlob = processFileToBlob('non_creamy_layer_certificate');
    $ewsEligibilityCertBlob = processFileToBlob('ews_eligibility_certificate');
    $domicileCertificateBlob = processFileToBlob('domicile_certificate');
    
    // Check if required files were uploaded
    if (!$tenthMarksheetBlob || !$schoolLeavingCertificateBlob || 
        !$aadhaarCardBlob || !$passportPhotoBlob) {
        throw new Exception("One or more required documents are missing. Please upload: 10th Marksheet, School Leaving Certificate, Aadhaar Card, and Passport Photo.");
    }
    
    // Insert student data with documents using PDO (matching the config.php connection)
    $sql = "INSERT INTO student_register (
        full_name, father_name, mother_name, mobile_number, guardian_mobile_number,
        email, dob, gender, class, program_interest, institution_type, caste, category,
        current_address, permanent_address, 
        tenth_marksheet, school_leaving_certificate, aadhaar_card, passport_photo,
        caste_certificate, non_creamy_layer_certificate, ews_eligibility_certificate, 
        domicile_certificate, created_at
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW()
    )";
    
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . implode(", ", $db->errorInfo()));
    }
    
    // Execute with all parameters including BLOBs
    $result = $stmt->execute([
        $fullName, $fatherName, $motherName, $mobileNumber, $guardianMobileNumber,
        $email, $dob, $gender, $class, $programInterest, $institutionType,
        $caste, $category, $currentAddress, $permanentAddress,
        $tenthMarksheetBlob, $schoolLeavingCertificateBlob, $aadhaarCardBlob, $passportPhotoBlob,
        $casteCertificateBlob, $nonCreamyLayerCertBlob, $ewsEligibilityCertBlob, $domicileCertificateBlob
    ]);
    
    if (!$result) {
        throw new Exception("Execute failed: " . implode(", ", $stmt->errorInfo()));
    }
    
    // Get the ID of the inserted row
    $studentId = $db->lastInsertId();
    
    // Clear the session data to prevent resubmission
    unset($_SESSION['form_data']);
    unset($_SESSION['form_files']);
    
    // Add information to be used on the success page
    $_SESSION['registration_success'] = true;
    $_SESSION['student_id'] = $studentId;
    $_SESSION['student_name'] = $fullName;
    $_SESSION['student_email'] = $email;
    
    // Log successful registration
    error_log("Registration successful for student ID: {$studentId}, Name: {$fullName}");
    
    // Redirect to success page
    header('Location: registration_success.php?id=' . $studentId);
    exit();
    
} catch (Exception $e) {
    // Log the error
    error_log("Registration failed: " . $e->getMessage());
    error_log("Exception trace: " . $e->getTraceAsString());
    
    // Store error in session
    $_SESSION['registration_error'] = $e->getMessage();
    
    // Clear form data to prevent eternal loop
    unset($_SESSION['form_data']);
    unset($_SESSION['form_files']);
    
    // Redirect to error page
    header('Location: registration_error.php');
    exit();
}
?> 