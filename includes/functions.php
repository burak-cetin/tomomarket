<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/site.php';

// ── Güvenlik ──────────────────────────────────────────────
function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }

// ── Veritabanı yardımcıları ───────────────────────────────
function getBrands(bool $activeOnly = true): array {
    $sql = 'SELECT * FROM brands' . ($activeOnly ? ' WHERE active=1' : '') . ' ORDER BY sort_order, name';
    return getDB()->query($sql)->fetchAll();
}

function getBrandBySlug(string $slug): ?array {
    $stmt = getDB()->prepare('SELECT * FROM brands WHERE slug=? AND active=1');
    $stmt->execute([$slug]);
    return $stmt->fetch() ?: null;
}

function getProductsByBrand(int $brandId): array {
    $stmt = getDB()->prepare('SELECT p.*, b.name AS brand_name, b.slug AS brand_slug FROM products p JOIN brands b ON b.id=p.brand_id WHERE p.brand_id=? AND p.active=1 ORDER BY p.sort_order, p.name');
    $stmt->execute([$brandId]);
    return $stmt->fetchAll();
}

function getProductBySlug(string $slug): ?array {
    $stmt = getDB()->prepare('SELECT p.*, b.name AS brand_name, b.slug AS brand_slug, b.logo AS brand_logo FROM products p JOIN brands b ON b.id=p.brand_id WHERE p.slug=? AND p.active=1');
    $stmt->execute([$slug]);
    return $stmt->fetch() ?: null;
}

function getAllActiveProducts(int $limit = 0): array {
    $sql = 'SELECT p.*, b.name AS brand_name, b.slug AS brand_slug FROM products p JOIN brands b ON b.id=p.brand_id WHERE p.active=1 ORDER BY b.sort_order, p.sort_order';
    if ($limit > 0) $sql .= ' LIMIT ' . (int)$limit;
    return getDB()->query($sql)->fetchAll();
}

