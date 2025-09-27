# Sistem Zakat - Laravel Information System

## 🎯 Overview

Sistem Zakat adalah sistem informasi pengelolaan zakat berbasis web yang dibangun menggunakan Laravel 12. Sistem ini menyediakan platform digital modern untuk pengelolaan zakat yang transparan, efisien, dan sesuai dengan ketentuan syariah Islam.

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
- **Payment Processing**: Pencatatan pembayaran dengan multiple payment methods
- **Receipt Generation**: Kwitansi otomatis untuk setiap pembayaran

### 🎯 Distribution System
- **8 Asnaf Categories**: Distribusi sesuai dengan 8 golongan mustahik
- **Distribution Tracking**: Monitoring penyaluran zakat kepada mustahik
- **Balance Management**: Kontrol saldo zakat real-time

### 📈 Reporting & Documentation
- **Comprehensive Reports**: Laporan pembayaran, distribusi, dan statistik
- **Export Features**: Export data dalam berbagai format
- **Audit Trail**: Pencatatan lengkap semua transaksi

## 🛠 Technology Stack

- **Backend**: Laravel 12.0, PHP 8.2+
- **Frontend**: Bootstrap 5, Tailwind CSS 4.0, Vite
- **Database**: MySQL (configurable)
- **Authentication**: Laravel's built-in authentication
- **Charts**: Chart.js
- **Icons**: Bootstrap Icons

## 📋 System Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL 5.7+ or MariaDB
- Web server (Apache/Nginx)

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
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
```bash
# Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_zakat
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Run migrations and seeders
php artisan migrate:fresh --seed
```

### 5. Build Assets
```bash
# Build frontend assets
npm run build

# Or for development
npm run dev
```

### 6. Start Application
```bash
# Start Laravel server
php artisan serve

# Application will be available at http://localhost:8000
```

## 👨‍💻 Default User Accounts

### Admin Account
- **Email**: admin@zakat.com
- **Password**: password
- **Role**: Admin (Full access)

### Staff Account
- **Email**: staff1@zakat.com
- **Password**: password
- **Role**: Staff (Management access)

### Muzakki Account
- **Email**: ahmad@example.com
- **Password**: password
- **Role**: Muzakki (User access)

## 📚 Database Structure

### Core Tables

#### `users`
Sistem authentication dengan role-based access (admin, staff, muzakki)

#### `zakat_types`
Master data jenis-jenis zakat dengan nisab dan tarif masing-masing

#### `muzakki`
Data lengkap pembayar zakat (nama, kontak, pekerjaan, penghasilan)

#### `mustahik`
Data penerima zakat dengan kategori 8 asnaf dan status verifikasi

#### `zakat_payments`
Transaksi pembayaran zakat dengan kode unik dan kwitansi

#### `zakat_distributions`
Distribusi zakat kepada mustahik dengan tracking penerimaan

## 🔐 Security Features

- **CSRF Protection**: Semua form protected dengan CSRF token
- **SQL Injection Prevention**: Eloquent ORM dengan parameter binding
- **XSS Protection**: Input sanitization dan output escaping
- **Role-based Authorization**: Middleware untuk kontrol akses
- **Password Hashing**: Bcrypt hashing untuk password
- **Session Security**: Secure session management

## 🧮 Zakat Calculation Engine

### Supported Zakat Types

1. **Zakat Mal (Emas & Perak)**
   - Nisab: 85 gram emas atau 595 gram perak
   - Rate: 2.5%

2. **Zakat Mal (Uang & Tabungan)**
   - Nisab: Setara 85 gram emas
   - Rate: 2.5%

3. **Zakat Profesi**
   - Nisab: Setara nilai 85 gram emas per bulan
   - Rate: 2.5%

4. **Zakat Fitrah**
   - Fixed amount per person
   - Wajib di bulan Ramadan

5. **Zakat Pertanian**
   - Nisab: 653 kg gabah kering
   - Rate: 5% (irigasi) atau 10% (tadah hujan)

6. **Zakat Perdagangan**
   - Nisab: Setara 85 gram emas
   - Rate: 2.5%

## 📊 8 Asnaf Mustahik

1. **Fakir**: Tidak memiliki harta dan pekerjaan
2. **Miskin**: Memiliki harta/pekerjaan tapi tidak mencukupi
3. **Amil**: Petugas pengumpul dan pembagi zakat
4. **Muallaf**: Orang yang baru masuk Islam
5. **Riqab**: Memerdekakan budak/tawanan
6. **Gharim**: Orang berutang untuk kepentingan baik
7. **Fisabilillah**: Untuk kepentingan umum di jalan Allah
8. **Ibnu Sabil**: Musafir kehabisan bekal

## 🔄 API Endpoints

### Public APIs
- `GET /calculator/gold-price` - Current gold price
- `POST /calculator/calculate` - Zakat calculation

### Authenticated APIs
- `GET /dashboard/stats` - Dashboard statistics
- `GET /api/mustahik/by-category` - Mustahik by category
- `GET /api/distributions/mustahik-by-category` - Distribution targets

## 📱 Mobile Responsiveness

Sistem ini dibangun dengan design responsive menggunakan Bootstrap 5:
- Mobile-first approach
- Collapsible sidebar untuk mobile
- Touch-friendly interface
- Optimized forms untuk mobile input

## 🎨 UI/UX Features

- **Modern Design**: Clean dan professional interface
- **Interactive Elements**: Hover effects dan smooth transitions
- **Color-coded Categories**: Visual distinction untuk berbagai jenis data
- **Real-time Feedback**: Loading states dan success/error messages
- **Print-friendly**: Optimized untuk pencetakan kwitansi

## 🔍 Testing

```bash
# Run PHP tests
php artisan test

# Run with coverage
php artisan test --coverage

# Check code style
./vendor/bin/pint
```

## 📈 Performance Optimization

- **Database Indexing**: Optimized queries dengan proper indexing
- **Eager Loading**: Mengurangi N+1 queries
- **Caching**: Laravel caching untuk data yang sering diakses
- **Asset Optimization**: Vite untuk bundling dan minification

## 🚀 Deployment

### Production Checklist

1. **Environment Configuration**
```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

2. **Security Settings**
```bash
# Generate new app key
php artisan key:generate

# Cache configuration
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

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📞 Support

For support and questions:
- Create an issue in the repository
- Contact the development team
- Check the documentation wiki

---

**Built with ❤️ for the Muslim community**

Sistem Zakat - Modern digital platform for transparent and efficient zakat management according to Islamic principles.