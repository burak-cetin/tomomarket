<?php
// admin/includes/sidebar.php
$currentFile = basename($_SERVER['PHP_SELF']);
function adminActive(string $file): string {
    global $currentFile;
    return ($currentFile === $file) ? ' active' : '';
}
?>
<!-- Mobile toggle for admin -->
<button class="admin-sidebar-toggle" onclick="document.querySelector('.admin-sidebar').classList.toggle('active')" style="display:none;position:fixed;top:1rem;left:1rem;z-index:10000;background:#1e293b;color:#fff;border:none;border-radius:8px;padding:.5rem .75rem;cursor:pointer;font-size:1.2rem">☰</button>
<style>@media(max-width:768px){.admin-sidebar-toggle{display:block!important}}</style>

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
