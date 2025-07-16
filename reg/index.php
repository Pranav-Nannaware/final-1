<?php
// index.php

// Start the session to generate and store the CSRF token
session_start();
if(empty($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check for error messages from recipt.php
$error_message = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
$show_toast = !empty($error_message);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Portal</title>
    <link rel="stylesheet" href="assets/modern-theme.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <!-- Main Registration Card -->
        <div class="card fade-in">
            <div class="card-header">
                <h1 class="card-title">
                    <i class="fas fa-graduation-cap"></i>
                    Student Registration Portal
                </h1>
                <p class="card-subtitle">Welcome to the CMRIT Student Registration System</p>
            </div>

            <!-- Registration Options -->
            <div class="text-center mb-8">
                <button id="reg12" class="btn btn-primary btn-lg">
                    <i class="fas fa-user-edit"></i>
                    Existing Registration (12th)
                </button>
            </div>

            <!-- Additional Options (Hidden by default) -->
            <div id="moreButtons" class="grid grid-cols-2 gap-6 mb-8" style="display: none;">
                <button id="aided" class="btn btn-outline btn-lg">
                    <i class="fas fa-hand-holding-heart"></i>
                    Aided Student
                </button>
                <button id="unaided" class="btn btn-outline btn-lg">
                    <i class="fas fa-user-graduate"></i>
                    Unaided Student
                </button>
            </div>
        </div>

        <!-- Registration Forms -->
        <div id="aidedForm" class="card slide-up" style="display: none;">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-hand-holding-heart"></i>
                    Aided Student Registration
                </h2>
                <p class="card-subtitle">Please enter your registration details</p>
            </div>
            
            <form action="process_aided.php" method="post" autocomplete="off" class="max-w-md mx-auto">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="form-group">
                    <label for="aidedRegNo" class="form-label">
                        <i class="fas fa-id-card"></i>
                        Registration Number
                    </label>
                    <input type="text" 
                           id="aidedRegNo" 
                           name="aidedRegNo" 
                           class="form-control"
                           pattern="[A-Za-z0-9]{4,12}" 
                           maxlength="4" 
                           placeholder="Enter your registration number" 
                           required 
                           autocomplete="off">
                </div>
                
                <button type="submit" class="btn btn-success btn-lg w-full">
                    <i class="fas fa-paper-plane"></i>
                    Register
                </button>
            </form>
        </div>

        <div id="unaidedForm" class="card slide-up" style="display: none;">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-user-graduate"></i>
                    Unaided Student Registration
                </h2>
                <p class="card-subtitle">Please enter your registration details</p>
            </div>
            
            <form action="process_unaided.php" method="post" enctype="multipart/form-data" autocomplete="off" class="max-w-md mx-auto">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="form-group">
                    <label for="unaidedRegNo" class="form-label">
                        <i class="fas fa-id-card"></i>
                        Registration Number
                    </label>
                    <input type="text" 
                           id="unaidedRegNo" 
                           name="unaidedRegNo" 
                           class="form-control"
                           pattern="[A-Za-z0-9]{4,12}" 
                           maxlength="4" 
                           placeholder="Enter your registration number" 
                           required 
                           autocomplete="off">
                </div>
                
                <button type="submit" class="btn btn-outline btn-lg w-full">
                    <i class="fas fa-paper-plane"></i>
                    Register
                </button>
            </form>
        </div>

        <!-- Receipt Printing Section -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-receipt"></i>
                    Print Receipt
                </h2>
                <p class="card-subtitle">Already registered? Print your receipt below</p>
            </div>
            
            <form action="recipt.php" method="get" autocomplete="off" class="max-w-md mx-auto">
                <?php 
                if (!isset($_SESSION['csrf_token'])) {
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                }
                ?>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="form-group">
                    <label for="reg_no" class="form-label">
                        <i class="fas fa-search"></i>
                        Registration Number
                    </label>
                    <input type="text" 
                           id="reg_no" 
                           name="reg_no" 
                           class="form-control"
                           pattern="[A-Za-z0-9]{3,12}" 
                           maxlength="12" 
                           placeholder="Enter your registration number" 
                           required 
                           autocomplete="off">
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg w-full">
                    <i class="fas fa-print"></i>
                    Print Receipt
                </button>
            </form>
        </div>
    </div>

    <!-- Toast message container -->
    <?php if ($show_toast): ?>
    <div id="toast" class="toast toast-error">
        <?php echo $error_message; ?>
    </div>
    <?php endif; ?>

    <script>
    $(document).ready(function(){
        // Show toast if there was an error
        <?php if($show_toast): ?>
        var toast = $("#toast");
        toast.addClass("show");
        setTimeout(function(){
            toast.removeClass("show");
        }, 5000); // Show for 5 seconds
        <?php endif; ?>
        
        // Toggle display of additional buttons for 12th registration
        $("#reg12").click(function(){
            $("#moreButtons").slideToggle("slow");
            // Hide any open forms
            $("#aidedForm, #unaidedForm").slideUp("slow");
        });
        
        // When clicking on the Aided button, display the aided registration form
        $("#aided").click(function(){
            // Hide the unaided form if visible
            $("#unaidedForm").slideUp("slow");
            // Toggle the aided form with slide effect
            $("#aidedForm").slideToggle("slow");
        });
        
        // When clicking on the Unaided button, display the unaided registration form
        $("#unaided").click(function(){
            // Hide the aided form if visible
            $("#aidedForm").slideUp("slow");
            // Toggle the unaided form with slide effect
            $("#unaidedForm").slideToggle("slow");
        });

        // Add loading states to buttons
        $('form').on('submit', function() {
            $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        });
    });
    </script>
</body>
</html>
