🔐 PHP Authentication & OTP Verification System

A simple PHP authentication system with email-based 6-digit OTP verification using PHPMailer and MySQL.

This project demonstrates how to build a login system where users must provide valid login credentials and then verify a one-time password (OTP) sent to their email before accessing the protected area.

✨ Features
🔑 User login with email and password
🔐 Password verification using PHP's password_verify()
📧 6-digit verification code sent through email
🔢 Numeric OTP validation
⏱️ OTP expiration after 10 minutes
🔒 OTP stored as a password hash in the session
📬 PHPMailer SMTP integration
🗄️ MySQL database integration using PDO
🛡️ Prepared SQL statements
⚠️ Session-based error handling
🎨 Responsive login and verification interface
🖼️ HTML email template with embedded logo
📱 Bootstrap 5 interface
🔌 Database connection testing page
🛠️ Technologies Used
Technology	Purpose
PHP	Backend and authentication logic
MySQL	User account database
PDO	Database connection and prepared statements
PHPMailer	Sending verification emails
Bootstrap 5	User interface
Composer	PHP dependency management
SMTP	Email delivery
HTML/CSS	Frontend structure and styling
🔄 Authentication Flow

The authentication process follows this flow:

User
  │
  ▼
Login Page
  │
  ├── Email + Password
  │
  ▼
Authenticate User
  │
  ├── Invalid credentials
  │       │
  │       └──► Return to Login
  │
  ▼
Generate 6-Digit OTP
  │
  ▼
Hash OTP
  │
  ▼
Store OTP + Expiration in Session
  │
  ▼
Send OTP via PHPMailer
  │
  ▼
Verification Page
  │
  ├── Invalid OTP
  │       │
  │       └──► Show Error
  │
  ├── Expired OTP
  │       │
  │       └──► Show Error
  │
  ▼
Verify OTP
  │
  ▼
Create Authenticated Session
  │
  ▼
Dashboard

The current implementation generates the OTP using PHP's random_int() and stores a hashed version of the code in the session. The verification code expires after 10 minutes.

📁 Project Structure
php-auth-otp-system/
│
├── assets/
│   └── images/
│       ├── logo.png
│       └── seal.png
│
├── config/
│   └── database.php
│
├── includes/
│   └── mailer.php
│
├── public/
│   └── index.php
│
├── src/
│   └── ha.php
│
├── vendor/
│
├── authenticate.php
├── composer.json
├── composer.lock
├── login.php
├── test_connection.php
└── verify.php
📌 Main Files
login.php

Displays the login interface where users enter their email address and password.

authenticate.php

Processes the login request.

It:

Validates the submitted credentials.
Searches for the user in the MySQL database.
Verifies the password.
Generates a 6-digit OTP.
Hashes the OTP.
Stores the verification information in the PHP session.
Sends the OTP through PHPMailer.
Redirects the user to the verification page.
verify.php

Handles the 6-digit OTP verification.

The system checks:

Whether the verification session exists
Whether the OTP contains exactly 6 digits
Whether the OTP has expired
Whether the submitted OTP matches the hashed OTP

After successful verification, the user's authenticated session is created and the user is redirected to the dashboard.

includes/mailer.php

Contains the PHPMailer configuration and email template used to send the verification code.

The email uses an HTML layout and can embed the project logo directly into the email.

config/database.php

Contains the PDO connection configuration for the MySQL database.

test_connection.php

A simple utility for testing the MySQL database connection and checking the number of users in the users table.

🚀 Installation
1. Clone the Repository
git clone https://github.com/ekingthegreat/php-auth-otp-system.git

Navigate into the project:

cd php-auth-otp-system
2. Install PHP Dependencies

Make sure Composer is installed, then run:

composer install

Note: Configure PHPMailer as a Composer dependency before running the project if it is not already installed in your local vendor directory.

3. Create the Database

Create a MySQL database named:

login_system

Create the required users table with the following structure:

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
4. Configure the Database

Open:

config/database.php

Configure the database connection according to your local MySQL setup:

$host = 'localhost';
$dbname = 'login_system';
$username = 'root';
$password = '';

Change the values if your MySQL configuration is different.

5. Configure SMTP

The application uses PHPMailer with SMTP to send the 6-digit verification code.

Configure your SMTP credentials in the mailer configuration.

Do not commit real SMTP passwords, API keys, or other credentials to GitHub.

For production use, credentials should be stored using environment variables or another secure secret-management method.

6. Start Your Local Server

If you're using XAMPP:

Start Apache.
Start MySQL.
Place the project inside the XAMPP htdocs directory.
Make sure the database is available.
Open the project through your local server.

Example:

http://localhost/php-auth-otp-system/login.php
7. Test the Database Connection

Open:

http://localhost/php-auth-otp-system/test_connection.php

A successful connection should display:

✓ Database Connection Successful!
📧 OTP Verification

When a user successfully enters their email and password:

The system generates a random 6-digit OTP.
The OTP is hashed before being stored in the session.
The OTP is sent to the user's email through PHPMailer.
The user enters the OTP on the verification page.
The submitted OTP is verified against the stored hash.
The OTP expires after 10 minutes.
After successful verification, the user is authenticated.

Example:

Your verification code is:

482731

This code expires in 10 minutes.
🔒 Security Considerations

This project uses several security-related PHP practices:

Passwords are verified using password_verify().
OTPs are generated using random_int().
OTPs are stored as hashes rather than plain text.
OTP expiration is enforced.
SQL queries use PDO prepared statements.
User-facing session errors are escaped using htmlspecialchars().
SMTP credentials should be kept outside the public repository.
⚠️ Important

This project is intended primarily as a learning and development project. Before using it in a production environment, additional security measures should be considered, including:

CSRF protection
Login rate limiting
OTP attempt limits
Session ID regeneration
Secure cookie configuration
Environment-based secrets
HTTPS
Password reset functionality
Account lockout or throttling
Production error logging
🎨 User Interface

The login and verification pages use Bootstrap 5 with a custom rounded-card interface.

The project uses a red-based visual design with:

Primary:      #b30000
Primary Dark: #8a0000

The verification page provides a dedicated 6-digit OTP input with numeric input support for mobile devices.

🧪 Development

This project is currently structured as a lightweight PHP application and can be developed locally using:

XAMPP
Apache
MySQL
PHP
Composer
📚 Learning Objectives

This project was created to practice:

PHP authentication
MySQL database integration
PDO prepared statements
Password hashing
Session management
OTP generation
Email verification
PHPMailer SMTP configuration
HTML email design
Bootstrap 5
Composer dependency management
🔮 Possible Future Improvements

User registration

Password reset via email

Resend OTP functionality

OTP attempt limit

Login rate limiting

CSRF protection

Remember-me functionality

User dashboard

Logout functionality

Environment variable configuration

Improved session security

Automated tests

Docker support

👨‍💻 Author

ekingthegreat

GitHub:
https://github.com/ekingthegreat
