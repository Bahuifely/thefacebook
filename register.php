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
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Register | thefacebook</title>
<link rel="stylesheet" href="<?php echo BASE_PATH; ?>/css/style.css">
<script>
        // use same allowed domains from server to keep client/server in sync
        const universityDomains = <?php echo json_encode($allowed_domains, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;

        function validateEmail() {
            const email = document.getElementById('email').value;
            const emailError = document.getElementById('email-error');
            
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
<body class="login-page">
    <div class="topbar">
        <div class="wrap">
            <div class="nav-center">
                <a href="<?php echo BASE_PATH; ?>/login.php">login</a> |
                <a href="<?php echo BASE_PATH; ?>/register.php">register</a> |
                <a href="<?php echo BASE_PATH; ?>/contact.php">Contact</a>
            </div>

            <a href="<?php echo BASE_PATH; ?>/" class="logo">[ thefacebook ]</a>

            <div class="nav-avatar" aria-hidden="true">
                <img src="<?php echo BASE_PATH; ?>/images/avatar.jpeg" alt="avatar">
            </div>
        </div>
    </div>

    <div class="page" role="main">
        <div class="left-col" aria-label="register column">
            

            <!-- removed form from left column so left column shows only avatar -->
        </div>

        <div class="main-panel" aria-label="welcome panel">
            <div class="panel-header">¡Bienvenido a Thefacebook!</div>
            <div class="panel-body">

                <!-- MOVED: registration box placed inside center panel and centered -->
                <div class="register-box" role="form" aria-labelledby="register-title">
                    <h3 id="register-title" style="font-size:14px;margin:0 0 8px 0;color:#2f4f7d;">Registro</h3>

                    <?php if ($error): ?>
                        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="message success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo BASE_PATH; ?>/register.php" onsubmit="return validateForm()" style="margin:0;">
                        <label for="name">Full Name:</label>
                        <input id="name" type="text" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>

                        <label for="email">University Email:</label>
                        <input id="email" type="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required onblur="validateEmail()">
                        <div id="email-error" style="color:#c00;font-size:10px;margin-top:3px;display:none;"></div>
                        <small style="color:#666;display:block;margin-bottom:6px;">Must be from a university domain</small>

                        <label for="school">School/University:</label>
                        <input id="school" type="text" name="school" value="<?php echo isset($school) ? htmlspecialchars($school) : ''; ?>" placeholder="e.g., Universidad del Valle de Guatemala">

                        <label for="sex">Sex:</label>
                        <select id="sex" name="sex">
                            <option value="">Select...</option>
                            <option value="Male"<?php if (isset($sex) && $sex==='Male') echo ' selected'; ?>>Male</option>
                            <option value="Female"<?php if (isset($sex) && $sex==='Female') echo ' selected'; ?>>Female</option>
                        </select>

                        <label for="password">Password:</label>
                        <input id="password" type="password" name="password" required minlength="6">

                        <label for="confirm_password">Confirm Password:</label>
                        <input id="confirm_password" type="password" name="confirm_password" required>

                        <div class="login-actions register-actions" style="margin-top:8px;">
                            <button type="submit" class="btn-small">Register</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
