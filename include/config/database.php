<?php
require __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);

function getDatabaseConnection(): ?PDO
{
    $host = $_ENV['DB_HOST'];
    $dbname = $_ENV['DB_NAME'];
    $dsn = "mysql:host={$host};dbname={$dbname}";
    $username = $_ENV["DB_USER"];
    $password = $_ENV["DB_PASS"];


    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        header("Location: /pages/errors/500.php");
        exit;
    }
}
?>