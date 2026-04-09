<?php
require_once __DIR__ . '/config/site.php';
require_once __DIR__ . '/includes/functions.php';

$listings = getSecondHandListings(true, 50);
$depth    = '';
$currentPage = 'ikinci-el';

$seoTitle    = 'İkinci El Dental Tomografi Cihazları | TomografiMarket';
$seoDesc     = 'TomografiMarket\'te ikinci el dental tomografi ve görüntüleme cihazları. CBCT, panoramik röntgen ve daha fazlası. Güvenilir satıcılardan uygun fiyatlı kullanılmış dental ekipmanlar.';
$seoKeywords = 'ikinci el dental tomografi, kullanılmış cbct, ikinci el panoramik röntgen, ikinci el dental cihaz, dental cihaz al sat';
$canonical   = SITE_URL . '/ikinci-el.php';

ob_start();
renderBreadcrumbSchema([
    ['TomografiMarket', SITE_URL],
    ['İkinci El Dental Tomografi', $canonical],
]);
$bcSchema = ob_get_clean();
$extraSchemas = [$bcSchema];

require __DIR__ . '/includes/header.php';
?>
<meta name="base-depth" content="">

<!-- Hero -->
<section class="second-hand-hero">
  <h1>İkinci El Dental Tomografi</h1>
  <p>Güvenilir satıcılardan uygun fiyatlı, kontrollü ikinci el dental tomografi ve görüntüleme cihazları.</p>
  <button class="btn-cta-white" onclick="openContactModal()">Cihazınızı Satmak İstiyor musunuz?</button>
</section>

<!-- Filters -->
<div class="second-hand-filters">
  <div class="filters-container">
    <input type="text" id="sh-search" class="filter-search" placeholder="Marka veya model ara...">
    <select id="sh-brand" class="filter-select">
      <option value="">Tüm Markalar</option>
      <?php
      $brands = array_unique(array_filter(array_column($listings, 'brand')));
      sort($brands);
      foreach ($brands as $b): ?>
      <option value="<?= h(strtolower($b)) ?>"><?= h($b) ?></option>
      <?php endforeach; ?>
    </select>
    <select id="sh-condition" class="filter-select">
      <option value="">Tüm Durumlar</option>
      <option value="mükemmel">Mükemmel</option>
      <option value="çok iyi">Çok İyi</option>
      <option value="iyi">İyi</option>
    </select>
    <select id="sh-city" class="filter-select">
      <option value="">Tüm Şehirler</option>
      <?php
      $cities = array_unique(array_filter(array_column($listings, 'city')));
      sort($cities);
      foreach ($cities as $c): ?>
      <option value="<?= h(strtolower($c)) ?>"><?= h($c) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<!-- Listings -->
<div class="second-hand-grid" id="sh-grid">
  <?php if (empty($listings)): ?>
  <div style="grid-column:1/-1;text-align:center;padding:4rem;color:var(--text-secondary)">
    <div style="font-size:3rem;margin-bottom:1rem">📭</div>
    <h2>Henüz ilan bulunmuyor</h2>
    <p style="margin-top:.5rem">İkinci el cihaz satmak istiyorsanız bizimle iletişime geçin.</p>
    <button class="btn-primary" style="margin-top:1.5rem" onclick="openContactModal()">İlan Ver</button>
  </div>
  <?php else: ?>
    <?php foreach ($listings as $item): ?>
    <div class="sh-card"
         data-brand="<?= h(strtolower($item['brand']??'')) ?>"
         data-condition="<?= h($item['condition']) ?>"
         data-city="<?= h(strtolower($item['city']??'')) ?>"
         data-text="<?= h(strtolower($item['title'].' '.$item['brand'].' '.$item['model'])) ?>">
      <div class="sh-card-image">
        <?php if ($item['featured']): ?><span class="sh-featured-badge">⭐ Öne Çıkan</span><?php endif; ?>
        <?php if ($item['image']): ?>
        <img src="uploads/second-hand/<?= h($item['image']) ?>" alt="<?= h($item['title']) ?>" loading="lazy">
        <?php else: ?>
        <div class="sh-no-image">📷</div>
        <?php endif; ?>
      </div>
      <div class="sh-card-content">
        <span class="sh-brand"><?= h($item['brand'] ?? 'Belirtilmemiş') ?></span>
        <h3><?= h($item['title']) ?></h3>
        <div class="sh-meta">
          <?php if ($item['model']): ?>
          <span class="sh-meta-item">🔖 <?= h($item['model']) ?></span>
          <?php endif; ?>
          <?php if ($item['year']): ?>
          <span class="sh-meta-item">📅 <?= h($item['year']) ?></span>
          <?php endif; ?>
          <span class="sh-condition <?= conditionClass($item['condition']) ?>"><?= conditionLabel($item['condition']) ?></span>
        </div>
        <?php if ($item['description']): ?>
        <p style="font-size:.85rem;color:var(--text-secondary);line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
          <?= h($item['description']) ?>
        </p>
        <?php endif; ?>
        <div class="sh-price">
          <?php if ($item['price']): ?>
            <?= number_format($item['price'], 0, ',', '.') ?> <?= h($item['currency']) ?>
          <?php else: ?>
            <span class="sh-price-tbd">Fiyat için iletişime geçin</span>
          <?php endif; ?>
        </div>
      </div>
      <div class="sh-actions">
        <?php if ($item['city']): ?>
        <span class="sh-city">📍 <?= h($item['city']) ?></span>
        <?php endif; ?>
        <button class="btn-details" style="margin-left:auto"
          onclick="openContactModal('İkinci El: <?= h($item['brand'].' '.$item['model']) ?>')">
          Bilgi Al
        </button>
      </div>
    </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<!-- Info Section -->
