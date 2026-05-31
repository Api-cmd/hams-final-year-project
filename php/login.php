<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/index.html');
    exit();
}

$email = clean($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Simple validation
if (empty($email) || empty($password)) {
    header('Location: ../pages/index.html?msg=login_failed');
    exit();
}

// Check user
$stmt = $pdo->prepare("SELECT user_id, full_name, email, password, role FROM users WHERE email = ? AND is_active = 1");
$stmt->execute([$email]);
$user = $stmt->fetch();

// Verify password
if (!$user || !password_verify($password, $user['password'])) {
    header('Location: ../pages/index.html?msg=login_failed');
    exit();
}

// After login success
// Login success - temporary for testing
$_SESSION['user_id'] = $user['user_id'];
$_SESSION['user_name'] = $user['full_name'];
$_SESSION['user_role'] = $user['role'];
$_SESSION['user_email'] = $user['email'];

// DEBUG: Show success instead of redirecting
echo "✅ LOGIN SUCCESSFUL!<br>";
echo "Name: " . $user['full_name'] . "<br>";
echo "Role: " . $user['role'] . "<br>";
echo "Email: " . $user['email'] . "<br>";
echo "<br><a href='../index.html'>Go to login page</a>";
exit();
// Redirect based on role
/*switch ($user['role']) {
    case 'patient':
        header('Location: ../pages/dashboard.html');
        break;
    case 'staff':
        header('Location: ../pages/staff-dashboard.html');
        break;
    case 'admin':
        header('Location: ../pages/admin-dashboard.html');
        break;
    default:
        header('Location: ../index.html?msg=login_failed');
}
exit(); */

?>