<?php
// payment_aided.php - Secure Payment Page for Aided Students with receipt storage in DB

// Enforce HTTPS connection
// if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
//     $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//     header('HTTP/1.1 301 Moved Permanently');
//     header('Location: ' . $redirect);
//     exit();
// }

// Start secure session with strict settings
session_start([
    'cookie_lifetime' => 0,
    'cookie_secure'   => true,
    'cookie_httponly' => true,
    'use_strict_mode' => true,
    'sid_length'      => 48,
]);



// Generate a CSRF token if one doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Define fee details for aided students
$feeDetails = [
    [
        'component' => 'HSC Exam Fees',
        'account'   => 'In Cash',
        'amount'    => 1000,
        'qr'        => 'qr_codes/hsc_exam.png'
    ],
    [
        'component' => 'Tuition Fees',
        'account'   => '471301010977915',
        'amount'    => 13450,
        'qr'        => 'uploads/UNAIDED TUTION.png'
    ],
    [
        'component' => 'Stationary Fees',
        'account'   => '471302010950644',
        'amount'    => 3000,
        'qr'        => 'uploads/STATIONARY.png'
    ],
    [
        'component' => 'C.S Fees (for CS Students only)',
        'account'   => '471301010977916',
        'amount'    => 19800,
        'qr'        => 'uploads/UNAIDED CS.png'
    ],
    [
        'component' => 'I.T Fees (for IT Students only)',
        'account'   => '471301010977918',
        'amount'    => 7000,
        'qr'        => 'uploads/UNAIDED IT.png'
    ],
    [
        'component' => 'PTA Fees',
        'account'   => '471302010951620',
        'amount'    => 200,
        'qr'        => 'uploads/UNAIDED PTA.png'
    ],
];
$totalAmount = array_sum(array_column($feeDetails, 'amount'));

$messages = []; // Array for success or error messages

// --- DATABASE CONNECTION ---
// Update the credentials below to match your settings
$db_host = 'localhost';
$db_name = 'cmrit_db';
$db_user = 'cmrit_user';
$db_pass = 'test';
$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}

// Mapping fee components to the database column that stores the receipt
$columnMapping = [
    'Tuition Fees'           => 'receipt_tuition',
    'Stationary Fees'        => 'receipt_stationary',
    'C.S Fees (for CS Students only)' => 'receipt_cs',
    'I.T Fees (for IT Students only)' => 'receipt_it',
    'PTA Fees'               => 'receipt_pta',
];

