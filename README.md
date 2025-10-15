# 🕌 Sistem Zakat - Laravel Information System

## 🎯 Overview

**Sistem Zakat** adalah sistem informasi pengelolaan zakat berbasis web yang dibangun menggunakan **Laravel 12**. Sistem ini menyediakan platform digital modern untuk pengelolaan zakat yang transparan, efisien, dan sesuai dengan ketentuan syariah Islam.

---

## 🚀 Key Features

### 📊 Dashboard & Analytics

- **Admin Dashboard**: Statistik real-time pembayaran dan distribusi zakat
- **Muzakki Dashboard**: Riwayat pembayaran dan kalkulator zakat personal
- **Interactive Charts**: Grafik pembayaran bulanan dan statistik per jenis zakat

### 👥 User Management

- **Role-based Authentication**: Admin, Staff, dan Muzakki dengan hak akses berbeda
- **Muzakki Management**: Registrasi dan pengelolaan data pembayar zakat
- **Mustahik Management**: Verifikasi dan kategorisasi penerima zakat (8 Asnaf)

### 💰 Zakat Management

- **Multi-type Zakat Support**: Zakat Mal, Fitrah, Profesi, Pertanian, Perdagangan
- **Smart Calculator**: Perhitungan otomatis berdasarkan nisab dan tarif zakat
- **Payment Processing**: Pencatatan pembayaran dengan berbagai metode
- **Receipt Generation**: Kwitansi otomatis untuk setiap pembayaran

### 🎯 Distribution System

- **8 Asnaf Categories**: Distribusi sesuai dengan 8 golongan mustahik
- **Distribution Tracking**: Monitoring penyaluran zakat kepada mustahik
- **Balance Management**: Kontrol saldo zakat secara real-time

### 📈 Reporting & Documentation

- **Comprehensive Reports**: Laporan pembayaran, distribusi, dan statistik
- **Export Features**: Ekspor data ke berbagai format
- **Audit Trail**: Pencatatan lengkap semua aktivitas dan transaksi

---

## 🛠️ Technology Stack

| Layer    | Technologies                        |
| -------- | ----------------------------------- |
| Backend  | Laravel 12.0, PHP 8.2+              |
| Frontend | Bootstrap 5, Tailwind CSS 4.0, Vite |
| Database | MySQL (configurable)                |
| Auth     | Laravel Authentication              |
| Charts   | Chart.js                            |
| Icons    | Bootstrap Icons                     |

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

git clone <repository-url>
cd SistemZakat

### 2. Install Dependencies

# Install PHP dependencies

composer install

# Install Node dependencies

npm install

### 3. Environment Configuration

cp .env.example .env
php artisan key:generate

### 4. Database Setup

Edit `.env`:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_zakat
DB_USERNAME=your_username
DB_PASSWORD=your_password

Run migration and seeders:
php artisan migrate:fresh --seed

### 5. Build Assets

npm run build

# or for development

npm run dev

### 6. Start Application

php artisan serve

# Access at http://localhost:8000

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
| `zakat_types`         | Jenis zakat beserta nisab dan tarif         |
| `muzakki`             | Data pembayar zakat                         |
| `mustahik`            | Data penerima zakat (8 asnaf)               |
| `zakat_payments`      | Transaksi pembayaran zakat                  |
| `zakat_distributions` | Distribusi zakat kepada mustahik            |

---

## 🔐 Security Features

- CSRF Protection
- SQL Injection Prevention
- XSS Protection
- Role-based Authorization
- Password Hashing (Bcrypt)
- Secure Session Management

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

| Method | Endpoint                 | Description        |
| ------ | ------------------------ | ------------------ |
| GET    | `/calculator/gold-price` | Current gold price |
| POST   | `/calculator/calculate`  | Zakat calculation  |

### Authenticated APIs

| Method | Endpoint                                  | Description          |
| ------ | ----------------------------------------- | -------------------- |
| GET    | `/dashboard/stats`                        | Dashboard statistics |
| GET    | `/api/mustahik/by-category`               | Mustahik by category |
| GET    | `/api/distributions/mustahik-by-category` | Distribution targets |

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

---

## 🔍 Testing

php artisan test
php artisan test --coverage
./vendor/bin/pint

---

## 📈 Performance Optimization

- Database indexing & eager loading
- Laravel caching
- Optimized queries
- Vite asset bundling & minification

---

## 🚀 Deployment

### Production Checklist

1. **Environment Configuration**
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain.com

2. **Security Settings**
   php artisan key:generate
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache

3. **Database Migration**
   php artisan migrate --force

4. **File Permissions**
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache

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
