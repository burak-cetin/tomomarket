<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) { header('Location: index.php'); exit; }
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/site.php';
require_once __DIR__ . '/../includes/functions.php';

$db     = getDB();
$action = $_GET['action'] ?? 'list';
$msg    = '';

// ── Kaydet / Güncelle ─────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id    = (int)($_POST['id'] ?? 0);
    $cols  = ['slug','brand_id','name','tagline','description','image','brochure','badge','badge_type',
              'goruntuleme','fov','voksel','tarama_suresi','voltaj','akim','rekonstruksiyon','sensor','mensei',
              'dusuk_doz','panoramik','sefalometrik','ai_destekli','kompakt','hizli_tarama',
              'seo_title','seo_desc','seo_keywords','sort_order','active'];

    $vals = [];
    foreach ($cols as $c) {
        if (in_array($c, ['dusuk_doz','panoramik','sefalometrik','ai_destekli','kompakt','hizli_tarama','active'])) {
            $vals[$c] = isset($_POST[$c]) ? 1 : 0;
        } elseif ($c === 'sort_order' || $c === 'brand_id') {
            $vals[$c] = (int)($_POST[$c] ?? 0);
        } else {
            $vals[$c] = trim($_POST[$c] ?? '');
        }
    }

    if ($id) {
        $set  = implode(', ', array_map(fn($c) => "`$c`=:$c", $cols));
        $stmt = $db->prepare("UPDATE products SET $set WHERE id=:id");
        $vals['id'] = $id;
        $stmt->execute($vals);
        $msg = '✅ Ürün güncellendi.';
    } else {
        $cols_str  = implode(',', array_map(fn($c) => "`$c`", $cols));
        $binds_str = implode(',', array_map(fn($c) => ":$c", $cols));
        $stmt = $db->prepare("INSERT INTO products ($cols_str) VALUES ($binds_str)");
        $stmt->execute($vals);
        $msg = '✅ Ürün eklendi.';
    }
    $action = 'list';
}

// ── Sil ──────────────────────────────────────────────
if ($action === 'delete' && !empty($_GET['id'])) {
    $db->prepare("DELETE FROM products WHERE id=?")->execute([(int)$_GET['id']]);
    $msg = '✅ Ürün silindi.';
    $action = 'list';
}

