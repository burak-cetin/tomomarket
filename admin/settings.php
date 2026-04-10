<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) { header('Location: index.php'); exit; }
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/site.php';

$db  = getDB();
$msg = '';
$tab = $_GET['tab'] ?? 'general';

// ── Ayarlari kaydet ──────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['form_action'] ?? '';

    if ($action === 'password') {
        $currentPass = $_POST['current_password'] ?? '';
        $newPass     = $_POST['new_password'] ?? '';
        $confirmPass = $_POST['confirm_password'] ?? '';

        // Mevcut sifreyi kontrol et
        $hash = $db->query("SELECT `value` FROM site_settings WHERE `key`='admin_pass_hash'")->fetchColumn();
        if (!password_verify($currentPass, $hash)) {
            $msg = 'error:Mevcut sifre hatali.';
        } elseif (strlen($newPass) < 8) {
            $msg = 'error:Yeni sifre en az 8 karakter olmalidir.';
        } elseif ($newPass !== $confirmPass) {
            $msg = 'error:Yeni sifreler eslesmiyeor.';
        } else {
            $newHash = password_hash($newPass, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE site_settings SET `value`=? WHERE `key`='admin_pass_hash'");
            $stmt->execute([$newHash]);
            $msg = 'success:Sifre basariyla guncellendi.';
        }
        $tab = 'password';
    }

    if ($action === 'settings') {
        $settings = [
            'site_name'    => trim($_POST['site_name'] ?? ''),
            'site_tagline' => trim($_POST['site_tagline'] ?? ''),
            'site_email'   => trim($_POST['site_email'] ?? ''),
            'site_phone1'  => trim($_POST['site_phone1'] ?? ''),
            'site_phone2'  => trim($_POST['site_phone2'] ?? ''),
            'site_wa'      => trim($_POST['site_wa'] ?? ''),
            'seo_default_desc'     => trim($_POST['seo_default_desc'] ?? ''),
            'seo_default_keywords' => trim($_POST['seo_default_keywords'] ?? ''),
        ];

        foreach ($settings as $key => $value) {
            $stmt = $db->prepare("INSERT INTO site_settings (`key`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `value`=?");
            $stmt->execute([$key, $value, $value]);
        }
        $msg = 'success:Ayarlar kaydedildi.';
        $tab = 'general';
    }
}

// ── Mevcut ayarlari yukle ────────────────────────────
function getSetting(PDO $db, string $key, string $default = ''): string {
    $stmt = $db->prepare("SELECT `value` FROM site_settings WHERE `key`=?");
    $stmt->execute([$key]);
    return $stmt->fetchColumn() ?: $default;
}

$s = [
    'site_name'    => getSetting($db, 'site_name', SITE_NAME),
    'site_tagline' => getSetting($db, 'site_tagline', SITE_TAGLINE),
    'site_email'   => getSetting($db, 'site_email', SITE_EMAIL),
    'site_phone1'  => getSetting($db, 'site_phone1', SITE_PHONE1),
    'site_phone2'  => getSetting($db, 'site_phone2', SITE_PHONE2),
    'site_wa'      => getSetting($db, 'site_wa', SITE_WA),
    'seo_default_desc'     => getSetting($db, 'seo_default_desc', SEO_DEFAULT_DESC),
    'seo_default_keywords' => getSetting($db, 'seo_default_keywords', SEO_DEFAULT_KEYWORDS),
];

