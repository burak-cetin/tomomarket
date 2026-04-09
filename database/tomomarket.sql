-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 09 Nis 2026, 08:17:06
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `tomomarket`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `excerpt` varchar(500) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `author` varchar(150) DEFAULT 'TomografiMarket',
  `category` varchar(100) DEFAULT NULL,
  `tags` varchar(400) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_desc` varchar(400) DEFAULT NULL,
  `published` tinyint(1) DEFAULT 0,
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `slug`, `title`, `excerpt`, `content`, `cover_image`, `author`, `category`, `tags`, `seo_title`, `seo_desc`, `published`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'cbct-nedir-dental-tomografi-rehberi', 'CBCT Nedir? Dental Tomografi Hakkında Kapsamlı Rehber', 'Cone Beam Bilgisayarlı Tomografi (CBCT) teknolojisi, diş hekimliğinde teşhis ve tedavi planlamasını devrim niteliğinde değiştirmiştir. Bu rehberde CBCT\'nin ne olduğunu, nasıl çalıştığını ve kliniğiniz için doğru cihazı nasıl seçeceğinizi öğrenin.', '<h2>CBCT (Cone Beam CT) Nedir?</h2><p>Cone Beam Bilgisayarlı Tomografi (CBCT), dental görüntülemede devrim yaratan üç boyutlu görüntüleme teknolojisidir. Klasik tıbbi CT cihazlarından farklı olarak, CBCT tek bir dönüş hareketi ile yüksek çözünürlüklü 3D görüntü elde eder ve çok daha düşük radyasyon dozu kullanır.</p><h2>CBCT ile Panoramik Röntgenin Farkı Nedir?</h2><p>Panoramik röntgen (OPG) 2 boyutlu düzlemsel bir görüntü sunarken, CBCT üç boyutlu hacimsel veri sağlar. Bu sayede diş hekimi dişin tüm eksenlerde detaylı görüntüsünü inceleyebilir.</p><h3>CBCT\'nin Kullanım Alanları</h3><ul><li>İmplant planlaması ve yerleşimi</li><li>Kanal tedavisi (Endodonti)</li><li>Ortodontik analiz</li><li>Cerrahi planlama</li><li>Çene kemiği patolojilerinin tespiti</li><li>TMJ (Temporomandibular eklem) değerlendirmesi</li></ul><h2>Doğru CBCT Cihazını Nasıl Seçmeliyim?</h2><p>Kliniğiniz için doğru CBCT seçiminde şu kriterleri göz önünde bulundurun:</p><ul><li><strong>FOV (Field of View):</strong> Küçük FOV endodonti için, büyük FOV implant ve cerrahi için uygundur.</li><li><strong>Voksel boyutu:</strong> Küçük voksel = yüksek çözünürlük ama uzun tarama süresi.</li><li><strong>Tarama süresi:</strong> Kısa tarama süresi hareket artefaktını azaltır.</li><li><strong>Yazılım desteği:</strong> Türkçe yazılım ve lokal teknik destek önemlidir.</li></ul>', NULL, 'TomografiMarket', 'Rehber', 'cbct, dental tomografi, diş hekimliği, görüntüleme', 'CBCT Nedir? Dental Tomografi Rehberi 2024 | TomografiMarket', 'CBCT nedir, nasıl çalışır, panoramik röntgenden farkı nedir? Kliniğiniz için doğru dental tomografi nasıl seçilir? Kapsamlı rehber.', 1, '2024-11-01 10:00:00', '2026-04-02 10:21:56', '2026-04-02 10:21:56'),
(2, 'dental-tomografi-fiyatlari-2024', 'Dental Tomografi Cihazı Fiyatları 2024 — Ne Kadar Bütçe Ayırmalısınız?', '2024 yılında dental CBCT ve panoramik röntgen cihazı fiyatları, marka, özellik ve menşeye göre büyük farklılıklar göstermektedir. Bu yazımızda fiyat aralıklarını ve bütçenize göre en iyi seçimi nasıl yapacağınızı ele alıyoruz.', '<h2>Dental Tomografi Fiyatlarını Etkileyen Faktörler</h2><p>Dental görüntüleme cihazı fiyatları; marka, menşe ülke, görüntüleme modu (2D/3D), FOV boyutu ve yazılım özellikleri gibi pek çok faktöre göre değişmektedir.</p><h3>Fiyat Kategorileri</h3><h4>Giriş Seviyesi 3D CBCT</h4><p>Çin ve Kore menşeli kompakt modeller, giriş seviyesi CBCT pazarında uygun seçenekler sunar. Bu kategorideki cihazlar temel klinik ihtiyaçları karşılamaktadır.</p><h4>Orta Segment</h4><p>İtalyan ve Koreli markaların orta segment cihazları, daha geniş FOV ve gelişmiş yazılım özellikleri sunar.</p><h4>Üst Segment</h4><p>Alman ve Finlandalı markaların üst segment cihazları, maksimum görüntü kalitesi ve yapay zeka entegrasyonu ile fark yaratır.</p><h2>Doğru Bütçe Planlaması</h2><p>Cihaz maliyeti hesaplanırken sadece satın alma fiyatı değil, kurulum, eğitim, yıllık bakım ve yazılım lisans ücretleri de göz önünde bulundurulmalıdır. TomografiMarket olarak size bütçenize uygun en iyi seçeneği bulmakta yardımcı oluyoruz.</p>', NULL, 'TomografiMarket', 'Fiyat Rehberi', 'dental tomografi fiyat, cbct fiyat, dental cihaz fiyat, panoramik röntgen fiyat', 'Dental Tomografi Fiyatları 2024 | TomografiMarket', '2024 dental tomografi cihazı fiyatları. CBCT ve panoramik röntgen fiyat aralıkları, bütçenize uygun en iyi seçim rehberi.', 1, '2024-11-15 10:00:00', '2026-04-02 10:21:56', '2026-04-02 10:21:56'),
(3, 'ikinci-el-dental-tomografi-alirken-dikkat-edilmesi-gerekenler', 'İkinci El Dental Tomografi Alırken Dikkat Edilmesi Gerekenler', 'İkinci el CBCT veya panoramik röntgen cihazı alımında nelere dikkat etmelisiniz? Fiyat, bakım geçmişi, yedek parça ve yazılım uyumluluğu konularında uzman rehberi.', '<h2>İkinci El Dental Cihaz Alımında Risk Değerlendirmesi</h2><p>İkinci el dental görüntüleme cihazı, yeni cihaza kıyasla önemli maliyet avantajı sağlayabilir. Ancak doğru değerlendirme yapılmazsa beklenmedik masraflarla karşılaşılabilir.</p><h3>Kontrol Edilmesi Gereken Başlıca Noktalar</h3><ul><li><strong>Cihaz yaşı ve çalışma saati:</strong> Çoğu CBCT cihazı 10-15 yıl ömre sahiptir.</li><li><strong>Bakım geçmişi belgeleri:</strong> Yetkili servis kayıtlarını mutlaka isteyin.</li><li><strong>Yazılım uyumluluğu:</strong> Cihazın güncel işletim sistemleriyle uyumlu olup olmadığını kontrol edin.</li><li><strong>X-ray tüpü durumu:</strong> Tüp değişimi en büyük masraf kalemidir.</li><li><strong>Detektor durumu:</strong> FPD veya CMOS detektör arızaları pahalı onarım gerektirir.</li><li><strong>Marka yetkili servis erişimi:</strong> Türkiye\'de yetkili servis olup olmadığını araştırın.</li></ul><h2>TomografiMarket İkinci El Güvencesi</h2><p>Platformumuzdaki ikinci el ilanları uzman ekibimiz tarafından incelenmektedir. Satın almadan önce teknik ekspertiz hizmeti için bizimle iletişime geçin.</p>', NULL, 'TomografiMarket', 'İkinci El', 'ikinci el cbct, ikinci el dental tomografi, kullanılmış dental cihaz, ikinci el röntgen', 'İkinci El Dental Tomografi Rehberi | TomografiMarket', 'İkinci el CBCT ve panoramik röntgen cihazı alımında dikkat edilmesi gerekenler. Uzman tavsiyeleri ve risk değerlendirmesi.', 1, '2024-12-01 10:00:00', '2026-04-02 10:21:56', '2026-04-02 10:21:56'),
(4, 'cbct-ile-implant-planlamasi', 'CBCT ile İmplant Planlaması: Neden 3D Görüntüleme Şart?', 'Modern implant diş hekimliğinde CBCT kullanımı artık altın standart haline gelmiştir. 3D tomografi ile implant planlamasının avantajlarını ve klinik önemini keşfedin.', '<h2>İmplant Planlamasında 3D Görüntülemenin Önemi</h2><p>Dental implant yerleştirme prosedürü, kemik kalitesi, miktarı ve anatomik yapıların hassas analizi gerektirir. CBCT, bu analizin en güvenilir aracıdır.</p><h3>CBCT ile İmplant Planlamasının Avantajları</h3><ul><li>Tam üç boyutlu kemik hacmi ölçümü</li><li>Sinir kanalı ve sinus sınırlarının tam tespiti</li><li>Dijital rehberli cerrahi planlama (cerrahi stent)</li><li>Komplikasyon riskinin minimize edilmesi</li><li>Hasta sunumunda görsel destek</li></ul><h2>Hangi CBCT Cihazı İmplant İçin En Uygundur?</h2><p>İmplant planlaması için küçük voksel boyutu (0.1 mm altı) ve orta-büyük FOV sunan cihazlar tercih edilmelidir. LargeV Smart3D-X, Vatech PaX-i3D ve Planmeca ProMax 3D bu kategoride öne çıkan modellerdir.</p>', NULL, 'TomografiMarket', 'Klinik Rehber', 'implant planlaması, cbct implant, 3d implant, dental implant görüntüleme', 'CBCT ile İmplant Planlaması | TomografiMarket', 'CBCT ile implant planlamasının avantajları ve önemi. İmplant için en uygun dental tomografi cihazı seçimi rehberi.', 1, '2024-12-10 10:00:00', '2026-04-02 10:21:56', '2026-04-02 10:21:56');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `origin` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_desc` varchar(400) DEFAULT NULL,
  `seo_keywords` varchar(400) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `brands`
