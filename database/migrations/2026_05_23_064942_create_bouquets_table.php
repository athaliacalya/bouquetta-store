<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bouquets', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->json('flower_ids');
            $table->string('recipient')->nullable();
            $table->string('sender')->nullable();
            $table->text('message')->nullable();
            $table->integer('total_price')->default(0);
            $table->enum('status', ['draft', 'pending', 'confirmed', 'delivered', 'cancelled'])->default('draft');
            $table->string('ip_address')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('bouquets'); }
};