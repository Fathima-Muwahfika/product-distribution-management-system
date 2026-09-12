<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->unique();
            $table->string('name');
            $table->string('category');
            $table->integer('carton_qty');
            $table->decimal('cost_price', 10, 2);
            $table->decimal('mrp', 10, 2);
            $table->integer('stock_qty')->default(0);
            $table->integer('min_stock_level')->default(10);
            $table->enum('source', ['Local', 'Import'])->default('Local');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
