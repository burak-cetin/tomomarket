<?php
http_response_code(404);
require_once __DIR__ . '/config/site.php';
require_once __DIR__ . '/includes/functions.php';
$depth = '';
$seoTitle = '404 — Sayfa Bulunamadı | TomografiMarket';
require __DIR__ . '/includes/header.php';
?>
<div style="text-align:center;padding:8rem 5%">
  <div style="font-size:5rem;margin-bottom:1rem">😕</div>
  <h1 style="font-family:'Space Grotesk',sans-serif;font-size:3rem;margin-bottom:1rem">404</h1>
  <p style="color:var(--text-secondary);font-size:1.1rem;margin-bottom:2rem">Aradığınız sayfa bulunamadı.</p>
  <a href="/" class="btn-primary" style="text-decoration:none">Ana Sayfaya Dön</a>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