--

INSERT INTO `brands` (`id`, `slug`, `name`, `logo`, `origin`, `description`, `seo_title`, `seo_desc`, `seo_keywords`, `sort_order`, `active`, `created_at`) VALUES
(1, 'largev', 'LargeV', 'img/largev-logo.png', 'Çin', 'LargeV, uygun fiyatlı ve yüksek performanslı 3D CBCT sistemleriyle öne çıkan Çin menşeli dental görüntüleme markasıdır. Smart3D-X ve HiRes3D modelleriyle geniş bir kullanıcı kitlesine hitap etmektedir.', 'LargeV Dental Tomografi Cihazları | TomografiMarket', 'LargeV dental tomografi cihazlarını inceleyin. Smart3D-X ve HiRes3D modelleri özellikleri, teknik detaylar ve fiyat bilgisi için bizimle iletişime geçin.', 'largev tomografi, largev cbct, largev dental, smart3d-x, hires3d', 1, 1, '2026-04-02 10:19:40'),
(2, 'hdxwill', 'HDXWILL', 'img/hdx-logo.png', 'Güney Kore', 'HDXWILL, yenilikçi dental görüntüleme teknolojileri ile sağlık profesyonellerine yüksek kaliteli ve uygun maliyetli çözümler sunar. Gelişmiş CBCT sistemleri, kullanıcı dostu arayüz ve güvenilir performansıyla öne çıkar.', 'HDXWILL Dental Tomografi Cihazları | TomografiMarket', 'HDXWILL Dentio, Dentri, EcoX dental tomografi cihazları. Teknik özellikler ve fiyat bilgisi için TomografiMarket\'i ziyaret edin.', 'hdxwill tomografi, hdxwill cbct, hdxwill dentio, hdxwill dentri, hdxwill ecox', 2, 1, '2026-04-02 10:19:40'),
(3, 'durr', 'Dürr Dental', 'img/durr-logo.png', 'Almanya', 'Dürr Dental, Almanya\'nın köklü dental ekipman üreticilerinden biridir. VistaPano ve VistaVox serileri yüksek görüntü kalitesi ve güvenilirlik ile tanınmaktadır.', 'Dürr Dental Tomografi Cihazları | TomografiMarket', 'Dürr Dental VistaPano S ve VistaVox S dental görüntüleme cihazları. Alman mühendisliğiyle üretilen kaliteli CBCT sistemleri.', 'dürr dental tomografi, durr vistapaono, durr vistavox, alman dental cihazı', 3, 1, '2026-04-02 10:19:40'),
(4, 'myray', 'MyRay', 'img/myray-logo.png', 'İtalya', 'MyRay, İtalyan mühendisliği ve tasarım anlayışıyla geliştirilen dental görüntüleme cihazları üretmektedir. X5 ve X9 modelleri kompakt yapıları ve yüksek görüntü kalitesiyle öne çıkar.', 'MyRay Dental Tomografi Cihazları | TomografiMarket', 'MyRay X5 ve X9 dental CBCT cihazları. İtalyan yapımı yüksek kaliteli dental tomografi sistemleri.', 'myray tomografi, myray x5, myray x9, italyan dental cihazı', 9, 1, '2026-04-02 10:19:40'),
(5, 'castellini', 'Castellini', 'img/castellini-logo.png', 'İtalya', 'Castellini, 150 yılı aşkın deneyimiyle İtalya\'nın en köklü dental ekipman üreticilerinden biridir. X-Radius serisi yüksek performans ve güvenilirlik sunar.', 'Castellini Dental Tomografi Cihazları | TomografiMarket', 'Castellini X-Radius Compact ve Trio Plus dental CBCT cihazları. İtalyan mühendisliğiyle üstün görüntüleme performansı.', 'castellini tomografi, castellini x-radius, castellini cbct', 5, 1, '2026-04-02 10:19:40'),
(6, 'pointnix', 'Pointnix', 'img/pointnix-logo.png', 'Güney Kore', 'Pointnix, Güney Kore merkezli yenilikçi dental görüntüleme çözümleri sunmaktadır. 200HD, 500CS ve 800C modelleriyle geniş bir ürün yelpazesi sunar.', 'Pointnix Dental Tomografi Cihazları | TomografiMarket', 'Pointnix 200HD, 500CS, 800C dental görüntüleme cihazları. Kore teknolojisiyle üretilen kaliteli CBCT sistemleri.', 'pointnix tomografi, pointnix 200hd, pointnix 500cs, pointnix 800c', 6, 1, '2026-04-02 10:19:40'),
(7, 'newtom', 'NewTom', 'img/newtom-logo.png', 'İtalya', 'NewTom, CBCT teknolojisinin öncüsü İtalyan markasıdır. Giano HR, Go 3D ve VGi EVO modelleriyle dünya genelinde tanınan yüksek kaliteli dental tomografi çözümleri sunar.', 'NewTom Dental Tomografi Cihazları | TomografiMarket', 'NewTom Giano HR, Go 3D ve VGi EVO CBCT cihazları. CBCT teknolojisinin öncüsü NewTom\'dan kaliteli dental görüntüleme.', 'newtom tomografi, newtom giano, newtom go 3d, newtom vgi, cbct öncüsü', 7, 1, '2026-04-02 10:19:40'),
(8, 'planmeca', 'Planmeca', 'img/planmeca-logo.png', 'Finlandiya', 'Planmeca, Finlandiya merkezli dünya lideri dental ekipman üreticisidir. ProMax ve VISO serileriyle hem 2D hem 3D görüntüleme alanında standart belirler.', 'Planmeca Dental Tomografi Cihazları | TomografiMarket', 'Planmeca ProMax ve VISO G dental tomografi cihazları. Finlandiya\'nın lider dental ekipman markasından kaliteli CBCT sistemleri.', 'planmeca tomografi, planmeca promax, planmeca viso, fin dental cihazı', 8, 1, '2026-04-02 10:19:40'),
(9, 'morita', 'Morita', 'img/morita-logo.png', 'Japonya', 'J. Morita, 100 yılı aşkın köklü geçmişiyle Japonya\'nın en prestijli dental ekipman markasıdır. 3D Accuitomo ve VeraView serileri yüksek hassasiyetiyle bilinir.', 'Morita Dental Tomografi Cihazları | TomografiMarket', 'Morita 3D Accuitomo 170, VeraView X800 ve VeraViewEPOCS dental görüntüleme cihazları. Japon hassasiyetiyle üretilen CBCT sistemleri.', 'morita tomografi, morita accuitomo, morita veraview, japon dental cihazı', 4, 1, '2026-04-02 10:19:40'),
(10, 'meyer', 'Meyer', 'img/meyer-logo.png', 'Çin', 'Meyer Dental,  Çin\'in güçlü dental görüntüleme markalarından biridir. 2D panoramik ve 3D CBCT sistemleriyle her büyüklükteki kliniğe uygun çözümler sunar.', 'Meyer Dental Tomografi Cihazları | TomografiMarket', 'Meyer Dental 2D panoramik ve 3D CBCT dental görüntüleme cihazları. Kore teknolojisiyle uygun fiyatlı kaliteli çözümler.', 'meyer dental tomografi, meyer cbct, meyer panoramik', 10, 1, '2026-04-02 10:19:40'),
(11, 'carestream', 'Carestream', 'img/carestream-logo.png', 'ABD', 'Carestream Dental, ABD merkezli dünya çapında tanınan dental görüntüleme markasıdır. CS 8100 ve CS 8200 3D modelleri yüksek çözünürlük ve kullanım kolaylığıyla öne çıkar.', 'Carestream Dental Tomografi Cihazları | TomografiMarket', 'Carestream CS 8100 ve CS 8200 3D dental tomografi cihazları. Amerikan teknolojisiyle yüksek kaliteli CBCT görüntüleme.', 'carestream tomografi, carestream cs 8100, carestream cs 8200, amerikan dental cihazı', 11, 1, '2026-04-02 10:19:40'),
(12, 'gendex', 'Gendex', 'img/gendex-logo.png', 'ABD', 'Gendex, uzun yıllardır dental görüntüleme sektöründe güvenilir çözümler sunan köklü bir markadır. GXDP serisi yüksek görüntü kalitesi ve kullanıcı dostu yapısıyla tercih edilmektedir.', 'Gendex Dental Tomografi Cihazları | TomografiMarket', 'Gendex GXDP-300, GXDP-700 ve GXDP-800 dental görüntüleme cihazları. Güvenilir CBCT teknolojisiyle kaliteli dental teşhis.', 'gendex tomografi, gendex gxdp, gendex cbct, gendex panoramik', 12, 1, '2026-04-02 10:19:40'),
(13, 'owandy', 'Owandy', 'img/owandy-logo.png', 'Fransa', 'Owandy Radiology, Fransa merkezli uzmanlaşmış dental radyoloji ekipman üreticisidir. IMAX serisi, Avrupa standartlarında yüksek kaliteli görüntüleme sunar.', 'Owandy Dental Tomografi Cihazları | TomografiMarket', 'Owandy IMAX 3D XPro ve IMAX Pro dental tomografi cihazları. Fransız mühendisliğiyle üretilen CBCT sistemleri.', 'owandy tomografi, owandy imax, owandy cbct, fransız dental cihazı', 13, 1, '2026-04-02 10:19:40'),
(14, 'sirona', 'Sirona', 'img/sirona-logo.jpg', 'Almanya', 'Sirona Dental (Dentsply Sirona), Almanya\'nın dünyanın en büyük dental ekipman üreticisidir. Orthophos ve AXEOS serileri yüksek kalite ve güvenilirliğin sembolüdür.', 'Sirona Dental Tomografi Cihazları | TomografiMarket', 'Sirona AXEOS ve Orthophos dental tomografi cihazları. Dentsply Sirona\'dan dünya standartlarında CBCT görüntüleme.', 'sirona tomografi, dentsply sirona, sirona orthophos, sirona axeos, alman dental', 14, 1, '2026-04-02 10:19:40'),
(15, 'vatech', 'Vatech', 'img/vatech-logo.png', 'Güney Kore', 'Vatech, Güney Kore\'nin öncü dental görüntüleme şirketlerinden biridir. PaX-i ve PaX-i3D serileri, yüksek görüntü kalitesi ve gelişmiş yazılım özellikleriyle öne çıkar.', 'Vatech Dental Tomografi Cihazları | TomografiMarket', 'Vatech PaX-i Plus, PaX-i3D Green ve Smart dental tomografi cihazları. Kore\'nin öncü dental görüntüleme markasından kaliteli CBCT.', 'vatech tomografi, vatech paxi, vatech cbct, vatech panoramik, kore dental', 15, 1, '2026-04-02 10:19:40');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contact_leads`
--

CREATE TABLE `contact_leads` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `subject` varchar(300) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `tagline` varchar(300) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `brochure` varchar(255) DEFAULT NULL,
  `badge` varchar(50) DEFAULT NULL,
  `badge_type` varchar(50) DEFAULT 'default',
  `goruntuleme` varchar(100) DEFAULT NULL,
  `fov` varchar(200) DEFAULT NULL,
  `voksel` varchar(100) DEFAULT NULL,
  `tarama_suresi` varchar(100) DEFAULT NULL,
  `voltaj` varchar(100) DEFAULT NULL,
  `akim` varchar(100) DEFAULT NULL,
  `rekonstruksiyon` varchar(100) DEFAULT NULL,
  `sensor` varchar(100) DEFAULT NULL,
  `mensei` varchar(100) DEFAULT NULL,
  `dusuk_doz` tinyint(1) DEFAULT 0,
  `panoramik` tinyint(1) DEFAULT 0,
  `sefalometrik` tinyint(1) DEFAULT 0,
  `ai_destekli` tinyint(1) DEFAULT 0,
  `kompakt` tinyint(1) DEFAULT 0,
  `hizli_tarama` tinyint(1) DEFAULT 0,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_desc` varchar(400) DEFAULT NULL,
  `seo_keywords` varchar(400) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `slug`, `brand_id`, `name`, `tagline`, `description`, `image`, `brochure`, `badge`, `badge_type`, `goruntuleme`, `fov`, `voksel`, `tarama_suresi`, `voltaj`, `akim`, `rekonstruksiyon`, `sensor`, `mensei`, `dusuk_doz`, `panoramik`, `sefalometrik`, `ai_destekli`, `kompakt`, `hizli_tarama`, `seo_title`, `seo_desc`, `seo_keywords`, `sort_order`, `active`, `created_at`) VALUES
