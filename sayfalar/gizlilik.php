<?php
require_once __DIR__ . '/../config/site.php';
require_once __DIR__ . '/../includes/functions.php';
$depth = '../';
$currentPage = '';
$seoTitle = 'Gizlilik Politikası | TomografiMarket';
$seoDesc  = 'TomografiMarket gizlilik politikası. Kişisel verilerin korunması, çerez kullanımı ve veri güvenliği hakkında bilgi.';
$canonical = SITE_URL . '/sayfalar/gizlilik';
require __DIR__ . '/../includes/header.php';
?>
<meta name="base-depth" content="../">
<div class="breadcrumb"><div class="breadcrumb-container">
  <a href="../">Ana Sayfa</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current">Gizlilik Politikası</span>
</div></div>

<div style="max-width:900px;margin:0 auto;padding:4rem 5%">
  <h1 style="font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:800;margin-bottom:.5rem">Gizlilik Politikası</h1>
  <p style="color:var(--text-secondary);margin-bottom:3rem">Son güncelleme: <?= date('d.m.Y') ?></p>

  <div style="display:grid;gap:2rem">

    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.25rem;margin-bottom:1rem">Genel Bilgilendirme</h2>
      <p style="color:var(--text-secondary);line-height:1.8">
        TomografiMarket olarak, kullanıcılarımızın gizliliğine büyük önem veriyoruz. Bu politika, web sitemizi ziyaret ettiğinizde hangi bilgileri topladığımızı, bu bilgileri nasıl kullandığımızı ve nasıl koruduğumuzu açıklamaktadır.
      </p>
    </div>

    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.25rem;margin-bottom:1rem">Çerez (Cookie) Kullanımı</h2>
      <p style="color:var(--text-secondary);line-height:1.8;margin-bottom:.75rem">Sitemiz aşağıdaki çerezleri kullanmaktadır:</p>
      <ul style="color:var(--text-secondary);line-height:2;margin-left:1.5rem">
        <li><strong>Zorunlu Çerezler:</strong> Sitenin düzgün çalışması için gereklidir.</li>
        <li><strong>Analitik Çerezler:</strong> Ziyaretçi istatistiklerini anonim olarak toplar.</li>
        <li><strong>Fonksiyonel Çerezler:</strong> Karşılaştırma listesi gibi tercihlerinizi hatırlar.</li>
      </ul>
      <p style="color:var(--text-secondary);line-height:1.8;margin-top:.75rem">
        Tarayıcı ayarlarınızdan çerezleri devre dışı bırakabilirsiniz. Ancak bazı site özellikleri çalışmayabilir.
      </p>
    </div>

    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.25rem;margin-bottom:1rem">Toplanan Veriler</h2>
      <p style="color:var(--text-secondary);line-height:1.8">
        Sitemizi ziyaret ettiğinizde; IP adresiniz, tarayıcı türünüz, ziyaret ettiğiniz sayfalar ve ziyaret süreniz gibi teknik bilgiler anonim olarak kaydedilebilir. İletişim formunu doldurduğunuzda ad, e-posta ve telefon bilgileriniz toplanır.
      </p>
    </div>

    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.25rem;margin-bottom:1rem">Veri Güvenliği</h2>
      <p style="color:var(--text-secondary);line-height:1.8">
        Kişisel verileriniz SSL/TLS şifrelemesi ile iletilir ve güvenli sunucularda saklanır. Veritabanı erişimleri kısıtlı yetkilendirme ile korunmaktadır. Üçüncü taraf hizmet sağlayıcılarımız (Web3Forms) GDPR/KVKK uyumludur.
      </p>
    </div>

    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.25rem;margin-bottom:1rem">İletişim</h2>
      <p style="color:var(--text-secondary);line-height:1.8">
        Gizlilik politikamız hakkında sorularınız için:<br>
        📧 <a href="mailto:<?= SITE_EMAIL ?>"><?= SITE_EMAIL ?></a><br>
        📞 <a href="tel:<?= SITE_PHONE1 ?>">+90 (850) 303 78 93</a>
      </p>
    </div>

  </div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
