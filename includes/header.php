<?php
// includes/header.php
// Kullanım: require_once ROOT.'/includes/header.php';
// Beklenen değişkenler (opsiyonel): $seoTitle, $seoDesc, $seoKeywords, $canonical, $ogImage, $extraSchemas
if (!defined('SITE_NAME')) require_once __DIR__ . '/../config/site.php';
if (!function_exists('h')) require_once __DIR__ . '/functions.php';

$_depth    = $depth ?? '';   // '../' veya '' gibi dosya derinliği
$_curPage  = $currentPage ?? '';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php renderSeoHead($seoTitle ?? '', $seoDesc ?? '', $seoKeywords ?? '', $canonical ?? '', $ogImage ?? ''); ?>
  <link rel="icon" type="image/png" href="<?= $_depth ?>img/tomografi_market_icon.png">
  <link rel="apple-touch-icon" href="<?= $_depth ?>img/tomografi_market_icon.png">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

  <!-- Ortak CSS -->
  <link rel="stylesheet" href="<?= $_depth ?>assets/css/main.css">

  <!-- Organization Schema -->
  <?php renderOrganizationSchema(); ?>
  <?php if (!empty($extraSchemas)) foreach ($extraSchemas as $s) echo $s; ?>
</head>
<body>

<!-- ═══ NAV ═══════════════════════════════════════════════ -->
<nav>
  <div class="nav-container">
    <div class="logo-section">
      <a href="<?= $_depth ?>index.php" class="logo-link">
        <div class="logo-circle">
          <img src="<?= $_depth ?>img/tomografi_market_logo.png" alt="TomografiMarket Logo" width="120" height="80">
        </div>
        <div class="logo-text">
          <h1>TomografiMarket</h1>
          <p>Dental Görüntüleme Çözümleri</p>
        </div>
      </a>
    </div>

    <div class="nav-links desktop-nav">
      <a href="<?= $_depth ?>index.php#brands" class="nav-link<?= $_curPage==='home'?' active':'' ?>">Ürünler</a>
      <a href="<?= $_depth ?>ikinci-el.php" class="nav-link<?= $_curPage==='ikinci-el'?' active':'' ?>">İkinci El</a>
      <a href="<?= $_depth ?>blog/index.php" class="nav-link<?= $_curPage==='blog'?' active':'' ?>">Blog</a>
      <a href="<?= $_depth ?>sayfalar/karsilastirma.php" class="nav-link<?= $_curPage==='karsilastirma'?' active':'' ?>">Karşılaştır</a>
      <button class="btn-outline" onclick="openContactModal()">İletişim</button>
    </div>

    <div class="hamburger" onclick="toggleMobileMenu()" aria-label="Menü" role="button">
      <span></span><span></span><span></span>
    </div>
  </div>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobile-menu">
  <a href="<?= $_depth ?>index.php#brands">Ürünler</a>
  <a href="<?= $_depth ?>ikinci-el.php">İkinci El</a>
  <a href="<?= $_depth ?>blog/index.php">Blog</a>
  <a href="<?= $_depth ?>sayfalar/karsilastirma.php">Karşılaştır</a>
  <button class="btn-outline mobile-contact-btn" onclick="openContactModal();toggleMobileMenu()">İletişim</button>
</div>
