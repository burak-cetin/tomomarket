<?php
// admin/index.php — Admin Login
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
    header('Location: dashboard.php');
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/site.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    try {
        $stmt = getDB()->prepare("SELECT `value` FROM site_settings WHERE `key`='admin_pass_hash'");
        $stmt->execute();
        $hash = $stmt->fetchColumn();

        $adminUser = getDB()->prepare("SELECT `value` FROM site_settings WHERE `key`='admin_user'")->execute() ? 
            getDB()->query("SELECT `value` FROM site_settings WHERE `key`='admin_user'")->fetchColumn() : 'admin';

        if ($user === $adminUser && $hash && password_verify($pass, $hash)) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user']      = $user;
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Kullanıcı adı veya şifre hatalı.';
        }
    } catch (Exception $e) {
        $error = 'Sistem hatası. Lütfen tekrar deneyin.';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Girişi | TomografiMarket</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <meta name="robots" content="noindex, nofollow">
</head>
<body style="background:var(--bg-secondary);display:flex;align-items:center;justify-content:center;min-height:100vh">
  <div style="background:#fff;border:1px solid var(--border);border-radius:20px;padding:2.5rem;width:100%;max-width:400px;box-shadow:var(--shadow-lg)">
    <div style="text-align:center;margin-bottom:2rem">
      <h1 style="font-family:'Space Grotesk',sans-serif;font-size:1.5rem;color:var(--primary)">TomografiMarket</h1>
      <p style="color:var(--text-secondary);font-size:.9rem;margin-top:.25rem">Admin Paneli</p>
    </div>

    <?php if ($error): ?>
    <div class="alert alert-error" style="margin-bottom:1.5rem"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="admin-form-group">
        <label>Kullanıcı Adı</label>
        <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required autofocus>
      </div>
      <div class="admin-form-group" style="margin-bottom:1.5rem">
        <label>Şifre</label>
        <input type="password" name="password" required>
      </div>
      <button type="submit" class="btn-primary" style="width:100%;justify-content:center">Giriş Yap</button>
    </form>

    <div style="text-align:center;margin-top:1.5rem">
      <a href="../" style="color:var(--text-secondary);font-size:.85rem;text-decoration:none">← Siteye Dön</a>
    </div>
  </div>
</body>
</html>
