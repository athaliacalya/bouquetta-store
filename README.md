<p align="center">
  <img src="https://laravel.com/img/logomark.min.svg" width="120" alt="Bouquettaku Logo">
</p>

<h1 align="center">Bouquetta 🌸</h1>

<p align="center">
Website penjualan buket bunga berbasis Laravel
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10-red?style=flat-square">
  <img src="https://img.shields.io/badge/PHP-8+-blue?style=flat-square">
  <img src="https://img.shields.io/badge/Status-Active-success?style=flat-square">
</p>

---

## 🌷 Tentang Project
**Bouquetta** adalah website e-commerce sederhana untuk menjual berbagai jenis buket bunga.  
Project ini dibuat menggunakan Laravel sebagai backend framework.

---

## ✨ Fitur
- 🔐 Login & Register user
- 🛍️ Manajemen produk buket
- 🧾 Sistem checkout
- 📦 Dashboard admin
- 🗂️ CRUD data produk

---

## 🛠️ Teknologi
- Laravel
- PHP
- MySQL
- Bootstrap / Tailwind

---

## 🚀 Cara Instalasi

```bash
git clone https://github.com/athaliacalya/bouquetta.git
cd bouquetta
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve