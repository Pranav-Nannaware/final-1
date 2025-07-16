<?php
// Start session to retrieve error message
session_start();

// Get error message
$errorMessage = isset($_SESSION['registration_error']) ? $_SESSION['registration_error'] : "An unknown error occurred during registration.";

// Clear error message
unset($_SESSION['registration_error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Error</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/theme.css?v=<?php echo time(); ?>">
    
    <style>
        /* CSS Variables fallback */
        :root {
            --success: #28a745;
            --accent: #3F5EFB;
            --error: #FC466B;
        }

        /* Ensure theme styling */
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

        .campus-container {
            position: relative !important;
            z-index: 1 !important;
            padding: 1.5rem !important;
        }

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

        .campus-heading {
            font-size: 1.8rem !important;
            font-weight: 700 !important;
            margin-bottom: 0.5rem !important;
            background: linear-gradient(to right, #FC466B, #3F5EFB) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

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

        .text-error {
            color: #FC466B !important;
        }

        .error-icon {
            font-size: 5rem;
            color: #FC466B;
            margin-bottom: 1.5rem;
        }
        
        .error-message {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .error-details {
            background: rgba(220, 53, 69, 0.1);
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 2rem;
            text-align: left;
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
                            <div class="error-message">
                                <div class="error-icon">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                </div>
                                <h1 class="campus-heading">Registration Error</h1>
                                <p class="mb-4">We encountered an issue while processing your registration. Please review the error details below.</p>
                                
                                <div class="error-details">
                                    <h3 class="text-error mb-3">Error Details</h3>
                                    <p><?php echo htmlspecialchars($errorMessage); ?></p>
                                </div>
                                
                                <div class="mt-5">
                                    <p>What would you like to do next?</p>
                                    <div class="mt-4 d-flex justify-content-center gap-3 flex-wrap">
                                        <a href="registration.php" class="campus-btn">
                                            <i class="bi bi-arrow-left me-2"></i> Return to Registration
                                        </a>
                                        <a href="registration.php" class="campus-btn campus-btn-outline">
                                            <i class="bi bi-house-door me-2"></i> Return to Home
                                        </a>
                                    </div>
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
</body>
</html> 