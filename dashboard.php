<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/config/database.php';

$stmt = $pdo->prepare(
    'SELECT name, email FROM users WHERE id = ? LIMIT 1'
);
$stmt->execute([$_SESSION['user_id']]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Doc Marly SQMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: #f4f6f8; min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="card" style="width: 100%; max-width: 560px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
        <div class="card-body text-center p-5">
            <h1 class="mb-3">Welcome, <?= htmlspecialchars($user['name']) ?></h1>
            <p class="text-muted mb-4">You are signed in as <strong><?= htmlspecialchars($user['email']) ?></strong>.</p>
            <a href="logout.php" class="btn btn-danger btn-lg">Sign Out</a>
        </div>
    </div>
</body>

</html>
