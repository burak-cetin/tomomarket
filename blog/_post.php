<?php
require_once __DIR__ . '/../config/site.php';
require_once __DIR__ . '/../includes/functions.php';

$rawSlug = '';
if (!empty($_GET['slug'])) {
    $rawSlug = preg_replace('/[^a-z0-9\-]/', '', strtolower($_GET['slug']));
} else {
    $rawSlug = basename($_SERVER['PHP_SELF'], '.php');
}

$post = getBlogPostBySlug($rawSlug);
if (!$post) { header('HTTP/1.0 404 Not Found'); die('<h1>404</h1>'); }

$recentPosts = getBlogPosts(4);
$depth       = '../';
$currentPage = 'blog';

$seoTitle  = $post['seo_title'] ?: ($post['title'] . SEO_TITLE_SUFFIX);
$seoDesc   = $post['seo_desc'] ?: $post['excerpt'];
$canonical = SITE_URL . '/blog/' . $post['slug'];
$ogImage   = $post['cover_image'] ?? '';

ob_start();
renderBreadcrumbSchema([
    ['TomografiMarket', SITE_URL],
    ['Blog', SITE_URL . '/blog/'],
    [$post['title'], $canonical],
]);
$bcSchema = ob_get_clean();

// Article schema
$articleSchema = '<script type="application/ld+json">' . json_encode([
    '@context'         => 'https://schema.org',
    '@type'            => 'Article',
    'headline'         => $post['title'],
    'description'      => $post['excerpt'],
    'author'           => ['@type'=>'Organization','name'=>$post['author']],
    'publisher'        => ['@type'=>'Organization','name'=>'TomografiMarket','logo'=>SITE_URL.'/img/tomografi_market_logo.png'],
    'datePublished'    => $post['published_at'],
    'dateModified'     => $post['updated_at'],
    'url'              => $canonical,
    'image'            => $post['cover_image'] ? SITE_URL.'/'.$post['cover_image'] : SITE_URL.'/img/tomografi_market_logo.png',
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';

$extraSchemas = [$bcSchema, $articleSchema];
require __DIR__ . '/../includes/header.php';
?>
<meta name="base-depth" content="../">

<!-- Breadcrumb -->
<div class="breadcrumb">
  <div class="breadcrumb-container">
    <a href="../">Ana Sayfa</a>
    <span class="breadcrumb-sep">›</span>
    <a href="./">Blog</a>
    <span class="breadcrumb-sep">›</span>
    <span class="breadcrumb-current"><?= h($post['title']) ?></span>
  </div>
</div>

<div style="max-width:1100px;margin:0 auto;padding:3rem 5%;display:grid;grid-template-columns:1fr 300px;gap:3rem;align-items:start">

  <!-- Main Content -->
  <article>
    <?php if ($post['category']): ?>
    <span class="blog-category" style="margin-bottom:1rem;display:inline-block"><?= h($post['category']) ?></span>
    <?php endif; ?>
    <h1 style="font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:800;line-height:1.3;margin-bottom:1rem"><?= h($post['title']) ?></h1>
    <div style="font-size:.85rem;color:var(--text-light);margin-bottom:2rem;display:flex;gap:1.5rem;flex-wrap:wrap">
      <span>📅 <?= date('d.m.Y', strtotime($post['published_at'])) ?></span>
      <span>✍ <?= h($post['author']) ?></span>
      <?php if ($post['tags']): ?><span>🏷 <?= h($post['tags']) ?></span><?php endif; ?>
    </div>

    <?php if ($post['cover_image']): ?>
    <img src="../<?= h($post['cover_image']) ?>" alt="<?= h($post['title']) ?>" style="width:100%;border-radius:16px;margin-bottom:2rem;max-height:400px;object-fit:cover">
    <?php endif; ?>

    <div class="blog-post-content">
      <?= $post['content'] /* HTML içerik — admin tarafından kontrol edilen */ ?>
    </div>

    <!-- Share -->
    <div style="margin-top:3rem;padding-top:2rem;border-top:1px solid var(--border);display:flex;gap:1rem;flex-wrap:wrap">
      <a href="https://twitter.com/intent/tweet?url=<?= urlencode($canonical) ?>&text=<?= urlencode($post['title']) ?>"
         target="_blank" rel="noopener" style="padding:.6rem 1.25rem;background:#1da1f2;color:#fff;border-radius:8px;text-decoration:none;font-size:.85rem;font-weight:600">
        🐦 Twitter'da Paylaş
      </a>
      <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($canonical) ?>"
         target="_blank" rel="noopener" style="padding:.6rem 1.25rem;background:#0077b5;color:#fff;border-radius:8px;text-decoration:none;font-size:.85rem;font-weight:600">
        💼 LinkedIn'de Paylaş
      </a>
      <a href="https://wa.me/?text=<?= urlencode($post['title'].' '.$canonical) ?>"
         target="_blank" rel="noopener" style="padding:.6rem 1.25rem;background:#25d366;color:#fff;border-radius:8px;text-decoration:none;font-size:.85rem;font-weight:600">
        📱 WhatsApp
      </a>
    </div>
  </article>

  <!-- Sidebar -->
  <aside>
    <div style="position:sticky;top:90px;display:flex;flex-direction:column;gap:1.5rem">
      <!-- CTA -->
      <div style="background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;border-radius:16px;padding:1.5rem;text-align:center">
        <h3 style="font-family:'Space Grotesk',sans-serif;margin-bottom:.75rem">Uzman Danışmanlık</h3>
        <p style="opacity:.9;font-size:.9rem;margin-bottom:1.25rem">Kliniğiniz için en doğru cihazı birlikte seçelim.</p>
        <button class="btn-cta-white" style="width:100%" onclick="openContactModal()">Ücretsiz Danışmanlık</button>
      </div>

      <!-- Recent Posts -->
      <div style="background:var(--bg-primary);border:1px solid var(--border);border-radius:16px;padding:1.5rem">
        <h3 style="font-family:'Space Grotesk',sans-serif;font-size:1rem;margin-bottom:1rem">Son Yazılar</h3>
        <?php foreach ($recentPosts as $rp): if ($rp['slug'] === $post['slug']) continue; ?>
        <a href="<?= h($rp['slug']) ?>" style="display:block;padding:.75rem 0;border-bottom:1px solid var(--border);text-decoration:none;color:inherit;font-size:.9rem;font-weight:500;line-height:1.4">
          <?= h($rp['title']) ?>
          <span style="display:block;font-size:.75rem;color:var(--text-light);margin-top:.25rem"><?= date('d.m.Y', strtotime($rp['published_at'])) ?></span>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </aside>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
