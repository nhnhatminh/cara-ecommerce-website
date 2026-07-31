<?php
$host     = getenv('DB_HOST')     ?: 'db';
$port     = getenv('DB_PORT')     ?: '3306';
$dbname   = getenv('DB_NAME')     ?: 'cara_ecommerce_db';
$username = getenv('DB_USER')     ?: 'cara_admin';
$password = getenv('DB_PASS')     ?: 'Cara@1234';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Database Connection Error: " . $e->getMessage());
}
?>