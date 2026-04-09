<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/site.php';
require_once __DIR__ . '/includes/functions.php';

header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';

$db      = getDB();
$brands  = getBrands();
$products= getAllActiveProducts();
$posts   = getBlogPosts(100);

$now = date('Y-m-d');
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

  <!-- Ana Sayfa -->
  <url>
    <loc><?= SITE_URL ?>/</loc>
    <changefreq>weekly</changefreq>
    <priority>1.0</priority>
    <lastmod><?= $now ?></lastmod>
  </url>

  <!-- İkinci El -->
  <url>
    <loc><?= SITE_URL ?>/ikinci-el.php</loc>
    <changefreq>daily</changefreq>
    <priority>0.8</priority>
    <lastmod><?= $now ?></lastmod>
  </url>

  <!-- Blog -->
  <url>
    <loc><?= SITE_URL ?>/blog/</loc>
    <changefreq>weekly</changefreq>
    <priority>0.7</priority>
    <lastmod><?= $now ?></lastmod>
  </url>

  <!-- Karşılaştırma -->
  <url>
    <loc><?= SITE_URL ?>/sayfalar/karsilastirma.php</loc>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
  </url>

  <!-- Hakkımızda -->
  <url>
    <loc><?= SITE_URL ?>/sayfalar/hakkimizda.php</loc>
    <changefreq>monthly</changefreq>
    <priority>0.5</priority>
  </url>

  <!-- Marka Sayfaları -->
  <?php foreach ($brands as $b): ?>
  <url>
    <loc><?= SITE_URL ?>/markalar/<?= htmlspecialchars($b['slug']) ?>-tomografi.php</loc>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
    <lastmod><?= $now ?></lastmod>
  </url>
  <?php endforeach; ?>

  <!-- Ürün Sayfaları -->
  <?php foreach ($products as $p): ?>
  <url>
    <loc><?= SITE_URL ?>/urunler/<?= htmlspecialchars($p['slug']) ?>-detay.php</loc>
    <changefreq>weekly</changefreq>
    <priority>0.9</priority>
    <lastmod><?= $now ?></lastmod>
  </url>
  <?php endforeach; ?>

  <!-- Blog Yazıları -->
  <?php foreach ($posts as $post): ?>
  <url>
    <loc><?= SITE_URL ?>/blog/<?= htmlspecialchars($post['slug']) ?>.php</loc>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
    <lastmod><?= date('Y-m-d', strtotime($post['updated_at'] ?: $post['published_at'])) ?></lastmod>
  </url>
  <?php endforeach; ?>

</urlset>
