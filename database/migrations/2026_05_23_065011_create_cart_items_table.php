<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 100);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name');
            $table->json('flower_ids');
            $table->text('personal_message')->nullable();
            $table->integer('price');
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('cart_items'); }
};