<?php
// Database configuration
$host = 'localhost';
$dbname = 'cmrit_db';
$username = 'cmrit_user';
$password = 'test';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                addStudent($pdo);
                break;
            case 'edit':
                editStudent($pdo);
                break;
            case 'delete':
                deleteStudent($pdo);
                break;
        }
    }
}

// Handle document download
if (isset($_GET['download']) && isset($_GET['student_id']) && isset($_GET['doc_type'])) {
    downloadDocument($pdo, $_GET['student_id'], $_GET['doc_type']);
    exit;
}

// Handle document view
if (isset($_GET['view']) && isset($_GET['student_id']) && isset($_GET['doc_type'])) {
    viewDocument($pdo, $_GET['student_id'], $_GET['doc_type']);
    exit;
}

// Handle PDF generation
if (isset($_GET['generate_pdf']) && isset($_GET['student_id'])) {
    $mode = $_GET['mode'] ?? 'download';
    generateStudentPDF($pdo, $_GET['student_id'], $mode);
    exit;
}

// Handle Excel report generation
if (isset($_GET['generate_excel_report'])) {
    $classFilter = $_GET['class_filter'] ?? '';
    $institutionFilter = $_GET['institution_filter'] ?? '';
    generateExcelReport($pdo, $classFilter, $institutionFilter);
    exit;
}

// Get current action
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

function addStudent($pdo) {
    $sql = "INSERT INTO student_register (
        full_name, father_name, mother_name, mobile_number, guardian_mobile_number,
        email, dob, gender, class, program_interest, institution_type, caste,
        category, school_udise_number, aadhaar_number, tenth_marks, tenth_percentage,
        current_address, permanent_address, tenth_marksheet, school_leaving_certificate,
        aadhaar_card, passport_photo, caste_certificate, non_creamy_layer_certificate,
        ews_eligibility_certificate, domicile_certificate
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    
    // Handle file uploads
    $files = ['tenth_marksheet', 'school_leaving_certificate', 'aadhaar_card', 'passport_photo', 
              'caste_certificate', 'non_creamy_layer_certificate', 'ews_eligibility_certificate', 
              'domicile_certificate'];
    
    $fileData = [];
    foreach ($files as $file) {
        if (isset($_FILES[$file]) && $_FILES[$file]['error'] === UPLOAD_ERR_OK) {
            $fileData[$file] = file_get_contents($_FILES[$file]['tmp_name']);
        } else {
            $fileData[$file] = null;
        }
    }
    
    $stmt->execute([
        $_POST['full_name'], $_POST['father_name'], $_POST['mother_name'],
        $_POST['mobile_number'], $_POST['guardian_mobile_number'], $_POST['email'],
        $_POST['dob'], $_POST['gender'], $_POST['class'], $_POST['program_interest'],
        $_POST['institution_type'], $_POST['caste'], $_POST['category'],
        $_POST['school_udise_number'], $_POST['aadhaar_number'], $_POST['tenth_marks'],
        $_POST['tenth_percentage'], $_POST['current_address'], $_POST['permanent_address'],
        $fileData['tenth_marksheet'], $fileData['school_leaving_certificate'],
        $fileData['aadhaar_card'], $fileData['passport_photo'], $fileData['caste_certificate'],
        $fileData['non_creamy_layer_certificate'], $fileData['ews_eligibility_certificate'],
        $fileData['domicile_certificate']
    ]);
    
    header("Location: index.php?message=Student added successfully");
    exit;
}

function editStudent($pdo) {
    $sql = "UPDATE student_register SET 
        full_name=?, father_name=?, mother_name=?, mobile_number=?, guardian_mobile_number=?,
        email=?, dob=?, gender=?, class=?, program_interest=?, institution_type=?, caste=?,
        category=?, school_udise_number=?, aadhaar_number=?, tenth_marks=?, tenth_percentage=?,
        current_address=?, permanent_address=?";
    
    $params = [
        $_POST['full_name'], $_POST['father_name'], $_POST['mother_name'],
        $_POST['mobile_number'], $_POST['guardian_mobile_number'], $_POST['email'],
        $_POST['dob'], $_POST['gender'], $_POST['class'], $_POST['program_interest'],
        $_POST['institution_type'], $_POST['caste'], $_POST['category'],
        $_POST['school_udise_number'], $_POST['aadhaar_number'], $_POST['tenth_marks'],
        $_POST['tenth_percentage'], $_POST['current_address'], $_POST['permanent_address']
    ];
    
    // Handle file uploads for edit
    $files = ['tenth_marksheet', 'school_leaving_certificate', 'aadhaar_card', 'passport_photo', 
              'caste_certificate', 'non_creamy_layer_certificate', 'ews_eligibility_certificate', 
              'domicile_certificate'];
    
    foreach ($files as $file) {
        if (isset($_FILES[$file]) && $_FILES[$file]['error'] === UPLOAD_ERR_OK) {
            $sql .= ", $file=?";
            $params[] = file_get_contents($_FILES[$file]['tmp_name']);
        }
    }
    
    $sql .= " WHERE id=?";
    $params[] = $_POST['id'];
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    
    header("Location: index.php?message=Student updated successfully");
    exit;
}

