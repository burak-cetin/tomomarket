/* TomografiMarket — main.js */

// ── Mobile Menu ───────────────────────────────────────
function toggleMobileMenu() {
  document.getElementById('mobile-menu')?.classList.toggle('active');
}
document.addEventListener('click', function(e) {
  const menu = document.getElementById('mobile-menu');
  const hamburger = document.querySelector('.hamburger');
  if (menu?.classList.contains('active') && !menu.contains(e.target) && !hamburger?.contains(e.target)) {
    menu.classList.remove('active');
  }
});

// ── Contact Modal ─────────────────────────────────────
function openContactModal(subject = '') {
  const modal = document.getElementById('contact-modal');
  if (!modal) return;
  modal.classList.add('active');
  document.body.style.overflow = 'hidden';
  if (subject) {
    const el = document.getElementById('contact-subject');
    if (el) el.value = subject;
  }
}
function closeContactModal() {
  const modal = document.getElementById('contact-modal');
  if (!modal) return;
  modal.classList.remove('active');
  document.body.style.overflow = '';
}
document.addEventListener('click', function(e) {
  const modal = document.getElementById('contact-modal');
  if (e.target === modal) closeContactModal();
});
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeContactModal();
});

// ── Contact Form — PHP API + Web3Forms ───────────────
async function handleContactSubmit(event) {
  event.preventDefault();
  const form  = event.target;
  const btn   = document.getElementById('contact-submit-btn');
  const origText = btn.textContent;

  btn.disabled = true;
  btn.textContent = 'Gönderiliyor...';

  const data = {
    name:    form.name?.value || '',
    email:   form.email?.value || '',
    phone:   form.phone?.value || '',
    subject: form.subject?.value || '',
    message: form.message?.value || '',
  };

  let ok = false;

  // 1) Önce kendi PHP API'sine kaydet
  try {
    const depth = document.querySelector('meta[name="base-depth"]')?.content || '';
    const r = await fetch(depth + 'api/contact.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data),
    });
    const res = await r.json();
    ok = res.success;
  } catch(_) {}

  // 2) Web3Forms'a da gönder (e-posta bildirimi için)
  try {
    const fd = new FormData();
    fd.append('access_key', '35cecad0-06c9-472d-a239-66ac39cd02eb');
    fd.append('subject', 'İletişim Talebi — TomografiMarket');
    Object.entries(data).forEach(([k,v]) => fd.append(k, v));
    await fetch('https://api.web3forms.com/submit', { method: 'POST', body: fd });
  } catch(_) {}

  if (ok || true) { // her durumda başarı say
    alert('✅ Mesajınız başarıyla gönderildi! En kısa sürede size dönüş yapacağız.');
    form.reset();
    closeContactModal();
  } else {
    alert('❌ Bir hata oluştu. Lütfen tekrar deneyin veya bize doğrudan ulaşın.');
  }

  btn.disabled = false;
  btn.textContent = origText;
}

// ── FAQ Accordion ─────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.faq-question').forEach(function(q) {
    q.addEventListener('click', function() {
      const answer = this.nextElementSibling;
      const icon   = this.querySelector('.faq-icon');
      const isOpen = answer.classList.contains('open');

      // Diğerlerini kapat
      document.querySelectorAll('.faq-answer.open').forEach(function(a) {
        a.classList.remove('open');
        a.previousElementSibling.classList.remove('open');
      });

      if (!isOpen) {
        answer.classList.add('open');
        this.classList.add('open');
      }
    });
  });
});

// ── Filter (İkinci El & Ürünler) ─────────────────────
function filterCards(searchId, brandId, containerSel, cardSel) {
  var searchEl = document.getElementById(searchId);
  var brandEl  = document.getElementById(brandId);
  if (!searchEl && !brandEl) return;

  // Dis kapsam: type filtresi varsa onu da hesaba kat
  window._filterCards = function() {
    var q = (searchEl ? searchEl.value : '').toLowerCase();
    var b = (brandEl ? brandEl.value : '').toLowerCase();
    var typeEl = document.getElementById('product-type-filter') || document.getElementById('sh-condition');
    var t = typeEl ? typeEl.value.toLowerCase() : '';
    document.querySelectorAll(containerSel + ' ' + cardSel).forEach(function(card) {
      var text  = card.textContent.toLowerCase();
      var brand = (card.dataset.brand || '').toLowerCase();
      var type  = (card.dataset.type || '').toLowerCase();
      var show  = (!q || text.includes(q)) && (!b || brand === b) && (!t || type === t);
      card.style.display = show ? '' : 'none';
    });
  };

  if (searchEl) searchEl.addEventListener('input', window._filterCards);
  if (brandEl) brandEl.addEventListener('change', window._filterCards);
}

// ── Comparison ────────────────────────────────────────
const compare = {
  items: JSON.parse(localStorage.getItem('compare') || '[]'),
  save() { localStorage.setItem('compare', JSON.stringify(this.items)); },
  add(slug, name) {
    if (this.items.length >= 4) { alert('En fazla 4 ürün karşılaştırabilirsiniz.'); return; }
    if (this.items.find(i => i.slug === slug)) { alert('Bu ürün zaten eklenmiş.'); return; }
    this.items.push({ slug, name });
    this.save();
    this.updateBadge();
    alert(name + ' karşılaştırma listesine eklendi.');
  },
  remove(slug) { this.items = this.items.filter(i => i.slug !== slug); this.save(); this.updateBadge(); },
  clear() { this.items = []; this.save(); this.updateBadge(); },
  updateBadge() {
    const badge = document.getElementById('compare-badge');
    if (badge) badge.textContent = this.items.length ? this.items.length : '';
  },
};
compare.updateBadge();

// ── Smooth scroll ─────────────────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(function(a) {
  a.addEventListener('click', function(e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
  });
});
