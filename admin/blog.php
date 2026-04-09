<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) { header('Location: index.php'); exit; }
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/site.php';
require_once __DIR__ . '/../includes/functions.php';

$db     = getDB();
$action = $_GET['action'] ?? 'list';
$msg    = '';

// ── Kaydet / Guncelle ─────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id   = (int)($_POST['id'] ?? 0);
    $cols = ['slug','title','excerpt','content','cover_image','author','category','tags',
             'seo_title','seo_desc','published'];

    $vals = [];
    foreach ($cols as $c) {
        if ($c === 'published') {
            $vals[$c] = isset($_POST[$c]) ? 1 : 0;
        } else {
            $vals[$c] = trim($_POST[$c] ?? '');
        }
    }

    // published_at ayarla
    $published_at = trim($_POST['published_at'] ?? '');
    if (!$published_at && $vals['published']) {
        $published_at = date('Y-m-d H:i:s');
    }

    if ($id) {
        $set  = implode(', ', array_map(fn($c) => "`$c`=:$c", $cols));
        $sql  = "UPDATE blog_posts SET $set, `published_at`=:published_at WHERE id=:id";
        $stmt = $db->prepare($sql);
        $vals['published_at'] = $published_at ?: null;
        $vals['id'] = $id;
        $stmt->execute($vals);
        $msg = 'Yazi guncellendi.';
    } else {
        $cols[] = 'published_at';
        $vals['published_at'] = $published_at ?: null;
        $cols_str  = implode(',', array_map(fn($c) => "`$c`", $cols));
        $binds_str = implode(',', array_map(fn($c) => ":$c", $cols));
        $stmt = $db->prepare("INSERT INTO blog_posts ($cols_str) VALUES ($binds_str)");
        $stmt->execute($vals);
        $msg = 'Yazi eklendi.';

        // Blog post dosyasini otomatik olustur
        $newSlug = $vals['slug'];
        $blogFile = __DIR__ . '/../blog/' . $newSlug . '.php';
        if (!file_exists($blogFile) && $newSlug) {
            file_put_contents($blogFile, '<?php require __DIR__ . \'/_post.php\'; ?>');
        }
    }
    $action = 'list';
}

// ── Sil ──────────────────────────────────────────────
if ($action === 'delete' && !empty($_GET['id'])) {
    $db->prepare("DELETE FROM blog_posts WHERE id=?")->execute([(int)$_GET['id']]);
    $msg = 'Yazi silindi.';
    $action = 'list';
}

