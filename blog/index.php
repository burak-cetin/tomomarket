<?php
require_once __DIR__ . '/../config/site.php';
require_once __DIR__ . '/../includes/functions.php';

$posts = getBlogPosts(20);
$depth = '../';
$currentPage = 'blog';

$seoTitle    = 'Blog — Dental Tomografi Rehberleri | TomografiMarket';
$seoDesc     = 'Dental tomografi, CBCT teknolojisi, panoramik röntgen ve dental görüntüleme hakkında kapsamlı rehberler, haberler ve uzman tavsiyeleri.';
$seoKeywords = 'dental tomografi blog, cbct rehber, dental görüntüleme, dental cihaz rehber';
$canonical   = SITE_URL . '/blog/';

require __DIR__ . '/../includes/header.php';
?>
<meta name="base-depth" content="../">

<!-- Hero -->
<section class="blog-hero">
  <h1>Blog &amp; Rehberler</h1>
  <p>Dental görüntüleme teknolojileri hakkında kapsamlı bilgiler, cihaz rehberleri ve uzman tavsiyeleri</p>
</section>

<!-- Blog Grid -->
<div class="blog-grid">
  <?php if (empty($posts)): ?>
  <div style="grid-column:1/-1;text-align:center;padding:4rem;color:var(--text-secondary)">
    <p>Henüz blog yazısı bulunmuyor.</p>
  </div>
  <?php else: ?>
    <?php foreach ($posts as $post): ?>
    <a href="<?= h($post['slug']) ?>.php" class="blog-card">
      <div class="blog-card-image">
        <?php if ($post['cover_image']): ?>
        <img src="../<?= h($post['cover_image']) ?>" alt="<?= h($post['title']) ?>" loading="lazy">
        <?php else: ?>
        <div class="blog-placeholder-img">📰</div>
        <?php endif; ?>
      </div>
      <div class="blog-card-content">
        <?php if ($post['category']): ?>
        <span class="blog-category"><?= h($post['category']) ?></span>
        <?php endif; ?>
        <h2><?= h($post['title']) ?></h2>
        <p class="blog-excerpt"><?= h($post['excerpt']) ?></p>
        <div class="blog-meta">
          📅 <?= date('d.m.Y', strtotime($post['published_at'])) ?>
          &nbsp;·&nbsp; ✍ <?= h($post['author']) ?>
        </div>
      </div>
    </a>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<!-- CTA -->
<section class="cta-section" style="margin-top:0">
  <h2>Doğru Cihaz Seçiminde Yardıma mı İhtiyacınız Var?</h2>
  <p>Blog rehberlerimizi okudunuz, şimdi uzmanlarımıza sorun.</p>
  <div class="cta-buttons">
    <button class="btn-cta-white" onclick="openContactModal()">Ücretsiz Danışmanlık</button>
    <a href="../index.php#urunler" class="btn-cta-outline">Tüm Cihazlar</a>
  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
