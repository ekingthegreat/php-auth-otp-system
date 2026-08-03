<?php

$host = 'localhost';
$dbname = 'login_system';
$username = 'root';
$password = '';

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    echo "<h2 style='color: green;'>✓ Database Connection Successful!</h2>";

    echo "<p>Database: <strong>" . htmlspecialchars($dbname) . "</strong></p>";

    // Test query
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM users");

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<p>Users in database: <strong>"
        . $result['total']
        . "</strong></p>";

} catch (PDOException $e) {

    echo "<h2 style='color: red;'>✗ Database Connection Failed!</h2>";

    echo "<p>Error:</p>";

    echo "<pre>"
        . htmlspecialchars($e->getMessage())
        . "</pre>";
}