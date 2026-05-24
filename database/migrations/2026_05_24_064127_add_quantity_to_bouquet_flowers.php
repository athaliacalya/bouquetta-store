<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Buat tabel bouquet_flowers jika belum ada
        if (!Schema::hasTable('bouquet_flowers')) {
            Schema::create('bouquet_flowers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('bouquet_id')->constrained()->onDelete('cascade');
                $table->foreignId('flower_id')->constrained()->onDelete('cascade');
                $table->unsignedInteger('quantity')->default(1);
                $table->timestamps();
            });
        } else {
            // Jika tabel sudah ada, hanya tambah kolom quantity
            Schema::table('bouquet_flowers', function (Blueprint $table) {
                if (!Schema::hasColumn('bouquet_flowers', 'quantity')) {
                    $table->unsignedInteger('quantity')->default(1)->after('flower_id');
                }
            });
        }

        // Tambah kolom total_stems ke tabel bouquets
        if (Schema::hasTable('bouquets')) {
            Schema::table('bouquets', function (Blueprint $table) {
                if (!Schema::hasColumn('bouquets', 'total_stems')) {
                    $table->unsignedInteger('total_stems')->default(0)->after('total_price');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('bouquet_flowers')) {
            Schema::table('bouquet_flowers', function (Blueprint $table) {
                if (Schema::hasColumn('bouquet_flowers', 'quantity')) {
                    $table->dropColumn('quantity');
                }
            });
        }

        if (Schema::hasTable('bouquets')) {
            Schema::table('bouquets', function (Blueprint $table) {
                if (Schema::hasColumn('bouquets', 'total_stems')) {
                    $table->dropColumn('total_stems');
                }
            });
        }
    }
};