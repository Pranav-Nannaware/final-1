# Student Registration Portal - Standalone Module

This is a standalone version of the student registration module that can be run independently from the main website.

## Features

- Complete student registration form with multi-step process
- Document upload functionality (PDF, JPG, PNG)
- Form validation and error handling
- Responsive design with modern UI
- Database integration for storing student data
- Success and error pages with proper feedback

## Prerequisites

- PHP 7.4 or higher
- MySQL database
- Web server (Apache/Nginx)
- PDO extension enabled

## Installation

1. **Database Setup**
   - Create a MySQL database named `cmrit_db`
   - Create a user `cmrit_user` with password `test`
   - Import the required database schema (create the `student_register` table)

2. **Configuration**
   - Update database credentials in `includes/config.php` if needed
   - Ensure the uploads directory has write permissions

3. **File Structure**
   ```
   studregister_standalone/
   ├── assets/
   │   └── theme.css
   ├── includes/
   │   └── config.php
   ├── uploads/
   ├── index.php (Homepage)
   ├── registration.php (Main registration form)
   ├── process_registration.php
   ├── process_registration_direct.php
   ├── registration_success.php
   ├── registration_error.php
   ├── check_php_config.php
   └── README.md
   ```

## Usage

1. **Access the Portal**
   - Open `index.php` in your web browser
   - This serves as the main entry point

2. **Student Registration**
   - Click "New Student Registration" to start
   - Fill out the multi-step form with required information
   - Upload required documents (under 1MB each)
   - Review and submit the form

3. **System Check**
   - Use `check_php_config.php` to verify PHP configuration
   - Ensures all required extensions are available

## Required Documents

- 10th Standard Marksheet
- School Leaving Certificate  
- Aadhaar Card or Valid ID Proof
- Passport Size Photo
- Additional documents for reserved categories (if applicable)

## File Upload Requirements

- Maximum file size: 1MB per file
- Supported formats: PDF, JPG, JPEG, PNG
- Files are stored as BLOB in the database

## Database Schema

The module expects a table named `student_register` with the following key fields:
- Personal information (name, email, phone, etc.)
- Academic details (marks, percentage, etc.)
- Address information
- Document storage (BLOB fields)
- Timestamps

## Security Features

- Input validation and sanitization
- File type and size validation
- SQL injection prevention using prepared statements
- Session management
- Error logging

## Troubleshooting

1. **File Upload Issues**
   - Check PHP upload limits in `php.ini`
   - Ensure uploads directory permissions
   - Verify file size and format requirements

2. **Database Connection**
   - Verify database credentials in `config.php`
   - Check if database and table exist
   - Ensure PDO extension is enabled

3. **Permission Issues**
   - Set proper file permissions for uploads directory
   - Check web server configuration

## Customization

- Modify `assets/theme.css` for styling changes
- Update form fields in `registration.php`
- Adjust validation rules in processing files
- Configure database settings in `includes/config.php`

## Support

This is a standalone module extracted from the main CMR Institute website. It maintains all the original functionality while being completely self-contained.

For technical support, check the error logs and ensure all prerequisites are met. 