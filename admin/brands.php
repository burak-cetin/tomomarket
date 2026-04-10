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
    $cols = ['slug','name','logo','origin','description','seo_title','seo_desc','seo_keywords','sort_order','active'];

    $vals = [];
    foreach ($cols as $c) {
        if ($c === 'active') {
            $vals[$c] = isset($_POST[$c]) ? 1 : 0;
        } elseif ($c === 'sort_order') {
            $vals[$c] = (int)($_POST[$c] ?? 0);
        } else {
            $vals[$c] = trim($_POST[$c] ?? '');
        }
    }

    if ($id) {
        $set  = implode(', ', array_map(fn($c) => "`$c`=:$c", $cols));
        $stmt = $db->prepare("UPDATE brands SET $set WHERE id=:id");
        $vals['id'] = $id;
        $stmt->execute($vals);
        $msg = 'Marka guncellendi.';
    } else {
        $cols_str  = implode(',', array_map(fn($c) => "`$c`", $cols));
        $binds_str = implode(',', array_map(fn($c) => ":$c", $cols));
        $stmt = $db->prepare("INSERT INTO brands ($cols_str) VALUES ($binds_str)");
        $stmt->execute($vals);
        $msg = 'Marka eklendi.';
    }
    $action = 'list';
}

// ── Sil ──────────────────────────────────────────────
if ($action === 'delete' && !empty($_GET['id'])) {
    $db->prepare("DELETE FROM brands WHERE id=?")->execute([(int)$_GET['id']]);
    $msg = 'Marka silindi.';
    $action = 'list';
}

// ── Edit formu icin veri ─────────────────────────────
$editBrand = null;
if ($action === 'edit' && !empty($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM brands WHERE id=?");
    $stmt->execute([(int)$_GET['id']]);
    $editBrand = $stmt->fetch();
}

$allBrands = $db->query("SELECT * FROM brands ORDER BY sort_order, name")->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Markalar | TomografiMarket Admin</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <meta name="robots" content="noindex, nofollow">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
      <h1 style="font-family:'Space Grotesk',sans-serif;font-size:1.5rem">Markalar</h1>
      <a href="?action=add" class="btn-primary" style="text-decoration:none;font-size:.9rem;padding:.6rem 1.25rem">+ Marka Ekle</a>
    </div>

    <?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

    <?php if ($action === 'add' || $action === 'edit'):
      $b = $editBrand ?? [];
      $formTitle = $action === 'edit' ? 'Markayi Duzenle' : 'Yeni Marka';
    ?>
    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.15rem;margin-bottom:1.5rem"><?= $formTitle ?></h2>
      <form method="POST">
        <?php if (!empty($b['id'])): ?><input type="hidden" name="id" value="<?= (int)$b['id'] ?>"><?php endif; ?>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
          <div class="admin-form-group">
            <label>Marka Adi <span style="color:red">*</span></label>
            <input type="text" name="name" value="<?= htmlspecialchars($b['name']??'') ?>" required>
          </div>
          <div class="admin-form-group">
            <label>Slug <span style="color:red">*</span></label>
            <input type="text" name="slug" value="<?= htmlspecialchars($b['slug']??'') ?>" required placeholder="marka-adi">
          </div>
          <div class="admin-form-group">
            <label>Logo Yolu</label>
            <input type="text" name="logo" value="<?= htmlspecialchars($b['logo']??'') ?>" placeholder="img/marka-logo.png">
          </div>
          <div class="admin-form-group">
            <label>Mensei</label>
            <input type="text" name="origin" value="<?= htmlspecialchars($b['origin']??'') ?>" placeholder="Almanya, Japonya...">
          </div>
        </div>

        <div class="admin-form-group">
          <label>Aciklama</label>
          <textarea name="description" rows="4"><?= htmlspecialchars($b['description']??'') ?></textarea>
        </div>

        <h3 style="font-family:'Space Grotesk',sans-serif;margin:1.25rem 0 .75rem;font-size:1rem;color:var(--text-secondary)">SEO</h3>
        <div style="display:grid;gap:1rem">
          <div class="admin-form-group"><label>SEO Baslik</label><input type="text" name="seo_title" value="<?= htmlspecialchars($b['seo_title']??'') ?>"></div>
          <div class="admin-form-group"><label>SEO Aciklama</label><textarea name="seo_desc" rows="2"><?= htmlspecialchars($b['seo_desc']??'') ?></textarea></div>
          <div class="admin-form-group"><label>SEO Anahtar Kelimeler</label><input type="text" name="seo_keywords" value="<?= htmlspecialchars($b['seo_keywords']??'') ?>"></div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:1rem">
          <div class="admin-form-group"><label>Sira</label><input type="number" name="sort_order" value="<?= (int)($b['sort_order']??0) ?>"></div>
          <div class="admin-form-group"><label>Durum</label><label style="display:flex;align-items:center;gap:.4rem;font-size:.9rem;cursor:pointer;margin-top:.4rem"><input type="checkbox" name="active" <?= ($b['active']??1) ? 'checked' : '' ?>> Aktif</label></div>
        </div>

        <div style="display:flex;gap:1rem;margin-top:1.5rem">
          <button type="submit" class="btn-primary">Kaydet</button>
          <a href="brands.php" class="btn-outline" style="text-decoration:none">Iptal</a>
        </div>
      </form>
    </div>

    <?php else: ?>

    <!-- List -->
    <div class="admin-card">
      <div style="overflow-x:auto">
        <table class="admin-table">
          <thead><tr><th>#</th><th>Logo</th><th>Marka</th><th>Mensei</th><th>Sira</th><th>Durum</th><th>Islem</th></tr></thead>
          <tbody>
            <?php foreach ($allBrands as $brand): ?>
            <tr>
              <td><?= $brand['id'] ?></td>
              <td>
                <?php if ($brand['logo']): ?>
                <img src="../<?= htmlspecialchars($brand['logo']) ?>" alt="<?= htmlspecialchars($brand['name']) ?>" style="max-height:30px;max-width:60px;object-fit:contain">
                <?php else: ?>—<?php endif; ?>
              </td>
              <td><strong><?= htmlspecialchars($brand['name']) ?></strong><br><small style="color:var(--text-light)"><?= htmlspecialchars($brand['slug']) ?></small></td>
              <td><?= htmlspecialchars($brand['origin']??'') ?></td>
              <td><?= $brand['sort_order'] ?></td>
              <td><span class="badge-<?= $brand['active'] ? 'active' : 'inactive' ?>"><?= $brand['active'] ? 'Aktif' : 'Pasif' ?></span></td>
              <td style="white-space:nowrap">
                <a href="?action=edit&id=<?= $brand['id'] ?>" style="color:var(--primary);text-decoration:none;font-size:.85rem;font-weight:600;margin-right:.75rem">Duzenle</a>
                <a href="../markalar/<?= htmlspecialchars($brand['slug']) ?>" target="_blank" style="color:var(--secondary);text-decoration:none;font-size:.85rem;font-weight:600;margin-right:.75rem">Goruntule</a>
                <a href="?action=delete&id=<?= $brand['id'] ?>" style="color:var(--accent);text-decoration:none;font-size:.85rem;font-weight:600" onclick="return confirm('Silmek istediginize emin misiniz? Bu markaya ait tum urunler de silinecektir.')">Sil</a>
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
