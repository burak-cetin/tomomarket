/* TomografiMarket Chatbot — Rule-based */
(function() {
  'use strict';

  // ═══════════════════════════════════════════════════════
  //  KURAL SETI
  // ═══════════════════════════════════════════════════════

  const SITE_WA = '905057737803';
  const SITE_EMAIL = 'info@tomografimarket.com';
  const SITE_PHONE = '+908503037893';

  // Her kural: anahtar kelimeler + cevap (+ opsiyonel hizli secenekler)
  const rules = [
    {
      name: 'selam',
      keywords: ['merhaba', 'selam', 'selamlar', 'hello', 'hi', 'iyi gunler', 'iyi günler', 'gunaydin', 'günaydın', 'iyi aksamlar', 'iyi akşamlar'],
      answer: 'Merhaba! 👋 TomografiMarket asistanına hoş geldiniz. Size nasıl yardımcı olabilirim?',
      quickReplies: ['Fiyat bilgisi almak istiyorum', 'Cihaz karşılaştırmak istiyorum', 'İkinci el cihazlar', 'Teknik destek']
    },
    {
      name: 'fiyat',
      keywords: ['fiyat', 'kac para', 'kaç para', 'ucret', 'ücret', 'maliyet', 'butce', 'bütçe', 'ne kadar', 'tutar', 'ödeme', 'odeme'],
      answer: 'Dental tomografi cihaz fiyatları; marka, menşe ülke, 2D/3D özellik, FOV boyutu ve yazılım paketine göre değişiklik gösterir. Size özel fiyat teklifi için lütfen iletişime geçin.',
      quickReplies: ['WhatsApp ile iletişim', 'İletişim formu']
    },
    {
      name: 'taksit',
      keywords: ['taksit', 'kredi', 'finansman', 'leasing', 'taksitli'],
      answer: 'Taksit, leasing ve finansman seçenekleri konusunda uzman ekibimiz size detaylı bilgi verebilir. WhatsApp üzerinden iletişime geçin.',
      quickReplies: ['WhatsApp ile iletişim']
    },
    {
      name: 'ikinci_el',
      keywords: ['ikinci el', 'kullanilmis', 'kullanılmış', '2.el', 'ikinci', 'second hand', 'second-hand', 'used'],
      answer: 'İkinci el dental tomografi ilanlarımızı inceleyebilirsiniz. Tüm ilanlar uzman ekibimiz tarafından değerlendirilir.',
      quickReplies: ['İkinci el sayfasına git', 'İlan vermek istiyorum']
    },
    {
      name: 'karsilastirma',
      keywords: ['karsilastir', 'karşılaştır', 'kiyasla', 'kıyasla', 'compare', 'fark', 'karsilastirma', 'karşılaştırma'],
      answer: 'Cihazları yan yana karşılaştırmak için karşılaştırma sayfamızı kullanabilirsiniz. En fazla 4 cihazı FOV, voksel, sensör vb. özellikleriyle kıyaslayabilirsiniz.',
      quickReplies: ['Karşılaştırma sayfası']
    },
    {
      name: 'cbct_teknik',
      keywords: ['cbct', 'cone beam', 'conebeam', '3d tomografi', '3 boyutlu', 'fov', 'voksel', 'voxel', 'teknik', 'özellik', 'ozellik'],
      answer: 'CBCT (Cone Beam CT), 3 boyutlu dental görüntüleme teknolojisidir. FOV (görüntüleme alanı), voksel boyutu, tarama süresi ve sensör tipi seçim kriterleridir. Detaylı rehberimize göz atabilirsiniz.',
      quickReplies: ['CBCT Nedir rehberi', 'Cihazları karşılaştır']
    },
    {
      name: 'panoramik',
      keywords: ['panoramik', '2d', 'rontgen', 'röntgen', 'opg'],
      answer: '2D panoramik röntgen (OPG) cihazları; çenenin düzlemsel görüntüsünü sunar. Uygun fiyatlı seçeneklerden premium seviyeye kadar geniş ürün yelpazemiz var.',
      quickReplies: ['2D cihazları gör', 'Fiyat bilgisi al']
    },
    {
      name: 'marka',
      keywords: ['marka', 'brand', 'hangi markalar', 'marka listesi', 'vatech', 'planmeca', 'sirona', 'morita', 'largev', 'hdxwill', 'carestream', 'gendex', 'owandy', 'newtom', 'castellini', 'myray', 'meyer', 'pointnix', 'durr'],
      answer: 'Platformumuzda 15 dünya markası bulunmaktadır: LargeV, HDXWILL, Vatech, Planmeca, Sirona, Morita, NewTom, Carestream, Gendex, Owandy, MyRay, Castellini, Meyer, Pointnix, Dürr Dental.',
      quickReplies: ['Tüm markaları gör']
    },
    {
      name: 'servis',
      keywords: ['servis', 'ariza', 'arıza', 'tamir', 'bakim', 'bakım', 'sorun', 'calismiyor', 'çalışmıyor', 'bozuk'],
      answer: 'Teknik servis ve bakım konuları için satıcı firmanın yetkili servisine yönlendirme yapıyoruz. Uzman ekibimiz size doğru servisi bulmanızda yardımcı olabilir.',
      quickReplies: ['WhatsApp ile iletişim']
    },
    {
      name: 'yazilim',
      keywords: ['yazilim', 'yazılım', 'software', 'dicom', 'program', 'lisans'],
      answer: 'Dental tomografi cihazları DICOM standardında çalışır. Yazılım lisansı, güncelleme ve uyumluluk konuları marka bazında farklılık gösterir. Detaylı bilgi için iletişime geçin.',
      quickReplies: ['WhatsApp ile iletişim', 'İletişim formu']
    },
    {
      name: 'kurulum',
      keywords: ['kurulum', 'montaj', 'teslimat', 'nakliye', 'kargo', 'kurma'],
      answer: 'Cihaz kurulumu ve teslimatı; seçilen marka ve satıcı firmanın politikalarına göre değişir. Detaylı bilgi için ilgili ürün sayfasından iletişime geçebilirsiniz.',
      quickReplies: ['Ürünleri gör', 'WhatsApp ile iletişim']
    },
    {
      name: 'egitim',
      keywords: ['egitim', 'eğitim', 'training', 'kullanım', 'kullanim', 'nasil kullanilir', 'nasıl kullanılır'],
      answer: 'Cihaz kurulumu sonrası kullanıcı eğitimi satıcı firma tarafından verilir. Eğitim detayları için bize ulaşın.',
      quickReplies: ['WhatsApp ile iletişim']
    },
    {
      name: 'garanti',
      keywords: ['garanti', 'iade', 'warranty', 'güvence', 'guvence'],
      answer: 'Garanti süreleri ve koşulları marka bazında değişmektedir. Ortalama 2 yıl garanti standarttır. Detay için ilgili ürün sayfasındaki satıcıya ulaşın.',
      quickReplies: ['Ürünleri gör']
    },
    {
      name: 'blog',
      keywords: ['blog', 'rehber', 'makale', 'yazi', 'yazı', 'içerik', 'icerik'],
      answer: 'Blog bölümümüzde CBCT teknolojisi, fiyat rehberi, ikinci el alım kılavuzu ve implant planlaması gibi birçok konuda detaylı içerik bulabilirsiniz.',
      quickReplies: ['Blog sayfasına git']
    },
    {
      name: 'iletisim',
      keywords: ['iletisim', 'iletişim', 'telefon', 'email', 'e-posta', 'adres', 'ulasmak', 'ulaşmak', 'numaranız', 'numaraniz'],
      answer: `📞 Telefon: ${SITE_PHONE}<br>💬 WhatsApp: +90 505 773 78 03<br>📧 E-posta: ${SITE_EMAIL}`,
      quickReplies: ['WhatsApp ile iletişim', 'İletişim formu']
    },
    {
      name: 'tesekkur',
      keywords: ['tesekkur', 'teşekkür', 'sagol', 'sağol', 'thanks', 'mersi', 'eyvallah'],
      answer: 'Rica ederim! 😊 Başka bir konuda yardımcı olabilir miyim?',
      quickReplies: ['Fiyat bilgisi', 'Karşılaştırma', 'Hayır teşekkürler']
    },
    {
      name: 'veda',
      keywords: ['bay bay', 'hosca kal', 'hoşça kal', 'gorusmek', 'görüşmek', 'hayir tesekkurler', 'hayır teşekkürler', 'hayir', 'hayır'],
      answer: 'İyi günler! 👋 Tekrar görüşmek üzere. Herhangi bir sorunuz olduğunda buradayız.',
      quickReplies: []
    }
  ];

  // Hizli secenek ile URL/aksiyon eslesmesi
  const quickActions = {
    'WhatsApp ile iletişim': { type: 'url', url: `https://wa.me/${SITE_WA}?text=Merhaba%2C%20bilgi%20almak%20istiyorum.` },
    'İletişim formu': { type: 'modal' },
    'İkinci el sayfasına git': { type: 'url', url: '/ikinci-el' },
    'İlan vermek istiyorum': { type: 'modal', subject: 'İkinci el cihaz ilanı vermek istiyorum' },
    'Karşılaştırma sayfası': { type: 'url', url: '/sayfalar/karsilastirma' },
    'CBCT Nedir rehberi': { type: 'url', url: '/blog/cbct-nedir-dental-tomografi-rehberi' },
    'Cihazları karşılaştır': { type: 'url', url: '/sayfalar/karsilastirma' },
    '2D cihazları gör': { type: 'url', url: '/#urunler' },
    'Tüm markaları gör': { type: 'url', url: '/#brands' },
    'Ürünleri gör': { type: 'url', url: '/#urunler' },
    'Blog sayfasına git': { type: 'url', url: '/blog/' },
    'Fiyat bilgisi al': { type: 'modal', subject: 'Fiyat bilgisi almak istiyorum' },
    'Fiyat bilgisi almak istiyorum': { type: 'message', text: 'fiyat' },
    'Cihaz karşılaştırmak istiyorum': { type: 'message', text: 'karsilastirma' },
    'İkinci el cihazlar': { type: 'message', text: 'ikinci el' },
    'Teknik destek': { type: 'message', text: 'servis' },
    'Fiyat bilgisi': { type: 'message', text: 'fiyat' },
    'Karşılaştırma': { type: 'message', text: 'karsilastirma' },
    'Hayır teşekkürler': { type: 'message', text: 'hayir' },
  };

  // ═══════════════════════════════════════════════════════
  //  YARDIMCI FONKSIYONLAR
  // ═══════════════════════════════════════════════════════

  function normalize(text) {
    return text.toLowerCase()
      .replace(/ı/g, 'i').replace(/ğ/g, 'g').replace(/ü/g, 'u')
      .replace(/ş/g, 's').replace(/ö/g, 'o').replace(/ç/g, 'c')
      .trim();
  }

  function findRule(userText) {
    const text = normalize(userText);
    let bestMatch = null;
    let bestScore = 0;

    for (const rule of rules) {
      for (const keyword of rule.keywords) {
        const nk = normalize(keyword);
        if (text.includes(nk)) {
          // Uzun anahtar kelimeler daha yuksek puan alir
          const score = nk.length;
          if (score > bestScore) {
            bestScore = score;
            bestMatch = rule;
          }
        }
      }
    }
    return bestMatch;
  }

  function fallbackAnswer() {
    return {
      name: 'fallback',
      answer: 'Üzgünüm, bu konuda tam bir cevap veremiyorum. 🤔 Size daha iyi yardımcı olabilmemiz için uzman ekibimizle iletişime geçmenizi öneririm.',
      quickReplies: ['WhatsApp ile iletişim', 'İletişim formu']
    };
  }

  // ═══════════════════════════════════════════════════════
  //  UI OLUSTURMA
  // ═══════════════════════════════════════════════════════

  function buildUI() {
    const btn = document.createElement('button');
    btn.className = 'chatbot-btn';
    btn.setAttribute('aria-label', 'Yardım chatbot');
    btn.innerHTML = `
      <svg viewBox="0 0 24 24" width="30" height="30" fill="currentColor" aria-hidden="true">
        <path d="M20 9V7c0-1.1-.9-2-2-2h-3V3c0-.55-.45-1-1-1h-4c-.55 0-1 .45-1 1v2H6c-1.1 0-2 .9-2 2v2c-1.1 0-2 .9-2 2v3c0 1.1.9 2 2 2v4c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-4c1.1 0 2-.9 2-2v-3c0-1.1-.9-2-2-2zm-4 8H8v-2h8v2zm.5-5c-.83 0-1.5-.67-1.5-1.5S15.67 9 16.5 9s1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm-9 0C6.67 12 6 11.33 6 10.5S6.67 9 7.5 9s1.5.67 1.5 1.5S8.33 12 7.5 12z"/>
      </svg>
      <span class="chatbot-notif" id="chatbot-notif">1</span>
    `;
    btn.addEventListener('click', toggleChat);
    document.body.appendChild(btn);

    const panel = document.createElement('div');
    panel.className = 'chatbot-panel';
    panel.id = 'chatbot-panel';
    panel.innerHTML = `
      <div class="chatbot-header">
        <div class="chatbot-header-info">
          <div class="chatbot-avatar">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="#fff" aria-hidden="true">
              <path d="M20 9V7c0-1.1-.9-2-2-2h-3V3c0-.55-.45-1-1-1h-4c-.55 0-1 .45-1 1v2H6c-1.1 0-2 .9-2 2v2c-1.1 0-2 .9-2 2v3c0 1.1.9 2 2 2v4c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-4c1.1 0 2-.9 2-2v-3c0-1.1-.9-2-2-2zm-4 8H8v-2h8v2zm.5-5c-.83 0-1.5-.67-1.5-1.5S15.67 9 16.5 9s1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm-9 0C6.67 12 6 11.33 6 10.5S6.67 9 7.5 9s1.5.67 1.5 1.5S8.33 12 7.5 12z"/>
            </svg>
          </div>
          <div>
            <div class="chatbot-title">TomografiBot</div>
            <div class="chatbot-status"><span class="chatbot-dot"></span> Çevrimiçi</div>
          </div>
        </div>
        <button class="chatbot-close" aria-label="Kapat">×</button>
      </div>
      <div class="chatbot-body" id="chatbot-body"></div>
      <div class="chatbot-quick" id="chatbot-quick"></div>
      <form class="chatbot-input-form" id="chatbot-form" autocomplete="off">
        <input type="text" id="chatbot-input" placeholder="Mesajınızı yazın..." aria-label="Mesaj">
        <button type="submit" aria-label="Gönder">
          <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
        </button>
      </form>
    `;
    document.body.appendChild(panel);

    panel.querySelector('.chatbot-close').addEventListener('click', toggleChat);
    document.getElementById('chatbot-form').addEventListener('submit', onSubmit);
  }

  function toggleChat() {
    const panel = document.getElementById('chatbot-panel');
    const notif = document.getElementById('chatbot-notif');
    const wasOpen = panel.classList.contains('active');
    panel.classList.toggle('active');
    if (notif) notif.style.display = 'none';
    // Ilk kez acilirsa hosgeldin mesaji
    if (!wasOpen && !panel.dataset.initialized) {
      panel.dataset.initialized = '1';
      setTimeout(() => {
        renderBotMessage({
          answer: 'Merhaba! 👋 Ben TomografiBot. Dental tomografi cihazları hakkında sorularınızı yanıtlayabilirim. Aşağıdan hızlı bir seçenek seçebilir veya sorunuzu yazabilirsiniz.',
          quickReplies: ['Fiyat bilgisi almak istiyorum', 'Cihaz karşılaştırmak istiyorum', 'İkinci el cihazlar', 'Teknik destek']
        });
      }, 300);
    }
    if (panel.classList.contains('active')) {
      setTimeout(() => document.getElementById('chatbot-input')?.focus(), 300);
    }
  }

  function onSubmit(e) {
    e.preventDefault();
    const input = document.getElementById('chatbot-input');
    const text = input.value.trim();
    if (!text) return;
    input.value = '';
    handleUserMessage(text);
  }

  function handleUserMessage(text) {
    renderUserMessage(text);
    // Yazisyor animasyonu
    showTyping();
    setTimeout(() => {
      hideTyping();
      const rule = findRule(text) || fallbackAnswer();
      renderBotMessage(rule);
    }, 600);
  }

  function renderUserMessage(text) {
    const body = document.getElementById('chatbot-body');
    const msg = document.createElement('div');
    msg.className = 'chatbot-msg chatbot-msg-user';
    msg.textContent = text;
    body.appendChild(msg);
    body.scrollTop = body.scrollHeight;
  }

  function renderBotMessage(rule) {
    const body = document.getElementById('chatbot-body');
    const msg = document.createElement('div');
    msg.className = 'chatbot-msg chatbot-msg-bot';
    msg.innerHTML = rule.answer;
    body.appendChild(msg);
    body.scrollTop = body.scrollHeight;

    // Hizli cevap butonlari
    const quick = document.getElementById('chatbot-quick');
    quick.innerHTML = '';
    if (rule.quickReplies && rule.quickReplies.length) {
      rule.quickReplies.forEach(label => {
        const btn = document.createElement('button');
        btn.className = 'chatbot-quick-btn';
        btn.textContent = label;
        btn.addEventListener('click', () => handleQuickAction(label));
        quick.appendChild(btn);
      });
    }
  }

  function handleQuickAction(label) {
    const action = quickActions[label];
    if (!action) {
      renderUserMessage(label);
      handleUserMessage(label);
      return;
    }
    if (action.type === 'url') {
      renderUserMessage(label);
      setTimeout(() => {
        renderBotMessage({ answer: 'Sizi ilgili sayfaya yönlendiriyorum... 🔗', quickReplies: [] });
        setTimeout(() => {
          if (action.url.startsWith('http')) window.open(action.url, '_blank');
          else window.location.href = action.url;
        }, 600);
      }, 200);
    } else if (action.type === 'modal') {
      renderUserMessage(label);
      setTimeout(() => {
        renderBotMessage({ answer: 'İletişim formunu açıyorum. Bilgilerinizi doldurup gönderdikten sonra size en kısa sürede dönüş yapacağız. ✉️', quickReplies: [] });
        if (typeof window.openContactModal === 'function') {
          window.openContactModal(action.subject || '');
        }
      }, 200);
    } else if (action.type === 'message') {
      renderUserMessage(label);
      showTyping();
      setTimeout(() => {
        hideTyping();
        const rule = findRule(action.text) || fallbackAnswer();
        renderBotMessage(rule);
      }, 500);
    }
  }

  function showTyping() {
    const body = document.getElementById('chatbot-body');
    const el = document.createElement('div');
    el.className = 'chatbot-msg chatbot-msg-bot chatbot-typing';
    el.id = 'chatbot-typing';
    el.innerHTML = '<span></span><span></span><span></span>';
    body.appendChild(el);
    body.scrollTop = body.scrollHeight;
  }

  function hideTyping() {
    const el = document.getElementById('chatbot-typing');
    if (el) el.remove();
  }

  // Baslat
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', buildUI);
  } else {
    buildUI();
  }
})();
