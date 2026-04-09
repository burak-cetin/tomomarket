<?php
require_once __DIR__ . '/../config/site.php';
require_once __DIR__ . '/../includes/functions.php';
$depth = '../';
$currentPage = '';
$seoTitle = 'KVKK Aydınlatma Metni | TomografiMarket';
$seoDesc  = 'TomografiMarket KVKK (Kişisel Verilerin Korunması Kanunu) kapsamında kişisel verilerin işlenmesine ilişkin aydınlatma metni.';
$canonical = SITE_URL . '/sayfalar/kvkk.php';
require __DIR__ . '/../includes/header.php';
?>
<meta name="base-depth" content="../">
<div class="breadcrumb"><div class="breadcrumb-container">
  <a href="../index.php">Ana Sayfa</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current">KVKK Aydınlatma Metni</span>
</div></div>

<div style="max-width:900px;margin:0 auto;padding:4rem 5%">
  <h1 style="font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:800;margin-bottom:.5rem">KVKK Aydınlatma Metni</h1>
  <p style="color:var(--text-secondary);margin-bottom:3rem">Son güncelleme: <?= date('d.m.Y') ?></p>

  <div style="display:grid;gap:2rem">

    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.25rem;margin-bottom:1rem">1. Veri Sorumlusu</h2>
      <p style="color:var(--text-secondary);line-height:1.8">
        6698 sayılı Kişisel Verilerin Korunması Kanunu ("KVKK") uyarınca, kişisel verileriniz veri sorumlusu sıfatıyla <strong>TomografiMarket</strong> tarafından aşağıda açıklanan kapsamda işlenebilecektir.
      </p>
    </div>

    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.25rem;margin-bottom:1rem">2. İşlenen Kişisel Veriler</h2>
      <p style="color:var(--text-secondary);line-height:1.8;margin-bottom:.75rem">İletişim formları aracılığıyla aşağıdaki veriler toplanmaktadır:</p>
      <ul style="color:var(--text-secondary);line-height:2;margin-left:1.5rem">
        <li>Ad ve Soyad</li>
        <li>E-posta adresi</li>
        <li>Telefon numarası</li>
        <li>Mesaj içeriği</li>
        <li>IP adresi (sistem güvenliği amacıyla)</li>
      </ul>
    </div>

    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.25rem;margin-bottom:1rem">3. Kişisel Verilerin İşlenme Amaçları</h2>
      <ul style="color:var(--text-secondary);line-height:2;margin-left:1.5rem">
        <li>İletişim taleplerinizin yanıtlanması</li>
        <li>Ürün ve hizmetler hakkında bilgi sunulması</li>
        <li>Teklif ve fiyat bilgisi gönderilmesi</li>
        <li>Yasal yükümlülüklerin yerine getirilmesi</li>
      </ul>
    </div>

    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.25rem;margin-bottom:1rem">4. Kişisel Verilerin Aktarılması</h2>
      <p style="color:var(--text-secondary);line-height:1.8">
        Kişisel verileriniz; yasal zorunluluklar dışında üçüncü taraflarla paylaşılmaz ve yurt dışına aktarılmaz. İletişim bildirim amacıyla yalnızca güvenli form hizmet sağlayıcılarıyla (Web3Forms) paylaşılabilir.
      </p>
    </div>

    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.25rem;margin-bottom:1rem">5. Haklarınız</h2>
      <p style="color:var(--text-secondary);line-height:1.8;margin-bottom:.75rem">KVKK'nın 11. maddesi uyarınca aşağıdaki haklarınızı kullanabilirsiniz:</p>
      <ul style="color:var(--text-secondary);line-height:2;margin-left:1.5rem">
        <li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
        <li>İşlenmişse buna ilişkin bilgi talep etme</li>
        <li>İşlenme amacını ve amacına uygun kullanılıp kullanılmadığını öğrenme</li>
        <li>Verilerin silinmesini veya yok edilmesini talep etme</li>
        <li>Düzeltilmesini talep etme</li>
      </ul>
      <p style="color:var(--text-secondary);line-height:1.8;margin-top:.75rem">
        Talepleriniz için: <a href="mailto:<?= SITE_EMAIL ?>"><?= SITE_EMAIL ?></a>
      </p>
    </div>

    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.25rem;margin-bottom:1rem">6. Veri Saklama Süresi</h2>
      <p style="color:var(--text-secondary);line-height:1.8">
        Kişisel verileriniz, yasal saklama süreleri ve işlenme amacı ortadan kalkana kadar muhafaza edilmektedir. İletişim kayıtları en fazla 3 yıl süreyle saklanmaktadır.
      </p>
    </div>

  </div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
