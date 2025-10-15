# 🕌 Sistem Zakat - Laravel Information System

## 🎯 Overview

**Sistem Zakat** adalah sistem informasi pengelolaan zakat berbasis web yang dibangun menggunakan **Laravel 12**. Sistem ini menyediakan platform digital modern untuk pengelolaan zakat yang transparan, efisien, dan sesuai dengan ketentuan syariah Islam.

---

## 🚀 Key Features

### 📊 Dashboard & Analytics

- **Admin Dashboard**: Statistik real-time pembayaran dan distribusi zakat
- **Muzakki Dashboard**: Riwayat pembayaran dan kalkulator zakat personal
- **Interactive Charts**: Grafik pembayaran bulanan dan statistik per jenis zakat
- **Program Progress Tracking**: Monitoring progress pengumpulan dana per program

### 👥 User Management

- **Role-based Authentication**: Admin, Staff, dan Muzakki dengan hak akses berbeda
- **Muzakki Management**: Registrasi dan pengelolaan data pembayar zakat
- **Mustahik Management**: Verifikasi dan kategorisasi penerima zakat (8 Asnaf)
- **Profile Management**: Pengelolaan profil pengguna dengan integrasi Firebase

### 💰 Zakat & Donation Management

- **Multi-type Zakat Support**: Zakat Mal, Fitrah, Profesi, Pertanian, Perdagangan
- **Infaq & Shadaqah Programs**: Program infaq masjid, pendidikan, kemanusiaan, dll
- **Pilar Zakat Programs**: Program berbasis pilar zakat (pendidikan, kesehatan, ekonomi, sosial-dakwah, kemanusiaan, lingkungan)
- **Smart Calculator**: Perhitungan otomatis berdasarkan nisab dan tarif zakat
- **Payment Processing**: Pencatatan pembayaran dengan berbagai metode termasuk Midtrans
- **Guest Donations**: Sistem donasi untuk pengguna yang belum login
- **Receipt Generation**: Kwitansi otomatis untuk setiap pembayaran dengan opsi download PDF

### 📣 Campaign Management

- **Program Campaigns**: Kampanye penggalangan dana untuk program-program spesifik
- **Target Amount Tracking**: Monitoring target pengumpulan dana per kampanye
- **Progress Visualization**: Visualisasi progress kampanye dengan indikator persentase

### 🎯 Distribution System

- **8 Asnaf Categories**: Distribusi sesuai dengan 8 golongan mustahik
- **Distribution Tracking**: Monitoring penyaluran zakat kepada mustahik
- **Goods & Cash Distribution**: Dukungan untuk distribusi berupa uang maupun barang
- **Distribution Receipts**: Bukti distribusi dengan detail penerima dan lokasi

### 📈 Reporting & Documentation

- **Comprehensive Reports**: Laporan pembayaran, distribusi, dan statistik
- **Export Features**: Ekspor data ke berbagai format (PDF, Excel)
- **Audit Trail**: Pencatatan lengkap semua aktivitas dan transaksi
- **News & Articles**: Sistem publikasi berita dan artikel terkait kegiatan zakat

### 🔔 Notification System

- **Real-time Notifications**: Sistem notifikasi untuk status pembayaran dan distribusi
- **Payment Status Updates**: Pemberitahuan otomatis ketika status pembayaran berubah
- **User Dashboard Alerts**: Indikator notifikasi di dashboard pengguna

---

## 🛠️ Technology Stack

| Layer    | Technologies                        |
| -------- | ----------------------------------- |
| Backend  | Laravel 12.0, PHP 8.2+              |
| Frontend | Bootstrap 5, Tailwind CSS 4.0, Vite |
| Database | MySQL (configurable)                |
| Auth     | Laravel Authentication, Firebase    |
| Payment  | Midtrans Payment Gateway            |
| Charts   | Chart.js                            |
| Icons    | Bootstrap Icons                     |
| PDF      | DomPDF                              |

---

## 📋 System Requirements

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 5.7+ atau MariaDB
- Web server (Apache/Nginx)

---

## 🔧 Installation Guide

### 1. Clone Repository

```bash
git clone <repository-url>
cd SistemZakat
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup

Edit `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_zakat
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Run migration and seeders:

```bash
php artisan migrate:fresh --seed
```

### 5. Configure Midtrans Payment Gateway

Add Midtrans credentials to `.env`:

```
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
```

### 6. Build Assets

```bash
npm run build

# or for development
npm run dev
```

### 7. Start Application

```bash
php artisan serve

# Access at http://localhost:8000
```

---

## 👨‍💻 Default User Accounts

| Role    | Email             | Password | Access Level      |
| ------- | ----------------- | -------- | ----------------- |
| Admin   | admin@zakat.com   | password | Full access       |
| Staff   | staff1@zakat.com  | password | Management access |
| Muzakki | ahmad@example.com | password | User access       |

---

## 📚 Database Structure

