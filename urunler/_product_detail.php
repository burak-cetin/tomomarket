<?php
// urunler/[product-slug]-detay.php
require_once __DIR__ . '/../config/site.php';
require_once __DIR__ . '/../includes/functions.php';

// Slug tespiti
$rawSlug = '';
if (!empty($_GET['slug'])) {
    $rawSlug = preg_replace('/[^a-z0-9\-]/', '', strtolower($_GET['slug']));
} else {
    $file = basename($_SERVER['PHP_SELF'], '.php');
    if (preg_match('/^(.+)-detay$/', $file, $m)) {
        $rawSlug = $m[1];
    }
}

$p = getProductBySlug($rawSlug);
if (!$p) { header('HTTP/1.0 404 Not Found'); die('<h1>404 — Ürün bulunamadı</h1>'); }

$relatedProducts = getRelatedProducts($p['id'], $p['brand_id']);
$depth    = '../';
$currentPage = '';

$seoTitle    = $p['seo_title'] ?: ($p['brand_name'] . ' ' . $p['name'] . ' Dental Tomografi Cihazı' . SEO_TITLE_SUFFIX);
$seoDesc     = $p['seo_desc'] ?: ($p['brand_name'] . ' ' . $p['name'] . ' dental tomografi cihazı teknik özellikleri. ' . ($p['tagline'] ?? ''));
$seoKeywords = $p['seo_keywords'] ?: ($p['brand_name'] . ' ' . $p['name'] . ', dental tomografi, cbct');
$canonical   = SITE_URL . '/urunler/' . $p['slug'] . '-detay.php';
$ogImage     = $p['image'] ?? '';

ob_start(); renderProductSchema($p); $productSchemaStr = ob_get_clean();
ob_start(); renderBreadcrumbSchema([
    ['TomografiMarket', SITE_URL],
    [$p['brand_name'] . ' Tomografi', SITE_URL . '/markalar/' . $p['brand_slug'] . '-tomografi.php'],
    [$p['brand_name'] . ' ' . $p['name'], $canonical],
]); $breadcrumbSchemaStr = ob_get_clean();
$extraSchemas = [$productSchemaStr, $breadcrumbSchemaStr];

require __DIR__ . '/../includes/header.php';
?>
<meta name="base-depth" content="../">

<!-- Breadcrumb -->
<div class="breadcrumb">
  <div class="breadcrumb-container">
    <a href="../index.php">Ana Sayfa</a>
    <span class="breadcrumb-sep">›</span>
    <a href="../markalar/<?= h($p['brand_slug']) ?>-tomografi.php"><?= h($p['brand_name']) ?></a>
    <span class="breadcrumb-sep">›</span>
    <span class="breadcrumb-current"><?= h($p['name']) ?></span>
  </div>
</div>

<!-- Product Hero -->
<section class="product-hero">
  <div class="product-hero-container">
    <div class="product-image-section">
      <img src="../<?= h($p['image']) ?>" alt="<?= h($p['brand_name']) ?> <?= h($p['name']) ?> Dental Tomografi Cihazı" width="400">
    </div>
    <div class="product-info-section">
      <span class="product-brand"><?= h($p['brand_name']) ?></span>
      <h1><?= h($p['name']) ?></h1>
      <p class="product-tagline"><?= h($p['tagline'] ?: $p['description']) ?></p>

      <!-- Feature Chips -->
      <div class="feature-chips">
        <?php if ($p['goruntuleme']): ?><span class="chip"><?= h($p['goruntuleme']) ?></span><?php endif; ?>
        <?php if ($p['mensei'] && $p['mensei']!=='—'): ?><span class="chip">🌍 <?= h($p['mensei']) ?></span><?php endif; ?>
        <span class="chip <?= $p['dusuk_doz'] ? 'yes' : 'no' ?>"><?= $p['dusuk_doz'] ? '✓' : '✗' ?> Düşük Doz</span>
        <span class="chip <?= $p['panoramik'] ? 'yes' : 'no' ?>"><?= $p['panoramik'] ? '✓' : '✗' ?> Panoramik</span>
        <span class="chip <?= $p['sefalometrik'] ? 'yes' : 'no' ?>"><?= $p['sefalometrik'] ? '✓' : '✗' ?> Sefalometrik</span>
        <span class="chip <?= $p['ai_destekli'] ? 'yes' : 'no' ?>"><?= $p['ai_destekli'] ? '✓' : '✗' ?> AI Destekli</span>
        <span class="chip <?= $p['kompakt'] ? 'yes' : 'no' ?>"><?= $p['kompakt'] ? '✓' : '✗' ?> Kompakt</span>
        <span class="chip <?= $p['hizli_tarama'] ? 'yes' : 'no' ?>"><?= $p['hizli_tarama'] ? '✓' : '✗' ?> Hızlı Tarama</span>
      </div>

      <div class="product-cta" style="margin-top:2rem">
        <button class="btn-primary" onclick="openContactModal('<?= h($p['brand_name'].' '.$p['name']) ?>')">
          📩 Fiyat Teklifi İste
        </button>
        <?php if ($p['brochure']): ?>
        <button class="btn-secondary" onclick="window.open('../<?= h($p['brochure']) ?>','_blank')">
          📄 Broşür İndir
        </button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- Tech Specs -->
