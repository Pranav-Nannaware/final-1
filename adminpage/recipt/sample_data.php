<?php
require_once 'db_config.php';

$conn = getDBConnection();

// Sample student data
$sample_students = array(
    array(
        'full_name' => 'John Doe',
        'father_name' => 'Robert Doe',
        'mother_name' => 'Mary Doe',
        'mobile_number' => '9876543210',
        'guardian_mobile_number' => '9876543211',
        'email' => 'john.doe@example.com',
        'dob' => '2005-06-15',
        'gender' => 'Male',
        'class' => '12th',
        'program_interest' => 'Computer Science',
        'institution_type' => 'Aided',
        'caste' => 'OC',
        'category' => 'General',
        'current_address' => '123 Main Street, Bangalore',
        'permanent_address' => '123 Main Street, Bangalore'
    ),
    array(
        'full_name' => 'Jane Smith',
        'father_name' => 'Michael Smith',
        'mother_name' => 'Sarah Smith',
        'mobile_number' => '9876543212',
        'guardian_mobile_number' => '9876543213',
        'email' => 'jane.smith@example.com',
        'dob' => '2005-08-20',
        'gender' => 'Female',
        'class' => '12th',
        'program_interest' => 'Information Technology',
        'institution_type' => 'Unaided',
        'caste' => 'BC',
        'category' => 'BC-A',
        'current_address' => '456 Park Avenue, Bangalore',
        'permanent_address' => '456 Park Avenue, Bangalore'
    ),
    array(
        'full_name' => 'Rajesh Kumar',
        'father_name' => 'Suresh Kumar',
        'mother_name' => 'Lakshmi Kumar',
        'mobile_number' => '9876543214',
        'guardian_mobile_number' => '9876543215',
        'email' => 'rajesh.kumar@example.com',
        'dob' => '2005-04-10',
        'gender' => 'Male',
        'class' => '12th',
        'program_interest' => 'Computer Science',
        'institution_type' => 'Aided',
        'caste' => 'SC',
        'category' => 'SC',
        'current_address' => '789 Gandhi Road, Bangalore',
        'permanent_address' => '789 Gandhi Road, Bangalore'
    )
);

echo "<h2>Inserting Sample Student Data</h2>";

foreach ($sample_students as $student) {
    $sql = "INSERT INTO student_register (
        full_name, father_name, mother_name, mobile_number, guardian_mobile_number, 
        email, dob, gender, class, program_interest, institution_type, 
        caste, category, current_address, permanent_address
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssss", 
        $student['full_name'],
        $student['father_name'],
        $student['mother_name'],
        $student['mobile_number'],
        $student['guardian_mobile_number'],
        $student['email'],
        $student['dob'],
        $student['gender'],
        $student['class'],
        $student['program_interest'],
        $student['institution_type'],
        $student['caste'],
        $student['category'],
        $student['current_address'],
        $student['permanent_address']
    );
    
    if ($stmt->execute()) {
        echo "<p>✓ Inserted: " . $student['full_name'] . " (" . $student['institution_type'] . ")</p>";
    } else {
        echo "<p>✗ Error inserting " . $student['full_name'] . ": " . $conn->error . "</p>";
    }
    
    $stmt->close();
}

echo "<h3>Sample data insertion completed!</h3>";
echo "<p><a href='receipt_generator.php'>Go to New Payment Receipt Generator</a></p>";

$conn->close();
?> 