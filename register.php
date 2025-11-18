<?php
require_once 'config/session.php';
require_once 'config/database.php';

// If already logged in, redirect to home
if (isLoggedIn()) {
    header('Location: /index.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $school = trim($_POST['school'] ?? '');
    $sex = $_POST['sex'] ?? '';
    
    // Validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif (!isUniversityEmail($email)) {
        $error = 'You must register with a university email address.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } else {
        $conn = getConnection();
        
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = 'An account with this email already exists.';
        } else {
            // Insert new user (password in plain text as per requirements)
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, school, sex) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $password, $school, $sex);
            
            if ($stmt->execute()) {
                $success = 'Registration successful! You can now login.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | thefacebook</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        function validateEmail() {
            const email = document.getElementById('email').value;
            const emailError = document.getElementById('email-error');
            
            // University domains
            const universityDomains = [
                'uvg.edu.gt',
                'edu.gt',
                'harvard.edu',
                'stanford.edu',
                'mit.edu',
                'berkeley.edu',
                'yale.edu',
                'columbia.edu',
                'cornell.edu',
                'princeton.edu'
            ];
            
            const domain = email.substring(email.lastIndexOf("@") + 1);
            let isUniversity = false;
            
            for (let i = 0; i < universityDomains.length; i++) {
                if (domain === universityDomains[i] || domain.endsWith('.' + universityDomains[i])) {
                    isUniversity = true;
                    break;
                }
            }
            
            if (!isUniversity && email.includes('@')) {
                emailError.textContent = 'You must use a university email address.';
                emailError.style.display = 'block';
                return false;
            } else {
                emailError.style.display = 'none';
                return true;
            }
        }

        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return false;
            }
            
            return validateEmail();
        }
    </script>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>thefacebook</h1>
            <p>Register - You must have a university email</p>
        </div>

        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>University Email:</label>
                <input type="email" id="email" name="email" required onblur="validateEmail()">
                <div id="email-error" style="color: #c00; font-size: 10px; margin-top: 3px; display: none;"></div>
                <small style="color: #666;">Must be from uvg.edu.gt or other university domain</small>
            </div>

            <div class="form-group">
                <label>School/University:</label>
                <input type="text" name="school" placeholder="e.g., Universidad del Valle de Guatemala">
            </div>

            <div class="form-group">
                <label>Sex:</label>
                <select name="sex">
                    <option value="">Select...</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" id="password" name="password" required minlength="6">
                <small style="color: #666;">At least 6 characters</small>
            </div>

            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Register</button>
            </div>
        </form>

        <p style="text-align: center; margin-top: 20px;">
            Already have an account? <a href="login.php" style="color: #3b5998;">Login here</a>
        </p>
    </div>
</body>
</html>
