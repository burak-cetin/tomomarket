<?php
require_once __DIR__ . '/../config/site.php';
require_once __DIR__ . '/../includes/functions.php';

$allProducts = getAllActiveProducts();
$depth       = '../';
$currentPage = 'karsilastirma';

$seoTitle    = 'Dental Tomografi Cihazı Karşılaştırma | TomografiMarket';
$seoDesc     = 'Dental CBCT ve panoramik röntgen cihazlarını yan yana karşılaştırın. Teknik özellikler, FOV, voksel boyutu, sensör teknolojisi ve daha fazlası.';
$seoKeywords = 'dental tomografi karşılaştırma, cbct karşılaştırma, dental cihaz karşılaştır';
$canonical   = SITE_URL . '/sayfalar/karsilastirma.php';

require __DIR__ . '/../includes/header.php';
?>
<meta name="base-depth" content="../">

<!-- Breadcrumb -->
<div class="breadcrumb">
  <div class="breadcrumb-container">
    <a href="../index.php">Ana Sayfa</a>
    <span class="breadcrumb-sep">›</span>
    <span class="breadcrumb-current">Cihaz Karşılaştırma</span>
  </div>
</div>

<!-- Hero -->
<section style="background:linear-gradient(135deg,#0f172a,#1e293b);color:#fff;padding:3rem 5%;text-align:center">
  <h1 style="font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:800;margin-bottom:.75rem">Dental Tomografi Karşılaştırma</h1>
  <p style="opacity:.85;max-width:600px;margin:0 auto">Karşılaştırmak istediğiniz cihazları seçin (en fazla 4 cihaz).</p>
</section>

