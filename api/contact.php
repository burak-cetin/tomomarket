<?php
// api/contact.php — İletişim formu POST endpoint
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/site.php';
require_once __DIR__ . '/../includes/functions.php';

// JSON veya form verisi al
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!$data) {
    $data = $_POST;
}

$name    = trim($data['name']    ?? '');
$email   = trim($data['email']   ?? '');
$phone   = trim($data['phone']   ?? '');
$subject = trim($data['subject'] ?? '');
$message = trim($data['message'] ?? '');
$source  = trim($data['source']  ?? ($_SERVER['HTTP_REFERER'] ?? 'website'));

// Basit validasyon
if (!$name || !$phone) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Ad ve telefon zorunludur.']);
    exit;
}

if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Geçersiz e-posta adresi.']);
    exit;
}

// Basit spam koruması: aynı IP'den 5 dakikada birden fazla istek
try {
    $ip   = $_SERVER['REMOTE_ADDR'] ?? '';
    $stmt = getDB()->prepare("SELECT COUNT(*) FROM contact_leads WHERE ip=? AND created_at > DATE_SUB(NOW(), INTERVAL 5 MINUTE)");
    $stmt->execute([$ip]);
    if ($stmt->fetchColumn() >= 5) {
        http_response_code(429);
        echo json_encode(['success' => false, 'message' => 'Çok fazla istek. Lütfen birkaç dakika bekleyin.']);
        exit;
    }
} catch (Exception $e) {
    // Rate limit kontrolü başarısız olsa bile devam et
}

$ok = saveLead([
    'name'    => $name,
    'email'   => $email,
    'phone'   => $phone,
    'subject' => $subject,
    'message' => $message,
    'source'  => $source,
]);

if ($ok) {
    echo json_encode(['success' => true, 'message' => 'Mesajınız başarıyla alındı.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Veritabanı hatası.']);
}
