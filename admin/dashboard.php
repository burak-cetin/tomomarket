<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: index.php'); exit;
}
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/site.php';

$db = getDB();
$brandCount   = $db->query("SELECT COUNT(*) FROM brands WHERE active=1")->fetchColumn();
$productCount = $db->query("SELECT COUNT(*) FROM products WHERE active=1")->fetchColumn();
$leadCount    = $db->query("SELECT COUNT(*) FROM contact_leads")->fetchColumn();
$shCount      = $db->query("SELECT COUNT(*) FROM second_hand WHERE active=1")->fetchColumn();
$blogCount    = $db->query("SELECT COUNT(*) FROM blog_posts WHERE published=1")->fetchColumn();
$recentLeads  = $db->query("SELECT * FROM contact_leads ORDER BY created_at DESC LIMIT 10")->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Dashboard | TomografiMarket Admin</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <meta name="robots" content="noindex, nofollow">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem">
      <div>
        <h1 style="font-family:'Space Grotesk',sans-serif;font-size:1.75rem">Dashboard</h1>
        <p style="color:var(--text-secondary)">Hoş geldiniz, <?= htmlspecialchars($_SESSION['admin_user'] ?? 'Admin') ?>!</p>
      </div>
      <a href="../index.php" target="_blank" class="btn-outline" style="text-decoration:none;padding:.5rem 1rem;font-size:.9rem">🌐 Siteyi Görüntüle</a>
    </div>

    <!-- Stats -->
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:1.25rem;margin-bottom:2rem">
      <?php
      $stats = [
          ['label'=>'Aktif Marka',    'value'=>$brandCount,   'icon'=>'🏷',  'link'=>'brands.php'],
          ['label'=>'Aktif Ürün',     'value'=>$productCount, 'icon'=>'📦',  'link'=>'products.php'],
          ['label'=>'İkinci El İlan', 'value'=>$shCount,      'icon'=>'♻️',  'link'=>'second-hand.php'],
          ['label'=>'Blog Yazısı',    'value'=>$blogCount,    'icon'=>'📝',  'link'=>'blog.php'],
          ['label'=>'İletişim Talebi','value'=>$leadCount,    'icon'=>'📩',  'link'=>'leads.php'],
      ];
      foreach ($stats as $s):
      ?>
      <a href="<?= $s['link'] ?>" style="background:#fff;border:1px solid var(--border);border-radius:12px;padding:1.25rem;text-decoration:none;color:inherit;transition:.2s;display:block" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
        <div style="font-size:1.8rem;margin-bottom:.5rem"><?= $s['icon'] ?></div>
        <div style="font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:700;color:var(--primary)"><?= $s['value'] ?></div>
        <div style="font-size:.85rem;color:var(--text-secondary);margin-top:.25rem"><?= $s['label'] ?></div>
      </a>
      <?php endforeach; ?>
    </div>

    <!-- Recent Leads -->
    <div class="admin-card">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem">
        <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.15rem">Son İletişim Talepleri</h2>
        <a href="leads.php" class="btn-outline" style="font-size:.85rem;padding:.4rem .9rem;text-decoration:none">Tümünü Gör</a>
      </div>
      <?php if (empty($recentLeads)): ?>
      <p style="color:var(--text-secondary);text-align:center;padding:2rem">Henüz iletişim talebi yok.</p>
      <?php else: ?>
      <div style="overflow-x:auto">
        <table class="admin-table">
          <thead><tr>
            <th>Tarih</th><th>Ad Soyad</th><th>E-posta</th><th>Telefon</th><th>Konu</th>
          </tr></thead>
          <tbody>
            <?php foreach ($recentLeads as $lead): ?>
            <tr>
              <td style="white-space:nowrap"><?= date('d.m.Y H:i', strtotime($lead['created_at'])) ?></td>
              <td><?= htmlspecialchars($lead['name'] ?? '—') ?></td>
              <td><a href="mailto:<?= htmlspecialchars($lead['email'] ?? '') ?>"><?= htmlspecialchars($lead['email'] ?? '—') ?></a></td>
              <td><?= htmlspecialchars($lead['phone'] ?? '—') ?></td>
              <td><?= htmlspecialchars($lead['subject'] ?? '—') ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>

    <!-- Quick Links -->
    <div class="admin-card" style="margin-top:1.5rem">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.15rem;margin-bottom:1rem">Hızlı İşlemler</h2>
      <div style="display:flex;gap:.75rem;flex-wrap:wrap">
        <a href="products.php?action=add" class="btn-primary" style="text-decoration:none;font-size:.9rem;padding:.65rem 1.25rem">+ Ürün Ekle</a>
        <a href="second-hand.php?action=add" class="btn-secondary" style="text-decoration:none;font-size:.9rem;padding:.65rem 1.25rem">+ İlan Ekle</a>
        <a href="blog.php?action=add" class="btn-outline" style="text-decoration:none;font-size:.9rem;padding:.65rem 1.25rem">+ Blog Yazısı</a>
        <a href="../sitemap.php" target="_blank" class="btn-outline" style="text-decoration:none;font-size:.9rem;padding:.65rem 1.25rem">🗺 Sitemap</a>
      </div>
    </div>
  </main>
</div>
</body>
</html>