<div style="padding:2rem 5%;max-width:1400px;margin:0 auto">

  <!-- Product Selector -->
  <div style="background:var(--bg-primary);border:1px solid var(--border);border-radius:16px;padding:2rem;margin-bottom:2rem">
    <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.25rem;margin-bottom:1.25rem">Karşılaştırılacak Cihazları Seçin</h2>
    <div style="display:flex;gap:1rem;flex-wrap:wrap;align-items:flex-end">
      <?php for ($i = 1; $i <= 4; $i++): ?>
      <div style="flex:1;min-width:200px">
        <label style="display:block;font-size:.85rem;font-weight:600;margin-bottom:.4rem;color:var(--text-secondary)">Cihaz <?= $i ?></label>
        <select id="sel-<?= $i ?>" class="filter-select" style="width:100%" onchange="updateComparison()">
          <option value="">— Seçiniz —</option>
          <?php foreach ($allProducts as $prod): ?>
          <option value="<?= h($prod['slug']) ?>"><?= h($prod['brand_name'] . ' ' . $prod['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <?php endfor; ?>
      <button class="btn-secondary" onclick="clearAll()">Temizle</button>
    </div>
  </div>

  <!-- Comparison Table -->
  <div id="comparison-result" style="display:none">
    <div class="comparison-table-wrapper">
      <table class="comparison-table" id="comp-table">
        <thead>
          <tr id="comp-header">
            <th style="width:200px">Özellik</th>
          </tr>
        </thead>
        <tbody id="comp-body"></tbody>
      </table>
    </div>
  </div>

  <div id="comparison-empty" style="text-align:center;padding:4rem;color:var(--text-secondary)">
    <div style="font-size:3rem;margin-bottom:1rem">⚖️</div>
    <p>Karşılaştırmak için yukarıdan cihaz seçin.</p>
  </div>
</div>

<!-- CTA -->
<section class="cta-section">
  <h2>Hangi Cihaz Kliniğinize Uygun?</h2>
  <p>Uzmanlarımız kliniğinizin ihtiyaçlarını analiz ederek size en doğru seçimi önerir.</p>
  <div class="cta-buttons">
    <button class="btn-cta-white" onclick="openContactModal()">Ücretsiz Danışmanlık</button>
  </div>
</section>

<script>
// Tüm ürün verisi PHP'den JS'e aktar
var allProductsData = <?= json_encode(array_column($allProducts, null, 'slug'), JSON_UNESCAPED_UNICODE) ?>;

var specRows = [
  { key: 'brand_name',     label: 'Marka' },
  { key: 'goruntuleme',    label: 'Görüntüleme Modu' },
  { key: 'fov',            label: 'FOV (Alan)' },
  { key: 'voksel',         label: 'Voksel Boyutu' },
  { key: 'tarama_suresi',  label: 'Tarama Süresi' },
  { key: 'voltaj',         label: 'Voltaj' },
  { key: 'akim',           label: 'Akım' },
  { key: 'rekonstruksiyon',label: 'Rekonstrüksiyon' },
  { key: 'sensor',         label: 'Sensör Teknolojisi' },
  { key: 'mensei',         label: 'Menşei' },
  { key: 'dusuk_doz',      label: 'Düşük Doz', bool: true },
  { key: 'panoramik',      label: 'Panoramik', bool: true },
  { key: 'sefalometrik',   label: 'Sefalometrik', bool: true },
  { key: 'ai_destekli',    label: 'AI Destekli', bool: true },
  { key: 'kompakt',        label: 'Kompakt Tasarım', bool: true },
  { key: 'hizli_tarama',   label: 'Hızlı Tarama', bool: true },
];

function getSelected() {
  var selected = [];
  for (var i = 1; i <= 4; i++) {
    var slug = document.getElementById('sel-' + i).value;
    if (slug && allProductsData[slug]) selected.push(allProductsData[slug]);
  }
  return selected;
}

function updateComparison() {
  var items = getSelected();
  var empty = document.getElementById('comparison-empty');
  var result = document.getElementById('comparison-result');

  if (items.length < 2) {
    result.style.display = 'none';
    empty.style.display = 'block';
    empty.querySelector('p').textContent = items.length === 1
      ? 'En az 2 cihaz seçin.'
      : 'Karşılaştırmak için yukarıdan cihaz seçin.';
    return;
  }

  result.style.display = 'block';
  empty.style.display = 'none';

  // Header
  var header = document.getElementById('comp-header');
  header.innerHTML = '<th style="width:200px">Özellik</th>';
  items.forEach(function(p) {
    header.innerHTML += '<th><a href="../urunler/' + p.slug + '-detay.php" style="color:#fff">' +
      p.brand_name + '<br>' + p.name + '</a></th>';
  });

  // Body
  var body = document.getElementById('comp-body');
  body.innerHTML = '';

  specRows.forEach(function(row) {
    var tr = document.createElement('tr');
    var labelTd = document.createElement('td');
    labelTd.style.fontWeight = '600';
    labelTd.style.color = 'var(--text-secondary)';
    labelTd.style.fontSize = '.85rem';
    labelTd.textContent = row.label;
    tr.appendChild(labelTd);

    items.forEach(function(p) {
      var td = document.createElement('td');
      if (row.bool) {
        td.innerHTML = p[row.key] == 1
          ? '<span class="yes-icon">✓ Evet</span>'
          : '<span class="no-icon">— Hayır</span>';
      } else {
        td.textContent = p[row.key] || '—';
      }
      tr.appendChild(td);
    });
    body.appendChild(tr);
  });

  // Action row
  var actionTr = document.createElement('tr');
  var emptyTd = document.createElement('td');
  actionTr.appendChild(emptyTd);
  items.forEach(function(p) {
    var td = document.createElement('td');
    td.innerHTML = '<button class="btn-details" style="margin:.25rem" onclick="openContactModal(\'' + p.brand_name + ' ' + p.name + '\')">Teklif Al</button>' +
      '<button class="btn-contact" style="margin:.25rem" onclick="location.href=\'../urunler/' + p.slug + '-detay.php\'">Detaylar</button>';
    actionTr.appendChild(td);
  });
  body.appendChild(actionTr);
}

function clearAll() {
  for (var i = 1; i <= 4; i++) {
    document.getElementById('sel-' + i).value = '';
  }
  updateComparison();
}

// URL query'den ön seçim
(function() {
  var params = new URLSearchParams(window.location.search);
  var slugs = (params.get('slugs') || '').split(',').filter(Boolean);
  slugs.slice(0,4).forEach(function(slug, idx) {
    var sel = document.getElementById('sel-' + (idx+1));
    if (sel) { sel.value = slug; }
  });
  if (slugs.length > 0) updateComparison();
})();
</script>

<?php require __DIR__ . '/../includes/footer.php'; ?>
