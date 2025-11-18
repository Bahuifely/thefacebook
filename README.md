# thefacebook Clone

A recreation of the original thefacebook (2004-2005) using PHP, MySQL, HTML, CSS, and JavaScript.

## Features

- User registration with university email validation
- Secure login with session management
- Profile pages displaying user information
- Team/creators page
- Classic 2004 thefacebook design

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server

## Installation

### 1. Database Setup

Import the database schema:

\`\`\`bash
mysql -u root -p < scripts/database-setup.sql
\`\`\`

Or manually run the SQL from `scripts/database-setup.sql` in your MySQL client.

### 2. Configure Database Connection

Edit `config/database.php` and update the database credentials:

\`\`\`php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'thefacebook');
\`\`\`

### 3. Upload Files

Upload all files to your web server's public directory (e.g., `public_html`, `www`, or `htdocs`).

### 4. Set Permissions

Make sure the web server has read access to all files:

\`\`\`bash
chmod -R 755 /path/to/your/project
\`\`\`

### 5. Create Images Directory

Create an images directory for user avatars and team photos:

\`\`\`bash
mkdir images
chmod 755 images
\`\`\`

Add default avatar and team member photos to the `images` directory.

## File Structure

\`\`\`
/
├── config/
│   ├── database.php       # Database connection and email validation
│   └── session.php         # Session management functions
├── css/
│   └── style.css          # Main stylesheet
├── images/                # User avatars and team photos
├── scripts/
│   └── database-setup.sql # Database schema
├── index.php              # Main profile page (requires login)
├── login.php              # Login page
├── register.php           # Registration page
├── team.php               # Team/creators page
├── logout.php             # Logout handler
└── README.md              # This file
\`\`\`

## University Email Validation

The system validates that users register with university email addresses. Allowed domains are configured in `config/database.php`:

- uvg.edu.gt (Universidad del Valle de Guatemala)
- harvard.edu
- stanford.edu
- mit.edu
- And other university domains...

You can add more domains to the `$allowed_domains` array.

## Security Notes

**IMPORTANT**: This project stores passwords in plain text as per the original requirements. This is **NOT secure** and should **NEVER** be used in production. For a real application, always use PHP's `password_hash()` and `password_verify()` functions.

## Deployment

### Free Hosting Options:

1. **InfinityFree** (https://infinityfree.net)
   - Free PHP and MySQL hosting
   - No ads on free tier
   - Good for testing

2. **000webhost** (https://www.000webhost.com)
   - Free PHP and MySQL
   - Easy setup

3. **Heroku** (with ClearDB MySQL add-on)
   - Free tier available
   - Requires more configuration

### Deployment Steps:

1. Sign up for a free hosting account
2. Create a MySQL database
3. Import the `database-setup.sql` file
4. Upload all PHP files via FTP or file manager
5. Update `config/database.php` with your database credentials
6. Access your site via the provided URL

## Usage

1. Go to `/register.php` to create an account with a university email
2. After registration, login at `/login.php`
3. View your profile at `/index.php`
4. Visit `/team.php` to see the creators

## Customization

### Update Team Members:

Edit `team.php` and modify the team member information:

\`\`\`php
<div class="member-name">Your Name</div>
<div class="member-role">Your Role</div>
\`\`\`

Add team member photos to `/images/` directory.

### Change Logo/Branding:

Edit the header section in each PHP file or modify the `.logo` class in `css/style.css`.

## Credits

Original thefacebook design by Mark Zuckerberg (2004)
Recreated as an educational project

## License

This is an educational project. The original thefacebook design is property of Meta/Facebook.
