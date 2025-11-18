<?php
require_once 'config/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creators | thefacebook</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php if (isLoggedIn()): ?>
    <!-- Header for logged in users -->
    <div class="header">
        <div class="header-content">
            <a href="/" class="logo">thefacebook</a>
            <div class="nav">
                <a href="/">home</a>
                <a href="/search.php">search</a>
                <a href="/team.php">creators</a>
                <a href="/logout.php">logout</a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="team-container">
        <div class="team-header">
            <h1>The Creators</h1>
            <p style="color: #666; font-size: 13px;">Meet the team behind this thefacebook clone</p>
        </div>

        <div class="team-members">
            <!-- Team Member 1 -->
            <div class="team-member">
                <div class="member-photo">
                    <img src="/images/team-member-1.jpg" alt="Team Member 1">
                </div>
                <div class="member-name">Your Name Here</div>
                <div class="member-role">Lead Developer</div>
                <div style="margin-top: 10px; font-size: 11px; color: #666;">
                    Full-stack development<br>
                    Database design
                </div>
            </div>

            <!-- Team Member 2 -->
            <div class="team-member">
                <div class="member-photo">
                    <img src="/images/team-member-2.jpg" alt="Team Member 2">
                </div>
                <div class="member-name">Team Member 2</div>
                <div class="member-role">Frontend Developer</div>
                <div style="margin-top: 10px; font-size: 11px; color: #666;">
                    UI/UX Design<br>
                    CSS Styling
                </div>
            </div>

            <!-- Team Member 3 -->
            <div class="team-member">
                <div class="member-photo">
                    <img src="/images/team-member-3.jpg" alt="Team Member 3">
                </div>
                <div class="member-name">Team Member 3</div>
                <div class="member-role">Backend Developer</div>
                <div style="margin-top: 10px; font-size: 11px; color: #666;">
                    PHP Development<br>
                    Security Implementation
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #d3d6db;">
            <p style="color: #666; font-size: 11px;">
                This is a recreation of the original thefacebook from 2004-2005<br>
                Built with PHP, MySQL, HTML, CSS, and JavaScript
            </p>
            <?php if (!isLoggedIn()): ?>
            <p style="margin-top: 15px;">
                <a href="/login.php" style="color: #3b5998; text-decoration: none;">← Back to Login</a>
            </p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
