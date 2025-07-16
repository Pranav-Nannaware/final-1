<?php
// Enable comprehensive error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log errors to a file for server-side debugging
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

// Start session for error handling
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle form submission directly (no redirect to prevent file loss)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include the processing logic directly
    require_once 'process_registration_direct.php';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Theme CSS with fallback -->
    <link rel="stylesheet" href="assets/theme.css?v=<?php echo time(); ?>">
    
    <style>
        /* Ensure the theme is properly loaded */
        body {
            font-family: 'DM Sans', sans-serif !important;
            min-height: 100vh;
            background: linear-gradient(-45deg, #FC466B, #3F5EFB) !important;
            background-size: 400% 400% !important;
            animation: gradient 15s ease infinite !important;
            color: #333 !important;
            position: relative;
            overflow-x: hidden;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Background blobs */
        .blob {
            position: absolute !important;
            width: 500px !important;
            height: 500px !important;
            mix-blend-mode: color-dodge !important;
            filter: blur(120px) !important;
            border-radius: 100% !important;
            z-index: 0 !important;
        }

        .blob-1 {
            top: -200px !important;
            right: -100px !important;
            background: linear-gradient(180deg, rgba(47, 184, 255, 0.42) 31.77%, #5E9FFE 100%) !important;
        }

        .blob-2 {
            bottom: -300px !important;
            left: -200px !important;
            background: linear-gradient(180deg, rgba(255, 97, 175, 0.42) 31.77%, #FF61AF 100%) !important;
        }

        /* Campus container */
        .campus-container {
            position: relative !important;
            z-index: 1 !important;
            padding: 1.5rem !important;
        }

        /* Campus cards */
        .campus-card {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px) !important;
            border-radius: 20px !important;
            overflow: hidden !important;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2) !important;
            margin-bottom: 1.5rem !important;
        }

        .campus-section {
            padding: 1.5rem !important;
        }

        /* Headings */
        .campus-heading {
            font-size: 1.8rem !important;
            font-weight: 700 !important;
            margin-bottom: 0.5rem !important;
            background: linear-gradient(to right, #FC466B, #3F5EFB) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        .campus-subheading {
            font-size: 1.4rem !important;
            font-weight: 600 !important;
            margin-bottom: 0.5rem !important;
            color: #3F5EFB !important;
        }

        /* Form controls */
        .campus-form-control {
            background: rgba(255, 255, 255, 0.8) !important;
            border: 2px solid rgba(0, 0, 0, 0.08) !important;
            border-radius: 12px !important;
            padding: 0.75rem 1rem !important;
            transition: all 0.3s ease !important;
            width: 100% !important;
        }

        .campus-form-control:focus {
            border-color: #3F5EFB !important;
            box-shadow: 0 0 0 0.2rem rgba(63, 94, 251, 0.25) !important;
            background: rgba(255, 255, 255, 0.95) !important;
        }

        /* Buttons */
        .campus-btn {
            background: linear-gradient(to right, #FC466B, #3F5EFB) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            color: white !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: inline-block !important;
        }

        .campus-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
            color: white !important;
        }

        .campus-btn-outline {
            background: rgba(255, 255, 255, 0.2) !important;
            border: 2px solid rgba(255, 255, 255, 0.3) !important;
            color: #333 !important;
        }

        .campus-btn-outline:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            color: #3F5EFB !important;
        }

        /* Form-specific custom styles */
        .required-field:after {
            content: " *";
            color: #FC466B;
        }
        
        .file-input-group {
            position: relative;
        }
        
        .file-input-group input[type="file"] {
            padding: 12px;
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            border: 2px solid rgba(0, 0, 0, 0.08);
            width: 100%;
        }
        
        .progress-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }
        
        .progress-container::before {
            content: '';
            position: absolute;
            background: rgba(0, 0, 0, 0.1);
            height: 4px;
            width: 100%;
            top: 15px;
            z-index: 1;
        }
        
        .progress-step {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 33%;
        }
        
        .step-circle {
            background: white;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            height: 34px;
            width: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
        }
        
        .progress-step.active .step-circle {
            border-color: #3F5EFB;
            background: #3F5EFB;
            color: white;
        }
        
        .progress-step.completed .step-circle {
            border-color: #28a745;
            background: #28a745;
            color: white;
        }
        
        .progress-step-label {
            font-size: 14px;
            font-weight: 600;
        }
        
        .campus-form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px 1.5rem;
        }
        
        .campus-form-column {
            flex: 1;
            padding: 0 15px;
            min-width: 250px;
        }
        
        /* Custom form field enhancements */
        .campus-form-control {
            padding: 0.75rem 1rem !important;
            height: auto !important;
        }
        
        .campus-form-group {
            margin-bottom: 1.5rem;
        }
        
        .campus-form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        /* Spacing between sections */
        .campus-card {
            margin-bottom: 2rem !important;
        }
        
        .campus-section {
            padding: 1.75rem !important;
        }
        
        .campus-subheading {
            margin-bottom: 1.5rem !important;
        }
        
        /* File inputs alignment */
        .file-input-group {
            margin-top: 0.25rem;
        }
        
        /* Form check alignment */
        .form-check {
            padding-left: 1.75rem;
        }
        
        .form-check-input {
            margin-left: -1.75rem;
        }
        
        /* Text formatting */
        .text-muted {
            color: rgba(0, 0, 0, 0.6) !important;
        }
        
        textarea.campus-form-control {
            min-height: 100px;
        }
        
        /* Review section styles */
        .review-item {
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px dashed rgba(0,0,0,0.1);
        }
        
        .review-label {
            font-weight: 600;
            color: #3F5EFB;
        }
        
        .review-value {
            font-weight: 400;
        }
        
        .step-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
        }
        
        .is-invalid {
            border-color: var(--error) !important;
        }
        
        .campus-alert {
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .campus-alert-info {
            border-left: 4px solid var(--accent);
        }
        
        @media (max-width: 768px) { 
            .campus-form-row {
                flex-direction: column;
            }
            
            .campus-form-column {
                min-width: 100%;
            }
            
            .step-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .step-buttons .campus-btn {
                width: 100%;
            }
        }
    </style>
    
    <script>
        function copyAddress(checkbox) {
            if (checkbox.checked) {
                document.getElementById('permanent_address').value = document.getElementById('current_address').value;
                document.getElementById('permanent_address').disabled = true;
            } else {
                document.getElementById('permanent_address').disabled = false;
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize multi-step form elements
            const maxFileSize = 1 * 1024 * 1024;
            const fileInputs = document.querySelectorAll('input[type="file"]');
            
            const personalInfoSection = document.getElementById('personal-info-section');
            const documentsSection = document.getElementById('documents-section');
            const reservedDocsSection = document.getElementById('reserved-docs-section');
            const reviewSection = document.getElementById('review-section');
            const termsSection = document.getElementById('terms-section');
            
            const personalInfoProgress = document.getElementById('personal-info-progress');
            const documentsProgress = document.getElementById('documents-progress');
            const reviewProgress = document.getElementById('review-progress');
            
            const nextToDocsBtn = document.getElementById('next-to-docs-btn');
            const backToPersonalBtn = document.getElementById('back-to-personal-btn');
            const nextToReviewBtn = document.getElementById('next-to-review-btn');
            const backToDocsBtn = document.getElementById('back-to-docs-btn');
            const submitFormBtn = document.getElementById('submit-form-btn');
            
            // Set initial state
            personalInfoSection.style.display = 'block';
            documentsSection.style.display = 'none';
            reservedDocsSection.style.display = 'none';
            reviewSection.style.display = 'none';
            termsSection.style.display = 'none';
            
            personalInfoProgress.classList.add('active');
            
            // Function to update review section with form data
            function updateReviewSection() {
                // Personal Information
                document.getElementById('review-full-name').textContent = document.getElementById('full_name').value || 'Not provided';
                document.getElementById('review-email').textContent = document.getElementById('email').value || 'Not provided';
                document.getElementById('review-father-name').textContent = document.getElementById('father_name').value || 'Not provided';
                document.getElementById('review-mother-name').textContent = document.getElementById('mother_name').value || 'Not provided';
                document.getElementById('review-mobile').textContent = document.getElementById('mobile_number').value || 'Not provided';
                document.getElementById('review-guardian-mobile').textContent = document.getElementById('guardian_mobile_number').value || 'Not provided';
                document.getElementById('review-dob').textContent = document.getElementById('dob').value || 'Not provided';
                
                const genderSelect = document.getElementById('gender');
                document.getElementById('review-gender').textContent = genderSelect.selectedIndex > 0 ? 
                    genderSelect.options[genderSelect.selectedIndex].text : 'Not selected';
                
                const classSelect = document.getElementById('class');
                document.getElementById('review-class').textContent = classSelect.selectedIndex > 0 ? 
                    classSelect.options[classSelect.selectedIndex].text : 'Not selected';
                
                const programSelect = document.getElementById('program_interest');
                document.getElementById('review-program').textContent = programSelect.selectedIndex > 0 ? 
                    programSelect.options[programSelect.selectedIndex].text : 'Not selected';
                
                const institutionSelect = document.getElementById('institution_type');
                document.getElementById('review-institution').textContent = institutionSelect.selectedIndex > 0 ? 
                    institutionSelect.options[institutionSelect.selectedIndex].text : 'Not selected';
                
                const casteSelect = document.getElementById('caste');
                document.getElementById('review-caste').textContent = casteSelect.selectedIndex > 0 ? 
                    casteSelect.options[casteSelect.selectedIndex].text : 'Not selected';
                
                const categorySelect = document.getElementById('category');
                document.getElementById('review-category').textContent = categorySelect.selectedIndex > 0 ? 
                    categorySelect.options[categorySelect.selectedIndex].text : 'Not selected';
                
                document.getElementById('review-school-udise').textContent = document.getElementById('school_udise_number').value || 'Not provided';
                document.getElementById('review-aadhaar-number').textContent = document.getElementById('aadhaar_number').value || 'Not provided';
                document.getElementById('review-tenth-marks').textContent = document.getElementById('tenth_marks').value || 'Not provided';
                document.getElementById('review-tenth-percentage').textContent = document.getElementById('tenth_percentage').value ? document.getElementById('tenth_percentage').value + '%' : 'Not provided';
                
                document.getElementById('review-current-address').textContent = document.getElementById('current_address').value || 'Not provided';
                document.getElementById('review-permanent-address').textContent = document.getElementById('permanent_address').value || 'Not provided';
                
                // Documents
                const tenthMarksheet = document.getElementById('tenth_marksheet').files[0];
                document.getElementById('review-tenth-marksheet').textContent = tenthMarksheet ? tenthMarksheet.name : 'No file selected';
                
                const schoolLeaving = document.getElementById('school_leaving_certificate').files[0];
                document.getElementById('review-school-leaving').textContent = schoolLeaving ? schoolLeaving.name : 'No file selected';
                
                const aadhaarCard = document.getElementById('aadhaar_card').files[0];
                document.getElementById('review-aadhaar').textContent = aadhaarCard ? aadhaarCard.name : 'No file selected';
                
                const passportPhoto = document.getElementById('passport_photo').files[0];
                document.getElementById('review-passport-photo').textContent = passportPhoto ? passportPhoto.name : 'No file selected';
                
                // Reserved Category Documents
                const casteCertificate = document.getElementById('caste_certificate').files[0];
                document.getElementById('review-caste-certificate').textContent = casteCertificate ? casteCertificate.name : 'Not uploaded';
                
                const nonCreamyLayer = document.getElementById('non_creamy_layer_certificate').files[0];
                document.getElementById('review-non-creamy').textContent = nonCreamyLayer ? nonCreamyLayer.name : 'Not uploaded';
                
                const ewsCertificate = document.getElementById('ews_eligibility_certificate').files[0];
                document.getElementById('review-ews').textContent = ewsCertificate ? ewsCertificate.name : 'Not uploaded';
                
                const domicileCertificate = document.getElementById('domicile_certificate').files[0];
                document.getElementById('review-domicile').textContent = domicileCertificate ? domicileCertificate.name : 'Not uploaded';
            }
            
            // Validate personal info fields
            function validatePersonalInfo() {
                const requiredFields = personalInfoSection.querySelectorAll('[required]');
                let valid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        valid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
                
                return valid;
            }
            
            // Validate document fields
            function validateDocuments() {
                const requiredFields = documentsSection.querySelectorAll('[required]');
                let valid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        valid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
                
                return valid;
            }
            
            // Next button: Personal Info to Documents
            if (nextToDocsBtn) {
                nextToDocsBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (!validatePersonalInfo()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Information',
                            text: 'Please fill out all required fields in Personal Information.',
                            confirmButtonColor: '#FC466B'
                        });
                        return;
                    }
                    
                    // Update display
                    personalInfoSection.style.display = 'none';
                    documentsSection.style.display = 'block';
                    reservedDocsSection.style.display = 'block';
                    reviewSection.style.display = 'none';
                    termsSection.style.display = 'none';
                    
                    // Update progress
                    personalInfoProgress.classList.remove('active');
                    personalInfoProgress.classList.add('completed');
                    documentsProgress.classList.add('active');
                    reviewProgress.classList.remove('active');
                    
                    // Scroll to top
                    window.scrollTo(0, 0);
                });
            }
            
            // Back button: Documents to Personal Info
            if (backToPersonalBtn) {
                backToPersonalBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Update display
                    personalInfoSection.style.display = 'block';
                    documentsSection.style.display = 'none';
                    reservedDocsSection.style.display = 'none';
                    reviewSection.style.display = 'none';
                    termsSection.style.display = 'none';
                    
                    // Update progress
                    personalInfoProgress.classList.add('active');
                    personalInfoProgress.classList.remove('completed');
                    documentsProgress.classList.remove('active');
                    
                    // Scroll to top
                    window.scrollTo(0, 0);
                });
            }
            
            // Next button: Documents to Review
            if (nextToReviewBtn) {
                nextToReviewBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (!validateDocuments()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Documents',
                            text: 'Please upload all required documents.',
                            confirmButtonColor: '#FC466B'
                        });
                        return;
                    }
                    
                    // Update review content
                    updateReviewSection();
                    
                    // Update display
                    personalInfoSection.style.display = 'none';
                    documentsSection.style.display = 'none';
                    reservedDocsSection.style.display = 'none';
                    reviewSection.style.display = 'block';
                    termsSection.style.display = 'block';
                    
                    // Update progress
                    personalInfoProgress.classList.remove('active');
                    personalInfoProgress.classList.add('completed');
                    documentsProgress.classList.remove('active');
                    documentsProgress.classList.add('completed');
                    reviewProgress.classList.add('active');
                    
                    // Scroll to top
                    window.scrollTo(0, 0);
                });
            }
            
            // Back button: Review to Documents
            if (backToDocsBtn) {
                backToDocsBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Update display
                    personalInfoSection.style.display = 'none';
                    documentsSection.style.display = 'block';
                    reservedDocsSection.style.display = 'block';
                    reviewSection.style.display = 'none';
                    termsSection.style.display = 'none';
                    
                    // Update progress
                    documentsProgress.classList.add('active');
                    documentsProgress.classList.remove('completed');
                    reviewProgress.classList.remove('active');
                    
                    // Scroll to top
                    window.scrollTo(0, 0);
                });
            }
            
            // Auto-calculate percentage based on total marks out of 500
            const tenthMarksInput = document.getElementById('tenth_marks');
            const tenthPercentageInput = document.getElementById('tenth_percentage');
            let isManualPercentage = false;
            
            if (tenthMarksInput && tenthPercentageInput) {
                // Track if user manually enters percentage
                tenthPercentageInput.addEventListener('input', function() {
                    if (this.value !== '') {
                        isManualPercentage = true;
                    }
                });
                
                // Auto-calculate only if percentage hasn't been manually entered
                tenthMarksInput.addEventListener('input', function() {
                    const totalMarks = parseFloat(this.value);
                    if (!isManualPercentage) {
                        if (totalMarks >= 0 && totalMarks <= 500) {
                            const percentage = (totalMarks / 500) * 100;
                            tenthPercentageInput.value = percentage.toFixed(2);
                        } else if (this.value === '') {
                            tenthPercentageInput.value = '';
                        }
                    }
                });
                
                // Reset manual flag if percentage field is cleared
                tenthPercentageInput.addEventListener('keyup', function() {
                    if (this.value === '') {
                        isManualPercentage = false;
                    }
                });
            }
            
            // Enhanced file validation (size and type)
            fileInputs.forEach(function(input) {
                input.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        // Check file size
                        if (file.size > maxFileSize) {
                            Swal.fire({
                                icon: 'error',
                                title: 'File Too Large',
                                text: `The file '${file.name}' exceeds the maximum allowed size of 1MB.`,
                                confirmButtonColor: '#FC466B'
                            });
                            event.target.value = "";
                            return;
                        }
                        
                        // Check file extension
                        const fileName = file.name.toLowerCase();
                        const allowedExtensions = ['.jpg', '.jpeg', '.png', '.pdf'];
                        const fileExtension = fileName.substring(fileName.lastIndexOf('.'));
                        
                        if (!allowedExtensions.includes(fileExtension)) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid File Type',
                                text: `Please upload only JPG, JPEG, PNG, or PDF files. You uploaded: ${fileExtension}`,
                                confirmButtonColor: '#FC466B'
                            });
                            event.target.value = "";
                            return;
                        }
                        
                        // Check MIME type if available
                        if (file.type) {
                            const allowedMimeTypes = [
                                'image/jpeg',
                                'image/jpg', 
                                'image/png',
                                'application/pdf'
                            ];
                            
                            if (!allowedMimeTypes.includes(file.type)) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Invalid File Format',
                                    text: `File type '${file.type}' not supported. Please upload JPG, PNG, or PDF.`,
                                    confirmButtonColor: '#FC466B'
                                });
                                event.target.value = "";
                                return;
                            }
                        }
                    }
                });
            });
            
            // Form submission
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Always prevent default to handle validation
                    
                    // Check if we're on the review step
                    if (reviewSection.style.display !== 'block') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Complete All Steps',
                            text: 'Please complete all steps and review your information before submitting.',
                            confirmButtonColor: '#FC466B'
                        });
                        return;
                    }
                    
                    // Validate terms checkbox
                    const termsCheckbox = document.getElementById('agree_terms');
                    if (!termsCheckbox.checked) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Terms Agreement Required',
                            text: 'Please agree to the terms and conditions before submitting.',
                            confirmButtonColor: '#FC466B'
                        });
                        return;
                    }
                    
                    // Final validation of all required fields
                    const allRequiredFields = form.querySelectorAll('[required]');
                    let valid = true;
                    let invalidFields = [];
                    
                    allRequiredFields.forEach(field => {
                        if (field.type !== 'checkbox' && !field.value.trim()) {
                            valid = false;
                            invalidFields.push(field.name || 'Unnamed field');
                        }
                    });
                    
                    if (!valid) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Information',
                            text: 'Some required information is missing: ' + invalidFields.join(', ') + '. Please go back and complete all fields.',
                            confirmButtonColor: '#FC466B'
                        });
                        return;
                    }
                    
                    // Show processing message
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Your registration is being submitted.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                            
                            // Submit the form with a small delay to allow the UI to update
                            setTimeout(() => {
                                try {
                                    // Force all fields to be valid before submission
                                    const requiredFields = form.querySelectorAll('[required]');
                                    requiredFields.forEach(field => {
                                        if (!field.value && field.type !== 'checkbox') {
                                            // If a required file input is empty, set a dummy value that passes validation
                                            // This is because we already validated files are uploaded earlier
                                            if (field.type === 'file' && field.files.length === 0) {
                                                // We already validated files earlier, so we can bypass here
                                                field.removeAttribute('required');
                                            }
                                        }
                                    });
                                    
                                    // Actually submit the form
                                    form.removeEventListener('submit', arguments.callee);
                                    form.submit();
                                } catch (error) {
                                    console.error("Form submission error:", error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Submission Error',
                                        text: 'An error occurred while submitting the form: ' + error.message,
                                        confirmButtonColor: '#FC466B'
                                    });
                                }
                            }, 500);
                        }
                    });
                });
            }
        });
    </script>
