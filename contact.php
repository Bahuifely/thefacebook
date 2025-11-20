<?php
require_once 'config/session.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Contact | thefacebook</title>
<link rel="stylesheet" href="<?php echo (defined('BASE_PATH') ? BASE_PATH : ''); ?>/css/style.css">
</head>
<body class="login-page">
  <div class="topbar">
    <div class="wrap">
      <div class="nav-center">
        <a href="<?php echo (defined('BASE_PATH') ? BASE_PATH : ''); ?>/login.php">Login</a> |
        <a href="<?php echo (defined('BASE_PATH') ? BASE_PATH : ''); ?>/register.php">Register</a> |
        <a href="<?php echo (defined('BASE_PATH') ? BASE_PATH : ''); ?>/contact.php">Contact</a>
      </div>

      <a href="<?php echo (defined('BASE_PATH') ? BASE_PATH : ''); ?>/" class="logo">[ thefacebook ]</a>

      <div class="nav-avatar" aria-hidden="true">
        <img src="<?php echo (defined('BASE_PATH') ? BASE_PATH : ''); ?>/images/avatar.jpeg" alt="avatar">
      </div>
    </div>
  </div>

  <div class="page" role="main">
    <div class="left-col" aria-hidden="true">

    </div>

    <div class="main-panel" aria-label="contact panel">
      <div class="panel-header">Contacto del Desarrollador</div>
      <div class="panel-body">
        <div class="contact-card">
          <div class="contact-photo">
            <img src="<?php echo (defined('BASE_PATH') ? BASE_PATH : ''); ?>/images/avatar.jpeg" alt="Developer">
          </div>
          <div class="contact-info">
            <h3>Felisa Ixchel Barreno Huinac</h3>
            <p><strong>Rol:</strong> Desarrollador web</p>
            <p><strong>Email:</strong> <a href="mailto:fely@example.com">fely@uvg.edu.gt</a></p>
            <p><strong>Tel:</strong> +502 5543 5678</p>
            <p><strong>Sobre:</strong> Desarrollo y mantenimiento del proyecto Thefacebook.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>