<section class="tech-specs">
  <div class="tech-specs-container">
    <div class="section-header" style="text-align:left;padding:0 0 2rem">
      <h2>Teknik Özellikler</h2>
      <p style="color:var(--text-secondary)"><?= h($p['brand_name']) ?> <?= h($p['name']) ?> detaylı teknik bilgileri</p>
    </div>
    <div class="specs-grid">
      <?php
      $specs = [
          'Görüntüleme Modu' => $p['goruntuleme'],
          'FOV (Alan)'       => $p['fov'],
          'Voksel Boyutu'    => $p['voksel'],
          'Tarama Süresi'    => $p['tarama_suresi'],
          'Voltaj Aralığı'   => $p['voltaj'],
          'Akım Aralığı'     => $p['akim'],
          'Rekonstrüksiyon'  => $p['rekonstruksiyon'],
          'Sensör Teknolojisi'=> $p['sensor'],
          'Menşei'           => $p['mensei'],
      ];
      foreach ($specs as $label => $val):
          if (!$val || $val === '—') continue;
      ?>
      <div class="spec-item">
        <div class="spec-label"><?= h($label) ?></div>
        <div class="spec-value"><span class="highlight"><?= h($val) ?></span></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Description -->
<?php if ($p['description']): ?>
<section style="padding:3rem 5%;max-width:1400px;margin:0 auto">
  <div class="admin-card">
    <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.5rem;margin-bottom:1rem">
      <?= h($p['brand_name']) ?> <?= h($p['name']) ?> Hakkında
    </h2>
    <p style="color:var(--text-secondary);line-height:1.8"><?= nl2br(h($p['description'])) ?></p>
  </div>
</section>
<?php endif; ?>

<!-- Related Products -->
<?php if (!empty($relatedProducts)): ?>
<section style="padding:2rem 5% 4rem;max-width:1400px;margin:0 auto">
  <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.6rem;margin-bottom:1.5rem">
    <?= h($p['brand_name']) ?> Diğer Modeller
  </h2>
  <div class="products-grid">
    <?php foreach ($relatedProducts as $r): ?>
    <div class="product-card">
      <a href="<?= h($r['slug']) ?>-detay.php" class="product-image-link">
        <div class="product-image-container">
          <img src="../<?= h($r['image']) ?>" alt="<?= h($r['brand_name']) ?> <?= h($r['name']) ?>" loading="lazy">
        </div>
      </a>
      <div class="product-content">
        <span class="product-brand-tag"><?= h($r['brand_name']) ?></span>
        <h3><?= h($r['name']) ?></h3>
        <p class="product-description"><?= h(substr($r['description']??'',0,100)) ?>...</p>
        <div class="product-actions">
          <button class="btn-details" onclick="location.href='<?= h($r['slug']) ?>-detay.php'">Detaylar</button>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="cta-section">
  <h2><?= h($p['brand_name']) ?> <?= h($p['name']) ?> için Teklif Alın</h2>
  <p>Kliniğinize en uygun konfigürasyonu ve fiyatı öğrenmek için hemen iletişime geçin.</p>
  <div class="cta-buttons">
    <button class="btn-cta-white" onclick="openContactModal('<?= h($p['brand_name'].' '.$p['name']) ?>')">Ücretsiz Teklif Al</button>
    <a href="../sayfalar/karsilastirma.php" class="btn-cta-outline">Diğer Modellerle Karşılaştır</a>
  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
