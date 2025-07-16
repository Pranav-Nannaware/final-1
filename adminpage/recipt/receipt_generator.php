<?php
// Database connection
$servername = "localhost";
$username = "cmrit_user";
$password = "test";
$dbname = "cmrit_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fee structures
$fees_aided = array(
    "HSC EXAM FEES" => 1000,
    "TUITION FEES" => 340,
    "STATIONARY FEES" => 3000,
    "C.S FEES (only Applicable for CS Students)" => 19800,
    "I.T FEES (only Applicable for IT Students)" => 7000,
    "PTA FEES" => 200
);

$fees_unaided = array(
    "HSC EXAM FEES" => 1000,
    "TUITION FEES" => 13450,
    "STATIONARY FEES" => 3000,
    "C.S FEES (only Applicable for CS Students)" => 19800,
    "I.T FEES (only Applicable for IT Students)" => 7000,
    "PTA FEES" => 200
);

// Handle search functionality
$search_query = "";
$search_results = array();
$selected_student = null;
$selected_components = array();
$total_amount = 0;
$receipt_generated = false;

if ($_POST) {
    // Handle student search
    if (isset($_POST['search_student']) && !empty($_POST['search_query'])) {
        $search_query = trim($_POST['search_query']);
        
        // Search by ID, name, or mobile number
        $search_sql = "SELECT id, full_name, father_name, mobile_number, institution_type, program_interest, class 
                       FROM student_register 
                       WHERE id LIKE ? OR full_name LIKE ? OR mobile_number LIKE ? 
                       ORDER BY full_name LIMIT 10";
        
        $search_param = "%$search_query%";
        $stmt = $conn->prepare($search_sql);
        $stmt->bind_param("sss", $search_param, $search_param, $search_param);
        $stmt->execute();
        $search_results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
    
    // Handle student selection and receipt generation
    if (isset($_POST['student_id']) && $_POST['student_id'] != '') {
        $student_id = $_POST['student_id'];
        $student_query = $conn->query("SELECT * FROM student_register WHERE id = $student_id");
        $selected_student = $student_query->fetch_assoc();
        
        // Handle fee component selection and calculation
        if (isset($_POST['components']) && is_array($_POST['components'])) {
            $selected_components = $_POST['components'];
            $fee_structure = ($selected_student['institution_type'] == 'Aided') ? $fees_aided : $fees_unaided;
            
            foreach ($selected_components as $component) {
                if (isset($fee_structure[$component])) {
                    $total_amount += $fee_structure[$component];
                }
            }
            
            // Check if receipt generation is requested
            if (isset($_POST['generate_receipt']) && $total_amount > 0) {
                $receipt_generated = true;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>New Payment Receipt Generator</title>
    <link rel="stylesheet" href="../assets/admin-theme.css">
    <style>
        /* Additional custom styles for receipt generator page */
        .components-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        
        .component-item {
            background-color: #e8f4f8;
            padding: 15px;
            border-radius: 5px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .component-item:hover {
            border-color: #3498db;
            background-color: #d4edda;
        }
        
        .component-item input[type="checkbox"] {
            margin-right: 10px;
            transform: scale(1.2);
        }
        
        .student-info {
            background-color: #e8f5e8;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }
        
        .info-item {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        
        .info-label {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .total-amount {
            background-color: #fff3cd;
            border: 2px solid #ffc107;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        
        .total-amount h3 {
            color: #856404;
            margin: 0;
            font-size: 24px;
        }
        
        .receipt {
            background-color: #fff;
            width: 176mm;  /* B5 width */
            height: 250mm; /* B5 height */
            margin: 20px auto;
            padding: 15mm;
            border: 2px solid #000;
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            box-sizing: border-box;
        }
        
        .receipt-header {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        
        .receipt-logo {
            width: 100px;
            height: 100px;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .receipt-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .receipt-school-info {
            flex: 1;
            text-align: center;
        }
        
        .receipt-school-info h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            line-height: 1.2;
        }
        
        .receipt-address {
            font-size: 10px;
            margin: 5px 0;
        }
        
        .receipt-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 15px 0;
            text-decoration: underline;
        }
        
        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 11px;
        }
        
        .receipt-student-details {
            margin-bottom: 15px;
            font-size: 11px;
            line-height: 1.6;
        }
        
        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 11px;
        }
        
        .receipt-table th,
        .receipt-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        
        .receipt-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        
        .receipt-table td:last-child {
            text-align: right;
        }
        
        .receipt-total-row {
            font-weight: bold;
        }
        
        .receipt-amount-words {
            margin: 15px 0;
            font-size: 11px;
        }
        
        .receipt-note {
            font-size: 9px;
            font-style: italic;
            margin: 10px 0;
        }
        
        .receipt-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
            font-size: 11px;
        }
        
        .receipt-signature {
            text-align: center;
            min-width: 120px;
        }
        
        .search-section {
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #17a2b8;
        }
        
        .search-box {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .search-box input[type="text"] {
            flex: 1;
            min-width: 300px;
        }
        
        .search-results {
            background-color: #fff;
            border: 2px solid #17a2b8;
            border-radius: 8px;
            margin-top: 20px;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .search-result-item {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .search-result-item:hover {
            background-color: #e8f4f8;
            border-left: 4px solid #17a2b8;
        }
        
        .search-result-item:last-child {
            border-bottom: none;
        }
        
        .student-basic-info {
            flex: 1;
        }
        
        .student-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 16px;
        }
        
        .student-details {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .select-btn {
            background-color: #17a2b8;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        
        .select-btn:hover {
            background-color: #138496;
        }
        
        .search-info {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 15px;
            font-size: 14px;
        }
        
        .no-results {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
        }
        
        @media print {
            @page {
                size: B5;
                margin: 10mm;
            }
            
            body * {
                visibility: hidden;
            }
            .receipt, .receipt * {
                visibility: visible;
            }
            .receipt {
                position: absolute;
                left: 0;
                top: 0;
                margin: 0;
                border: none;
                width: 100%;
                height: 100%;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
    <script>
        // Fee structures for JavaScript calculation
        const feesAided = {
            "HSC EXAM FEES": 1000,
            "TUITION FEES": 340,
            "STATIONARY FEES": 3000,
            "C.S FEES (only Applicable for CS Students)": 19800,
            "I.T FEES (only Applicable for IT Students)": 7000,
            "PTA FEES": 200
        };
        
        const feesUnaided = {
            "HSC EXAM FEES": 1000,
            "TUITION FEES": 13450,
            "STATIONARY FEES": 3000,
            "C.S FEES (only Applicable for CS Students)": 19800,
            "I.T FEES (only Applicable for IT Students)": 7000,
            "PTA FEES": 200
        };
        
        function calculateTotal() {
            const institutionType = document.getElementById('institution_type').value;
            const feeStructure = (institutionType === 'Aided') ? feesAided : feesUnaided;
            
            let total = 0;
            const checkboxes = document.querySelectorAll('input[name="components[]"]:checked');
            
            checkboxes.forEach(checkbox => {
                const component = checkbox.value;
                if (feeStructure[component]) {
                    total += feeStructure[component];
                }
            });
            
            // Update total display
            const totalElement = document.getElementById('total_amount');
            const generateBtn = document.getElementById('generate_btn');
            
            if (total > 0) {
                totalElement.innerHTML = '<h3>Total Amount: ₹' + total.toLocaleString() + '</h3>';
                totalElement.style.display = 'block';
                generateBtn.style.display = 'inline-block';
            } else {
                totalElement.style.display = 'none';
                generateBtn.style.display = 'none';
            }
        }
        
        function toggleComponent(checkbox) {
            const item = checkbox.closest('.component-item');
            if (checkbox.checked) {
                item.style.backgroundColor = '#d4edda';
                item.style.borderColor = '#28a745';
            } else {
                item.style.backgroundColor = '#e8f4f8';
                item.style.borderColor = 'transparent';
            }
            calculateTotal();
        }
        
        // Initialize form when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Check if we have selected components and calculate total
            calculateTotal();
            
            // Set initial state for checked components
            const checkboxes = document.querySelectorAll('input[name="components[]"]');
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    toggleComponent(checkbox);
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>New Payment Receipt Generator</h1>
        
        <?php 
        // Debug information (remove in production)
        if (isset($_POST['generate_receipt'])) {
            echo "<!-- Debug: Generate receipt clicked -->";
            echo "<!-- Student ID: " . (isset($_POST['student_id']) ? $_POST['student_id'] : 'Not set') . " -->";
            echo "<!-- Components: " . (isset($_POST['components']) ? implode(', ', $_POST['components']) : 'None') . " -->";
            echo "<!-- Total: " . $total_amount . " -->";
            echo "<!-- Receipt Generated: " . ($receipt_generated ? 'Yes' : 'No') . " -->";
        }
        
        if (!$receipt_generated): ?>
        <form method="POST" action="">
            <div class="search-section">
                <h3>🔍 Search Student</h3>
                <div class="search-box">
                    <input type="text" 
                           name="search_query" 
                           placeholder="Search by Student ID, Name, or Mobile Number..." 
                           value="<?php echo htmlspecialchars($search_query); ?>"
                           autocomplete="off">
                    <button type="submit" name="search_student" class="btn">Search</button>
                </div>
                
                <div class="search-info">
                    <strong>💡 Tip:</strong> You can search using Student ID (e.g., "1"), Name (e.g., "John"), or Mobile Number (e.g., "9876543210")
                </div>
                
                <?php if (!empty($search_results)): ?>
                <div class="search-results">
                    <?php foreach($search_results as $student): ?>
                    <div class="search-result-item">
                        <div class="student-basic-info">
                            <div class="student-name"><?php echo htmlspecialchars($student['full_name']); ?></div>
                            <div class="student-details">
                                ID: <?php echo $student['id']; ?> | 
                                Mobile: <?php echo $student['mobile_number']; ?> | 
                                Class: <?php echo $student['class']; ?> | 
                                Program: <?php echo $student['program_interest']; ?> | 
                                Type: <strong><?php echo $student['institution_type']; ?></strong>
                            </div>
                        </div>
                        <button type="submit" name="student_id" value="<?php echo $student['id']; ?>" class="select-btn">
                            Select
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php elseif (isset($_POST['search_student']) && !empty($search_query)): ?>
                <div class="search-results">
                    <div class="no-results">
                        No students found matching "<?php echo htmlspecialchars($search_query); ?>"<br>
                        <small>Try searching with different terms like Student ID, partial name, or mobile number</small>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <?php if ($selected_student): ?>
            <div class="student-info">
                <h3>Student Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Name:</div>
                        <div><?php echo $selected_student['full_name']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Father's Name:</div>
                        <div><?php echo $selected_student['father_name']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Mobile:</div>
                        <div><?php echo $selected_student['mobile_number']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Class:</div>
                        <div><?php echo $selected_student['class']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Program:</div>
                        <div><?php echo $selected_student['program_interest']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Institution Type:</div>
                        <div><?php echo $selected_student['institution_type']; ?></div>
                    </div>
                </div>
            </div>
            
            <!-- Hidden fields to maintain student data -->
            <input type="hidden" name="student_id" value="<?php echo $selected_student['id']; ?>">
            <input type="hidden" id="institution_type" value="<?php echo $selected_student['institution_type']; ?>">
            
            <div class="form-section">
                <h3>Select Fee Components (<?php echo $selected_student['institution_type']; ?> Students)</h3>
                <div class="components-grid">
                    <?php 
                    $fee_structure = ($selected_student['institution_type'] == 'Aided') ? $fees_aided : $fees_unaided;
                    foreach($fee_structure as $component => $amount): 
                    ?>
                    <div class="component-item">
                        <label>
                            <input type="checkbox" name="components[]" value="<?php echo $component; ?>"
                                   onchange="toggleComponent(this)"
                                   <?php echo (in_array($component, $selected_components)) ? 'checked' : ''; ?>>
                            <strong><?php echo $component; ?></strong><br>
                            <span style="color: #28a745; font-weight: bold;">₹<?php echo number_format($amount); ?></span>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Auto-calculated total amount -->
            <div id="total_amount" class="total-amount" style="display: none;">
                <h3>Total Amount: ₹0</h3>
            </div>
            
            <div style="text-align: center;">
                <button type="submit" name="generate_receipt" id="generate_btn" class="btn btn-success" style="display: none;">
                    Generate Receipt
                </button>
            </div>
            <?php endif; ?>
        </form>
        
        <?php else: ?>
        <div class="receipt">
            <div class="receipt-header">
                <div class="receipt-logo">
                    <img src="IMG-20250419-WA0006.jpg" alt="School Logo">
                </div>
                <div class="receipt-school-info">
                    <h2>V.P.Sabha's<br>Bharat English School<br>&<br>Junior College</h2>
                    <div class="receipt-address">19/2, T.P Scheme, Shivajinagar, Pune 411005</div>
                </div>
            </div>
            
            <div class="receipt-title">FEES RECEIPT</div>
            
            <div class="receipt-info">
                <div>Registration no: <?php echo str_pad($selected_student['id'], 4, '0', STR_PAD_LEFT); ?></div>
                <div>Receipt Date: <?php echo date('d/m/Y'); ?></div>
            </div>
            
            <div class="receipt-student-details">
                <div><strong>Student Name:</strong> <?php echo strtoupper($selected_student['full_name']); ?></div>
                <div><strong>Class:</strong> <?php echo $selected_student['class']; ?></div>
                <div><strong>Institution Type:</strong> <?php echo $selected_student['institution_type']; ?></div>
                <div><strong>Academic Year:</strong> <?php echo date('Y'); ?>-<?php echo (date('Y') + 1); ?></div>
            </div>
            
            <table class="receipt-table">
                <thead>
                    <tr>
                        <th>Fees Components</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $fee_structure = ($selected_student['institution_type'] == 'Aided') ? $fees_aided : $fees_unaided;
                    foreach($selected_components as $component): 
                    ?>
                    <tr>
                        <td><?php echo $component; ?></td>
                        <td><?php echo number_format($fee_structure[$component]); ?>/-</td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="receipt-total-row">
                        <td><strong>TOTAL FEES</strong></td>
                        <td><strong><?php echo number_format($total_amount); ?>/-</strong></td>
                    </tr>
                </tbody>
            </table>
            
            <div class="receipt-amount-words">
                <strong>Amount in words:</strong><br>
                <?php 
                function convertToWords($number) {
                    $ones = array(
                        0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
                        7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
                        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen',
                        18 => 'Eighteen', 19 => 'Nineteen'
                    );
                    
                    $tens = array(
                        0 => '', 2 => 'Twenty', 3 => 'Thirty', 4 => 'Forty', 5 => 'Fifty', 6 => 'Sixty',
                        7 => 'Seventy', 8 => 'Eighty', 9 => 'Ninety'
                    );
                    
                    if ($number < 20) {
                        return $ones[$number];
                    } elseif ($number < 100) {
                        return $tens[intval($number / 10)] . ' ' . $ones[$number % 10];
                    } elseif ($number < 1000) {
                        return $ones[intval($number / 100)] . ' Hundred ' . convertToWords($number % 100);
                    } elseif ($number < 100000) {
                        return convertToWords(intval($number / 1000)) . ' Thousand ' . convertToWords($number % 1000);
                    } else {
                        return convertToWords(intval($number / 100000)) . ' Lakh ' . convertToWords($number % 100000);
                    }
                }
                echo ucfirst(trim(convertToWords($total_amount))) . ' rupees only';
                ?>
            </div>
            
            <div class="receipt-note">
                <em>Note: Fees marked as N/A were not applicable based on student's submitted documentation.</em>
            </div>
            
            <div class="receipt-footer">
                <div class="receipt-signature">
                    <strong>Principal</strong><br>
                    Bharat English School &<br>
                    Junior College, Pune 5
                </div>
            </div>
        </div>
        
        <div style="text-align: center; margin: 20px 0;" class="no-print">
            <button onclick="window.print()" class="btn">Print Receipt</button>
            <a href="receipt_generator.php" class="btn" style="text-decoration: none;">Generate New Receipt</a>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?> 
