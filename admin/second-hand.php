<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) { header('Location: index.php'); exit; }
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/site.php';
require_once __DIR__ . '/../includes/functions.php';

$db     = getDB();
$action = $_GET['action'] ?? 'list';
$msg    = '';

// ── Dosya yukleme yardimcisi ─────────────────────────
function handleUpload(string $inputName, string $targetDir, array $allowedExts): string {
    if (empty($_FILES[$inputName]) || $_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) return '';
    $file = $_FILES[$inputName];
    $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExts)) return '';
    $basePath = dirname(__DIR__);
    $dir = $basePath . '/' . $targetDir;
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $safeName = preg_replace('/[^a-z0-9\-\.]/', '-', strtolower(pathinfo($file['name'], PATHINFO_FILENAME)));
    $fileName = $safeName . '.' . $ext;
    $counter = 1;
    while (file_exists($dir . '/' . $fileName)) {
        $fileName = $safeName . '-' . $counter . '.' . $ext;
        $counter++;
    }
    if (move_uploaded_file($file['tmp_name'], $dir . '/' . $fileName)) {
        return $targetDir . '/' . $fileName;
    }
    return '';
}

// ── Kaydet / Guncelle ─────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id   = (int)($_POST['id'] ?? 0);
    $cols = ['title','brand','model','year','condition','description','price','currency','image',
             'contact_name','contact_phone','city','slug','active','featured'];

    $vals = [];
    foreach ($cols as $c) {
        if (in_array($c, ['active','featured'])) {
            $vals[$c] = isset($_POST[$c]) ? 1 : 0;
        } elseif ($c === 'price') {
            $vals[$c] = ($_POST[$c] ?? '') !== '' ? (float)$_POST[$c] : null;
        } elseif ($c === 'year') {
            $vals[$c] = ($_POST[$c] ?? '') !== '' ? (int)$_POST[$c] : null;
        } else {
            $vals[$c] = trim($_POST[$c] ?? '');
        }
    }

    // Gorsel dosya yukleme
    $imgPath = handleUpload('image_file', 'uploads/second-hand', ['jpg','jpeg','png','webp']);
    if ($imgPath) {
        // second_hand tablosunda sadece dosya adi saklanir
        $vals['image'] = basename($imgPath);
    }

    // Slug otomatik olustur
    if (empty($vals['slug']) && !empty($vals['title'])) {
        $vals['slug'] = slugify($vals['brand'] . '-' . $vals['model'] . '-' . ($vals['year'] ?? ''));
    }

    if ($id) {
        $set  = implode(', ', array_map(fn($c) => "`$c`=:$c", $cols));
        $stmt = $db->prepare("UPDATE second_hand SET $set WHERE id=:id");
        $vals['id'] = $id;
        $stmt->execute($vals);
        $msg = 'Ilan guncellendi.';
    } else {
        $cols_str  = implode(',', array_map(fn($c) => "`$c`", $cols));
        $binds_str = implode(',', array_map(fn($c) => ":$c", $cols));
        $stmt = $db->prepare("INSERT INTO second_hand ($cols_str) VALUES ($binds_str)");
        $stmt->execute($vals);
        $msg = 'Ilan eklendi.';
    }
    $action = 'list';
}

// ── Sil ──────────────────────────────────────────────
if ($action === 'delete' && !empty($_GET['id'])) {
    $db->prepare("DELETE FROM second_hand WHERE id=?")->execute([(int)$_GET['id']]);
    $msg = 'Ilan silindi.';
    $action = 'list';
}