function deleteStudent($pdo) {
    $stmt = $pdo->prepare("DELETE FROM student_register WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    
    header("Location: index.php?message=Student deleted successfully");
    exit;
}

function getStudent($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM student_register WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function markAsViewed($pdo, $id) {
    $stmt = $pdo->prepare("UPDATE student_register SET is_new = 0 WHERE id = ?");
    $stmt->execute([$id]);
}

function downloadDocument($pdo, $studentId, $docType) {
    $allowedTypes = ['tenth_marksheet', 'school_leaving_certificate', 'aadhaar_card', 'passport_photo', 
                     'caste_certificate', 'non_creamy_layer_certificate', 'ews_eligibility_certificate', 
                     'domicile_certificate'];
    
    if (!in_array($docType, $allowedTypes)) {
        http_response_code(400);
        die("Invalid document type");
    }
    
    $stmt = $pdo->prepare("SELECT $docType, full_name FROM student_register WHERE id = ?");
    $stmt->execute([$studentId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$result || !$result[$docType]) {
        http_response_code(404);
        die("Document not found");
    }
    
    // Generate filename
    $fileName = $result['full_name'] . '_' . $docType;
    
    // Set headers for file download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Content-Length: ' . strlen($result[$docType]));
    
    // Output the file content
    echo $result[$docType];
}

function viewDocument($pdo, $studentId, $docType) {
    $allowedTypes = ['tenth_marksheet', 'school_leaving_certificate', 'aadhaar_card', 'passport_photo', 
                     'caste_certificate', 'non_creamy_layer_certificate', 'ews_eligibility_certificate', 
                     'domicile_certificate'];
    
    if (!in_array($docType, $allowedTypes)) {
        http_response_code(400);
        die("Invalid document type");
    }
    
    $stmt = $pdo->prepare("SELECT $docType, full_name FROM student_register WHERE id = ?");
    $stmt->execute([$studentId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$result || !$result[$docType]) {
        http_response_code(404);
        die("Document not found");
    }
    
    // Generate filename
    $fileName = $result['full_name'] . '_' . $docType;
    
    // Detect content type based on file signature
    $fileContent = $result[$docType];
    $contentType = 'application/octet-stream';
    
    // Check file signature to determine type
    $signature = substr($fileContent, 0, 4);
    if (substr($fileContent, 0, 4) === '%PDF') {
        $contentType = 'application/pdf';
    } elseif (substr($fileContent, 0, 2) === "\xFF\xD8") {
        $contentType = 'image/jpeg';
    } elseif (substr($fileContent, 0, 8) === "\x89PNG\r\n\x1a\n") {
        $contentType = 'image/png';
    } elseif (substr($fileContent, 0, 6) === 'GIF87a' || substr($fileContent, 0, 6) === 'GIF89a') {
        $contentType = 'image/gif';
    }
    
    // Set headers for inline viewing
    header('Content-Type: ' . $contentType);
    header('Content-Disposition: inline; filename="' . $fileName . '"');
    header('Content-Length: ' . strlen($fileContent));
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    
    // Output the file content
    echo $fileContent;
}

function getAllStudents($pdo, $search = '', $filter = 'all') {
    $sql = "SELECT id, full_name, institution_type, class, created_at, is_new, mobile_number FROM student_register";
    $params = [];
    $conditions = [];
    
    // Add search condition
    if (!empty($search)) {
        $conditions[] = "(id LIKE ? OR full_name LIKE ? OR mobile_number LIKE ?)";
        $searchParam = "%$search%";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
    }
    
    // Add filter condition
    if ($filter !== 'all') {
        $conditions[] = "institution_type = ?";
        $params[] = $filter;
    }
    
    // Combine conditions
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function generateStudentPDF($pdo, $studentId, $mode = 'download') {
    $student = getStudent($pdo, $studentId);
    
    if (!$student) {
        http_response_code(404);
        die("Student not found");
    }
    
    if ($mode === 'download') {
        // Generate actual PDF content for download
        generatePDFContent($student);
    } else {
        // Generate HTML for print preview
        generateHTMLContent($student);
    }
}

function generatePDFContent($student) {
    $filename = 'Student_' . $student['id'] . '_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $student['full_name']) . '.html';
    
    // Generate HTML content optimized for PDF conversion
    $html = generatePDFOptimizedHTML($student);
    
    // Set headers for file download
    header('Content-Type: text/html; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . strlen($html));
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    
    echo $html;
}

function generateHTMLContent($student) {
    $html = generateStudentHTML($student);
    
    // Set headers for HTML display
    header('Content-Type: text/html; charset=UTF-8');
    
    // Update the title to include college name
    $html = str_replace(
        'Student Details - ' . htmlspecialchars($student['full_name']) . '</title>',
        'Student Details - ' . htmlspecialchars($student['full_name']) . ' | Bharat English School & Jr. College</title>',
        $html
    );
    
        // Update the header content to include institution type
    $html = str_replace(
        '<h1>Student Management System</h1>
            <h2>Student Registration Details</h2>',
        '<h1>Bharat English School & Jr. College</h1>
            <h2>Admission Form - ' . htmlspecialchars($student['institution_type']) . '</h2>',
        $html
    );

    // Update body margin and add punch hole spacing
    $html = str_replace(
        'margin: 20px;',
        'margin: 20px 20px 20px 80px;',
        $html
    );
    
    // Add auto-print functionality and updated print styles
    $html = str_replace('</head>', '
        <style media="print">
            body { margin: 10mm 10mm 10mm 25mm !important; }
            .header { page-break-after: avoid; }
            .section { page-break-inside: avoid; }
        </style>
        <script>
            window.onload = function() {
                if (window.location.search.includes("auto_print=1")) {
                    setTimeout(function() { window.print(); }, 1000);
                }
            }
        </script>
    </head>', $html);
    

    
    echo $html;
}

function getLogoBase64() {
    $logoPath = 'IMG-20250419-WA0006.jpg';
    if (file_exists($logoPath)) {
        $imageData = file_get_contents($logoPath);
        $base64 = base64_encode($imageData);
        $mimeType = 'image/jpeg';
        return "data:$mimeType;base64,$base64";
    }
    return '';
}

function generatePDFOptimizedHTML($student) {
    $logoDataUrl = getLogoBase64();
    $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Details - ' . htmlspecialchars($student['full_name']) . ' | Bharat English School & Jr. College</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px 20px 20px 80px; 
            color: #333; 
            line-height: 1.4;
        }
        .pdf-instructions {
            background: #e3f2fd;
            border: 2px solid #1976d2;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            margin-left: -60px;
        }
        .pdf-instructions h3 {
            color: #1976d2;
            margin: 0 0 10px 0;
        }
        @media print {
            .pdf-instructions { display: none; }
            body { margin: 10mm 10mm 10mm 25mm; }
            .content-wrapper { padding-left: 0; }
        }

        .header {
            display: flex;
            align-items: center;
            border-bottom: 3px solid #1976d2;
            padding-bottom: 20px;
            margin-bottom: 30px;
            gap: 20px;
            position: relative;
        }
        .header-logo {
            flex-shrink: 0;
            width: 80px;
            height: 80px;
        }
        .header-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .header-text {
            flex: 1;
            text-align: center;
        }
        .header h1 {
            color: #000000;
            font-weight: bold;
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .header h2 {
            color: #000000;
            font-weight: bold;
            margin: 0;
            font-size: 16px;
        }
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .content-wrapper {
            padding-left: 20px;
        }
        .section-title {
            background-color: #f5f5f5;
            padding: 10px;
            border-left: 4px solid #1976d2;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .detail-item {
            margin-bottom: 8px;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 150px;
        }
        .detail-value {
            color: #333;
        }
        .document-status {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 12px;
        }
        .available {
            background-color: #c8e6c9;
            color: #2e7d32;
        }
        .missing {
            background-color: #ffcdd2;
            color: #c62828;
        }

    </style>
    <script>
        function convertToPDF() {
            document.querySelector(".pdf-instructions").style.display = "none";
            window.print();
        }
        window.onload = function() {
            // Auto-focus for immediate PDF conversion
            setTimeout(function() {
                if (confirm("This file has been downloaded. Click OK to convert it to PDF, or Cancel to view the content first.")) {
                    convertToPDF();
                }
            }, 500);
        }
    </script>
</head>
<body>
    <div class="pdf-instructions">
        <h3>📄 PDF Conversion Instructions</h3>
        <p><strong>To save as PDF:</strong> Press <kbd>Ctrl+P</kbd> (or <kbd>Cmd+P</kbd> on Mac), then select "Save as PDF" as destination.</p>
        <button onclick="convertToPDF()" style="background: #1976d2; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Convert to PDF Now</button>
    </div>
    
    <div class="content-wrapper">
        <div class="header">
            ' . ($logoDataUrl ? '<div class="header-logo"><img src="' . $logoDataUrl . '" alt="College Logo" /></div>' : '') . '
            <div class="header-text">
                <h1>Bharat English School & Jr. College</h1>
                <h2>Admission Form - ' . htmlspecialchars($student['institution_type']) . '</h2>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Personal Information</div>';
    
    $personalInfo = [
        'Student ID' => $student['id'],
        'Full Name' => $student['full_name'],
        'Father\'s Name' => $student['father_name'],
        'Mother\'s Name' => $student['mother_name'],
        'Date of Birth' => date('d-m-Y', strtotime($student['dob'])),
        'Gender' => $student['gender'],
        'Caste' => $student['caste'],
        'Category' => $student['category'],
        'Aadhaar Number' => $student['aadhaar_number']
    ];
    
    foreach ($personalInfo as $label => $value) {
        $html .= '<div class="detail-item">
            <span class="detail-label">' . $label . ':</span>
            <span class="detail-value">' . htmlspecialchars($value) . '</span>
        </div>';
    }
    
    $html .= '
    </div>
    
    <div class="section">
        <div class="section-title">Contact Information</div>';
    
    $contactInfo = [
        'Mobile Number' => $student['mobile_number'],
        'Guardian Mobile' => $student['guardian_mobile_number'],
        'Email' => $student['email'],
        'Current Address' => $student['current_address'],
        'Permanent Address' => $student['permanent_address']
    ];
    
    foreach ($contactInfo as $label => $value) {
        $displayValue = (strpos($label, 'Address') !== false) ? nl2br(htmlspecialchars($value)) : htmlspecialchars($value);
        $html .= '<div class="detail-item">
            <span class="detail-label">' . $label . ':</span>
            <span class="detail-value">' . $displayValue . '</span>
        </div>';
    }
    
    $html .= '
    </div>
    
    <div class="section">
        <div class="section-title">Academic Information</div>';
    
    $academicInfo = [
        'Class' => $student['class'],
        'Program of Interest' => $student['program_interest'],
        'Institution Type' => $student['institution_type'],
        'School UDISE Number' => $student['school_udise_number'],
        '10th Marks' => $student['tenth_marks'],
        '10th Percentage' => $student['tenth_percentage'] . '%'
    ];
    
    foreach ($academicInfo as $label => $value) {
        $html .= '<div class="detail-item">
            <span class="detail-label">' . $label . ':</span>
            <span class="detail-value">' . htmlspecialchars($value) . '</span>
        </div>';
    }
    
    $html .= '
    </div>
    
    <div class="section">
        <div class="section-title">Document Status</div>';
    
    $documents = [
        'tenth_marksheet' => '10th Marksheet',
        'school_leaving_certificate' => 'School Leaving Certificate',
        'aadhaar_card' => 'Aadhaar Card',
        'passport_photo' => 'Passport Photo',
        'caste_certificate' => 'Caste Certificate',
        'non_creamy_layer_certificate' => 'Non-Creamy Layer Certificate',
        'ews_eligibility_certificate' => 'EWS Eligibility Certificate',
        'domicile_certificate' => 'Domicile Certificate'
    ];
    
    foreach ($documents as $docField => $docTitle) {
        $status = $student[$docField] ? 'Available ✓' : 'Not Uploaded ✗';
        $statusClass = $student[$docField] ? 'available' : 'missing';
        
        $html .= '<div class="detail-item">
            <span class="detail-label">' . $docTitle . ':</span>
            <span class="detail-value"><span class="document-status ' . $statusClass . '">' . $status . '</span></span>
        </div>';
    }
    
    $html .= '
    </div>
    
    <div class="section">
        <div class="section-title">System Information</div>
        <div class="detail-item">
            <span class="detail-label">Registration Date:</span>
            <span class="detail-value">' . date('d-m-Y H:i:s', strtotime($student['created_at'])) . '</span>
        </div>
    </div>
    
    </div>
</body>
</html>';
    
    return $html;
}

function htmlToText($student) {
    $documents = [
        'tenth_marksheet' => '10th Marksheet',
        'school_leaving_certificate' => 'School Leaving Certificate',
        'aadhaar_card' => 'Aadhaar Card',
        'passport_photo' => 'Passport Photo',
        'caste_certificate' => 'Caste Certificate',
        'non_creamy_layer_certificate' => 'Non-Creamy Layer Certificate',
        'ews_eligibility_certificate' => 'EWS Eligibility Certificate',
        'domicile_certificate' => 'Domicile Certificate'
    ];
    
    $text = "STUDENT MANAGEMENT SYSTEM\n";
    $text .= "Student Registration Details\n";
    $text .= str_repeat("=", 50) . "\n\n";
    
    $text .= "PERSONAL INFORMATION\n";
    $text .= str_repeat("-", 20) . "\n";
    $text .= "Student ID: " . $student['id'] . "\n";
    $text .= "Full Name: " . $student['full_name'] . "\n";
    $text .= "Father's Name: " . $student['father_name'] . "\n";
    $text .= "Mother's Name: " . $student['mother_name'] . "\n";
    $text .= "Date of Birth: " . date('d-m-Y', strtotime($student['dob'])) . "\n";
    $text .= "Gender: " . $student['gender'] . "\n";
    $text .= "Caste: " . $student['caste'] . "\n";
    $text .= "Category: " . $student['category'] . "\n";
    $text .= "Aadhaar Number: " . $student['aadhaar_number'] . "\n\n";
    
    $text .= "CONTACT INFORMATION\n";
    $text .= str_repeat("-", 20) . "\n";
    $text .= "Mobile Number: " . $student['mobile_number'] . "\n";
    $text .= "Guardian Mobile: " . $student['guardian_mobile_number'] . "\n";
    $text .= "Email: " . $student['email'] . "\n";
    $text .= "Current Address: " . $student['current_address'] . "\n";
    $text .= "Permanent Address: " . $student['permanent_address'] . "\n\n";
    
    $text .= "ACADEMIC INFORMATION\n";
    $text .= str_repeat("-", 20) . "\n";
    $text .= "Class: " . $student['class'] . "\n";
    $text .= "Program of Interest: " . $student['program_interest'] . "\n";
    $text .= "Institution Type: " . $student['institution_type'] . "\n";
    $text .= "School UDISE Number: " . $student['school_udise_number'] . "\n";
    $text .= "10th Marks: " . $student['tenth_marks'] . "\n";
    $text .= "10th Percentage: " . $student['tenth_percentage'] . "%\n\n";
    
    $text .= "DOCUMENT STATUS\n";
    $text .= str_repeat("-", 20) . "\n";
    foreach ($documents as $docField => $docTitle) {
        $status = $student[$docField] ? 'Available' : 'Not Uploaded';
        $text .= $docTitle . ": " . $status . "\n";
    }
    
    $text .= "\nSYSTEM INFORMATION\n";
    $text .= str_repeat("-", 20) . "\n";
    $text .= "Registration Date: " . date('d-m-Y H:i:s', strtotime($student['created_at'])) . "\n";
    $text .= "Generated on: " . date('d-m-Y H:i:s') . "\n";
    
    return $text;
}

function generateStudentHTML($student, $forPDF = false) {
    $logoDataUrl = getLogoBase64();
    $html = '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Student Details - ' . htmlspecialchars($student['full_name']) . ' | Bharat English School & Jr. College</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                color: #333;
                line-height: 1.6;
            }

            .header {
                display: flex;
                align-items: center;
                border-bottom: 3px solid #667eea;
                padding-bottom: 20px;
                margin-bottom: 30px;
                gap: 20px;
            }
            .header-logo {
                flex-shrink: 0;
                width: 80px;
                height: 80px;
            }
            .header-logo img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }
            .header-text {
                flex: 1;
                text-align: center;
            }
            .header h1 {
                color: #000000;
                font-weight: bold;
                margin-bottom: 5px;
                font-size: 28px;
            }
            .header h2 {
                color: #000000;
                font-weight: bold;
                margin: 0;
                font-size: 18px;
                font-weight: normal;
            }
            .section {
                margin-bottom: 25px;
                page-break-inside: avoid;
            }
            .section-title {
                background-color: #f8f9fa;
                padding: 12px 15px;
                border-left: 4px solid #667eea;
                font-weight: bold;
                font-size: 16px;
                margin-bottom: 15px;
                color: #555;
            }
            .details-grid {
                display: table;
                width: 100%;
                margin-bottom: 15px;
            }
            .detail-row {
                display: table-row;
                border-bottom: 1px solid #eee;
            }
            .detail-label {
                display: table-cell;
                padding: 8px 15px 8px 0;
                font-weight: bold;
                width: 35%;
                vertical-align: top;
                color: #555;
            }
            .detail-value {
                display: table-cell;
                padding: 8px 0;
                vertical-align: top;
            }
            .document-available {
                background-color: #d4edda;
                color: #155724;
                padding: 4px 8px;
                border-radius: 4px;
            }
            .document-missing {
                background-color: #f8d7da;
                color: #721c24;
                padding: 4px 8px;
                border-radius: 4px;
            }

        </style>
    </head>
    <body>
        <div class="header">
            ' . ($logoDataUrl ? '<div class="header-logo"><img src="' . $logoDataUrl . '" alt="College Logo" /></div>' : '') . '
            <div class="header-text">
                <h1>Bharat English School & Jr. College</h1>
                <h2>Admission Form - ' . htmlspecialchars($student['institution_type']) . '</h2>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Personal Information</div>
            <div class="details-grid">
                <div class="detail-row">
                    <div class="detail-label">Student ID:</div>
                    <div class="detail-value">' . $student['id'] . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Full Name:</div>
                    <div class="detail-value">' . htmlspecialchars($student['full_name']) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Father\'s Name:</div>
                    <div class="detail-value">' . htmlspecialchars($student['father_name']) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Mother\'s Name:</div>
                    <div class="detail-value">' . htmlspecialchars($student['mother_name']) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Date of Birth:</div>
                    <div class="detail-value">' . date('d-m-Y', strtotime($student['dob'])) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Gender:</div>
                    <div class="detail-value">' . htmlspecialchars($student['gender']) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Caste:</div>
                    <div class="detail-value">' . htmlspecialchars($student['caste']) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Category:</div>
                    <div class="detail-value">' . htmlspecialchars($student['category']) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Aadhaar Number:</div>
                    <div class="detail-value">' . htmlspecialchars($student['aadhaar_number']) . '</div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Contact Information</div>
            <div class="details-grid">
                <div class="detail-row">
                    <div class="detail-label">Mobile Number:</div>
                    <div class="detail-value">' . htmlspecialchars($student['mobile_number']) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Guardian Mobile:</div>
                    <div class="detail-value">' . htmlspecialchars($student['guardian_mobile_number']) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Email:</div>
                    <div class="detail-value">' . htmlspecialchars($student['email']) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Current Address:</div>
                    <div class="detail-value">' . nl2br(htmlspecialchars($student['current_address'])) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Permanent Address:</div>
                    <div class="detail-value">' . nl2br(htmlspecialchars($student['permanent_address'])) . '</div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Academic Information</div>
            <div class="details-grid">
                <div class="detail-row">
                    <div class="detail-label">Class:</div>
                    <div class="detail-value">' . htmlspecialchars($student['class']) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Program of Interest:</div>
                    <div class="detail-value">' . htmlspecialchars($student['program_interest']) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Institution Type:</div>
                    <div class="detail-value">' . htmlspecialchars($student['institution_type']) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">School UDISE Number:</div>
                    <div class="detail-value">' . htmlspecialchars($student['school_udise_number']) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">10th Marks:</div>
                    <div class="detail-value">' . htmlspecialchars($student['tenth_marks']) . '</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">10th Percentage:</div>
                    <div class="detail-value">' . htmlspecialchars($student['tenth_percentage']) . '%</div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Document Status</div>
            <div class="details-grid">';
    
    $documents = [
        'tenth_marksheet' => '10th Marksheet',
        'school_leaving_certificate' => 'School Leaving Certificate',
        'aadhaar_card' => 'Aadhaar Card',
        'passport_photo' => 'Passport Photo',
        'caste_certificate' => 'Caste Certificate',
        'non_creamy_layer_certificate' => 'Non-Creamy Layer Certificate',
        'ews_eligibility_certificate' => 'EWS Eligibility Certificate',
        'domicile_certificate' => 'Domicile Certificate'
    ];
    
    foreach ($documents as $docField => $docTitle) {
        $status = $student[$docField] ? 'Available ✓' : 'Not Uploaded ✗';
        $class = $student[$docField] ? 'document-available' : 'document-missing';
        
        $html .= '
                <div class="detail-row">
                    <div class="detail-label">' . $docTitle . ':</div>
                    <div class="detail-value"><span class="' . $class . '">' . $status . '</span></div>
                </div>';
    }
    
    $html .= '
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">System Information</div>
            <div class="details-grid">
                <div class="detail-row">
                    <div class="detail-label">Registration Date:</div>
                    <div class="detail-value">' . date('d-m-Y H:i:s', strtotime($student['created_at'])) . '</div>
                </div>
            </div>
        </div>
        
    </body>
    </html>';
    
    return $html;
}

function generateExcelReport($pdo, $classFilter = '', $institutionFilter = '') {
    // Build SQL query with filters
    $sql = "SELECT * FROM student_register";
    $params = [];
    $conditions = [];
    
    // Add class filter
    if (!empty($classFilter)) {
        $conditions[] = "class = ?";
        $params[] = $classFilter;
    }
    
    // Add institution type filter
    if (!empty($institutionFilter)) {
        $conditions[] = "institution_type = ?";
        $params[] = $institutionFilter;
    }
    
    // Combine conditions
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    // Get filtered students
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Generate filename with current date and filters
    $filenameParts = ['Students_Report'];
    if (!empty($classFilter)) {
        $filenameParts[] = 'Class_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $classFilter);
    }
    if (!empty($institutionFilter)) {
        $filenameParts[] = $institutionFilter;
    }
    $filenameParts[] = date('Y-m-d_H-i-s');
    $filename = implode('_', $filenameParts) . '.csv';
    
    // Clear any previous output
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    // Set headers for CSV download
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');
    
    // Create output stream
    $output = fopen('php://output', 'w');
    
    // Add BOM for UTF-8 Excel compatibility
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Add header row
    $headers = [
        'Student ID',
        'Full Name',
        'Father\'s Name',
        'Mother\'s Name',
        'Date of Birth',
        'Gender',
        'Mobile Number',
        'Guardian Mobile',
        'Email',
        'Current Address',
        'Permanent Address',
        'Class',
        'Program of Interest',
        'Institution Type',
        'Caste',
        'Category',
        'School UDISE Number',
        'Aadhaar Number',
        '10th Marks',
        '10th Percentage',
        '10th Marksheet Status',
        'School Leaving Certificate Status',
        'Aadhaar Card Status',
        'Passport Photo Status',
        'Caste Certificate Status',
        'Non-Creamy Layer Certificate Status',
        'EWS Eligibility Certificate Status',
        'Domicile Certificate Status',
        'Is New Student',
        'Registration Date'
    ];
    
    fputcsv($output, $headers);
    
    // Add data rows
    if (!empty($students)) {
        foreach ($students as $student) {
            $row = [
                $student['id'] ?? '',
                $student['full_name'] ?? '',
                $student['father_name'] ?? '',
                $student['mother_name'] ?? '',
                !empty($student['dob']) ? date('d-m-Y', strtotime($student['dob'])) : '',
                $student['gender'] ?? '',
                $student['mobile_number'] ?? '',
                $student['guardian_mobile_number'] ?? '',
                $student['email'] ?? '',
                $student['current_address'] ?? '',
                $student['permanent_address'] ?? '',
                $student['class'] ?? '',
                $student['program_interest'] ?? '',
                $student['institution_type'] ?? '',
                $student['caste'] ?? '',
                $student['category'] ?? '',
                $student['school_udise_number'] ?? '',
                $student['aadhaar_number'] ?? '',
                $student['tenth_marks'] ?? '',
                !empty($student['tenth_percentage']) ? $student['tenth_percentage'] . '%' : '',
                !empty($student['tenth_marksheet']) ? 'Available' : 'Not Uploaded',
                !empty($student['school_leaving_certificate']) ? 'Available' : 'Not Uploaded',
                !empty($student['aadhaar_card']) ? 'Available' : 'Not Uploaded',
                !empty($student['passport_photo']) ? 'Available' : 'Not Uploaded',
                !empty($student['caste_certificate']) ? 'Available' : 'Not Uploaded',
                !empty($student['non_creamy_layer_certificate']) ? 'Available' : 'Not Uploaded',
                !empty($student['ews_eligibility_certificate']) ? 'Available' : 'Not Uploaded',
                !empty($student['domicile_certificate']) ? 'Available' : 'Not Uploaded',
                !empty($student['is_new']) ? 'Yes' : 'No',
                !empty($student['created_at']) ? date('d-m-Y H:i:s', strtotime($student['created_at'])) : ''
            ];
            
            fputcsv($output, $row);
        }
    } else {
        // If no students found, add a row indicating this
        fputcsv($output, ['No students found in the database.']);
    }
    
    fclose($output);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Admission Registration System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/admin-theme.css">
    <style>
        .nav-header {
            background: #ffffff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 2rem;
        }
        
        .nav-header h1 {
            color: #2c3e50;
            margin: 0;
            border-bottom: none;
            font-size: 1.8rem;
        }
        
        .nav-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .nav-links a {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .nav-links a:hover {
            background: #f8f9fa;
            color: #2980b9;
        }
        
        .nav {
            display: flex !important;
            gap: 15px;
            margin-bottom: 30px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            z-index: 999 !important;
        }
        
        .nav a {
            background: #fff;
            color: #3498db;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            border: 2px solid #3498db;
            transition: all 0.3s ease;
            font-weight: 600;
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .nav a:hover, .nav a.active {
            background: #3498db;
            color: white;
        }
        
        .btn-excel-report {
            background: #2ecc71 !important;
            color: white !important;
            border: 2px solid #2ecc71 !important;
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            z-index: 1000 !important;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s ease;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn-excel-report:hover {
            background: #27ae60 !important;
            color: white !important;
            border: 2px solid #27ae60 !important;
            transform: translateY(-2px);
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #555;
        }
        
        .form-group label:after {
            content: "";
        }
        
        .form-group label[for="full_name"]:after,
        .form-group label[for="father_name"]:after,
        .form-group label[for="mother_name"]:after,
        .form-group label[for="dob"]:after,
        .form-group label[for="gender"]:after,
        .form-group label[for="mobile_number"]:after,
        .form-group label[for="guardian_mobile_number"]:after,
        .form-group label[for="email"]:after,
        .form-group label[for="current_address"]:after,
        .form-group label[for="permanent_address"]:after,
        .form-group label[for="class"]:after,
        .form-group label[for="program_interest"]:after,
        .form-group label[for="institution_type"]:after {
            content: " *";
            color: #e53e3e;
            font-weight: bold;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e1e1;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .btn {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn:hover {
            background: #5a67d8;
            transform: translateY(-2px);
        }
        
        .btn-danger {
            background: #e53e3e;
        }
        
        .btn-danger:hover {
            background: #c53030;
        }
        
        .btn-success {
            background: #38a169;
        }
        
        .btn-success:hover {
            background: #2f855a;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .table th,
        .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e1e1e1;
        }
        
        .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #555;
        }
        
        .table tr:hover {
            background: #f8f9fa;
        }
        
        .actions {
            display: flex;
            gap: 10px;
        }
        
        .message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        
        .section-title {
            background: #f8f9fa;
            padding: 15px 20px;
            margin: 30px -30px 20px -30px;
            border-left: 4px solid #667eea;
            font-weight: 600;
            color: #555;
        }
        
        .new-tag {
            background: #ff4757;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            margin-left: 8px;
            display: inline-block;
            animation: pulse 2s infinite;
        }
        
        .search-filter-bar {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .search-form {
            display: flex;
            gap: 15px;
            align-items: end;
            flex-wrap: wrap;
        }
        
        .search-group {
            flex: 1;
            min-width: 200px;
        }
        
        .search-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }
        
        .search-group input,
        .search-group select {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 25px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        
        .search-group input:focus,
        .search-group select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .search-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-search {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-search:hover {
            background: #5a67d8;
        }
        
        .btn-clear {
            background: #e2e8f0;
            color: #4a5568;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-clear:hover {
            background: #cbd5e0;
        }
        
        .search-results {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .document-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .document-item {
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .document-item:hover {
            border-color: #667eea;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .document-item.has-document {
            border-color: #38a169;
            background: #f0fff4;
        }
        
        .document-item.no-document {
            border-color: #e53e3e;
            background: #fdf2f2;
        }
        
        .document-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }
        
        .document-action {
            margin-top: 10px;
        }
        
        .btn-download {
            background: #38a169;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 2px;
        }
        
        .btn-download:hover {
            background: #2f855a;
            color: white;
        }
        
        .btn-view {
            background: #667eea;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 2px;
        }
        
        .btn-view:hover {
            background: #5a67d8;
            color: white;
        }
        
        .btn-pdf {
            background: #dc3545;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }
        
        .btn-pdf:hover {
            background: #c82333;
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-print {
            background: #28a745;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }
        
        .btn-print:hover {
            background: #218838;
            color: white;
            transform: translateY(-2px);
        }
        
        .document-buttons {
            display: flex;
            gap: 5px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .document-status {
            color: #666;
            font-size: 12px;
            font-style: italic;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
        
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .nav {
                flex-direction: column;
                align-items: center;
            }
            
            .table {
                font-size: 12px;
            }
            
            .container {
                padding: 10px;
            }
            
            .search-form {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-group {
                min-width: auto;
            }
            
            .search-buttons {
                justify-content: center;
                margin-top: 10px;
            }
            
            .document-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
        
        .excel-report-dropdown {
            position: relative;
            display: inline-block;
        }
        
        .report-dropdown-content {
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            min-width: 320px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1000;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #e1e1e1;
            margin-top: 5px;
        }
        
        .report-dropdown-content form {
            margin: 0;
        }
        
        .report-dropdown-content label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
            font-size: 14px;
        }
        
        .report-dropdown-content select {
            width: 100%;
            padding: 10px;
            border: 2px solid #e1e1e1;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        
        .report-dropdown-content select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .report-filter-group {
            margin-bottom: 15px;
        }
        
        .report-generate-btn {
            background: #10b981;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .report-generate-btn:hover {
            background: #059669;
            transform: translateY(-1px);
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
    </style>
    <script>
        // Ensure navigation and download button are properly displayed on page load
        function ensureButtonVisibility() {
            const nav = document.querySelector('.nav');
            const downloadButton = document.querySelector('.btn-excel-report');
            
            if (nav) {
                nav.style.display = 'flex';
                nav.style.visibility = 'visible';
                nav.style.opacity = '1';
            }
            
            if (downloadButton) {
                downloadButton.style.display = 'inline-block';
                downloadButton.style.visibility = 'visible';
                downloadButton.style.opacity = '1';
                downloadButton.style.position = 'relative';
                downloadButton.style.zIndex = '1000';
            }
        }
        
        // Toggle report dropdown
        function toggleReportDropdown() {
            const dropdown = document.getElementById('reportDropdown');
            if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                dropdown.style.display = 'block';
            } else {
                dropdown.style.display = 'none';
            }
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('reportDropdown');
            const button = event.target.closest('.btn-excel-report');
            
            if (!button && !dropdown.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });
        
        // Run immediately and also on DOMContentLoaded
        ensureButtonVisibility();
        document.addEventListener('DOMContentLoaded', ensureButtonVisibility);
        
        // Also run after a short delay to catch any late-loading styles
        setTimeout(ensureButtonVisibility, 100);
        setTimeout(ensureButtonVisibility, 500);
    </script>
</head>
<body>
    <div class="nav-header">
        <h1><i class="fas fa-users"></i> New Admission Registration</h1>
        <div class="nav-links">
            <a href="../index.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="../12thadm/index.php"><i class="fas fa-user-shield"></i> 12th Admission Management</a>
            <a href="../recipt/index.php"><i class="fas fa-receipt"></i> New Payment Receipt Generator</a>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h1>New Admission Registration System</h1>
            <p>Manage BESJC Student Admissions</p>
        </div>

        <div class="nav" style="display: flex !important; visibility: visible !important; opacity: 1 !important;">
            <a href="index.php" class="<?= $action === 'list' ? 'active' : '' ?>">View All Students</a>
            <a href="index.php?action=add" class="<?= $action === 'add' ? 'active' : '' ?>">Add New Student</a>
            <div class="excel-report-dropdown">
                <button type="button" class="btn-excel-report" onclick="toggleReportDropdown()" style="display: inline-block !important; visibility: visible !important; opacity: 1 !important;" title="Download student report with filters">📊 Download Excel Report ▼</button>
                <div id="reportDropdown" class="report-dropdown-content" style="display: none;">
                    <form method="GET">
                        <input type="hidden" name="generate_excel_report" value="1">
                        <div class="report-filter-group">
                            <label for="class_filter">Filter by Class:</label>
                            <select name="class_filter" id="class_filter">
                                <option value="">All Classes</option>
                                <?php
                                // Standard classes that should always be available
                                $standardClasses = ['11th', '12th'];
                                
                                // Get unique classes from database
                                $classStmt = $pdo->query("SELECT DISTINCT class FROM student_register WHERE class != '' ORDER BY class");
                                $dbClasses = $classStmt->fetchAll(PDO::FETCH_COLUMN);
                                
                                // Combine standard classes with database classes, removing duplicates
                                $allClasses = array_unique(array_merge($standardClasses, $dbClasses));
                                
                                // Sort classes naturally (11th, 12th first, then others)
                                usort($allClasses, function($a, $b) {
                                    if ($a === '11th') return -1;
                                    if ($b === '11th') return 1;
                                    if ($a === '12th') return -1;
                                    if ($b === '12th') return 1;
                                    return strcmp($a, $b);
                                });
                                
                                foreach ($allClasses as $class) {
                                    echo '<option value="' . htmlspecialchars($class) . '">' . htmlspecialchars($class) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="report-filter-group">
                            <label for="institution_filter">Filter by Institution Type:</label>
                            <select name="institution_filter" id="institution_filter">
                                <option value="">All Types</option>
                                <option value="Aided">Aided</option>
                                <option value="Unaided">Unaided</option>
                            </select>
                        </div>
                        <div style="text-align: center;">
                            <button type="submit" class="report-generate-btn">Generate Report</button>
                        </div>
                        <hr style="margin: 15px 0; border: none; border-top: 1px solid #eee;">
                        <div style="text-align: center;">
                            <a href="index.php?generate_excel_report=1" class="btn" style="background: #667eea; color: white; text-decoration: none; padding: 8px 16px; border-radius: 20px; font-size: 12px; display: inline-block;">📄 Quick Download All Students</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['message'])): ?>
            <div class="message">
                <?= htmlspecialchars($_GET['message']) ?>
            </div>
        <?php endif; ?>

        <?php if ($action === 'list'): ?>
            <!-- Search and Filter Bar -->
            <div class="search-filter-bar">
                <form method="GET" class="search-form">
                    <input type="hidden" name="action" value="list">
                    <div class="search-group">
                        <label for="search">Search by ID, Name, or Mobile</label>
                        <input type="text" name="search" id="search" placeholder="Enter ID, name, or mobile number..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    </div>
                    <div class="search-group">
                        <label for="filter">Filter by Institution Type</label>
                        <select name="filter" id="filter">
                            <option value="all" <?= ($_GET['filter'] ?? 'all') === 'all' ? 'selected' : '' ?>>All</option>
                            <option value="Aided" <?= ($_GET['filter'] ?? '') === 'Aided' ? 'selected' : '' ?>>Aided</option>
                            <option value="Unaided" <?= ($_GET['filter'] ?? '') === 'Unaided' ? 'selected' : '' ?>>Unaided</option>
                        </select>
                    </div>
                    <div class="search-buttons">
                        <button type="submit" class="btn-search">Search</button>
                        <a href="index.php?action=list" class="btn-clear">Clear</a>
                    </div>
                </form>
            </div>

            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>All Students</h2>
                    <div style="text-align: right;">
                        <div style="color: #666; font-size: 14px;">
                            Total Registered Students: <?php
                                $totalStmt = $pdo->query("SELECT COUNT(*) FROM student_register");
                                echo $totalStmt->fetchColumn();
                            ?>
                        </div>
                    </div>
                </div>
                <?php 
                $search = $_GET['search'] ?? '';
                $filter = $_GET['filter'] ?? 'all';
                $students = getAllStudents($pdo, $search, $filter);
                ?>
                
                <?php if (!empty($search) || $filter !== 'all'): ?>
                    <div class="search-results">
                        <?php 
                        $resultCount = count($students);
                        $searchText = !empty($search) ? "for \"" . htmlspecialchars($search) . "\"" : "";
                        $filterText = $filter !== 'all' ? "in " . htmlspecialchars($filter) . " institutions" : "";
                        $separator = (!empty($search) && $filter !== 'all') ? " " : "";
                        echo "Found {$resultCount} student(s) {$searchText}{$separator}{$filterText}";
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if (empty($students)): ?>
                    <p>No students found. <a href="index.php?action=add">Add the first student</a></p>
                <?php else: ?>
                                         <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Institution Type</th>
                                <th>Class</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                                                         <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?= $student['id'] ?></td>
                                    <td>
                                        <?= htmlspecialchars($student['full_name']) ?>
                                        <?php if ($student['is_new']): ?>
                                            <span class="new-tag">New</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($student['institution_type']) ?></td>
                                    <td><?= htmlspecialchars($student['class']) ?></td>
                                    <td><?= date('Y-m-d H:i', strtotime($student['created_at'])) ?></td>
                                    <td class="actions">
                                        <a href="index.php?action=view&id=<?= $student['id'] ?>" class="btn">View</a>
                                        <a href="index.php?action=edit&id=<?= $student['id'] ?>" class="btn btn-success">Edit</a>
                                        <form method="post" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= $student['id'] ?>">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

        <?php elseif ($action === 'add'): ?>
            <div class="card">
                <h2>Add New Student</h2>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="section-title">Personal Information</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" name="full_name" id="full_name" required>
                        </div>
                        <div class="form-group">
                            <label for="father_name">Father's Name</label>
                            <input type="text" name="father_name" id="father_name" required>
                        </div>
                        <div class="form-group">
                            <label for="mother_name">Mother's Name</label>
                            <input type="text" name="mother_name" id="mother_name" required>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" name="dob" id="dob" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="caste">Caste</label>
                            <input type="text" name="caste" id="caste">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" name="category" id="category">
                        </div>
                        <div class="form-group">
                            <label for="aadhaar_number">Aadhaar Number</label>
                            <input type="text" name="aadhaar_number" id="aadhaar_number" maxlength="12">
                        </div>
                    </div>

                    <div class="section-title">Contact Information</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="mobile_number">Mobile Number</label>
                            <input type="tel" name="mobile_number" id="mobile_number" required>
                        </div>
                        <div class="form-group">
                            <label for="guardian_mobile_number">Guardian Mobile Number</label>
                            <input type="tel" name="guardian_mobile_number" id="guardian_mobile_number" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="current_address">Current Address</label>
                            <textarea name="current_address" id="current_address" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="permanent_address">Permanent Address</label>
                            <textarea name="permanent_address" id="permanent_address" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="section-title">Academic Information</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="class">Class</label>
                            <input type="text" name="class" id="class" required>
                        </div>
                        <div class="form-group">
                            <label for="program_interest">Program of Interest</label>
                            <input type="text" name="program_interest" id="program_interest" required>
                        </div>
                        <div class="form-group">
                            <label for="institution_type">Institution Type</label>
                            <select name="institution_type" id="institution_type" required>
                                <option value="">Select Type</option>
                                <option value="Aided">Aided</option>
                                <option value="Unaided">Unaided</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="school_udise_number">School UDISE Number</label>
                            <input type="text" name="school_udise_number" id="school_udise_number">
                        </div>
                        <div class="form-group">
                            <label for="tenth_marks">10th Marks</label>
                            <input type="number" name="tenth_marks" id="tenth_marks">
                        </div>
                        <div class="form-group">
                            <label for="tenth_percentage">10th Percentage</label>
                            <input type="number" name="tenth_percentage" id="tenth_percentage" step="0.01" max="100">
                        </div>
                    </div>

                    <div class="section-title">Document Uploads</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="tenth_marksheet">10th Marksheet</label>
                            <input type="file" name="tenth_marksheet" id="tenth_marksheet" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="form-group">
                            <label for="school_leaving_certificate">School Leaving Certificate</label>
                            <input type="file" name="school_leaving_certificate" id="school_leaving_certificate" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="form-group">
                            <label for="aadhaar_card">Aadhaar Card</label>
                            <input type="file" name="aadhaar_card" id="aadhaar_card" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="form-group">
                            <label for="passport_photo">Passport Photo</label>
                            <input type="file" name="passport_photo" id="passport_photo" accept=".jpg,.jpeg,.png">
                        </div>
                        <div class="form-group">
                            <label for="caste_certificate">Caste Certificate</label>
                            <input type="file" name="caste_certificate" id="caste_certificate" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="form-group">
                            <label for="non_creamy_layer_certificate">Non-Creamy Layer Certificate</label>
                            <input type="file" name="non_creamy_layer_certificate" id="non_creamy_layer_certificate" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="form-group">
                            <label for="ews_eligibility_certificate">EWS Eligibility Certificate</label>
                            <input type="file" name="ews_eligibility_certificate" id="ews_eligibility_certificate" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="form-group">
                            <label for="domicile_certificate">Domicile Certificate</label>
                            <input type="file" name="domicile_certificate" id="domicile_certificate" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>

                    <div style="text-align: center; margin-top: 30px;">
                        <button type="submit" class="btn btn-success">Add Student</button>
                        <a href="index.php" class="btn">Cancel</a>
                    </div>
                </form>
            </div>

        <?php elseif ($action === 'edit' && $id): ?>
            <?php $student = getStudent($pdo, $id); ?>
            <?php if (!$student): ?>
                <div class="card">
                    <p>Student not found. <a href="index.php">Go back to list</a></p>
                </div>
            <?php else: ?>
                <div class="card">
                    <h2>Edit Student: <?= htmlspecialchars($student['full_name']) ?></h2>
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?= $student['id'] ?>">
                        
                        <div class="section-title">Personal Information</div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="full_name">Full Name</label>
                                <input type="text" name="full_name" id="full_name" value="<?= htmlspecialchars($student['full_name']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="father_name">Father's Name</label>
                                <input type="text" name="father_name" id="father_name" value="<?= htmlspecialchars($student['father_name']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="mother_name">Mother's Name</label>
                                <input type="text" name="mother_name" id="mother_name" value="<?= htmlspecialchars($student['mother_name']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" name="dob" id="dob" value="<?= $student['dob'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?= $student['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= $student['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                                    <option value="Other" <?= $student['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="caste">Caste</label>
                                <input type="text" name="caste" id="caste" value="<?= htmlspecialchars($student['caste']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <input type="text" name="category" id="category" value="<?= htmlspecialchars($student['category']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="aadhaar_number">Aadhaar Number</label>
                                <input type="text" name="aadhaar_number" id="aadhaar_number" value="<?= htmlspecialchars($student['aadhaar_number']) ?>" maxlength="12">
                            </div>
                        </div>

                        <div class="section-title">Contact Information</div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="mobile_number">Mobile Number</label>
                                <input type="tel" name="mobile_number" id="mobile_number" value="<?= htmlspecialchars($student['mobile_number']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="guardian_mobile_number">Guardian Mobile Number</label>
                                <input type="tel" name="guardian_mobile_number" id="guardian_mobile_number" value="<?= htmlspecialchars($student['guardian_mobile_number']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="<?= htmlspecialchars($student['email']) ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="current_address">Current Address</label>
                                <textarea name="current_address" id="current_address" rows="3" required><?= htmlspecialchars($student['current_address']) ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="permanent_address">Permanent Address</label>
                                <textarea name="permanent_address" id="permanent_address" rows="3" required><?= htmlspecialchars($student['permanent_address']) ?></textarea>
                            </div>
                        </div>

                        <div class="section-title">Academic Information</div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="class">Class</label>
                                <input type="text" name="class" id="class" value="<?= htmlspecialchars($student['class']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="program_interest">Program of Interest</label>
                                <input type="text" name="program_interest" id="program_interest" value="<?= htmlspecialchars($student['program_interest']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="institution_type">Institution Type</label>
                                <select name="institution_type" id="institution_type" required>
                                    <option value="">Select Type</option>
                                    <option value="Aided" <?= $student['institution_type'] === 'Aided' ? 'selected' : '' ?>>Aided</option>
                                    <option value="Unaided" <?= $student['institution_type'] === 'Unaided' ? 'selected' : '' ?>>Unaided</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="school_udise_number">School UDISE Number</label>
                                <input type="text" name="school_udise_number" id="school_udise_number" value="<?= htmlspecialchars($student['school_udise_number']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="tenth_marks">10th Marks</label>
                                <input type="number" name="tenth_marks" id="tenth_marks" value="<?= $student['tenth_marks'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="tenth_percentage">10th Percentage</label>
                                <input type="number" name="tenth_percentage" id="tenth_percentage" value="<?= $student['tenth_percentage'] ?>" step="0.01" max="100">
                            </div>
                        </div>

                        <div class="section-title">Document Uploads (Upload new files to replace existing ones)</div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="tenth_marksheet">10th Marksheet</label>
                                <input type="file" name="tenth_marksheet" id="tenth_marksheet" accept=".pdf,.jpg,.jpeg,.png">
                                <?php if ($student['tenth_marksheet']): ?>
                                    <small>Current file exists</small>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="school_leaving_certificate">School Leaving Certificate</label>
                                <input type="file" name="school_leaving_certificate" id="school_leaving_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                <?php if ($student['school_leaving_certificate']): ?>
                                    <small>Current file exists</small>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="aadhaar_card">Aadhaar Card</label>
                                <input type="file" name="aadhaar_card" id="aadhaar_card" accept=".pdf,.jpg,.jpeg,.png">
                                <?php if ($student['aadhaar_card']): ?>
                                    <small>Current file exists</small>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="passport_photo">Passport Photo</label>
                                <input type="file" name="passport_photo" id="passport_photo" accept=".jpg,.jpeg,.png">
                                <?php if ($student['passport_photo']): ?>
                                    <small>Current file exists</small>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="caste_certificate">Caste Certificate</label>
                                <input type="file" name="caste_certificate" id="caste_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                <?php if ($student['caste_certificate']): ?>
                                    <small>Current file exists</small>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="non_creamy_layer_certificate">Non-Creamy Layer Certificate</label>
                                <input type="file" name="non_creamy_layer_certificate" id="non_creamy_layer_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                <?php if ($student['non_creamy_layer_certificate']): ?>
                                    <small>Current file exists</small>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="ews_eligibility_certificate">EWS Eligibility Certificate</label>
                                <input type="file" name="ews_eligibility_certificate" id="ews_eligibility_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                <?php if ($student['ews_eligibility_certificate']): ?>
                                    <small>Current file exists</small>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="domicile_certificate">Domicile Certificate</label>
                                <input type="file" name="domicile_certificate" id="domicile_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                <?php if ($student['domicile_certificate']): ?>
                                    <small>Current file exists</small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div style="text-align: center; margin-top: 30px;">
                            <button type="submit" class="btn btn-success">Update Student</button>
                            <a href="index.php" class="btn">Cancel</a>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

        <?php elseif ($action === 'view' && $id): ?>
            <?php $student = getStudent($pdo, $id); ?>
            <?php if (!$student): ?>
                <div class="card">
                    <p>Student not found. <a href="index.php">Go back to list</a></p>
                </div>
            <?php else: ?>
                <?php 
                // Mark student as viewed (remove the "new" status)
                if ($student['is_new']) {
                    markAsViewed($pdo, $id);
                }
                ?>
                <div class="card">
                    <h2>Student Details: <?= htmlspecialchars($student['full_name']) ?></h2>
                    
                    <div class="section-title">Personal Information</div>
                    <div class="form-row">
                        <div><strong>Full Name:</strong> <?= htmlspecialchars($student['full_name']) ?></div>
                        <div><strong>Father's Name:</strong> <?= htmlspecialchars($student['father_name']) ?></div>
                        <div><strong>Mother's Name:</strong> <?= htmlspecialchars($student['mother_name']) ?></div>
                        <div><strong>Date of Birth:</strong> <?= $student['dob'] ?></div>
                        <div><strong>Gender:</strong> <?= $student['gender'] ?></div>
                        <div><strong>Caste:</strong> <?= htmlspecialchars($student['caste']) ?></div>
                        <div><strong>Category:</strong> <?= htmlspecialchars($student['category']) ?></div>
                        <div><strong>Aadhaar Number:</strong> <?= htmlspecialchars($student['aadhaar_number']) ?></div>
                    </div>

                    <div class="section-title">Contact Information</div>
                    <div class="form-row">
                        <div><strong>Mobile Number:</strong> <?= htmlspecialchars($student['mobile_number']) ?></div>
                        <div><strong>Guardian Mobile:</strong> <?= htmlspecialchars($student['guardian_mobile_number']) ?></div>
                        <div><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></div>
                    </div>
                    <div class="form-row">
                        <div><strong>Current Address:</strong> <?= nl2br(htmlspecialchars($student['current_address'])) ?></div>
                        <div><strong>Permanent Address:</strong> <?= nl2br(htmlspecialchars($student['permanent_address'])) ?></div>
                    </div>

                    <div class="section-title">Academic Information</div>
                    <div class="form-row">
                        <div><strong>Class:</strong> <?= htmlspecialchars($student['class']) ?></div>
                        <div><strong>Program Interest:</strong> <?= htmlspecialchars($student['program_interest']) ?></div>
                        <div><strong>Institution Type:</strong> <?= $student['institution_type'] ?></div>
                        <div><strong>School UDISE Number:</strong> <?= htmlspecialchars($student['school_udise_number']) ?></div>
                        <div><strong>10th Marks:</strong> <?= $student['tenth_marks'] ?></div>
                        <div><strong>10th Percentage:</strong> <?= $student['tenth_percentage'] ?>%</div>
                    </div>

                    <div class="section-title">Uploaded Documents</div>
                    <div class="document-grid">
                        <?php 
                        $documents = [
                            'tenth_marksheet' => '10th Marksheet',
                            'school_leaving_certificate' => 'School Leaving Certificate',
                            'aadhaar_card' => 'Aadhaar Card',
                            'passport_photo' => 'Passport Photo',
                            'caste_certificate' => 'Caste Certificate',
                            'non_creamy_layer_certificate' => 'Non-Creamy Layer Certificate',
                            'ews_eligibility_certificate' => 'EWS Eligibility Certificate',
                            'domicile_certificate' => 'Domicile Certificate'
                        ];
                        
                        foreach ($documents as $docField => $docTitle): ?>
                            <div class="document-item <?= $student[$docField] ? 'has-document' : 'no-document' ?>">
                                <div class="document-title"><?= $docTitle ?></div>
                                <?php if ($student[$docField]): ?>
                                    <div class="document-status">✅ Document Available</div>
                                    <div class="document-action">
                                        <div class="document-buttons">
                                            <a href="index.php?view=1&student_id=<?= $student['id'] ?>&doc_type=<?= $docField ?>" 
                                               class="btn-view" target="_blank">
                                                👁️ View
                                            </a>
                                            <a href="index.php?download=1&student_id=<?= $student['id'] ?>&doc_type=<?= $docField ?>" 
                                               class="btn-download">
                                                📄 Download
                                            </a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="document-status">❌ Not Uploaded</div>
                                    <div class="document-action">
                                        <span style="color: #999; font-size: 12px;">No document available</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="section-title">System Information</div>
                    <div class="form-row">
                        <div><strong>Is New Student:</strong> <?= $student['is_new'] ? 'Yes' : 'No' ?></div>
                        <div><strong>Created At:</strong> <?= date('Y-m-d H:i:s', strtotime($student['created_at'])) ?></div>
                    </div>

                    <div style="text-align: center; margin-top: 30px;">
                        <a href="index.php?action=edit&id=<?= $student['id'] ?>" class="btn btn-success">Edit Student</a>
                        <a href="index.php?generate_pdf=1&student_id=<?= $student['id'] ?>&mode=download" class="btn-pdf" title="Download as PDF">📄 Download PDF</a>
                        <a href="index.php?generate_pdf=1&student_id=<?= $student['id'] ?>&mode=print&auto_print=1" class="btn-print" target="_blank" title="Open in new tab and print">🖨️ Print PDF</a>
                        <a href="index.php" class="btn">Back to List</a>
                    </div>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</body>
</html>
