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
    <title>Student Registration Portal</title>
    
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
            min-height: 100vh !important;
            display: flex !important;
            align-items: center !important;
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
            padding: 2rem !important;
        }

        /* Headings */
        .campus-heading {
            font-size: 2.5rem !important;
            font-weight: 700 !important;
            margin-bottom: 1rem !important;
            background: linear-gradient(to right, #FC466B, #3F5EFB) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        .campus-subheading {
            font-size: 1.4rem !important;
            font-weight: 600 !important;
            margin-bottom: 1rem !important;
            color: #3F5EFB !important;
        }

        /* Buttons */
        .campus-btn {
            background: linear-gradient(to right, #FC466B, #3F5EFB) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 1rem 2rem !important;
            color: white !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: inline-block !important;
            font-size: 1.1rem !important;
        }

        .campus-btn:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2) !important;
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

        /* Welcome content */
        .welcome-icon {
            font-size: 4rem !important;
            color: #3F5EFB !important;
            margin-bottom: 1.5rem !important;
        }

        .feature-list {
            list-style: none !important;
            padding: 0 !important;
            margin: 2rem 0 !important;
        }

        .feature-list li {
            padding: 0.75rem 0 !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
            display: flex !important;
            align-items: center !important;
        }

        .feature-list li:last-child {
            border-bottom: none !important;
        }

        .feature-list li i {
            color: #28a745 !important;
            margin-right: 1rem !important;
            font-size: 1.2rem !important;
        }

        .info-box {
            background: rgba(13, 202, 240, 0.1) !important;
            border: 2px solid #0dcaf0 !important;
            border-radius: 12px !important;
            padding: 1.5rem !important;
            margin: 2rem 0 !important;
        }

        @media (max-width: 768px) {
            .campus-heading {
                font-size: 2rem !important;
            }
            
            .campus-subheading {
                font-size: 1.2rem !important;
            }
            
            .welcome-icon {
                font-size: 3rem !important;
            }
            
            .campus-section {
                padding: 1.5rem !important;
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
                <div class="col-lg-8">
                    <div class="campus-card">
                        <div class="campus-section text-center">
                            <div class="welcome-icon">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                            
                            <h1 class="campus-heading">Welcome to Student Registration</h1>
                            <p class="lead text-muted mb-4">Complete your registration process for the upcoming academic year</p>
                            
                            <div class="info-box">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-info-circle-fill me-3" style="color: #0dcaf0; font-size: 1.5rem;"></i>
                                    <div>
                                        <h5 class="mb-1">Registration for Classes 11th & 12th Science </h5>
                                        <p class="mb-0">We are now accepting applications for Higher Secondary Education (Classes 11th and 12th Science) for the academic year 2024-25.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <h3 class="campus-subheading">What You'll Need</h3>
                            <ul class="feature-list text-start">
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Personal information and contact details</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Academic records and certificates</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Identity proof documents</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Digital copies of all required documents</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Stable internet connection</span>
                                </li>
                            </ul>
                            
                            <div class="mt-5">
                                <a href="instructions.php" class="campus-btn me-3">
                                    <i class="bi bi-arrow-right me-2"></i> Start Registration Process
                                </a>
                                <a href="../index.php" class="campus-btn campus-btn-outline">
                                    <i class="bi bi-house-fill me-2"></i> Back to Home
                                </a>
                            </div>
                            
                            <div class="mt-4">
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    Estimated completion time: 15-20 minutes
                                </small>
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
            // Add entrance animation
            const card = document.querySelector('.campus-card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
            
            // Add hover effects to buttons
            document.querySelectorAll('.campus-btn').forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                });
                
                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html> 