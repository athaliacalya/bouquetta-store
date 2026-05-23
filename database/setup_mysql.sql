-- ============================================================
-- Bouquetta - MySQL Setup Script
-- Jalankan: mysql -u root -p < database/setup_mysql.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS bouquetta CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bouquetta;

-- ============================================================
-- Setelah menjalankan file ini, jalankan:
--   php artisan migrate
--   php artisan db:seed
-- ============================================================