// --- FORM PROCESSING ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }
    
    // Check if we are generating the receipt (simulate generation)
    if (isset($_POST['generate_receipt'])) {
        $messages[] = "Receipt generated successfully. Please log in again to download the receipt once the admin approves.";
    } else {
        // Process the uploaded files for each fee (skipping HSC Exam Fees)
        foreach ($feeDetails as $index => $fee) {
            if ($fee['component'] === 'HSC Exam Fees') {
                continue;
            }
            if (!isset($columnMapping[$fee['component']])) {
                continue;
            }
            $dbColumn = $columnMapping[$fee['component']];
            $inputName = 'receipt_' . $index;
            
            // If a file has been uploaded for this fee
            if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] !== UPLOAD_ERR_NO_FILE) {
                if ($_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES[$inputName]['tmp_name'];
                    // Validate file type and size (100KB max)
                    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimeType = $finfo->file($tmpName);
                    
                    if (!in_array($mimeType, $allowedMimeTypes)) {
                        $messages[] = "Invalid file type for " . htmlspecialchars($fee['component'], ENT_QUOTES, 'UTF-8') . ". Please upload a JPG or PNG.";
                        continue;
                    }
                    
                    if ($_FILES[$inputName]['size'] > 2097152) {
                        $messages[] = "File too large for " . htmlspecialchars($fee['component'], ENT_QUOTES, 'UTF-8') . ". Maximum allowed size is 2 MB.";
                        continue;
                    }
                    
                    // Read the file as binary data
                    $fileData = file_get_contents($tmpName);
                    if ($fileData === false) {
                        $messages[] = "Error reading file data for " . htmlspecialchars($fee['component'], ENT_QUOTES, 'UTF-8') . ".";
                        continue;
                    }
                    
                    // Prepare and execute the UPDATE query to save the BLOB data
                    $sql = "UPDATE existstudents SET {$dbColumn} = :fileData WHERE registration_number = :registration_number";
                    $stmt = $pdo->prepare($sql);
                    // Bind parameters (using PARAM_LOB for file data)
                    $stmt->bindParam(':fileData', $fileData, PDO::PARAM_LOB);
                    $stmt->bindParam(':registration_number', $_SESSION['registration_number'], PDO::PARAM_STR);
                    
                    try {
                        if ($stmt->execute()) {
                            $messages[] = "Receipt for " . htmlspecialchars($fee['component'], ENT_QUOTES, 'UTF-8') . " uploaded and stored successfully.";
                        } else {
                            $messages[] = "Failed to update database for " . htmlspecialchars($fee['component'], ENT_QUOTES, 'UTF-8') . ".";
                        }
                    } catch (PDOException $e) {
                        $messages[] = "Database error while uploading receipt for " . htmlspecialchars($fee['component'], ENT_QUOTES, 'UTF-8') . ": " . $e->getMessage();
                    }
                } else {
                    $messages[] = "Error uploading file for " . htmlspecialchars($fee['component'], ENT_QUOTES, 'UTF-8') . ": " . getFileErrorMessage($_FILES[$inputName]['error']);
                }
            }
        }
    }
    // Regenerate the CSRF token after processing
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Function to get human-readable file upload error messages
function getFileErrorMessage($errorCode) {
    switch ($errorCode) {
        case UPLOAD_ERR_INI_SIZE:
            return "The uploaded file exceeds the upload_max_filesize directive in php.ini";
        case UPLOAD_ERR_FORM_SIZE:
            return "The uploaded file exceeds the MAX_FILE_SIZE directive in the HTML form";
        case UPLOAD_ERR_PARTIAL:
            return "The uploaded file was only partially uploaded";
        case UPLOAD_ERR_NO_FILE:
            return "No file was uploaded";
        case UPLOAD_ERR_NO_TMP_DIR:
            return "Missing a temporary folder";
        case UPLOAD_ERR_CANT_WRITE:
            return "Failed to write file to disk";
        case UPLOAD_ERR_EXTENSION:
            return "File upload stopped by extension";
        default:
            return "Unknown upload error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Unaided Students</title>
    <link rel="stylesheet" href="assets/modern-theme.css">
</head>
<body>
        <div class="container">
        <div class="card fade-in">
            <div class="card-header">
                <h1 class="card-title">
                    <i class="fas fa-user-graduate"></i>
                    Payment Portal - Unaided Students
                </h1>
                <p class="card-subtitle">Upload your payment receipts for verification</p>
            </div>
            
            <?php if (empty($_SESSION['registration_number'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    Error: No registration number found in session. Please start from the registration page.
                </div>
            <?php else: ?>
                <div class="alert alert-success">
                    <i class="fas fa-user-check"></i>
                    Student: <?php echo htmlspecialchars($_SESSION['student_name'] ?? 'Unknown', ENT_QUOTES, 'UTF-8'); ?> 
                    (Reg #: <?php echo htmlspecialchars($_SESSION['registration_number'], ENT_QUOTES, 'UTF-8'); ?>)
                </div>
            <?php endif; ?>
            
            <?php if ($messages): ?>
                <?php foreach ($messages as $msg): ?>
                    <div class="alert <?php echo (strpos($msg, 'successfully') !== false) ? 'alert-success' : 'alert-error'; ?>">
                        <i class="fas <?php echo (strpos($msg, 'successfully') !== false) ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?>"></i>
                        <?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <form action="payment_unaided.php" method="POST" enctype="multipart/form-data">
                <!-- CSRF token -->
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <i class="fas fa-list"></i>
                                    Fee Component
                                </th>
                                <th>
                                    <i class="fas fa-credit-card"></i>
                                    Account Number
                                </th>
                                <th>
                                    <i class="fas fa-rupee-sign"></i>
                                    Amount (₹)
                                </th>
                                <th>
                                    <i class="fas fa-qrcode"></i>
                                    QR Code
                                </th>
                                <th>
                                    <i class="fas fa-upload"></i>
                                    Payment Receipt Upload
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($feeDetails as $index => $fee): ?>
                                <tr>
                                    <td>
                                        <i class="fas fa-file-invoice"></i>
                                        <?php echo htmlspecialchars($fee['component'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td class="font-mono"><?php echo htmlspecialchars($fee['account'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="font-bold">₹<?php echo number_format($fee['amount']); ?></td>
                                    <td>
                                        <?php if ($fee['component'] === 'HSC Exam Fees'): ?>
                                            <span class="text-secondary">No QR Code</span>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-sm btn-outline" data-img="<?php echo htmlspecialchars($fee['qr'], ENT_QUOTES, 'UTF-8'); ?>">
                                                <i class="fas fa-qrcode"></i>
                                                View QR Code
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($fee['component'] === 'HSC Exam Fees'): ?>
                                            <span class="text-secondary">N/A</span>
                                        <?php else: ?>
                                            <input type="file" name="receipt_<?php echo $index; ?>" accept="image/*" class="form-control">
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="bg-gray-50">
                                <td class="font-bold text-lg" colspan="2">
                                    <i class="fas fa-calculator"></i>
                                    Total Amount
                                </td>
                                <td class="font-bold text-lg text-primary">₹<?php echo number_format($totalAmount); ?></td>
                                <td colspan="2"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="text-center mt-8">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-upload"></i>
                        Submit Payments & Upload Receipts
                    </button>
                </div>
                
                <div class="mt-8 p-6 bg-yellow-50 rounded-lg border border-yellow-200">
                    <h3 class="text-lg font-bold mb-4 text-yellow-800">
                        <i class="fas fa-exclamation-triangle"></i>
                        Important Notes
                    </h3>
                    <ul class="space-y-2 text-yellow-700">
                        <li>
                            <i class="fas fa-check-circle"></i>
                            Make sure that the UPI transaction ID is visible in the screenshot
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            Log in again to download the receipt as soon as the admin generates it
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            Only JPG and PNG files are accepted (max 2MB)
                        </li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Modal for displaying QR Code -->
    <div id="qrModal" class="modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal()">&times;</button>
            <h3 class="text-lg font-bold mb-4">
                <i class="fas fa-qrcode"></i>
                QR Code
            </h3>
            <img id="qrImage" src="" alt="QR Code" class="w-full rounded-lg">
        </div>
    </div>
    
    <script>
        // QR Code modal functionality
        var modal = document.getElementById('qrModal');
        var modalImg = document.getElementById('qrImage');
        
        // Add click event to all QR buttons
        document.querySelectorAll('[data-img]').forEach(function(button) {
            button.addEventListener('click', function() {
                modal.style.display = "block";
                modalImg.src = button.getAttribute('data-img');
            });
        });
        
        function closeModal() {
            modal.style.display = "none";
        }
        
        // Close modal when clicking outside
        modal.onclick = function(event) {
            if (event.target === modal) {
                closeModal();
            }
        };

        // Validate file size on file input change
        document.querySelectorAll('input[type="file"]').forEach(function(input) {
            input.addEventListener('change', function() {
                if (input.files.length > 0) {
                    var file = input.files[0];
                    if (file.size > 2097152) { // 2MB = 2097152 bytes
                        alert("File too large. Maximum allowed size is 2 MB.");
                        input.value = "";
                    }
                }
            });
        });

        // Add loading states to form submission
        document.querySelector('form').addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            }
        });
    </script>
</body>
</html>
