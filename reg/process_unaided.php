<?php
// process_unaided.php
session_start();
require 'db_connect.php';

if (isset($_POST['unaidedRegNo'])) {
    $reg_no = trim($_POST['unaidedRegNo']);

    $sql = "SELECT * FROM existstudents WHERE registration_number = :reg_no AND registration_type = 'unaided'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':reg_no' => $reg_no]);
    $student = $stmt->fetch();

    if ($student) {
        $_SESSION['registration_number'] = $student['registration_number'];
        $_SESSION['student_name'] = $student['name_of_student'];
        $_SESSION['registration_type'] = $student['registration_type'];
        
        echo "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Student Details - Unaided</title><link rel='stylesheet' href='assets/modern-theme.css'></head><body>";
        ?>
        <div class="container">
            <div class="card fade-in">
                <div class="card-header">
                    <h1 class="card-title">
                        <i class="fas fa-user-graduate"></i>
                        Student Details (Unaided)
                    </h1>
                    <p class="card-subtitle">Registration confirmed successfully</p>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <i class="fas fa-info-circle"></i>
                                    Field
                                </th>
                                <th>
                                    <i class="fas fa-user"></i>
                                    Details
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <i class="fas fa-user"></i>
                                    <strong>Name</strong>
                                </td>
                                <td><?php echo htmlspecialchars($student['name_of_student']); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fas fa-graduation-cap"></i>
                                    <strong>Class</strong>
                                </td>
                                <td><?php echo htmlspecialchars($student['class']); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fas fa-tag"></i>
                                    <strong>Registration Type</strong>
                                </td>
                                <td>
                                    <span class="badge badge-primary">
                                        <?php echo htmlspecialchars($student['registration_type']); ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fas fa-layer-group"></i>
                                    <strong>Division</strong>
                                </td>
                                <td><?php echo htmlspecialchars($student['division']); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fas fa-id-card"></i>
                                    <strong>Registration Number</strong>
                                </td>
                                <td class="font-mono font-bold"><?php echo htmlspecialchars($student['registration_number']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-8">
                    <a href="fees_unaided.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-credit-card"></i>
                        Proceed to Fees Structure
                    </a>
                    
                    <a href="index.php" class="btn btn-outline btn-lg ml-4">
                        <i class="fas fa-arrow-left"></i>
                        Back to Portal
                    </a>
                </div>

                <!-- Success Message -->
                <div class="mt-8 p-6 bg-green-50 rounded-lg border border-green-200">
                    <h3 class="text-lg font-bold mb-4 text-green-800">
                        <i class="fas fa-check-circle"></i>
                        Registration Successful!
                    </h3>
                    <p class="text-green-700">
                        Your registration has been confirmed. You can now proceed to view the fee structure and make payments.
                    </p>
                </div>
            </div>
        </div>
        <?php
        echo "</body></html>";
    } else {
        header("Location: index.php?error=invalid_reg");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
