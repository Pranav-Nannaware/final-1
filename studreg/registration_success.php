<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the main configuration file for proper database connection
require_once 'includes/config.php';

// Check if ID was passed in URL
$studentId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get student information if ID is provided
$studentInfo = null;
if ($studentId > 0 && isset($db)) {
    try {
        $sql = "SELECT full_name, email, mobile_number, dob, program_interest, institution_type FROM student_register WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$studentId]);
        
        if ($stmt->rowCount() > 0) {
            $studentInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        error_log("Error fetching student info: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful - Bharat English School & Junior College</title>
    
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

        .text-accent {
            color: #3F5EFB !important;
        }

        .success-checkmark {
            font-size: 5rem;
            color: #28a745;
            margin-bottom: 1.5rem;
        }
        
        .success-message {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .campus-card {
            margin-top: 3rem;
        }
        
        .student-info {
            background: rgba(40, 167, 69, 0.1);
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 2rem;
            text-align: left;
        }
        
        .student-info p {
            margin-bottom: 0.5rem;
        }
        
        .student-info strong {
            color: var(--accent);
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .info-item {
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 8px;
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
                            <div class="success-message">
                                <div class="success-checkmark">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <h1 class="campus-heading">Registration Successful!</h1>
                                <p class="mb-4">Thank you for registering with Bharat English School & Junior College. Your information has been successfully submitted and stored in our system.</p>
                                
                                <?php if ($studentInfo): ?>
                                <div class="student-info">
                                    <h3 class="text-accent mb-3">Your Registration Details</h3>
                                    <div class="info-grid">
                                        <div class="info-item">
                                            <p><strong>Registration ID:</strong> <?php echo $studentId; ?></p>
                                        </div>
                                        <div class="info-item">
                                            <p><strong>Name:</strong> <?php echo htmlspecialchars($studentInfo['full_name']); ?></p>
                                        </div>
                                        <div class="info-item">
                                            <p><strong>Email:</strong> <?php echo htmlspecialchars($studentInfo['email']); ?></p>
                                        </div>
                                        <div class="info-item">
                                            <p><strong>Mobile:</strong> <?php echo htmlspecialchars($studentInfo['mobile_number']); ?></p>
                                        </div>
                                        <div class="info-item">
                                            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($studentInfo['dob']); ?></p>
                                        </div>
                                        <div class="info-item">
                                            <p><strong>Optional Subject:</strong> <?php echo htmlspecialchars($studentInfo['program_interest']); ?></p>
                                        </div>
                                        <div class="info-item">
                                            <p><strong>Institution Type:</strong> <?php echo htmlspecialchars($studentInfo['institution_type']); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-info mt-3">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <strong>Important:</strong> Please keep your Registration ID (<strong><?php echo $studentId; ?></strong>) for future reference. You will need this for any follow-up communications.
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    Student information not found. This may be due to an invalid ID or database error.
                                </div>
                                <?php endif; ?>
                                
                                <div class="mt-5">
                                    <h4>What's Next?</h4>
                                    <div class="row mt-4 justify-content-center">
                                        <div class="col-md-6">
                                            <div class="card border-0 h-100" style="background: rgba(255, 255, 255, 0.1);">
                                                <div class="card-body text-center">
                                                    <i class="bi bi-calendar-check h2 text-success"></i>
                                                    <h5>Follow-up Process</h5>
                                                    <p class="small">Our admission team will contact you within 2-3 business days.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 d-flex justify-content-center gap-3 flex-wrap">
                                        <a href="registration.php" class="campus-btn campus-btn-outline">
                                            <i class="bi bi-plus-circle me-2"></i> New Registration
                                        </a>
                                        <a href="registration.php" class="campus-btn">
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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add subtle animation to success elements
            const successCard = document.querySelector('.success-message');
            if (successCard) {
                successCard.style.opacity = '0';
                successCard.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    successCard.style.transition = 'all 0.6s ease-out';
                    successCard.style.opacity = '1';
                    successCard.style.transform = 'translateY(0)';
                }, 100);
            }
        });
    </script>
</body>
</html> 
