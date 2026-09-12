<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Each row here is one "batch" of stock added to a product at a
     * specific cost price / MRP. A product can have many batches over
     * time (e.g. bought at Rs.500 in January, then Rs.550 in March) —
     * the product itself keeps ONE code/name, but its stock is tracked
     * batch by batch here so old stock (old price) and new stock (new
     * price) can be shown separately.
     */
    public function up(): void
    {
        Schema::create('stock_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->decimal('cost_price', 10, 2);
            $table->decimal('mrp', 10, 2);
            $table->integer('quantity');         // qty originally added in this batch
            $table->integer('remaining_qty');    // qty left from this batch
            $table->string('source')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });

        $now = now();
        $products = \DB::table('products')->get();
        foreach ($products as $product) {
            \DB::table('stock_batches')->insert([
                'product_id'    => $product->id,
                'cost_price'    => $product->cost_price,
                'mrp'           => $product->mrp,
                'quantity'      => $product->stock_qty,
                'remaining_qty' => $product->stock_qty,
                'source'        => 'Opening Stock',
                'notes'         => null,
                'user_id'       => null,
                'created_at'    => $product->created_at ?? $now,
                'updated_at'    => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_batches');
    }
};