</head>
<body>
    <!-- Background Effects -->
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="campus-container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="campus-card">
                        <div class="campus-section">
                            <div class="text-center mb-4">
                                <h1 class="campus-heading">Student Registration</h1>
                                <p>Complete the form below to register as a student with our institution</p>
                            </div>
                            
                            <div class="progress-container mb-5">
                                <div class="progress-step" id="personal-info-progress">
                                    <div class="step-circle">1</div>
                                    <div class="progress-step-label">Personal Info</div>
                                </div>
                                <div class="progress-step" id="documents-progress">
                                    <div class="step-circle">2</div>
                                    <div class="progress-step-label">Documents</div>
                                </div>
                                <div class="progress-step" id="review-progress">
                                    <div class="step-circle">3</div>
                                    <div class="progress-step-label">Review & Submit</div>
                                </div>
                            </div>
                            
                            <form method="post" enctype="multipart/form-data" id="registration-form">
                                
                                
                                <!-- Personal Information -->
                                <div class="campus-card mb-4" id="personal-info-section">
                                    <div class="campus-section">
                                        <h2 class="campus-subheading"><i class="bi bi-person-fill me-2"></i> Personal Information</h2>
                                        
                                        <div class="campus-form-row">
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="full_name" class="required-field">Full Name</label>
                                                    <input type="text" name="full_name" id="full_name" class="campus-form-control" required placeholder="Enter your full name">
                                                </div>
                                            </div>
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="email" class="required-field">Student Email</label>
                                                    <input type="email" name="email" id="email" class="campus-form-control" required placeholder="Enter your email address">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="campus-form-row">
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="father_name" class="required-field">Father's Name</label>
                                                    <input type="text" name="father_name" id="father_name" class="campus-form-control" required placeholder="Enter father's name">
                                                </div>
                                            </div>
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="mother_name" class="required-field">Mother's Name</label>
                                                    <input type="text" name="mother_name" id="mother_name" class="campus-form-control" required placeholder="Enter mother's name">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="campus-form-row">
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="mobile_number" class="required-field">Mobile Number</label>
                                                    <input type="tel" name="mobile_number" id="mobile_number" class="campus-form-control" required pattern="[0-9]+" title="Please enter only numbers." placeholder="Enter your mobile number">
                                                </div>
                                            </div>
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="guardian_mobile_number" class="required-field">Parent/Guardian Mobile</label>
                                                    <input type="tel" name="guardian_mobile_number" id="guardian_mobile_number" class="campus-form-control" required pattern="[0-9]+" title="Please enter only numbers." placeholder="Enter guardian's mobile number">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="campus-form-row">
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="dob" class="required-field">Date of Birth</label>
                                                    <input type="date" name="dob" id="dob" class="campus-form-control" required>
                                                </div>
                                            </div>
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="gender" class="required-field">Gender</label>
                                                    <select name="gender" id="gender" class="campus-form-control" required>
                                                        <option value="">Select gender</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="campus-form-row">
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="class" class="required-field">Class</label>
                                                    <select name="class" id="class" class="campus-form-control" required>
                                                        <option value="">Select class</option>
                                                        <option value="11th">11th</option>
                                                        <option value="12th">12th</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="program_interest">Optional Subjects</label>
                                                    <select name="program_interest" id="program_interest" class="campus-form-control" required>
							<option value="">Select optional subject</option>
                                                        <option value="NULL">NONE</option>							
