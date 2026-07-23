<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->string('slug')->unique();
            $table->string('category'); // Đồng hồ nam / nữ / thể thao / thông minh / cao cấp
            $table->decimal('price', 15, 2);
            $table->decimal('original_price', 15, 2)->nullable();
            $table->text('description')->nullable();
            $table->text('features')->nullable();       // JSON array
            $table->text('specifications')->nullable(); // JSON object
            $table->string('image')->default('products/default.jpg'); // Tên file ảnh
            $table->integer('rating_total')->default(0);
            $table->integer('rating_count')->default(0);
            $table->integer('stock')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
