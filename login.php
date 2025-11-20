<?php
require_once 'config/session.php';
require_once 'config/database.php';

// If not logged in, redirect to login
if (!isLoggedIn()) {
    header('Location: ' . BASE_PATH . '/index.php');
    exit();
}

// Get user data
$conn = getConnection();
$user_id = getUserId();

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    session_destroy();
    header('Location: ' . BASE_PATH . '/index.php');
    exit();
}

$stmt->close();
$conn->close();

// normalized variables & safe fallbacks
$name = htmlspecialchars($user['name'] ?? 'Profile');
$avatar = BASE_PATH . '/images/avatar.jpeg';
$school = htmlspecialchars($user['school'] ?? 'Puget Sound');
$status = htmlspecialchars($user['status'] ?? 'Student');
$member_since_raw = $user['member_since'] ?? $user['created_at'] ?? null;
$last_update_raw = $user['last_update'] ?? $user['updated_at'] ?? null;
$member_since = $member_since_raw ? date('F j, Y', strtotime($member_since_raw)) : date('F j, Y');
$last_update = $last_update_raw ? date('F j, Y', strtotime($last_update_raw)) : date('F j, Y');
$email = htmlspecialchars($user['email'] ?? '');
$about = htmlspecialchars($user['about'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?>'s Profile | thefacebook</title>
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>/css/style.css">
</head>
<body>
    <!-- Topbar -->
    <div class="topbar">
        <div class="wrap">
            <div class="nav-center">
                <a href="<?php echo BASE_PATH; ?>/">home</a>
                <a href="<?php echo BASE_PATH; ?>/">search</a>
                <a href="<?php echo BASE_PATH; ?>/">global</a>
                <a href="<?php echo BASE_PATH; ?>/">social net</a>
                <a href="<?php echo BASE_PATH; ?>/">invite</a>
                <a href="<?php echo BASE_PATH; ?>/">faq</a>
                <a href="<?php echo BASE_PATH; ?>/logout.php">logout</a>
            </div>
            <a href="<?php echo BASE_PATH; ?>/" class="logo">[ thefacebook ]</a>
            <div class="nav-avatar" aria-hidden="true">
                <img src="<?php echo BASE_PATH; ?>/images/avatar.jpeg" alt="avatar">
            </div>
        </div>
    </div>

    <div class="profile-wrapper">
        <div class="container">
            <!-- Left sidebar -->
            <aside class="left-sidebar">
                <div class="search-box dashed">
                    <form action="<?php echo BASE_PATH; ?>/search.php" method="GET">
                        <input type="text" name="q" placeholder="quick search">
                        <button type="submit">go</button>
                    </form>
                </div>

                <nav class="menu dashed">
                    <h4>My Profile [ <a href="<?php echo BASE_PATH; ?>/edit.php">edit</a> ]</h4>
                    <ul>
                        <li><a href="<?php echo BASE_PATH; ?>/">My Profile</a></li>
                        <li><a href="<?php echo BASE_PATH; ?>/friends.php">My Friends</a></li>
                        <li><a href="<?php echo BASE_PATH; ?>/groups.php">My Groups</a></li>
                        <li><a href="<?php echo BASE_PATH; ?>/parties.php">My Parties</a></li>
                        <li><a href="<?php echo BASE_PATH; ?>/">My Messages</a></li>
                        <li><a href="<?php echo BASE_PATH; ?>/account.php">My Account</a></li>
                        <li><a href="<?php echo BASE_PATH; ?>/privacy.php">My Privacy</a></li>
                    </ul>
                </nav>
            </aside>

            <!-- Main profile area -->
            <main class="profile-main">
                <div class="profile-title-bar">
                    <div class="profile-title"><?php echo $name; ?></div>
                    <div class="profile-tab">Profile</div>
                </div>

                <div class="profile-panel">
                    <div class="left-column">
                        <div class="section card">
                            <div class="section-header">Picture</div>
                            <div class="section-body center">
                                <img class="profile-photo" src="<?php echo $avatar; ?>" alt="Profile Picture">
                                <div class="btn-list">
                                    <a class="btn" href="<?php echo BASE_PATH; ?>/?to=<?php echo urlencode($email); ?>">Send <?php echo $name; ?> a Message</a>
                                    <a class="btn secondary" href="#">Poke Him!</a>
                                </div>
                            </div>
                        </div>

                        <div class="section card small">
                            <div class="section-header">Connection</div>
                            <div class="section-body">This is you.</div>
                        </div>

                        <div class="section card small">
                            <div class="section-header">Mutual Friends</div>
                            <div class="section-body">You have <strong>0</strong> friends in common</div>
                        </div>
                    </div>

                    <div class="right-column">
                        <div class="section card large">
                            <div class="section-header">Information</div>
                            <div class="section-body info">
                                <h5>Account Info:</h5>
                                <table class="info-table">
                                    <tr><td class="label">Name:</td><td><?php echo $name; ?></td></tr>
                                    <tr><td class="label">Member Since:</td><td><?php echo $member_since; ?></td></tr>
                                    <tr><td class="label">Last Update:</td><td><?php echo $last_update; ?></td></tr>
                                </table>

                                <h5>Basic Info:</h5>
                                <table class="info-table">
                                    <tr><td class="label">School:</td><td><?php echo $school; ?></td></tr>
                                    <tr><td class="label">Status:</td><td><?php echo $status; ?></td></tr>
                                </table>

                                <h5>Contact Info:</h5>
                                <table class="info-table">
                                    <tr><td class="label">Email:</td><td><?php echo $email; ?></td></tr>
                                </table>

                                <h5>About Me:</h5>
                                <div class="about-me"><?php echo nl2br($about); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
  </body>
  </html>
