<p align="center">
  <img src="https://laravel.com/img/logomark.min.svg" width="120" alt="Bouquetta Logo">
</p>

<h1 align="center">Bouquetta</h1>

<p align="center">
Website Penjualan Buket Bunga Berbasis Laravel
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10-red?style=flat-square">
  <img src="https://img.shields.io/badge/PHP-8+-blue?style=flat-square">
  <img src="https://img.shields.io/badge/MySQL-Database-orange?style=flat-square">
  <img src="https://img.shields.io/badge/Status-Active-success?style=flat-square">
</p>

---

# Tentang Project

**Bouquetta** adalah website e-commerce sederhana untuk penjualan buket bunga secara online.  
Project ini dibuat menggunakan framework **Laravel** dengan database **MySQL**.

Website ini memiliki fitur:
- Manajemen produk buket bunga
- Sistem login & register user
- Keranjang belanja
- Checkout pemesanan
- Dashboard admin
- CRUD data produk

Project ini dibuat untuk pembelajaran dan pengembangan website berbasis Laravel.

---

# Screenshoot Halaman

## Halaman Beranda
![Beranda](assets/images/beranda-new.png)

---

## Halaman Login
![Login](assets/images/login.png)

---

## Halaman Keranjang
![Keranjang](assets/images/keranjangbelanja.png)

---

## Halaman Checkout
![Checkout](assets/images/checkout.png)

---

## Dashboard Admin
![Dashboard](assets/images/dashboard.png)

---

# Struktur Database

Database pada project **Bouquetta** terdiri dari beberapa tabel berikut:

| No | Nama Tabel | Fungsi |
|----|-------------|---------|
| 1 | bouquets | Menyimpan data produk buket |
| 2 | bouquet_flowers | Relasi antara buket dan bunga |
| 3 | flowers | Menyimpan data bunga |
| 4 | cart_items | Menyimpan data keranjang belanja user |
| 5 | orders | Menyimpan data pesanan customer |
| 6 | users | Menyimpan data akun pengguna |
| 7 | subscribers | Menyimpan data subscriber |
| 8 | sessions | Menyimpan session login |
| 9 | migrations | Riwayat migrasi database |
| 10 | cache | Penyimpanan cache aplikasi |
| 11 | cache_locks | Data lock cache |
| 12 | jobs | Queue jobs Laravel |
| 13 | job_batches | Batch queue jobs |
| 14 | failed_jobs | Penyimpanan job gagal |

---

# Fitur Utama

- Login & Register
- CRUD Produk Buket
- Sistem Checkout
- Keranjang Belanja
- Dashboard Admin
- Manajemen Database

---

# Cara Instalasi

```bash
git clone https://github.com/athaliacalya/bouquetta.git
cd bouquetta

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate

php artisan serve