$msgType = '';
$msgText = '';
if ($msg) {
    [$msgType, $msgText] = explode(':', $msg, 2);
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Ayarlar | TomografiMarket Admin</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <meta name="robots" content="noindex, nofollow">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <h1 style="font-family:'Space Grotesk',sans-serif;font-size:1.5rem;margin-bottom:1.5rem">Ayarlar</h1>

    <?php if ($msgText): ?>
    <div class="alert alert-<?= $msgType === 'error' ? 'error' : 'success' ?>"><?= htmlspecialchars($msgText) ?></div>
    <?php endif; ?>

    <!-- Tab Navigation -->
    <div style="display:flex;gap:.5rem;margin-bottom:1.5rem;border-bottom:2px solid var(--border);padding-bottom:0">
      <a href="?tab=general" style="padding:.75rem 1.25rem;text-decoration:none;font-weight:600;font-size:.9rem;border-bottom:2px solid <?= $tab==='general' ? 'var(--primary)' : 'transparent' ?>;color:<?= $tab==='general' ? 'var(--primary)' : 'var(--text-secondary)' ?>;margin-bottom:-2px">Genel Ayarlar</a>
      <a href="?tab=password" style="padding:.75rem 1.25rem;text-decoration:none;font-weight:600;font-size:.9rem;border-bottom:2px solid <?= $tab==='password' ? 'var(--primary)' : 'transparent' ?>;color:<?= $tab==='password' ? 'var(--primary)' : 'var(--text-secondary)' ?>;margin-bottom:-2px">Sifre Degistir</a>
      <a href="?tab=info" style="padding:.75rem 1.25rem;text-decoration:none;font-weight:600;font-size:.9rem;border-bottom:2px solid <?= $tab==='info' ? 'var(--primary)' : 'transparent' ?>;color:<?= $tab==='info' ? 'var(--primary)' : 'var(--text-secondary)' ?>;margin-bottom:-2px">Sistem Bilgisi</a>
    </div>

    <?php if ($tab === 'general'): ?>
    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.15rem;margin-bottom:1.5rem">Genel Site Ayarlari</h2>
      <form method="POST">
        <input type="hidden" name="form_action" value="settings">

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
          <div class="admin-form-group">
            <label>Site Adi</label>
            <input type="text" name="site_name" value="<?= htmlspecialchars($s['site_name']) ?>">
          </div>
          <div class="admin-form-group">
            <label>Slogan</label>
            <input type="text" name="site_tagline" value="<?= htmlspecialchars($s['site_tagline']) ?>">
          </div>
          <div class="admin-form-group">
            <label>E-posta</label>
            <input type="email" name="site_email" value="<?= htmlspecialchars($s['site_email']) ?>">
          </div>
          <div class="admin-form-group">
            <label>Telefon 1</label>
            <input type="text" name="site_phone1" value="<?= htmlspecialchars($s['site_phone1']) ?>">
          </div>
          <div class="admin-form-group">
            <label>Telefon 2</label>
            <input type="text" name="site_phone2" value="<?= htmlspecialchars($s['site_phone2']) ?>">
          </div>
          <div class="admin-form-group">
            <label>WhatsApp Numarasi</label>
            <input type="text" name="site_wa" value="<?= htmlspecialchars($s['site_wa']) ?>" placeholder="905XXXXXXXXX">
          </div>
        </div>

        <h3 style="font-family:'Space Grotesk',sans-serif;margin:1.5rem 0 .75rem;font-size:1rem;color:var(--text-secondary)">SEO Varsayilanlari</h3>
        <div class="admin-form-group">
          <label>Varsayilan Aciklama (Meta Description)</label>
          <textarea name="seo_default_desc" rows="3"><?= htmlspecialchars($s['seo_default_desc']) ?></textarea>
        </div>
        <div class="admin-form-group">
          <label>Varsayilan Anahtar Kelimeler</label>
          <input type="text" name="seo_default_keywords" value="<?= htmlspecialchars($s['seo_default_keywords']) ?>">
        </div>

        <button type="submit" class="btn-primary" style="margin-top:1.5rem">Kaydet</button>
      </form>
    </div>

    <?php elseif ($tab === 'password'): ?>
    <div class="admin-card" style="max-width:500px">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.15rem;margin-bottom:1.5rem">Sifre Degistir</h2>
      <form method="POST">
        <input type="hidden" name="form_action" value="password">
        <div class="admin-form-group">
          <label>Mevcut Sifre</label>
          <input type="password" name="current_password" required>
        </div>
        <div class="admin-form-group">
          <label>Yeni Sifre</label>
          <input type="password" name="new_password" required minlength="8">
        </div>
        <div class="admin-form-group">
          <label>Yeni Sifre (Tekrar)</label>
          <input type="password" name="confirm_password" required minlength="8">
        </div>
        <button type="submit" class="btn-primary" style="margin-top:1rem">Sifreyi Guncelle</button>
      </form>
    </div>

    <?php elseif ($tab === 'info'): ?>
    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.15rem;margin-bottom:1.5rem">Sistem Bilgisi</h2>
      <table class="admin-table">
        <tbody>
          <tr><td style="font-weight:600;width:200px">PHP Surumu</td><td><?= phpversion() ?></td></tr>
          <tr><td style="font-weight:600">MySQL Surumu</td><td><?= $db->query("SELECT VERSION()")->fetchColumn() ?></td></tr>
          <tr><td style="font-weight:600">Sunucu</td><td><?= htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'Bilinmiyor') ?></td></tr>
          <tr><td style="font-weight:600">Site URL</td><td><?= htmlspecialchars(SITE_URL) ?></td></tr>
          <tr><td style="font-weight:600">Aktif Marka Sayisi</td><td><?= $db->query("SELECT COUNT(*) FROM brands WHERE active=1")->fetchColumn() ?></td></tr>
          <tr><td style="font-weight:600">Aktif Urun Sayisi</td><td><?= $db->query("SELECT COUNT(*) FROM products WHERE active=1")->fetchColumn() ?></td></tr>
          <tr><td style="font-weight:600">Blog Yazi Sayisi</td><td><?= $db->query("SELECT COUNT(*) FROM blog_posts WHERE published=1")->fetchColumn() ?></td></tr>
          <tr><td style="font-weight:600">Ikinci El Ilan</td><td><?= $db->query("SELECT COUNT(*) FROM second_hand WHERE active=1")->fetchColumn() ?></td></tr>
          <tr><td style="font-weight:600">Iletisim Talepleri</td><td><?= $db->query("SELECT COUNT(*) FROM contact_leads")->fetchColumn() ?></td></tr>
        </tbody>
      </table>
    </div>

    <div class="admin-card" style="margin-top:1.5rem">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.15rem;margin-bottom:1rem">Hizli Linkler</h2>
      <div style="display:flex;gap:.75rem;flex-wrap:wrap">
        <a href="../sitemap.php" target="_blank" class="btn-outline" style="text-decoration:none;font-size:.85rem;padding:.5rem 1rem">Sitemap (XML)</a>
        <a href="../robots.txt" target="_blank" class="btn-outline" style="text-decoration:none;font-size:.85rem;padding:.5rem 1rem">robots.txt</a>
        <a href="../" target="_blank" class="btn-outline" style="text-decoration:none;font-size:.85rem;padding:.5rem 1rem">Siteyi Goruntule</a>
      </div>
    </div>
    <?php endif; ?>
  </main>
</div>
</body>
</html>
