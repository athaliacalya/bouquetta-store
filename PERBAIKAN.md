# Bouquetta – Catatan Perbaikan & Setup MySQL

## Bug yang Diperbaiki

### 1. ✅ Login → "Akun Dinonaktifkan"
- Kolom `role`, `is_active`, `phone`, `address` ditambahkan ke migrasi `users`
- `User` model ditulis ulang dengan `$fillable` array standar (mengganti PHP attribute lama)
- `AuthController` diperbaiki agar hanya blokir login jika `is_active` **eksplisit = 0**
- `register()` sekarang selalu menyertakan `is_active => true`

### 2. ✅ Bunga Tidak Muncul di Builder
- Migrasi `flowers` ditambah kolom `image_path`
- `FlowerSeeder` diperbarui dengan 10 bunga sesuai file `.webp` yang tersedia
- `Flower` model ditambah accessor `image_url`
- `home.blade.php` diubah tampilkan gambar `.webp` sungguhan (bukan emoji)

### 3. ✅ Tidak Bisa Tambah ke Keranjang
- Semua nama file model, controller, middleware dikoreksi (case-sensitive Linux):
  - `Cartitem.php` → `CartItem.php`
  - `Authcontroller.php` → `AuthController.php`
  - `Cartcontroller.php` → `CartController.php`
  - `Checkoutcontroller.php` → `CheckoutController.php`
  - `Adminmiddleware.php` → `AdminMiddleware.php`
  - Dan semua admin controller

### 4. ✅ Perbaikan Lainnya
- `Order` & `Bouquet` model: field `fillable` dilengkapi
- Cart view tampilkan gambar `.webp` bunga yang dipilih
- Preview bouquet builder tampilkan gambar `.webp`
- `.env` dikonfigurasi untuk MySQL

---

## Setup MySQL

### Langkah 1 – Buat database
```sql
-- Di MySQL / phpMyAdmin:
CREATE DATABASE bouquetta CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
Atau via terminal:
```bash
mysql -u root -p < database/setup_mysql.sql
```

### Langkah 2 – Konfigurasi .env
Edit file `.env`, sesuaikan bagian database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bouquetta
DB_USERNAME=root
DB_PASSWORD=password_mysql_kamu
```

### Langkah 3 – Install dependensi
```bash
composer install
npm install
```

### Langkah 4 – Generate app key (jika belum ada)
```bash
php artisan key:generate
```

### Langkah 5 – Jalankan migrasi & seeder
```bash
php artisan migrate
php artisan db:seed
```

### Langkah 6 – Build assets
```bash
npm run build
# atau untuk development:
npm run dev
```

### Langkah 7 – Jalankan server
```bash
php artisan serve
```
Buka: http://localhost:8000

---

## Akun Default (setelah seeder)

| Role     | Email               | Password  |
|----------|---------------------|-----------|
| Admin    | admin@bouquetta.id  | admin123  |
| Customer | demo@bouquetta.id   | demo123   |

---

## Struktur Gambar Bunga
File `.webp` tersimpan di `public/images/flowers/`:

| Slug        | File                    |
|-------------|-------------------------|
| anemone     | anemonen.webp           |
| carnation   | carnationn.webp         |
| daisy       | daisyn.webp             |
| rose        | rosen.webp              |
| sunflower   | sunflowern.webp         |
| tulip       | tulipn.webp             |
| orchid      | orchidn.webp            |
| peony       | peonyn.webp             |
| lily        | lilyns.webp             |
| ranunculus  | ranunculusn.webp        |
