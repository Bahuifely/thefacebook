<?php
// ...existing code...
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'thefacebook');

// Create connection
function getConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

// University email domains (add more as needed)
$allowed_domains = [
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

function isUniversityEmail($email) {
    global $allowed_domains;
    
    $domain = substr(strrchr($email, "@"), 1);
    if (!$domain) {
        return false;
    }

    foreach ($allowed_domains as $allowed_domain) {
        // exact match (case-insensitive)
        if (strcasecmp($domain, $allowed_domain) === 0) {
            return true;
        }
        // subdomains: allows dept.university.edu
        if (preg_match('/(^|\.)' . preg_quote($allowed_domain, '/') . '$/i', $domain)) {
            return true;
        }
    }
    
    return false;
}
?>
// ...existing code...