| Table                 | Description                                 |
| --------------------- | ------------------------------------------- |
| `users`               | Sistem autentikasi dengan role-based access |
| `muzakki`             | Data pembayar zakat                         |
| `mustahik`            | Data penerima zakat (8 asnaf)               |
| `zakat_payments`      | Transaksi pembayaran zakat                  |
| `zakat_distributions` | Distribusi zakat kepada mustahik            |
| `programs`            | Program-program zakat, infaq, shadaqah      |
| `campaigns`           | Kampanye penggalangan dana                  |
| `program_types`       | Jenis program (zakat, infaq, shadaqah)      |
| `notifications`       | Sistem notifikasi pengguna                  |
| `news`                | Berita dan informasi terkini                |
| `artikels`            | Artikel edukasi dan informasi               |

---

## 🔐 Security Features

- CSRF Protection
- SQL Injection Prevention
- XSS Protection
- Role-based Authorization
- Password Hashing (Bcrypt)
- Secure Session Management
- Payment Gateway Integration Security

---

## 🧮 Zakat Calculation Engine

### Supported Zakat Types

| Jenis Zakat               | Nisab                         | Rate                             |
| ------------------------- | ----------------------------- | -------------------------------- |
| Zakat Mal (Emas/Perak)    | 85 gram emas / 595 gram perak | 2.5%                             |
| Zakat Mal (Uang/Tabungan) | Setara 85 gram emas           | 2.5%                             |
| Zakat Profesi             | Setara 85 gram emas per bulan | 2.5%                             |
| Zakat Fitrah              | Tetap per orang               | Sesuai ketentuan                 |
| Zakat Pertanian           | 653 kg gabah kering           | 5% (irigasi) / 10% (tadah hujan) |
| Zakat Perdagangan         | Setara 85 gram emas           | 2.5%                             |

---

## 📊 8 Asnaf Mustahik

1. **Fakir** — Tidak memiliki harta dan pekerjaan
2. **Miskin** — Memiliki pekerjaan tapi tidak mencukupi
3. **Amil** — Petugas pengelola zakat
4. **Muallaf** — Orang yang baru masuk Islam
5. **Riqab** — Memerdekakan budak/tawanan
6. **Gharim** — Orang berutang untuk kepentingan baik
7. **Fisabilillah** — Kepentingan umum di jalan Allah
8. **Ibnu Sabil** — Musafir kehabisan bekal

---

## 🔄 API Endpoints

### Public APIs

| Method | Endpoint                 | Description           |
| ------ | ------------------------ | --------------------- |
| GET    | `/calculator/gold-price` | Current gold price    |
| POST   | `/calculator/calculate`  | Zakat calculation     |
| GET    | `/program`               | List all programs     |
| GET    | `/campaigns/{category}`  | Campaigns by category |

### Authenticated APIs

| Method | Endpoint                                  | Description          |
| ------ | ----------------------------------------- | -------------------- |
| GET    | `/dashboard/stats`                        | Dashboard statistics |
| GET    | `/api/mustahik/by-category`               | Mustahik by category |
| GET    | `/api/distributions/mustahik-by-category` | Distribution targets |
| GET    | `/api/muzakki/search`                     | Search muzakki       |
| GET    | `/api/payments/search`                    | Search payments      |

---

## 📱 Mobile Responsiveness

Dibangun dengan desain _responsive_ (mobile-first) menggunakan Bootstrap 5:

- Collapsible sidebar
- Touch-friendly interface
- Optimized forms untuk input mobile
- Layout responsif di semua ukuran layar

---

## 🎨 UI/UX Features

- Modern & clean design
- Interactive elements (hover, smooth transitions)
- Color-coded categories
- Real-time feedback (loading, success/error)
- Print-friendly receipts
- Notification badges
- Program progress indicators

---

## 🔍 Testing

```bash
php artisan test
php artisan test --coverage
./vendor/bin/pint
```

---

## 📈 Performance Optimization

- Database indexing & eager loading
- Laravel caching
- Optimized queries
- Vite asset bundling & minification
- Lazy loading for images

---

## 🚀 Deployment

### Production Checklist

1. **Environment Configuration**

   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain.com
   ```

2. **Security Settings**

   ```bash
   php artisan key:generate
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Database Migration**

   ```bash
   php artisan migrate --force
   ```

4. **File Permissions**
   ```bash
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

---

## 🤝 Contributing

1. Fork repository
2. Buat branch fitur: `git checkout -b feature/AmazingFeature`
3. Commit perubahan: `git commit -m 'Add AmazingFeature'`
4. Push ke branch: `git push origin feature/AmazingFeature`
5. Buat Pull Request

---

## 📄 License

Proyek ini dilisensikan di bawah [MIT License](LICENSE) – lihat file LICENSE untuk detail.

---

## 📞 Support

Untuk bantuan atau pertanyaan:

- Buat issue di repository
- Hubungi tim pengembang
- Lihat dokumentasi wiki

---

**Built with ❤️ for the Muslim community**  
_Modern digital platform for transparent and efficient zakat management according to Islamic principles._
