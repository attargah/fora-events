# ForaEvents - Teknik Değerlendirme Ödevi

##  Proje Hakkında

ForaEvents, etkinlik oluşturma, bilet satışı ve katılımcı yönetimi gibi temel özellikleri içeren bir etkinlik yönetim sistemi.

Proje benim seçimime bırakıldığında kısa süre içerisinde geliştirebileceğim, hem public tarafta hem de management tarafında orta düzeyde ama yetkin olduğumu gösterebileceğim bir proje yapmak istedim..

Proje temel olarak bir organizatörün kendi etkinlikleri için bilet satabildiği küçük - orta boyutlu bir projedir.

Projede en çok zorlandığım kısım ön yüz oldu. Filtreleme sistemi için service yazmak, ön yüzde tasarımını yapıp optimize hale getirmekten çok daha basit oldu benim için.

Projenin en başında kurduğum Checkout - Registration - Event Ticket - Event yapısını başarılı buluyorum. Ayrıca Registration Formu, EventFilter ve Checkout Serviceleri bu projede en iyi yaptığımı düşündüğüm kısımlardır.

Business logic olarak hem projenin büyüklüğü hem de verilen süreyi göz önüne kalarak Service - Controller yapısı kullanmaya karar verdim.

### AI Kullanımı

Projenin public sayfalarının tasarımı Stitch AI tarafından hazırlanmış olup Claude AI kullanılarak kodlaştırılmıştır.
Arka Yüzde ise sadece uzun kod bloklarını tek seferde yazdırmak gibi angarya işleri kolaylaştırmak için kullanılmıştır.


### Temel Özellikler

- **Etkinlik Yönetimi**: Etkinlik oluşturma, düzenleme ve kategorilendirme
- **Bilet Sistemi**: Farklı bilet türleri ve fiyatlandırma seçenekleri
- **Kayıt Sistemi**: Katılımcı kayıtları ve takibi
- **Admin Paneli**: Filament ile güçlendirilmiş modern yönetim arayüzü
- **Dashboard Widgets**: Etkinlik istatistikleri ve özet bilgiler
- **Formlar**: İletişim ve Mail Bülten Formları
- **Mail**: Müşteriye ve Yöneticiye bilgilendirme mailleri
- **Cache Yönetimi**: Performans için Redis/Database cache desteği
- **Queue**: Mail ve Eventlerin daha verimli çalışması için Queue desteği


##  Teknoloji Stack

- **Backend**: Laravel 12.x (PHP 8.2+)
- **Admin Panel**: Filament 5.0
- **Frontend**: AlpineJs + TailwindCSS 4.0
- **Database**: MySQL
- **Cache**: Redis/Database
- **Queue**: Database Queue

##  Kurulum

### Gereksinimler

- PHP 8.2 veya üzeri
- Composer
- Node.js & NPM
- MySQL
- Redis 

### Adım Adım Kurulum

1. **Projeyi klonlayın**
```bash
git clone https://github.com/attargah/fora-events.git
cd fora-events
```

2. **Veritabanı ayarlarını yapılandırın**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=foraevents
DB_USERNAME=root
DB_PASSWORD=your_password
```

3. **Bağımlılıkları yükleyin ve projeyi ayarlayın**
```bash
composer setup 
```



4. **Seederları çalıştırın**
```bash
php artisan db:seed
```

##  Kullanım

### Development Ortamında Çalıştırma

Tek komutla tüm servisleri başlatın:
```bash
composer dev
```

### Manuel Çalıştırma

Eğer servisleri ayrı ayrı çalıştırmak isterseniz:

```bash
php artisan serve

php artisan queue:listen  

npm run dev
```

### Admin Paneline Erişim

Tarayıcınızda `http://localhost:8000/admin` adresine gidin ve oluşturduğunuz admin kullanıcısı ile giriş yapın.

Eğer seeder dosyasını çalıştırdıysanız aşağıdaki Admin Kullanıcısı otomatik oluşacaktır.
```bash
Eposta Adresi = admin@admin.com
Şifre = Admin1234
```

