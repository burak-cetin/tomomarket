<?php
// admin/includes/sidebar.php
$currentFile = basename($_SERVER['PHP_SELF']);
function adminActive(string $file): string {
    global $currentFile;
    return ($currentFile === $file) ? ' active' : '';
}
?>
<nav class="admin-sidebar">
  <div class="logo">TomografiMarket<br><span style="font-size:.75rem;color:#94a3b8;font-weight:400">Admin Panel</span></div>
  <div class="admin-menu">
    <a href="dashboard.php" class="<?= adminActive('dashboard.php') ?>">📊 Dashboard</a>
    <a href="brands.php" class="<?= adminActive('brands.php') ?>">🏷 Markalar</a>
    <a href="products.php" class="<?= adminActive('products.php') ?>">📦 Ürünler</a>
    <a href="second-hand.php" class="<?= adminActive('second-hand.php') ?>">♻️ İkinci El</a>
    <a href="blog.php" class="<?= adminActive('blog.php') ?>">📝 Blog</a>
    <a href="leads.php" class="<?= adminActive('leads.php') ?>">📩 İletişim Talepleri</a>
    <a href="settings.php" class="<?= adminActive('settings.php') ?>">⚙️ Ayarlar</a>
    <a href="logout.php" style="margin-top:2rem;color:#f87171">🚪 Çıkış Yap</a>
  </div>
</nav>
