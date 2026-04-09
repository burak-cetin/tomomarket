<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) { header('Location: index.php'); exit; }
require_once __DIR__ . '/../config/db.php';

$db    = getDB();
$page  = max(1, (int)($_GET['page'] ?? 1));
$limit = 25;
$offset = ($page - 1) * $limit;
$total = $db->query("SELECT COUNT(*) FROM contact_leads")->fetchColumn();
$leads = $db->prepare("SELECT * FROM contact_leads ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
$leads->execute();
$leads = $leads->fetchAll();
$pages = ceil($total / $limit);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>İletişim Talepleri | Admin</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <meta name="robots" content="noindex, nofollow">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
      <h1 style="font-family:'Space Grotesk',sans-serif;font-size:1.5rem">📩 İletişim Talepleri</h1>
      <span style="color:var(--text-secondary);font-size:.9rem">Toplam: <strong><?= $total ?></strong></span>
    </div>

    <div class="admin-card">
      <div style="overflow-x:auto">
        <table class="admin-table">
          <thead><tr><th>Tarih</th><th>Ad Soyad</th><th>E-posta</th><th>Telefon</th><th>Konu</th><th>Mesaj</th><th>IP</th></tr></thead>
          <tbody>
            <?php if (empty($leads)): ?>
            <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-secondary)">Henüz talep yok.</td></tr>
            <?php else: foreach ($leads as $l): ?>
            <tr>
              <td style="white-space:nowrap;font-size:.82rem"><?= date('d.m.Y H:i', strtotime($l['created_at'])) ?></td>
              <td><?= htmlspecialchars($l['name']??'—') ?></td>
              <td><a href="mailto:<?= htmlspecialchars($l['email']??'') ?>"><?= htmlspecialchars($l['email']??'—') ?></a></td>
              <td><?= htmlspecialchars($l['phone']??'—') ?></td>
              <td><?= htmlspecialchars($l['subject']??'—') ?></td>
              <td style="max-width:220px;font-size:.82rem;color:var(--text-secondary)"><?= htmlspecialchars(substr($l['message']??'', 0, 100)) ?><?= strlen($l['message']??'')>100?'…':'' ?></td>
              <td style="font-size:.8rem;color:var(--text-light)"><?= htmlspecialchars($l['ip']??'') ?></td>
            </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>

      <?php if ($pages > 1): ?>
      <div class="pagination" style="justify-content:flex-start;padding:1.25rem 0 0">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
        <?php if ($i === $page): ?>
        <span class="current"><?= $i ?></span>
        <?php else: ?>
        <a href="?page=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
        <?php endfor; ?>
      </div>
      <?php endif; ?>
    </div>
  </main>
</div>
</body>
</html>
