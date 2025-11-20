<?php
require_once 'config/session.php';
require_once 'config/database.php';

// If already logged in, redirect to index (use BASE_PATH)
if (isLoggedIn()) {
    header('Location: ' . BASE_PATH . '/login.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $conn = getConnection();
        
        $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Plain text password comparison (as per requirements)
            if ($password === $user['password']) {
                // Use session helper to log in and redirect to index
                loginUser($user['id'], $user['email']);
                header('Location: ' . BASE_PATH . '/login.php');
                exit();
            } else {
                $error = 'Invalid email or password.';
            }
        } else {
            $error = 'Invalid email or password.';
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
<title>Login | thefacebook</title>
<!-- FIXED: añadida la barra '/' entre BASE_PATH y css -->
<link rel="stylesheet" href="<?php echo BASE_PATH; ?>/css/style.css">
</head>
<body>
    <div class="topbar">
    
    <div class="wrap">

            <div class="nav-center">
                <a href="<?php echo BASE_PATH; ?>/index.php">login</a> |
                <a href="<?php echo BASE_PATH; ?>/register.php">register</a> |
                <a href="<?php echo BASE_PATH; ?>/contact.php">Contact</a>
           <!-- NEW: avatar en navbar (div separado para poder controlar tamaño) -->
            </div>

            <a href="<?php echo BASE_PATH; ?>/" class="logo">[ thefacebook ]</a>
            <div class="nav-avatar" aria-hidden="true">
                <img src="<?php echo BASE_PATH; ?>/images/avatar.jpeg" alt="avatar">
            </div>
            
        </div>
    </div>

    <div class="page">
        <div class="left-col">
            
            <div class="login-box">
                <?php if ($error): ?>
                    <div class="message error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="message success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>

                <form method="POST" action="<?php echo BASE_PATH; ?>/index.php" style="margin:0;">
                    <label for="email">Email:</label>
                    <input id="email" type="email" name="email" required>

                    <label for="password">Password:</label>
                    <input id="password" type="password" name="password" required>

                    <div class="login-actions" style="margin-top:6px;">
                        <button type="submit" class="btn-small">login</button>
                        <a href="<?php echo BASE_PATH; ?>/register.php"><button type="button" class="btn-small secondary">register</button></a>
                    </div>
                </form>
            </div>
        </div>

        <div class="main-panel">
            <div class="panel-header">Welcome to Thefacebook!</div>
            <div class="panel-body">
                <h2>[ Welcome to Thefacebook ]</h2>
                <p>Thefacebook is an online directory that connects people through social networks at colleges.</p>

                <p>We have opened up Thefacebook for popular consumption at <strong>Universidad del Valle de Guatemala University.</strong></p>

                <p>You can use Thefacebook to:</p>

                <ul class="features">
                    <li>Search for people at your school</li>
                    <li>Find out who are in your classes</li>
                    <li>Look up your friends' friends</li>
                    <li>See a visualization of your social network</li>
                </ul>

                <p>To get started, click below to register. If you have already registered, you can log in.</p>

                <div class="panel-actions">
                    <a href="<?php echo BASE_PATH; ?>/register.php"><button class="btn">Register</button></a>
                    <a href="<?php echo BASE_PATH; ?>/index.php"><button class="btn">Login</button></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
