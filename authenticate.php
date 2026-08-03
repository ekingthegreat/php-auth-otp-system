<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/mailer.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {

    $_SESSION['error'] = 'Please enter your email and password.';

    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare(
    "SELECT id, name, email, password
     FROM users
     WHERE email = ?
     LIMIT 1"
);

$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password'])) {

    $_SESSION['error'] = 'Invalid email or password.';

    header('Location: login.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| Generate 6-digit verification code
|--------------------------------------------------------------------------
*/

$code = random_int(100000, 999999);

/*
|--------------------------------------------------------------------------
| Store verification information in session
|--------------------------------------------------------------------------
*/

$_SESSION['verification_user_id'] = $user['id'];

$_SESSION['verification_code'] = password_hash(
    (string)$code,
    PASSWORD_DEFAULT
);

$_SESSION['verification_expires'] =
    time() + (10 * 60);

/*
|--------------------------------------------------------------------------
| Send email
|--------------------------------------------------------------------------
*/

if (sendVerificationCode(
    $user['email'],
    $user['name'],
    $code
)) {

    header('Location: verify.php');
    exit;

} else {

    unset(
        $_SESSION['verification_user_id'],
        $_SESSION['verification_code'],
        $_SESSION['verification_expires']
    );

    $_SESSION['error'] =
        'Unable to send verification email.';

    header('Location: login.php');
    exit;
}