// ── Edit formu icin veri ─────────────────────────────
$editItem = null;
if ($action === 'edit' && !empty($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM second_hand WHERE id=?");
    $stmt->execute([(int)$_GET['id']]);
    $editItem = $stmt->fetch();
}

$allItems = $db->query("SELECT * FROM second_hand ORDER BY featured DESC, created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Ikinci El | TomografiMarket Admin</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <meta name="robots" content="noindex, nofollow">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
      <h1 style="font-family:'Space Grotesk',sans-serif;font-size:1.5rem">Ikinci El Ilanlar</h1>
      <a href="?action=add" class="btn-primary" style="text-decoration:none;font-size:.9rem;padding:.6rem 1.25rem">+ Ilan Ekle</a>
    </div>

    <?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

    <?php if ($action === 'add' || $action === 'edit'):
      $item = $editItem ?? [];
      $formTitle = $action === 'edit' ? 'Ilani Duzenle' : 'Yeni Ilan';
    ?>
    <div class="admin-card">
      <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.15rem;margin-bottom:1.5rem"><?= $formTitle ?></h2>
      <form method="POST" enctype="multipart/form-data">
        <?php if (!empty($item['id'])): ?><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><?php endif; ?>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
          <div class="admin-form-group">
            <label>Ilan Basligi <span style="color:red">*</span></label>
            <input type="text" name="title" value="<?= htmlspecialchars($item['title']??'') ?>" required>
          </div>
          <div class="admin-form-group">
            <label>Slug</label>
            <input type="text" name="slug" value="<?= htmlspecialchars($item['slug']??'') ?>" placeholder="Bos birakirsaniz otomatik olusturulur">
          </div>
          <div class="admin-form-group">
            <label>Marka</label>
            <input type="text" name="brand" value="<?= htmlspecialchars($item['brand']??'') ?>" placeholder="Vatech, Planmeca...">
          </div>
          <div class="admin-form-group">
            <label>Model</label>
            <input type="text" name="model" value="<?= htmlspecialchars($item['model']??'') ?>" placeholder="PaX-i3D Green...">
          </div>
          <div class="admin-form-group">
            <label>Yil</label>
            <input type="number" name="year" value="<?= htmlspecialchars($item['year']??'') ?>" min="2000" max="2030">
          </div>
          <div class="admin-form-group">
            <label>Durum</label>
            <select name="condition">
              <?php foreach (['iyi'=>'Iyi','cok iyi'=>'Cok Iyi','mukemmel'=>'Mukemmel'] as $val=>$lbl): ?>
              <option value="<?= $val ?>" <?= ($item['condition']??'iyi')===$val?'selected':'' ?>><?= $lbl ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="admin-form-group">
          <label>Aciklama</label>
          <textarea name="description" rows="4"><?= htmlspecialchars($item['description']??'') ?></textarea>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem">
          <div class="admin-form-group">
            <label>Fiyat</label>
            <input type="number" name="price" value="<?= htmlspecialchars($item['price']??'') ?>" step="0.01" placeholder="Bos birakilirsa 'Fiyat icin iletisime gecin'">
          </div>
          <div class="admin-form-group">
            <label>Para Birimi</label>
            <select name="currency">
              <?php foreach (['TRY'=>'TRY','USD'=>'USD','EUR'=>'EUR'] as $v=>$l): ?>
              <option value="<?= $v ?>" <?= ($item['currency']??'TRY')===$v?'selected':'' ?>><?= $l ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="admin-form-group">
            <label>Sehir</label>
            <input type="text" name="city" value="<?= htmlspecialchars($item['city']??'') ?>" placeholder="Istanbul, Ankara...">
          </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
          <div class="admin-form-group">
            <label>Gorsel Yukle</label>
            <input type="file" name="image_file" accept="image/jpeg,image/png,image/webp" style="padding:.5rem">
            <?php if (!empty($item['image'])): ?>
            <small style="color:var(--text-light);display:block;margin-top:.3rem">Mevcut: <?= htmlspecialchars($item['image']) ?></small>
            <?php endif; ?>
            <input type="hidden" name="image" value="<?= htmlspecialchars($item['image']??'') ?>">
          </div>
          <div class="admin-form-group">
            <label>Iletisim Adi</label>
            <input type="text" name="contact_name" value="<?= htmlspecialchars($item['contact_name']??'') ?>">
          </div>
          <div class="admin-form-group">
            <label>Iletisim Telefon</label>
            <input type="text" name="contact_phone" value="<?= htmlspecialchars($item['contact_phone']??'') ?>">
          </div>
        </div>

        <div style="display:flex;gap:1.5rem;margin:1.25rem 0">
          <label style="display:flex;align-items:center;gap:.4rem;font-size:.9rem;cursor:pointer">
            <input type="checkbox" name="active" <?= ($item['active']??1) ? 'checked' : '' ?>> Aktif
          </label>
          <label style="display:flex;align-items:center;gap:.4rem;font-size:.9rem;cursor:pointer">
            <input type="checkbox" name="featured" <?= ($item['featured']??0) ? 'checked' : '' ?>> One Cikan
          </label>
        </div>

        <div style="display:flex;gap:1rem;margin-top:1.5rem">
          <button type="submit" class="btn-primary">Kaydet</button>
          <a href="second-hand.php" class="btn-outline" style="text-decoration:none">Iptal</a>
        </div>
      </form>
    </div>

    <?php else: ?>

    <!-- List -->
    <div class="admin-card">
      <?php if (empty($allItems)): ?>
      <p style="color:var(--text-secondary);text-align:center;padding:2rem">Henuz ikinci el ilan bulunmuyor.</p>
      <?php else: ?>
      <div style="overflow-x:auto">
        <table class="admin-table">
          <thead><tr><th>#</th><th>Baslik</th><th>Marka</th><th>Model</th><th>Fiyat</th><th>Sehir</th><th>Durum</th><th>Islem</th></tr></thead>
          <tbody>
            <?php foreach ($allItems as $item): ?>
            <tr>
              <td><?= $item['id'] ?></td>
              <td>
                <strong><?= htmlspecialchars($item['title']) ?></strong>
                <?php if ($item['featured']): ?><span style="color:var(--warning);font-size:.75rem;font-weight:700"> ONE CIKAN</span><?php endif; ?>
              </td>
              <td><?= htmlspecialchars($item['brand']??'') ?></td>
              <td><?= htmlspecialchars($item['model']??'') ?></td>
              <td><?= $item['price'] ? number_format($item['price'],0,',','.') . ' ' . htmlspecialchars($item['currency']) : '—' ?></td>
              <td><?= htmlspecialchars($item['city']??'') ?></td>
              <td><span class="badge-<?= $item['active'] ? 'active' : 'inactive' ?>"><?= $item['active'] ? 'Aktif' : 'Pasif' ?></span></td>
              <td style="white-space:nowrap">
                <a href="?action=edit&id=<?= $item['id'] ?>" style="color:var(--primary);text-decoration:none;font-size:.85rem;font-weight:600;margin-right:.75rem">Duzenle</a>
                <a href="?action=delete&id=<?= $item['id'] ?>" style="color:var(--accent);text-decoration:none;font-size:.85rem;font-weight:600" onclick="return confirm('Ilani silmek istediginize emin misiniz?')">Sil</a>
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
