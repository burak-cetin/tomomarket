<?php
require_once __DIR__ . '/config/site.php';
require_once __DIR__ . '/includes/functions.php';

$brands   = getBrands();
$products = getAllActiveProducts();
$depth    = '';
$currentPage = 'home';

$seoTitle    = 'TomografiMarket — Dental Tomografi ve Görüntüleme Cihazları Türkiye';
$seoDesc     = 'Türkiye\'nin en kapsamlı dental tomografi ve görüntüleme platformu. LargeV, HDXWILL, Vatech, Planmeca, Sirona, Morita ve daha fazla markadan 40+ model. Fiyat ve teknik bilgi için hemen iletişime geçin.';
$seoKeywords = 'dental tomografi, cbct, diş tomografisi, dental görüntüleme, panoramik röntgen, dental röntgen cihazı, dental cbct fiyat, 3d diş tomografisi';
$canonical   = SITE_URL . '/';

// JSON-LD — ItemList for all brands
$brandSchemas = [];
$brandListItems = [];
foreach ($brands as $i => $b) {
    $brandListItems[] = [
        '@type'    => 'ListItem',
        'position' => $i + 1,
        'url'      => SITE_URL . '/markalar/' . $b['slug'] . '-tomografi.php',
        'name'     => $b['name'] . ' Dental Tomografi Cihazları',
    ];
}
$itemListSchema = '<script type="application/ld+json">' . json_encode([
    '@context'        => 'https://schema.org',
    '@type'           => 'ItemList',
    'name'            => 'Dental Tomografi Markaları',
    'description'     => 'TomografiMarket\'te satışta olan dental tomografi ve görüntüleme cihazı markaları',
    'itemListElement' => $brandListItems,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';

$extraSchemas = [$itemListSchema];

require __DIR__ . '/includes/header.php';
?>
<meta name="base-depth" content="">

<!-- ═══ HERO ══════════════════════════════════════════════ -->
<section class="hero">
  <div class="hero-container">
    <div class="hero-content">
      <h2><span class="highlight">Geleceğin</span> Dental Görüntüleme Teknolojisi</h2>
      <p class="hero-description">
        Dünya standardında dental tomografi cihazları ve görüntüleme ekipmanlarıyla tanışın.
        Uluslararası markalar ve yüzlerce model arasından kliniğiniz için en uygun çözümü bulun.
      </p>
      <div class="hero-buttons">
        <button class="btn-primary" onclick="document.getElementById('brands').scrollIntoView({behavior:'smooth'})">Ürünleri Keşfet</button>
        <button class="btn-secondary" onclick="openContactModal()">İletişime Geç</button>
      </div>
    </div>
    <div class="hero-stats">
      <div class="stat-box"><div class="stat-number"><?= count($brands) ?>+</div><div class="stat-label">Dünya Markası</div></div>
      <div class="stat-box"><div class="stat-number"><?= count($products) ?>+</div><div class="stat-label">Gelişmiş Model</div></div>
      <div class="stat-box"><div class="stat-number">100+</div><div class="stat-label">Mutlu Kullanıcı</div></div>
      <div class="stat-box"><div class="stat-number">7/24</div><div class="stat-label">Teknik Destek</div></div>
    </div>
  </div>
</section>

<!-- ═══ BRANDS ════════════════════════════════════════════ -->
<section id="brands" class="brands-section">
  <div class="section-header">
    <span class="section-tag">Markalar</span>
    <h2 class="section-title">Dental Tomografi Cihazları</h2>
    <p class="section-description">Dünya çapında güvenilen premium markalardan, kliniğiniz için en uygun dental tomografi cihazını keşfedin.</p>
  </div>
  <div class="brands-grid">
    <?php foreach ($brands as $b): ?>
    <a href="markalar/<?= h($b['slug']) ?>-tomografi.php" class="brand-card" title="<?= h($b['name']) ?> Dental Tomografi Cihazları">
      <img src="<?= h($b['logo']) ?>" alt="<?= h($b['name']) ?> Logo" loading="lazy">
    </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- ═══ ALL PRODUCTS ══════════════════════════════════════ -->
<section id="urunler" style="background:var(--bg-primary);padding:1rem 0">
  <div class="section-header">
    <span class="section-tag">Tüm Ürünler</span>
    <h2 class="section-title">Dental CBCT ve Görüntüleme Sistemleri</h2>
    <p class="section-description">Farklı marka ve modellerdeki tüm dental görüntüleme sistemlerini keşfedin.</p>
  </div>

  <!-- Filter Bar -->
  <div style="padding:.5rem 5% 1.5rem;max-width:1400px;margin:0 auto;display:flex;gap:1rem;flex-wrap:wrap;align-items:center">
    <input type="text" id="product-search" placeholder="Cihaz ara..." class="filter-search" style="flex:1;min-width:180px">
    <select id="product-brand-filter" class="filter-select">
      <option value="">Tüm Markalar</option>
      <?php foreach ($brands as $b): ?>
      <option value="<?= h($b['slug']) ?>"><?= h($b['name']) ?></option>
      <?php endforeach; ?>
    </select>
    <select id="product-type-filter" class="filter-select">
      <option value="">Tüm Tipler</option>
      <option value="3d">3D CBCT</option>
      <option value="2d">2D Panoramik</option>
    </select>
  </div>

  <div class="products-grid" id="products-grid" style="padding:0 5% 4rem;max-width:1400px;margin:0 auto">
    <?php foreach ($products as $p): ?>
    <div class="product-card" data-brand="<?= h($p['brand_slug']) ?>" data-type="<?= strpos(strtolower($p['goruntuleme']??''), '3d') !== false ? '3d' : '2d' ?>">
      <a href="urunler/<?= h($p['slug']) ?>-detay.php" class="product-image-link">
        <div class="product-image-container">
          <?php if ($p['badge']): ?>
          <span class="product-badge badge-<?= h($p['badge_type']) ?>"><?= h($p['badge']) ?></span>
          <?php endif; ?>
          <img src="<?= h($p['image']) ?>" alt="<?= h($p['brand_name']) ?> <?= h($p['name']) ?> Dental Tomografi Cihazı" loading="lazy">
        </div>
      </a>
      <div class="product-content">
        <span class="product-brand-tag"><?= h($p['brand_name']) ?></span>
        <h3><?= h($p['name']) ?></h3>
        <p class="product-description"><?= h($p['tagline'] ?: substr($p['description']??'', 0, 120) . '...') ?></p>
        <ul class="product-features">
          <?php if ($p['goruntuleme']): ?><li><?= h($p['goruntuleme']) ?></li><?php endif; ?>
          <?php if ($p['fov'] && $p['fov'] !== '—'): ?><li>FOV: <?= h($p['fov']) ?></li><?php endif; ?>
          <?php if ($p['voksel'] && $p['voksel'] !== '—'): ?><li>Voksel: <?= h($p['voksel']) ?></li><?php endif; ?>
          <?php if ($p['tarama_suresi']): ?><li>Tarama: <?= h($p['tarama_suresi']) ?></li><?php endif; ?>
        </ul>
        <div class="product-actions">
          <?php if ($p['brochure']): ?>
          <button class="btn-contact" onclick="window.open('<?= h($p['brochure']) ?>','_blank')">📄 Broşür</button>
          <?php endif; ?>
          <button class="btn-details" onclick="location.href='urunler/<?= h($p['slug']) ?>-detay.php'">Detaylar</button>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ═══ FEATURES / HAKKIMIZDA ════════════════════════════ -->
<section id="aboutus" class="features-section">
  <div class="features-container">
    <div class="features-content">
      <h3>Neden TomografiMarket'i Tercih Etmeliyim?</h3>
      <p>
        Dental görüntüleme alanındaki en yeni teknolojileri ve cihazları tarafsız bir bakış açısıyla tanıtıyor ve karşılaştırıyoruz.
        Amacımız, sağlık profesyonellerine doğru ve güncel bilgiler sunarak, ihtiyaçlarına en uygun çözümleri belirlemelerinde destek olmaktır.
      </p>
    </div>
    <div class="features-grid">
      <div class="feature-item"><div class="feature-icon">🏆</div><h4>Premium Markalar</h4><p>Dünya standartlarında kaliteli ekipmanlar</p></div>
      <div class="feature-item"><div class="feature-icon">🔧</div><h4>Teknik Destek</h4><p>7/24 uzman teknik destek hizmeti</p></div>
      <div class="feature-item"><div class="feature-icon">💎</div><h4>Yenilikçi Teknoloji</h4><p>En son teknolojiye sahip cihazlar</p></div>
      <div class="feature-item"><div class="feature-icon">🎯</div><h4>Özel Çözümler</h4><p>İhtiyacınıza özel paketler</p></div>
    </div>
  </div>
</section>

<!-- ═══ FAQ ═══════════════════════════════════════════════ -->
<?php
$faqs = [
    ['q'=>'CBCT ile panoramik röntgen arasındaki fark nedir?', 'a'=>'Panoramik röntgen (OPG) 2 boyutlu düzlemsel görüntü sunarken, CBCT (Cone Beam CT) üç boyutlu hacimsel veri elde eder. CBCT, implant planlaması, kanal tedavisi ve cerrahi planlamada çok daha fazla bilgi sağlar.'],
    ['q'=>'Kliniğim için doğru dental tomografi cihazını nasıl seçebilirim?', 'a'=>'Doğru cihaz seçimi için kliniğinizin uzmanlık alanına (implant, ortodonti, endodonti vb.), günlük hasta sayısına, mekân ölçülerinize ve bütçenize göre değerlendirme yapılmalıdır. TomografiMarket uzmanlarımız size özel analiz sunmaktadır.'],
    ['q'=>'Dental tomografi cihazı fiyatları nasıl belirlenir?', 'a'=>'Fiyatlar; cihazın menşei, görüntüleme modu (2D/3D), FOV boyutu, dedektör teknolojisi, yazılım paketi ve kurulum gereksinimine göre değişmektedir. Detaylı fiyat bilgisi için bize ulaşın.'],
    ['q'=>'İkinci el dental tomografi cihazı almak mantıklı mıdır?', 'a'=>'Bakım geçmişi belgelenmiş, yetkili servisi olan markaların ikinci el cihazları bütçe dostu seçenek olabilir. Ancak dedektör ve X-ray tüpü durumu mutlaka uzman tarafından değerlendirilmelidir. Platformumuzda güvenilir ikinci el ilanlarına ulaşabilirsiniz.'],
    ['q'=>'Türkiye\'de dental tomografi için hangi markalar yaygın olarak kullanılıyor?', 'a'=>'Türkiye\'de Vatech, Planmeca, Sirona (Dentsply Sirona), NewTom, Carestream ve HDXWILL en yaygın kullanılan markalar arasındadır. Son yıllarda LargeV ve MyRay da önemli pay almaktadır.'],
];
renderFAQSchema($faqs);
?>
<section class="faq-section">
  <h2>Sık Sorulan Sorular</h2>
  <?php foreach ($faqs as $faq): ?>
  <div class="faq-item">
    <div class="faq-question">
      <span><?= h($faq['q']) ?></span>
      <span class="faq-icon">+</span>
    </div>
    <div class="faq-answer"><?= h($faq['a']) ?></div>
  </div>
  <?php endforeach; ?>
</section>

<!-- ═══ CTA ════════════════════════════════════════════════ -->
<section class="cta-section">
  <h2>Kliniğiniz İçin En Uygun Cihazı Bulalım</h2>
  <p>Uzman ekibimiz, ihtiyaçlarınızı analiz ederek size en doğru dental görüntüleme çözümünü sunar.</p>
  <div class="cta-buttons">
    <button class="btn-cta-white" onclick="openContactModal()">Ücretsiz Danışmanlık Al</button>
    <a href="sayfalar/karsilastirma.php" class="btn-cta-outline">Cihazları Karşılaştır</a>
  </div>
</section>

<script>
filterCards('product-search','product-brand-filter','#products-grid','.product-card');
document.getElementById('product-type-filter')?.addEventListener('change', function() {
  const val = this.value;
  document.querySelectorAll('#products-grid .product-card').forEach(function(c) {
    c.style.display = (!val || c.dataset.type === val) ? '' : 'none';
  });
});
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
