<?php
require_once 'config/session.php';
require_once 'config/database.php';

// If not logged in, redirect to login
if (!isLoggedIn()) {
    header('Location: login.php');
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
    header('Location: login.php');
    exit();
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user['name']); ?>'s Profile | thefacebook</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <a href="/" class="logo">thefacebook</a>
            <div class="nav">
                <a href="/">home</a>
                <a href="/search.php">search</a>
                <a href="/global.php">global</a>
                <a href="/social.php">social net</a>
                <a href="/invite.php">invite</a>
                <a href="/faq.php">faq</a>
                <a href="/logout.php">logout</a>
                <div class="user-info">
                    <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="avatar" class="user-avatar">
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="profile-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="quick-search">
                <form action="/search.php" method="GET">
                    <input type="text" name="q" placeholder="quick search">
                    <button type="submit">go</button>
                </form>
            </div>

            <h3>My Profile</h3>
            <ul>
                <li><a href="/">My Profile</a></li>
                <li><a href="/edit.php">Edit</a></li>
            </ul>

            <h3>My Friends</h3>
            <ul>
                <li><a href="/friends.php">My Friends</a></li>
            </ul>

            <h3>My Parties</h3>
            <ul>
                <li><a href="/parties.php">My Parties</a></li>
            </ul>

            <h3>My Messages</h3>
            <ul>
                <li><a href="/messages.php">My Messages</a></li>
            </ul>

            <h3>My Account</h3>
            <ul>
                <li><a href="/account.php">My Account</a></li>
            </ul>

            <h3>My Privacy</h3>
            <ul>
                <li><a href="/privacy.php">My Privacy</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Profile Header -->
            <div class="profile-header">
                <h2><?php echo htmlspecialchars($user['name']); ?>'s Profile</h2>
                <div class="profile-location"><?php echo htmlspecialchars($user['school'] ?: 'Puget Sound'); ?></div>
            </div>

            <!-- Profile Content -->
            <div class="profile-content">
                <!-- Left Column: Picture -->
                <div>
                    <div class="profile-picture-section">
                        <div class="section-header">Picture</div>
                        <div class="section-content">
                            <div class="profile-picture">
                                <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="Profile Picture">
                            </div>
                            <div class="action-buttons">
                                <button class="action-button">Send Mark a Message</button>
                                <button class="action-button">Poke Him</button>
                            </div>
                        </div>
                    </div>

                    <!-- Connection Section -->
                    <div class="connection-section">
                        <div class="section-header">Connection</div>
                        <div class="connection-content">
                            This is you
                        </div>
                    </div>

                    <!-- Mutual Friends -->
                    <div class="connection-section">
                        <div class="section-header">Mutual Friends</div>
                        <div class="connection-content">
                            You have <strong>0</strong> friends in common with <?php echo htmlspecialchars($user['name']); ?>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Information -->
                <div>
                    <!-- Account Info -->
                    <div class="info-section">
                        <div class="section-header">Information</div>
                        <div class="section-content">
                            <h4 style="margin-bottom: 10px; font-size: 12px;">Account Info:</h4>
                            <table class="info-table">
                                <tr>
                                    <td class="info-label">Name:</td>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                </tr>
                                <tr>
                                    <td class="info-label">Member Since:</td>
                                    <td><?php echo date('F j, Y', strtotime($user['member_since'])); ?></td>
                                </tr>
                                <tr>
                                    <td class="info-label">Last Update:</td>
                                    <td><?php echo date('F j, Y', strtotime($user['last_update'])); ?></td>
                                </tr>
                            </table>

                            <h4 style="margin: 15px 0 10px 0; font-size: 12px;">Basic Info:</h4>
                            <table class="info-table">
                                <tr>
                                    <td class="info-label">School:</td>
                                    <td><?php echo htmlspecialchars($user['school'] ?: ''); ?></td>
                                </tr>
                                <tr>
                                    <td class="info-label">Status:</td>
                                    <td><?php echo htmlspecialchars($user['status']); ?></td>
                                </tr>
                                <tr>
                                    <td class="info-label">Sex:</td>
                                    <td><?php echo htmlspecialchars($user['sex'] ?: 'Male'); ?></td>
                                </tr>
                                <tr>
                                    <td class="info-label">Residence:</td>
                                    <td><?php echo htmlspecialchars($user['residence'] ?: 'Kirkld 113'); ?></td>
                                </tr>
                                <tr>
                                    <td class="info-label">Birthday:</td>
                                    <td><?php echo $user['birthday'] ? date('F j, Y', strtotime($user['birthday'])) : 'May 14, 1984'; ?></td>
                                </tr>
                                <tr>
                                    <td class="info-label">Home Town:</td>
                                    <td><?php echo htmlspecialchars($user['hometown'] ?: 'Dobbs Ferry, NY'); ?></td>
                                </tr>
                                <tr>
                                    <td class="info-label">High School:</td>
                                    <td><?php echo htmlspecialchars($user['highschool'] ?: 'Phillips Exeter Academy, 2002'); ?></td>
                                </tr>
                            </table>

                            <h4 style="margin: 15px 0 10px 0; font-size: 12px;">Contact Info:</h4>
                            <table class="info-table">
                                <tr>
                                    <td class="info-label">Email:</td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                </tr>
                                <tr>
                                    <td class="info-label">Screenname:</td>
                                    <td><?php echo htmlspecialchars($user['screenname'] ?: 'zberg02'); ?></td>
                                </tr>
                                <tr>
                                    <td class="info-label">Mobile:</td>
                                    <td><?php echo htmlspecialchars($user['mobile'] ?: ''); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
