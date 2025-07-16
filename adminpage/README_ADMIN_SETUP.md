# Admin Login System Setup Guide

This guide will help you set up the secure admin login system for the Student Management System.

## Features

- **Secure Authentication**: Password hashing and session management
- **Session Timeout**: Automatic logout after 8 hours of inactivity
- **SQL Injection Protection**: Prepared statements for all database queries
- **Modern UI**: Responsive design with beautiful gradients and animations
- **User Management**: Easy admin account creation and management

## Setup Instructions

### 1. Database Setup

First, ensure your database is properly configured in `includes/db_config.php`:

```php
$host = 'localhost';
$username = 'your_db_username';
$password = 'your_db_password';
$database = 'your_database_name';
```

### 2. Create Admin Account

**Option A: Using the Setup Script (Recommended)**

1. Navigate to `setup_admin.php` in your browser
2. Fill in the required information:
   - Username (unique)
   - Full Name
   - Email (optional)
   - Password (minimum 6 characters)
   - Confirm Password
3. Click "Create Admin Account"
4. The system will automatically create the `admin_users` table and your first admin account

**Option B: Manual Database Setup**

1. Run the SQL script `setup_admin_users.sql` in your database
2. This creates the table and adds a default admin user:
   - Username: `admin`
   - Password: `admin123`

### 3. Access the System

1. Navigate to `login.php` in your browser
2. Enter your credentials
3. You'll be redirected to the main dashboard

## File Structure

```
adminpage/
├── login.php              # Login page
├── logout.php             # Logout handler
├── setup_admin.php        # Admin setup script
├── index.php              # Main dashboard (now protected)
├── includes/
│   ├── auth.php           # Authentication helper functions
│   └── db_config.php      # Database configuration
├── setup_admin_users.sql  # SQL script for manual setup
└── README_ADMIN_SETUP.md  # This file
```

## Security Features

### Password Security
- Passwords are hashed using PHP's `password_hash()` function
- Uses bcrypt algorithm with cost factor 10
- Salt is automatically generated and stored with the hash

### Session Security
- Sessions are automatically started on all protected pages
- Session timeout after 8 hours of inactivity
- Session cookies are properly destroyed on logout
- Session fixation protection

### SQL Injection Protection
- All database queries use prepared statements
- User input is properly sanitized
- Parameter binding prevents SQL injection attacks

### XSS Protection
- All user output is escaped using `htmlspecialchars()`
- Form values are properly sanitized

## Usage

### Login
- Access `login.php` to log in
- Enter your username and password
- You'll be redirected to the dashboard upon successful login

### Dashboard Access
- The main dashboard (`index.php`) now requires authentication
- If not logged in, you'll be redirected to the login page
- The dashboard shows the logged-in admin's name and a logout button

### Logout
- Click the "Logout" button in the top-right corner
- Or navigate directly to `logout.php`
- All session data will be cleared

## Adding More Admin Users

### Through Setup Script
1. Access `setup_admin.php`
2. Create additional admin accounts as needed

### Through Database
```sql
INSERT INTO admin_users (username, password_hash, full_name, email) 
VALUES ('newadmin', '$2y$10$...', 'New Admin', 'newadmin@example.com');
```

To generate a password hash in PHP:
```php
echo password_hash('your_password', PASSWORD_DEFAULT);
```

## Troubleshooting

### Common Issues

1. **"Connection failed" error**
   - Check your database configuration in `includes/db_config.php`
   - Ensure MySQL/MariaDB is running
   - Verify database credentials

2. **"Table doesn't exist" error**
   - Run the setup script at `setup_admin.php`
   - Or manually execute `setup_admin_users.sql`

3. **Login not working**
   - Verify the admin_users table exists
   - Check that the user account is active (`is_active = 1`)
   - Ensure password was properly hashed

4. **Session issues**
   - Check PHP session configuration
   - Ensure cookies are enabled in the browser
   - Verify session storage permissions

### Security Recommendations

1. **Change Default Password**: If using the default admin account, change the password immediately
2. **Use HTTPS**: Deploy on HTTPS in production
3. **Regular Updates**: Keep PHP and MySQL updated
4. **Backup**: Regularly backup your database
5. **Monitor Logs**: Check server logs for suspicious activity

## Customization

### Styling
- Modify CSS in the respective PHP files
- Colors and styling can be adjusted in the `<style>` sections

### Session Timeout
- Edit the timeout value in `includes/auth.php`:
```php
$timeout = 8 * 60 * 60; // Change to desired seconds
```

### Password Requirements
- Modify validation in `setup_admin.php` and `login.php`
- Add additional password complexity requirements as needed

## Support

For issues or questions:
1. Check the troubleshooting section above
2. Verify all files are properly uploaded
3. Check server error logs
4. Ensure PHP version is 7.0 or higher

---

**Note**: This system is designed for educational institutions and should be deployed with appropriate security measures in production environments. 