<section style="background:var(--bg-primary);padding:4rem 5%">
  <div style="max-width:900px;margin:0 auto">
    <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.8rem;font-weight:700;margin-bottom:1.5rem;text-align:center">
      İkinci El Dental Cihaz Alırken Dikkat Edilmesi Gerekenler
    </h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.5rem">
      <?php
      $tips = [
          ['icon'=>'📋', 'title'=>'Bakım Geçmişini Kontrol Edin', 'desc'=>'Yetkili servis kayıtlarını ve bakım belgelerini mutlaka isteyin.'],
          ['icon'=>'🔬', 'title'=>'Teknik Ekspertiz Yaptırın', 'desc'=>'Satın almadan önce uzman teknik ekibimizin cihazı incelemesini sağlayın.'],
          ['icon'=>'💾', 'title'=>'Yazılım Uyumluluğunu Sorun', 'desc'=>'Cihazın güncel işletim sistemleriyle ve DICOM standardıyla uyumlu olduğunu doğrulayın.'],
          ['icon'=>'🔧', 'title'=>'Yedek Parça Bulunabilirliği', 'desc'=>'Türkiye\'de yetkili servis ve yedek parça temin imkânını araştırın.'],
      ];
      foreach ($tips as $tip): ?>
      <div class="feature-item">
        <div class="feature-icon"><?= $tip['icon'] ?></div>
        <h4><?= h($tip['title']) ?></h4>
        <p><?= h($tip['desc']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <h2>İkinci El Cihazınızı Satmak İster misiniz?</h2>
  <p>Platformumuza ilan ekleyin, binlerce diş hekimi adayına ulaşın. Ücretsiz ilan ve ekspertiz hizmetimizden yararlanın.</p>
  <div class="cta-buttons">
    <button class="btn-cta-white" onclick="openContactModal()">İlan Ver</button>
    <a href="blog/ikinci-el-dental-tomografi-alirken-dikkat-edilmesi-gerekenler.php" class="btn-cta-outline">Satın Alma Rehberi</a>
  </div>
</section>

<script>
(function() {
  var searchEl = document.getElementById('sh-search');
  var brandEl  = document.getElementById('sh-brand');
  var condEl   = document.getElementById('sh-condition');
  var cityEl   = document.getElementById('sh-city');

  function filter() {
    var q    = searchEl.value.toLowerCase();
    var b    = brandEl.value.toLowerCase();
    var cond = condEl.value.toLowerCase();
    var city = cityEl.value.toLowerCase();
    document.querySelectorAll('#sh-grid .sh-card').forEach(function(card) {
      var show = (!q || card.dataset.text.includes(q))
              && (!b    || card.dataset.brand === b)
              && (!cond || card.dataset.condition === cond)
              && (!city || card.dataset.city === city);
      card.style.display = show ? '' : 'none';
    });
  }

  [searchEl, brandEl, condEl, cityEl].forEach(function(el) {
    el?.addEventListener('change', filter);
    el?.addEventListener('input', filter);
  });
})();
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
