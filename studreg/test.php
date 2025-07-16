<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Portal - CMR Institute of Technology</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/theme.css?v=<?php echo time(); ?>">
</head>
<body>
    <!-- Background Effects -->
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    
    <div class="campus-container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">
                    <div class="campus-card">
                        <div class="campus-section text-center">
                            <!-- Logo -->
                            <div class="campus-logo justify-content-center">
                                <i class="bi bi-mortarboard"></i>
                                <span>Student Registration Portal</span>
                            </div>
                            
                            <!-- Main Heading -->
                            <h1 class="campus-heading">CMR Institute of Technology</h1>
                            <p class="mb-4 text-muted">Welcome to the Student Registration Portal. Start your academic journey with us.</p>
                            
                            <!-- Action Buttons -->
                            <div class="d-grid gap-3">
                                <a href="registration.php" class="campus-btn campus-btn-lg">
                                    <i class="bi bi-person-plus me-2"></i> New Student Registration
                                </a>
                                
                                <div class="row g-2">
                                    <div class="col-6">
                                        <a href="check_php_config.php" class="campus-btn campus-btn-outline w-100">
                                            <i class="bi bi-gear me-2"></i> System Check
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="registration_success.php" class="campus-btn campus-btn-outline w-100">
                                            <i class="bi bi-info-circle me-2"></i> Help
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Information Card -->
                    <div class="campus-card">
                        <div class="campus-section">
                            <h3 class="campus-subheading">
                                <i class="bi bi-info-circle me-2"></i>
                                Registration Information
                            </h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="feature-card h-100">
                                        <div class="card-icon">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                        <h5 class="card-title">Required Documents</h5>
                                        <ul class="list-unstyled mb-0">
                                            <li><i class="bi bi-check2 text-success me-2"></i> 10th Marksheet</li>
                                            <li><i class="bi bi-check2 text-success me-2"></i> School Leaving Certificate</li>
                                            <li><i class="bi bi-check2 text-success me-2"></i> Aadhaar Card</li>
                                            <li><i class="bi bi-check2 text-success me-2"></i> Passport Photo</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="feature-card h-100">
                                        <div class="card-icon">
                                            <i class="bi bi-shield-check"></i>
                                        </div>
                                        <h5 class="card-title">Important Notes</h5>
                                        <ul class="list-unstyled mb-0">
                                            <li><i class="bi bi-exclamation-triangle text-warning me-2"></i> All documents must be under 1MB</li>
                                            <li><i class="bi bi-exclamation-triangle text-warning me-2"></i> Only PDF, JPG, PNG formats</li>
                                            <li><i class="bi bi-exclamation-triangle text-warning me-2"></i> Fill all required fields</li>
                                            <li><i class="bi bi-exclamation-triangle text-warning me-2"></i> Double-check your information</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 