(1, 'largev-smart3d-x', 1, 'Smart3D-X', 'Kompakt tasarım, güçlü 3D performans', 'Smart3D-X, küçük ayak izi ve büyük görüntüleme kapasitesiyle kompakt kliniklerin ideal CBCT çözümüdür.', 'img/products/largev-smart3d-x.png', 'brosurler/LargeV-Smart3D-X.pdf', 'Kompakt', 'default', '3D CBCT', '5x8 / 8x8 / 12x10', '0.05-0.25 mm', '18.5 sn', '60-100 kV', '2-10 mA', '<60 sn', 'CSL+(CMOS/TFT)', 'Çin', 1, 0, 0, 0, 1, 1, 'LargeV Smart3D-X Dental Tomografi | TomografiMarket', 'LargeV Smart3D-X CBCT cihazı özellikleri: 5x8 / 8x8 / 12x10 FOV, 0.05 mm voksel, 18.5 sn tarama. Fiyat ve teknik bilgi için bize ulaşın.', 'largev smart3d-x, smart3d x fiyat, largev cbct, kompakt dental tomografi', 1, 1, '2026-04-02 10:19:40'),
(2, 'largev-hires3d', 1, 'HiRes3D', 'Yüksek çözünürlük, detaylı 3D görüntüleme', 'HiRes3D, ismiyle müsemma yüksek çözünürlüklü CBCT görüntüleme sistemidir. Detaylı dental analiz gerektiren vakalar için ideal.', 'img/products/largev-hires3d.png', 'brosurler/LargeV-HiRes3D.pdf', 'Hi-Res', 'default', '3D CBCT', '5x5 / 8x8 / 15x10', '0.05-0.3 mm', '20 sn', '60-100 kV', '2-10 mA', '<60 sn', 'CMOS FPD', 'Çin', 1, 0, 0, 0, 0, 0, 'LargeV HiRes3D Dental Tomografi | TomografiMarket', 'LargeV HiRes3D yüksek çözünürlüklü CBCT cihazı. 0.05 mm voksel boyutu ile üstün görüntü kalitesi.', 'largev hires3d, yüksek çözünürlüklü cbct, largev dental', 2, 1, '2026-04-02 10:19:40'),
(5, 'hdxwill-dentio', 2, 'Dentio', 'Kompakt tasarım ile güçlü görüntüleme', 'Dentio, kompakt yapısı ve gelişmiş görüntüleme teknolojisiyle küçük-orta kliniklerin tercihi.', 'img/products/hdxwill-dentio.png', 'brosurler/HDXWILL-Dentio-v1-01.pdf', 'Yeni', 'new', '3D CBCT', '5x5 / 8x8', '0.09-0.3 mm', '4.2-8.2 sn', '60-90 kV', '4-10 mA', '<60 sn', 'TFT/CMOS', 'Güney Kore', 1, 0, 0, 0, 1, 1, 'HDXWILL Dentio Dental Tomografi | TomografiMarket', 'HDXWILL Dentio CBCT cihazı: 4.2-8.2 sn tarama, TFT/CMOS sensör. Kompakt dental tomografi fiyatı için iletişime geçin.', 'hdxwill dentio, dentio cbct fiyat, hdxwill kompakt tomografi', 1, 1, '2026-04-02 10:21:56'),
(6, 'hdxwill-dentri', 2, 'Dentri', 'Geniş FOV ve üstün performans', 'Dentri, geniş FOV seçenekleri ve yüksek görüntü kalitesiyle profesyonel kliniklerin güçlü CBCT çözümü.', 'img/products/hdxwill-dentri.png', 'brosurler/HDXWILL-Dentri-v1-01.pdf', 'Popüler', 'default', '3D CBCT', '16x14.5', '0.1-0.3 mm', '8-36 sn', '60-110 kV', '4-10 mA', '<90 sn', 'TFT/CMOS', 'Güney Kore', 1, 1, 1, 0, 0, 0, 'HDXWILL Dentri Dental Tomografi | TomografiMarket', 'HDXWILL Dentri CBCT cihazı: 16x14.5 cm FOV, panoramik, sefalometrik özellikli. Teknik detaylar ve fiyat bilgisi.', 'hdxwill dentri, dentri cbct, hdxwill panoramik tomografi', 2, 1, '2026-04-02 10:21:56'),
(7, 'hdxwill-ecox', 2, 'EcoX', 'Ekonomik fiyat, güvenilir performans', 'EcoX, ekonomik fiyatı ve güvenilir performansıyla yeni açılan klinikler için ideal giriş seviyesi CBCT.', 'img/products/hdxwill-ecox.png', 'brosurler/HDXWILL-Eco-x-v1-01.pdf', 'Eco', 'eco', '3D CBCT', '8x8 / 11x8', '0.1-0.3 mm', '8-24 sn', '60-110 kV', '4-10 mA', '<90 sn', 'TFT/CMOS', 'Güney Kore', 1, 0, 0, 0, 0, 0, 'HDXWILL EcoX Dental Tomografi | TomografiMarket', 'HDXWILL EcoX ekonomik CBCT cihazı. Yeni klinikler için uygun fiyatlı dental tomografi çözümü.', 'hdxwill ecox, ucuz cbct, ekonomik dental tomografi, giriş seviyesi cbct', 3, 1, '2026-04-02 10:21:56'),
(8, 'durr-vistapano-s', 3, 'VistaPano S', 'Alman mühendisliği ile panoramik görüntüleme', 'VistaPano S, Alman mühendisliği ve hassasiyetiyle yüksek kaliteli 2D panoramik görüntüleme sunar.', 'img/products/durr-vistapano-s.png', 'brosurler/Durr-VistaPano-S.pdf', '2D', 'default', '2D Panoramik', '—', '—', '5.9-16 sn', '60-90 kV', '2-16 mA', '—', 'CCD', 'Almanya', 0, 1, 1, 0, 0, 1, 'Dürr VistaPano S Panoramik Röntgen | TomografiMarket', 'Dürr Dental VistaPano S panoramik röntgen cihazı. Alman kalitesiyle yüksek çözünürlüklü 2D dental görüntüleme.', 'durr vistapano s, panoramik röntgen, alman dental röntgen, 2d dental görüntüleme', 1, 1, '2026-04-02 10:21:56'),
(9, 'durr-vistavox-s', 3, 'VistaVox S', '3D CBCT ve panoramik bir arada', 'VistaVox S, panoramik ve 3D CBCT görüntülemeyi tek sistemde birleştiren gelişmiş Alman cihazıdır.', 'img/products/durr-vistavox-s.png', 'brosurler/Durr-VistaVox-S.pdf', '3D+Pan', 'new', '3D CBCT + Panoramik', '8x8 / 11x8', '0.1-0.3 mm', '14-26 sn', '60-90 kV', '3-16 mA', '<90 sn', 'CMOS', 'Almanya', 1, 1, 1, 0, 0, 0, 'Dürr VistaVox S CBCT + Panoramik | TomografiMarket', 'Dürr Dental VistaVox S 3D CBCT ve panoramik röntgen sistemi. Alman kalitesi ile çift fonksiyonlu dental tomografi.', 'durr vistavox s, cbct panoramik kombi, durr 3d tomografi', 2, 1, '2026-04-02 10:21:56'),
(10, 'myray-x5', 4, 'X5', 'Kompakt İtalyan CBCT sistemi', 'MyRay X5, kompakt yapısı ve İtalyan tasarım anlayışıyla küçük klinikler için ideal 3D CBCT çözümüdür.', 'img/products/myray-x5.jpg', 'brosurler/MyRay-X5.pdf', 'Kompakt', 'default', '3D CBCT', '5x5 / 8x8', '0.075-0.3 mm', '18 sn', '60-90 kV', '2-10 mA', '<60 sn', 'CMOS', 'İtalya', 1, 0, 0, 0, 1, 0, 'MyRay X5 Dental Tomografi | TomografiMarket', 'MyRay X5 kompakt CBCT cihazı. İtalyan yapımı dental tomografi teknik özellikleri ve fiyat bilgisi.', 'myray x5, myray kompakt cbct, italyan dental tomografi', 1, 1, '2026-04-02 10:21:56'),
(11, 'myray-x9', 4, 'X9', 'Gelişmiş görüntüleme ve geniş FOV', 'MyRay X9, geniş FOV seçenekleri ve gelişmiş görüntüleme özellikleriyle kapsamlı dental analiz imkânı sunar.', 'img/products/myray-x9.jpg', 'brosurler/MyRay-X9.pdf', 'Pro', 'default', '3D CBCT', '5x5 / 8x8 / 15x10', '0.075-0.3 mm', '18-26 sn', '60-90 kV', '2-10 mA', '<90 sn', 'CMOS', 'İtalya', 1, 1, 1, 0, 0, 0, 'MyRay X9 Dental Tomografi | TomografiMarket', 'MyRay X9 profesyonel CBCT cihazı. Panoramik ve sefalometrik özellikli gelişmiş dental görüntüleme.', 'myray x9, myray pro cbct, myray panoramik sefalometrik', 2, 1, '2026-04-02 10:21:56'),
(12, 'carestream-cs-8100', 11, 'CS 8100', 'Hızlı ve güvenilir panoramik görüntüleme', 'CS 8100, yüksek görüntü kalitesi ve hızlı tarama süresiyle modern kliniklerin panoramik ihtiyacına yanıt verir.', 'img/products/carestream-cs8100-3d.jpg', 'brosurler/Carestream-CS-8100.pdf', '2D', 'default', '2D Panoramik', '—', '—', '7.4-17.4 sn', '64-84 kV', '2-10 mA', '—', 'CCD', 'ABD', 0, 1, 0, 0, 0, 1, 'Carestream CS 8100 Panoramik | TomografiMarket', 'Carestream CS 8100 panoramik röntgen cihazı. Amerikan teknolojisiyle yüksek kaliteli 2D dental görüntüleme.', 'carestream cs 8100, carestream panoramik, 2d dental röntgen', 1, 1, '2026-04-02 10:21:56'),
(13, 'carestream-cs-8200-3d', 11, 'CS 8200 3D', '3D CBCT ve 2D tek sistemde', 'CS 8200 3D, panoramik ve 3D CBCT görüntülemeyi tek platformda birleştiren gelişmiş Carestream sistemidir.', 'img/products/carestream-cs8200-3d.jpg', 'brosurler/Carestream-CS-8200-3D.pdf', '3D', 'new', '3D CBCT + Panoramik', '8x8 / 8x10', '0.09-0.3 mm', '7.4-17.4 sn', '60-90 kV', '2-10 mA', '<90 sn', 'CMOS', 'ABD', 1, 1, 0, 0, 0, 0, 'Carestream CS 8200 3D CBCT | TomografiMarket', 'Carestream CS 8200 3D panoramik + CBCT dental görüntüleme cihazı. Teknik detaylar için iletişime geçin.', 'carestream cs 8200, carestream 3d cbct, carestream panoramik tomografi', 2, 1, '2026-04-02 10:21:56'),
(14, 'vatech-paxi-plus', 15, 'PaX-i Plus', 'Akıllı panoramik görüntüleme', 'PaX-i Plus, gelişmiş AI destekli özellikleri ve yüksek görüntü kalitesiyle modern kliniklerin tercihi.', 'img/products/vatech-paxi-plus.jpg', 'brosurler/Vatech-PaX-i-Plus.pdf', 'AI', 'default', '2D Panoramik', '—', '—', '5.9-14.1 sn', '60-90 kV', '2-12 mA', '—', 'CMOS', 'Güney Kore', 0, 1, 1, 1, 0, 1, 'Vatech PaX-i Plus Panoramik | TomografiMarket', 'Vatech PaX-i Plus AI destekli panoramik röntgen cihazı. Kore teknolojisiyle akıllı dental görüntüleme.', 'vatech paxi plus, vatech ai panoramik, kore dental röntgen', 1, 1, '2026-04-02 10:21:56'),
(15, 'vatech-paxi3d-green', 15, 'PaX-i3D Green', 'Çevreci tasarım, üstün 3D performans', 'PaX-i3D Green, çevre dostu tasarımı ve düşük doz teknolojisiyle öne çıkan 3D CBCT sistemidir.', 'img/products/vatech-paxi3d-green.jpg', 'brosurler/Vatech-PaX-i3D-Green.pdf', 'Eco', 'eco', '3D CBCT', '5x5 / 8x8 / 12x9', '0.08-0.3 mm', '15-24 sn', '60-90 kV', '2-12 mA', '<90 sn', 'CMOS FPD', 'Güney Kore', 1, 1, 0, 1, 0, 0, 'Vatech PaX-i3D Green CBCT | TomografiMarket', 'Vatech PaX-i3D Green 3D CBCT cihazı. Düşük dozlu çevre dostu dental tomografi sistemi.', 'vatech paxi3d green, vatech 3d cbct, vatech düşük doz tomografi', 2, 1, '2026-04-02 10:21:56'),
(16, 'vatech-paxi3d-smart', 15, 'PaX-i3D Smart', 'Akıllı teknoloji ile üstün görüntüleme', 'PaX-i3D Smart, yapay zeka destekli görüntü işleme ve geniş FOV seçenekleriyle gelişmiş klinik ihtiyaçlarına cevap verir.', 'img/products/vatech-paxi3d-smart.jpg', 'brosurler/Vatech-PaX-i3D-Smart.pdf', 'AI', 'new', '3D CBCT', '5x5 / 8x8 / 15x10', '0.08-0.3 mm', '15-24 sn', '60-90 kV', '2-12 mA', '<90 sn', 'CMOS FPD', 'Güney Kore', 1, 1, 1, 1, 0, 0, 'Vatech PaX-i3D Smart CBCT | TomografiMarket', 'Vatech PaX-i3D Smart AI destekli 3D CBCT cihazı. Yapay zeka ile güçlendirilmiş dental tomografi.', 'vatech paxi3d smart, vatech ai cbct, akıllı dental tomografi', 3, 1, '2026-04-02 10:21:56'),
(17, 'planmeca-promax-2d', 8, 'ProMax 2D', 'Finlandiya kalitesi 2D panoramik', 'Planmeca ProMax 2D, fin mühendisliği ve yüksek görüntü kalitesiyle dünyada en çok kullanılan panoramik sistemlerden biridir.', 'img/products/planmeca-promax3d.jpg', 'brosurler/Planmeca-ProMax-2D.pdf', '2D', 'default', '2D Panoramik', '—', '—', '5.4-17.6 sn', '54-90 kV', '1-16 mA', '—', 'CMOS', 'Finlandiya', 0, 1, 1, 0, 0, 1, 'Planmeca ProMax 2D Panoramik | TomografiMarket', 'Planmeca ProMax 2D panoramik röntgen cihazı. Fin kalitesiyle yüksek çözünürlüklü dental görüntüleme.', 'planmeca promax 2d, planmeca panoramik, fin dental röntgen', 1, 1, '2026-04-02 10:21:56'),
(18, 'planmeca-promax-3d', 8, 'ProMax 3D', 'Dünya standardında 3D CBCT', 'ProMax 3D, modüler yapısı ve geniş FOV yelpazesiyle hem küçük hem büyük kliniklerin ihtiyaçlarına cevap verir.', 'img/products/planmeca-promax3d.jpg', 'brosurler/Planmeca-ProMax-3D.pdf', 'Pro', 'default', '3D CBCT', '4x5 / 8x8 / 23x26', '0.05-0.6 mm', '12-26 sn', '54-90 kV', '1-16 mA', '<100 sn', 'CMOS', 'Finlandiya', 1, 1, 1, 0, 0, 0, 'Planmeca ProMax 3D CBCT | TomografiMarket', 'Planmeca ProMax 3D dental CBCT cihazı. Dünyanın en büyük FOV aralığına sahip modüler tomografi sistemi.', 'planmeca promax 3d, planmeca cbct, planmeca tomografi fiyat', 2, 1, '2026-04-02 10:21:56'),
(19, 'planmeca-viso-g', 8, 'VISO G', 'Yeni nesil AI entegrasyonu', 'VISO G, yapay zeka destekli görüntü analizi ve gelişmiş hasta konumlandırma sistemiyle Planmeca\'nın amiral gemisi CBCT\'sidir.', 'img/products/planmeca-visog5.jpg', 'brosurler/Planmeca-VISO-G.pdf', 'AI', 'new', '3D CBCT', '6x6 / 13x9 / 23x26', '0.05-0.4 mm', '12-26 sn', '54-90 kV', '1-16 mA', '<100 sn', 'CMOS FPD', 'Finlandiya', 1, 1, 1, 1, 0, 0, 'Planmeca VISO G CBCT | TomografiMarket', 'Planmeca VISO G AI destekli 3D CBCT cihazı. Yeni nesil dental tomografi teknolojisi.', 'planmeca viso g, planmeca ai cbct, planmeca yeni nesil tomografi', 3, 1, '2026-04-02 10:21:56'),
(20, 'sirona-orthophos-2d', 14, 'Orthophos E', 'Güvenilir Alman panoramik', 'Orthophos E, sektörde güvenilirliğiyle tanınan Sirona\'nın 2D panoramik çözümüdür.', 'img/products/sirona-orthophos-2d.png', 'brosurler/Sirona-Orthophos-E.pdf', '2D', 'default', '2D Panoramik', '—', '—', '14.1 sn', '60-90 kV', '2-16 mA', '—', 'CMOS', 'Almanya', 0, 1, 1, 0, 0, 0, 'Sirona Orthophos E Panoramik | TomografiMarket', 'Sirona Orthophos E panoramik röntgen cihazı. Dentsply Sirona Alman kalitesiyle dental görüntüleme.', 'sirona orthophos, dentsply sirona panoramik, alman dental röntgen', 1, 1, '2026-04-02 10:21:56'),
(21, 'sirona-axeos', 14, 'AXEOS', 'Tam entegre CBCT çözümü', 'AXEOS, modüler yapısı ve Sirona\'nın 100 yıllık tecrübesiyle geliştirilmiş tam entegre 3D CBCT sistemidir.', 'img/products/sirona-axeos.png', 'brosurler/Sirona-AXEOS.pdf', 'Pro', 'default', '3D CBCT', '8x8 / 11x8 / 15x10', '0.1-0.3 mm', '14.1 sn', '60-90 kV', '2-16 mA', '<90 sn', 'CMOS', 'Almanya', 1, 1, 1, 0, 0, 0, 'Sirona AXEOS CBCT | TomografiMarket', 'Sirona AXEOS 3D CBCT dental tomografi cihazı. Dentsply Sirona Alman kalitesiyle üstün görüntüleme.', 'sirona axeos, dentsply sirona cbct, sirona 3d tomografi', 2, 1, '2026-04-02 10:21:56'),
(22, 'sirona-orthophos-3d', 14, 'Orthophos SL 3D', 'Saf CBCT performansı', 'Orthophos SL 3D, özel SmartScan teknolojisiyle gereksiz doz almadan ihtiyaç duyulan alanı görüntüler.', 'img/products/sirona-orthophos-3d.jpeg', 'brosurler/Sirona-Orthophos-SL-3D.pdf', 'Smart', 'new', '3D CBCT', '5x5 / 8x8 / 11x8', '0.08-0.3 mm', '5.5-17.5 sn', '60-90 kV', '2-16 mA', '<90 sn', 'CMOS', 'Almanya', 1, 1, 1, 0, 0, 1, 'Sirona Orthophos SL 3D CBCT | TomografiMarket', 'Sirona Orthophos SL 3D SmartScan teknolojili CBCT. Düşük doz, yüksek kalite dental tomografi.', 'sirona orthophos sl, sirona 3d cbct, smartscan dental tomografi', 3, 1, '2026-04-02 10:21:56'),
(23, 'morita-veraviewepocs-2d', 9, 'VeraViewEPOCS 2D', 'Japon hassasiyeti 2D görüntüleme', 'VeraViewEPOCS 2D, Japon hassasiyeti ve üstün optik tasarımıyla çarpıcı netlikte panoramik görüntüler sunar.', 'img/products/morita-veraviewepocs-2dcp.png', 'brosurler/Morita-VeraViewEPOCS-2D.pdf', '2D', 'default', '2D Panoramik', '—', '—', '10-17 sn', '60-90 kV', '2-10 mA', '—', 'CMOS', 'Japonya', 0, 1, 1, 0, 0, 0, 'Morita VeraViewEPOCS 2D | TomografiMarket', 'Morita VeraViewEPOCS 2D panoramik röntgen cihazı. Japon hassasiyetiyle net dental görüntüleme.', 'morita veraview, morita panoramik, japon dental röntgen', 1, 1, '2026-04-02 10:21:56'),
(24, 'morita-veraview-x800', 9, 'VeraView X800', 'Kapsamlı multi-modal görüntüleme', 'VeraView X800, 2D panoramik, 3D CBCT ve sefalometriyi tek sistemde birleştiren Morita\'nın amiral gemisidir.', 'img/products/Morita_Veraview_X800.jpg', 'brosurler/Morita-VeraView-X800.pdf', 'Multi', 'new', '3D CBCT + Panoramik', '4x4 / 8x8 / 17x12', '0.08-0.25 mm', '17.5 sn', '60-90 kV', '2-10 mA', '<90 sn', 'CMOS FPD', 'Japonya', 1, 1, 1, 1, 0, 0, 'Morita VeraView X800 CBCT | TomografiMarket', 'Morita VeraView X800 multi-modal CBCT sistemi. 2D panoramik ve 3D görüntüleme bir arada.', 'morita veraview x800, morita 3d cbct, morita multi modal tomografi', 2, 1, '2026-04-02 10:21:56'),
(25, 'morita-veraviewepocs-3d-r100', 9, 'VeraViewEPOCS 3D R100', 'Küresel sensörlü 3D CBCT', 'VeraViewEPOCS 3D R100, yuvarlak FOV seçeneği ve yüksek çözünürlüğüyle özellikle implant planlamasında üstün performans sunar.', 'img/products/Morita_Veraviewepocs_3D_R100.jpg', 'brosurler/Morita-VeraViewEPOCS-3D.pdf', '3D', 'default', '3D CBCT', 'R40 / R60 / R80 / R100', '0.08-0.25 mm', '17.5 sn', '60-90 kV', '2-10 mA', '<90 sn', 'CMOS FPD', 'Japonya', 1, 1, 0, 0, 0, 0, 'Morita VeraViewEPOCS 3D R100 | TomografiMarket', 'Morita VeraViewEPOCS 3D R100 CBCT cihazı. Küresel FOV ile implant planlamasına özel dental tomografi.', 'morita veraview 3d, morita r100, implant planlama cbct', 3, 1, '2026-04-02 10:21:56'),
(26, 'morita-3d-accuitomo-170', 9, '3D Accuitomo 170', 'Ultra yüksek çözünürlük', '3D Accuitomo 170, 0.04 mm\'ye kadar voksel boyutuyla piyasanın en yüksek çözünürlüklü CBCT sistemlerinden biridir.', 'img/products/Morita_3D_Accuitomo_170.jpg', 'brosurler/Morita-3D-Accuitomo-170.pdf', 'Hi-Res', 'new', '3D CBCT', 'ø4x4 ~ ø17x12', '0.04-0.25 mm', '17.5 sn', '60-90 kV', '1-8 mA', '<90 sn', 'CMOS FPD', 'Japonya', 1, 0, 0, 0, 0, 0, 'Morita 3D Accuitomo 170 | TomografiMarket', 'Morita 3D Accuitomo 170 ultra yüksek çözünürlüklü CBCT. 0.04 mm voksel ile endodontiye özel dental tomografi.', 'morita accuitomo 170, ultra cbct, yüksek çözünürlük tomografi, endodonti cbct', 4, 1, '2026-04-02 10:21:56'),
(27, 'newtom-giano-hr', 7, 'Giano HR', 'CBCT öncüsünden yüksek çözünürlük', 'Giano HR, CBCT teknolojisinin mucidi NewTom\'un yüksek çözünürlüklü flagman cihazıdır. Geniş hasta tüpüyle konforlu tarama sağlar.', 'img/products/newtom-gianohr.jpg', 'brosurler/NewTom-Giano-HR.pdf', 'Hi-Res', 'default', '3D CBCT', '8x8 / 13x9 / 17x13', '0.075-0.3 mm', '18 sn', '60-110 kV', '0.5-20 mA', '<90 sn', 'FPD CMOS', 'İtalya', 1, 1, 1, 0, 0, 0, 'NewTom Giano HR CBCT | TomografiMarket', 'NewTom Giano HR yüksek çözünürlüklü CBCT cihazı. CBCT öncüsü İtalyan marka.', 'newtom giano hr, newtom cbct, newtom tomografi fiyat', 1, 1, '2026-04-02 10:21:56'),
(28, 'newtom-go-3d', 7, 'Go 3D', 'Kompakt 3D CBCT çözümü', 'Go 3D, küçük boyutu ve uygun fiyatıyla NewTom\'un kompakt CBCT çözümüdür. Sınırlı alanlarda ideal.', 'img/products/newtom-go3d.png', 'brosurler/NewTom-Go-3D.pdf', 'Kompakt', 'default', '3D CBCT', '5x5 / 8x8', '0.075-0.3 mm', '18 sn', '60-110 kV', '0.5-20 mA', '<90 sn', 'FPD CMOS', 'İtalya', 1, 0, 0, 0, 1, 0, 'NewTom Go 3D CBCT | TomografiMarket', 'NewTom Go 3D kompakt CBCT cihazı. Küçük klinikler için uygun fiyatlı İtalyan dental tomografi.', 'newtom go 3d, newtom kompakt cbct, küçük klinik tomografi', 2, 1, '2026-04-02 10:21:56'),
(29, 'newtom-vgi-evo', 7, 'VGi EVO', 'Büyük hacimli full-body CBCT', 'VGi EVO, devasa gövde boyutunu tarayabilen, maksillofasiyal ve ENT vakalara da uygun full-volume CBCT sistemidir.', 'img/products/newtom-vgievo.png', 'brosurler/NewTom-VGi-EVO.pdf', 'Full Vol', 'new', '3D CBCT', '8x8 / 15x12 / 20x19', '0.1-0.4 mm', '18-36 sn', '60-110 kV', '0.5-20 mA', '<120 sn', 'FPD CMOS', 'İtalya', 1, 1, 1, 0, 0, 0, 'NewTom VGi EVO CBCT | TomografiMarket', 'NewTom VGi EVO full-volume CBCT cihazı. Geniş hacimli ENT ve maksillofasiyal görüntüleme.', 'newtom vgi evo, full volume cbct, ent cbct, maksilofasiyal tomografi', 3, 1, '2026-04-02 10:21:56'),
(30, 'owandy-imax-3d-xpro', 13, 'IMAX 3D XPro', 'Fransız teknolojisi ile yüksek performans', 'IMAX 3D XPro, Fransız mühendisliği ve gelişmiş görüntü işleme algoritmasıyla profesyonel kliniklerin CBCT ihtiyacını karşılar.', 'img/products/owandy_i-max-3d-xpro.png', 'brosurler/Owandy-IMAX-3D-XPro.pdf', 'Pro', 'default', '3D CBCT', '5x5 / 8x8 / 13x9', '0.08-0.3 mm', '16-26 sn', '60-90 kV', '2-12 mA', '<90 sn', 'CMOS FPD', 'Fransa', 1, 1, 1, 0, 0, 0, 'Owandy IMAX 3D XPro CBCT | TomografiMarket', 'Owandy IMAX 3D XPro CBCT cihazı. Fransız teknolojisiyle profesyonel dental görüntüleme.', 'owandy imax 3d xpro, owandy cbct, fransız dental tomografi', 1, 1, '2026-04-02 10:21:56'),
(31, 'owandy-imax-pro', 13, 'IMAX Pro', 'Kompakt panoramik+CBCT', 'IMAX Pro, küçük boyutu ve yüksek görüntü kalitesiyle hem panoramik hem 3D CBCT imkânı sunar.', 'img/products/owandy_i-max-pro.png', 'brosurler/Owandy-IMAX-Pro.pdf', 'Kompakt', 'default', '3D CBCT + Panoramik', '5x5 / 8x8', '0.1-0.3 mm', '16 sn', '60-90 kV', '2-12 mA', '<90 sn', 'CMOS', 'Fransa', 1, 1, 0, 0, 1, 0, 'Owandy IMAX Pro CBCT | TomografiMarket', 'Owandy IMAX Pro kompakt CBCT + panoramik cihazı. Fransız kalitesiyle çift fonksiyonlu dental görüntüleme.', 'owandy imax pro, owandy kompakt cbct, owandy panoramik tomografi', 2, 1, '2026-04-02 10:21:56'),
(32, 'meyer-2d-dental-panoramic', 10, '2D Panoramik', 'Uygun fiyatlı panoramik çözüm', 'Meyer 2D Dental Panoramik, güçlü sensör teknolojisi ve kullanıcı dostu arayüzüyle her klinik için uygun fiyatlı panoramik çözüm sunar.', 'img/products/meyer-cbct-2d-pro.png', 'brosurler/Meyer-2D-Panoramic.pdf', '2D', 'default', '2D Panoramik', '—', '—', '9-14 sn', '60-90 kV', '2-12 mA', '—', 'CMOS', 'Çin', 0, 1, 1, 0, 0, 0, 'Meyer 2D Panoramik Röntgen | TomografiMarket', 'Meyer 2D panoramik dental röntgen cihazı. Uygun fiyatlı Kore yapımı dental görüntüleme sistemi.', 'meyer panoramik, meyer 2d röntgen, kore panoramik dental', 1, 1, '2026-04-02 10:21:56'),
(33, 'meyer-dental-cbct', 10, 'Dental CBCT', '3D CBCT güçlü fiyat avantajıyla', 'Meyer Dental CBCT, uygun fiyatı ve güvenilir performansıyla bütçe dostu kliniklere 3D görüntüleme imkânı sunar.', 'img/products/meyer-cbct-3d-pro.png', 'brosurler/Meyer-Dental-CBCT.pdf', '3D', 'default', '3D CBCT', '8x8 / 12x9', '0.1-0.3 mm', '14-26 sn', '60-90 kV', '2-12 mA', '<90 sn', 'CMOS', 'Çin', 1, 1, 0, 0, 0, 0, 'Meyer Dental CBCT Tomografi | TomografiMarket', 'Meyer Dental CBCT cihazı. Uygun fiyatlı Kore yapımı 3D dental tomografi sistemi.', 'meyer cbct, meyer 3d tomografi, uygun fiyat cbct, kore dental tomografi', 2, 1, '2026-04-02 10:21:56'),
(34, 'castellini-x-radius-compact', 5, 'X-Radius Compact', 'Kompakt İtalyan CBCT', 'X-Radius Compact, yer tasarrufu sağlayan kompakt yapısı ve yüksek görüntü kalitesiyle küçük klinikler için biçilmiş kaftan.', 'img/products/Castellini_X-Radius-Compact.png', 'brosurler/Castellini-X-Radius-Compact.pdf', 'Kompakt', 'default', '3D CBCT', '5x5 / 8x8', '0.075-0.3 mm', '18 sn', '60-90 kV', '2-10 mA', '<90 sn', 'CMOS', 'İtalya', 1, 0, 0, 0, 1, 0, 'Castellini X-Radius Compact CBCT | TomografiMarket', 'Castellini X-Radius Compact dental CBCT cihazı. Kompakt İtalyan yapımı 3D dental tomografi.', 'castellini x-radius compact, castellini cbct, kompakt italyan tomografi', 1, 1, '2026-04-02 10:21:56'),
(35, 'castellini-x-radius-trio-plus', 5, 'X-Radius Trio Plus', 'Üç fonksiyon bir arada', 'X-Radius Trio Plus, panoramik, sefalometrik ve 3D CBCT fonksiyonlarını tek platformda birleştiren Castellini\'nin amiral gemisidir.', 'img/products/Castellini_X-Radius-Trio-Plus.jpg', 'brosurler/Castellini-X-Radius-Trio-Plus.pdf', 'Trio', 'new', '3D CBCT + Pan + Sef', '5x5 / 8x8 / 15x10', '0.075-0.3 mm', '18-26 sn', '60-90 kV', '2-10 mA', '<90 sn', 'CMOS FPD', 'İtalya', 1, 1, 1, 0, 0, 0, 'Castellini X-Radius Trio Plus | TomografiMarket', 'Castellini X-Radius Trio Plus 3-in-1 CBCT, panoramik, sefalometrik cihazı. İtalyan yapımı çok fonksiyonlu dental görüntüleme.', 'castellini trio plus, 3 in 1 dental tomografi, cbct panoramik sefalometrik', 2, 1, '2026-04-02 10:21:56'),
(36, 'gendex-gxdp-300', 12, 'GXDP-300', 'Güvenilir giriş seviyesi panoramik', 'GXDP-300, güvenilirliği ve kullanım kolaylığıyla dental kliniklerin vazgeçilmez panoramik cihazıdır.', 'img/products/gendex-gxdp-300.png', 'brosurler/Gendex-GXDP-300.pdf', '2D', 'default', '2D Panoramik', '—', '—', '12-17.6 sn', '60-90 kV', '2-12 mA', '—', 'CCD', 'ABD', 0, 1, 1, 0, 0, 0, 'Gendex GXDP-300 Panoramik | TomografiMarket', 'Gendex GXDP-300 panoramik röntgen cihazı. Güvenilir ve uygun fiyatlı dental görüntüleme.', 'gendex gxdp 300, gendex panoramik, dental röntgen cihazı', 1, 1, '2026-04-02 10:21:56'),
(37, 'gendex-gxdp-700', 12, 'GXDP-700', 'Orta segment panoramik+sefalometrik', 'GXDP-700, sefalometrik ek modülüyle ortodontik vakalar için güçlü panoramik çözüm sunar.', 'img/products/gendex-gxdp-700.jpg', 'brosurler/Gendex-GXDP-700.pdf', '2D+Sef', 'default', '2D Panoramik + Sef', '—', '—', '12-17.6 sn', '60-90 kV', '2-12 mA', '—', 'CCD', 'ABD', 0, 1, 1, 0, 0, 0, 'Gendex GXDP-700 Panoramik+Sef | TomografiMarket', 'Gendex GXDP-700 panoramik + sefalometrik dental cihazı. Ortodontik vakalar için ideal görüntüleme.', 'gendex gxdp 700, gendex sefalometrik, ortodonti panoramik', 2, 1, '2026-04-02 10:21:56'),
(38, 'gendex-gxdp-800', 12, 'GXDP-800', '3D CBCT ile tam donanım', 'GXDP-800, 3D CBCT kapasitesiyle Gendex\'in en gelişmiş dental görüntüleme sistemidir.', 'img/products/gendex-gxdp-800.png', 'brosurler/Gendex-GXDP-800.pdf', '3D', 'new', '3D CBCT + Panoramik', '5x5 / 8x8 / 13x9', '0.1-0.3 mm', '12-26 sn', '60-90 kV', '2-12 mA', '<90 sn', 'CMOS', 'ABD', 1, 1, 1, 0, 0, 0, 'Gendex GXDP-800 CBCT | TomografiMarket', 'Gendex GXDP-800 3D CBCT dental tomografi cihazı. Panoramik ve CBCT bir arada güçlü görüntüleme.', 'gendex gxdp 800, gendex 3d cbct, gendex tomografi', 3, 1, '2026-04-02 10:21:56'),
(39, 'pointnix-200hd', 6, '200HD', 'Kompakt yüksek çözünürlük', 'Pointnix 200HD, yüksek çözünürlüklü sensörü ve kompakt tasarımıyla küçük klinikler için akıllı seçim.', 'img/products/pointnix-200hd.jpg', 'brosurler/Pointnix-200HD.pdf', 'Kompakt', 'default', '3D CBCT', '8x8', '0.08-0.3 mm', '18 sn', '60-90 kV', '2-10 mA', '<90 sn', 'CMOS', 'Güney Kore', 1, 0, 0, 0, 1, 0, 'Pointnix 200HD CBCT | TomografiMarket', 'Pointnix 200HD kompakt CBCT cihazı. Kore teknolojisiyle yüksek çözünürlüklü dental tomografi.', 'pointnix 200hd, pointnix cbct, kore cbct cihazı', 1, 1, '2026-04-02 10:21:56'),
(40, 'pointnix-500cs', 6, '500CS', 'Orta segment güçlü CBCT', 'Pointnix 500CS, geniş FOV ve güvenilir performansıyla orta ölçekli kliniklerin tercihi.', 'img/products/pointnix-500hd.jpg', 'brosurler/Pointnix-500CS.pdf', 'Pro', 'default', '3D CBCT + Panoramik', '8x8 / 12x9', '0.08-0.3 mm', '18-26 sn', '60-90 kV', '2-10 mA', '<90 sn', 'CMOS FPD', 'Güney Kore', 1, 1, 1, 0, 0, 0, 'Pointnix 500CS CBCT | TomografiMarket', 'Pointnix 500CS panoramik + CBCT dental görüntüleme sistemi. Kore yapımı güçlü dental tomografi.', 'pointnix 500cs, pointnix panoramik cbct, kore dental tomografi', 2, 1, '2026-04-02 10:21:56'),
(41, 'pointnix-800c', 6, '800C', 'Tam donanımlı 3D görüntüleme', 'Pointnix 800C, geniş hacimli görüntüleme kapasitesiyle gelişmiş klinik vakalara cevap veren üst segment CBCT sistemidir.', 'img/products/pointnix-800c.jpg', 'brosurler/Pointnix-800C.pdf', 'Full', 'new', '3D CBCT', '8x8 / 15x10', '0.08-0.3 mm', '18-36 sn', '60-90 kV', '2-10 mA', '<120 sn', 'FPD CMOS', 'Güney Kore', 1, 1, 1, 0, 0, 0, 'Pointnix 800C CBCT | TomografiMarket', 'Pointnix 800C full-volume CBCT cihazı. Büyük FOV ile gelişmiş dental tomografi.', 'pointnix 800c, full volume cbct, geniş fov dental tomografi', 3, 1, '2026-04-02 10:21:56');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `second_hand`
--

CREATE TABLE `second_hand` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `brand` varchar(150) DEFAULT NULL,
  `model` varchar(150) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `condition` enum('iyi','çok iyi','mükemmel') DEFAULT 'iyi',
  `description` text DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'TRY',
  `image` varchar(255) DEFAULT NULL,
  `contact_name` varchar(150) DEFAULT NULL,
  `contact_phone` varchar(50) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `site_settings`
--

CREATE TABLE `site_settings` (
  `key` varchar(100) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `site_settings`
--

INSERT INTO `site_settings` (`key`, `value`) VALUES
('admin_pass_hash', '$2y$10$ZwJ4xryVwOIasvLm3JeIV.9Bh5MRYHCfLZ8q1Z1snGToGcEdYwr9C'),
('admin_user', 'admin');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Tablo için indeksler `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Tablo için indeksler `contact_leads`
--
ALTER TABLE `contact_leads`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Tablo için indeksler `second_hand`
--
ALTER TABLE `second_hand`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Tablo için indeksler `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`key`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Tablo için AUTO_INCREMENT değeri `contact_leads`
--
ALTER TABLE `contact_leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Tablo için AUTO_INCREMENT değeri `second_hand`
--
ALTER TABLE `second_hand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
