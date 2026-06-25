<?php

/**
 * Database configuration — THE single place for DB credentials.
 *
 * Values are read from environment variables (set in docker-compose.yml) and
 * fall back to a local/Windows setup (localhost, user "root", empty password).
 * To change the credentials, edit them HERE (or via the env vars) and nowhere
 * else — every model and controller connects through connectDatabase() below.
 */
function dbConfig(): array
{
    static $config;
    if ($config === null) {
        $pass = getenv('DB_PASS');
        $config = [
            'host'    => getenv('DB_HOST') ?: '127.0.0.1',
            'name'    => getenv('DB_NAME') ?: 'journal',
            'user'    => getenv('DB_USER') ?: 'root',
            'pass'    => $pass === false ? '' : $pass,
            'charset' => 'utf8mb4',
        ];
    }
    return $config;
}

/**
 * Opens a PDO connection using the single dbConfig() above.
 */
function connectDatabase(): PDO
{
    $c = dbConfig();
    try {
        return new PDO(
            "mysql:host={$c['host']};dbname={$c['name']};charset={$c['charset']}",
            $c['user'],
            $c['pass']
        );
    } catch (PDOException $e) {
        die('Keine Verbindung zur Datenbank möglich: ' . $e->getMessage());
    }
}
