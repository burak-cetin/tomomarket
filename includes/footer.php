<?php
// includes/footer.php
if (!defined('SITE_NAME')) require_once __DIR__ . '/../config/site.php';
if (!function_exists('getBrands')) require_once __DIR__ . '/functions.php';
$_depth = $depth ?? '';
$_brands = getBrands();
?>

<!-- ═══ FOOTER ════════════════════════════════════════════ -->
<footer>
  <div class="footer-container">
    <div class="footer-brand">
      <h3>TomografiMarket</h3>
      <p>Dental görüntüleme teknolojilerinde Türkiye'nin güvenilir çözüm ortağı. LargeV, HDXWILL, Vatech, Planmeca ve daha birçok dünya markasının yetkili distribütörüyüz.</p>
    </div>

    <div class="footer-section">
      <h4>İletişim</h4>
      <p><a href="mailto:<?= SITE_EMAIL ?>">📧 <?= SITE_EMAIL ?></a></p>
      <p><a href="tel:<?= SITE_PHONE1 ?>">📞 +90 (850) 303 78 93</a></p>
      <p><a href="tel:<?= SITE_PHONE2 ?>">💬 +90 (505) 773 78 03</a></p>
    </div>

    <div class="footer-section">
      <h4>Hızlı Linkler</h4>
      <p><a href="<?= $_depth ?>index.php#brands">Tüm Markalar</a></p>
      <p><a href="<?= $_depth ?>ikinci-el.php">İkinci El Cihazlar</a></p>
      <p><a href="<?= $_depth ?>blog/index.php">Blog &amp; Rehberler</a></p>
      <p><a href="<?= $_depth ?>sayfalar/karsilastirma.php">Cihaz Karşılaştır</a></p>
      <p><a href="<?= $_depth ?>sayfalar/hakkimizda.php">Hakkımızda</a></p>
      <p><a href="<?= $_depth ?>sayfalar/kvkk.php">KVKK</a></p>
    </div>

    <div class="footer-section">
      <h4>Markalar</h4>
      <?php foreach (array_slice($_brands, 0, 8) as $b): ?>
      <p><a href="<?= $_depth ?>markalar/<?= h($b['slug']) ?>-tomografi.php"><?= h($b['name']) ?></a></p>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="footer-bottom">
    <p>&copy; <?= date('Y') ?> TomografiMarket. Tüm hakları saklıdır.
    | <a href="<?= $_depth ?>sayfalar/kvkk.php">KVKK</a>
    | <a href="<?= $_depth ?>sayfalar/gizlilik.php">Gizlilik Politikası</a>
    </p>
  </div>
</footer>

<!-- WhatsApp -->
<a href="https://wa.me/<?= SITE_WA ?>?text=Merhaba%2C%20dental%20görüntüleme%20ekipmanları%20hakkında%20bilgi%20almak%20istiyorum."
   class="whatsapp-btn" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp ile iletişime geç">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
  </svg>
</a>

<!-- ═══ İLETİŞİM MODAL ════════════════════════════════════ -->
<div class="contact-modal" id="contact-modal" role="dialog" aria-modal="true" aria-label="İletişim Formu">
  <div class="contact-modal-content">
    <div class="contact-modal-header">
      <button class="contact-modal-close" onclick="closeContactModal()" aria-label="Kapat">×</button>
      <h2>Bize Ulaşın</h2>
      <p>Size en kısa sürede dönüş yapalım</p>
    </div>
    <div class="contact-modal-body">
      <form id="contact-form" onsubmit="handleContactSubmit(event)">
        <div class="contact-form-group">
          <label>Ad Soyad <span class="required">*</span></label>
          <input type="text" name="name" placeholder="Adınız ve soyadınız" required>
        </div>
        <div class="contact-form-group">
          <label>E-posta <span class="required">*</span></label>
          <input type="email" name="email" placeholder="ornek@email.com" required>
        </div>
        <div class="contact-form-group">
          <label>Telefon</label>
          <input type="tel" name="phone" placeholder="05XX XXX XX XX">
        </div>
        <div class="contact-form-group">
          <label>İlgilendiğiniz Cihaz</label>
          <input type="text" name="subject" placeholder="Örn: LargeV Smart3D-X" id="contact-subject">
        </div>
        <div class="contact-form-group">
          <label>Mesajınız</label>
          <textarea name="message" placeholder="Mesajınızı buraya yazabilirsiniz..." rows="4"></textarea>
        </div>
        <div class="contact-form-checkbox">
          <input type="checkbox" id="contact-kvkk" required>
          <label for="contact-kvkk">
            <a href="<?= $_depth ?>sayfalar/kvkk.php" target="_blank">KVKK aydınlatma metnini</a> okudum ve kabul ediyorum
          </label>
        </div>
        <button type="submit" class="contact-form-submit" id="contact-submit-btn">Mesajı Gönder</button>
      </form>
    </div>
  </div>
</div>

<!-- ═══ SCRIPTS ═══════════════════════════════════════════ -->
<script src="<?= $_depth ?>assets/js/main.js"></script>
</body>
</html>