// ── Edit formu icin veri ─────────────────────────────
$editPost = null;
if ($action === 'edit' && !empty($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM blog_posts WHERE id=?");
    $stmt->execute([(int)$_GET['id']]);
    $editPost = $stmt->fetch();
}

$allPosts = $db->query("SELECT * FROM blog_posts ORDER BY published_at DESC, created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Blog | TomografiMarket Admin</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <meta name="robots" content="noindex, nofollow">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
      <h1 style="font-family:'Space Grotesk',sans-serif;font-size:1.5rem">Blog Yazilari</h1>
      <a href="?action=add" class="btn-primary" style="text-decoration:none;font-size:.9rem;padding:.6rem 1.25rem">+ Yazi Ekle</a>
    </div>

    <?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

    <?php if ($action === 'add' || $action === 'edit'):
      $p = $editPost ?? [];
      $formTitle = $action === 'edit' ? 'Yaziyi Duzenle' : 'Yeni Blog Yazisi';
    ?>
    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.15rem;margin-bottom:1.5rem"><?= $formTitle ?></h2>
      <form method="POST">
        <?php if (!empty($p['id'])): ?><input type="hidden" name="id" value="<?= (int)$p['id'] ?>"><?php endif; ?>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
          <div class="admin-form-group">
            <label>Baslik <span style="color:red">*</span></label>
            <input type="text" name="title" value="<?= htmlspecialchars($p['title']??'') ?>" required>
          </div>
          <div class="admin-form-group">
            <label>Slug <span style="color:red">*</span></label>
            <input type="text" name="slug" value="<?= htmlspecialchars($p['slug']??'') ?>" required placeholder="yazi-url-slug">
          </div>
          <div class="admin-form-group">
            <label>Kategori</label>
            <input type="text" name="category" value="<?= htmlspecialchars($p['category']??'') ?>" placeholder="Rehber, Haber, Fiyat Rehberi...">
          </div>
          <div class="admin-form-group">
            <label>Etiketler</label>
            <input type="text" name="tags" value="<?= htmlspecialchars($p['tags']??'') ?>" placeholder="cbct, dental, tomografi">
          </div>
          <div class="admin-form-group">
            <label>Yazar</label>
            <input type="text" name="author" value="<?= htmlspecialchars($p['author']??'TomografiMarket') ?>">
          </div>
          <div class="admin-form-group">
            <label>Yayin Tarihi</label>
            <input type="datetime-local" name="published_at" value="<?= !empty($p['published_at']) ? date('Y-m-d\TH:i', strtotime($p['published_at'])) : '' ?>">
          </div>
        </div>

        <div class="admin-form-group">
          <label>Ozet (Excerpt)</label>
          <textarea name="excerpt" rows="3"><?= htmlspecialchars($p['excerpt']??'') ?></textarea>
        </div>

        <div class="admin-form-group">
          <label>Icerik (HTML)</label>
          <textarea name="content" rows="15" style="font-family:monospace;font-size:.85rem"><?= htmlspecialchars($p['content']??'') ?></textarea>
        </div>

        <div class="admin-form-group">
          <label>Kapak Gorseli Yolu</label>
          <input type="text" name="cover_image" value="<?= htmlspecialchars($p['cover_image']??'') ?>" placeholder="img/blog/kapak.jpg">
        </div>

        <h3 style="font-family:'Space Grotesk',sans-serif;margin:1.25rem 0 .75rem;font-size:1rem;color:var(--text-secondary)">SEO</h3>
        <div style="display:grid;gap:1rem">
          <div class="admin-form-group"><label>SEO Baslik</label><input type="text" name="seo_title" value="<?= htmlspecialchars($p['seo_title']??'') ?>"></div>
          <div class="admin-form-group"><label>SEO Aciklama</label><textarea name="seo_desc" rows="2"><?= htmlspecialchars($p['seo_desc']??'') ?></textarea></div>
        </div>

        <div style="margin:1.25rem 0">
          <label style="display:flex;align-items:center;gap:.4rem;font-size:.9rem;cursor:pointer">
            <input type="checkbox" name="published" <?= ($p['published']??0) ? 'checked' : '' ?>> Yayinla
          </label>
        </div>

        <div style="display:flex;gap:1rem;margin-top:1.5rem">
          <button type="submit" class="btn-primary">Kaydet</button>
          <a href="blog.php" class="btn-outline" style="text-decoration:none">Iptal</a>
        </div>
      </form>
    </div>

    <?php else: ?>

    <!-- List -->
    <div class="admin-card">
      <?php if (empty($allPosts)): ?>
      <p style="color:var(--text-secondary);text-align:center;padding:2rem">Henuz blog yazisi bulunmuyor.</p>
      <?php else: ?>
      <div style="overflow-x:auto">
        <table class="admin-table">
          <thead><tr><th>#</th><th>Baslik</th><th>Kategori</th><th>Yazar</th><th>Tarih</th><th>Durum</th><th>Islem</th></tr></thead>
          <tbody>
            <?php foreach ($allPosts as $post): ?>
            <tr>
              <td><?= $post['id'] ?></td>
              <td><strong><?= htmlspecialchars($post['title']) ?></strong><br><small style="color:var(--text-light)"><?= htmlspecialchars($post['slug']) ?></small></td>
              <td><?= htmlspecialchars($post['category']??'') ?></td>
              <td><?= htmlspecialchars($post['author']??'') ?></td>
              <td style="white-space:nowrap;font-size:.82rem"><?= $post['published_at'] ? date('d.m.Y', strtotime($post['published_at'])) : '—' ?></td>
              <td><span class="badge-<?= $post['published'] ? 'active' : 'inactive' ?>"><?= $post['published'] ? 'Yayinda' : 'Taslak' ?></span></td>
              <td style="white-space:nowrap">
                <a href="?action=edit&id=<?= $post['id'] ?>" style="color:var(--primary);text-decoration:none;font-size:.85rem;font-weight:600;margin-right:.75rem">Duzenle</a>
                <a href="../blog/<?= htmlspecialchars($post['slug']) ?>.php" target="_blank" style="color:var(--secondary);text-decoration:none;font-size:.85rem;font-weight:600;margin-right:.75rem">Goruntule</a>
                <a href="?action=delete&id=<?= $post['id'] ?>" style="color:var(--accent);text-decoration:none;font-size:.85rem;font-weight:600" onclick="return confirm('Bu yaziyi silmek istediginize emin misiniz?')">Sil</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </main>
</div>
</body>
</html>
