<?php
// ============================================================
//  TomografiMarket — Site Ayarları
// ============================================================

define('SITE_NAME',    'TomografiMarket');
define('SITE_TAGLINE', 'Dental Görüntüleme Çözümleri');
define('SITE_URL',     'http://localhost/tomomarket_php');  // Trailing slash yok
define('SITE_EMAIL',   'info@tomografimarket.com');
define('SITE_PHONE1',  '+908503037893');
define('SITE_PHONE2',  '+905057737803');
define('SITE_WA',      '905057737803');
define('WEB3FORMS_KEY','35cecad0-06c9-472d-a239-66ac39cd02eb');

// Admin şifre hash'i — install.php çalıştırınca otomatik güncellenir
// Varsayılan: Admin1234!
define('ADMIN_USER',   'admin');
define('ADMIN_PASS_HASH', '$2y$10$placeholder_run_install_php_first');

// SEO varsayılanları
define('SEO_TITLE_SUFFIX', ' | TomografiMarket');
define('SEO_DEFAULT_DESC', 'TomografiMarket — Türkiye\'nin Dental Tomografi ve Görüntüleme Ekipmanları Uzmanı. LargeV, HDXWILL, Vatech, Planmeca ve daha fazlası.');
define('SEO_DEFAULT_KEYWORDS', 'dental tomografi, cbct, diş tomografisi, dental görüntüleme, panoramik röntgen, dental röntgen cihazı');

// Yollar
define('BASE_PATH', dirname(__DIR__));
define('UPLOAD_PATH', BASE_PATH . '/uploads');
