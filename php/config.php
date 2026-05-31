<?php
// ===========================================================
// php/config.php
// Database connection 
// ===========================================================

// --- Database settings  ---
define('DB_HOST', 'localhost');
define('DB_NAME', 'hams20_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// --- Start session for login ---
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Connect to database ---
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// --- Simple helper functions ---
function clean($value) {
    return trim(htmlspecialchars($value));
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}
?>