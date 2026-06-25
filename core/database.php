<?php

function connectDatabase() {
    // Configuration is read from environment variables so the same code runs
    // on Windows (XAMPP/local MySQL) and inside Docker. The defaults match the
    // original local Windows setup (localhost, user "root", empty password).
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $name = getenv('DB_NAME') ?: 'journal';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS');
    if ($pass === false) {
        $pass = '';
    }

    try {
        return new PDO("mysql:host=$host;dbname=$name;charset=utf8mb4", $user, $pass);
    } catch (PDOException $e) {
        die('Keine Verbindung zur Datenbank möglich: ' . $e->getMessage());
    }
}