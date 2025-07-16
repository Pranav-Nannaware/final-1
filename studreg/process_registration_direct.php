<?php
// Direct processing without session redirects to prevent temporary file loss
// Enable comprehensive error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log errors to a file for server-side debugging
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

// Start session for error handling only
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the main configuration file for proper database connection
require_once 'includes/config.php';

// Log the start of processing
error_log("Direct registration processing started: " . date('Y-m-d H:i:s'));
error_log("Processing data for: " . (isset($_POST['full_name']) ? $_POST['full_name'] : 'Unknown'));

// Debug: Log file information
foreach ($_FILES as $fieldName => $file) {
    if (isset($file['name']) && $file['name']) {
        error_log("File uploaded - Field: {$fieldName}, Name: {$file['name']}, Size: {$file['size']}, Type: {$file['type']}, Error: {$file['error']}, TmpName exists: " . (file_exists($file['tmp_name']) ? 'YES' : 'NO'));
    }
}

try {
    // Validate mobile numbers: allow only digits
    $mobileNumber = $_POST['mobile_number'] ?? '';
    $guardianMobileNumber = $_POST['guardian_mobile_number'] ?? '';
    
    if (!ctype_digit($mobileNumber) || !ctype_digit($guardianMobileNumber)) {
        throw new Exception("Invalid mobile number format. Mobile numbers must contain only numeric digits.");
    }
    
    // Collect and sanitize form data
    $fullName = trim(htmlspecialchars($_POST['full_name'] ?? ''));
    $fatherName = trim(htmlspecialchars($_POST['father_name'] ?? ''));
    $motherName = trim(htmlspecialchars($_POST['mother_name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $dob = $_POST['dob'] ?? '';
    $gender = htmlspecialchars($_POST['gender'] ?? '');
    $class = htmlspecialchars($_POST['class'] ?? '');
    $programInterest = htmlspecialchars($_POST['program_interest'] ?? '');
    $institutionType = htmlspecialchars($_POST['institution_type'] ?? '');
    $caste = htmlspecialchars($_POST['caste'] ?? '');
    $category = htmlspecialchars($_POST['category'] ?? '');
    $schoolUdiseNumber = trim(htmlspecialchars($_POST['school_udise_number'] ?? ''));
    $aadhaarNumber = trim(htmlspecialchars($_POST['aadhaar_number'] ?? ''));
    $tenthMarks = intval($_POST['tenth_marks'] ?? 0);
    $tenthPercentage = floatval($_POST['tenth_percentage'] ?? 0.0);
    $currentAddress = trim(htmlspecialchars($_POST['current_address'] ?? ''));
    $permanentAddress = trim(htmlspecialchars($_POST['permanent_address'] ?? ''));
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format. Please provide a valid email address.");
    }
    
    // Validate date format
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $dob)) {
        throw new Exception("Invalid date format. Please use YYYY-MM-DD format.");
    }
    
    // Validate new fields
    if (!ctype_digit($schoolUdiseNumber) || empty($schoolUdiseNumber)) {
        throw new Exception("Invalid School UDISE Number. Please enter only numeric digits.");
    }
    
    if (!ctype_digit($aadhaarNumber) || strlen($aadhaarNumber) !== 12) {
        throw new Exception("Invalid Aadhaar Number. Please enter exactly 12 numeric digits.");
    }
    
    if ($tenthMarks < 0 || $tenthMarks > 1000) {
        throw new Exception("Invalid 10th marks. Please enter marks between 0 and 1000.");
    }
    
    if ($tenthPercentage < 0 || $tenthPercentage > 100) {
        throw new Exception("Invalid 10th percentage. Please enter percentage between 0 and 100.");
    }
    
    // Use the global database connection from config.php
    if (!isset($db)) {
        throw new Exception("Database connection not available. Please check configuration.");
    }
    
    // Check for duplicate email
    $emailCheckStmt = $db->prepare("SELECT COUNT(*) FROM student_register WHERE email = ?");
    $emailCheckStmt->execute([$email]);
    if ($emailCheckStmt->fetchColumn() > 0) {
        throw new Exception("This email address is already registered. Please use a different email address.");
    }
    
    // Helper function to handle file uploads to BLOB (enhanced version)
    function processFileToBlob($fieldName) {
        // If no file is uploaded
        if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] != UPLOAD_ERR_OK) {
            // Return null for optional files - database allows NULL values
            return null;
        }
        
        $file = $_FILES[$fieldName];
        
        error_log("Processing file: {$fieldName} - TmpName: {$file['tmp_name']}, Size: {$file['size']}, Error: {$file['error']}");
        
        // Check upload errors
        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                return null;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new Exception("File too large for {$fieldName}. Maximum allowed size is 1MB.");
            case UPLOAD_ERR_PARTIAL:
                throw new Exception("File upload was interrupted for {$fieldName}. Please try again.");
            case UPLOAD_ERR_NO_TMP_DIR:
                throw new Exception("Server configuration error: No temporary directory for {$fieldName}.");
            case UPLOAD_ERR_CANT_WRITE:
                throw new Exception("Server error: Cannot write file {$fieldName} to disk.");
            case UPLOAD_ERR_EXTENSION:
                throw new Exception("File upload stopped by PHP extension for {$fieldName}.");
            default:
                throw new Exception("Unknown upload error for {$fieldName}.");
        }
        
        // Check if file exists and is readable
        if (!file_exists($file['tmp_name']) || !is_readable($file['tmp_name'])) {
            throw new Exception("Uploaded file for {$fieldName} is not accessible. Please try uploading again.");
        }
        
        // Validate file size (1MB max)
        $maxFileSize = 1 * 1024 * 1024;
        if ($file['size'] > $maxFileSize) {
            throw new Exception("File too large: {$fieldName} exceeds 1MB size limit. Current size: " . round($file['size'] / 1024 / 1024, 2) . "MB");
        }
        
        // Get file extension from original filename
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
        
        // Validate file extension first
        if (!in_array($fileExtension, $allowedExtensions)) {
            throw new Exception("Invalid file extension for {$fieldName}. Only JPG, JPEG, PNG, or PDF files allowed. Uploaded: {$fileExtension}");
        }
        
        // Read file content first to ensure it's accessible
        $fileContent = file_get_contents($file['tmp_name']);
        if ($fileContent === false) {
            throw new Exception("Failed to read file: {$fieldName}. Please try uploading again.");
        }
        
        // Validate file signatures (magic bytes)
        $fileSignature = bin2hex(substr($fileContent, 0, 8));
        $validSignatures = [
            'ffd8ff' => 'JPEG',           // JPEG
            '89504e47' => 'PNG',          // PNG  
            '25504446' => 'PDF',          // PDF
        ];
        
        $isValidSignature = false;
        $detectedType = 'Unknown';
        foreach ($validSignatures as $signature => $type) {
            if (strpos($fileSignature, $signature) === 0) {
                $isValidSignature = true;
                $detectedType = $type;
                break;
            }
        }
        
        if (!$isValidSignature) {
            throw new Exception("Invalid file format for {$fieldName}. File appears to be corrupted or not a valid JPG, PNG, or PDF file. File signature: {$fileSignature}");
        }
        
        error_log("File {$fieldName} processed successfully - Type: {$detectedType}, Size: {$file['size']} bytes");
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
        school_udise_number, aadhaar_number, tenth_marks, tenth_percentage, is_new,
        current_address, permanent_address, 
        tenth_marksheet, school_leaving_certificate, aadhaar_card, passport_photo,
        caste_certificate, non_creamy_layer_certificate, ews_eligibility_certificate, 
        domicile_certificate, created_at
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW()
    )";
    
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . implode(", ", $db->errorInfo()));
    }
    
    // Execute with all parameters including BLOBs
    $result = $stmt->execute([
        $fullName, $fatherName, $motherName, $mobileNumber, $guardianMobileNumber,
        $email, $dob, $gender, $class, $programInterest, $institutionType,
        $caste, $category, $schoolUdiseNumber, $aadhaarNumber, $tenthMarks, $tenthPercentage,
        1, // is_new - set to 1 for new registrations
        $currentAddress, $permanentAddress,
        $tenthMarksheetBlob, $schoolLeavingCertificateBlob, $aadhaarCardBlob, $passportPhotoBlob,
        $casteCertificateBlob, $nonCreamyLayerCertBlob, $ewsEligibilityCertBlob, $domicileCertificateBlob
    ]);
    
    if (!$result) {
        throw new Exception("Execute failed: " . implode(", ", $stmt->errorInfo()));
    }
    
    // Get the ID of the inserted row
    $studentId = $db->lastInsertId();
    
    // Add information to be used on the success page
    $_SESSION['registration_success'] = true;
    $_SESSION['student_id'] = $studentId;
    $_SESSION['student_name'] = $fullName;
    $_SESSION['student_email'] = $email;
    
    // Log successful registration
    error_log("Registration successful for student ID: {$studentId}, Name: {$fullName}");
    
    // Instead of redirecting, include the success page directly
    $showSuccessPage = true;
    $successStudentId = $studentId;
    include 'registration_success_content.php';
    
} catch (Exception $e) {
    // Log the error
    error_log("Registration failed: " . $e->getMessage());
    error_log("Exception trace: " . $e->getTraceAsString());
    
    // Store error in session
    $_SESSION['registration_error'] = $e->getMessage();
    
    // Instead of redirecting, include the error page directly
    $showErrorPage = true;
    $errorMessage = $e->getMessage();
    include 'registration_error_content.php';
}
?> 