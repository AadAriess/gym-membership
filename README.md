# Gym Membership & Billing System (Technical Test)

Sistem internal berbasis web untuk jaringan gym yang sedang berkembang. Aplikasi ini dirancang menggunakan **Laravel** untuk mengelola data member, otomatisasi pembuatan invoice bulanan, verifikasi pembayaran manual oleh Admin, serta manajemen penangguhan (_suspension_) akses member yang terlambat membayar.

## Fitur Utama

1. **Authentication & Role Management (RBAC):** Login staff internal menggunakan Laravel Gate. Akun **Admin** memiliki akses penuh (CRUD, Billing Engine, & Pembayaran), sedangkan **Staff Biasa** hanya memiliki akses baca (_read-only_).
2. **Membership Management:** Manajemen paket langganan (Basic, Premium, VIP) beserta nominal harga iuran.
3. **Member Management:** Pengelolaan data member (Status, Paket Langganan, Tanggal Join).
4. **Idempotent Billing Engine (Artisan Command):** Mekanisme _generate_ invoice bulanan otomatis dengan rumus `Harga Paket + Tax 11% = Total Tagihan`. Sistem ini dilengkapi dengan _Idempotency Guard_ sehingga **aman dijalankan berkali-kali pada bulan yang sama tanpa risiko duplikasi data**.
5. **Auto-Suspension System:** Deteksi otomatis dan suspensi massal (_Massive Suspend_) bagi member yang menunggak pembayaran lebih dari 3 hari (_due date_).
6. **Audit Trail & Member Detail:** Visibilitas rekam jejak finansial per member (total durasi bulan lunas, nominal iuran masuk, dan riwayat transaksi).

---

## Spesifikasi Teknis & Stack

- **Framework:** Laravel 13
- **Language:** PHP 8.2+
- **Database:** MySQL
- **Frontend UI:** Bootstrap 5 (via CDN - Zero Configuration)

---

## Langkah-Langkah Menjalankan Project

Ikuti instruksi berikut untuk menjalankan proyek di lingkungan lokal Anda:

### 1. Clone Repository

```bash
git clone
cd gym-membership
```

### 2. Install Depedency

```bash
composer install
```

### 3. Konfigurasi Environment File

Salin file .env.example menjadi .env:

```bash
cp .env.example .env
```

Buka file .env dan sesuaikan pengaturan database Anda:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gym_test_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Jalankan Database Migration & Seeder

Perintah ini akan membuat seluruh tabel yang diperlukan sekaligus mengisi data paket membership serta 2 akun staff default (Admin & Staff Biasa):

```bash
php artisan migrate --seed
```

### 6. Jalankan Server Lokal

```bash
php artisan serve
```

Akun untuk Pengujian (Credentials)
Gunakan akun di bawah ini untuk menguji perbedaan hak akses (Authorization):

A. Akun Admin (Full Akses)
Email: admin@gym.com

Password: password123

Fitur khusus: Dapat melakukan CRUD Member, menekan tombol Run Billing Engine, mencatat Pembayaran Manual, dan melakukan Suspended Massive.

B. Akun Staff Biasa (Akses Terbatas)
Email: staff@gym.com

Password: password123

Fitur: Hanya dapat melihat daftar member, profil detail member, serta daftar invoice (Read-Only). Button aksi modifikasi data otomatis disembunyikan.
