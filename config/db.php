<?php
// ============================================================
//  TomografiMarket — Veritabanı Bağlantısı
// ============================================================
define('DB_HOST', 'localhost');
define('DB_NAME', 'tomomarket');
define('DB_USER', 'root');          // ← Hosting'inize göre değiştirin
define('DB_PASS', '');              // ← Hosting'inize göre değiştirin
define('DB_CHARSET', 'utf8mb4');

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            http_response_code(500);
            die('<h2>Veritabanı bağlantı hatası.</h2><p>' . htmlspecialchars($e->getMessage()) . '</p>');
        }
    }
    return $pdo;
}