// ── Edit formu için veri ─────────────────────────────
$editProduct = null;
if ($action === 'edit' && !empty($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM products WHERE id=?");
    $stmt->execute([(int)$_GET['id']]);
    $editProduct = $stmt->fetch();
}

$allBrands   = getBrands(false);
$allProducts = $db->query("SELECT p.*, b.name AS brand_name FROM products p JOIN brands b ON b.id=p.brand_id ORDER BY b.sort_order, p.sort_order")->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Ürünler | TomografiMarket Admin</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <meta name="robots" content="noindex, nofollow">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
      <h1 style="font-family:'Space Grotesk',sans-serif;font-size:1.5rem">📦 Ürünler</h1>
      <a href="?action=add" class="btn-primary" style="text-decoration:none;font-size:.9rem;padding:.6rem 1.25rem">+ Ürün Ekle</a>
    </div>

    <?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

    <?php if ($action === 'add' || $action === 'edit'):
      $p = $editProduct ?? [];
      $formTitle = $action === 'edit' ? 'Ürünü Düzenle' : 'Yeni Ürün';
    ?>
    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.15rem;margin-bottom:1.5rem"><?= $formTitle ?></h2>
      <form method="POST">
        <?php if (!empty($p['id'])): ?><input type="hidden" name="id" value="<?= (int)$p['id'] ?>"><?php endif; ?>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
          <div class="admin-form-group">
            <label>Marka <span style="color:red">*</span></label>
            <select name="brand_id" required>
              <option value="">— Seçin —</option>
              <?php foreach ($allBrands as $b): ?>
              <option value="<?= $b['id'] ?>" <?= ($p['brand_id']??'') == $b['id'] ? 'selected' : '' ?>><?= htmlspecialchars($b['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="admin-form-group">
            <label>Slug <span style="color:red">*</span></label>
            <input type="text" name="slug" value="<?= htmlspecialchars($p['slug']??'') ?>" required placeholder="ornek-urun-adi">
          </div>
          <div class="admin-form-group">
            <label>Ürün Adı <span style="color:red">*</span></label>
            <input type="text" name="name" value="<?= htmlspecialchars($p['name']??'') ?>" required>
          </div>
          <div class="admin-form-group">
            <label>Tagline</label>
            <input type="text" name="tagline" value="<?= htmlspecialchars($p['tagline']??'') ?>">
          </div>
        </div>

        <div class="admin-form-group">
          <label>Açıklama</label>
          <textarea name="description" rows="4"><?= htmlspecialchars($p['description']??'') ?></textarea>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
          <div class="admin-form-group"><label>Görsel yolu</label><input type="text" name="image" value="<?= htmlspecialchars($p['image']??'') ?>" placeholder="img/products/..."></div>
          <div class="admin-form-group"><label>Broşür yolu</label><input type="text" name="brochure" value="<?= htmlspecialchars($p['brochure']??'') ?>" placeholder="brosurler/..."></div>
          <div class="admin-form-group"><label>Badge</label><input type="text" name="badge" value="<?= htmlspecialchars($p['badge']??'') ?>" placeholder="Yeni, Popüler..."></div>
          <div class="admin-form-group"><label>Badge Tipi</label>
            <select name="badge_type">
              <?php foreach (['default','new','eco'] as $bt): ?>
              <option value="<?= $bt ?>" <?= ($p['badge_type']??'default')===$bt?'selected':'' ?>><?= $bt ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <h3 style="font-family:'Space Grotesk',sans-serif;margin:1.25rem 0 .75rem;font-size:1rem;color:var(--text-secondary)">Teknik Özellikler</h3>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem">
          <?php
          $specFields = [
              'goruntuleme'=>'Görüntüleme Modu','fov'=>'FOV','voksel'=>'Voksel',
              'tarama_suresi'=>'Tarama Süresi','voltaj'=>'Voltaj','akim'=>'Akım',
              'rekonstruksiyon'=>'Rekonstrüksiyon','sensor'=>'Sensör','mensei'=>'Menşei',
          ];
          foreach ($specFields as $fn => $fl):
          ?>
          <div class="admin-form-group"><label><?= $fl ?></label><input type="text" name="<?= $fn ?>" value="<?= htmlspecialchars($p[$fn]??'') ?>"></div>
          <?php endforeach; ?>
        </div>

        <h3 style="font-family:'Space Grotesk',sans-serif;margin:1.25rem 0 .75rem;font-size:1rem;color:var(--text-secondary)">Özellikler (Evet/Hayır)</h3>
        <div style="display:flex;flex-wrap:wrap;gap:1rem;margin-bottom:1.25rem">
          <?php
          $boolFields = ['dusuk_doz'=>'Düşük Doz','panoramik'=>'Panoramik','sefalometrik'=>'Sefalometrik',
                         'ai_destekli'=>'AI Destekli','kompakt'=>'Kompakt','hizli_tarama'=>'Hızlı Tarama'];
          foreach ($boolFields as $fn => $fl):
          ?>
          <label style="display:flex;align-items:center;gap:.4rem;font-size:.9rem;cursor:pointer">
            <input type="checkbox" name="<?= $fn ?>" <?= ($p[$fn]??0) ? 'checked' : '' ?>> <?= $fl ?>
          </label>
          <?php endforeach; ?>
        </div>

        <h3 style="font-family:'Space Grotesk',sans-serif;margin:1.25rem 0 .75rem;font-size:1rem;color:var(--text-secondary)">SEO</h3>
        <div style="display:grid;gap:1rem">
          <div class="admin-form-group"><label>SEO Başlık</label><input type="text" name="seo_title" value="<?= htmlspecialchars($p['seo_title']??'') ?>"></div>
          <div class="admin-form-group"><label>SEO Açıklama</label><textarea name="seo_desc" rows="2"><?= htmlspecialchars($p['seo_desc']??'') ?></textarea></div>
          <div class="admin-form-group"><label>SEO Anahtar Kelimeler</label><input type="text" name="seo_keywords" value="<?= htmlspecialchars($p['seo_keywords']??'') ?>"></div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:1rem">
          <div class="admin-form-group"><label>Sıra</label><input type="number" name="sort_order" value="<?= (int)($p['sort_order']??0) ?>"></div>
          <div class="admin-form-group"><label>Durum</label><label style="display:flex;align-items:center;gap:.4rem;font-size:.9rem;cursor:pointer;margin-top:.4rem"><input type="checkbox" name="active" <?= ($p['active']??1) ? 'checked' : '' ?>> Aktif</label></div>
        </div>

        <div style="display:flex;gap:1rem;margin-top:1.5rem">
          <button type="submit" class="btn-primary">Kaydet</button>
          <a href="products.php" class="btn-outline" style="text-decoration:none">İptal</a>
        </div>
      </form>
    </div>

    <?php else: ?>

    <!-- List -->
    <div class="admin-card">
      <div style="overflow-x:auto">
        <table class="admin-table">
          <thead><tr><th>#</th><th>Marka</th><th>Ürün Adı</th><th>Görüntüleme</th><th>Durum</th><th>İşlem</th></tr></thead>
          <tbody>
            <?php foreach ($allProducts as $prod): ?>
            <tr>
              <td><?= $prod['id'] ?></td>
              <td><?= htmlspecialchars($prod['brand_name']) ?></td>
              <td><strong><?= htmlspecialchars($prod['name']) ?></strong><br><small style="color:var(--text-light)"><?= htmlspecialchars($prod['slug']) ?></small></td>
              <td><?= htmlspecialchars($prod['goruntuleme']??'') ?></td>
              <td><span class="badge-<?= $prod['active'] ? 'active' : 'inactive' ?>"><?= $prod['active'] ? 'Aktif' : 'Pasif' ?></span></td>
              <td style="white-space:nowrap">
                <a href="?action=edit&id=<?= $prod['id'] ?>" style="color:var(--primary);text-decoration:none;font-size:.85rem;font-weight:600;margin-right:.75rem">Düzenle</a>
                <a href="../urunler/<?= htmlspecialchars($prod['slug']) ?>-detay.php" target="_blank" style="color:var(--secondary);text-decoration:none;font-size:.85rem;font-weight:600;margin-right:.75rem">Görüntüle</a>
                <a href="?action=delete&id=<?= $prod['id'] ?>" style="color:var(--accent);text-decoration:none;font-size:.85rem;font-weight:600" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php endif; ?>
  </main>
</div>
</body>
</html>
