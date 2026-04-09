<?php
require_once __DIR__ . '/../config/site.php';
require_once __DIR__ . '/../includes/functions.php';
$depth = '../';
$currentPage = '';
$seoTitle = 'Hakkımızda | TomografiMarket';
$seoDesc  = 'TomografiMarket, dental tomografi ve görüntüleme cihazları alanında Türkiye\'nin güvenilir çözüm ortağı. Misyon, vizyon ve ekibimiz hakkında bilgi alın.';
$canonical = SITE_URL . '/sayfalar/hakkimizda.php';
require __DIR__ . '/../includes/header.php';
?>
<meta name="base-depth" content="../">
<div class="breadcrumb"><div class="breadcrumb-container">
  <a href="../index.php">Ana Sayfa</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current">Hakkımızda</span>
</div></div>

<section style="background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;padding:4rem 5%;text-align:center">
  <h1 style="font-family:'Space Grotesk',sans-serif;font-size:2.5rem;font-weight:800;margin-bottom:1rem">Hakkımızda</h1>
  <p style="opacity:.9;max-width:600px;margin:0 auto;font-size:1.05rem">Dental görüntüleme alanında Türkiye'nin güvenilir çözüm ortağı</p>
</section>

<div style="max-width:900px;margin:0 auto;padding:4rem 5%">
  <div style="display:grid;gap:2.5rem">

    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.5rem;margin-bottom:1rem">Biz Kimiz?</h2>
      <p style="color:var(--text-secondary);line-height:1.8">
        TomografiMarket, dental tomografi ve görüntüleme teknolojileri alanında uzmanlaşmış bir Türkiye merkezli dağıtım ve danışmanlık platformudur. LargeV, HDXWILL, Vatech, Planmeca, Sirona, Morita ve daha birçok dünya markasının yetkili distribütörü olarak faaliyet göstermekteyiz.
      </p>
      <p style="color:var(--text-secondary);line-height:1.8;margin-top:1rem">
        Diş hekimlerine ve klinik sahiplerine en güncel dental görüntüleme teknolojilerini tanıtmak, doğru cihaz seçiminde yol göstermek ve satış sonrası teknik destek sağlamak temel misyonumuzdur.
      </p>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">
      <div class="feature-item"><div class="feature-icon">🎯</div><h4>Misyonumuz</h4><p>Diş hekimlerine en kaliteli görüntüleme teknolojisini en uygun koşullarda sunmak.</p></div>
      <div class="feature-item"><div class="feature-icon">🔭</div><h4>Vizyonumuz</h4><p>Türkiye'nin dental görüntüleme alanında birinci referans platformu olmak.</p></div>
      <div class="feature-item"><div class="feature-icon">🏆</div><h4>Kalite Güvencesi</h4><p>Tüm ürünler uluslararası kalite standartlarına (CE, ISO) uyumludur.</p></div>
      <div class="feature-item"><div class="feature-icon">🤝</div><h4>Satış Sonrası Destek</h4><p>Cihaz kurulumu, kullanıcı eğitimi ve teknik servis desteği sağlıyoruz.</p></div>
    </div>

    <div class="admin-card" style="text-align:center">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.4rem;margin-bottom:1rem">İletişim Bilgilerimiz</h2>
      <p style="color:var(--text-secondary);margin-bottom:.5rem">📧 <a href="mailto:<?= SITE_EMAIL ?>"><?= SITE_EMAIL ?></a></p>
      <p style="color:var(--text-secondary);margin-bottom:.5rem">📞 <a href="tel:<?= SITE_PHONE1 ?>">+90 (850) 303 78 93</a></p>
      <p style="color:var(--text-secondary);margin-bottom:1.5rem">💬 <a href="tel:<?= SITE_PHONE2 ?>">+90 (505) 773 78 03</a></p>
      <button class="btn-primary" onclick="openContactModal()">Bize Ulaşın</button>
    </div>
  </div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
