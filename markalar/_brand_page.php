<?php
// markalar/[brand-slug] (clean URL)
// .htaccess ile markalar/vatech → bu dosya
require_once __DIR__ . '/../config/site.php';
require_once __DIR__ . '/../includes/functions.php';

// Slug tespiti: query string veya dosya adindan
$rawSlug = '';
if (!empty($_GET['brand'])) {
    $rawSlug = preg_replace('/[^a-z0-9\-]/', '', strtolower($_GET['brand']));
} else {
    $file = basename($_SERVER['PHP_SELF'], '.php');
    // Eski format: vatech-tomografi → vatech
    if (preg_match('/^(.+)-tomografi$/', $file, $m)) {
        $rawSlug = $m[1];
    } else {
        $rawSlug = $file;
    }
}

$brand = getBrandBySlug($rawSlug);
if (!$brand) {
    header('HTTP/1.0 404 Not Found');
    die('<h1>404 — Marka bulunamadı</h1>');
}

$products = getProductsByBrand($brand['id']);
$depth    = '../';
$currentPage = '';

$seoTitle    = $brand['seo_title'] ?: ($brand['name'] . ' Dental Tomografi Cihazları' . SEO_TITLE_SUFFIX);
$seoDesc     = $brand['seo_desc'] ?: ('TomografiMarket\'te ' . $brand['name'] . ' markasının tüm dental tomografi ve görüntüleme cihazlarını inceleyin.');
$seoKeywords = $brand['seo_keywords'] ?: ($brand['name'] . ' tomografi, ' . $brand['name'] . ' cbct, dental tomografi');
$canonical   = SITE_URL . '/markalar/' . $brand['slug'];
$ogImage     = $brand['logo'] ?? '';

// Structured Data
$productSchemas = '';
foreach ($products as $p) {
    ob_start();
    renderProductSchema(array_merge($p, ['brand_name' => $brand['name']]));
    $productSchemas .= ob_get_clean();
}
$breadcrumbSchema = '';
ob_start();
renderBreadcrumbSchema([
    ['TomografiMarket', SITE_URL],
    ['Markalar', SITE_URL . '/#brands'],
    [$brand['name'] . ' Tomografi', $canonical],
]);
$breadcrumbSchema = ob_get_clean();
$extraSchemas = [$productSchemas, $breadcrumbSchema];

require __DIR__ . '/../includes/header.php';
?>
<meta name="base-depth" content="../">

<!-- Breadcrumb -->
<div class="breadcrumb">
  <div class="breadcrumb-container">
    <a href="../">Ana Sayfa</a>
    <span class="breadcrumb-sep">›</span>
    <a href="../#brands">Markalar</a>
    <span class="breadcrumb-sep">›</span>
    <span class="breadcrumb-current"><?= h($brand['name']) ?> Dental Tomografi</span>
  </div>
</div>

<!-- Brand Header -->
<section class="brand-header">
  <div class="brand-header-container">
    <div class="brand-logo-box">
      <img src="../<?= h(resolveImage($brand['logo'])) ?>" alt="<?= h($brand['name']) ?> Logo" width="160" height="80">
    </div>
    <div class="brand-info">
      <?php if ($brand['origin']): ?>
      <span style="display:inline-block;background:var(--bg-tertiary);color:var(--primary);padding:.3rem .8rem;border-radius:20px;font-size:.8rem;font-weight:600;margin-bottom:.75rem">
        🌍 <?= h($brand['origin']) ?> Menşeli
      </span>
      <?php endif; ?>
      <h1><?= h($brand['name']) ?> Dental Tomografi Cihazları</h1>
      <p><?= h($brand['description'] ?? '') ?></p>
      <button class="brand-cta-button" onclick="openContactModal('<?= h($brand['name']) ?>')">
        ✉ <?= h($brand['name']) ?> Hakkında Bilgi Al
      </button>
    </div>
  </div>
</section>

<!-- Products -->
<section class="products-section">
  <h2 class="section-title"><?= h($brand['name']) ?> Dental CBCT Sistemleri</h2>
  <p style="color:var(--text-secondary);text-align:center;margin-bottom:2rem">
    <?= h($brand['name']) ?>'in öne çıkan dental görüntüleme cihazlarını keşfedin.
  </p>

  <?php if (empty($products)): ?>
    <p style="text-align:center;color:var(--text-secondary);padding:3rem">Bu markaya ait ürün bulunamadı.</p>
  <?php else: ?>
  <div class="products-grid">
    <?php foreach ($products as $p): ?>
    <div class="product-card">
      <a href="../urunler/<?= h($p['slug']) ?>" class="product-image-link">
        <div class="product-image-container">
          <?php if ($p['badge']): ?>
          <span class="product-badge badge-<?= h($p['badge_type']) ?>"><?= h($p['badge']) ?></span>
          <?php endif; ?>
          <img src="../<?= h(resolveImage($p['image'])) ?>" alt="<?= h($brand['name']) ?> <?= h($p['name']) ?> Dental Tomografi Cihazı" loading="lazy">
        </div>
      </a>
      <div class="product-content">
        <span class="product-brand-tag"><?= h($brand['name']) ?></span>
        <h2><?= h($p['name']) ?></h2>
        <p class="product-description"><?= h($p['tagline'] ?: substr($p['description']??'',0,120).'...') ?></p>
        <ul class="product-features">
          <?php if ($p['goruntuleme']): ?><li><?= h($p['goruntuleme']) ?></li><?php endif; ?>
          <?php if ($p['fov'] && $p['fov']!=='—'): ?><li>FOV: <?= h($p['fov']) ?></li><?php endif; ?>
          <?php if ($p['voksel'] && $p['voksel']!=='—'): ?><li>Voksel: <?= h($p['voksel']) ?></li><?php endif; ?>
          <?php if ($p['tarama_suresi']): ?><li>Tarama Süresi: <?= h($p['tarama_suresi']) ?></li><?php endif; ?>
          <?php if ($p['sensor']): ?><li>Sensör: <?= h($p['sensor']) ?></li><?php endif; ?>
        </ul>
        <div class="product-actions">
          <?php if ($p['brochure']): ?>
          <button class="btn-contact" onclick="window.open('../<?= h($p['brochure']) ?>','_blank')">📄 Broşür İndir</button>
          <?php else: ?>
          <button class="btn-contact" onclick="openContactModal('<?= h($brand['name'].' '.$p['name']) ?>')">✉ Bilgi Al</button>
          <?php endif; ?>
          <button class="btn-details" onclick="location.href='../urunler/<?= h($p['slug']) ?>'">Detaylar</button>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>

<!-- CTA -->
<section class="cta-section">
  <h2><?= h($brand['name']) ?> Hakkında Daha Fazla Bilgi Alın</h2>
  <p>Uzman ekibimiz, <?= h($brand['name']) ?> ürünleri hakkında size detaylı bilgi sunmaktan memnuniyet duyar.</p>
  <div class="cta-buttons">
    <button class="btn-cta-white" onclick="openContactModal('<?= h($brand['name']) ?>')">Fiyat Teklifi İste</button>
    <a href="../sayfalar/karsilastirma" class="btn-cta-outline">Cihazları Karşılaştır</a>
  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
