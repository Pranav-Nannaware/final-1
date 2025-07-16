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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Instructions - Student Registration</title>
    
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

        /* Instruction styles */
        .instruction-step {
            background: rgba(255, 255, 255, 0.7) !important;
            border-radius: 15px !important;
            padding: 1.5rem !important;
            margin-bottom: 1.5rem !important;
            border-left: 5px solid #3F5EFB !important;
            transition: all 0.3s ease !important;
        }

        .instruction-step:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .step-number {
            background: linear-gradient(to right, #FC466B, #3F5EFB) !important;
            color: white !important;
            width: 40px !important;
            height: 40px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-weight: bold !important;
            margin-bottom: 1rem !important;
        }

        .document-list {
            list-style: none !important;
            padding: 0 !important;
        }

        .document-list li {
            padding: 0.5rem 0 !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
            display: flex !important;
            align-items: center !important;
        }

        .document-list li:last-child {
            border-bottom: none !important;
        }

        .document-list li i {
            color: #3F5EFB !important;
            margin-right: 0.75rem !important;
            font-size: 1.2rem !important;
        }

        .required-badge {
            background: #FC466B !important;
            color: white !important;
            padding: 0.25rem 0.5rem !important;
            border-radius: 20px !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            margin-left: 0.5rem !important;
        }

        .optional-badge {
            background: #28a745 !important;
            color: white !important;
            padding: 0.25rem 0.5rem !important;
            border-radius: 20px !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            margin-left: 0.5rem !important;
        }

        .warning-box {
            background: rgba(255, 193, 7, 0.1) !important;
            border: 2px solid #ffc107 !important;
            border-radius: 12px !important;
            padding: 1rem !important;
            margin: 1rem 0 !important;
        }

        .info-box {
            background: rgba(13, 202, 240, 0.1) !important;
            border: 2px solid #0dcaf0 !important;
            border-radius: 12px !important;
            padding: 1rem !important;
            margin: 1rem 0 !important;
        }

        .checklist-item {
            display: flex !important;
            align-items: center !important;
            margin-bottom: 0.75rem !important;
            padding: 0.5rem !important;
            background: rgba(255, 255, 255, 0.5) !important;
            border-radius: 8px !important;
        }

        .checklist-item i {
            color: #28a745 !important;
            margin-right: 0.75rem !important;
            font-size: 1.2rem !important;
        }

        .progress-indicator {
            display: flex !important;
            justify-content: center !important;
            margin: 2rem 0 !important;
        }

        .progress-step {
            display: flex !important;
            align-items: center !important;
            margin: 0 1rem !important;
        }

        .progress-step.active {
            color: #3F5EFB !important;
            font-weight: bold !important;
        }

        .progress-step.completed {
            color: #28a745 !important;
        }

        .progress-line {
            width: 50px !important;
            height: 2px !important;
            background: rgba(0, 0, 0, 0.2) !important;
            margin: 0 0.5rem !important;
        }

        .progress-line.active {
            background: #3F5EFB !important;
        }

        .progress-line.completed {
            background: #28a745 !important;
        }

        @media (max-width: 768px) {
            .campus-heading {
                font-size: 1.5rem !important;
            }
            
            .campus-subheading {
                font-size: 1.2rem !important;
            }
            
            .instruction-step {
                padding: 1rem !important;
            }
            
            .progress-indicator {
                flex-direction: column !important;
                gap: 1rem !important;
            }
            
            .progress-step {
                margin: 0 !important;
            }
            
            .progress-line {
                display: none !important;
            }
        }
    </style>
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
                                <h1 class="campus-heading">Student Registration Instructions</h1>
                                <p class="text-muted">Please read these instructions carefully before proceeding with your registration</p>
                            </div>
                            
                            <!-- Progress Indicator -->
                            <div class="progress-indicator">
                                <div class="progress-step active">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    Instructions
                                </div>
                                <div class="progress-line active"></div>
                                <div class="progress-step">
                                    <i class="bi bi-person-fill me-2"></i>
                                    Registration
                                </div>
                                <div class="progress-line"></div>
                                <div class="progress-step">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    Complete
                                </div>
                            </div>
                            
                            <!-- Important Notice -->
                            <div class="warning-box">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle-fill me-3" style="color: #ffc107; font-size: 1.5rem;"></i>
                                    <div>
                                        <h5 class="mb-1">Important Notice</h5>
                                        <p class="mb-0">Please ensure you have all required documents ready before starting the registration process. Incomplete applications may be rejected.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Registration Process -->
                            <div class="instruction-step">
                                <div class="step-number">1</div>
                                <h3 class="campus-subheading">Registration Process Overview</h3>
                                <p>The registration process consists of three main steps:</p>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="text-center p-3">
                                            <i class="bi bi-person-fill" style="font-size: 2rem; color: #3F5EFB;"></i>
                                            <h5 class="mt-2">Step 1: Personal Information</h5>
                                            <p class="text-muted">Fill in your personal details, academic information, and contact details.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center p-3">
                                            <i class="bi bi-file-earmark-arrow-up" style="font-size: 2rem; color: #3F5EFB;"></i>
                                            <h5 class="mt-2">Step 2: Document Upload</h5>
                                            <p class="text-muted">Upload all required documents in the specified format.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center p-3">
                                            <i class="bi bi-check-circle-fill" style="font-size: 2rem; color: #3F5EFB;"></i>
                                            <h5 class="mt-2">Step 3: Review & Submit</h5>
                                            <p class="text-muted">Review all information and submit your application.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Required Documents -->
                            <div class="instruction-step">
                                <div class="step-number">2</div>
                                <h3 class="campus-subheading">Required Documents</h3>
                                <p>Please ensure you have the following documents ready in digital format (JPG, PNG, or PDF, max 1MB each):</p>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="text-primary">Mandatory Documents</h5>
                                        <ul class="document-list">
                                            <li>
                                                <i class="bi bi-file-earmark-text"></i>
                                                10th Marksheet
                                                <span class="required-badge">Required</span>
                                            </li>
                                            <li>
                                                <i class="bi bi-file-earmark-text"></i>
                                                School Leaving Certificate
                                                <span class="required-badge">Required</span>
                                            </li>
                                            <li>
                                                <i class="bi bi-file-earmark-text"></i>
                                                Aadhaar Card or Valid ID Proof
                                                <span class="required-badge">Required</span>
                                            </li>
                                            <li>
                                                <i class="bi bi-file-earmark-image"></i>
                                                Passport Size Photo
                                                <span class="required-badge">Required</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="text-success">Optional Documents</h5>
                                        <ul class="document-list">
                                            <li>
                                                <i class="bi bi-file-earmark-text"></i>
                                                Caste Certificate
                                                <span class="optional-badge">Optional</span>
                                            </li>
                                            <li>
                                                <i class="bi bi-file-earmark-text"></i>
                                                Non Creamy Layer Certificate
                                                <span class="optional-badge">Optional</span>
                                            </li>
                                            <li>
                                                <i class="bi bi-file-earmark-text"></i>
                                                EWS Eligibility Certificate
                                                <span class="optional-badge">Optional</span>
                                            </li>
                                            <li>
                                                <i class="bi bi-file-earmark-text"></i>
                                                Domicile Certificate
                                                <span class="optional-badge">Optional</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Information Required -->
                            <div class="instruction-step">
                                <div class="step-number">3</div>
                                <h3 class="campus-subheading">Information You'll Need</h3>
                                <p>Please have the following information ready:</p>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="text-primary">Personal Details</h5>
                                        <div class="checklist-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Full name as per official documents</span>
                                        </div>
                                        <div class="checklist-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Valid email address</span>
                                        </div>
                                        <div class="checklist-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Mobile number</span>
                                        </div>
                                        <div class="checklist-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Parent/Guardian mobile number</span>
                                        </div>
                                        <div class="checklist-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Date of birth</span>
                                        </div>
                                        <div class="checklist-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Complete address details</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="text-primary">Academic Information</h5>
                                        <div class="checklist-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>10th standard marks (out of 500)</span>
                                        </div>
                                        <div class="checklist-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>10th standard percentage</span>
                                        </div>
                                        <div class="checklist-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Previous school UDISE number</span>
                                        </div>
                                        <div class="checklist-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Aadhaar card number</span>
                                        </div>
                                        <div class="checklist-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Caste and category information</span>
                                        </div>
                                        <div class="checklist-item">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Preferred class (11th or 12th)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- File Upload Guidelines -->
                            <div class="instruction-step">
                                <div class="step-number">4</div>
                                <h3 class="campus-subheading">File Upload Guidelines</h3>
                                
                                <div class="info-box">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-info-circle-fill me-3" style="color: #0dcaf0; font-size: 1.5rem;"></i>
                                        <div>
                                            <h5 class="mb-1">File Requirements</h5>
                                            <ul class="mb-0">
                                                <li>Accepted formats: JPG, JPEG, PNG, PDF</li>
                                                <li>Maximum file size: 1MB per file</li>
                                                <li>Ensure documents are clear and readable</li>
                                                <li>All text should be clearly visible</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="text-success">Tips for Better Uploads</h5>
                                        <ul>
                                            <li>Use good lighting when scanning/photographing</li>
                                            <li>Ensure the entire document is captured</li>
                                            <li>Check that text is readable before uploading</li>
                                            <li>Use PDF format for multi-page documents</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="text-warning">Common Issues to Avoid</h5>
                                        <ul>
                                            <li>Blurry or unclear images</li>
                                            <li>Cut-off document edges</li>
                                            <li>Files larger than 1MB</li>
                                            <li>Unsupported file formats</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            

                            
                            <!-- Action Buttons -->
                            <div class="text-center mt-5">
                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                    <a href="index.php" class="campus-btn campus-btn-outline">
                                        <i class="bi bi-arrow-left me-2"></i> Back to Home
                                    </a>
                                    <a href="registration.php" class="campus-btn">
                                        <i class="bi bi-arrow-right me-2"></i> Start Registration
                                    </a>
                                </div>
                            </div>
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
            // Add smooth scrolling to anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
            
            // Add animation to instruction steps
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            document.querySelectorAll('.instruction-step').forEach(step => {
                step.style.opacity = '0';
                step.style.transform = 'translateY(20px)';
                step.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(step);
            });
        });
    </script>
</body>
</html> 