function getSecondHandListings(bool $featuredFirst = true, int $limit = 20): array {
    $order = $featuredFirst ? 'featured DESC, created_at DESC' : 'created_at DESC';
    $stmt = getDB()->prepare("SELECT * FROM second_hand WHERE active=1 ORDER BY $order LIMIT ?");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

function getSecondHandBySlug(string $slug): ?array {
    $stmt = getDB()->prepare('SELECT * FROM second_hand WHERE slug=? AND active=1');
    $stmt->execute([$slug]);
    return $stmt->fetch() ?: null;
}

function getBlogPosts(int $limit = 10, string $category = ''): array {
    if ($category) {
        $stmt = getDB()->prepare('SELECT * FROM blog_posts WHERE published=1 AND category=? ORDER BY published_at DESC LIMIT ?');
        $stmt->execute([$category, $limit]);
    } else {
        $stmt = getDB()->prepare('SELECT * FROM blog_posts WHERE published=1 ORDER BY published_at DESC LIMIT ?');
        $stmt->execute([$limit]);
    }
    return $stmt->fetchAll();
}

function getBlogPostBySlug(string $slug): ?array {
    $stmt = getDB()->prepare('SELECT * FROM blog_posts WHERE slug=? AND published=1');
    $stmt->execute([$slug]);
    return $stmt->fetch() ?: null;
}

function getRelatedProducts(int $productId, int $brandId, int $limit = 3): array {
    $stmt = getDB()->prepare('SELECT p.*, b.name AS brand_name FROM products p JOIN brands b ON b.id=p.brand_id WHERE p.brand_id=? AND p.id!=? AND p.active=1 ORDER BY RAND() LIMIT ?');
    $stmt->execute([$brandId, $productId, $limit]);
    return $stmt->fetchAll();
}

// ── SEO ───────────────────────────────────────────────────
function renderSeoHead(string $title, string $desc = '', string $keywords = '', string $canonical = '', string $ogImage = ''): void {
    $title    = $title ?: SEO_DEFAULT_DESC;
    $desc     = $desc ?: SEO_DEFAULT_DESC;
    $keywords = $keywords ?: SEO_DEFAULT_KEYWORDS;
    $canonical = $canonical ?: (SITE_URL . strtok($_SERVER['REQUEST_URI'], '?'));
    $ogImage  = $ogImage ? (SITE_URL . '/' . $ogImage) : (SITE_URL . '/img/tomografi_market_logo.png');
    echo '<title>' . h($title) . '</title>' . "\n";
    echo '<meta name="description" content="' . h($desc) . '">' . "\n";
    echo '<meta name="keywords" content="' . h($keywords) . '">' . "\n";
    echo '<meta name="robots" content="index, follow">' . "\n";
    echo '<meta name="author" content="TomografiMarket">' . "\n";
    echo '<link rel="canonical" href="' . h($canonical) . '">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta property="og:title" content="' . h($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . h($desc) . '">' . "\n";
    echo '<meta property="og:url" content="' . h($canonical) . '">' . "\n";
    echo '<meta property="og:image" content="' . h($ogImage) . '">' . "\n";
    echo '<meta property="og:site_name" content="TomografiMarket">' . "\n";
    echo '<meta property="og:locale" content="tr_TR">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . h($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . h($desc) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . h($ogImage) . '">' . "\n";
    echo '<link rel="alternate" hreflang="tr" href="' . h($canonical) . '">' . "\n";
    echo '<link rel="alternate" hreflang="x-default" href="' . h($canonical) . '">' . "\n";
    echo '<meta name="geo.region" content="TR">' . "\n";
    echo '<meta name="geo.placename" content="Turkey">' . "\n";
    echo '<meta name="language" content="Turkish">' . "\n";
}

function renderOrganizationSchema(): void {
    echo '<script type="application/ld+json">' . json_encode([
        '@context'  => 'https://schema.org',
        '@type'     => 'Organization',
        'name'      => 'TomografiMarket',
        'url'       => SITE_URL,
        'logo'      => SITE_URL . '/img/tomografi_market_logo.png',
        'contactPoint' => [
            '@type'       => 'ContactPoint',
            'telephone'   => SITE_PHONE1,
            'contactType' => 'customer service',
            'availableLanguage' => 'Turkish',
        ],
        'sameAs' => [],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}

function renderProductSchema(array $p): void {
    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Product',
        'name'        => $p['brand_name'] . ' ' . $p['name'],
        'description' => $p['description'] ?? '',
        'brand'       => ['@type' => 'Brand', 'name' => $p['brand_name']],
        'offers'      => [
            '@type'         => 'Offer',
            'seller'        => ['@type' => 'Organization', 'name' => 'TomografiMarket'],
            'availability'  => 'https://schema.org/InStock',
            'priceCurrency' => 'TRY',
            'url'           => SITE_URL . '/urunler/' . $p['slug'],
        ],
    ];
    if (!empty($p['image'])) $schema['image'] = SITE_URL . '/' . $p['image'];
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}

function renderBreadcrumbSchema(array $items): void {
    $list = [];
    foreach ($items as $i => $item) {
        $list[] = ['@type' => 'ListItem', 'position' => $i+1, 'name' => $item[0], 'item' => $item[1]];
    }
    echo '<script type="application/ld+json">' . json_encode([
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $list,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}

function renderFAQSchema(array $faqs): void {
    $items = [];
    foreach ($faqs as $faq) {
        $items[] = ['@type' => 'Question', 'name' => $faq['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']]];
    }
    echo '<script type="application/ld+json">' . json_encode([
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => $items,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}

// ── Görsel Çözümleme ─────────────────────────────────────
function resolveImage(string $path): string {
    if (!$path) return '';
    $basePath = dirname(__DIR__);
    $fullPath = $basePath . '/' . $path;
    if (file_exists($fullPath)) return $path;

    $info = pathinfo($path);
    $exts = ['png', 'jpg', 'jpeg', 'webp'];
    foreach ($exts as $ext) {
        $alt = $info['dirname'] . '/' . $info['filename'] . '.' . $ext;
        if (file_exists($basePath . '/' . $alt)) return $alt;
    }

    $dir = $basePath . '/' . $info['dirname'];
    if (is_dir($dir)) {
        $target = strtolower(str_replace(['_', ' '], '-', $info['filename']));
        foreach (scandir($dir) as $file) {
            if ($file === '.' || $file === '..') continue;
            $fileBase = strtolower(str_replace(['_', ' '], '-', pathinfo($file, PATHINFO_FILENAME)));
            if ($target === $fileBase) {
                return $info['dirname'] . '/' . $file;
            }
        }
    }

    return $path;
}

// ── Yardımcılar ───────────────────────────────────────────
function slugify(string $text): string {
    $tr = ['ş'=>'s','ı'=>'i','ğ'=>'g','ü'=>'u','ö'=>'o','ç'=>'c','Ş'=>'s','İ'=>'i','Ğ'=>'g','Ü'=>'u','Ö'=>'o','Ç'=>'c'];
    $text = strtr($text, $tr);
    $text = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $text), '-'));
    return $text;
}

function saveLead(array $data): bool {
    try {
        $stmt = getDB()->prepare('INSERT INTO contact_leads (name, email, phone, subject, message, source, ip) VALUES (?,?,?,?,?,?,?)');
        return $stmt->execute([
            $data['name'] ?? null,
            $data['email'] ?? null,
            $data['phone'] ?? null,
            $data['subject'] ?? null,
            $data['message'] ?? null,
            $data['source'] ?? null,
            $_SERVER['REMOTE_ADDR'] ?? null,
        ]);
    } catch (PDOException $e) { return false; }
}

function conditionLabel(string $c): string {
    return match($c) { 'mükemmel' => 'Mükemmel', 'çok iyi' => 'Çok İyi', default => 'İyi' };
}

function conditionClass(string $c): string {
    return match($c) { 'mükemmel' => 'condition-excellent', 'çok iyi' => 'condition-very-good', default => 'condition-good' };
}