<option value="Computer Science">Computer Science</option>
                                                        <option value="IT">IT</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                                                <div class="campus-form-row">
                            <div class="campus-form-column">
                                <div class="campus-form-group">
                                    <label for="institution_type" class="required-field">Institution Type</label>
                                    <select name="institution_type" id="institution_type" class="campus-form-control" required>
                                        <option value="">Select institution type</option>
                                        <option value="Aided">Aided</option>
                                        <option value="Unaided">Unaided</option>
                                    </select>
                                </div>
                            </div>
                            <div class="campus-form-column">
                                <div class="campus-form-group">
                                    <label for="caste" class="required-field">Caste</label>
                                    <select name="caste" id="caste" class="campus-form-control" required>
                                        <option value="">Select caste</option>
                                        <option value="General">General</option>
                                        <option value="SC">SC</option>
                                        <option value="ST">ST</option>
                                        <option value="OBC">OBC</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="campus-form-row">
                            <div class="campus-form-column">
                                <div class="campus-form-group">
                                    <label for="school_udise_number" class="required-field">Last Year School UDISE Number</label>
                                    <input type="text" name="school_udise_number" id="school_udise_number" class="campus-form-control" required pattern="[0-9]+" title="Please enter only numbers." placeholder="Enter school UDISE number">
                                </div>
                            </div>
                            <div class="campus-form-column">
                                <div class="campus-form-group">
                                    <label for="aadhaar_number" class="required-field">Aadhaar Card Number</label>
                                    <input type="text" name="aadhaar_number" id="aadhaar_number" class="campus-form-control" required pattern="[0-9]{12}" title="Please enter a valid 12-digit Aadhaar number." placeholder="Enter 12-digit Aadhaar number" maxlength="12">
                                </div>
                            </div>
                        </div>
                        
                        <div class="campus-form-row">
                            <div class="campus-form-column">
                                <div class="campus-form-group">
                                    <label for="tenth_marks" class="required-field">Standard 10th Total Marks (Out of 500)</label>
                                    <input type="number" name="tenth_marks" id="tenth_marks" class="campus-form-control" required min="0" max="500" placeholder="Enter total marks obtained out of 500">
                                </div>
                            </div>
                            <div class="campus-form-column">
                                <div class="campus-form-group">
                                    <label for="tenth_percentage" class="required-field">Standard 10th Percentage</label>
                                    <input type="number" name="tenth_percentage" id="tenth_percentage" class="campus-form-control" required min="0" max="100" step="0.01" placeholder="Auto-calculated or enter manually">
                                </div>
                            </div>
                        </div>
                                        
                                        <div class="campus-form-row">
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="category" class="required-field">Category</label>
                                                    <select name="category" id="category" class="campus-form-control" required>
                                                        <option value="">Select category</option>
                                                        <option value="Open">Open</option>
                                                        <option value="Reserved">Reserved</option>
                                                        <option value="EWS">EWS</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="current_address" class="required-field">Current Address</label>
                                                    <textarea name="current_address" id="current_address" class="campus-form-control" required placeholder="Enter your current address"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="campus-form-row">
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="permanent_address" class="required-field">Permanent Address</label>
                                                    <textarea name="permanent_address" id="permanent_address" class="campus-form-control" required placeholder="Enter your permanent address"></textarea>
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" id="same_address" onclick="copyAddress(this)">
                                                    <label class="form-check-label" for="same_address">
                                                        Same as Current Address
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="step-buttons">
                                            <div></div> <!-- Empty div for flex alignment -->
                                            <button type="button" id="next-to-docs-btn" class="campus-btn">
                                                <i class="bi bi-arrow-right me-2"></i> Next: Document Upload
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Document Upload -->
                                <div class="campus-card mb-4" id="documents-section">
                                    <div class="campus-section">
                                        <h2 class="campus-subheading"><i class="bi bi-file-earmark-arrow-up me-2"></i> Document Upload</h2>
                                        
                                        <div class="campus-alert campus-alert-info mb-4">
                                            <i class="bi bi-info-circle-fill"></i>
                                            <span>All documents must be in JPG, PNG, or PDF format, and each file must not exceed 1MB.</span>
                                        </div>
                                        
                                        <div class="campus-form-row">
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="tenth_marksheet" class="required-field">10th Marksheet</label>
                                                    <div class="file-input-group">
                                                        <input type="file" name="tenth_marksheet" id="tenth_marksheet" accept=".pdf,.jpg,.jpeg,.png" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="school_leaving_certificate" class="required-field">School Leaving Certificate</label>
                                                    <div class="file-input-group">
                                                        <input type="file" name="school_leaving_certificate" id="school_leaving_certificate" accept=".pdf,.jpg,.jpeg,.png" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="campus-form-row">
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="aadhaar_card" class="required-field">Aadhaar Card or valid ID Proof</label>
                                                    <div class="file-input-group">
                                                        <input type="file" name="aadhaar_card" id="aadhaar_card" accept=".pdf,.jpg,.jpeg,.png" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="passport_photo" class="required-field">Passport Size-Photo</label>
                                                    <div class="file-input-group">
                                                        <input type="file" name="passport_photo" id="passport_photo" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="campus-form-row">
                                            <div class="campus-form-column">
                                                <div class="campus-form-group">
                                                    <label for="domicile_certificate">Domicile Certificate (Optional)</label>
                                                    <div class="file-input-group">
                                                                                                <input type="file" name="domicile_certificate" id="domicile_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>
                            <div class="campus-form-column">
                                <!-- Intentionally left empty for alignment -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Reserved Category Documents -->
                <div class="campus-card mb-4" id="reserved-docs-section">
                    <div class="campus-section">
                        <h2 class="campus-subheading"><i class="bi bi-file-earmark-text me-2"></i> Reserved Category Documents</h2>
                        <p class="mb-4 text-muted">These documents are only required for applicants in reserved categories.</p>
                        
                        <div class="campus-form-row">
                            <div class="campus-form-column">
                                <div class="campus-form-group">
                                    <label for="caste_certificate">Caste Certificate</label>
                                    <div class="file-input-group">
                                        <input type="file" name="caste_certificate" id="caste_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>
                            <div class="campus-form-column">
                                <div class="campus-form-group">
                                    <label for="non_creamy_layer_certificate">Non Creamy Layer Certificate</label>
                                    <div class="file-input-group">
                                        <input type="file" name="non_creamy_layer_certificate" id="non_creamy_layer_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="campus-form-row mb-0">
                            <div class="campus-form-column">
                                <div class="campus-form-group mb-0">
                                    <label for="ews_eligibility_certificate">EWS Eligibility Certificate</label>
                                    <div class="file-input-group">
                                        <input type="file" name="ews_eligibility_certificate" id="ews_eligibility_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="campus-form-column">
                                                <!-- Intentionally left empty for alignment -->
                                            </div>
                                        </div>
                                        
                                        <div class="step-buttons">
                                            <button type="button" id="back-to-personal-btn" class="campus-btn campus-btn-outline">
                                                <i class="bi bi-arrow-left me-2"></i> Back to Personal Info
                                            </button>
                                            <button type="button" id="next-to-review-btn" class="campus-btn">
                                                <i class="bi bi-eye me-2"></i> Review Application
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Review Section -->
                                <div class="campus-card mb-4" id="review-section">
                                    <div class="campus-section">
                                        <h2 class="campus-subheading"><i class="bi bi-list-check me-2"></i> Review Your Application</h2>
                                        <p class="mb-4 text-muted">Please review all the information before final submission.</p>
                                        
                                        <div class="campus-card glass-effect">
                                            <div class="campus-section">
                                                <h3 class="text-accent mb-3">Personal Information</h3>
                                                
                                                <div class="row g-3 mb-4">
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Full Name</div>
                                                            <div class="review-value" id="review-full-name"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Email</div>
                                                            <div class="review-value" id="review-email"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Father's Name</div>
                                                            <div class="review-value" id="review-father-name"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Mother's Name</div>
                                                            <div class="review-value" id="review-mother-name"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Mobile Number</div>
                                                            <div class="review-value" id="review-mobile"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Guardian Mobile</div>
                                                            <div class="review-value" id="review-guardian-mobile"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Date of Birth</div>
                                                            <div class="review-value" id="review-dob"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Gender</div>
                                                            <div class="review-value" id="review-gender"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Class</div>
                                                            <div class="review-value" id="review-class"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Optional Subjects</div>
                                                            <div class="review-value" id="review-program"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Institution Type</div>
                                                            <div class="review-value" id="review-institution"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Caste</div>
                                                            <div class="review-value" id="review-caste"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Category</div>
                                                            <div class="review-value" id="review-category"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Last Year School UDISE Number</div>
                                                            <div class="review-value" id="review-school-udise"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Aadhaar Card Number</div>
                                                            <div class="review-value" id="review-aadhaar-number"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Standard 10th Total Marks (Out of 500)</div>
                                                            <div class="review-value" id="review-tenth-marks"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Standard 10th Percentage</div>
                                                            <div class="review-value" id="review-tenth-percentage"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-4">
                                                    <div class="review-item">
                                                        <div class="review-label">Current Address</div>
                                                        <div class="review-value" id="review-current-address"></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-4">
                                                    <div class="review-item">
                                                        <div class="review-label">Permanent Address</div>
                                                        <div class="review-value" id="review-permanent-address"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="campus-card glass-effect mt-4">
                                            <div class="campus-section">
                                                <h3 class="text-accent mb-3">Documents</h3>
                                                
                                                <div class="row g-3 mb-4">
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">10th Marksheet</div>
                                                            <div class="review-value" id="review-tenth-marksheet"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">School Leaving Certificate</div>
                                                            <div class="review-value" id="review-school-leaving"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Aadhaar Card</div>
                                                            <div class="review-value" id="review-aadhaar"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Passport Photo</div>
                                                            <div class="review-value" id="review-passport-photo"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <h4 class="text-accent mb-3">Reserved Category Documents</h4>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Caste Certificate</div>
                                                            <div class="review-value" id="review-caste-certificate"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Non Creamy Layer Certificate</div>
                                                            <div class="review-value" id="review-non-creamy"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">EWS Eligibility Certificate</div>
                                                            <div class="review-value" id="review-ews"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="review-item">
                                                            <div class="review-label">Domicile Certificate</div>
                                                            <div class="review-value" id="review-domicile"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="step-buttons">
                                            <button type="button" id="back-to-docs-btn" class="campus-btn campus-btn-outline">
                                                <i class="bi bi-arrow-left me-2"></i> Back to Documents
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                

                                
                                <!-- Terms and Submit -->
                                <div class="campus-card mb-4" id="terms-section">
                                    <div class="campus-section">
                                        <h2 class="campus-subheading"><i class="bi bi-check2-circle me-2"></i> Terms and Submission</h2>
                                        
                                        <div class="form-check mb-4">
                                            <input class="form-check-input" type="checkbox" name="agree_terms" id="agree_terms" required>
                                            <label class="form-check-label required-field" for="agree_terms">
                                                I agree to the terms and conditions and privacy policy.
                                            </label>
                                        </div>
                                        
                                        <div class="text-center">
                                            <button type="submit" id="submit-form-btn" class="campus-btn">
                                                <i class="bi bi-send-fill me-2"></i> Submit Registration
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registration-form');
            const submitBtn = document.getElementById('submit-form-btn');

        });
    </script>
</body>
</html>
